<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ShirtSizeReportController extends Controller
{
   
    function index(Request $request)
    {
      //After the date is entered it will come as ajax request and fetch the data
     if(request()->ajax())
     {

      if(!empty($request->filter_startdate))
      {
      
      
        $review = DB::table('employeeuniform')
       
        // ->join('rangeofpeople', 'rangeofpeople.id', '=', 'conferencerequest.no_of_people') 
        

         ->select('*')
            
         ->where('officeId','=',$request->filter_startdate)
         ->where('shirt','=',$request->filter_enddate)
         ->where('employeeuniform.status','=', 0)

         ->get();
      }
      //When the report page loads 
      else
      {
       

        $review = DB::table('employeeuniform')
        
        // ->join('rangeofpeople', 'rangeofpeople.id', '=', 'conferencerequest.no_of_people') 
       

       ->select('*')
       ->where('employeeuniform.status','=', 0)
       ->get();
      }
      return datatables()->of($review)->make(true);
     }
    
    }
}

?>