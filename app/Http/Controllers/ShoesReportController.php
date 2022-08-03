<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ShoesReportController extends Controller
{
   
    function index(Request $request)
    {
      //After the date is entered it will come as ajax request and fetch the data
     if(request()->ajax())
     {

      if(!empty($request->offname))
      {
      
      
        $review = DB::table('employeeuniform')
       
        ->join('officedetails', 'officedetails.id', '=', 'employeeuniform.officeId')
        ->join('shoesize', 'shoesize.id', '=', 'employeeuniform.shoe')
        ->join('users', 'users.empId', '=', 'employeeuniform.empId') 
        
        ->select('employeeuniform.empId','officedetails.longOfficeName','shoesize.ukShoeSize','users.empName')
        ->where('employeeuniform.status','=', 0)
            
         ->where('employeeuniform.officeId','=',$request->offname)
         ->where('employeeuniform.shoe','=',$request->shoesizee)
         ->where('employeeuniform.status','=', 0)

         ->get();
      }
      //When the report page loads 
      else
      {
       

        $review = DB::table('employeeuniform')
        
        ->join('officedetails', 'officedetails.id', '=', 'employeeuniform.officeId')
        ->join('shoesize', 'shoesize.id', '=', 'employeeuniform.shoe')
        ->join('users', 'users.empId', '=', 'employeeuniform.empId') 
        
        ->select('employeeuniform.empId','officedetails.longOfficeName','shoesize.ukShoeSize','users.empName')
       ->where('employeeuniform.status','=', 0)
       ->get();
      }
      return datatables()->of($review)->make(true);
     }
    
    }
}

?>