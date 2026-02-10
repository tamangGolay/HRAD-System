<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
         ->join('hrserviceapproval','hrserviceapproval.noteId','=','hrservice.id')  

        ->select('hrservice.id','hrservice.serviceType','hrservice.emailId','hrservice.createdOn','hrservice.justification','hrservice.status','hrservice.createdBy','officeDetails','empName','hrserviceapproval.assignedTo',
        DB::raw("CONCAT(hrservice.createdBy, ' (', users.empName, ')') as createdByDisplay"))
      
         ->where(function($q) {
                $q->where('hrservice.status', 'HRApproved')
                ->orWhere('hrservice.status', 'Rejected');
            })
            ->where('cancelled', 'No')


            ->where(function($q) {
                $q->where('hrserviceapproval.modiType', 'HRApproved')
                ->orWhere('hrserviceapproval.modiType', 'Rejected');
            })
            
       
        //   ->where('cancelled','=','No')
          ->orderBy('hrservice.id', 'desc');
          
  
          if (!empty($request->serviceType)) {
              $query->where('serviceType', $request->serviceType);
          }
  
          $review = $query->get();
  
          return datatables()->of($review)->make(true);
      }        
  }

}