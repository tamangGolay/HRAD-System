
<! DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE = edge">
    <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
    <title> Increment Order </title>
    <! - Bootstrap5 CSS ->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

   <style>
   table, th, td {
  border: 1px solid black;
}
 th, td {
  border-color: #000000;
 
}
div.notesheet {
      position: absolute;
      right: 45;  
    }
    
@media print {
    tr.page-break  { display: block; page-break-before: always; }
}   

   </style>

</head>
<body>

  <div class = "container-fluid mt-4">
        <div class = "row">
            <img src="{{asset('/cd/images/header.png')}}" width="100%" height="100px">
            <br><br><br>
            <div class = "col-md-8">
                <div class="notesheet">{{date('d-m-Y', strtotime($increment1->createdOn))}}</div> 
                <p> BPC/HRAD/HRMD-05/{{$increment1->incrementDate}} / {{$increment1->id}} </p>
            </div>
            <br>
            <div class ="row col-lg-12">
                <div class = "col-md-12 col-lg-12">
                    <p>{{$headDesignation->designation}}</p>
                    <p>{{$increment1->longOfficeName}}</p>
                    <p>{{$increment1->officeAddress}}</p>
                </div>
            </div>
            <br>
            <div class = "row col-lg-12">
                <div class = "col-md-12 col-lg-12">
                    <p> <strong> Subject:</strong> <u>Increment Order</u></p>
                </div>
            </div>
            <br>
            <div class = "row col-lg-12">
                <div class = "col-md-12 col-lg-12">
                    <p> Dear sir/madam, </p>
                    <br>
                </div>
            </div>
            <div class = "row col-lg-12">
                <div class = "col-md-12 increment1 col-lg-12">
                <p> The final increment payout for the {{$increment1->incrementCycle}} Cycle {{$increment1->incrementDate}} is circulated for kind information and necessary action. </p>
                </div>
            </div>                
            <div class = "row col-lg-12">
                <div class = "col-md-12 col-lg-12">      
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-striped table-bordered gg">
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
                                        
                             @foreach ($increment as $increment) 
                             @if( $loop->first or $loop->iteration  <= 100 )

                                 <tr>
                                <td > {{$loop->iteration}}</td>
                                <td > {{$increment->empName }} ({{$increment->empId}}) </td>
                                <td > {{$increment->designation}}({{$increment->grade}}) </td>
                                <td > {{$increment-> oldBasic}} </td>
                                <td > {{$increment-> increment}} </td>
                                <td > {{$increment-> newBasic}} </td>
                            </tr>
                            @endif
                            
                             @endforeach
                             </tbody>
                        </table>
                    </div> 
                </div> 
            </div>
            <br>
            <div class = "row col-lg-12">
                <div class = "col-md-12 col-lg-12">
                    <p> You are requested to inform the employees under their jurisdiction of the same and also to maintain a copy of the same in their personal file for record. </p> 
                </div>
            </div> 
            <br>
            <div class = "row col-lg-12">
                <div class = "col-md-12 col-lg-12">
                    <p> Yours Sincerely </p>
                </div>
            </div>
            <br>
            <div class = "row col-lg-12">
                <div class = "col-md-12 col-lg-12 increment1">
                   <img src="{{asset('/cd/images/hrsign.gif')}}" width="20%" height="30px">
                   <br>       
                    <p> {{$GmName-> empName }} </p>
                    <p> General Manager-HR </p>
                </div>
            </div> 
            <br><br><br>                
            <div class = "row col-lg-12">
                <div class = "col-md-12 col-lg-12 increment1">
                    <p> Copy to: </p>
                    <p> &nbsp; &nbsp; 1. {{$PiadDesignation->desisnamelong }}, PIAD, HRAD, BPC for further necessary action.  </p>                    
                    <p> &nbsp; &nbsp; 2. HR Admin, {{$officeAddress->officeDetails }} for necessary action. </p>
                    <p> &nbsp; &nbsp; 3. Person Concern</p>
                </div>
            </div>
        </div>
            
       
    <div class = "row">
        <!-- <img src="{{asset('/cd/images/footer.jpg')}}" width="40%" height="100px"> -->
        <img src="{{asset('/cd/images/footer.PNG')}}" width="80%" height="40px">
    </div>
</div>

      
   
    <script src = "https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity = "sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KinkN" crossorigin="anonymous"></script>
   <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <script src = "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"> </script>
   
    </body>
</html>




 
        
