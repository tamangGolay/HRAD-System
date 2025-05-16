
<! DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE = edge">
    <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
    <title> Welfare Report </title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

   <style>
   table, th, td {
    border: 1px solid black;
}

.col1{
   width:80%;
}
.col5{
  width:20%;
}
div.notesheet {
      position: absolute;
      right: 45;  
    }


   </style>
</head>
<body>

    <div class = "container-fluid  mt-4">
        <div class = "row">

        <img src="{{asset('/cd/images/header.png')}}" width="100%" height="100px">
        <br><br><br>
            <div class = "col-md-8">           
            <div class="notesheet">{{ \Carbon\Carbon::parse($welfare->createdOn)->format('Y-m-d') }}</div>
                <h2 style="text-align:center"> Welfare Report </h2>
            </div>

            <div class = "row">
            <div class = "col-md-12">
                <table class = "table">

                    <thead>
                      <tr>
                        <th scope = "col" class="col5">Welfare Id</th>
                        <td class="col1"> {{$welfare->id}} </td>
                      </tr>

                      <tr>
                        <th scope = "col" class="col5">Welfare Topic</th>
                        <td class="col1"> {{$welfare->topic}} </td>
                      </tr>

                      <tr>
                        <th scope = "col" class="col5">Applied By</th>
                        <td class="col1"> {{$userName->empName}} </td>
                      </tr>

                      <tr>
                        <th scope = "col" class="col5">Applied For</th>
                        <td class="col1">
                        {{$userName->empID}}    ({{$userName->empIdName}})
                        <br>
                        <span style="margin-left: 10px;">(For his/her: {{$userName->relationToEmp}})</span>
                        </td>
                      </tr>                  
                   
                    
                    </thead> </table>
                     
            </div>
        </div>
        <br> <br> 
        
        <p> <h5 class="text-center">Justification</h5></p>
        <br>
        <p>{!! nl2br ($welfare-> justification) !!}</p>

        <br> <br>
        
    </div>
        <div class = "row">
            <div class = "col-lg-12">
                <table class="table">
                <thead>
                        <tr>
                            <th colspan="5" class="text-center">Remarks by Committee Member(s)</th>
                        </tr>
                      <tr>
                        <th scope = "col" class="col5"> Reviewer </th>
                        <th scope = "col" class="col5"> Name </th>
                        <th scope = "col" class="col5"> Status </th>                        
                        <th scope = "col" class="col5"> Remarks </th>
                        <th scope = "col" class="col5"> Action Date</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($welfareapprove as $approve)
                        <tr>
                            <td  class="col1"> {{$approve-> modifier}} </td>
                            <td  class="col1"> {{$approve-> empName}} </td>                          
                            <td class="col1"> 
                            {{ $approve->modifierType == 'Member1Recommended' || $approve->modifierType == 'Member2Recommended' ? 'Recommended' : $approve->modifierType }}
                            </td>
                            <td class="col1" > {{$approve-> remarks}} </td>
                            <td class="col1" > {{$approve-> modifiedOn}} </td>                          
                          
                        </tr>
                        @endforeach
                    </tbody>                    
                  </table>
                  <p style="text-align:center"><i>***This is system generated report.***</i></p>
            </div>
        </div>
    </div>
    
    <script src = "https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity = "sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KinkN" crossorigin="anonymous"></script>
   <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <script src = "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"> </script>
   
</body>
</html>




 
        
