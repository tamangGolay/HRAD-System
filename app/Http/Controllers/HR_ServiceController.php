<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\MyTestMail;
use App\HR_Service;
use App\HR_Service_Approval;
 
// Add more models as needed

class HR_ServiceController extends Controller
{
    public function index(Request $request)
  {
      if ($request->ajax()) {
          $query = DB::table('hrservice')
          ->join('officedetails','officedetails.id','hrservice.officeId')
          ->join('users','users.empId','hrservice.createdBy')
        //   ->join('officeunder','officeunder.office','=','hrservice.officeId')
          
          ->select('hrservice.*','longOfficeName','empName')
          ->where('hrservice.status','=','Approved')
        //   ->where('officeunder.head',Auth::user()->empId)
          ->where('cancelled','=','No');
          
  
          if (!empty($request->serviceType)) {
              $query->where('serviceType', $request->serviceType);
          }
  
          $review = $query->get();
  
          return datatables()->of($review)->make(true);
      }        
  }


    public function Request_HrServices(Request $request)
    {
        //dd($request);

        $empId = Auth::user()->empId;
        $officeId = Auth::user()->office;

        $supervisorEmail = DB::table('employeesupervisor')
            ->select('emailId')
            ->where('employee', $empId)
            ->first();

        $userDetail = DB::table('users')
            ->join('officedetails', 'officedetails.id', '=', 'users.office')
            ->select('users.*', 'officedetails.longOfficeName')
            ->where('users.empId', $empId)
            ->first();

        $supervisorMailContent = [
            'title' => 'Mail From the HRIS System',
            'body' => 'Dear sir/madam,',
            'body1' => 'You have a request for ' . $request->serviceType . ' from ' . $userDetail->empName . 
                       ' bearing employee Id ' . $userDetail->empId . 
                       ' of ' . $userDetail->longOfficeName . '.',
            'body2' => '',
            'body3' => 'Please kindly do the necessary action.',
            'body4' => 'click here: http://hris.bpc.bt',
            'body5' => '',
            'body6' => '',
        ];

        $isOfficeHead = DB::table('employeesupervisor')
            ->where('supervisor', $empId)
            ->exists();

        $officeType = DB::table('officedetails')
            ->where('id', $officeId)
            ->value('officeType');

        // Determine status based on logic
        $status = $this->determineStatus($officeType, $isOfficeHead);

        $model = new HR_Service();

        $model->serviceType = $request->serviceType;
        $model->createdBy = $request->empId;
        $model->emailId = $request->emailId;
        $model->officeId = $request->office;
        $model->justification = $request->justification;
        $model->createdOn = $request->serviceDate;

        if ($status) {
            $model->status = $status;
        }

        $model->save();

        // Send mail
        if ($supervisorEmail) {
            Mail::to($supervisorEmail->emailId)->send(new MyTestMail($supervisorMailContent));
        }

        return redirect('home')
            ->with('page', 'HR_FORMS')
            ->with('success', 'Submitted successfully');
    }

    private function determineStatus($officeType, $isOfficeHead)
    {
        if (!$isOfficeHead) {
            return match($officeType) {
                'Section' => 'Processing',
                'Division' => 'Recommended',
                'Department' => 'GMRecommended',
                default => null,
            };
        } else {
            return match($officeType) {
                'Unit', 'Sub Division', 'Team', 'Substation' => 'Processing',
                'Section' => 'Recommended',
                'Division' => 'GMRecommended',
                'Department' => 'DirectorRecommended',
                default => null,
            };
        }
    } 

    public function getRemarks($id)
    {
        $remarks = DB::table('hrserviceapproval')
                    ->where('noteId', $id)
                    ->get();

        return response()->json($remarks);
    }

    //HR Approved and Rejected function from here

public function HR_hrservice(Request $request)
  {
    $id = DB::table('hrservice')->where('id', $request->id)->value('id');
    if (!$id) return back()->with('error', 'Invalid HR Service ID');

    // if (!in_array($request->status, ['HRApproved', 'Rejected']) || empty($request->remarks)) {
    //     return redirect('home')->with('page', 'ReviewHrService')->with('error', 'You cannot leave the remarks field empty!!');
    // }

    if (!in_array($request->status, ['HRApproved', 'Rejected']) || empty($request->remarks)) {
        return response()->json(['success' => false, 'message' => 'You cannot leave the remarks field empty!!']);
    }

    // Save to approval table
    HR_Service_Approval::create([
        'noteId' => $id,
        'modifier' => $request->empId,
        'remarks' => $request->remarks,
        'modiType' => $request->status,
        ]);
      
        HR_Service::updateOrCreate(
            ['id' => $id],
            ['status' => $request->status]
        );
    
    // Fetch user & note info
    $user = Auth::user();
    $userDetail = DB::table('users')
        ->join('officedetails', 'officedetails.id', '=', 'users.office')
        ->select('users.empName', 'users.empId', 'officedetails.longOfficeName')
        ->where('users.empId', $user->empId)
        ->first();

    $noteTitle = DB::table('hrservice')
        ->join('hrserviceapproval', 'hrserviceapproval.noteId', '=', 'hrservice.id')
        ->where('hrservice.id', $id)
        ->value('serviceType');

    $userEmail = DB::table('hrservice')->where('id', $id)->value('emailId');

    $mailData = [
        'title' => 'Mail From the HRIS System',
        'body' => 'Dear sir/madam,',
        'body1' => '',
        'body2' => '',
        'body3' => '',
        'body4' => '',
        'body5' => '',
        'body6' => '',
    ];

    switch ($request->status) {        
        case 'HRApproved':
            $mailData['body1'] = "Your request for <b>$noteTitle</b> has been approved by the HR focal person {$userDetail->empName} bearing employee Id {$userDetail->empId} of {$userDetail->longOfficeName}. They will contact or mail you on your request.";
            $mailData['body5'] = 'Have a great day!';

             Mail::to($userEmail)->send(new MyTestMail($mailData));

            return response()->json(['success' => true]);

        case 'Rejected':
            $mailData['title'] = 'Mail From the HRIS System Reject';
            $mailData['body1'] = "Your request for <b>$noteTitle</b> has been rejected by the HR Admin {$userDetail->empName} bearing employee Id {$userDetail->empId} of {$userDetail->longOfficeName}.";
            $mailData['body3'] = 'Reason: ' . $request->remarks;
            $mailData['body4'] = 'click here: http://hris.bpc.bt';
            $mailData['body5'] = 'Never give up. Great things take time';

            // Mail::to($userEmail)->send(new MyTestMail($mailData));

            return response()->json(['success' => true]);

    }
}
     

    
}
