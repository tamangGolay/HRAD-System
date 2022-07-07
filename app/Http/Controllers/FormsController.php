<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Roles;
use App\orgunit;
use App\Dzongkhags;
use Carbon\Carbon;
use App\Vehicles;
use App\User;
use App\vehiclerequest;
use App\guesthouseroom;
use App\guesthouse;
use App\Grade;
use App\roombed;

class FormsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getView(Request $request)
    {
        //create user.
        if ($request->v == "conferenceuser")
        {
            $user = Auth::user();

            $wings = Wing::all();
            $departments = Department::all();
            $divisions = Division::all();

            $roles = $user->role;
            $role_admin = false;
            foreach ($roles as $role)
            {
                if ($role->name == "Admin")
                {
                    $role_admin = true;
                }
            }
            // //admin to add user from any dzongkhags and any roles.
            // if($role_admin)
            // {
            //      $roles = Roles::all();
            //      $wings = Wing::all();
            //      $departments = Department::all();
            //     //  $division = Division::all();
            // }
            // else
            // {
            //     $roles = Roles::wherein('role_admin',$user->role)->get();
            //     // $dzongkhags = Dzongkhags::where('id',$user->dzongkhag_id)->get();
            // }
            

            $rhtml = view('conference.conferenceuser')->with(['roles' => $roles, 'wings' => $wings, 'departments' => $departments, 'divisions' => $divisions])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }
        //end of create user.
        

       //User List.
       if ($request->v == "userList")
       {


         
               $roles = Roles::all();
               $orgunit = orgunit::all();
               $grade = Grade::all();
               $dzongkhag = Dzongkhags::all();         

      

       


           $userLists = DB::table('users')->join('userrolemapping', 'users.id', '=', 'userrolemapping.user_id')
               ->join('roles', 'users.role_id', '=', 'roles.id')
               ->join('orgunit', 'orgunit.id', '=', 'users.org_unit_id')
               ->join('guesthouserate', 'users.grade', '=', 'guesthouserate.id')
               ->join('dzongkhags', 'dzongkhags.id', '=', 'users.dzongkhag')

               ->select('users.id','users.email','dzongkhags.Dzongkhag_Name','users.gender','guesthouserate.grade','roles.id as rid','users.org_unit_id as oid','users.id as uid','users.emp_id', 'users.contact_number', 'users.designation', 'orgunit.description', 'users.name as uname', 'roles.name')
               ->latest('users.id') //similar to orderby('id','desc')
               ->where('users.status',0)
           
               ->paginate(10000000);

           $rhtml = view('auth.userList')->with(['userList' => $userLists,'roles' => $roles, 'orgunit' => $orgunit, 'grade' => $grade, 'dzongkhag' => $dzongkhag])->render();
           return response()
               ->json(array(
               'success' => true,
               'html' => $rhtml
           ));
       }
       //end of User List.


       //uniform view

       if ($request->v == "uniform")
       {

       
         
            $c_book = DB::table('conferencerequest')->join('conference', 'conferencerequest.conference_id', '=', 'conference.id')
               ->join('orgunit', 'orgunit.id', '=', 'conferencerequest.org_unit_id')
   
           
   
               ->select('conferencerequest.id', 'conferencerequest.emp_id', 'conferencerequest.id', 'conferencerequest.name', 'conferencerequest.contact_number', 'conferencerequest.meeting_name', 'conferencerequest.start_date', 'conferencerequest.end_date', 'orgunit.description','conference.Conference_Name'
                       )
               ->latest('id')
               ->paginate(1000000000);

               $rhtml = view('uniform.uniform')->with(['c_book' => $c_book])->render();
               return response()
                   ->json(array(
                   'success' => true,
                   'html' => $rhtml
               ));
   
        }
       //end uniform view

       //uniform report for individual employee
       if ($request->v == "uniformReport") 
       {
           try{

        $data1 = DB::table('employeeuniform')
        ->join('orgunit', 'orgunit.id', '=', 'employeeuniform.org_unit_id')
                 
           ->select('employeeuniform.id', 'employeeuniform.emp_id', 'orgunit.description','employeeuniform.name', 'employeeuniform.shirt', 'employeeuniform.pant', 'employeeuniform.jacket', 'employeeuniform.raincoat', 'employeeuniform.jumboot', 'employeeuniform.shoe')
            ->paginate(10000);
            

               $rhtml = view('uniform.uniformReport')->with(['data1' => $data1])->render();
               return response()
                   ->json(array(
                   'success' => true,
                   'html' => $rhtml
               ));  
            }
            catch(\Facade\Ignition\Exceptions\ViewException $e) {

                $data1 = DB::table('employeeuniform')
                ->join('orgunit', 'orgunit.id', '=', 'employeeuniform.org_unit_id')
                         
                   ->select('employeeuniform.id', 'employeeuniform.emp_id', 'orgunit.description','employeeuniform.name', 'employeeuniform.shirt', 'employeeuniform.pant', 'employeeuniform.jacket', 'employeeuniform.raincoat', 'employeeuniform.jumboot', 'employeeuniform.shoe')
                    ->paginate(10000);
                            
                       $rhtml = view('uniform.uniformReportE')->with(['data1' => $data1])->render();
                       return response()
                           ->json(array(
                           'success' => true,
                           'html' => $rhtml
                       ));  


            } 
        }

        //end of uniform report for individual employee
         //uniform report for offfice wise

       if ($request->v == "officeuniformReport")  
       {

        $data2 = DB::table('officeuniform') 
        ->join('orgunit', 'orgunit.id', '=', 'officeuniform.org_unit_id')
        ->join('dzongkhags', 'dzongkhags.id', '=', 'officeuniform.dzongkhag')
        
                 
           ->select('officeuniform.id','officeuniform.org_unit_id','dzongkhags.Dzongkhag_Name', 'orgunit.description','officeuniform.uniform_id','officeuniform.S','officeuniform.M','officeuniform.L', 'officeuniform.XL','officeuniform.Size_2XL','officeuniform.Size_3XL','officeuniform.Size_4XL','officeuniform.Size_5XL','officeuniform.Size_6XL')
           ->where('officeuniform.id',1) 
           ->orwhere('officeuniform.id',2) 
           ->orwhere('officeuniform.id',3) 
           ->orwhere('officeuniform.id',6) 
           ->paginate(10000);

               $rhtml = view('uniform.officeUniformReport')->with(['data2' => $data2])->render();
               return response()
                   ->json(array(
                   'success' => true,
                   'html' => $rhtml
               ));   
        }
        //end of uniform report for office wise


         //View for Total shoe sizes
         if ($request->v == "TotalShoeSizes")  
         {
  
            $data2 = DB::table('officeuniform') 
            ->join('orgunit', 'orgunit.id', '=', 'officeuniform.org_unit_id')
            ->join('dzongkhags', 'dzongkhags.id', '=', 'officeuniform.dzongkhag')
            
                     
               ->select('officeuniform.id','officeuniform.org_unit_id','dzongkhags.Dzongkhag_Name', 'orgunit.description','officeuniform.uniform_id','officeuniform.shoe_3','officeuniform.shoe_4','officeuniform.shoe_5', 'officeuniform.shoe_6','officeuniform.shoe_7','officeuniform.shoe_8','officeuniform.shoe_9','officeuniform.shoe_10','officeuniform.shoe_11','officeuniform.shoe_12','officeuniform.shoe_13','officeuniform.shoe_14','officeuniform.shoe_15','dzongkhag')
               ->where('officeuniform.id',4) 
               ->orwhere('officeuniform.id',5) 
               ->paginate(10000);
    
                   $rhtml = view('uniform.totalShoes')->with(['data2' => $data2])->render();
                   return response()
                       ->json(array(
                       'success' => true,
                       'html' => $rhtml
                   ));   
            }
  
  //end for total shoe sizes;



         //vehicle report List.
         if ($request->v == "reportsbak")
         {
            
            $data = DB::table('vehiclerequest')
    //    ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
    //    ->join('status', 'status.id', '=', 'vehiclerequest.status')
    //    ->join('vehicledetails', 'vehicledetails.id', '=', 'vehiclerequest.vehicleId')
    //   ->join('users', 'users.id', '=', 'vehiclerequest.supervisor') //pull gm's name
      
       ->select('*')
       ->get();
      

         $rhtml = view('vehicle.reportsbak')->with(['data' => $data])->render();
         return response()
             ->json(array(
             'success' => true,
             'html' => $rhtml
         ));
         }
         //end vehicle report.


//Conference Report
if ($request->v == "cReports")

         {            
            $review = DB::table('conferencerequest')
    //    ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
    //    ->join('status', 'status.id', '=', 'vehiclerequest.status')
    //    ->join('vehicledetails', 'vehicledetails.id', '=', 'vehiclerequest.vehicleId')
    //   ->join('users', 'users.id', '=', 'vehiclerequest.supervisor') //pull gm's name
      
       ->select('*')
       ->get();
      

         $rhtml = view('conference.conferenceReport')->with(['review' => $review])->render();
         return response()
             ->json(array(
             'success' => true,
             'html' => $rhtml
         ));
         }

//end of CReports

//Guest House reports

//Conference Report
if ($request->v == "guestHouseReports")
 {
            
 $review= DB::table('roombed')
        

       ->select('*')
       ->latest('roombed.id')

       ->get();
      

         $rhtml = view('guesthouse.guestHouseReports')->with(['review' => $review])->render();
         return response()
             ->json(array(
             'success' => true,
             'html' => $rhtml
         ));
        
         }

// end of guest House Reports

//user list

       if ($request->v == "userListHR")
       {
         
               $roles = Roles::all();
               $orgunit = orgunit::all();
               $grade = Grade::all();
               $dzongkhag = Dzongkhags::all();

       


           $userLists = DB::table('users')->join('userrolemapping', 'users.id', '=', 'userrolemapping.user_id')
               ->join('roles', 'users.role_id', '=', 'roles.id')
               ->join('orgunit', 'orgunit.id', '=', 'users.org_unit_id')
               ->join('guesthouserate', 'users.grade', '=', 'guesthouserate.id')
               ->join('dzongkhags', 'dzongkhags.id', '=', 'users.dzongkhag')

               ->select('dzongkhags.Dzongkhag_Name','users.email','users.gender','guesthouserate.grade','roles.id as rid','users.org_unit_id as oid','users.id as uid','users.emp_id', 'users.contact_number', 'users.designation', 'orgunit.description', 'users.name as uname', 'roles.name')
               ->latest('users.id') //similar to orderby('id','desc')
               ->where('status',0)

               ->paginate(10000000);

           $rhtml = view('auth.userListHR')->with(['userList' => $userLists,'roles' => $roles, 'orgunit' => $orgunit,'grade' => $grade,'dzongkhag' => $dzongkhag])->render();
           return response()
               ->json(array(
               'success' => true,
               'html' => $rhtml
           ));
       }
       //end of User List.
       
       

        //Q_Checkout form
        if ($request->v == "Q_Checkout")
        {
            $dzongkhags = Dzongkhags::all();
            $agencies = Agencies::all();

            $rhtml = view('Quarantine.Q_Checkout')->with(['dzongkhags' => $dzongkhags, 'agencies' => $agencies])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }
        //Q_Facility form
        if ($request->v == "Q_Facility")
        {
            $dzongkhags = Dzongkhags::all();

            $rhtml = view('Quarantine.Q_Facility')->with(['dzongkhags' => $dzongkhags])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }

        //admin role and form mapping
        if ($request->v == "role_form")
        {
            $roles = Roles::all();
            //exception to Role Form Mapping.
            $formlist = DB::table('forms')->where('description', '!=', 'Role Form Mapping')
                ->select('id', 'description', DB::raw("(select form_id from roleformmapping where roleformmapping.form_id = forms.id and roleformmapping.role_id='1') as formid"))
                ->get();

            $rhtml = view('role_forms')->with(['formlist' => $formlist, 'roles' => $roles])->render();
            return response()
                ->json(array(
                'success' => true,  
                'html' => $rhtml
            ));
        }

        

        //form
        if ($request->v == "registerVehicle")
        {
            $dzongkhags = Dzongkhags::all();
            $agencies = Agencies::all();

            $rhtml = view('Transportation.registerVehicle')->with(['dzongkhags' => $dzongkhags, 'agencies' => $agencies])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));

        }

        //Tracking Vehicle(To free the vehicle after tour)
        if ($request->v == "Free_vehicle")
        {
            $dzongkhags = Dzongkhags::all();

            $Free_vehicle = DB::table('vehicledetails')->join('dzongkhags', 'vehicledetails.dzo_id', '=', 'dzongkhags.id')
                ->select('vehicledetails.id', 'vehicledetails.vehicle_name', 'vehicledetails.vehicle_type', 'vehicledetails.vehicle_number', 'vehicledetails.model', 'dzongkhags.Dzongkhag_Name', 'vehicledetails.status')
                ->paginate(15);

            $rhtml = view('Tracking_Vehicle.Free_vehicle')->with(['dzongkhags' => $dzongkhags, 'Free_vehicle' => $Free_vehicle])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }
        //Free_vehicle end
        //Request_vehicle
        if ($request->v == "Request_vehicle")
        {

            $id = vehiclerequest::all();// added new

            $dzongkhags = Dzongkhags::all();
	    $vehicles = Vehicles::all()
	    ->where('status',0)	    ;
            $user = Auth::id();

            // $user = User::find($id)->name;
            // $user = User::find($id)->emp_id;
            // $user = User::find($id)->org_unit_id;


//added new

$vehicle_name = DB::table('vehiclerequest')->join('vehicledetails', 'vehicledetails.id', '=', 'vehiclerequest.vehicleId')
    ->select('vehicle_name', 'vehicle_number')
    ->get();


$bookedv = DB::table('vehiclerequest')
->join('vehicledetails', 'vehiclerequest.vehicleId', '=', 'vehicledetails.id')
 
    ->where('vehiclerequest.status', 4)
    ->select( 'vehiclerequest.id','vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehicledetails.vehicle_name','vehicledetails.vehicle_number')
    
    ->latest('vehiclerequest.id') //similar to orderby('vehiclerequest.id','desc')

    ->paginate(10000000);



        
    $rhtml = view('Tracking_Vehicle.Request_vehicle')->with(['dzongkhags' => $dzongkhags, 'vehicles' => $vehicles, 'user' => $user, 'bookedv'=> $bookedv])->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));

}
//Request_vehicle end

        //guest house start
        if ($request->v == "GuestHouseBooking")
        {
            $guesthouseroom = guesthouseroom::all();
            $roombed = guesthouseroom::all();

         

          
            
            $dzongkhags = Dzongkhags::all();
            $dzongkhag = Dzongkhags::all();
            $dzongkhag2 = Dzongkhags::all();

            $dzongkhag3 = Dzongkhags::all();

            $dzongkhag4 = Dzongkhags::all();
            $dzongkhag90 = Dzongkhags::all();


        
            $user = Auth::id();

         
            

            $rhtml = view('guesthouse.GuestHouseBooking')->with(['roombed'  => $roombed,'guesthouseroom' => $guesthouseroom,'dzongkhags' => $dzongkhags,
            
            'dzongkhag' => $dzongkhag,  'dzongkhag90' => $dzongkhag90,'dzongkhag2' => $dzongkhag2,'dzongkhag3' => $dzongkhag3,'dzongkhag4' => $dzongkhag4,'user' => $user])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));

        }

        //guesthouse end



        //guest house outsider start
        if ($request->v == "GuestHouseBookingOutsider")
        {
            $guesthouseroom = guesthouseroom::all();
            $roombed = guesthouseroom::all();

         

          
            
            $dzongkhags = Dzongkhags::all();
            $dzongkhag = Dzongkhags::all();
            $dzongkhag2 = Dzongkhags::all();

            $dzongkhag3 = Dzongkhags::all();

            $dzongkhag4 = Dzongkhags::all();
            $dzongkhag90 = Dzongkhags::all();


        
            $user = Auth::id();

         
            

            $rhtml = view('guesthouse.GuestHouseBookingOutsider')->with(['roombed'  => $roombed,'guesthouseroom' => $guesthouseroom,'dzongkhags' => $dzongkhags,
            
            'dzongkhag' => $dzongkhag,  'dzongkhag90' => $dzongkhag90,'dzongkhag2' => $dzongkhag2,'dzongkhag3' => $dzongkhag3,'dzongkhag4' => $dzongkhag4,'user' => $user])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));

        }

        //guesthouse end



         //guest house Self
         if ($request->v == "GuestHouseBookingSelf")
         {
             $guesthouseroom = guesthouseroom::all();
             $roombed = guesthouseroom::all();
 
          
 
           
             
             $dzongkhags = Dzongkhags::all();
             $dzongkhag = Dzongkhags::all();
             $dzongkhag2 = Dzongkhags::all();
 
             $dzongkhag3 = Dzongkhags::all();
 
             $dzongkhag4 = Dzongkhags::all();
             $dzongkhag90 = Dzongkhags::all();
 
 
         
             $user = Auth::id();
 
          
             
 
             $rhtml = view('guesthouse.GuestHouseBookingSelf')->with(['roombed'  => $roombed,'guesthouseroom' => $guesthouseroom,'dzongkhags' => $dzongkhags,
             
             'dzongkhag' => $dzongkhag,  'dzongkhag90' => $dzongkhag90,'dzongkhag2' => $dzongkhag2,'dzongkhag3' => $dzongkhag3,'dzongkhag4' => $dzongkhag4,'user' => $user])->render();
             return response()
                 ->json(array(
                 'success' => true,
                 'html' => $rhtml
             ));
 
         }
 
         //guesthouse end

//add Room and bed to old guestHouse
 if ($request->v == "addRoom")
 {


 
    $guesthouseroom = guesthouseroom::all();

 

  
    
    $dzongkhags = Dzongkhags::all();
    $dzongkhag = Dzongkhags::all();
    $dzongkhag2 = Dzongkhags::all();

    $dzongkhag3 = Dzongkhags::all();

    $dzongkhag4 = Dzongkhags::all();



    $user = Auth::id();

    $roombed = DB::table('guesthouseroom')->join('guesthousename', 'guesthousename.id', '=', 'guesthouseroom.guest_house_id')
    ->join('dzongkhags', 'dzongkhags.id', '=', 'guesthouseroom.dzo_id')  




    ->select('guesthouseroom.room_no','guesthouseroom.id as gid','dzongkhags.Dzongkhag_Name','guesthousename.name')
   
   ->latest('guesthouseroom.id') //similar to orderby('roombed.id','desc')            
    ->paginate(10000000);

 
    

    $rhtml = view('guesthouse.addRoom')->with(['roombed'  => $roombed,'guesthouseroom' => $guesthouseroom,'dzongkhags' => $dzongkhags,
    
    'dzongkhag' => $dzongkhag,'dzongkhag2' => $dzongkhag2,'dzongkhag3' => $dzongkhag3,'dzongkhag4' => $dzongkhag4,'user' => $user])->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));
 }
//add room end

        //guest house wangtsa review=1           
        if ($request->v == "ghWangtsa_review")
        {

            try{

            $wangtsaReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                                 ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                                 ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                                 ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                                
                                                 ->where('roombed.guest_house_id', 1)               
            
                                                 ->where('roombed.statusrb', 0)
                                                 ->where('roombed.id','>', 25)

                                 
                                                 ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                         
                                                ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                               ->paginate(10000000);
                                 
                                             $rhtml = view('guesthouse.wangtsaReview')->with(['wangtsaReview' => $wangtsaReview])->render();
                                             return response()
                                                 ->json(array(
                                                 'success' => true,
                                                 'html' => $rhtml
                                             ));
                                            }

                                            catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                                $wangtsaReview = DB::table('roombed')
                                                ->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                                ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                                ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                                ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                               
                                                ->where('roombed.guest_house_id', 1)               
           
                                                ->where('roombed.statusrb', 0)
                                                ->where('roombed.id','>', 25)

                                
                                                ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                               ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                                ->paginate(10000000);
                                
                                            $rhtml = view('guesthouse.wangtsaReviewE')->with(['wangtsaReview' => $wangtsaReview])->render();
                                            return response()
                                                ->json(array(
                                                'success' => true,
                                                'html' => $rhtml
                                            ));
                                             }
                                         }                                     
                                   
//guest house wangtsa review end


//guest house TMO review=2        
        if ($request->v == "ghTMO_review")
        {
        try{
            $tmoReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                                 ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                                 ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                                 ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                                 
                                                 ->where('roombed.guest_house_id', 2)               
            
                                                 ->where('roombed.statusrb', 0)
                                                 ->where('roombed.id','>', 25)

                                 
                                                 ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                                ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                                 ->paginate(10000000);
                                 
                                             $rhtml = view('guesthouse.tmoReview')->with(['tmoReview' => $tmoReview])->render();
                                             return response()
                                                 ->json(array(
                                                 'success' => true,
                                                 'html' => $rhtml
                                             ));
                                            }

                                            catch(\Facade\Ignition\Exceptions\ViewException $e) {

                                                $tmoReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                                ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                                ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                                ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                                
                                                ->where('roombed.guest_house_id', 2)               
           
                                                ->where('roombed.statusrb', 0)
                                                ->where('roombed.id','>', 25)

                                
                                                ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                               ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                                ->paginate(10000000);
                                
                                            $rhtml = view('guesthouse.tmoReviewE')->with(['tmoReview' => $tmoReview])->render();
                                            return response()
                                                ->json(array(
                                                'success' => true,
                                                'html' => $rhtml
                                            ));
                                             }
                                         }                                     
                                   
//guest house TMO review end

//guest house Dhamdum review=3       
if ($request->v == "ghDhamdum_review")
{
try{
    $dhamdumReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 3)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.dhamdhumReview')->with(['dhamdumReview' => $dhamdumReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $dhamdumReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 3)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.dhamdhumReviewE')->with(['dhamdumReview' => $dhamdumReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                                     
                           
//guest house Dhamdum review end

//guest house Jigmeling review=4     
if ($request->v == "ghJigmeling_review")
{
try{
    $jigmelingReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 4)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                         
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.jigmelingReview')->with(['jigmelingReview' => $jigmelingReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $jigmelingReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 4)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.jigmelingReviewE')->with(['jigmelingReview' => $jigmelingReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                                     
                           
//guest house Jigmeling substation review end


//guest house Dhajay review=5       
if ($request->v == "ghDhajay_review")
{
try{
    $dhajayReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 5)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                         
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.dhajayReview')->with(['dhajayReview' => $dhajayReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                         
    $dhajayReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
    ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
    ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
    ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
    
    ->where('roombed.guest_house_id', 5)               

    ->where('roombed.statusrb', 0)
    ->where('roombed.id','>', 25)


    ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
    
   ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
    ->paginate(10000000);

$rhtml = view('guesthouse.dhajayReviewE')->with(['dhajayReview' => $dhajayReview])->render();
return response()
    ->json(array(
    'success' => true,
    'html' => $rhtml
));
                                     }
                                 }                                     
                           
//guest house Dhajay review end

// //guest house Tingtibi review=6
// if ($request->v == "ghTingtibi_review")
// {
// try{
//     $tingtibiReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
//                                          ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
//                                          ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
//                                          ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
//                                          ->where('roombed.guest_house_id', 6)               
    
//                                          ->where('roombed.statusrb', 0)
//                                          ->where('roombed.id','>', 26)

                         
//                                          ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
//                                         ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
//                                          ->paginate(10000000);
                         
//                                      $rhtml = view('guesthouse.tingtibiReview')->with(['tingtibiReview' => $tingtibiReview])->render();
//                                      return response()
//                                          ->json(array(
//                                          'success' => true,
//                                          'html' => $rhtml
//                                      ));
//                                     }

//                                     catch(\Facade\Ignition\Exceptions\ViewException $e) {
//                                         $tingtibiReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
//                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
//                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
//                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
//                                         ->where('roombed.guest_house_id', 6)               
   
//                                         ->where('roombed.statusrb', 0)
//                                         ->where('roombed.id','>', 26)

                        
//                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
//                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
//                                         ->paginate(10000000);
                        
//                                     $rhtml = view('guesthouse.tingtibiReviewE')->with(['tingtibiReview' => $tingtibiReview])->render();
//                                     return response()
//                                         ->json(array(
//                                         'success' => true,
//                                         'html' => $rhtml
//                                     ));
//                                      }
//                                  }                                     
                           
// //guest house tingtibi review end

//guest house Dhajay review=6   
if ($request->v == "ghYurmoo_review")
{
try{
    $yurmooReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 6)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.yurmooReview')->with(['yurmooReview' => $yurmooReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $yurmooReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 6)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.yurmooReviewE')->with(['yurmooReview' => $yurmooReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                                     
                           
//guest house yurmoo review end


//guest house Dangapela review=7      
if ($request->v == "ghDagapela_review")
{
try{
    $dagapelaReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 7)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.dagapelaReview')->with(['dagapelaReview' => $dagapelaReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }


                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $dagapelaReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 7)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.dagapelaReviewE')->with(['dagapelaReview' => $dagapelaReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                                     
                           
//guest house Dagapela review end


//guest house TMD Transit camp review=8   
if ($request->v == "ghTMD_review")
{
try{
    $tmdReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 8)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.tmdReview')->with(['tmdReview' => $tmdReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $tmdReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 8)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.tmdReviewE')->with(['tmdReview' => $tmdReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                                     
                           
//guest house TMD Transit camp review end

//Guest House olathang Review= 9  

        if ($request->v == "ghOlathang_review")
        {
            try{
            $olathangReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                                 ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                                 ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                                 ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                                 
                                                 ->where('roombed.guest_house_id', 9)               
            
                                                 ->where('roombed.statusrb', 0)
                                                 ->where('roombed.id','>', 25)

                                 
                                                 ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                                ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                                 ->paginate(10000000);
                                 
                                             $rhtml = view('guesthouse.olathangReview')->with(['olathangReview' => $olathangReview])->render();
                                             return response()
                                                 ->json(array(
                                                 'success' => true,
                                                 'html' => $rhtml
                                             ));
                                            }

                                            catch(\Facade\Ignition\Exceptions\ViewException $e) {

                                             $olathangReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                             ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                             ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                             ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                             
                                             ->where('roombed.guest_house_id', 9)               
        
                                             ->where('roombed.statusrb', 0)
                                             ->where('roombed.id','>', 25)

                             
                                             ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                    
                                            ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                             ->paginate(10000000);
                             
                                         $rhtml = view('guesthouse.olathangReviewE')->with(['olathangReview' => $olathangReview])->render();
                                         return response()
                                             ->json(array(
                                             'success' => true,
                                             'html' => $rhtml
                                         ));
                                        }
                                         }                                     
 //end of olathang guest house review     
 
 
//Guest House pangbesa Review= 10

if ($request->v == "ghPangbesa_review")
{
    try{
        $pangbesaReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 10)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.pangbesaReview')->with(['pangbesaReview' => $pangbesaReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }
                                    catch(\Facade\Ignition\Exceptions\ViewException $e){
                                        $pangbesaReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                            ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                            ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                            ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                            
                                            ->where('roombed.guest_house_id', 10)               
    
                                            ->where('roombed.statusrb', 0)
                                            ->where('roombed.id','>', 25)

                            
                                            ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                            ->paginate(10000000);
                            
                                        $rhtml = view('guesthouse.pangbesaReviewE')->with(['pangbesaReview' => $pangbesaReview])->render();
                                        return response()
                                            ->json(array(
                                            'success' => true,
                                            'html' => $rhtml
                                        ));
                                     }
                                 }                                     
//end of pangbesa guest house review  
 
//DEOTHANG gUEST house=11
if ($request->v == "ghDeothang_review")
{
    try{
        $deothangReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 11)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.deothangReview')->with(['deothangReview' => $deothangReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }
                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                    $deothangReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 11)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.deothangReviewE')->with(['deothangReview' => $deothangReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                                     
//DEOTHANG gUEST house end
 
  
//TM Pinsa gUEST house=12
if ($request->v == "ghPinsa_review")
{
    try{
        $pinsaReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 12)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.pinsaReview')->with(['pinsaReview' => $pinsaReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }
                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $pinsaReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 12)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.pinsaReviewE')->with(['pinsaReview' => $pinsaReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                    }
                                 }                                     
//pinsa gUEST house end

 
//ESSD Tashichholing gUEST house=13
if ($request->v == "ghTashichoeling_review")
{
    try{
        $tashichoelingReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 13)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.tashichoelingReview')->with(['tashichoelingReview' => $tashichoelingReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $tashichoelingReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 13)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.tashichoelingReviewE')->with(['tashichoelingReview' => $tashichoelingReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                                     
//Tashicholling gUEST house end

 
//Dorokha gUEST house=14
if ($request->v == "ghDorokha_review")
{
 try{
    $dorokhaReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 14)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.dorokhaReview')->with(['dorokhaReview' => $dorokhaReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $dorokhaReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 14)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.dorokhaReviewE')->with(['dorokhaReview' => $dorokhaReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                                     
//dorokha gUEST house end

//Kewathang gUEST house=15
if ($request->v == "ghKewathang_review")
{
try{
    $kewathangReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 15)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.kewathangReview')->with(['kewathangReview' => $kewathangReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $kewathangReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 15)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.kewathangReviewE')->with(['kewathangReview' => $kewathangReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                                     
//Kewathang gUEST house end


        //Guest House Garpang Review=16

        if ($request->v == "ghGarpang_review")
        {
            try{
            $garpangReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                                 ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                                 ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                                 ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                                 
                                                 ->where('roombed.guest_house_id', 16)               
            
                                                 ->where('roombed.statusrb', 0)
                                                 ->where('roombed.id','>', 25)

                                 
                                                 ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                                ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                                 ->paginate(10000000);
                                 
                                             $rhtml = view('guesthouse.garpangReview')->with(['garpangReview' => $garpangReview])->render();
                                             return response()
                                                 ->json(array(
                                                 'success' => true,
                                                 'html' => $rhtml
                                             ));
                                            }

                                            catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                                $garpangReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                                ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                                ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                                ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                                
                                                ->where('roombed.guest_house_id', 16)               
           
                                                ->where('roombed.statusrb', 0)
                                                ->where('roombed.id','>', 25)

                                
                                                ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                               ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                                ->paginate(10000000);
                                
                                            $rhtml = view('guesthouse.garpangReviewE')->with(['garpangReview' => $garpangReview])->render();
                                            return response()
                                                ->json(array(
                                                'success' => true,
                                                'html' => $rhtml
                                            ));
                                             }
                                         }                               
                                    
         
//end of garpang guest house review
                                        
 

//chumey GH=17
if ($request->v == "ghChumey_review")
{
    try{

    $chumeyReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 

                                         ->where('roombed.guest_house_id', 17)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.chumeyReview')->with(['chumeyReview' => $chumeyReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }
              catch(\Facade\Ignition\Exceptions\ViewException $e){
                $chumeyReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 

                ->where('roombed.guest_house_id', 17)               

                ->where('roombed.statusrb', 0)
                ->where('roombed.id','>', 25)


                ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
               
               ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                ->paginate(10000000);

            $rhtml = view('guesthouse.chumeyReviewE')->with(['chumeyReview' => $chumeyReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
    }                       
                                 }                               
                            
 //end of chumey guest house review

 //ESD Wangdue GH=18
if ($request->v == "ghESDwangdue_review")
{
try{
    $wangdueReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 18)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.wangdueReview')->with(['wangdueReview' => $wangdueReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $wangdueReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 18)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.wangdueReviewE')->with(['wangdueReview' => $wangdueReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                               
                            
 //end of wangdue guest house review

 //chumey GH=
if ($request->v == "ghTangmachu_review")
{
    try{

    $tangmachuReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 19)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.tangmachuReview')->with(['tangmachuReview' => $tangmachuReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $tangmachuReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 19)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.tangmachuReviewE')->with(['tangmachuReview' => $tangmachuReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                               
                            
 //end of tangmachu guest house review
                                      
 //phuentsholing GH=20
if ($request->v == "ghPhuentsholing_review")
{
try{
    $phuentsholingReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 20)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.phuentsholingReview')->with(['phuentsholingReview' => $phuentsholingReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $phuentsholingReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 20)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.phuentsholingReviewE')->with(['phuentsholingReview' => $phuentsholingReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                               
                            
 //end of phuentsholing guest house review
 
 //Transit Camp GH=21
if ($request->v == "ghTransitCamp_review")
{
    try{

    $transitCampReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag') 
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 21)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.transitCampReview')->with(['transitCampReview' => $transitCampReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }
                                

                         
                     
                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $transitCampReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag') 
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 21)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.transitCampReviewE')->with(['transitCampReview' => $transitCampReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                               
                            
 //end of transitCamp guest house review   
 
 // Kilikhar GuestHouse  id=22
if ($request->v == "ghkilikhar_review")
{
    try{

    $kilikharReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag') 
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 22)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.kilikharReview')->with(['kilikharReview' => $kilikharReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }
                                

                         
                     
                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $transitCampReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag') 
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 22)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.kilikharReviewE')->with(['kilikharReview' => $kilikharReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                               
                            
 //kilikhar guest house review   

 // Kanglung GuestHouse  id=23
if ($request->v == "ghkanglung_review")
{
    try{

    $kanglungReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag') 
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 23)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.kanglungReview')->with(['kanglungReview' => $kanglungReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }
                                

                         
                     
                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $transitCampReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag') 
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 23)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.kanglungReviewE')->with(['kanglungReview' => $kanglungReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                               
                            
 // end of kanglung guest house review   

// nangkhor GuestHouse  id=24
if ($request->v == "ghnangkhor_review")
{
    try{

    $nangkhorReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag') 
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 24)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.nangkhorReview')->with(['nangkhorReview' => $nangkhorReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }
                                

                         
                     
                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $transitCampReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag') 
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 24)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.nangkhorReviewE')->with(['nangkhorReview' => $nangkhorReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                               
                            
 // end of nangkhor guest house review   


 // nganglam guesthouse review  gh id =25

if ($request->v == "ghnganglam_review")
{
    try{

    $nganglamReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag') 
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 25)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.nganglamReview')->with(['nganglamReview' => $nganglamReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }
                                

                         
                     
                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $nganglamReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag') 
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 25)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.nganglamReviewE')->with(['nganglamReview' => $nganglamReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                               
                            
 //end of nganglam guesthouse  review   

     
 //final GM AFTER MTO
 if ($request->v == "MTOGM_Review")
        
 {  
     $id = vehiclerequest::all();

     $mtoGM = DB::table('vehiclerequest')->join('vehicledetails', 'vehiclerequest.vehicleId', '=', 'vehicledetails.id')

        ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
         ->join('users', 'users.id', '=', 'vehiclerequest.supervisor') //pull gm's name
     
     
         
         ->where('vehiclerequest.status', 4)
         ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.dateOfRequisition', 'vehicledetails.vehicle_name', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit', 'users.name', 'users.designation')
         
         ->latest('vehiclerequest.id') //similar to orderby('vehiclerequest.id','desc')
     
         ->paginate(10000000);

     $rhtml = view('vehicle.generalManagerReview')->with(['mtoGM' => $mtoGM])->render();
     return response()
         ->json(array(
         'success' => true,
         'html' => $rhtml
     ));
 }  
 //END mto GM
                  
 
 //return GM AFTER MTO
 if ($request->v == "Return_Review")
        
 {  
     $id = vehiclerequest::all();

     $returnGM = DB::table('vehiclerequest')->join('vehicledetails', 'vehiclerequest.vehicleId', '=', 'vehicledetails.id')

        ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
         ->join('users', 'users.id', '=', 'vehiclerequest.supervisor') //pull gm's name
     
     
         
         ->where('vehiclerequest.status', 6)  //approve
         ->orwhere('vehiclerequest.status', 5) //rejected
         
         ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'vehiclerequest.status','vehiclerequest.reason','orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.dateOfRequisition', 'vehicledetails.vehicle_name', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit', 'users.name', 'users.designation')
         
         ->latest('vehiclerequest.id') //similar to orderby('vehiclerequest.id','desc')
     
         ->paginate(10000000);

     $rhtml = view('vehicle.ReturnReview')->with(['returnGM' => $returnGM])->render();
     return response()
         ->json(array(
         'success' => true,
         'html' => $rhtml
     ));
 } 
 
 //END return  mto GM

     //CMDPO Review
           if ($request->v == "CMDPO_Review")
        
         {

          $cmdpoReview = DB::table('vehiclerequest')
              ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
          // ->join('users','users.id','=','vehiclerequest.supervisor')//pull users designation
          

              ->where('vehiclerequest.org_unit_id', 73) //field id
          
              ->where('vehiclerequest.status', 0)
              
              ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.designationVf','vehiclerequest.vname', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit', 'vehiclerequest.personalvehicle')

              ->latest('vehiclerequest.id') //similar to orderby('vehiclerequest.id','desc')
          
              ->paginate(10000000);

          $rhtml = view('vehicle.CMDPO_Review')->with(['cmdpoReview' => $cmdpoReview])->render();
          return response()
              ->json(array(
              'success' => true,
              'html' => $rhtml
          ));
      } 
     
     //end of cdmpo
     
      //ICD REview
        if ($request->v == "ICD_Review")
        
        {

            $IcdReview = DB::table('vehiclerequest')
                ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
            // ->join('users','users.id','=','vehiclerequest.supervisor')//pull users designation
            

                ->where('vehiclerequest.org_unit_id', 44) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 45)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 46)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 61)
                ->where('vehiclerequest.status', 0)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.designationVf','vehiclerequest.vname', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit', 'vehiclerequest.personalvehicle')

                ->latest('vehiclerequest.id') //similar to orderby('vehiclerequest.id','desc')
            
                ->paginate(10000000);

            $rhtml = view('vehicle.ICD_Review')->with(['IcdReview' => $IcdReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of ICD Review


        //TD REview
        if ($request->v == "TD_Review")
        {

            $TdReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')

                ->where('vehiclerequest.org_unit_id', 19) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 20)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 21)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 22)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 23)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 53)
                ->where('vehiclerequest.status', 0)
                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.TD_Review')->with(['TdReview' => $TdReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of TD Review
        

        //TCD Review
        if ($request->v == "TCD_Review")
        {

            $TcdReview = DB::table('vehiclerequest')                
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                ->where('vehiclerequest.org_unit_id', 54) //field i
            
                ->where('vehiclerequest.status', 0)
                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date','vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.TCD_Review')->with(['TcdReview' => $TcdReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of TCD Review
        

        //DCD REview
        if ($request->v == "DCD_Review")
        {

            $DcdReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                ->where('vehiclerequest.org_unit_id', 24) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 25)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 26)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 27)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 55)
                ->where('vehiclerequest.status', 0)
                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date',  'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.DCD_Review')->with(['DcdReview' => $DcdReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of DCD Review
        //DCSD REview
        if ($request->v == "DCSD_Review")
        {

            $DcsdReview = DB::table('vehiclerequest')                
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                ->where('vehiclerequest.org_unit_id', 28) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 29)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 30)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 31)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 32)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 56)
                ->where('vehiclerequest.status', 0)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.DCSD_Review')->with(['DcsdReview' => $DcsdReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of DCSD Review
        //HRAD REview
        if ($request->v == "HRAD_Review")
        {

            $HradReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')

                ->where('vehiclerequest.org_unit_id', 33) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 34)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 35)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 57)
                ->where('vehiclerequest.status', 0)
                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date',  'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.HRAD_Review')->with(['HradReview' => $HradReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of HRAD Review
        

        // For sbsf Review
        if ($request->v == "SFSB_Review")
        {

            $sfsbReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                // ->where('vehiclerequest.org_unit_id', 36) //field id
            
                // ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 59)
                ->where('vehiclerequest.status', 0)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date','vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.SFSB_Review')->with(['sfsbReview' => $sfsbReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } ///end of sbsf view

        // for PSD Review
        if ($request->v == "PSD_Review")
        {

            $psdReview = DB::table('vehiclerequest')

            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')

                ->where('vehiclerequest.org_unit_id', 37) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 38)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 39)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 58)
                ->where('vehiclerequest.status', 0)
                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.PSD_Review')->with(['psdReview' => $psdReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }
        //end of PSD Review
        

        //  For ERD Review
        if ($request->v == "ERD_Review")
        {

            $erdReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                ->where('vehiclerequest.org_unit_id', 41) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 42)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 43)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 60)
                ->where('vehiclerequest.status', 0)
                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.ERD_Review')->with(['erdReview' => $erdReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } // end of ERD Review
        

        //  For SPBD Review
        if ($request->v == "SPBD_Review")
        {

            $spbdReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                ->where('vehiclerequest.org_unit_id', 47) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 48)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 62)
                ->where('vehiclerequest.status', 0)
            //  ->orwhere('org_unit_id',43)
            
                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.SPBD_Review')->with(['spbdReview' => $spbdReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } // end of SPBD Review
        

        //Transmission services REview
        if ($request->v == "TS_Review")
        {

            $tsReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                ->where('vehiclerequest.org_unit_id', 10) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 11)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 63)
                ->where('vehiclerequest.status', 0)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date','vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.TS_Review')->with(['tsReview' => $tsReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of Transmission service
        

        //Distribution services REview
        if ($request->v == "DS_Review")
        {

            $dsReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')

                ->where('vehiclerequest.org_unit_id', 12) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 13)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 64)
                ->where('vehiclerequest.status', 0)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.DS_Review')->with(['dsReview' => $dsReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of d service
        

        //HRCS services REview
        if ($request->v == "HRCS_Review")
        {

            $hrcsReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')

                ->where('vehiclerequest.org_unit_id', 14) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 15)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 16)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 65)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 36)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 40)
                ->where('vehiclerequest.status', 0)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.HRCS_Review')->with(['hrcsReview' => $hrcsReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of HRCS service
        //Finance A services REview
        if ($request->v == "FAS_Review")
        {

            $fasReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                ->where('vehiclerequest.org_unit_id', 49) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 50)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 51)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 66)
                ->where('vehiclerequest.status', 0)
                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date',  'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.FAS_Review')->with(['fasReview' => $fasReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of Finance A services REview
        

        //STS REview
        if ($request->v == "STS_Review")
        {

            $stsReview = DB::table('vehiclerequest')

            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                ->where('vehiclerequest.org_unit_id', 17) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 18)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 9)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 67)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 72)
                ->where('vehiclerequest.status', 0)
        
                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.STS_Review')->with(['stsReview' => $stsReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end STS
        //BPSO REview
        if ($request->v == "BPSO_Review")
        {

            $bpsoReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')

                ->where('vehiclerequest.org_unit_id', 68) //field id
            
                ->where('vehiclerequest.status', 0)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.BPSO_Review')->with(['bpsoReview' => $bpsoReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of BPSO
        

        //INTERNAL AUDIT REview
        if ($request->v == "IAD_Review")
        {

            $iadReview = DB::table('vehiclerequest')

            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                ->where('vehiclerequest.org_unit_id', 69) //field id
            
                ->where('vehiclerequest.status', 0)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.IAD_Review')->with(['iadReview' => $iadReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of IAD
        

        //CEO Review
        if ($request->v == "DIR_Review")
        {

            $dirReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                ->where('vehiclerequest.org_unit_id', 3) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 4)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 5)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 6)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 7)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 8)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 70)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 52)
                ->where('vehiclerequest.status', 0)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date','vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.DIR_Review')->with(['dirReview' => $dirReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of DIR REview
        

        //MTO review
        if ($request->v == "MTO_Review")
        {
            try{

            $id = vehiclerequest::all();

            $mtoReview = DB::table('vehiclerequest')->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
            //  ->join('users','users.id','=','vehiclerequest.supervisor')
            
                ->join('users', 'users.id', '=', 'vehiclerequest.supervisor') //pull gm's name
            
                ->where('vehiclerequest.status', 2)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.dateOfRequisition','vehiclerequest.purpose', 'vehiclerequest.placesToVisit', 'users.name', 'users.designation','vehiclerequest.personalvehicle')
                ->orderBy('vehiclerequest.id', 'desc')
                ->paginate(10000000);

            $details = Vehicles::all()
            ->where('status',0); 
            // show only vehicle with status 0 which is available ,1 is deleted vehicle status



            $rhtml = view('vehicle.MTO_Review')->with(['mtoReview' => $mtoReview, 'id' => $id, 'details' => $details])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } 
        //end of DIR REview
        catch(\Facade\Ignition\Exceptions\ViewException $e)
        {

            $id = vehiclerequest::all();

            $mtoReview = DB::table('vehiclerequest')->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
            //  ->join('users','users.id','=','vehiclerequest.supervisor')
            
                // ->join('vehicledetails', 'vehicledetails.id', '=', 'vehiclerequest.vehicleId')
                ->join('users', 'users.id', '=', 'vehiclerequest.supervisor') //pull gm's name
            
                ->where('vehiclerequest.status', 2)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.dateOfRequisition','vehiclerequest.purpose', 'vehiclerequest.placesToVisit', 'users.name', 'users.designation','vehiclerequest.personalvehicle')
                ->orderBy('vehiclerequest.id', 'desc')
                ->paginate(10000000);

            $details = Vehicles::all();

            $rhtml = view('vehicle.vehicle_reviewe')->with(['mtoReview' => $mtoReview, 'id' => $id, 'details' => $details])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));

        }
    }
//mto review end

        //MTO edit review
        if ($request->v == "MTO_EditReview")
        {
            try{

            $id = vehiclerequest::all();

            $mtoEditReview = DB::table('vehiclerequest')->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
            //  ->join('users','users.id','=','vehiclerequest.supervisor')
            
                ->join('users', 'users.id', '=', 'vehiclerequest.supervisor') //pull gm's name
            
                ->where('vehiclerequest.status', 4)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.dateOfRequisition','vehiclerequest.purpose', 'vehiclerequest.placesToVisit', 'users.name', 'users.designation','vehiclerequest.personalvehicle')
                ->orderBy('vehiclerequest.id', 'desc')
                ->paginate(10000000);

            $details = Vehicles::all();

            $rhtml = view('vehicle.MTO Edit View')->with(['mtoEditReview' => $mtoEditReview, 'id' => $id, 'details' => $details])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } 
        
        catch(\Facade\Ignition\Exceptions\ViewException $e)
        {

            $id = vehiclerequest::all();

            $mtoEditReview = DB::table('vehiclerequest')->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
            //  ->join('users','users.id','=','vehiclerequest.supervisor')
            
                // ->join('vehicledetails', 'vehicledetails.id', '=', 'vehiclerequest.vehicleId')
                ->join('users', 'users.id', '=', 'vehiclerequest.supervisor') //pull gm's name
            
                ->where('vehiclerequest.status', 4)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.dateOfRequisition','vehiclerequest.purpose', 'vehiclerequest.placesToVisit', 'users.name', 'users.designation','vehiclerequest.personalvehicle')
                ->orderBy('vehiclerequest.id', 'desc')
                ->paginate(10000000);

            $details = Vehicles::all();

            $rhtml = view('vehicle.vehicle_reviewe')->with(['mtoEditReview' => $mtoEditReview, 'id' => $id, 'details' => $details])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));

        }
    }
//mto edit review end


        //view for manage conference
        if ($request->v == "manage_conference")
        {

            $conference = conference::all();
            $review = DB::table('conference')
                ->where('status_c','0')
                ->paginate();

            $rhtml = view('conference.manage_conference')->with(['review' => $review,
            
            'conference' => $conference])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }

        //end for view  manage conference

// view for Reports

if ($request->v == "vehicleReport")
{
    $id = vehiclerequest::all();

    $reports = DB::table('vehiclerequest')->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
    //  ->join('users','users.id','=','vehiclerequest.supervisor')
    
        ->join('vehicledetails', 'vehicledetails.id', '=', 'vehiclerequest.vehicleId')
        ->join('users', 'users.id', '=', 'vehiclerequest.supervisor') //pull gm's name
    
        // ->where('vehiclerequest.status', 0)

        ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.dateOfRequisition', 'vehicledetails.vehicle_name', 'vehiclerequest.purpose', 'vehiclerequest.status', 'vehiclerequest.placesToVisit', 'users.name', 'users.designation')
        ->orderBy('vehiclerequest.id', 'desc')
        ->paginate(10000000);

    $details = Vehicles::all();

    $rhtml = view('vehicle.reports')->with(['reports' => $reports, 'id' => $id, 'details' => $details])->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));
} 
    //end of IAD      

//view for manage vehicle
 //view for manage conference

 if ($request->v == "manage_vehicle")
 {

    //  $conference = vehicles::all();
    //  $review = DB::table('vehicledetails')->select('*')
    //      ->paginate();

     $rhtml = view('vehicle.manage_vehicle')->render();
     return response()
         ->json(array(
         'success' => true,
         'html' => $rhtml
     ));
 }

 //view for manage resignation
 
 if ($request->v == "resignationtypemaster")
 {
     $rhtml = view('masterData.resignationMaster')->render();
     return response()
         ->json(array(
         'success' => true,
         'html' => $rhtml
     ));
 }

 //view for manage designation

 if ($request->v == "designationmaster")
 {
     $rhtml = view('masterData.designationMaster')->render();
     return response()
         ->json(array(
         'success' => true,
         'html' => $rhtml
     ));
 }

 //view for manage company

 if ($request->v == "companymaster")
 {
     $rhtml = view('masterData.companyMaster')->render();
     return response()
         ->json(array(
         'success' => true,
         'html' => $rhtml
     ));
 }

  //view for manage leave type
 
  if ($request->v == "leavetypemaster")
  {
      $rhtml = view('masterData.leavetypeMaster')->render();
      return response()
          ->json(array(
          'success' => true,
          'html' => $rhtml
      ));
  }


//manage guesthouse
if ($request->v == "manage_guesthouse")
 {

     $conference = guesthouse::all();
     $dzongkhags = Dzongkhags::all();
     $review = DB::table('guesthousename')->select('*')
         ->paginate();

     $rhtml = view('guesthouse.manage_guesthouse')->with(['review' => $review,'dzongkhags'=>$dzongkhags])->render();
     return response()
         ->json(array(
         'success' => true,
         'html' => $rhtml
     ));
 }

 //manage guesthouse room details
if ($request->v == "room_details")
{

    $dzongkhags = Dzongkhags::all();
    $review = DB::table('guesthouseroom')->select('*')
        ->paginate();

    $rhtml = view('guesthouse.room_details')->with(['review' => $review,'dzongkhags'=>$dzongkhags])->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));
}
 //conference reprts
 if ($request->v == "cReports")
       {
                $conference = conference::all();

                $review = DB::table('conferencerequest')->join('orgunit', 'orgunit.id', '=', 'conferencerequest.org_unit_id')
                
                   
                     
                    ->join('conference', 'conference.id', '=', 'conferencerequest.conference_id')
                    ->where('status', 1)
                    ->where('conference_id', '1')
                   
                    ->orwhere('conference_id', '1')
                    ->where('status', 2) 
                    ->where('default',)                   

                    ->orwhere("conference_id", "2")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "3")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "4")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere('conference_id', "5")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "6")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "7")
                    ->where('status', 0)
                    ->where('default',)

                    ->select('conferencerequest.id', 'emp_id', 'name','contact_number','conferencerequest.conference_id', 'orgunit.description', 'conference.Conference_Name', 'meeting_name', 'conference_id', 'start_date', 'end_date','status')

                    ->latest('id') //similar to orderby('id','desc')
                
                
                    ->paginate(50);

                $rhtml = view('conference.conferenceReport')->with(['review' => $review, 'conference' => $conference])->render();
                return response()
                    ->json(array(
                    'success' => true,
                    'html' => $rhtml
                ));
            }
            //end report confrerences


        //view board room
        if ($request->v == "boardroom_review")
        {

            $conference = conference::all();
            $review = DB::table('conferencerequest')->join('orgunit', 'orgunit.id', '=', 'conferencerequest.org_unit_id')
            // ->join('division_tbl','division_tbl.id','=','conferencerequest.div_id')
            // ->join('wing_tbl','wing_tbl.id','=','conferencerequest.wing_id')
            // ->join('department_tbl','department_tbl.id','=','conferencerequest.dept_id')
            
            // ->join('rangeofpeople', 'rangeofpeople.id', '=', 'conferencerequest.no_of_people') 
                ->join('conference', 'conference.id', '=', 'conferencerequest.conference_id')

                ->where('status', 0)
                ->where('conference_id', '1')
                ->where('default',)

            // ->orWhere('conference_id','=','5')
            // ->Where('status','=','0')
            
                ->select('conferencerequest.id', 'emp_id', 'name','contact_number', 'conference.Conference_Name','conferencerequest.conference_id', 'orgunit.description', 'meeting_name', 'start_date', 'end_date')
                ->latest('id')

                ->paginate(50);

            $rhtml = view('conference.boardroom_review')->with(['review' => $review, 'conference' => $conference])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }
        //view status in admin(frontdesk)
        if ($request->v == "booking_review")
        {

            try
            {

                $conference = conference::all();

                $review = DB::table('conferencerequest')->join('orgunit', 'orgunit.id', '=', 'conferencerequest.org_unit_id')
                // ->join('rangeofpeople', 'rangeofpeople.id', '=', 'conferencerequest.no_of_people') 
                    ->join('conference', 'conference.id', '=', 'conferencerequest.conference_id')
                    ->where('status', 1)
                    ->where('conference_id', '1')

                    ->orwhere("conference_id", "2")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "3")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "4")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere('conference_id', "5")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "6")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "7")
                    ->where('status', 0)
                    ->where('default',)

                    ->select('conferencerequest.id', 'emp_id', 'name','contact_number','conferencerequest.conference_id', 'orgunit.description', 'conference.Conference_Name', 'meeting_name', 'conference_id', 'start_date', 'end_date')

                    ->latest('id') //similar to orderby('id','desc')
                

                
                    ->paginate(50);

                $rhtml = view('conference.booking_review')->with(['review' => $review, 'conference' => $conference])->render();
                return response()
                    ->json(array(
                    'success' => true,
                    'html' => $rhtml
                ));

                
            }

            catch(\Facade\Ignition\Exceptions\ViewException $e)
            {  

                $conference = conference::all();

                $review = DB::table('conferencerequest')->join('orgunit', 'orgunit.id', '=', 'conferencerequest.org_unit_id')
                // ->join('rangeofpeople', 'rangeofpeople.id', '=', 'conferencerequest.no_of_people') 
                    ->join('conference', 'conference.id', '=', 'conferencerequest.conference_id')
                    ->where('status', 1)
                    ->where('conference_id', '1')

                    ->orwhere("conference_id", "2")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "3")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "4")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere('conference_id', "5")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "6")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "7")
                    ->where('status', 0)
                    ->where('default',)

                    ->select('conferencerequest.id', 'emp_id', 'name','contact_number','conferencerequest.conference_id', 'orgunit.description', 'conference.Conference_Name', 'meeting_name', 'conference_id', 'start_date', 'end_date')

                    ->latest('id') //similar to orderby('id','desc')
                

                
                    ->paginate(50);

                $rhtml = view('conference.booking_reviewe')->with(['review' => $review, 'conference' => $conference])->render();
                return response()
                    ->json(array(
                    'success' => true,
                    'html' => $rhtml
                ));
                

            }
        }
        //change password for frontdesk and secretary
        if ($request->v == "changepassword")
        {

            $rhtml = view('changepassword')->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }

        //change password for frontdesk and secretary
        if ($request->v == "resetpassword")
        {

            $rhtml = view('auth.resetpassword')->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }

        //user add for login
        if ($request->v == "user")
        {

            $user = Auth::user();
            $grade = Grade::all();
            $dzongkhag = Dzongkhags::all();
            $orgunit = orgunit::all();
            $roles = roles::all();



          
            $rhtml = view('super admin.user')->with(['roles' => $roles, 'orgunit' => $orgunit,'dzongkhag' => $dzongkhag,'grade' => $grade])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));

        }


           //role add from admin
           if ($request->v == "roleAdd")
           {
   
              
              
               
   
               
   
               $rhtml = view('super admin.roleAdd')->render();
               return response()
                   ->json(array(
                   'success' => true,
                   'html' => $rhtml
               ));
   
           }

        //user delete for login
        if ($request->v == "userdelete")
        {
            $user = Auth::user();

            $roles = $user->role;
            $role_admin = false;
            foreach ($roles as $role)
            {
                if ($role->name == "Admin")
                {
                    $role_admin = true;
                }
            }
            //admin to add user from any dzongkhags and any roles.
            if ($role_admin)
            {
                $roles = Roles::all();
                $dzongkhags = Dzongkhags::all();
            }
            else
            {
                $roles = Roles::wherein('role_admin', $user->role)
                    ->get();
                $dzongkhags = Dzongkhags::where('id', $user->dzongkhag_id)
                    ->get();
            }

            $rhtml = view('super admin.userdelete')->with(['roles' => $roles, 'dzongkhags' => $dzongkhags])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }

        //vehicle review by supervisor
        if ($request->v == "vehicle_review")
        {

            $vehicle = vehicles::all();

            $review = DB::table('vehiclerequest')->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')

            // ->join('division_tbl','division_tbl.id','=','conferencerequest.div_id')
            // ->join('wing_tbl','wing_tbl.id','=','conferencerequest.wing_id')
            // ->join('department_tbl','department_tbl.id','=','conferencerequest.dept_id')
            
                ->join('vehicledetails', 'vehicledetails.id', '=', 'vehiclerequest.vehicleId')

                ->select('vehicledetails.id', 'emp_id', 'name', 'designation', 'vehiclerequest.vehicleId', 'orgunit.description', 'vehicledetails.vehicle_name', 'vehicle_number', 'vehicleId', 'start_date', 'end_date', 'purpose', 'placesToVisit', 'supervisor', 'mto')

                ->latest('id') //similar to orderby('id','desc')
            

            
                ->paginate(50);

            $rhtml = view('vehicle.vehicle_review')->with(['review' => $review, 'vehicle' => $vehicle])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }

        //employeemaster
         //user add for login
         if ($request->v == "employeemaster")
         {
 
             $user = Auth::user();
             $grade = Grade::all();
             $dzongkhag = Dzongkhags::all();
             $orgunit = orgunit::all();
             $roles = roles::all();
 
 
 
           
             $rhtml = view('masterData.employeeMaster')->with(['roles' => $roles, 'orgunit' => $orgunit,'dzongkhag' => $dzongkhag,'grade' => $grade])->render();
             return response()
                 ->json(array(
                 'success' => true,
                 'html' => $rhtml
             ));
 
         }

        //endemployeemaster


         //officeName
         if ($request->v == "officename")
         {
 
            
 
 
 
           
             $rhtml = view('masterData.officeName')->render();
             return response()
                 ->json(array(
                 'success' => true,
                 'html' => $rhtml
             ));
 
         }

        //end officeName

    }

}

