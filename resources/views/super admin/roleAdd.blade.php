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
					
                        <b>Add Role</b>
                     </div>
				<div class="card-body">
				<form method="POST" action="role" > @csrf
					<input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
					
					<div class="form-group row">
						<label for="role" class="col-md-4 col-form-label text-md-right">New Role:</label>
						<div class="col-md-4">
							<div class="input-group">
								<input id="role" type="text" class="form-control" name="role" required >
								<div class="input-group-append"></div>
							</div>
						</div>
					</div>
					<div class="form-group row mb-0">
						<div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12 ">
							<button type="submit" class="btn btn-outline-success btn-save" >Add Role</button>
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	document.getElementById('contenthead').innerHTML = '<strong></strong>';
});


</script>