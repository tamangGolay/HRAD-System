<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WfRelease;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use DB;
use Auth;

class PaymentReleaseController extends Controller
{

    public function paymentRelease(Request $request)
    {
     

        try
         {
            $Request_payment = new WfRelease;
            $Request_payment->empId = $request->empId;
            $Request_payment->releaseDate = $request->releaseDate;
            $Request_payment->amount = $request->amount;
            $Request_payment->reason = $request->reason;
        
            $Request_payment->save();

        
        
            return redirect('home')
                ->with('success', ' Payment Successful');

        } //try end
       
     catch(\Illuminate\Database\QueryException $e)
     {

          return redirect('home')
                ->with('error', 'Cannot leave the fields empty');

         }

    }
}   

    

