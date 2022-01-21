<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css">


    <title>CSV Import!</title>
</head>
<body>


<div class="container">
    <div class="row justify-content-md-center p-5">
        <div class="col-md-auto">
            <h1>CSV Import - Task</h1>
            <form method="POST" enctype="multipart/form-data" id="laravel-ajax-file-upload" action="javascript:void(0)">
                <div class="input-group">

                    <input accept=".csv" type="file" name="file" class="form-control" id="select-file"
                           aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                    <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04">Yükle</button>
                    <span class="text-danger">{{ $errors->first('file') }}</span>
                </div>
            </form>
        </div>

    </div>
    <div class="row justify-content-md-center p-5">
        <div class="col-md-auto" id="result-table" style="display:none">
            <h2 class="text text-success text-center">
                Aşağıdaki kayıtlar eklendi
            </h2>
            <table class="table-striped border-success success-table"   data-pagination="true"  data-search="true">
                <thead>
                <tr>
                    <th data-field="name">
              <span class="text-success">
                Name
              </span>
                    </th>
                    <th data-field="surname">
              <span class="text-success">
                Surname
              </span>
                    </th>
                    <th data-sortable="true" data-field="email">
              <span class="text-success">
                Email
              </span>
                    </th>
                    <th data-field="phone">
              <span class="text-success">
                Phone
              </span>
                    </th>
                    <th data-sortable="true" data-field="employee_id">
              <span class="text-success">
                Employee Id
              </span>
                    </th>
                    <th  data-sortable="true" data-field="point">
              <span class="text-success">
                Points
              </span>
                    </th>
                </tr>
                </thead>
            </table>

            <hr class="p-1">

            <h2 class="text text-danger text-center">
                Veritabanında yer alan eklenmeyen kayıtlar
            </h2>
            <table class="table-striped border-warning warning-table"   data-pagination="true"  data-search="true">
                <thead>
                <tr>
                    <th data-field="name">
              <span class="text-danger">
                Name
              </span>
                    </th>
                    <th data-field="surname">
              <span class="text-danger">
                Surname
              </span>
                    </th>
                    <th data-sortable="true" data-field="email">
              <span  class="text-danger">
                Email
              </span>
                    </th>
                    <th data-field="phone">
              <span class="text-danger">
                Phone
              </span>
                    </th>
                    <th data-sortable="true"  data-field="employee_id">
              <span class="text-danger">
                Employee Id
              </span>
                    </th>
                    <th data-sortable="true"  data-field="point">
              <span class="text-danger">
                Points
              </span>
                    </th>
                </tr>
                </thead>
            </table>


            <hr class="p-1">

            <h2 class="text text-danger text-center">
                CSV de yer alan eklenmeyen kayıtlar
            </h2>
            <table class="table-striped border-warning duplicate-table"   data-pagination="true"  data-search="true">
                <thead>
                <tr>
                    <th data-field="name">
              <span class="text-danger">
                Name
              </span>
                    </th>
                    <th data-field="surname">
              <span class="text-danger">
                Surname
              </span>
                    </th>
                    <th data-sortable="true" data-field="email">
              <span  class="text-danger">
                Email
              </span>
                    </th>
                    <th data-field="phone">
              <span class="text-danger">
                Phone
              </span>
                    </th>
                    <th data-sortable="true"  data-field="employee_id">
              <span class="text-danger">
                Employee Id
              </span>
                    </th>
                    <th data-sortable="true"  data-field="point">
              <span class="text-danger">
                Points
              </span>
                    </th>
                </tr>
                </thead>
            </table>


        </div>

    </div>

    <div class="row justify-content-md-center p-5">
        <div class="col-md-auto" id="result-table-2" style="display:none">
            <hr class="p-1">
            <h2 class="text text-info text-center">
                Veritabanında Bulunan Tüm Kayıtlar
            </h2>
            <table class="table-striped border-info info-table"   data-pagination="true"  data-search="true">
                <thead>
                <tr>
                    <th data-field="name">
              <span class="text-info">
                Name
              </span>
                    </th>
                    <th data-field="surname">
              <span class="text-info">
                Surname
              </span>
                    </th>
                    <th data-sortable="true"  data-field="email">
              <span class="text-info">
                Email
              </span>
                    </th>
                    <th data-field="phone">
              <span class="text-info">
                Phone
              </span>
                    </th>
                    <th data-sortable="true"  data-field="employee_id">
              <span class="text-info">
                Employee Id
              </span>
                    </th>
                    <th data-sortable="true"  data-field="point">
              <span class="text-info">
                Points
              </span>
                    </th>
                </tr>
                </thead>
            </table>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
<!-- Include the JavaScript file for Bootstrap table -->
<script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.js"></script>


<script type="text/javascript">
    $(document).ready(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#laravel-ajax-file-upload').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ url('upload')}}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    this.reset();

                    $('.success-table').bootstrapTable('destroy');
                    $('.warning-table').bootstrapTable('destroy');
                    $('.info-table').bootstrapTable('destroy');
                    $('.duplicate-table').bootstrapTable('destroy');

                    $('.success-table').bootstrapTable({
                        data: data['imported']
                    });
                    $('.warning-table').bootstrapTable({
                        data: data['duplicated']
                    });
                    $('.info-table').bootstrapTable({
                        data: data['all']
                    });
                    $('.duplicate-table').bootstrapTable({
                        data: data['csv_duplicated']
                    });


                    document.getElementById('result-table').style.display = 'block';
                    document.getElementById('result-table-2').style.display = 'block';
                    alert('Dosya yüklendi');
                    console.log(data);
                },
                error: function (data) {
                    alert('Dosya içeriği okunamadı')
                    console.log(data);
                }
            });
        });
    });

    $("#select-file").change(function(){

    });

</script>
</body>
</html>
