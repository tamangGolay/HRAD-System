<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TransferHistoryReportController extends Controller
{
   
    function index(Request $request)
    {
      //After the date is entered it will come as ajax request and fetch the data
     if(request()->ajax())
     {

      if(!empty($request->offname))
      {
      
      
        $review = DB::table('transferhistory')
       
        ->join('officedetails', 'officedetails.id', '=', 'transferhistory.transferFrom')
        ->join('officedetails AS B', 'B.id', '=', 'transferhistory.transferTo')
        ->join('officedetails AS D', 'D.id', '=', 'transferhistory.id')
        ->join('transferproposal', 'transferproposal.id', '=', 'transferhistory.id')
        ->join('employee4twimc', 'employee4twimc.empId', '=', 'transferhistory.empId')       

        ->select('transferhistory.empId','transferhistory.transferDate','transferproposal.hRRemarks','B.longOfficeName as tooffname','D.reportToOffice as oficereoprt','transferhistory.transferType','transferhistory.transferBenefit','officedetails.longOfficeName','transferproposal.reasonForTransfer','employee4twimc.empName','employee4twimc.designation','employee4twimc.grade')
        ->where('transferhistory.status','=', 'Closed')
            
        ->where('transferhistory.id','=',$request->offname)
        ->where('transferhistory.id','=',$request->transferDate)
         ->get();
      }
      //When the report page loads 
      else
      {
       

        $review = DB::table('transferhistory')
        
        ->join('officedetails', 'officedetails.id', '=', 'transferhistory.transferFrom')
        ->join('officedetails AS B', 'B.id', '=', 'transferhistory.transferTo')
        ->join('officedetails AS D', 'D.id', '=', 'transferhistory.id')

        ->join('transferproposal', 'transferproposal.id', '=', 'transferhistory.id') 
        ->join('employee4twimc', 'employee4twimc.empId', '=', 'transferhistory.empId') 

        ->select('transferhistory.empId','transferhistory.transferDate','transferproposal.hRRemarks','B.longOfficeName as tooffname','D.reportToOffice as oficereoprt','transferhistory.transferType','transferhistory.transferBenefit','officedetails.longOfficeName','transferproposal.reasonForTransfer','employee4twimc.empName','employee4twimc.designation','employee4twimc.grade')
        ->where('transferhistory.status','=', 'Closed')
        ->get();
      }
      return datatables()->of($review)->make(true);
     }
    
    }
}

?>