<style>
hr{
  border: 2px solid green;
  border-radius: 5px;
}
#backbutton{
  margin-left:2%;
}


</style>
<div class="row ">
  <div class="col">
    <div class="card ">
      <div class="card-header bg-green">
        <div class="col text-center">
          <h5>
              <b> Welfare Status Review </b>
            </h5>
			</div>
		
      </div><br>	  
        <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
        <div class="card-body table-responsive p-0">
          <table id="example1" class="table table-hover table-striped table-bordered">
          <button  id="backbutton" class="btn btn-info btn-md mb-3" onclick="back();" style="color:black;">Back</button>

            <thead> <tbody>		   	
            @foreach($welfareStatusReview as $rv)
			
              <tr class="text-nowrap">
                <th>Wefare NoteId</th>     <td> {{($rv->id)}}</td>    </tr>              
              <tr>  
                <th>Topic</th>              <td> {{$rv->topic}} </td>  </tr>
			        <tr>   
                <th>Justification</th>      <td> {!! nl2br($rv->justification) !!} </td>  </tr>                                  
			        <tr>   
                <th>Status</th>             <td> {{$rv->status}} </td> </tr>
			        <tr> 
                <th style="border-bottom:4px solid black;">Action</th> 
                <td  style="border-bottom:4px solid black;">

        <form method="POST" action="/cancelWelfare" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf         
        <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">        
        <input type="hidden" name="cancelled" id="cancelled" value="Yes">

        @if($rv->status == 'Applied')
        <button type="submit" name="id" id="id" onclick="return confirm('Do you want to cancel?');" value="{{$rv->id}}" class="btn btn-outline-danger text-dark"> 
        Cancel </button>	
        @elseif($rv->status == 'Member1Recommended' || $rv->status == 'Member2Recommended' || $rv->status == 'ChairpersonRecommended')
        <p class="btn btn-outline-success">Progress</p>
        @endif
		    
      </form> 
    </td> 	                 
              
  </tr>
		
</thead>          
            
  @endforeach
	  

        </tbody>
      </table>  
    <div class="float-right"> {{$welfareStatusReview->links()}} </div>
    <div>        
      </div>
      </div>
    </div>
    <script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>

    <script src="{{asset('/admin-lte/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('/admin-lte/plugins/jquery-validation/additional-methods.min.js')}}"></script>
    <!-- DataTables -->
    <script src="{{URL::asset('/admin-lte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <!-- Script for export file from datatable -->
    <script src="{{asset('/admin-lte/datatables/nima.js')}}"></script>
    <script src="{{asset('/admin-lte/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/admin-lte/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('/admin-lte/datatables/buttons.html5.min.js')}}"></script>
    <script src="{{asset('/admin-lte/datatables/buttons.print.min.js')}}"></script>
    <!-- <script src="{{asset('/admin-lte/datatables/buttons.flash.min.js')}}"></script> -->
    <script src="{{asset('/admin-lte/datatables/jszip.min.js')}}"></script>
    <!-- <script src="{{asset('/admin-lte/datatables/pdfmake.min.js')}}"></script> -->
    <script src="{{asset('/admin-lte/datatables/vfs_fonts.js')}}"></script>
    <!-- checkin form -->
    <script>
    $(function() {
      $("#example1").DataTable({
        "dom": 'Bfrtip',
        "responsive": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "paging": true,
        "retrieve":true,
        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5']
      });
    });
    </script>

<script>
  
function back()
{
  $.get('/getView?v=welfare_request', function(data) {
				$('#contentpage').empty();
				$('#contentpage').append(data.html);
			});
} 
</script>