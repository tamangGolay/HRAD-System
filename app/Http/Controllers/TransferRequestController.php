<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\transferRequest;
use DB;
use Auth;
use App\transferProposal;
use App\Officedetails;
use App\Officem;
use App\transferHistory;
use App\User;
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

            $reasonForTransfer = DB::table('transferrequest')->select('reason')
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
                $a->reasonForTransfer = $reasonForTransfer->reason;

                $a->save(); 
                
                $approvestatus='recommended';
                
                transferRequest::updateOrCreate(['id' => $id->id],
                ['status' =>$approvestatus]);       
                
                
                
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
     public function Admin_transfer(Request $request)
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
            $Request_notesheet->status = $request->status;
            $Request_notesheet->save();  


            return redirect('home')
            ->with('success', 'Transfer request submitted successfully!');
    }

    public function gmReviewTransfer(Request $request)
    {
        // dd($request);

        if($request->remarks == "recommended" ){                        //&& $request->remarks != ''
           
            $id = DB::table('transferproposal')->select('id')
            ->where('id',$request->id)
            ->first();

            $status='recommended'; 
             

        transferProposal::updateOrCreate(['id' => $id->id],
                           ['fromGMAction' =>$request->remarks,
                           'fromGM' =>$request->empId,
                           'status' =>$status,
                           'fromGMRemarks' =>$request->rejectreason]);  

        //  return redirect('home')
        //  ->with('success','You have recommended the Transfer Request');

        return redirect('home')->with('page', 'gmTransferReview')
            ->with('success', 'Transfer request submitted successfully!');

 }
 if($request->remarks2 == "rejected" ){    
                       
    $id = DB::table('transferproposal')->select('id')
    ->where('id',$request->id)
    ->first();

    $status1='rejected'; 
     

transferProposal::updateOrCreate(['id' => $id->id],
                   ['fromGMAction' =>$request->remarks2,
                   'fromGM' =>$request->empId,
                   'status' =>$status1,
                   'fromGMRemarks' =>$request->rejectreason]); 

//  return redirect('home')
//  ->with('error','You have rejectd the Transfer Request');

return redirect('home')->with('page', 'gmTransferReview')
->with('error', 'You have rejectd the Transfer Request!');

}

 else{
    return redirect('home')->with('Sorry','Recommendation Failed');  
 }

}


public function dirReviewTransfer(Request $request)
{
    // dd($request);

    if($request->remarks == "recommended" ){                        //&& $request->remarks != ''
       
        $id = DB::table('transferproposal')->select('id')
        ->where('id',$request->id)
        ->first();

        $status='dirrecommended';      

    transferProposal::updateOrCreate(['id' => $id->id],
                       ['fromDirectorAction' =>$request->remarks,
                       'fromDirector' =>$request->empId,
                       'status' =>$status,
                       'fromDirectorRemarks' =>$request->rejectreason]);  

     return redirect('home')
     ->with('success','You have recommended the Transfer Request');

}
if($request->remarks2 == "rejected" ){    
    

    $id = DB::table('transferproposal')->select('id')
    ->where('id',$request->id)
    ->first();

    $status1='rejected'; 

    transferProposal::updateOrCreate(['id' => $id->id],
                        ['fromDirectorAction' =>$request->remarks2,
                        'fromDirector' =>$request->empId,
                        'status' =>$status1,
                        'fromDirectorRemarks' =>$request->rejectreason]);   
                        return redirect('home')
                        ->with('error','You have rejectd the Transfer Request');

                    }

else{
return redirect('home')->with('Sorry','Recommendation Failed');  
}


}

public function viewRequest()
{
    
$viewRequest = DB::table('transferproposal')
->join('officedetails', 'officedetails.id', '=', 'transferproposal.fromOffice')
->join('officedetails AS B', 'B.id', '=', 'transferproposal.toOffice')   
->select('transferproposal.*','officedetails.officeDetails as f','B.officeDetails as tff')
 
 ->where('status','=','dirrecommended')     
 ->where('transferproposal.toOffice','=',Auth::user()->office)                             
          
  ->paginate(10000000);

  $rhtml = view('Transfer.viewRequest')->with(['viewRequest' => $viewRequest])->render();
  return response()
    ->json(array(
    'success' => true,
    'html' => $rhtml
   ));
  }

public function toManagerTransfer(Request $request)
{
    // dd($request);

    if($request->remarks == "proposed" ){                        
       
        $id = DB::table('transferproposal')->select('id')
        ->where('id',$request->id)
        ->first();      

    transferProposal::updateOrCreate(['id' => $id->id],
                       ['status' =>$request->remarks]);   

     return redirect('home')
     ->with('success','You have recommended the Transfer Request.');
     
    }

    if($request->remarks2 == "rejected" ){    
                          
     $id = DB::table('transferproposal')->select('id')
     ->where('id',$request->id)
     ->first();  

       transferProposal::updateOrCreate(['id' => $id->id],
        ['status' =>$request->remarks2]);   

    return redirect('home')
     ->with('error','You have rejectd the Transfer Request!');
   }

   else{
         return redirect('home')->with('Sorry','Recommendation Failed');  
   }

}

public function toGMtransferrequest()
{
    $fromoffice = Officedetails::all();
    $tooffice = Officedetails::all();
 
    $toGMtransferrequest = DB::table('transferproposal')
    ->join('officedetails', 'officedetails.id', '=', 'transferproposal.fromOffice')
   ->join('officedetails AS B', 'B.id', '=', 'transferproposal.toOffice') 
   ->join('officemaster','officemaster.id','=','transferproposal.toOffice')

   ->select('transferproposal.*','officedetails.officeDetails as f','B.officeDetails as tff')

    ->where('transferproposal.toOffice','=',Auth::user()->office) 
  ->where('transferproposal.status','=','proposed')
  ->where('transferproposal.toGM',)

 ->orwhere('officemaster.reportToOffice',Auth::user()->office)
  ->where('transferproposal.status','=','proposed')
  ->where('transferproposal.toGM',)
    
    
    ->paginate(10000000);


$rhtml = view('transfer.transferReviewToGM')->with(['toGMtransferrequest' => $toGMtransferrequest,'fromoffice' => $fromoffice,'tooffice' => $tooffice])->render();
return response()
  ->json(array(
  'success' => true,
  'html' => $rhtml
));
} //end

public function toGMReviewTransfer(Request $request)
 {
    // dd($request);
    
        if($request->remarks == "recommended" ){                        //&& $request->remarks != ''
           
            $id = DB::table('transferproposal')->select('id')
            ->where('id',$request->id)
            ->first();

            $status='recommended'; 
             

        transferProposal::updateOrCreate(['id' => $id->id],
                           ['toGMAction' =>$request->remarks,
                           'toGM' =>$request->empId,
                           'status' =>$status,
                           'toGMRemarks' =>$request->rejectreason]);   
         return redirect('home')
         ->with('success','You have recommended the Transfer Request');

 }

 if($request->remarks2 == "rejected" ){    
                       
    $id = DB::table('transferproposal')->select('id')
    ->where('id',$request->id)
    ->first();

    $status1='rejected'; 
     

transferProposal::updateOrCreate(['id' => $id->id],
                   ['toGMAction' =>$request->remarks2,
                   'toGM' =>$request->empId,
                   'status' =>$status1,
                   'toGMRemarks' =>$request->rejectreason]);  

 return redirect('home')
 ->with('error','You have rejectd the Transfer Request');

}

 else{
    return redirect('home')->with('Sorry','Recommendation Failed');  
 }

}

public function toDirtransferrequest()
{
    $fromoffice = Officedetails::all();
    $tooffice = Officedetails::all();
 
    $toDirtransferrequest = DB::table('transferproposal')
    ->join('officedetails', 'officedetails.id', '=', 'transferproposal.fromOffice')
   ->join('officedetails AS B', 'B.id', '=', 'transferproposal.toOffice') 
   ->join('officemaster','officemaster.id','=','transferproposal.toOffice')
   ->join('officeunder','officeunder.office','=','transferproposal.toOffice')

   ->select('transferproposal.*','officedetails.officeDetails as f','B.officeDetails as tff')

    ->where('transferproposal.toOffice','=',Auth::user()->office) 
  ->where('transferproposal.status','=','recommended')
  ->where('transferproposal.toDirector',)

 ->orwhere('officemaster.reportToOffice',Auth::user()->office)
  ->where('transferproposal.status','=','recommended')
  ->where('transferproposal.toDirector',)

  ->orwhere('officeunder.head',Auth::user()->empId)  
  ->where('transferproposal.status','=','recommended')
  ->where('transferproposal.toDirector',)
    
    
    ->paginate(10000000);

$rhtml = view('transfer.transferReviewToDir')->with(['toDirtransferrequest' => $toDirtransferrequest,'fromoffice' => $fromoffice,'tooffice' => $tooffice])->render();
return response()
  ->json(array(
  'success' => true,
  'html' => $rhtml
));
} //end

public function toDirReviewTransfer(Request $request)
 {
    // dd($request);
    
        if($request->remarks == "recommended" ){                        //&& $request->remarks != ''
           
            $id = DB::table('transferproposal')->select('id')
            ->where('id',$request->id)
            ->first();

            $status='dirrecommended'; 
             

        transferProposal::updateOrCreate(['id' => $id->id],
                           ['toDirectorAction' =>$request->remarks,
                           'toDirector' =>$request->empId,
                           'status' =>$status,
                           'toDirectorRemarks' =>$request->rejectreason]);   
         return redirect('home')
         ->with('success','You have recommended the Transfer Request');

 }

 if($request->remarks2 == "rejected" ){    
                       
    $id = DB::table('transferproposal')->select('id')
    ->where('id',$request->id)
    ->first();

    $status1='rejected'; 
     

transferProposal::updateOrCreate(['id' => $id->id],
                   ['toDirectorAction' =>$request->remarks2,
                   'toDirector' =>$request->empId,
                   'status' =>$status1,
                   'toDirectorRemarks' =>$request->rejectreason]);  

 return redirect('home')
 ->with('error','You have rejectd the Transfer Request');

}

 else{
    return redirect('home')->with('Sorry','Recommendation Failed');  
 }

}

public function HRReviewTransfer(Request $request)
{

    if($request->remarks == "Open" ){    

        $id = DB::table('transferproposal')->select('id')
        ->where('id',$request->id)
        ->first(); 
        
        $empId = DB::table('transferproposal')->select('empId')
        ->where('id',$request->id)
        ->first();
        
        $fromOffice = DB::table('transferproposal')->select('fromOffice')
        ->where('id',$request->id)
        ->first();  

        $toOffice = DB::table('transferproposal')->select('toOffice')
        ->where('id',$request->id)
        ->first();  

        $proposalId = DB::table('transferproposal')  
        ->select('id')
        ->where('id',$request->id)
        ->first();  

        $transferType = DB::table('transferproposal')->select('transferType')
        ->where('id',$request->id)
        ->first();  
        
        $transferBenefit = DB::table('transferproposal')->select('transferBenefits')
        ->where('id',$request->id)
        ->first();

        // $requestDate = DB::table('transferrequest')->select('requestDate')
        // ->where('id',$request->id)
        // ->first();  
    
    
       // dd($toOffice->toOffice);
    //    id,proposalId,empId,transferDate,transferFrom,transferTo,transferType,TransferBenefit,orderReleasedBy,OrderReleasedOn,relievedBy,relievedOn,joinedOn,joiningAcceptedBy,joiningAcceptedOn,status

            $a = new transferHistory;   // is ModelName
            $a->id = $id->id;
            $a->empId =  $empId->empId;
            $a->transferFrom = $fromOffice->fromOffice;
            $a->transferTo = $toOffice->toOffice;
            $a->proposalId = $proposalId->id;
            $a->transferType = $transferType->transferType;
            $a->transferBenefit = $transferBenefit->transferBenefits;
            $a->status = $request->remarks; 
            $a->transferDate = $request->requestDate;
            $a->orderReleasedBy =  $request->empId;
            $a->orderReleasedOn = $request->requestDate;
            $a->save();   
            
            $hraction='approved';
            
            transferProposal::updateOrCreate(['id' => $id->id],
            ['status' =>$request->remarks,
            'hRRemarks' =>$request->rejectreason,
            'hRAction' =>$hraction,
            'responsibleHR' =>$request->empId]);              
                           
                    
                return redirect('home')->with('page', 'hrTransferReview')
                ->with('success', 'Approved the transfer request successfully!');

}  

if($request->remarks2 == "rejected" ){ 

    $hraction1='rejected';   

    $id = DB::table('transferproposal')->select('id')
    ->where('id',$request->id)
    ->first(); 
    
    transferProposal::updateOrCreate(['id' => $id->id],
    ['status' =>$request->remarks2,
    'hRRemarks' =>$request->rejectreason,
    'hRAction' =>$hraction1,
    'responsibleHR' =>$request->empId]);                  
        
    //mail to user with reason of rejection
        
    return redirect('home')->with('page', 'hrTransferReview')
    ->with('error', 'This transfer request have been rejected!');

}

}
public function relieveEmployee(Request $request)
 {
    // dd($request);
    
        if($request->remarks == "Open" ){                        //&& $request->remarks != ''
           
            $id = DB::table('transferhistory')->select('id')
            ->where('id',$request->id)
            ->first();

            $status='recommended'; 
            
             

        transferHistory::updateOrCreate(['id' => $id->id],
                           ['relievedBy' =>$request->empId,
                           'relievedOn' =>$request->requestDate]);  

         return redirect('home')
         ->with('success','You have Relieved the employee');

 }

 else{
    return redirect('home')->with('Sorry','Recommendation Failed');  
 }

}


public function updateTransferHistory(Request $request)
 {

    $id = DB::table('transferhistory')->select('id')
    ->where('id',$request->id)
    ->first();
      
    $status='Closed';

    transferHistory::updateOrCreate(['id' => $id->id],
                   ['joinedOn' =>$request->joinedOn,
                   'joiningAcceptedBy' =>$request->empId,
                   'joiningAcceptedOn' =>$request->joiningAcceptedOn,
                   'status' =>$status]);

$UpdateOffice = DB::table('transferhistory')
              ->select('transferTo')
              ->where('id',$request->id)
              ->first();

$empId = DB::table('transferhistory')
              ->select('empId')
              ->where('id',$request->id)
              ->first();    
    
DB::update('update users set office = ? where empId = ?', [$UpdateOffice->transferTo, $empId->empId]);

return redirect('home')->with('page','employeeJoining')
 ->with('success','You have save the joining date and approve it!');


 }



}