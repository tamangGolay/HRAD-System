<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use App\User;

use DB;
  

class ChangePasswordController extends Controller
{
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
   
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {

    
        $apple=$request->validate([
            'current_password' => ['required', new MatchOldPassword],

            'new_password' => ['required',
                              ],
            'new_confirm_password' => ['same:new_password'],
        ]);

     


        // if()
        
        // {

        //     return redirect('home')->with('page','error');
        // }

        // DB::update('update users set password => Hash::make = $request->new_password where emp_id = $request->emp_id');

   
        if(User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)])){

            return redirect('home')
           
                ->with('successmsg', 'Password Changed Sucessfully');

        }

       

   
    }



    public function storestart(Request $request)
    {

    
        $apple=$request->validate([
            'current_password' => ['required', new MatchOldPassword],

            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

     


        // if()
        
        // {

        //     return redirect('home')->with('page','error');
        // }

        // DB::update('update users set password => Hash::make = $request->new_password where emp_id = $request->emp_id');

   
        if(User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)])){

            return redirect('home');

        }

       

   
    }



    public function reset(Request $request)
    {
        // dd($request);

        if(DB::table('users')->where('users.empId',$request->emp_id)
        ->exists()){


        $request->validate([
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        $new_password=Hash::make($request->new_password);

        
        DB::update('update users set password = ?  where empId = ?',[$new_password,$request->emp_id]);


            
            return redirect('home')->with('page','resetpassword');

        

    }

   
    }



  
}
