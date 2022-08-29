<style>
    
a {
    color: black !important;
    text-decoration: none;
}

<style>




.btn-primary {
    color: #fff !important;
    background-color: #007bff;
    border-color: #007bff;
}
.alert-success {
    color: #fff !important;
    background-color: #28a745 !important;
    border-color: #28a745 !important;
}

.alert-danger {
    color: #fff !important;
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
}
 img {
	width: 70%;
	height: 20%;
    border-radius: 5px;
    padding: 40% left;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    

}


</style>
@if(session()->has('alert-success'))
				<div class="alert alert-success"> {{ session()->get('alert-success') }} </div> @endif

@if(session()->has('error'))
				<div class="alert alert-danger"> {{ session()->get('error') }} </div> @endif


<link href="{{asset('css/bose.css')}}" rel="stylesheet">
<!-- called in bose.css -->

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"> -->
    <!-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"> -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script> 


<div class="container">
    <div class="row">
     <div class="col-md-12 ">
            <div class="card">
             <div class="card-header bg-green  d-flex justify-content-center">
                 <strong>Bulk upload</strong> 
             </div>
                <div class="textfont card-body">
                    @if(count($errors) > 0)
                        <div class="alert alert-danger">
                                Upload Validation Error<br><br>
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>
                                    {{ $error }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>
                                 {{ $message }}
                                </strong>
                        </div>
                    @endif    
                    <form method="POST" enctype="multipart/form-data" action="{{route('import')}}" >
                        {{csrf_field()}}
                        <div class="form-group row">
                            <label for="title" class="col-md-2 col-form-label text-md-right">Upload CSV file</label>
                                <div class="col-sm-10 col-md-6 col-lg-10 ">
                                    <input type="file" name="file" class="form-control" required>
                                </div>
                        </div>

                        <div class="form-group row mb-0">
						    <div class="col text-center col-form-label col-md-center col-sm-2 col-md-10 col-lg-12 ">
                                <input type="submit"name="upload" value="upload"class="btn btn-outline-primary btn-md"></button>
						    </div>
					    </div>    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
<br>
<div class = "col-md-11 text-center">
                <h4> Excel format sample</h4>
            </div>
            <br>

        <div>
        <img  class="img-responsive center-block d-block mx-auto" src="{{asset('/cd/images/sample.png')}}">
</div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>   -->
    <script type="text/javascript">  </script>

<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
		});
		</script>


