<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;
use App\Roles;
use App\roleusermappings;
use App\Dzongkhags;
use App\user_details;
use DB;
use App\orgunit;
use App\GradeMaster;
use App\Designation;
use App\pay;
use PDO;





class MasterDataController extends Controller
{

    private $roles;
    private $roles_id = array();
    private $form;

    // public function register()
    // {

    
    //       $roles = Roles::all();
    //       $orgunit = orgunit::all();
    //       $grade = Grade::all();
    //       $dzongkhag = Dzongkhags::all();

    

     
    //     return view('auth.register',compact('roles','orgunit','grade','dzongkhag'));
    // }

    public function storeUser(Request $request)
    {
      
      // $id = "select id from users where empId = $request->emp_id";
     
    // dd($request);



      // dd($request);

      //code to insert the qualifications
      // if(isset($_POST["item_name"]))
      // {
      //   $connect = new PDO("mysql:host=localhost;dbname=hradsystem", "root", "");
      //   //  $id = ();
      //   for($count = 0; $count < count($_POST["item_name"]); $count++)
      //   {  
      //     $query = "INSERT INTO employeequalificationmaster 
      //     (personalNo, qualificationId) 
      //     VALUES (:personalNo , :item_unit)
      //     ";
      //     $statement = $connect->prepare($query);
      //     $statement->execute(
      //     array(
      //       // ':id'   => $id,
      //       ':personalNo'  => $_POST["item_name"][$count], 
      //       ':item_unit'  => $_POST["item_unit"][$count]
      //     )
      //     );
      //   }
      //   $result = $statement->fetchAll();
      //   if(isset($result))
      //   {
      //     echo 'ok';
      //   }
      //  } 
       
        $users = new User;//users is ModelName
        $users->EmpId = $request->EmpId;//emp_id is from input name
        $users->EmpName =  $request->EmpName;//EmpName is from dB
       //rolepull 
        $users->BloodGroup = $request->BloodGroup;
        $users->cidNo = $request->cidNo;
        $users->dob = $request->dob;
        $users->gender = $request->gender;
        $users->appointmentDate = $request->appointmentDate; 
        $users->gradeId = $request->gradeId;
        $users->basicPay = $request->basicPay;
        $users->empStatus = $request->empStatus; 
        $users->lastDop = $request->lastDop;
        $users->mobileNo = $request->mobileNo;
        $users->emailId = $request->emailId;
        // $users->placeId = $request->placeId;
        $users->designationId = $request->designationId;
        $users->office = $request->office;
        // $users->bankName = $request->bankName;
        // $users->accountNumber = $request->accountNumber; 
        $users->resignationTypeId = $request->resignationTypeId;
        $users->resignationDate = $request->resignationDate;
        $users->employmentType = $request->employmentType;
        $users->incrementCycle = $request->incrementCycle;
               
        // $user->password =  Hash::make($request->password);      
        // $user->org_unit_id = $request->orgunit;
        // $user->role_id = $request->role;
        // $user->gender = $request->gender;
        // $user->contact_number = $request->contact_number;
        // $user->designation = $request->designation;
        // $user->dzongkhag = $request->dzongkhag;


        // $user->conference_user = $request->conferenceuser;
        // $user->created_by = Auth::id();

        //add role in the user_role_mapping.
        $roleuser = new roleusermappings;       
        $roleuser->role_id = $request->role;
        $roleuser->created_by = Auth::id();


       DB::transaction(function() use ($users,$roleuser)
       {
        $users->save();

        $roleuser->user_id = $users->id;
        $roleuser->save();

       });

        $designationId = DB::table('users')
            ->join('designationmaster', 'designationmaster.id', '=', 'users.designationId')
                ->select('designationmaster.desisNameLong')
                ->where('users.status', '=', 0)
                // ->where('vehiclerequest.id', '=', $Request_vehicle->id)
                ->first();

        // $bankName = DB::table('users')
        //     ->join('bankmaster', 'bankmaster.id', '=', 'users.bankName')
        //     // ->join('designationmaster', 'designationmaster.id', '=', 'users.designationId')
        //         ->select('bankmaster.bankName')
        //         ->where('users.status', '=', 0)
        //         // ->where('vehiclerequest.id', '=', $Request_vehicle->id)
        //         ->first();

        $resignationTypeId = DB::table('users')
                ->join('resignationtypemaster', 'resignationtypemaster.id', '=', 'users.resignationTypeId')
                ->select('resignationtypemaster.resignationType')
                ->where('users.status', '=', 0)
                ->first();
                
        $gradeId = DB::table('users')
                ->join('payscalemaster', 'payscalemaster.id', '=', 'users.gradeId')
                ->select('payscalemaster.grade')
                ->where('users.status', '=', 0);
                
        $office = DB::table('users')
                ->join('officename', 'officename.id', '=', 'users.office')
                ->select('officename.longOfficeName')
                ->where('users.status', '=', 0)
                ->first(); 

        // $placeId = DB::table('users')
        //         // ->join('placemaster', 'placemaster.id ', '=', 'office_address.placeId')
        //         ->join('office_address', 'office_address.placeId', '=', 'users.placeId')
        //         ->select('office_address.Address')
        //         ->where('users.status', '=', 0)
        //         ->first();

       return redirect('home')->with('success','Master Data Added Successfully!!!')
       ->with('page','employeemaster')
       ;
       


       
       

    }


    public function addRole(Request $request)
    {    
     
        $role = new Roles;
        $role->name = $request->role;
        $role->save();

        return redirect('home')->with('page', 'roleAdd')
        ->with('roleadd','Role Successfully Added!!!!!');
       
    }


    

    public function registerUser(Request $request)
    {
      $id = DB::table('users')->select('id')
      ->where('emp_id', $request->emp_id)
      ->first();
      


      DB::update('update users set email = ? where id = ?', [$request->email, $id->id]);

    //  dd($request);
      //   $user = new User;
      //   $user->emp_id = $request->emp_id;
      //   $user->name =  $request->name;
      //   $user->email = $request->email;   
      //   $user->password =  Hash::make($request->password);      
      //   $user->org_unit_id = $request->orgunit;
      //   $user->first_time_login = $request->firstTimeLogin;
      //   $user->grade = $request->grade;
      //   $user->gender = $request->gender;
      //   $user->contact_number = $request->contactNumber;
      //   $user->designation = $request->designation;
      //   $user->role_id = $request->role;
      //   $user->dzongkhag = $request->dzongkhag;
      //   $user->created_by = $request->create;


      //   $user->conference_user = $request->conferenceuser;

      //   //add role in the user_role_mapping.
      //   $roleuser = new roleusermappings;       
      //   $roleuser->role_id = $request->role;
      //   $roleuser->created_by = $request->create;


      //  DB::transaction(function() use ($user,$roleuser)
      //  {
      //   $user->save();

      //   $roleuser->user_id = $user->id;
      //   $roleuser->save();

      //  });



       return redirect('login')->with('success', 'User Registered Successfully!!!');
       ;
    }

   

    public function login()
    {
     if(Auth::check())
      {
        return redirect()->intended('/home');
      }
      else
      {
       return view('auth.login');
      }
      
    }


    public function firstpage()
    {
     if(Auth::check())
      {
        return redirect()->intended('/home');
      }
      else
      {
       return view('auth.firstpage');
      }
      
    }

    public function authenticate(Request $request)
    {

        $credentials = $request->only('emp_id', 'password');
        $status = DB::table('users')->select('status')
        ->where('emp_id', $request->emp_id)
        ->first();

        $email = DB::table('users')->select('email')
        ->where('emp_id', $request->emp_id)
        ->first();

        if($status == null){
          return redirect('login')->with('error', 'Please Register!!!');
        }

        if($email->email == 'e'){
          return redirect('login')->with('error', 'Please Register!!!');
        }

        if($status->status == 0){


        if (Auth::attempt($credentials)) {


              if (Auth::user()->first_time_login) {
                $first_time_login = true;
                Auth::user()->first_time_login = false;
                Auth::user()->save();
                return view(
                  'changepassword', 
                  ['first_time_login' => $first_time_login]
              ); 
             } 
              else {
                $first_time_login = false;

              }
        
          
            return redirect()->intended('/home');
        }
     
      }

        return redirect('login')->with('error', 'Invalid credentials');
    }

    public function logout() {
      Auth::logout();

      return redirect('/');
    }

    public function home()
    {
      return view('home');
    }

    public function getForms()
    {
        $this->roles = Auth::user()->role;

        foreach($this->roles as $role)
        {
            $this->role_id[] = $role->id;
        }

        $this->form = DB::table('roleformmapping')
                    ->wherein('role_id',$this->role_id)
                    ->select('forms','description')
                    ->get();
    }
}
