@php use Illuminate\Support\Str; @endphp
@extends('layouts.master')
@section('title') {{$title}} @endsection

@section('pagehead')
<style>
	a {
		text-decoration: none;
		color: black;
	}

	.Formcard {
		height: 5%;
		margin-left: 4%;
	}

	.nav-link {
		color: black;
	}

	.small-box:hover {
		transform: scale(1.1);
	}

	.small-box {
		transition: transform .2s;
		background-color: #F3F3F1;
	}

	.ta,
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
	.nav-link.active {
	font-weight: bold;
	background-color: transparent !important;
	color: green !important;
	text-decoration: underline;
	}
</style>

{{-- Display session messages --}}
@if(count($errors) > 0)
	<div class="alert alert-danger">
		Upload Validation Error<br><br>
		<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
	</div>
@endif

@foreach (['guesthouseself', 'cancel', 'error', 'guesthouse', 'success', 'roleadd', 'adduser', 'successmsg'] as $msg)
	@if(session()->has($msg))
		<div class="alert alert-{{ in_array($msg, ['error', 'cancel', 'guesthouse']) ? 'danger' : 'success' }} text-center" style="font-size:20px;">
			{{ session()->get($msg) }}
		</div>
	@endif
@endforeach

<div class="container-fluid mt-0 mb-0">
	<div class="row mt-0 mb-0">
		<div class="col-sm-6">
			<h5 id="contenthead">
				<a href="/home"><strong><i class="fa fa-home" aria-hidden="true">&nbsp;</i></strong></a>
			</h5>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><p id="listlink"><a href="#"></a></p></li>
			</ol>
		</div>
	</div>
</div>
@endsection

@section('content')
<div class="container-fluid" id="contentpage">
	{{-- Hidden page indicator --}}
	<input type="hidden" name="page" id="pageid" value="{{ session()->get('page')}}">

	{{-- Tabs --}}
	<ul class="nav nav-pills mb-3" id="groupTab" role="tablist">
    @foreach($groupedForms as $groupName => $group)
        <li class="nav-item">
            <a class="nav-link {{ $loop->first ? 'active' : '' }}"
		       id="group-tab-{{ Str::slug($groupName) }}"
               data-toggle="pill"
               href="#group{{ Str::slug($groupName) }}"
               role="tab">
               {{ $groupName }}
            </a>
        </li>
    @endforeach
</ul>


	{{-- Tab Content --}}
	<div class="tab-content" id="groupTabContent">
    @foreach($groupedForms as $groupName => $group)
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
             id="group{{ Str::slug($groupName) }}"
             role="tabpanel">
            <ul class="nav nav-treeview row">
                @foreach($group as $form)
                    <li class="small-box p-3 border border-dark col-lg-2 col-md-4 m-2">
                        <a href="/" onclick="return false;" data-value="{{ $form->forms }}" class="nav-link text-dark loadForm">
                            <h5 class="text-center">
                                <i class="fas {{ $form->icon }}" style="color:green;"></i>
                            </h5>
                            <p class="text-center">{{ $form->description }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>

</div>

{{-- Scripts --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
	$(document).ready(function () {
		// Auto-close session alerts
		$('div.alert').delay(6500).slideUp(300);

		// On form click
		$(document).on('click', '.loadForm', function (e) {
			e.preventDefault();
			const id = $(this).data('value');
			if (id && id !== 'none') {
				$.get('/getView?v=' + id, function (data) {
					// Option 1: Replace entire content section (including tabs)
					$('#contentpage').html(data.html);
				});
			}
		});

		// Load a specific form on page load (if session has a value)
		const page = $('#pageid').val();
		if (page.length > 0) {
			$.get('/getView?v=' + page, function (data) {
				$('#contentpage').html(data.html);
			});
		}
	});
</script>
@endsection
