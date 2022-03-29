    <div class="wrapper">   
           <!-- main search form -->  
            <section class="content" id='FR'>      
                <form>
                @csrf
                <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
                    <div class="inner-form"> 
                            <hr>
                            <span class="desc"> <strong> Qurantine Facilities </strong></span>
                            <hr>               
                            <div class="form-group row">
                              <div class="col-sm-3">
                                <div class="input-field">
                                  <div class="input-select">
                                    <select  class="form-control" name="dzongkhag" id="dzongkhag">
                                      <option value="">Select Dzongkhag</option>
                                        @foreach($dzongkhags as $dzongkhag)
                                        <option value="{{$dzongkhag->id}}">{{$dzongkhag->Dzongkhag_Name}}</option>
                                        @endforeach 
                                    </select>
                                  </div>
                                </div> 
                              </div>  
                              <div class="col-sm-3">  
                                <div class="input-field">
                                  <div class="input-select">
                                    <select   class="form-control" name="quarantineList" id="quarantineList">
                                      <option value="quarantineList">Select Quarantine Facility</option>   
                                    </select> 
                                  </div>
                                </div>
                              </div>       
                              <div class="col-sm-3">  
                                <div class="input-field">
                                  <div class="input-select">
                                  <select class="form-control" name="choices-single-defaul">
                                      <option placeholder="" value="">Facility Staues</option>
                                      <option>Available</option>
                                      <option>Used</option>
                                    </select>
                                  </div>
                                </div>
                              </div>    
                            </div>
                            <hr>
                            <div class="form-group row">                          
                                <div class="input-field">
                                  <div class="text-center">  
                                      <div class="col-sm-10">
                                        <button  class="btn btn-primary" type="reset" value="Reset">RESET</button>
                                      </div>
                                    </div>
                                </div>
                                <div class="input-field">
                                      <div class="col-sm-10">
                                        <button class="btn btn-primary" type="submit" value="Submit">SEARCH</button>
                                      </div>
                                </div> 
                            </div>
                            <hr>
                          <span class="desc"><strong>Search Individual Detail By</strong></span>
                            <hr> 
                            <div class="form-group row"> 
                              <div class="col-sm-3">  
                                <div class="input-field">
                                  <div class="input-select">   
                                    <select  class="form-control" name="nationalityList" id="nationalityList">
                                          <option placeholder="" value="">Nationality</option>
                                              @foreach($nationalityList as $nationalityList)
                                              <option value="{{$nationalityList->id}}">{{$nationalityList->nationality}}</option>
                                              @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div> 

                              <div class="col-sm-3">
                                <div class="input-field">
                                  <div class="input-select">
                                    <select  class="form-control" name="occupationList" id="occupationList">
                                      <option placeholder="" value="">Occupation</option>
                                        @foreach($occupationList as $occupationList)
                                          <option value="{{$occupationList->id}}">{{$occupationList->occupation}}</option>
                                        @endforeach 
                                    </select>
                                  </div>
                                </div>
                              </div>

                              <div class="col-sm-3">
                                <div class="input-field">
                                  <div class="input-select">
                                    <select  class="form-control" name="countryoforiginList" id="countryoforiginList">
                                      <option value="">Country of Origin</option>
                                        @foreach($countryoforiginList as $countryoforiginList)
                                        <option value="{{$countryoforiginList->id}}">{{$countryoforiginList->country}}</option>
                                        @endforeach 
                                    </select>
                                  </div>
                                </div>
                              </div>

                              <div class="col-sm-3">
                                <div class="input-field">
                                  <div class="input-select">
                                    <select class="form-control" name="choices-single-defaul">
                                      <option placeholder="" value="">Quarantine Type (Days)</option>
                                      <option>3 Days</option>
                                      <option>7 Days</option>
                                      <option>21 Days</option>
                                    </select>
                                  </div>
                                </div>
                              </div> 
                            </div>
                            
                            <div class="form-group row">   
                                <div class="col-sm-3">
                                  <label class="col-sm-4 text-center" for="dateid">From</label>
                                  <input type="date" class="form-control air-datepicker" name="joining_date" autocomplete="off" id="dateid">  
                                </div>
                                <div class="col-sm-3">
                                  <label class="col-sm-4 text-center" for="dateid">Till</label>
                                  <input type="date" class="form-control air-datepicker" name="joining_date" autocomplete="off" id="dateid">  
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">                          
                                <div class="input-field">
                                  <div class="text-center">  
                                      <div class="col-sm-10">
                                        <button  class="btn btn-primary" type="reset" value="Reset">RESET</button>
                                      </div>
                                  </div>
                                </div>
                                <div class="input-field">
                                      <div class="col-sm-10">
                                        <button class="btn btn-primary" type="submit" value="Submit">SEARCH</button>
                                      </div>
                                </div>
                            </div>
                          
                            <hr>
                           <span class="desc"><strong>Accounts Report</strong></span>
                            <hr>
                            <div class="form-group row"> 
                                <div class="col-sm-3">
                                  <div class="input-field">
                                    <div class="input-select">
                                      <select  class="form-control" name="dzongkhag" id="dzongkhag">
                                        <option value="">Select Dzongkhag</option>
                                          @foreach($dzongkhags as $dzongkhag)
                                        <option value="{{$dzongkhag->id}}">{{$dzongkhag->Dzongkhag_Name}}</option>
                                          @endforeach 
                                      </select>
                                    </div>
                                  </div> 
                                </div>
                                <div class="col-sm-3">  
                                  <div class="input-field">
                                    <div class="input-select">
                                      <select class="form-control" name="choices-single-defaul">
                                        <option placeholder="" value="">Select Month</option>
                                        <option>January</option>
                                        <option>February</option>
                                        <option>March</option>
                                        <option>April</option>
                                        <option>May</option>
                                        <option>June</option>
                                        <option>July</option>
                                        <option>August</option>
                                        <option>September</option>
                                        <option>October</option>
                                        <option>November</option>
                                        <option>December</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>  
                                <div class="col-sm-3">  
                                  <div class="input-field">
                                    <div class="input-select">
                                      <select class="form-control" name="choices-single-defaul">
                                        <option placeholder="" value="">Financial Year</option>
                                        <option>2020-2021</option>
                                        <option>2019-2020</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>  
                            </div>
                            <div class="form-group row">                          
                                <div class="input-field">
                                  <div class="text-center">  
                                      <div class="col-sm-10">
                                        <button  class="btn btn-primary" type="reset" value="Reset">RESET</button>
                                      </div>
                                  </div>
                                </div>
                                <div class="input-field">
                                      <div class="col-sm-10">
                                        <button class="btn btn-primary" type="submit" value="Submit">SEARCH</button>
                                      </div>
                                </div>
                            </div>
                    </div>
                </form>
            </section>
       
        
    </div>
  
<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"> </script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  document.getElementById('contenthead').innerHTML = '<strong>Search Detail for Quarantine</strong>';

  $("#dzongkhag").on('change',function(e){
           //console.log(e);
            var id = e.target.value;
            var csrftoken =document.getElementById('tokenid').value;
            $.get('/getValues?source=facilities&info='+id+'&token='+csrftoken,function(data){              
                console.log(data);
                 $('#quarantineList').empty();               
                  $.each(data, function(index, quarantineName){
                      $('#quarantineList').append('<option value="'+quarantineName.id+'">'+quarantineName.facility_name+'</option>');   
                  })
               
            });
    });

});

</script>
 
