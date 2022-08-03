<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class RainCoatSizeReportController extends Controller

  {
   
    function index(Request $request)
    {
      //After the date is entered it will come as ajax request and fetch the data
     if(request()->ajax())
     {

      if(!empty($request->officeId))
      {
      // dd($request);
      
        $review = DB::table('employeeuniform')
       
        ->join('officedetails', 'officedetails.id', '=', 'employeeuniform.officeId')   
        ->join('raincoatsize', 'raincoatsize.id', '=', 'employeeuniform.raincoat')   
        ->join('users','users.empId','=','employeeuniform.empId')
         ->select('officedetails.longOfficeName','employeeuniform.*','raincoatsize.sizeName','users.empName')
            
         ->where('employeeuniform.officeId','=',$request->officeId)
         ->where('employeeuniform.raincoat','=',$request->raincoat)
         ->where('employeeuniform.status','=', 0)

         ->get();
      }
      //When the report page loads 
      else
      {
       

        $review = DB::table('employeeuniform')           

        ->join('officedetails', 'officedetails.id', '=', 'employeeuniform.officeId')   
        ->join('raincoatsize', 'raincoatsize.id', '=', 'employeeuniform.raincoat')   
        ->join('users','users.empId','=','employeeuniform.empId')  
         ->select('officedetails.longOfficeName','employeeuniform.*','raincoatsize.sizeName','users.empName')

       ->where('employeeuniform.status','=', 0)
       ->get();
      }
      return datatables()->of($review)->make(true);
     }
    
    }
}

?>