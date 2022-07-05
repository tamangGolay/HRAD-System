<?php
use App\Http\Controllers\MailController;
use App\Http\Controllers\GuestHouseController;
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::post('deleteuser', 'ConferenceController@conference_deleteuser')->name('deleteuser');

Route::post('/delete', 'ConferenceController@delete')->name('delete');
Route::post('/deleteuser', 'Manage_UserController@delete')->name('deleteuser');
//forgot password
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

//forgot password new
Route::get('/forgetPassword', function () {
  return view('auth.forgetPassword');
})->middleware('guest')->name('password.request');
//end forgot password new



Route::post('destroyVehicle', 'Manage_VehicleController@delete')->name('destroyVehicle');
Route::get('manage_vehicle', 'Manage_VehicleController@message')->name('manage_vehicle');

Route::resource('g', Manage_UserController::class);


//vehicle Report
Route::post('reportsearch', 'reportSearchController@index')->name('reportsearch');




//vehicle
Route::resource('a_b', VehicleController::class);

//guesthouse edit routing
Route::resource('guesth', guestHouseEditController::class);

//manage vehicle
Route::resource('vehicle', Manage_VehicleController::class);


//guesthouse leki
Route::resource('guesthouse', Manage_GuesthouseController::class);
Route::post('destroyGuesthouse', 'Manage_GuesthouseController@delete')->name('destroyGuesthouse');
Route::get('manage_guesthouse', 'Manage_GuesthouseController@message')->name('manage_guesthouse');
Route::post('addRoom','GuestHouseController@addRoom')->name('addRoom');


Auth::routes();






Route::get('/', function(){
  return view('auth.login');

});












// new route



Route::get('/admin', function () {
        
        if(Auth::check())
        {
            
            return Redirect::route('home');
          
          // return redirect('dashboard');
        }
        else
        {
          //  return view('auth.login');
           return view('auth.login');
        }
        
    });

Route::post('registerUser', 'Auth\AuthController@registerUser')->name('registerUser');



Route::middleware(['auth'])->group(function() {

//tamang (Routes for Track_vehicles)
Route::post('Request_vehicle','VehicleController@Request_vehicle')->name('Request_vehicle');

Route::get('/home', 'HomeController@home')->name('home');




Route::get('getValues','GetMastersController@getValues');
Route::get('getValues1','GetMastersController@getValues1');

//route form post.
Route::post('roleform','FormRoleMappingCtrl@store')->name('roleform');
Route::post('bed','GuestHouseController@bed')->name('bed');
Route::post('gHouse','GuestHouseController@store')->name('gHouse');
Route::post('gHouseOutsider','GuestHouseController@storeOutsider')->name('gHouseOutsider');
Route::post('gHouseSelf','GuestHouseController@storeSelf')->name('gHouseSelf');


Route::post('/invoicemail','GuestHouseController@invoicemail')->name('invoicemail');
Route::post('/cancelGH','GuestHouseController@cancelGH')->name('cancelGH');




Route::get('/getUserDetails','apiControllers@getUserDetails');



Route::get('register', 'Auth\AuthController@register')->name('register')->middleware('authorizeform');
Route::post('user','Auth\AuthController@storeUser')->name('user');
Route::post('role','Auth\AuthController@addRole')->name('role');






}); //end of middleware group.

//Auth::routes();
Route::get('/login', 'Auth\AuthController@login')->name('login');
Route::post('login','Auth\AuthController@authenticate')->name('login');
Route::get('/register', 'Auth\AuthController@register')->name('register');
Route::post('/logout','Auth\AuthController@logout')->name('logout');



//vehicle
//ICD
Route::post('/vehicleapprove','VehicleController@vehicleapprove')->name('vehicleapprove');
Route::post('/vehiclereject','VehicleController@vehiclereject')->name('vehiclereject');

//MTO
Route::post('/MTOapprove','VehicleController@MTOapprove')->name('MTOapprove');
Route::post('/MTOreject','VehicleController@MTOreject')->name('MTOreject');
Route::post('/MTOrequestremove','VehicleController@MTOrequestremove')->name('MTOrequestremove');
//duration extend MTO
Route::post('/MTOdurationextend','VehicleController@MTOdurationextend')->name('MTOdurationextend');

//MTO TO GM
Route::post('/MTOGMapprove','VehicleController@MTOGMapprove')->name('MTOGMapprove');
Route::post('/MTOGMreject','VehicleController@MTOGMreject')->name('MTOGMreject');


//GM to MTO Return Review
Route::post('/RETURNapprove','VehicleController@RETURNapprove')->name('RETURNapprove');
Route::post('/RETURNreject','VehicleController@RETURNreject')->name('RETURNreject');


Route::get('/pass',function(){
    dd(Hash::make('bpc@123'));
});

Route::get('/getView','FormsController@getView');



//leki
Route::post('Q_Facility_Rooms','GuestHouseController@addRoomDetails')->name('Q_Facility_Rooms');
Route::get('/getRoomDetails','GuestHouseController@getRoomDetails')->name('getRooms');



Route::get('/dynamic', function() {
 $dzongkhags = \App\Dzongkhags::all();
 return view('Guesthouse.room_details',compact('dzongkhags'));

});





Route::get('/getValues','GetMastersController@getValues');
Route::get('/getValues1','GetMastersController@getValues1');



// change password

Route::post('changepassword', 'ChangePasswordController@store')->name('changepassword');
Route::post('changepasswordstart', 'ChangePasswordController@storestart')->name('changepasswordstart');




//reset password
Route::post('resetpassword', 'ChangePasswordController@reset')->name('resetpassword');


Route::get('/send-email',[MailController::class,'sendEmail']);
Route::get('/userList', 'Manage_UserController@message')->name('userList');


// GUESTHOUSE check availability
Route::get('checkguesthouse', [GuestHouseController::class, 'checkguesthouse']);
Route::get('checkguesthouseoutsider', [GuestHouseController::class, 'checkguesthouseoutsider']);
Route::get('checkguesthouseself', [GuestHouseController::class, 'checkguesthouseself']);
Route::get('fetch-guesthouse', [GuestHouseController::class, 'fetchguesthouse']);

//date to and from search
Route::post('/date_search', 'VehicleController@date_search')->name('date_search');

//for guesthouse cancel
Route::get('/guesthouseCancelBooking','GuestHouseController@ghcancelBooking');
Route::post('/guestHousereject','GuestHouseController@guestHousereject')->name('guestHousereject');

Route::get('/outsiderCancelBooking','GuestHouseController@outsiderCancelBooking');//outsider gh cancel

Route::get('/selfghCancelBooking','GuestHouseController@selfghCancelBooking');// guesthouse self cancel

// Routes for guestHouse report controller
Route::resource('guesthousereport','guestHouseReportsController');


//Routes for Conference System

//Booking review page

//Booking review updating request in store function
Route::resource('c_request', ConferenceController::class);
//Booking review deleting request
Route::post('/delete', 'ConferenceController@delete')->name('delete');
//Redirecting the booking review page after crude operations
Route::get('/booking_reviewm', 'ConferenceController@message')->name('booking_reviewm');

//Board room page
//Board room  approve
Route::post('/conferenceapprove','ConferenceController@conferenceapprove')->name('conferenceapprove');
//Board room reject
Route::post('/conferencereject','ConferenceController@conferencereject')->name('conferencereject');Route::post('/conferencebook','ConferenceController@conference')->name('conferencebook');

//C_booking page
//Routes for c_booking page
//To view the page

Route::get('/cbook/', 'GetMastersController@c_booking');
//For message
Route::get('/success', 'GetMastersController@success');
Route::get('/error', 'GetMastersController@error');




//Post data from form of C_booking page
Route::post('/conferencebook','ConferenceController@conference')->name('conferencebook');
//onFocusOut for employee details
//source == C_booking
Route::get('getValues','GetMastersController@getValues');

//Tracking page
//Page to enter booking id or employee number
Route::get('/tracking', 'GetMastersController@tracking');

//Track page
//Page that shows the status of request of meeting room
Route::get('trackstatus','ConferenceController@trackview');

//Manage Conference Page
//Index page for manage conference
Route::get('/conference_manage', 'Manage_ConferenceController@index')->name('conference_manage');
//Route for crude operation of manage conference
Route::resource('conference', Manage_ConferenceController::class);
//Route to delete the meeting room
Route::post('destroy', 'Manage_ConferenceController@deleteConference')->name('destroy');
//Redirecting the manage conference page after crude operations
Route::get('manage_conference', 'Manage_ConferenceController@message')->name('manage_conference');

//conferenceReport page
//route for report page
Route::resource('conferenceReport', 'conferenceReportController');//conference report

//Clash page
//route for clash
Route::get('/clash/{id}', 'GetMastersController@clashview')->name('/clash');

//Uniform Routes

Route::post('/uniform','UniformController@store')->name('uniform');

Route::post('/delete','UniformController@delete')->name('delete');

Route::post('destroy', 'Manage_UniformController@deleteuniformrecord')->name('destroy');

// for uniform deleting
Route::delete('/nieuws/{id}', 'uniformController@destroy')->name('nieuws');

//For MasterData
Route::post('user','MasterDataController@storeUser')->name('user');
