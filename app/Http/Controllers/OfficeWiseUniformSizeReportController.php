<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class OfficeWiseUniformSizeReportController extends Controller

  {
   
    function index(Request $request)
    {
      //After the date is entered it will come as ajax request and fetch the data
     if(request()->ajax())
     {

      if(!empty($request->officeId))
      {
      // dd($request);
      
        $review = DB::table('officeuniform')       
        
         ->select('*')            
         ->where('Office','=',$request->officeId)
         ->where('cloths','=',$request->cloths)
         ->where('officeuniform.size','!=','Not Applicable')
        //  ->where('employeeuniform.status','=', 0)

         ->get();
      }
      //When the report page loads 
      else
      {
       

        $review = DB::table('officeuniform')        
       
         ->select('*')
         ->where('officeuniform.size','!=','Not Applicable')

       ->get();
      }
      return datatables()->of($review)->make(true);
     }
    
    }
}

?>