<!-- <link href="{{asset('css/bose.css')}}" rel="stylesheet">  -->
		<!-- called in bose.css -->

<!-- Stored in resources/views/pages/incoming.blade.php -->@extends('layouts.master') @section('title') {{$title}} @endsection @section('pagehead')
<style>
	a {
    text-decoration: none;
    color: black;
}

/* @media only screen and (min-width: 750px) {



} */

.nimacard {
	height: 5%;
	margin-left: 4%;
	
}
.nav-link {
	color:black;
}

.small-box:hover {
	/* background-color: lightgreen; */
	transform: scale(1.1);
}

.small-box {
	transition: transform .2s;
	background-color:#F3F3F1;
	/* Animation */
}

.ta {
	white-space: nowrap;
}

.prop {
	white-space: nowrap;
}

#example1 {
	border-collapse: collapse;
	width: 95%;
	margin-left: 2%;
	border: 1px solid #ddd;
}

#contentpage {
	margin-left: 0%;
	margin-right: 0%;
}
.ofalldiv{
	background-color: white;
}

</style>

@if(count($errors) > 0)
    <div class="alert alert-danger">
     Upload Validation Error<br><br>
     <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
     </ul>
    </div>
   @endif

@if(session()->has('guesthouseself'))
<div style="font-size:20px" class="alert alert-success text-center"> {{ session()->get('guesthouseself') }} </div> @endif
@if(session()->has('cancel'))
<div style="font-size:20px" class="alert alert-danger text-center"> {{ session()->get('cancel') }} </div> @endif

 @if(session()->has('error'))
<div style="font-size:20px" class="alert alert-danger text-center"> {{ session()->get('error') }} </div> @endif
@if(session()->has('guesthouse'))
<div style="font-size:20px" class="alert alert-danger text-center"> {{ session()->get('guesthouse') }} </div> @endif
 @if(session()->has('success'))
<div style="font-size:20px" class="alert alert-success text-center" > {{ session()->get('success') }} </div> @endif
@if(session()->has('roleadd'))
<div style="font-size:20px" class="alert alert-success text-center" > {{ session()->get('roleadd') }} </div> @endif
@if(session()->has('adduser'))
<div style="font-size:20px" class="alert alert-success text-center" > {{ session()->get('adduser') }} </div> @endif


@if(session()->has('successmsg'))
<div style="font-size:20px" class="alert alert-success text-center " data-dismiss="alert" > {{ session()->get('successmsg') }} </div> @endif

<div class="container-fluid mt-0 mb-0 ">
	<div class="row mt-0 mb-0">
		<div class="col-sm-6">
			<h5 id="contenthead"> <a href="/home"><strong><i class="fa fa-home" aria-hidden="true">&nbsp;</i></strong></a></h5> </div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item">
					<p id="listlink">
						<a href="#"></a>
					</p>
				</li>
				 <!-- <li class="breadcrumb-item">
				<p id="linkid">
						<a href="#"></a>
				</p>	
				</li> -->
			</ol>
		</div>
	</div>
</div>
<!-- /.container-fluid -->@endsection @section('content')
<div class="container-fluid" id="contentpage">
	<!-- Main content -->
	<input type="hidden" name="page" id="pageid" value="{{ session()->get('page')}}">
	<ul class="nav nav-treeview nimacard"> @foreach($forms as $form)
		<li class="small-box p-3 border border-dark col-lg-3  col-md-4">
			<a href="/" onclick="return false;" data-value="{{$form->forms}}" class="nav-link text-dark sonamcard"> <i class="text-center"><h5><i class="fas {{$form->icon}}"></h5></i></i>&nbsp;&nbsp;
				<p class="text-center">{{$form->description}}</p>
			</a>
		</li> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;@endforeach </ul>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<script type="text/javascript">
	
	$(document).ready(function() {
		$("#dialog").dialog({
			autoOpen: false
		});
	});
	//to load page / previous ajax call.
	var page = document.getElementById('pageid').value;
	if(page.length > 0) {
		window.onload = callajaxOnPageLoad(page);
		var alt = document.createElement("div");
		alt.setAttribute("style", "position:absolute;top:20%;left:50%;background-color:#BFC9CA;border-color:#34495E;");
		setTimeout(function() {
			alt.parentNode.removeChild(alt);
		}, 3000);
		document.body.appendChild(alt);
	}

	function callajaxOnPageLoad(page) {
		$.get('/getView?v=' + page, function(data) {
			$('#contentpage').empty();
			$('#contentpage').append(data.html);
		});
	}


$(document).ready(function() {
	$("a").on('click', function(e) {
		//console.log(e);
		// var id = e.target.value;
		var id = $(this).data('value');
		if(id != 'none') {
			$.get('/getView?v=' + id, function(data) {
				document.getElementById('listlink').innerHTML = ''; // FR-register and deployment link(disappear)
				$('#contentpage').empty();
				$('#contentpage').append(data.html);
			});
		}
	});
})

	$('div.alert').delay(6500).slideUp(300);// Session message  display time
	
	</script> @endsection
	<!-- changes -->