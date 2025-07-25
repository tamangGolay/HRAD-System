<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
 
// Add more models as needed

class HR_Service_ReportController extends Controller
{
    public function index(Request $request)
  {
      if ($request->ajax()) {
          $query = DB::table('hrservice')
          ->join('officedetails','officedetails.id','hrservice.officeId')
          ->join('users','users.empId','hrservice.createdBy')
        //   ->join('officeunder','officeunder.office','=','hrservice.officeId')
          
          ->select('hrservice.*','officeDetails','empName')
          ->where('hrservice.status','=','HRApproved')
          ->orWhere('hrservice.status','=','Rejected')
       
          ->where('cancelled','=','No');
          
  
          if (!empty($request->serviceType)) {
              $query->where('serviceType', $request->serviceType);
          }
  
          $review = $query->get();
  
          return datatables()->of($review)->make(true);
      }        
  }

}