<style>
.chgpsswd2{
    font-family: "Times New Roman", Times, serif;
    font-size: 25px;
  }
  .textfont{
	font-family: Arial, Helvetica, sans-serif; 
	font-size: 15px;
  }
</style>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="chgpsswd2 card-header bg-green text-center">
					
                        <b>Tick Forms to grant permission:</b>
</b>
                     </div>
				<div class="card-body">
				<form method="POST" action="{{ route('roleform') }}"> @csrf
			<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
			
				<div class="card-body">
					<div class="form-group row">
						<label class="col-md-1 offset-md-2" for="roleid">Role:</label>
						<select class="col-sm-5" name="role" id="roleid"> @foreach($roles as $role)
							<option value="{{$role->id}}">{{$role->name}}</option> @endforeach </select>
					</div>
					<div class="form-group row">
						<label class="col-md-1 offset-md-2" for="formid">Forms:</label>
						<div class="col-sm-5">
							<!-- checkbox -->
							<div class="form-group clearfix border" id="formlistid"> @foreach($formlist as $fl)
								<div class="row">
									<div class="icheck-danger d-inline ml-2"> @if(isset($fl->formid))
										<input value="{{$fl->id}}" name="fcheck[]" class="form-control" type="checkbox" id="checkboxPrimary{{$loop->index}}" checked> @else
										<input value="{{$fl->id}}" name="fcheck[]" class="form-control" type="checkbox" id="checkboxPrimary{{$loop->index}}"> @endif
										<label for="checkboxPrimary{{$loop->index}}" class="text-muted"> {{$fl->description}} </label>
									</div>
								</div> @endforeach </div>
						</div>
					</div>
					<div class="form-group row mb-0">
						<div class="col-md-4 offset-md-5">
							<button type="submit" id="bsubmit" class="btn btn-success btn-save">Save</button>
						</div>
					</div>
				</div>
			</div>
		</form>
				</div>
			</div>
		</div>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<script type="text/javascript">
$(document).ready(function() {
	document.getElementById('contenthead').innerHTML = '<strong></strong>';
	$("#roleid").on('change', function(e) {
		var id = e.target.value;
		var csrftoken = document.getElementById('tokenid').value;
		$.get('/getValues?source=forms&info=' + id + '&token=' + csrftoken, function(data) {
			// $('#formlistid').empty();               
			$.each(data, function(index, fm) {
				var idk = 'checkboxPrimary' + index;
				if(fm.formid != null) {
					document.getElementById(idk).setAttribute('checked', '');
				} else {
					document.getElementById(idk).removeAttribute('checked');
				}
			})
		});
	});
});
</script>


</script>

<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
		});
		</script>