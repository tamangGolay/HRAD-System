<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\vehiclerequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class VehicleController extends Controller
{

public function Request_vehicle(Request $request)
{
    DB::beginTransaction();
    
    try{

    $Request_vehicle = new vehiclerequest;
    $Request_vehicle->emp_id = $request->emp_id;
    $Request_vehicle->vname = $request->name;
    $Request_vehicle->office_id = $request->office;
    $Request_vehicle->email = $request->email;
    $Request_vehicle->vehicleId = $request->vehicle;
    $Request_vehicle->start_date = $request->start_date;
    $Request_vehicle->end_date = $request->end_date;
    $Request_vehicle->dateOfRequisition = $request->date_of_requisition;
    $Request_vehicle->purpose = $request->purpose;
    $Request_vehicle->placesToVisit = $request->places_to_visit;
    $Request_vehicle->personalvehicle = $request->input('role');

    $status = null;
    // $Request_vehicle->save();

    $officeId = Auth::user()->office;
    $userOfficeName = DB::table('officedetails')->where('id', $request->office)->value('officeDetails');
    $officeType = DB::table('officedetails')->where('id', $officeId)->value('officeType');

    $isOfficeHead = DB::table('officemaster')->where('officeHead', $request->emp_id)->exists();

    $headDetails = DB::table('users')
        ->join('officedetails', 'users.office', '=', 'officedetails.id')
        ->whereIn('users.empId', function ($query) use ($officeId) {
            $query->select('head')->from('officeunder')->where('office', $officeId);
        })
        ->select('users.empId', 'users.emailId', 'officedetails.officeType as headOfficeType')
        ->get();

    // Send email based on officeType and role
    if (in_array($officeType, ['Team', 'Section', 'Unit', 'Sub Division', 'Substation'])) {
          $status = 'Processing';
        $this->sendMailToStakeholders($request, $userOfficeName, $headDetails->firstWhere('headOfficeType', 'Division')?->emailId);
    } elseif ($isOfficeHead && $officeType === 'Division') {
        $status = 'GMProcessing';
        $this->sendMailToStakeholders($request, $userOfficeName, $headDetails->firstWhere('headOfficeType', 'Department')?->emailId);
    } elseif ($officeType === 'Division' && !$isOfficeHead) {
         $status = 'Processing';
        $this->sendMailToStakeholders($request, $userOfficeName, $headDetails->firstWhere('headOfficeType', 'Division')?->emailId);
    } elseif (!$isOfficeHead && $officeType === 'Department') {
         $status = 'GMProcessing';
        $this->sendMailToStakeholders($request, $userOfficeName, $headDetails->firstWhere('headOfficeType', 'Department')?->emailId);
    }

    // For CEO-specific reporting
    $reportToOffice = DB::table('officemaster')->where('officeHead', $request->emp_id)->value('reportToOffice');
    if ($reportToOffice == 1) {
         $status = 'DirectorProcessing';
        $CEOEmail = DB::table('users')->where('empId', DB::table('officemaster')->where('id', 1)->value('officeHead'))->value('emailId');
        $this->sendMailToStakeholders($request, $userOfficeName, $CEOEmail);
    }

    if (is_null($status)) {
    throw new \Exception("Unable to determine the approval flow. Please contact IT support.");
    }

    $Request_vehicle->status = $status;
    $Request_vehicle->save();

    DB::commit();

        return back()->with('success', 'Vehicle request submitted successfully.');
    } catch (Exception $e) {
        DB::rollBack();

        Log::error('Vehicle request failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        return back()->with('error', 'Failed to process the vehicle request. Please try again.');
    }

}

// Helper: Mail content for user
private function getUserMailContent($request)
{
    return [
        'title' => 'Mail From the BPC System',
        'body' => 'Dear ' . $request->name . ',',
        'body1' => 'Your vehicle booking initiated on ' . $request->date_of_requisition . ' has been processed, kindly wait for the notice.',
        'body2' => 'Note',
        'body3' => '*If the request is rejected by supervisor, you will be notified otherwise you will receive notification from MTO only.',
        'body4' => '',
        'body5' => '',
        'body6' => '',
    ];
}

// Helper: Mail content for approver/head
private function getHeadMailContent($request, $userOfficeName)
{
    return [
        'title' => 'Mail From the BPC System',
        'body' => 'Dear sir/madam,',
        'body1' => 'You have a request for vehicle requisition from ' . $request->name . ' bearing employee Id ' . $request->emp_id . ' of ' . $userOfficeName . '.',
        'body2' => '',
        'body3' => 'Please kindly do the necessary action.',
        'body4' => 'click here: http://booking.bpc.bt',
        'body5' => '',
        'body6' => '',
    ];
}

// Helper: Send mail to employee, head, and backup
private function sendMailToStakeholders($request, $userOfficeName, $headEmail = null)
{
    Mail::to($request->email)->send(new MyTestMail($this->getUserMailContent($request)));

    $headContent = $this->getHeadMailContent($request, $userOfficeName);

    if ($headEmail) {
        Mail::to($headEmail)->send(new MyTestMail($headContent));
    }

    Mail::to('bosebackup1@gmail.com')->send(new MyTestMail($headContent));
}


    // Vehicle approve by supervisor
    public function vehicleapprove(Request $request)

    {
        //  dd($request->id);
        $id = DB::table('vehiclerequest')->select('id')
            ->where('id', $request->id)
            ->first();

        $officeDetails = DB::table('vehiclerequest')
            ->join('officedetails', 'officedetails.id', '=', 'vehiclerequest.office_id')                    
            ->where('vehiclerequest.id', '=', $request->id)
            ->select('officeDetails')   
            ->first();

            // update supervisor id to track supervior
        $supervisior = Auth::id();
        DB::update('update vehiclerequest set supervisor = ? where id = ?', [$supervisior, $id->id]);

        // DB::commit(); update status
        DB::table('vehiclerequest')
        ->where('id', $request->id)
        ->update(['status' => 'Supervisor Approved']);


        $name = DB::table('vehiclerequest')->select('vname')
            ->where('id', $request->id)
            ->first();

        $emp_id = DB::table('vehiclerequest')->select('emp_id')
            ->where('id', $request->id)
            ->first();

        $mtoMailContent = ['title' => 'Mail From the BPC System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for vehicle requisition from ' . $name->vname . ' bearing employee Id ' . $emp_id->emp_id . ' of  ' . $officeDetails->officeDetails . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: http://booking.bpc.bt','body5' => '','body6' => '', ];

        Mail::to('tashidema@bpc.bt')    //MTO
            ->send(new MyTestMail($mtoMailContent));

        Mail::to('bosebackup1@gmail.com')
            ->send(new MyTestMail($mtoMailContent));
    
            return redirect('home')
            ->with('success', 'You have approved the vehicle requisition');
    }       

     //vehicle reject(supervisor)
    public function vehiclereject(Request $request)
    {

        $id = DB::table('vehiclerequest')->select('id')
            ->where('id', $request->id)
            ->first();       

        $reason = $request->reason;
        DB::update('update vehiclerequest set reason = ? where id = ?', [$reason, $id->id]);

        $supervisior = Auth::id();
        DB::update('update vehiclerequest set supervisor = ? where id = ?', [$supervisior, $id->id]);

        DB::table('vehiclerequest')
            ->where('id', $request->id)
            ->update(['status' => 'Supervisor Rejected']);
       
        $name = DB::table('vehiclerequest')->select('vname')
            ->where('id', $request->id)
            ->first();

        $reqDate = DB::table('vehiclerequest')->select('dateOfRequisition')
            ->where('id', '=', $request->id)
            ->first();
     
        $employee = ['title' => 'Mail From the BPC System(Supervisor)', 'body' => 'Dear ' . $name->vname . ',', 'body1' => 'We are sorry to inform you that, your request for vehicle requisition initiated on ' . $reqDate->dateOfRequisition . ' could not be approved. ', 'body2' => ' ', 'body3' => ' Remarks: ' .$request->reason,'body4' => '','body5' => '','body6' => '', ];

        $email = DB::table('vehiclerequest')->select('email')
            ->where('id', '=', $request->id)
            ->first();

        Mail::to($email->email)
            ->send(new MyTestMail($employee));

        Mail::to('bosebackup1@gmail.com')
            ->send(new MyTestMail($employee));       

            return redirect('home')
            ->with('error', 'You have rejected the vehicle requisition!!');
        }          
            
     
    //MTOVehicle approve
    public function MTOapprove(Request $request)
    {
        // dd($request->vehicle);
	    
        $id = DB::table('vehiclerequest')->select('id')
            ->where('id', $request->idl)
            ->first();

        $mto = Auth::id();
        DB::update('update vehiclerequest set mto = ? where id = ?', [$mto, $id->id]);

        // DB::commit(); and update status
        DB::table('vehiclerequest')
            ->where('id', $request->idl)
             ->update(['status' => 'MTO Approved']);

        $name = DB::table('vehiclerequest')->select('vname')
            ->where('id', $request->idl)
            ->first();
        
        $start_date = DB::table('vehiclerequest')->select('start_date')
            ->where('id', $request->idl)
            ->first();

        $end_date = DB::table('vehiclerequest')->select('end_date')
            ->where('id', $request->idl)
            ->first();

        $email = DB::table('vehiclerequest')->select('email')
            ->where('id', $request->idl)
            ->first();

        $emp_id = DB::table('vehiclerequest')->select('emp_id')
            ->where('id', $request->idl)
            ->first();
        
        $placesToVisit = DB::table('vehiclerequest')->select('placesToVisit')
            ->where('id', $request->idl)
            ->first();

        $officedetails = DB::table('vehiclerequest')
           ->join('officedetails', 'officedetails.id','=','vehiclerequest.office_id')
            ->select('officeDetails')
            ->where('vehiclerequest.id', $request->idl)
            ->first();

        $reqDate = DB::table('vehiclerequest')->select('dateOfRequisition')
            ->where('id', '=', $request->idl)
            ->first();

        $vehicle_name = DB::table('vehicledetails')
            ->select('vehicle_name')
            ->where('vehicledetails.id', '=', $request->vehicle)
            ->first();

        $vehicle_id = DB::table('vehicledetails')
            ->select('id')
            ->where('vehicledetails.id', '=', $request->vehicle)
            ->first();
        // dd($vehicle_id->id);  
        DB::update('update vehiclerequest set vehicleId = ? where id = ?', [$vehicle_id->id, $id->id]);

              
        $supervisior = ['title' => 'Mail From the BPC System (From MTO)', 'body' => 'Dear sir,', 'body1' => 'This is to inform you that for the tour to ' . $placesToVisit->placesToVisit.', vehicle ' . $vehicle_name->vehicle_name. ' has beeen assigned to ' . $name->vname . '('.$emp_id->emp_id.' ) of '.$officedetails->officeDetails.' from '.$start_date->start_date. ' to ' .$end_date->end_date. '.', 'body2' => 'Plese keep note of it la!', 'body3' => '  ','body4' => ' ','body5' => ' Motor Transport Officer (MTO)','body6' => 'Wishing you a pleasant journey!', ];

        $employee = ['title' => 'Mail From the BPC System(From MTO)', 'body' => 'Dear ' . $name->vname . ',', 'body1' => 'Your request for vehicle requisition initiated on Date: ' . $reqDate->dateOfRequisition . ' has been approved.', 'body2' => 'Vehicle: '. $vehicle_name->vehicle_name .' has been asigned to you from '.$start_date->start_date. ' to ' .$end_date->end_date. '.', 'body3' => '', 'body4' => ' ','body5' => 'Motor Transport Officer (MTO)','body6' => 'Wishing you a pleasant journey!',];
              

        Mail::to('tashidema@bpc.bt')  //
        ->send(new MyTestMail($supervisior));

        Mail::to('bosebackup1@gmail.com')
        ->send(new MyTestMail($supervisior));
        
        
        Mail::to($email->email)
            ->send(new MyTestMail($employee));        
            
        Mail::to('bosebackup1@gmail.com')
        ->send(new MyTestMail($employee));

        return redirect('home')->with('page','MTO_Review')        
        ->with('success', 'You have assigned the vehicle!!');


    }//end vehicle approve


    
    //MTO reject
    public function MTOreject(Request $request)
    {

    $id = DB::table('vehiclerequest')->select('id')
            ->where('id', '=', $request->idl)
            ->first();

        $supervisior = Auth::id();
        DB::update('update vehiclerequest set supervisor = ? where id = ?', [$supervisior, $id->id]);

        $reason = $request->reason;
        DB::update('update vehiclerequest set reason = ? where id = ?', [$reason, $id->id]);

        DB::update('update vehiclerequest set vehicleId = ? where id = ?', [$request->vehiclename, $id->id]);

        // DB::commit();
        DB::table('vehiclerequest')
            ->where('id', '=', $request->idl)
           ->update(['status' => 'MTO Rejected']);

        $name = DB::table('vehiclerequest')->select('vname')
            ->where('id', '=', $request->idl)
            ->first();

        $email = DB::table('vehiclerequest')
            ->select('email')
            ->where('id', '=', $request->idl)
            ->first();      
      

        $reqDate = DB::table('vehiclerequest')->select('dateOfRequisition')
            ->where('id', '=', $request->idl)
            ->first();

        $employee = ['title' => 'Mail From the BPC System(MTO)', 'body' => 'Dear ' . $name->vname, 'body1' => 'We are sorry to inform you that, your request vehicle requisition initiated on ' . $reqDate->dateOfRequisition . ' is not available. ', 'body2' => 'Reason:', 'body3' => $request->reason, 'body4' => '', 'body5' => ' Motor Transport Officer (MTO)', 'body6' => 'Stay happy!',];

        Mail::to($email->email)
            ->send(new MyTestMail($employee));
    
            Mail::to('bosebackup1@gmail.com')
            ->send(new MyTestMail($employee));                         
             

        return redirect('home')->with('page','MTO_Review')  
        ->with('error', 'You have rejected the vehicle requisition!!');       
      
}//end reject MTO
    


//duration extend vehicle

    public function MTOdurationextend(Request $request)
    {
        // dd($request->vehicle);
	    
        $id = DB::table('vehiclerequest')->select('id')
            ->where('id', $request->idl)
            ->first();      

        // DB::commit();
        $vehicle = DB::table('vehiclerequest')->where('id', $request->idl)
            ->increment('status', 1);   
                   
                
        return redirect('home')->with('success', 'Vehicle is back to HQ and avaliable for use!');
    

    }
//end duration extend

    //editmto
    public function store(Request $request)
    {

        $end1 = $request->end_date;
        $end = date("Y-m-d ", strtotime($end1));

        vehiclerequest::updateOrCreate(['id' => $request->id], ['end_date' => $end]);

        return response()->json(['success' => 'Meeting Room saved successfully.']);
    }

    public function edit($id)
    {

        $conference = vehiclerequest::find($id);
        return response()->json($conference);
    }
 
   
    //MTO data remove from duration extend
    public function MTOrequestremove(Request $request)
    {

         DB::table('vehiclerequest')
            ->where('id', '=', $request->idl)
            ->decrement('status');

            return redirect('home')
            ->with('error', 'You have cancelled the vehicle approved request!');
                          
    }


}


