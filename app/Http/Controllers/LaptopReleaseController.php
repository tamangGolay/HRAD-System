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

        $existing = LaptopRelease::where('empid', $request->EmpId)->first();
        if (!$existing) {
        
            $Request_release = new LaptopRelease;
            $Request_release->empid = $request->EmpId;    
            $Request_release->remarks = $request->remarks;
            $Request_release->save();  

            return redirect('home')->with('page', 'laptopdetails')
                ->with('success', 'You have successfully saved the record!');

        } 
        return redirect('home')->with('page', 'laptopdetails')
                ->with('error', 'This EmpID is already assigned for co-purchase.');

    
}}

