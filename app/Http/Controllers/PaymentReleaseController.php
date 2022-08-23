<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WfReleaseProcess;
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
            $Request_payment = new WfReleaseProcess;
            $Request_payment->empId = $request->empId;
            $Request_payment->requestDate = $request->requestDate;
            $Request_payment->amount = $request->amount;
            $Request_payment->reason = $request->reason;
            $Request_payment->createdBy = $request->empId;        
            $Request_payment->save();       
        
            return redirect('home')
                ->with('success', 'You have requested for welfare release payment!');

        } //try end
       
     catch(\Illuminate\Database\QueryException $e)
     {

          return redirect('home')
                ->with('error', 'Cannot leave the fields empty');

         }

    }

    public function welfareReview(Request $request)
    {

        //ur code here
}   }

    

