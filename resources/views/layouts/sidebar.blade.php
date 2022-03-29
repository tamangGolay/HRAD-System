<!-- Brand Logo -->
<!-- Sidebar -->@guest @else
<aside class="main-sidebar elevation-4 border-left" id="sidebar" style="background-color:#FFFF;">
	<div>
		<a href="{{url('/home')}}" class="brand-link"> <img src="{{asset('/logo.png')}}" alt="BPC Logo" class="brand-image img-circle elevation-3" style="height:50px;width:40px; opacity: .8"> <span class="brand-text font-weight-dark center text-dark"><strong>BPC System</strong></span> </a>
	</div>
	<!-- Sidebar Menu -->
	<div class="sidebar">
		<!-- Agency Head -->
		<nav class="mt-2" style="background-color:#FFFF;">
			<div class="dropdown-divider"></div>
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
				<!-- FR Deployment -->
				<li class="nav-item has-treeview menu-open">
					<a href="" class="nav-link text-dark" data-value="none"> <i class="nav-icon fas fa-folder-plus"></i>
						<p><strong>Dashboard</strong> <i class="fas fa-angle-left right"></i> </p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item"><a href="/home" class="nav-link text-secondary"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i>&nbsp;&nbsp;<p>Dashboard</p></a></li>
					</ul>

        <!-- @if(Auth::user()->role_id != 41 || Auth::user()->role_id != 42 || Auth::user()->role_id != 43 || Auth::user()->role_id != 44 ||
        Auth::user()->role_id != 45 ||Auth::user()->role_id != 46 || Auth::user()->role_id != 47 || Auth::user()->role_id != 48 ||
        Auth::user()->role_id != 49 || Auth::user()->role_id != 50 || Auth::user()->role_id != 51 || Auth::user()->role_id != 52 ||
        Auth::user()->role_id != 53 || Auth::user()->role_id != 54 || Auth::user()->role_id != 55 || Auth::user()->role_id != 56 ||
        Auth::user()->role_id != 57 || Auth::user()->role_id != 58 || Auth::user()->role_id != 59 || Auth::user()->role_id != 60 ||
        Auth::user()->role_id != 61 || Auth::user()->role_id != 64 || Auth::user()->role_id != 65 || Auth::user()->role_id != 66 ||
        Auth::user()->role_id != 67)

				</li> @foreach($formgroups as $fg)
				<li class="nav-item has-treeview menu-open">
					<a href="" class="nav-link text-dark" data-value="none"> <i class="nav-icon fas fa-folder-plus"></i>
						<p><strong>{{$fg->group}}</strong> <i class="fas fa-angle-left right"></i> </p>
					</a>
					<ul class="nav nav-treeview"> @foreach($forms as $form) @if($form->group != $fg->group)
						<li class="nav-item"><a href="/" onclick="return false;" data-value="{{$form->forms}}" class="nav-link text-secondary"><i class="fas {{$form->icon}}"></i>&nbsp;&nbsp;<p>{{$form->description}}</p></a></li> @endif @endforeach </ul>
				</li> @endforeach
        @endif -->

				<div class="dropdown-divider"></div>
			</ul>
		</nav>
	</div>
	<!-- sidebar -->
</aside>
<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script--!>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
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
});
</script> @endguest
