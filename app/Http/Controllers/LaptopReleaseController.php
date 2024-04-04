<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LaptopRelease;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use DB;
use Auth;

class LaptopReleaseController extends Controller
{

    public function Laptop_release(Request $request)
    {
        
            $Request_refund = new LaptopRelease;
            $Request_refund->empid = $request->EmpId;     //database name n user input name
            $Request_refund->remarks = $request->remarks;
            // $Request_refund->releasedate = $request->refundAmount;                
            $Request_refund->save();    


            return redirect('home')->with('page', 'refund')
                ->with('success', 'welfare refund for this employee is successful!');

        } 

    
}

