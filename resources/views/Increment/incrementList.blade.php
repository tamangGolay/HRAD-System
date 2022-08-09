<!DOCTYPE html>
<html>
<head>
    <title></title>
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
  
<div class="container">
<h6>Filter Promotion List Data</h6>
   
    <!-- <input type="text" name="filter" class="form-control searchIncrementList" placeholder="Search for filter Only..."> -->
<div class="col-lg-12">
    <input type="number" name="filter" id="filter" class="form-control searchIncrementList col-lg-6" placeholder="Year..">
    <br>
    <input type="number" name="month" id="month" class="form-control searchIncrementListm col-lg-6" placeholder="Month..">

    <br>
   <button type="button" style="width:90px" name="" id="btnFiterSubmitSearch" class="btn btn-success col-lg-4">Filter</button>
   <button type="button" style="width:90px" name="" id="Reset" class="btn btn-success col-lg-4">Reset</button>

</div>

    <br>
   
    <table class="table table-bordered data-table"  id="tabb" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>EmpId</th>
                <th>Basic Pay</th>
                <th>Increment  Year</th>
                <th>Increment  Month</th>
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
          url: "{{ route('incrementlist.index') }}",
          data: function (d) {
                d.filter = $('.searchIncrementList').val(),
                d.month = $('.searchIncrementListm').val(),
                 d.search = $('input[type="search"]').val()
            }
        },
        columns: [
            {data: 'id', 
            name: 'id'
        },

            {data: 'empId', 
            name: 'empId'},

            {data: 'basicPay', 
            name:'users.basicPay'},

            {data: 'incrementDueDate', 
            name: 'incrementDueDate'},


            {data: 'month', 
            name: 'month'},

            {data: 'action', 
             name: 'action', 
                
             orderable: false, searchable: true},
        ]
    });
   
    // $(".searchIncrementList").keyup(function(){
    //     table.draw();
    // });

    $('#btnFiterSubmitSearch').click(function(){
        table.draw();
});

$('#Reset').click(function(){
    $('#filter').val('');
    $('#month').val('');
    table.clear().draw();
});


 

}); 
 
</script>
</html>