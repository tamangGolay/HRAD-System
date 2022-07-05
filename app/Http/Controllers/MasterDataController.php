<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\EmployeeMaster;
use Auth;
use Hash;
use App\Roles;
use App\roleusermappings;
use App\Dzongkhags;
use App\user_details;
use DB;
use App\orgunit;
use App\Grade;




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
      // dd($request);
     
        $EmployeeMaster = new EmployeeMaster;//EmployeeMaster is ModelName
        $EmployeeMaster->EmpId = $request->emp_id;//emp_id is from input name
        $EmployeeMaster->EmpName =  $request->name;//EmpName is from dB
       //rolepull 
        $EmployeeMaster->BloodGroup = $request->contact_number;   
       
        // $user->password =  Hash::make($request->password);      
        // $user->org_unit_id = $request->orgunit;
        // $user->role_id = $request->role;
        // $user->gender = $request->gender;
        // $user->grade = $request->grade;
        // $user->contact_number = $request->contact_number;
        // $user->designation = $request->designation;
        // $user->dzongkhag = $request->dzongkhag;


        // $user->conference_user = $request->conferenceuser;
        // $user->created_by = Auth::id();

        //add role in the user_role_mapping.
        // $roleuser = new roleusermappings;       
        // $roleuser->role_id = $request->role;
        // $roleuser->created_by = Auth::id();


      //  DB::transaction(function() use ($user,$roleuser)
      //  {
        $EmployeeMaster->save();

        // $roleuser->user_id = $user->id;
        // $roleuser->save();

      //  });

       return redirect('home')->with('page','employeeMaster')
       ->with('adduser','Master Data Added Successfully!!!');
       


       
       

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
