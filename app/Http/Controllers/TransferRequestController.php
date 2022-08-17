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
       
        if($request->status == "Request" ){    

            $id = DB::table('transferrequest')->select('id')
            ->where('id',$request->id)
            ->first(); 
            
            $empId = DB::table('transferrequest')->select('createdBy')
            ->where('id',$request->id)
            ->first();
            
            $fromOffice = DB::table('transferrequest')->select('fromOffice')
            ->where('id',$request->id)
            ->first();  

            $toOffice = DB::table('transferrequest')->select('toOffice')
            ->where('id',$request->id)
            ->first();  
            $requestDate = DB::table('transferrequest')->select('requestDate')
            ->where('id',$request->id)
            ->first();  
        
           // dd($toOffice->toOffice);

                $a = new transferProposal;   // is ModelName
                $a->requestId = $id->id;
                $a->empId =  $empId->createdBy;
                $a->proposedDate = $requestDate->requestDate;
                $a->fromOffice = $fromOffice->fromOffice;
                $a->toOffice = $toOffice->toOffice;
                $a->transferType = $request->status;
                $a->save();                
                
            return redirect('home')->with('page', 'transferRequestReview')
            ->with('success', 'Recommended and forwarded the transfer request successfully!');

    }  

      
      if($request->status2 == "rejected" ){    

        $id = DB::table('transferrequest')->select('id')
        ->where('id',$request->id)
        ->first(); 
        
        transferRequest::updateOrCreate(['id' => $id->id],
        ['status' =>$request->status2]);                  
            
        //mail to user with reason of rejection
            
        return redirect('home')->with('page', 'transferRequestReview')
        ->with('error', 'This transfer request have been rejected!');

}

     }


}
