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
          ->join('view_wfrelatives', 'view_wfrelatives.id', '=', 'wfrelease.deathOf')
         ->select('wfrelease.*','view_wfrelatives.relation')
        ->where('releaseDate','>=',$request->filter_startdate)
         ->where('releaseDate','<=',$request->filter_enddate)
       
         ->get();
      }
      else
      {
       
     $data = DB::table('wfrelease')
    
     ->join('view_wfrelatives', 'view_wfrelatives.id', '=', 'wfrelease.deathOf')
     ->select('wfrelease.*','view_wfrelatives.relation')    
      ->get();
      }
      
      return datatables()->of($data)->make(true);
     }
    
    }
}

?>
