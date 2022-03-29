<?php
header('X-Frame-Options: SAMEORIGIN');
?>
@extends('layouts.masterdefault')
@section('title', 'Login')
@section('content')






<div class="hold-transition login-page">

    <div class="login-box">

<div class="card">


<div class="card-body login-card-body "> 

    <div class="login-box-msg">{{ __('Track Status') }}</div>
        <form  action="trackstatus">
            @csrf
            <div class="row">
                <div class="col">
                  

            <div class="form-group row">
                <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> -->

                <div class="input-group mb-2">
                <input id="emp_id" type="number" placeholder="Booking No/Emplyee No" class="form-control" name="emp_id" required>
               

                    <div class="input-group-append">
                        <div class="input-group-text">
                        <span class="fas fa-search"></span>
                        </div>
                    </div>
                  
                </div>
            </div>

            </div>
            </div>


                <br>
            <div class="row">
                <div class="col-8">
                    <div class="col-4">

              
                    <button type="submit" class="btn btn-outline btn-success">
                        {{ __('Track') }}
                    </button>

                    

                    </div>
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


@endsection
