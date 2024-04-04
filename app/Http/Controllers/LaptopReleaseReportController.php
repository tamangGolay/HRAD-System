<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class laptopReleaseReportController extends Controller
{
   
    function index(Request $request)
    {
     if(request()->ajax())
     {

      if(!empty($request->filter_startdate))
      {
      
      
        $review = DB::table('laptopdetails')

        ->join('users', 'laptopdetails.empid', '=', 'users.empId')
        ->select('laptopdetails.*','users.empName')   
        ->whereDate('releasedate','>=',$request->filter_startdate)
        ->whereDate('releasedate','<=',$request->filter_enddate)
        ->get();
      }
      else
      {
       
        $review = DB::table('laptopdetails')
          ->join('users', 'laptopdetails.empid', '=', 'users.empId')
          ->select('laptopdetails.*','users.empName')
          ->get();
      }
      return datatables()->of($review)->make(true);
     }
    
    }
}

?>