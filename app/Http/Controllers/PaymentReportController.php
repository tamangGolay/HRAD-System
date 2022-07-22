<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class PaymentReportController extends Controller
{
   
    function index(Request $request)
    {

 if(request()->ajax())
     {


      if(!empty($request->filter_startdate))
      {

       $data = DB::table('wfrelease')
    //    ->join('users', 'users.id', '=', 'wfrelease.empId')
       ->select('*')
        ->where('releaseDate','>=',$request->filter_startdate)
         ->where('releaseDate','<=',$request->filter_enddate)
         ->where('wfrelease.status',0)
            ->get();
      }
      else
      {
       
     $data = DB::table('wfrelease')
    //    ->join('users', 'users.id', '=', 'wfrelease.empId')
       ->select('*')	
        ->where('wfrelease.status',0)      
      ->get();
      }
      
      return datatables()->of($data)->make(true);
     }
    
    }
}

?>
