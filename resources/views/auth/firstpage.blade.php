<meta name="viewport" content="width=device-width,initial-scale=1">
<!DOCTYPE html>

<head>
	<style>
	
@media only screen and (min-device-width: 2000px) {



.Row {
    display: table;
    width: 100%; /*Optional*/
    table-layout: fixed; /*Optional*/
    border-spacing: 10px; /*Optional*/
}

.pointer {
  
  pointer-events: none;
}
.Column {
    display: table-cell;
    /* background-color: red; Optional */
}

.topic{
text-align:center;

}}


</style>

 <link href="{{asset('css/bose.css')}}" rel="stylesheet"> 
 <!-- all css in bose.css -->

   <script src="{{asset('/admin-lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>

	<link href="{{asset('/admin-lte/css/firstpage.css')}}" rel="stylesheet" id="bootstrap-css">

	<script src="{{asset('/admin-lte/jquery/firstpage.min.js')}}"></script>
	<!------ Include the above in your HEAD tag ---------->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
	<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
	<!------ 4 lines  ---------->
</head>


<body>
	<div class="card-header" style="background-color:#28a745;">
		<div class="col d-flex justify-content-center" style="color:white">
			<h3 class="topic"> BPC ཞབས་ཏོག། </h3> </div>
	</div>
	
	<div class="container">
		<div class="Row" style="margin-top: 100px">
			<a href="/cbook">
				<div class="col-md-4 col-lg-4 col-sm-10 Column pointer" >

					<div class="box-part text-center"> 
						<i class="fa fa-group fa-4x" style="color:black" aria-hidden="true"></i>
						<br>
						<br>
						<br>
						<div class="title">
							<a href="/cbook"> <span>
                                    <h4>Conference Booking</h4> 
                                    <button type="button" class="btn btn-outline-success">
                                        <i class="fa fa-sign-in" style="color:black" aria-hidden="true"></i>
                                    </button> 
                                </span> </a>
						</div>
					</div>
				</div>
			</a>
			<a href="/login">
				<div class="col-md-4 col-lg-4 col-sm-10 Column pointer">

					<div class="box-part text-center"> <i class="fa fa-taxi fa-4x" style="color:black" aria-hidden="true"></i>
						<br>
						<br>
						<br>
						<div class="title">
							<a href="/login"> <span>
                                    <h4>Vehicle Booking</h4>
                                    <button type="button" class="btn btn-outline-success">
                                            <i class="fa fa-sign-in" style="color:black" aria-hidden="true"></i>
                                    </button>
                                </span> </a>
						</div>
					</div>
				</div>
			</a>
			<a href="/login">
				<div class="col-md-4 col-lg-4 col-sm-10 Column pointer">
					<div class="box-part text-center"> <i class="fa fa-home fa-4x" style="color:black" aria-hidden="true"></i>
						<br>
						<br>
						<br>
						<div class="title">
							<a href="/login"> <span>
                                    <h4>Transit Camp Booking</h4>
                                    <button type="button" class="btn btn-outline-success">
                                        <i class="fa fa-sign-in" style="color:black" aria-hidden="true"></i>
                                    </button>
                                </span> </a>
						</div>
					</div>
				</div>
			</a>
		</div>
	</div>
	<br>
	<br>
	<br>
	<footer class="text-muted main-footer" style="text:center;background-color:#FFFAFA;">
		<hr>
		<div class="container">
			<p class="text-center">BPC Online System; Bhutan Power Corporation Limited, 2021 </p>
		</div>
	</footer>
</body>