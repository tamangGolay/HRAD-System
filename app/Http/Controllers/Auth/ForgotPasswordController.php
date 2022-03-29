<?php 
  
namespace App\Http\Controllers\Auth; 
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use DB; 
use Carbon\Carbon; 
use App\User; 
use Mail; 
use Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
  
class ForgotPasswordController extends Controller
{
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showForgetPasswordForm()
      {
         return view('auth.forgetPassword');
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitForgetPasswordForm(Request $request)
      {

        // dd($request->input('empid'));
          // $request->validate([
          //     'email' => 'required|email|exists:users',
          // ]);
          
          $token = Str::random(64);
          $empId = Crypt::encrypt($request->input('empid'));

  
        //   DB::table('passwordReset')->insert([
        //       'email' => $request->email, 
        //       'token' => $token, 
        //       'created_at' => Carbon::now()
        //     ]);
  
          Mail::send('emails.forgetPassword', ['token' => $empId], function($message) use($request){
              $message->to($request->email);
              $message->subject('Reset Password');
          });
  
          return back()->with('message', 'We have e-mailed your password reset link!');
      }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm($token) { 
         return view('auth.forgetPasswordLink', ['token' => $token]);
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request)
      {
          $request->validate([
              'empid' => 'required',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
      

          $emp_id =  Crypt::decrypt($request->input('empid'));
// dd($emp_id);

          if(DB::table('users')->where('users.emp_id',$emp_id)
          ->exists()){
  
  
        //   $request->validate([
        //       'new_password' => ['required'],
        //       'new_confirm_password' => ['same:new_password'],
        //   ]);
  
          $new_password=Hash::make($request->password);
  
   
          DB::update('update users set password = ?  where emp_id = ?',[$new_password,$emp_id]);
   
        }
  
        //   $updatePassword = DB::table('passwordReset')
        //                       ->where([
        //                         'email' => $request->email, 
        //                         'token' => $request->token
        //                       ])
        //                       ->first();
  
        //   if(!$updatePassword){
        //       return back()->withInput()->with('error', 'Invalid token!');
        //   }

         
        //  $user = User::where('emp_id', $request->emp_id)
        //               ->update(['password' => Hash::make($request->password)]);

        // DB::update('update users set password = ?  where emp_id = ?',[$user,$request->emp_id]);

 
        return redirect()->to('/login')->send();
      }
      
}