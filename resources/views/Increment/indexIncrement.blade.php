
<! DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE = edge">
    <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
    <title> increment Order </title>
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
   width:250px;;
}

div.notesheet {
  position: absolute;
  right: 45;
  width: 100px;
  height: 120px;
}

div.table2 {
  position: absolute;
  left: 55;
  
}

   </style>
</head>
<body>

  <div class = "container-fluid mt-4">

        <div class = "row">
        <img src="{{asset('/cd/images/header.jpg')}}" width="100%" height="100px">
        <br><br><br>

            <br>
            <div class ="row">
                <div class = "col-md-12">

                    <p>{{$increment1->empName}}</p>
                    <p>{{$increment1->longOfficeName}}</p>
                    <p>{{$increment1->officeAddress}}</p>


                </div>
            </div>
            <br>
            <div class = "row">
                <div class = "col-md-12">
                    <p> <strong> Subject:</strong> <u>increment1 Order</u></p>
                </div>
            </div>
            <br>
            <div class = "row">
                <div class = "col-md-12">
                    <p> Dear sir/madam, </p>
                    <br>
                </div>
            </div>
            <div class = "row">
                <div class = "col-md-12 increment1">
                <p> The final increment payout for the {{$increment1->incrementCycle}} Cycle {{$increment1->incrementDate}} is circulated for kind information and necessary action. </p>
                </div>
            </div>
        
            <div class = "row">
            <div class = "col-md-12">
              <div class="card-body table-responsive p-0">
                <table id="table5" class="table table-hover table-striped table-bordered">

                <thead>
                            <tr>
                            <th scope="col">SN</th>
                            <th scope="col">Name(Employee Id)</th>
                            <th scope="col">Designation(Grade)</th>
                            <th scope="col">Old Basic</th>
                            <th scope="col">increment</th>
                            <th scope="col">New Basic</th>
                            </tr>
                        </thead>

                        <tbody>
                        <tr>
                        @foreach ($increment as $increment)

                          <td class="col1"> {{$increment->id}} </td>
                          <td class="col1"> {{$increment->empName }} ({{$increment->empId}}) </td>
                          <td class="col1"> {{$increment->designation}}({{$increment->grade}}) </td>
                           <td class="col1"> {{$increment-> oldBasic}} </td>
                            <td class="col1"> {{$increment-> increment}} </td>
                            <td class="col1"> {{$increment-> newBasic}} </td>
                        </tr>
                        </tbody>
                        @endforeach

                  </table>
                  <br>
                  <div class = "row">
                   <div class = "col-md-12 ">
                    <p> You are requested to inform the employees under their jurisdiction of the same and also to maintain a copy of the same in their personal file for record. </p> </div>
                </div> 
                <br>
                <div class = "row">
                   <div class = "col-md-12 ">
                    <p> Yours Sincerely </p></div>
                </div>
                <br><br>

                <div class = "row">
                   <div class = "col-md-12 increment1">
                    <p> {{$increment1-> empId }} </p>
                    <p> {{$increment1-> empId }} </p>
                    <p> General Manager-HR </p>
                    </div>
                </div> <br><br>
                <br>                <div class = "row">
                   <div class = "col-md-12 increment1">
                    <p> Copy to: </p>
                    <p> &nbsp; &nbsp; 1. {{$increment1-> empId }}, PIAD, HRAD, BPC for further necessary action.  </p>
                    <p> &nbsp; &nbsp; 2. All HR Admin, {{$increment1-> empId }}, {{$increment1-> empId }} for necessary action. (If available </p>
                    </div>
                </div>
            </div>
            </div>
        </div>

    </div>
  </div>
  <div class = "row">
        <!-- <img src="{{asset('/cd/images/footer.jpg')}}" width="40%" height="100px"> -->
        <img src="{{asset('/cd/images/footer.png')}}" width="100%" height="40px">

</div>


      
   
    <script src = "https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity = "sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KinkN" crossorigin="anonymous"></script>
   <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <script src = "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"> </script>
   
</body>
</html>




 
        
