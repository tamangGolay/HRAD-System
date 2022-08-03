<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class JacketReportController extends Controller
{
   
    function index(Request $request)
    {

 if(request()->ajax())
     {

      if(!empty($request->jacket))
      {

       $data = DB::table('employeeuniform')

       ->join('users', 'users.empId', '=', 'employeeuniform.empId')
       ->join('jacketmaster', 'jacketmaster.id', '=', 'employeeuniform.jacket')
       ->join('officedetails', 'officedetails.id', '=', 'employeeuniform.officeId')
  
       ->select('employeeuniform.id','employeeuniform.empId','officedetails.longOfficeName','jacketmaster.sizeName','users.empName')	
        ->where('employeeuniform.status',0)

        ->where('employeeuniform.jacket','=',$request->jacket)
         ->where('employeeuniform.officeId','=',$request->officeId)
         ->where('employeeuniform.status',0)
         ->get();
      }

      else
      {   
     $data = DB::table('employeeuniform')

     ->join('users', 'users.empId', '=', 'employeeuniform.empId')
     ->join('jacketmaster', 'jacketmaster.id', '=', 'employeeuniform.jacket')
     ->join('officedetails', 'officedetails.id', '=', 'employeeuniform.officeId')

      ->select('employeeuniform.id','employeeuniform.empId','officedetails.longOfficeName','jacketmaster.sizeName','users.empName')	
      ->where('employeeuniform.status',0)      
      ->get();
      }
      
      return datatables()->of($data)->make(true);
     }
    
    }
}

?>
