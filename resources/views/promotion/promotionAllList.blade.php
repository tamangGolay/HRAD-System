<!DOCTYPE html>

<html>

<head>


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


</head>

<body>

  

<div class="container-fluid" style="margin-right:20%;width:95%;"> 

    <h5 class="text-center">Filter Promotion List Data</h5>
       
 <div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12 text-center">
        <div class="form-group row col-sm-12 col-md-12">        
            <div class="col-lg-12 col-sm-12 col-md-12 text-center">
                <input type="date" name="promotionDueDate" id="promotionDueDate" class="form-control searchEmail" placeholder="Search ...">                       
            </div>     
        </div>
        <button type="button" name="" id="btnFiterSubmitSearch" class="btn btn-success col-lg-2 mt-3">Filter</button>
        <button type="button" name="promotionDueDate" id="Reset" class="btn btn-success col-lg-2 mt-3">Reset</button>
 
    </div> 
</div> 
</div>
    <br>

    <table class="table table-bordered data-table">

        <thead>

            <tr>
                <th>Sl No</th>
                <th>Emp Id</th>
                <th>Grade</th>
                <th>Basic Pay</th>
                <th>Promotion Due Date</th>
                <th width="100px">Action</th>

            </tr>

        </thead>

        <tbody>

        </tbody>

    </table>

</div>

  

</body>

  

<script type="text/javascript">

  $(function () {

   

    var table = $('.data-table').DataTable({

        processing: true,

        serverSide: true,

        ajax: {

          url: "{{ route('promotionlistall.index') }}",

          data: function (d) {

                d.promotionDueDate = $('.searchEmail').val(),

                d.search = $('input[type="search"]').val()

            }

        },

        columns: [


            {data: 'id', name: 'id'},

            {data: 'empId', name: 'empId'},
            
            {data: 'grade', name: 'grade'},
            
            {data: 'basicPay', name: 'basicPay'},
                        
            {data: 'promotionDueDate', name: 'promotionDueDate'},

            {data: 'action', name: 'action', orderable: false, searchable: false},

        ]

    });

   

    $(".searchEmail").keyup(function(){

        table.draw();

    });


  $('#btnFiterSubmitSearch').click(function(){
        table.draw();
    });



    $('#Reset').click(function(){
        $('#promotionDueDate').val('');
        table.clear().draw();
    });
});

</script>

</html>

