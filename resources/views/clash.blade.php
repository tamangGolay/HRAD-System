<!-- Stored in resources/views/pages/dispatch.blade.php -->@extends('layouts.masterstartpage') @section('pagehead')
<!-- c_booking -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
<!-- c_booking -->
<script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<style>
a {
	color: black;
	text-decoration: none;
	/* no underline */
}

.cardbody {
	margin-right: 5%;
	margin-left: 5%;
}

.ta {
	white-space: nowrap;
}


/* Green */

.nimasuccess {
	color: #28a745;
	background-color: transparent;
	background-image: none;
	border-color: #28a745;
}

.nimasuccess:hover {
	background-color: #28a745;
	color: white;
}

.alert {
	text-align: center;
}


/* th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
} */


/* nima */
</style>
<div class="container-fluid mt-0 mb-0">
	<div class="row mt-0 mb-0">
		<div class="col-sm-6"> </div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="/cbook">Book Again</a></p>
				</li>
				<li class="breadcrumb-item">
					<a href="#"></a>
				</li>
			</ol>
		</div>
	</div>
</div>
<!-- /.container-fluid -->@endsection @section('content') @if(session()->has('clash'))
<div class="alert alert-danger"> {{ session()->get('clash') }}
	<br>
	<div class="form-group row">
		<label class="col-md-4 col-form-label text-md-right" for="nameid">&nbsp;&nbsp;&nbsp;Booking Id:</label>
		<div class="col-sm-10 col-md-6 col-lg-4">
			<input type="text" name="name" class="form-control" id="nameid" value="<?php echo$clash[0]->id - 5; ?>" placeholder="Name" readonly> </div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label text-md-right" for="nameid">&nbsp;&nbsp;&nbsp;Already Booked By:</label>
		<div class="col-sm-10 col-md-6 col-lg-4">
			<input type="text" name="name" class="form-control" id="nameid" value="<?php echo$clash[0]->name; ?>" placeholder="Name" readonly> </div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label text-md-right" for="emp_id">&nbsp;&nbsp;&nbsp;Employee Number:</label>
		<div class="col-sm-10 col-md-6 col-lg-4">
			<input type="text" name="emp_id" class="form-control" id="emp_id" value="<?php echo$clash[0]->emp_id; ?>" placeholder="emp_id" readonly required> </div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label text-md-right" for="conference">&nbsp;&nbsp;&nbsp;Meeting Room:</label>
		<div class="col-sm-10 col-md-6 col-lg-4">
			<input type="text" name="conference" class="form-control" value="<?php echo$clash1[0]->Conference_Name;?>" id="conference" placeholder="conference" readonly> </div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label text-md-right" for="start_date">&nbsp;&nbsp;&nbsp;Start Date:</label>
		<div class="col-sm-10 col-md-6 col-lg-4">
			<input type="text" name="start_date" class="form-control" value="<?php echo date(" Y-m-d h:i A ",strtotime($clash[0]->start_date)) ; ?>" id="start_date" placeholder="start" readonly> </div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label text-md-right" for="end_date">&nbsp;&nbsp;&nbsp;End Date:</label>
		<div class="col-sm-10 col-md-6 col-lg-4">
			<input type="text" name="end_date" class="form-control" value="<?php echo
                      
                      
                      date(" Y-m-d h:i A ",strtotime($clash[0]->end_date)); ?>" id="end_date" placeholder="end" readonly> </div>
	</div>
</div> @endif
<!-- <div class="row">  

   
    <div class="col">
      <div class="card">
       <div class="card-header small-box bg-green d-flex justify-content-center"> <div class="card-title"><h4>Booked Conference Details</h4> </div></div>
      <div class="card-body table-responsive">  
  <table id="example1" class="table table-hover table-striped cell-border" >
                <thead >
                 <tr style="border:1px solid">  
                 
                  <th>Name</th>
                  <th>Contact Number</th>
                  <th>Conference Name</th>
                  <th>Meeting Name</th>
                  <th class="ta">Start Date</th>
                  <th></th>
                  <th class="ta">End Date</th>
                  
                 </tr>
                </thead>


             @foreach($c_book as $fv) 
                  <tr>

                   
                    <td>
                     {{$fv->name}}
                    </td>
                    <td>
                     {{$fv->contact_number}}
                    </td>

                    <td>
                     {{$fv->Conference_Name}}
                    </td>

                     <td>
                     {{$fv->meeting_name}}
                    </td>
                    <td>
                     {{$fv->start_date}}  
                    </td>
                    <td> to </td>

                    <td>
                     {{$fv->end_date}}
                    </td>
                   
                  </tr>
                  @endforeach
                 </tbody>
                 </table>

                 </div>
                 </div>

                 </div>

                 </div>


 
  
 -->@endsection