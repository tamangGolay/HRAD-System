<!-- Stored in resources/views/pages/incoming.blade.php -->@extends('layouts.masterforedit') @section('title') @endsection @section('pagehead')
<style>
a {
	color: black;
	text-decoration: none;
	/* no underline */
}
</style>

<div class="container-fluid mt-0 mb-0">
	<div class="row mt-0 mb-0">
		<div class="col-sm-6">
			<h5 id="contenthead"><strong>Home</strong></h5> </div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item">
					<p id="listlink">
						<a href="#"></a>
					</p>
				</li>
				<li class="breadcrumb-item">
					<a href="#"></a>
				</li>
			</ol>
		</div>
	</div>
</div>
<!-- /.container-fluid -->@endsection @section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header small-box bg-green d-flex justify-content-center">
				<div class="card-title">Edit Records</div>
			</div>
			<div class="container-fluid" id="contentpage">
				<form action="/conferenceedit/<?php $users[0]->id; ?>" method="post">
					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
					<div class="form-group row">
						<label for="dtpickerdemo" class="col-md-4 col-form-label text-md-right">&nbsp;&nbsp;&nbsp;Employee Number:</label>
						<div class="col-sm-10 col-md-6 col-lg-4 input-group date px-4" id="dtpickerdemo">
							<input type="text" class="form-control" value="<?php echo$users[0]->emp_id; ?>" name="emp_id" readonly> <span class="input-group-addon">
                  
                        <span class="glyphicon glyphicon-calendar" ></span> </span>
						</div>
					</div>
					<div class="form-group row">
						<label for="dtpickerdemo" class="col-md-4 col-form-label text-md-right">&nbsp;&nbsp;&nbsp;Name:</label>
						<div class="col-sm-10 col-md-6 col-lg-4 input-group date px-4" id="dtpickerdemo">
							<input type="text" class="form-control" value="<?php echo$users[0]->name; ?>" name="name" readonly> <span class="input-group-addon">
                  
                        <span class="glyphicon glyphicon-calendar" ></span> </span>
						</div>
					</div>
					<div class="form-group row">
						<label for="dtpickerdemo" class="col-md-4 col-form-label t
						
						ext-md-right">&nb
							
						sp;&nbsp;&nbsp;Meeting Room:</label>
						<div class="col-sm-10 col-md-6 col-lg-4 input-group date px-4" id="dtpickerdemo">
							<input type="text" class="form-control" value="<?php echo$conference[0]->Conference_Name;?>" name="conference_name" readonly> <span class="input-group-addon">
                  
                        <span class="glyphicon glyphicon-calendar" ></span> </span>
						</div>
					</div>
					<div class="form-group row">
						<label for="dtpickerdemo" class="col-md-4 col-form-label text-md-right">&nbsp;&nbsp;&nbsp;Start date and time:</label>
						<div class="col-sm-10 col-md-6 col-lg-4 input-group date px-4" id="dtpickerdemo">
							<input type="text" class="form-control" value="<?php echo$users[0]->start_date; ?>" name="start_date" placeholder="mm/dd/yyyy" /> <span class="input-group-addon">
                  
                        <span class="glyphicon glyphicon-calendar" ></span> </span>
						</div>
					</div>
					<div class="form-group row">
						<label for="dtpickerdemo2" class="col-md-4 col-form-label text-md-right"> &nbsp;&nbsp;&nbsp;End date and time:</label>
						<div class="col-sm-10 col-md-6 col-lg-4 input-group date px-4" id='dtpickerdemo2'>
							<input type="text" class="form-control" value="<?php echo$users[0]->end_date; ?>" name="end_date" /> <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span> </span>
						</div>
					</div>
					<div class="form-group row mb-0">
						<div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12s ">
							<button type="submit" id="update" class="btn btn-outline-success btn-lg">Update</button>
						</div>
					</div>
			</div>
		</div>
		</form>
	</div>
</div>
</div> @endsection