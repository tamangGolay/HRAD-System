<! DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE = edge">
    <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
    <title> Laravel 8 PDF </title>
    <! - Bootstrap5 CSS ->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

   <style>
   table, th, td {
  border: 1px solid black;
}
 th, td {
  border-color: #96D4D4;
 
}
.col1{
   width:100px;
}
.col2{
   width:500px;;
}

   </style>
</head>
<body>
    <div class = "container mt-4">
        <div class = "row">
            <div class = "col-md-8">
                <h2> NoteSheet </h2>
            </div>

            <div class = "row">
            <div class = "col-md-12">
                <table class = "table">
                    <caption> NoteSheet </caption>
                    <thead>
                      <tr>
                        <th scope = "col" class="col1"> Sl no </th>
                        <td class="col1"> {{$notesheet->id}} </td>

                      </tr>

                      <tr>
                        <th scope = "col" class="col1"> Name </th>
                        <td class="col1"> {{$notesheet->employee}} </td>

                      </tr>
                      <tr>
                        <th scope = "col" class="col1"> Justification </th>
                        <td class="col1"> {{$notesheet-> justification}} </td>

                      </tr>
                      <tr>
                        <th scope = "col" class="col1"> Office </th>
                        <td class="col1"> {{$notesheet-> office}} </td>

                      </tr>
                    </thead>
                    <!-- <tbody>
                        <tr>

                        </tr>
                    </tbody> -->
                  </table>
            </div>
        </div>
    </div>

           
            <!-- <div class = "col-md-4">
                <div class = "mb-4 d-flex justify-content-end">
                    <a class="btn btn-primary" href="http://127.0.0.1:8000/product/pdf"> Export to PDF </a>
                </div>
            </div> -->
        </div>
        <div class = "row">
            <div class = "col-md-12">
                <table class = "table">
                    <caption> Remarks </caption>
                    <thead>
                      <tr>
                        <th scope = "col" class="col1"> Reviewer </th>
                        <th scope = "col" class="col1"> Status </th>
                        <th scope = "col" class="col1"> Remarks </th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($notesheetapprove as $approve)
                        <tr>
                            <th  class="col1" scope = "row"> {{$approve-> modifier}} </th>
                            <td class="col1" > {{$approve->modiType}} </td>
                            <td class="col1" > {{$approve-> remarks}} </td>
                          
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
   
    <script src = "https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity = "sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KinkN" crossorigin="anonymous"></script>
   <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <script src = "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"> </script>
   
</body>
</html>