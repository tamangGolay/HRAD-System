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
Route::post('reportsearch', 'ContributionReportController@index')->name('reportsearch');




//vehicle
Route::resource('a_b', VehicleController::class);

//guesthouse edit routing
Route::resource('guesth', guestHouseEditController::class);

//manage vehicle
Route::resource('vehicle', Manage_VehicleController::class);




//employeeReporting

Route::resource('employeeR', Manage_employeeController::class);
Route::post('destroyemployeereport', 'Manage_employeeController@delete')->name('destroyemployeereport');

//payscale

Route::resource('pay', Manage_payController::class);
Route::post('destroypayscale', 'Manage_payController@delete')->name('destroypayscale');


//familydetails
Route::resource('family', Manage_familyController::class);
Route::post('destroyfamilydetails', 'Manage_familyController@delete')->name('destroyfamilydetails');


//incrementdetails

Route::resource('increment', Manage_incrementController::class);
Route::post('destroyincrementhistory', 'Manage_incrementController@delete')->name('destroyincrementhistory');

//reportoffice

Route::resource('officereport', Manage_officereportController::class);
Route::post('destroyofficehistory', 'Manage_officereportController@delete')->name('destroyofficehistory');

//promotion history
Route::resource('promotion', Manage_promotionController::class);
Route::post('destroypromotionhistory', 'Manage_promotionController@delete')->name('destroypromotionhistory');

// Userprofile

Route::post('/profileupdate','Manage_profileupdateController@store')->name('profileupdate');

Route::get('getValues','GetMastersController@getValues');
Route::post('/conferencebook','ConferenceController@conference')->name('conferencebook');
//pdf

// Route::get('/product/{id}', [App\Http\Controllers\ProductController::class, 'index'])->name('ProductController.index');
Route::get('/notesheetReport/{id}', [App\Http\Controllers\PdfController::class, 'createPDF'])->name('notesheet.pdf');
// Route::get('/', [App\Http\Controllers\ProductController::class, 'index1'])->name('ProductController.index1');

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




// Route::get('getValues','GetMastersController@getValues');
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

//CSV

// Route::get('/import-form',[EmployeeController::class,'importform']);

// Route::get('/import',[EmployeeController::class,'import'])->name('import');
Route::get('/import-form','EmployeeController@importform');
Route::post('/import','EmployeeController@import')->name('import');

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
Route::post('/conferencereject','ConferenceController@conferencereject')->name('conferencereject');
// Route::post('/conferencebook','ConferenceController@conference')->name('conferencebook');

//user_profile page
//Routes for user_profile page
//To view the page

Route::get('/cbook/', 'GetMastersController@user_profile');
//For message
Route::get('/success', 'GetMastersController@success');
Route::get('/error', 'GetMastersController@error');




//Post data from form of user_profile page


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

//golay
//for drungkhag
Route::resource('drungkhag', Manage_MasterDrungkhagController::class);
Route::post('destroydrungkhag', 'Manage_MasterDrungkhagController@delete')->name('destroydrungkhag');
//for town
Route::resource('town', Manage_MasterTownController::class);
Route::post('destroytown', 'Manage_MasterTownController@delete')->name('destroytown');
//for gewog
Route::resource('gewog', Manage_MasterGewogController::class);
Route::post('destroygewog', 'Manage_MasterGewogController@delete')->name('destroygewog');
//for village
Route::resource('village', Manage_MasterVillageController::class);
Route::post('destroyvillage', 'Manage_MasterVillageController@delete')->name('destroyvillage');
//for bank
Route::resource('bank', Manage_MasterBankController::class);
Route::post('destroybank', 'Manage_MasterBankController@delete')->name('destroybank');
//for place
Route::resource('place', Manage_MasterPlaceController::class);
Route::post('destroyplace', 'Manage_MasterPlaceController@delete')->name('destroyplace');
//For MasterData
Route::post('user','MasterDataController@storeUser')->name('user');
//manage officeName
Route::resource('officeName', Manage_MasterController::class);
Route::post('destroyofficeName', 'Manage_MasterController@delete')->name('destroyofficeName');
Route::post('save', 'OneEmployeeController@saveRecord')->name('save');

//golay end

//start sonam 
//manage designation
Route::resource('designation', DesignationMasterController::class);
Route::post('destroydesignation', 'DesignationMasterController@delete')->name('destroydesignation');

//manage resignation
Route::resource('resignation', ResignationMasterController::class);
Route::post('destroyresignation', 'ResignationMasterController@delete')->name('destroyresignation');

//manage company
Route::resource('company', CompanyMasterController::class);
Route::post('destroycompany', 'CompanyMasterController@delete')->name('destroycompany');

//manage leavetype
Route::resource('leave', LeavetypeMasterController::class);
Route::post('destroyleave', 'LeavetypeMasterController@delete')->name('destroyleave');

//manage office
Route::resource('office', OfficeMasterController::class);
Route::post('destroyoffice', 'OfficeMasterController@delete')->name('destroyoffice');

//manage department
Route::resource('department', DepartmentMasterController::class);
Route::post('destroydepartment', 'DepartmentMasterController@delete')->name('destroydepartment');

//manage skill master
Route::resource('skillmaster', SkillMasterController::class);
Route::post('destroyskillmaster', 'SkillMasterController@delete')->name('destroyskillmaster');
//end sonam

//manage grade 
Route::resource('grade', Manage_GradeController::class);
Route::post('destroyGrade', 'Manage_GradeController@delete')->name('destroyGrade');//for deleting grade

//manage post master
Route::resource('postmaster', Manage_PostController::class);
Route::post('destroyPostMaster', 'Manage_PostController@delete')->name('destroyPostMaster');//for deleting post


//manage division
Route::resource('division', Manage_DivisionController::class);
Route::post('destroyDivision', 'Manage_DivisionController@delete')->name('destroyDivision'); //for deleting  division

//manange contractdetail
Route::resource('contractdetail', Manage_ContractDetailController::class);
Route::post('destroyContractDetail', 'Manage_ContractDetailController@delete')->name('destroyContractDetail'); //for deleting contract details

//manage Service
Route::resource('service', Manage_ServiceController::class);
Route::post('destroyService', 'Manage_ServiceController@delete')->name('destroyService'); //for deleting service details

//manage substation
Route::resource('substation', Manage_SubstationController::class);
Route::post('destroySubstation', 'Manage_SubstationController@delete')->name('destroySubstation'); //for deleting substation details

//manage sub division
Route::resource('subdivision', Manage_SubDivisionController::class);
Route::post('destroySubDivision', 'Manage_SubDivisionController@delete')->name('destroySubDivision'); //for deleting  sub division


//golay


Route::resource('gewog', Manage_MasterGewogController::class);
Route::post('destroygewog', 'Manage_MasterGewogController@delete')->name('destroygewog');


Route::resource('bank', Manage_MasterBankController::class);
Route::post('destroybank', 'Manage_MasterBankController@delete')->name('destroybank');

Route::resource('place', Manage_MasterPlaceController::class);
Route::post('destroyplace', 'Manage_MasterPlaceController@delete')->name('destroyplace');


//qualificationleveltype
Route::resource('qualificationlevel', QualilevelController::class);
Route::post('destroyqualificationlevel', 'QualilevelController@delete')->name('destroyqualificationlevel');

//qualification
Route::resource('qualification', MasterQualiController::class);
Route::post('destroyQualification', 'MasterQualiController@delete')->name('destroyQualification');

//employee qualification
Route::resource('employeeQualification', empQualificationController::class);
Route::post('destroyEmpQualification', 'empQualificationController@delete')->name('destroyEmpQualification');

//relation 
Route::resource('relation', MasterRelationController::class);
Route::post('destroyrelation', 'MasterRelationController@delete')->name('destroyrelation');

//displinary
Route::resource('displinary', DisplinaryController::class);
Route::post('destroyDisplinary', 'DisplinaryController@delete')->name('destroyDisplinary');

//unit
Route::resource('unit', ManageUnitController::class);
Route::post('destroyUnit', 'ManageUnitController@delete')->name('destroyUnit');

//fieldname
Route::resource('field', Manage_FieldController::class);
Route::post('destroyField', 'Manage_FieldController@delete')->name('destroyField');

//PantSize Name
Route::resource('pant', Manage_PantController::class);
Route::post('destroyPant', 'Manage_PantController@delete')->name('destroyPant');

//Shirt Size Name
Route::resource('shirt', Manage_ShirtController::class);
Route::post('destroyShirt', 'Manage_ShirtController@delete')->name('destroyShirt');

//jacket size
Route::resource('jacket', Manage_MasterJacketSizeController::class);
Route::post('destroyJacket', 'Manage_MasterJacketSizeController@delete')->name('destroyJacket');

//uniform shoe size
Route::resource('shoesize', ShoeSizeMasterController::class);
Route::post('destroyshoesize', 'ShoeSizeMasterController@delete')->name('destroyshoesize');

//raincoat size
Route::resource('raincoat', Manage_MasterRainCoatController::class);
Route::post('destroyRainCoat', 'Manage_MasterRainCoatController@delete')->name('destroyRainCoat');

//route for payment release
Route::post('paymentRelease','PaymentReleaseController@paymentRelease')->name('paymentRelease');

//welfare refund
Route::post('Request_refund','WelfareRefundController@Request_refund')->name('Request_refund');

//skill category
Route::resource('skillcategory', SkillCategoryController::class);
Route::post('destroySkill', 'SkillCategoryController@delete')->name('destroySkill');//for deleting skill category


//sub skill category
Route::resource('subCat', SubSkillCategoryController::class);
Route::post('destroysubCat', 'SubSkillCategoryController@delete')->name('destroysubCat');

//employee skill map
Route::resource('employeeskillmap', EmployeeSkillMapController::class);
Route::post('destroyEmployeeSkill', 'EmployeeSkillMapController@delete')->name('destroyEmployeeSkill');//for deleting skill category 

//report for refund
Route::resource('refundReport', 'RefundReportController');//refund report

//welfare payment report
Route::resource('paymentreport', 'PaymentReportController');

//welfare refund
Route::post('Request_notesheet','NotesheetController@Request_notesheet')->name('Request_notesheet');

//notesheet route to view
Route::get('/selfghCancelBooking','NotesheetController@selfghCancelBooking');// 

//notesheet route to CANCEL
Route::post('/cancelNotesheet','NotesheetController@cancelNotesheet')->name('cancelNotesheet');

Route::post('/recommendnotesheet','NotesheetController@recommendnotesheet')->name('recommendnotesheet');
Route::post('/approvenotesheet','NotesheetController@approvenotesheet')->name('approvenotesheet');
Route::post('/rejectnotesheet','NotesheetController@rejectnotesheet')->name('rejectnotesheet');
Route::get('pdf-create','PdfController@create');

Route::resource('notesheet', NotesheetController::class);

Route::post('/supervisorApproval/{id}','NotesheetController@supervisorApproval')->name('supervisorApproval');// 

//gm notesheet route
Route::post('/GMrecommendnotesheet','NotesheetController@GMrecommendnotesheet')->name('GMrecommendnotesheet');

//director notesheet route
Route::post('/directorrecommendnotesheet','NotesheetController@directorrecommendnotesheet')->name('directorrecommendnotesheet');
