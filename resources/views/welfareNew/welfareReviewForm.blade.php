<style>
hr{
  border: 2px solid green;
  border-radius: 5px;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
			<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
			<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<div class="row">
  <div class="col">
    <div class="card ">
      <div class="card-header bg-green">
        <div class="col text-center">
          <h5>
             <b>Welfare Review Form </b>
            </h5>
			</div>		
    </div><br>	 
      <form method="POST" action="/recommendWelfare" enctype="multipart/form-data"  accept-charset="UTF-8" > @csrf
        <input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId" >

        <div class="card-body table-responsive p-0">
          <table id="example1" class="table table-hover table-striped table-bordered">
            <!-- <thead>  -->
              <tbody>

            @if($welfareNote)
			      @forelse($welfareNote as $rv)
			
              <tr class="text-nowrap">
                     <th>Welfare NoteId</th>   <td> {{($rv->id)}} </td>                     </tr>
              <tr>   <th>Created By</th>       <td> {{$rv->createdBy}} ({{$rv->empName}}) </td>   </tr>           
              <tr>   <th>Topic</th>            <td> {{$rv->topic}} </td>                    </tr>
              <tr>   <th>EmpId</th>            <td> {{$rv->empID}}( {{$rv->employeeName}}) </td></tr>
              <tr>   <th>For</th>              <td> {{$rv->relationToEmp}} </td></tr>
			        <tr>   <th>Justification</th>    <td> {!! nl2br($rv->justification) !!}</td>  </tr>                            
			        <tr>   <th>Status</th>           
              
              <td> 
              @if ($memberIdentity->memberType == 'Member 2') 
                  @if ($memberName1)
                 Recommended by: {{$memberName1->reviewerName1}}
                  @endif
              @elseif ($memberIdentity->memberType == 'Chairperson')
                  @if ($memberName2)
                  Recommended by: {{$memberName2->reviewerName2}}
                  @endif
              @endif
              </td> 
            </tr>           
             
            <tr><th colspan="2">Action</th></tr>

            <tr><th colspan="2">
                <div class="container">                  
                <div class="row">  
                @if ($memberIdentity && ($memberIdentity->memberType == 'Member 1' || $memberIdentity->memberType == 'Member 2'))            
                  <div class="col">          
                      <form method="POST" action="/recommendWelfare" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf        
                      <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
                      <input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId"> 

                        <input type="hidden" name="status" id="status" value="Recommended">                        
                        <button type="submit" name="id[]" id="id" onclick="return confirm('Do you want to recommend and forward?');" value="{{$rv->id}}" class="btn btn-outline-info text-dark col-lg-4 mb-4 btn-center"> 
                        Recommend
                        </button> 
                        <input type="text"  name="remarks" class="form-control" id="remarks" placeholder="recommend remarks" required>
                      </form>
                    </div>  
                    @endif 
                    <!-- 1 col-->
                    @if ($memberIdentity && $memberIdentity->memberType == 'Chairperson') 
                    <div class="col">          
                      <form method="POST" action="/recommendWelfare" enctype="multipart/form-data" accept-charset="UTF-8"> @csrf        
                      <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
                      <input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId" >

                        <input type="hidden" name="status1" id="status" value="Approved">
                        
                        <button type="submit" name="id[]" id="id" onclick="return confirm('Do you want to Approve the welfare request?');" value="{{$rv->id}}" class="btn btn-outline-info text-dark col-lg-4 mb-4 btn-center"> 
                        Approv
                        </button> 
                        <input type="text"  name="remarks" class="form-control" id="remarks" placeholder="Approve remarks" >
                      </form>
                    </div>   
                  @endif

                  @if ($memberIdentity && ($memberIdentity->memberType == 'Chairperson' || $memberIdentity->memberType == 'Member 1' || $memberIdentity->memberType == 'Member 2')) 
     
                    <div class="col">  
                      <form method="POST" action="/recommendWelfare"  enctype="multipart/form-data" accept-charset="UTF-8"> @csrf  
                        <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">       
                        <input type="hidden" class="form-control" value="{{ Auth::user()->empId }}" name="empId" id="empId" >

                        <input type="hidden" name="status2" id="status" value="Rejected">                        
                        <button type="submit" name="id[]" id="id" onclick="return confirm('Do you want to Reject?');" value="{{$rv->id}}" class="btn btn-outline-danger text-dark col-lg-4 mb-4 btn-center " > 
                        Reject
                        </button>
                        <input type="text"  name="remarks" class="form-control" id="remarks" placeholder=" Reject Remarks" required>
                      </form> </form>
                     </div>
                    @endif
                    </div>
                  </div>       
                </th> </tr> 
              @if ($memberIdentity->memberType != 'Member 1')
              <tr>
                <th style="border-bottom:4px solid black;" colspan="2">
                    <form method="POST" action="/viewRemarks/{{($rv->id)}}"  enctype="multipart/form-data" accept-charset="UTF-8" class="text-center"> @csrf         
                      @csrf
                      <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
                      <input type="submit" value="View Details" class="btn btn-primary text-center col-lg-4">
                  </form>      
                </th>                 
              </tr> 
            @endif

            @if ($memberIdentity->memberType == 'Member 1')
            <tr>
                <th style="border-bottom:4px solid black;" colspan="2"></th>                 
              </tr> 
            @endif

                @empty
                    <tr>
                        <td colspan="6" class="text-center">No data available</td>
                    </tr>
                @endforelse

            @else
                <tr>
                    <td colspan="6" class="text-center">No data available</td>
                </tr>
            @endif

        </tbody>
        <!-- </thead> -->
      </table>	  
      </div>
    </div>
  </div>
<div>

@if($welfareNote && count($welfareNote) > 0)
<div class="modal fade" id="ajaxModel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="modelHeading"></h4> </div>
						<div class="modal-body">
							<form id="Form" name="Form" class="form-horizontal"> @csrf
								<input type="hidden" id="token" value="{{ csrf_token() }}">
                
								<div class="form-group">
									<label class="col-sm-4 col-lg-12" for="justification">{{ __('Welfare NoteId:') }}</label>
									<div class="col-sm-6 col-lg-12">
								<input type="text" value="<?php echo $welfareNote[0]->id;?>" name="id" id="ids" readonly>	
                </div>
                </div>	
                
                <div class="form-group">
									<label class="col-sm-4 col-lg-12" for="justification">{{ __('Justification:') }}</label>
									<div class="col-sm-6 col-lg-12">
									<textarea class="form-control" rows="20"  value="<?php echo $welfareNote[0]->justification; ?>" name="justification" id="justification">
                 </textarea>
									</div>
								</div>

                <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12">
									<button type="submit" class="btn btn-outline-success" id="saveBtn" value="create">Save changes </button>
									<button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>       							</div>
							</form>
						</div>
					</div>
				</div>
</div>
@endif 

<!-- jquery-validation -->
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
			<!-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> -->
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
			<!-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> -->
    <script type="text/javascript">

			$(function() {
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});			
        	$('body').on('click', '.edit', function() {
					var notesheetRM = $(this).data('id');
					$.get("{{ route('welfareEdit.store') }}" + '/' + notesheetRM + '/edit', function(data) {
						$('#modelHeading').html("Edit Welfare Content");
						$('#saveBtn').val("edit-book");
						$('#ajaxModel').modal('show');
						$('#ids').val(data.id);                       //#id is from modal form and data.id is from modal(fillable) database
						$('#justification').val(data.justification);    //#input id and with data(DB field name)						
					})
				});
				$('#saveBtn').click(function(e) {
					e.preventDefault();
					$(this).html('Save');
					$.ajax({
						data: $('#Form').serialize(),
						url: "{{ route('welfareEdit.store') }}",
						type: "POST",
						dataType: 'json',
						success: function(data) {
							$('#Form').trigger("reset");
							$('#ajaxModel').modal('hide');
							//   table.draw();
							window.onload = callajaxOnPageLoad(page);
							var alt = document.createElement("div");
							alt.setAttribute("style", "position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
							alt.innerHTML = "Data Updated Successfully! ";
							setTimeout(function() {
								alt.parentNode.removeChild(alt);
							}, 4500);
							document.body.appendChild(alt);

            $.get('/getView?v=welfareReviewForm',function(data){        
           $('#contentpage').empty();                          
           $('#contentpage').append(data.html);
            });				
							table.draw();
						},
						error: function(data) {
							console.log('Error:', data);
							$('#saveBtn').html('Save Changes');
						}
					});
      		});
      })
      </script>
      <!-- jquery-validation -->
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
			<script src="{{asset('/admin-lte/datatables/jszip.min.js')}}"></script>
			<!-- <script src="{{asset('/admin-lte/datatables/pdfmake.min.js')}}"></script> -->  
			<script src="{{asset('/admin-lte/datatables/vfs_fonts.js')}}"></script>

    <script>
    $(function() {
      // Destroy the DataTable if it's already initialized
    if ($.fn.DataTable.isDataTable('#example1')) {
        $('#example1').DataTable().destroy();
    }
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
        "destroy": true,  // Allows reinitialization datatable
        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5']
      });
    });
    </script>
