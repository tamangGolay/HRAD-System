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
}