<style>
    
a {
    color: black !important;
    text-decoration: none;
}

.btn-primary {
    color: #fff !important;
    background-color: #007bff;
    border-color: #007bff;
}
.success {
    color: #fff !important;
    background-color: #28a745;
    border-color: #28a745;
}

</style>



<link href="{{asset('css/bose.css')}}" rel="stylesheet">
<!-- called in bose.css -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"> -->

  
<div class="container">
    <a class="btn success" href="javascript:void(0)" id="manageWfBank">Add new transaction&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"> </i></a>
    
    <div class=" textfont form-group row col-lg-12"> 
    <label class="col-md-10 col-form-label text-md-right">Balance:</label>
    <div class="col-md-2"> 
            <button class="btn-outline-info" name="balance" id="balance" value="" required readonly>
                                 
					                     @foreach($wfbalance as $wfbalance)
											 <option value="{{$wfbalance->balance}}">{{$wfbalance->balance}}</option>
										@endforeach
</button>  
</div>
    </div>

    
    
    <table class="table table-bordered data-table" style="width:100%">
    @csrf
        <thead>
            <tr>
                <th>No</th>
                <th >Date</th>
                <th >Narration</th>
                <th >Transcation</th>
                <th >Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
   
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">

                   <input type="hidden" name="id" id="wfbank_id">

                    <div class="form-group">
                        <label for="name" class="col-lg-12 col-sm-12 control-label">Date</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="date" class="form-control" id="date" name="date" value=""  required>
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Narration</label>
                        <div class="col-lg-12 col-sm-12">
                            <input type="text" id="narration" name="narration"  placeholder="eg:contribution" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Transcation</label>
                        <div class="col-lg-12 col-sm-12">   
                        <select name="transaction" id="transaction" class="form-control" required> 
							<option value=" ">Select Transcation type</option> 
							<option value="CR">CR</option>
							<option value="DR">DR</option> 
						</select> 
                        <!-- <input type="text" id="transaction" name="transaction"  placeholder="eg: trans" class="form-control" required> -->
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-12 col-sm-12 control-label">Amount</label>
                        <div class="col-lg-12 col-sm-12">                        
                        <input type="number" id="amount" name="amount"  placeholder="eg: 1000" class="form-control" required>
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10 text-center">
                     <button type="submit"  class="btn btn-outline-success" id="wfbankButton" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>                    

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="wfbankModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="wfbankHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="Form" name="Form" class="form-horizontal">
                @csrf
                <input type="hidden"  value="{{ csrf_token() }}">


                   
      
                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
						<button type="button" class="btn btn-outline-danger" data-dismiss="modal">No</button>                    
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>   -->
<script type="text/javascript">
  
    //Loading the contents of the Datatable from here
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('wfbank.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'date', name: 'date'},
            {data: 'narration', name: 'narration'},
            {data: 'transaction', name: 'transaction'},
            {data: 'amount', name: 'amount'},
            {data: 'action', name: 'action', orderable: true, searchable: true},
        ]
    });

    //After Clicking the Add New button it will trigger here
    $('#manageWfBank').click(function () {
        $('#wfbankButton').val("create-room");
        $('#wfbank_id').val('');
        $('#Form').trigger("reset");
        $('#modelHeading').html("Add new transaction ");
        $('#ajaxModel').modal('show');

       
    });

  //  After clicking the edit button it will trigger here
    $('body').on('click', '.edit', function () {
      var wfbank_id = $(this).data('id');
     
      $.get("{{ route('wfbank.index') }}" +'/' + wfbank_id +'/edit', function (data) {
          $('#modelHeading').html("Edit details");
          $('#wfbankButton').val("edit-room");
          $('#ajaxModel').modal('show');
          $('meta[name="csrf-token"]').attr('content'),
          $('#wfbank_id').val(data.id);
          $('#date').val(data.date); //input id,database
          $('#narration').val(data.narration);
          $('#transaction').val(data.transaction);
          $('#amount').val(data.amount);
      })
   });

//   After clicking save changes in Add and Edit it will trigger here

    $('#wfbankButton').click(function (e) {
       
        e.preventDefault();
        $(this).html('Save');

        
    
        $.ajax({
          data: $('#Form').serialize(),
          url: "{{ route('wfbank.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#Form').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
              window.onload = callajaxOnPageLoad(page);
             var alt = document.createElement("div");
             alt.setAttribute("style","position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
             alt.innerHTML = "Data Updated Successfully! ";
             setTimeout(function(){
              alt.parentNode.removeChild(alt);
             },4500);
            document.body.appendChild(alt);  

            $.get('/getView?v=wfbank',function(data){
            $('#contentpage').empty();                          
            $('#contentpage').append(data.html);
            });  
        
            // window.location.href = '/home';
        table.draw();

    
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#wfbankButton').html('Save Changes');
              alert("Cannot leave fields empty");
                
          }
      });
    });
     
</script>

<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
		});
		</script>


