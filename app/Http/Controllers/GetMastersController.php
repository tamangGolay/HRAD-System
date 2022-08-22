<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\conference;
use App\conferencebook;
use App\rangeofpeople;

use Hash;

class GetMastersController extends Controller
{
    //
    public function __constructor(Request $request)
    {

    }

    public function getValues(Request $request)
    {
        //check if token passed is matching with the session and the input.
        $token = $request->token;
        $stoken = $request->session()
            ->token();

        //  if($token != $stoken)
        //  {
        //       return response(null);
        //  }
        $table = $request->get('source');
        $value = $request->get('info');

        if ($table == 'gewogs')
        {
            $gewogs = DB::table('gewogs_tbl')->where('dzongkhag_id', $value)->select('id', 'gewog_name')
                ->get();

            return response()
                ->json($gewogs);
        }
        //to check details of FR to be used while collecting sample.
        

        if ($table == "checkout")
        {

            //check cid if already in database.
            if (DB::table('tbl_check_in')->where('tbl_check_in.cid_passport_no', $value)->exists())
            {
                $checkin = DB::table('tbl_check_in')->where('tbl_check_in.cid_passport_no', $value)->where('tbl_check_in.checkout_status', 0)
                    ->select('tbl_check_in.facility_id', 'tbl_check_in.id', 'tbl_check_in.name', 'tbl_check_in.gender', 'tbl_check_in.room_no', 'tbl_check_in.date_of_arrival', 'tbl_check_in.quarantine')
                    ->get();

                return response()
                    ->json($checkin);

            }
            else
            {
                return response()->json(['code' => '200', 'failed' => 'Check your cid!']);

            }

        }

// pull name form users table

if ($table == "paymentInfo")
        {

            //check cid if already in database.

            if (DB::table('users')->where('users.empId', $value)->exists())
            {
                $emp = DB::table('users')->where('users.empId', $value)
                    ->select('users.empName','users.empId')
                    ->get();

                return response()
                    ->json($emp);

            }
            else
            {
                return response()->json(['code' => '200', 'failed' => 'Check your Emp_id!']);

            }

        }

         if ($table == "user_profile")
        {

            
          //check cid if already in database.
            if (DB::table('users')->where('users.empId', $value)->exists())
            {
               

$emp = DB::table('users')
->join('designationmaster','designationmaster.id', 'users.designationId')
->join('officedetails','officedetails.id', 'users.office')
->join('payscalemaster','payscalemaster.id', 'users.gradeId')
// ->join('employeequalificationmaster','employeequalificationmaster.personalNo', 'users.id')
// ->join('qualificationmaster','qualificationmaster.id', 'employeequalificationmaster.qualificationId')
//  ->join('qualification','qualification.empId', 'users.id')

->select('users.*','designationmaster.desisNameLong','officedetails.id',
'officedetails.Address','officedetails.shortOfficeName','payscalemaster.grade'
)


->where('users.empId', $value)->get();  
                return response()
                    ->json($emp);

            }
            else
            {
                return response()->json(['code' => '200', 'failed' => 'Check your Emp_id!']);

            }

        }
        if ($table == "jobDescription")
        {

            
          //check cid if already in database.
            if (DB::table('users')->where('users.empId', $value)->exists())
            {
               

$emp = DB::table('users')
->where('users.empId', $value)
->join('jobdescription', 'jobdescription.empId', '=', 'users.empId') 
// ->join('designationmaster','designationmaster.id', 'users.designationId')
->join('officedetails','officedetails.id', 'users.office')

->select('jobdescription.*','users.empName','officedetails.longOfficeName'
)
->get();  
                return response()
                    ->json($emp);
              dd($emp);     
            }
            else
            {
                return response()->json(['code' => '200', 'failed' => 'Check your Emp_id!']);

            }

        }
        if ($table == "booking_review")
        {

            //check cid if already in database.
            if (DB::table('conferencerequest'))
            {
                $emp = DB::table('conferencerequest')->join('conference', 'conferencerequest.conference_id', '=', 'conference.id')
                    ->select('conferencerequest.id', 'conferencerequest.name', 'conferencerequest.contact_number', 'conferencerequest.meeting_name', 'conferencerequest.start_date', 'conferencerequest.end_date','conference.Conference_Name'
)
                    ->paginate(5);

                return response()
                    ->json($emp);

            }
            else
            {
                return response()->json(['code' => '200', 'failed' => 'Check your Emp_id!']);

            }

        }

        if ($table == 'division')
        {
            $division = DB::table('division_tbl')->where('Department_id', $value)->select('id', 'Division_name')
                ->get();

            return response()
                ->json($division);
        }

        if ($table == 'subagency')
        {
            $subagency = DB::table('subagencies_tbl')->where('agency_id', $value1)->select('id', 'name')
                ->get();

            return response()
                ->json($subagency);
        }

        //For check box
        if ($table == "forms")
        {
            $formlist = DB::table('forms')
            ->select('forms.description', 
            DB::raw("(select form_id from roleformmapping where roleformmapping.form_id = forms.id and roleformmapping.role_id=" . $value . ") as formid"))
            ->get();

            return response()
                ->json($formlist);
        }


        
        //get list of green houses of a given dzongkhag.
        if($table == "facilities")
        {
            $facilities = DB::table('guesthousename')
		    		->where('dzo_id',$value)
	    			->where('status',0)
                            ->select('id','name')
                            ->get();

            return response()->json($facilities);


        }
//rangeof people
        if($table == "people")
        {
            if($value == 1){

                $facilities = DB::table('conference')
                ->select('id','Conference_Name')

		    		// ->select('id','Conference_Name')
                    ->where('status_c',0)
                    ->orwhere('id',4)
                    ->where('status_c',0)
                    ->orwhere('id',2)
                    ->where('status_c',0)
                    ->orwhere('id',1)
                    ->where('status_c',0)
                    ->orwhere('id',5)
                    ->where('status_c',0)                
                    ->orwhere('id',3)                   

                    ->orderby('capacity')
                    // ->where('status_c',0)
                   ->get();

            }

            if($value == 2){

                $facilities = DB::table('conference')
                ->select('id','Conference_Name')

		    		// ->select('id','Conference_Name')
                    ->where('status_c',0)
                    ->orwhere('id',4)

                    ->where('status_c',0)
                    ->orwhere('id',2)

                    ->where('status_c',0)
                    ->orwhere('id',1)

                    ->where('status_c',0)
                    ->orwhere('id',5)

                    ->where('status_c',0)
                    ->orwhere('id',3)


                   ->get();

            }

            if($value == 3){
                $facilities = DB::table('conference')
                ->select('id','Conference_Name')

                    ->where('status_c',0)
                    ->orwhere('id',3)
                    ->where('status_c',0)
                    ->orwhere('id',5)
                    ->where('status_c',0)
                    ->orwhere('id',4)
                    ->where('status_c',0)
                    ->orwhere('id',1)
                    ->where('status_c',0)
                    ->orwhere('id',2)
                    ->orderby('capacity','desc')                  


                   ->get();

            }
            
            

            return response()->json($facilities);

            
        }

         //get list of green houses of a given dzongkhag for self.
         if($table == "facilitiesSelf")
         {
             $facilities = DB::table('guesthousename')
                     ->where('dzo_id',$value)
                     ->where('status',0)
                             ->select('id','name')
                             ->get();
 
             return response()->json($facilities);
         }

         if ($table == "forgetPassword")
        {

            //check cid if already in database.
            if (DB::table('users')->where('users.empId', $value)->exists())
            {
                $emp = DB::table('users')->where('users.empId', $value)
                ->select('users.emailId')
                    ->get();

                return response()
                    ->json($emp);

            }
            else
            {
                return response()->json(['code' => '200', 'failed' => 'Check your Emp_id!']);

            }

        }

        //For user add ; to check if the user already exist
        if ($table == 'useradd')
        {

            //check cid if already in database.
            if (DB::table('users')->where('users.empId', $value)->exists())
            {
                $emp = DB::table('users')
            ->select('users.empId'
            )
                    ->get();

                return response()
                    ->json($emp);

            }
            else
            {
                return response()->json(['code' => '200', 'failed' => 'Check your Emp_id!']);

            }

        }//end


        //welfare refund check with release table
        if ($table == 'checkrefund')
        {

            //check empid if already in wf relaese database
            if (DB::table('wfrelease')->where('wfrelease.empId', $value)->exists())
            {
            $emp = DB::table('wfrelease')
            
            ->select('wfrelease.empId')
            ->get();

            
                return response()
                    ->json($emp);

            }
            else
            {
                return response()->json(['code' => '200', 'failed' => 'Check your Employee Id!']);

            }

        }//end tdee 

         //welfare refund check with refund table
         if ($table == 'checkrefund')
         {
 
             //check empid if already in wf relaese database
             if (DB::table('wfrefund')->where('wfrefund.empId', $value)->exists())
             {
             $emp = DB::table('wfrefund')
             
             ->select('wfrefund.empId')
             ->get();
 
             
                 return response()
                     ->json($emp);
 
             }
             else
             {
                 return response()->json(['code' => '200', 'failed' => 'Check your Employee Id!']);
 
             }
 
         }//end tdee


        if ($table == "getName")
        {

            //check cid if already in database.

            if (DB::table('users')->where('users.empId', $value)->exists())
            {
                $emp = DB::table('users')->where('users.empId', $value)
                    ->select('users.empName','users.empId')
                    ->get();

                return response()
                    ->json($emp);

            }
            else
            {
                return response()->json(['code' => '200', 'failed' => 'Check your Emp_id!']);

            }

        }

        //end tdee

           //For user add ; to check if the user already exist
           if ($table == 'useraddregister')
           {
   
               //check cid if already in database.
               if (DB::table('users')->where('users.emp_id', $value)->exists())
               {
                   $emp = DB::table('users')
               ->select('emp_id','email'
               )
               ->where('emp_id',$value)
                       ->get();
                       
   
                   return response()
                       ->json($emp);
   
               }
               else
               {
                   return response()->json(['code' => '200', 'failed' => 'Check your Emp_id!']);
   
               }
   
           }

        //For user add ; to check if the user already exist
        if ($table == 'userdelete')
        {

            //check emp_id if already in database.
            if (DB::table('user_details')->where('user_details.emp_id', $value)->exists())
            {
                $emp = DB::table('user_details')
                ->select('user_details.emp_id'
                )
                    ->get();

                return response()
                    ->json($emp);

            }
            else
            {
                return response()->json(['code' => '200', 'failed' => 'Check your Emp_id!']);

            }

        }

        //For user add ; to check if the user already exist
        if ($table == 'conference_useradd')
        {

            //check emp_id if already in database.
            if (DB::table('user_details')->where('user_details.emp_id', $value)->exists())
            {
                $emp = DB::table('user_details')
                    ->select('user_details.emp_id')
                    ->get();

                return response()
                    ->json($emp);

            }
            else
            {
                return response()->json(['code' => '200', 'failed' => 'Check your Emp_id!']);

            }

        }

        if ($table == "currentpassword")
        {

            $check = Hash::check($value, auth()->user()
                ->password);

            //check passwd if already in database.
            if ($check == true)
            {

                $password = DB::table('users')->select('users.password')
                    ->get();

                return response()
                    ->json($password);

            }
            else
            {

                return response()->json(['code' => '200', 'failed' => 'Check your password!']);

            }

        }

    }

    //conference clash view
    public function clashview($id)
    {


        $id = $id + 5;
        $conference = conference::all();
        $clash = conferencebook::all();

        $clashv = conferencebook::all();

        $clashv = DB::select('select id from conferencerequest where id = ?', [$id]);



        $clash = DB::select('select * from conferencerequest where id = ?', [$id]);

        $conference_id = DB::table('conferencerequest')->where('id', $id)->select('conference_id')
            ->first();

        $clash1 = DB::table('conference')->where('id', $conference_id->conference_id)
            ->select('Conference_Name')
            ->get();

        $c_book = DB::table('conferencerequest')
        // ->latest('id')
        ->join('conference', 'conferencerequest.conference_id', '=', 'conference.id')

            ->where('status', 1)
            ->orwhere('conference_id', '1')
        //     ->where('conference_id' ,'=', "5")
        
            ->orwhere('status', 0)
            ->where("conference_id", "2")
            ->orwhere("conference_id", "3")
            ->orwhere("conference_id", "4")
            ->orwhere('conference_id', "5")
            // ->orwhere("conference_id", "6")
            // ->orwhere("conference_id", "7")
            // ->orwhere("conference_id", "8")


        // dd($c_book);
        
            ->select('conferencerequest.emp_id', 'conferencerequest.id', 'conferencerequest.name', 'conferencerequest.contact_number', 'conferencerequest.meeting_name', 'conferencerequest.start_date', 'conferencerequest.end_date','conference.Conference_Name'
                    )

            ->latest('id')
            ->paginate(15);

        return view('clash', ['clashv' => $clashv,'clash' => $clash, 'clash1' => $clash1, 'conference' => $conference, 'c_book' => $c_book]);

    }

    //view for track status
    public function tracking()
    {

        return view('tracking');

    }

    //For view of conference
    public function user_profile()
    {
	    $conference = conference::all()
            ->where('status_c',0)		    
		    ;
            $no_of_people90 = rangeofpeople::all()
            ->where('status_c',0)		    
		    ;
      
         $c_book = DB::table('conferencerequest')->join('conference', 'conferencerequest.conference_id', '=', 'conference.id')
            ->join('orgunit', 'orgunit.id', '=', 'conferencerequest.org_unit_id')

	    
           
            ->where('status', 1)
            ->where('conference_id', '1')

        //  ->where('conference_id' ,'=', '5')
        
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

            // ->orwhere("conference_id", "6")
            // ->where('status', 0)
            // ->where('default',)

            //  ->orwhere("conference_id", "7")
            // ->where('status', 0)
            // ->where('default',)

            // ->orwhere("conference_id", "8")
            // ->where('status', 0)
            // ->where('default',)

            ->select('conferencerequest.id', 'conferencerequest.emp_id', 'conferencerequest.id', 'conferencerequest.name', 'conferencerequest.contact_number', 'conferencerequest.meeting_name', 'conferencerequest.start_date', 'conferencerequest.end_date', 'orgunit.description','conference.Conference_Name'
                    )
            ->latest('id')
            ->paginate(1000000000);

        return view('user_profile', compact('conference', 'c_book','no_of_people90'));

    }

    public function success()
    {
        return redirect('home')
        ->with('success', 'Meeting Hall Updated Successfully!!!!');
    }

    public function error()
    {
        return redirect('home')
        ->with('error', 'Meeting Hall Cancelled Successfully!!!!');
    }

}

