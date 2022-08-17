<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\transferRequest;
use DB;
use Auth;
use App\transferProposal;

class TransferRequestController extends Controller
{

    public function Request_transfer(Request $request)
    {
        $b= DB::table('transferrequest') 
        ->join('officedetails', 'officedetails.id', '=', 'transferrequest.id')
        ->join('officedetails AS B', 'B.id', '=', 'transferrequest.id')
        ->join('employeesupervisor', 'employeesupervisor.employee', '=', 'transferrequest.createdBy')
        ->select('transferrequest.requestDate', 'transferrequest.reason','officedetails.*','officedetails.officeDetails as f','B.officeDetails as tff','employeesupervisor.superName','employeesupervisor.supervisor')
        ->get();   

        //   dd($request);

            $Request_notesheet = new transferRequest;
            $Request_notesheet->requestDate = $request->requestDate;
            $Request_notesheet->fromOffice = $request->fromOffice;
            $Request_notesheet->toOffice = $request->toOffice;               
            $Request_notesheet->requestToEmp = $request->requestToEmp;     //database name n user input name
            $Request_notesheet->reason = $request->reason;
            $Request_notesheet->createdBy = $request->empId;
            $Request_notesheet->save();  


            return redirect('home')->with('page', 'transferRequest')
            ->with('success', 'Transfer request submitted successfully!');

}


   public function recommendTransfer(Request $request)
    {

        if($request->status == "recommended" ){  //&& $request->remarks != ''
            $id = DB::table('transferrequest')->select('id')
            ->where('id',$request->id)
            ->first();    
        
                $a = new transferProposal;// is ModelName
                $a->requestId = $id->id;//
                $a->empId =  $request->createdBy;//
                $a->proposedDate = $request->requestDate;
                $a->fromOffice = $request->fromOffice;//
                $a->toOffice = $request->toOffice;//
                $a->transferType = $request->status;//
                $a->save();      
           

     }


}}
