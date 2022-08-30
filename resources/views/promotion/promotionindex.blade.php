
<! DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE = edge">
    <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
    <title> Promomtion Report</title>
    <! - Bootstrap5 CSS ->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

   <style>



a {
        color: black !important;
        text-decoration: none;
        font-family:Cambria;
  font-size:12;
    }
    
    
 
    .alert-success {
      color: #28a745 !important;
        background-color: #28a745 !important;
        border-color: #28a745 !important;
}


 table, th, td {
  border-color: #FFFFFF;
  font-family:Cambria;
  font-size:12;
 
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
   font-family:Cambria;
  font-size:12;
}

div.table2 {
  position: absolute;
  left: 55;
  font-family:Cambria;
  font-size:12;
  font-family:Cambria;
  font-size:12;
  
}
h4{
  text-decoration: underline; 
  font-family:Cambria;
  font-size:12;
}
div{
  font-family:Cambria;
  font-size:12;
}
h6{
  font-family:Cambria;
  font-size:12;

}
</style>
</head>
<body>
@foreach($promotion as $promotion)

    <div class = "container mt-4">
        <div class = "row">
        <img src="{{asset('/cd/images/header.jpg')}}" width="100%" height="100px">
        <br><br><br>


        
            <div class = "col-md-8">
            <div class="notesheet">{{ date('d-m-Y', strtotime($promotion->date)) }}</div> 
                <h6> BPC/HRA/HR-04/{{$year->promotionDate}}/{{$promotion->id}} </h6>
            </div>
<br>
 <div class = "row">
    <div class = "col-md-12">
        <table class = "table" width="93%">      
            <thead>
                <tr>
                    <th scope = "col" class="col1">{{$promotion->empName}}</th>                              
                </tr>
                  <tr>
                      <th scope = "col" class="col1"> {{$promotion->oldDesignation}} </th>            
                  </tr>
                      <tr>
                        <th scope = "col" class="col1">  {{$promotion->officeName}}</th>
                      </tr>
                          <tr>
                              <th scope = "col" class="col1"> {{$promotion->officeAddress}} </th>
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

       
        </div>


<br>
<br>

  <div class = "row">
       <div class = "table2 col-md-6">
            <table width="79%">
                 <h4> Subject:- Promotion Order </h4>
  <br>
  <br> 
                   <thead>
                      <tr>
                        <th scope = "col" class="col1"> Dear {{$promotion->empName}}, </th>
                        
                      </tr>
                    </thead>
 <br>
 
                      <tbody>         
                        <tr>
                            <th  class="col1"> I have the pleasure to inform you that you have been promoted to
                              {{$promotion->newDesignation}} ({{$grade->grade}}) in the {{$promotion->officeDetails}} of the company. 
                              You are promoted with effect from {{$promotion->promotionDate}}. Please accept my hearty congratulations on your promotion.
                          </th>
                        </tr>
<br>
                          <tr>
                            <th>
                              Your basic pay after the promotion shall be Nu  {{$promotion->newBasic}}. 
                           </th>
                            </tr>
<br>
                                  <tr>
                                          <th>
                              Other service conditions remain unchanged.
                                          </th>
                                  </tr>
<br>
<br>
                                        <tr>
                                            <th>
                              Yours sincerely,
                                            </th>
                                        </tr>
<br>
                                        @if($gradeId->newGrade <= 7)
                                        <img src="{{asset('/cd/images/ceosign.png')}}" width="40%" height="50px">
                                        <br>
                                        <h6>{{$ceo->HeadOfOffice}},</h6>
                                        <br>
                                        <h6>{{$ceo->designation}}</h6>
                                        @endif

                                        @if($gradeId->newGrade > 7)
                                        <img src="{{asset('/cd/images/hrsign.jpg')}}" width="40%" height="50px">
                            <br>         <h6>{{$hrGM->HeadOfOffice}}</h6>
                            <br>      <h6>{{$hrGM->designation}}</h6>
                                          @endif

<br>
<br>
                                                <tr>
                                                 <th>
                              Copies to: <br>
                             
                              {{$copy->copies}}

                       
                       
                        <br>Concerned HR Admin.
<br>

                                                      </th>
                           
                        </tr>
                        <img src="{{asset('/cd/images/promofooter.png')}}" width="100%" height="40px">
                    </tbody>
                  </table>

            </div>
        </div>

    </div>
    <div style="page-break-before:always;">

    @endforeach 

   
    <script src = "https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity = "sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KinkN" crossorigin="anonymous"></script>
   <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <script src = "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"> </script>
   
</body>
</html>




 
        
