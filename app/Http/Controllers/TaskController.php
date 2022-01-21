<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{

    public $duplicate_arr;
    private function formatToEmail($email)
    {
        $result = filter_var($email, FILTER_SANITIZE_EMAIL);
        $result = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $result);

        return $result;
    }

    private function unique_multidim_array($array, $key)
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            else{
                $this->duplicate_arr[] = $val;
            }
            $i++;
        }

        return $temp_array;
    }


    private function formatToPhone($phone)
    {

        $output = preg_replace('/[^0-9]/', '', $phone);
        $format = ltrim($output, '0');

        return $format;

    }

    private function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }


    public function store(Request $request)
    {
        request()->validate([
            'file' => 'required|max:4096',
        ]);


        if ($request->file('file')) {


            /*
             * Upload kısmı istenirse aktif edilebilir.
             *
            $fileName = pathinfo($request->file->hashName(), PATHINFO_FILENAME);

            $originalname = $fileName.".". $request->file->getClientOriginalExtension();
            $file = $request->file->storeAs('public/task', $originalname);
             */

            $imported = $duplicated = [];
            // csv check
            $mimes = array('application/vnd.ms-excel', 'text/plain', 'text/csv', 'text/tsv');
            if (in_array($request->file('file')->getMimeType(), $mimes)) {
                // CSV dosya içeriğini oku ve kaydet

                $path = $request->file('file')->getRealPath();
                $data = $this->csvToArray($path, ';');

                // Önce dataları formatla
                foreach ($data as $row) {
                    $taskList[] = [
                        'name' => trim($row['name']),
                        'surname' => trim($row['surname']),
                        'email' => $this->formatToEmail($row['email']),
                        'employee_id' => trim($row['employee_id']),
                        'phone' => $this->formatToPhone($row['phone']),
                        'point' => trim($row['point'])
                    ];
                }

                // Datayı unique leştir
                $data = $this->unique_multidim_array($taskList, 'email');
                $data = $this->unique_multidim_array($data, 'phone');
                $data = $this->unique_multidim_array($data, 'employee_id');

                // Veritabanına ekle
                foreach ($data as $task) {
                    /*
                      0 => array:6 [
                        "name" => "Rina"
                        "surname" => "Sweeney"
                        "email" => "urna.Nunc@Integertincidunt.com"
                        "employee_id" => "161711075760"
                        "phone" => "5306300252"
                        "point" => "566"
                      ]
                     */

                    // Task unique değerleri önceden girilmiş mi kontrol et


                    $task_add = Task::firstOrNew([
                        'email' => $task['email'],
                        'phone' => $task['phone'],
                        'employee_id' => $task['employee_id']
                    ], [
                        'name' => $task['name'],
                        'surname' => $task['surname'],
                        'point' => $task['point']
                    ]);


                    if ($task_add->id) {
                        $duplicated[] = $task;
                    } else {
                        $task_add->save();
                        $imported[] = $task;
                    }

                }
                $allTask = Task::all()->toArray();

                return Response()->json([
                    "success" => true,
                    "duplicated" => $duplicated,
                    "csv_duplicated" => $this->duplicate_arr,
                    "imported" => $imported,
                    "all" => $allTask
                ]);

            }

        }

        return Response()->json([
            "success" => false,
            "failed" => "",
            "imported" => "",
            "csv_duplicate" => "",
            "all" => $allTask
        ]);

    }

}
