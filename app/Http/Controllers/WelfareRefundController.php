<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Refund;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use DB;
use Auth;

class WelfareRefundController extends Controller
{

    public function Request_refund(Request $request)
    {
        //dd($request);
    
        // try
        //  {
            $Request_refund = new Refund;
            $Request_refund->empId = $request->EmpId;     //database name n user input name
            $Request_refund->refundDate = $request->refundDate;
            $Request_refund->amount = $request->refundAmount;                
            $Request_refund->save();    


            return redirect('home')->with('page', 'refund')
                ->with('success', 'welfare refund for this employee is successful!');

        } //try end
       
    //  catch(\Illuminate\Database\QueryException $e)
    //  {

    //       return redirect('home')->with('page', 'refund')
    //             ->with('error', 'Cannot leave the field empty!');

    //      }

    
}

