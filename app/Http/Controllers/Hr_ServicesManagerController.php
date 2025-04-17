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

class Hr_ServicesManagerController extends Controller
{
  public function index(Request $request)
  {
      if ($request->ajax()) {
          $query = DB::table('hrservice')
          ->join('officedetails','officedetails.id','hrservice.officeId')
          ->join('users','users.empId','hrservice.createdBy')
        //   ->join('officeunder','officeunder.office','=','hrservice.officeId')
          
          ->select('hrservice.*','longOfficeName','empName')
          ->where('hrservice.status','=','Processing')
        //   ->where('officeunder.head',Auth::user()->empId) 
          ->where('cancelled','=','No');
          
  
          if (!empty($request->serviceType)) {
              $query->where('serviceType', $request->serviceType);
          }
  
          $review = $query->get();
  
          return datatables()->of($review)->make(true);
      }
        
  }

  //Manager or head
  public function Manager_hrservice(Request $request)
  {
    $id = DB::table('hrservice')->where('id', $request->id)->value('id');
    if (!$id) return back()->with('error', 'Invalid HR Service ID');

    if (!in_array($request->status, ['Recommended', 'Approved', 'Rejected']) || empty($request->remarks)) {
        return response()->json(['success' => false, 'message' => 'You cannot leave the remarks field empty!!']);
        //return redirect('home')->with('page', 'ManagerReview')->with('error', 'You cannot leave the remarks field empty!!');
    }

    // Save to approval table
    HR_Service_Approval::create([
        'noteId' => $id,
        'modifier' => $request->empId,
        'remarks' => $request->remarks,
        'modiType' => $request->status,
        ]);

    // Update status
    HR_Service::updateOrCreate(['id' => $id], ['status' => $request->status]);

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
        case 'Recommended':
            $supervisorEmail = DB::table('employeesupervisor')
                ->where('employee', $user->empId)
                ->value('emailId');

            $mailData['body1'] = "You have a request for <b>$noteTitle</b> recommended by the manager {$userDetail->empName} bearing employee Id {$userDetail->empId} of {$userDetail->longOfficeName}.";
            $mailData['body4'] = 'click here: http://hris.bpc.bt';

            Mail::to($supervisorEmail)->cc($userEmail)->send(new MyTestMail($mailData));

           return response()->json(['success' => true]);

        case 'Approved':
            $mailData['body1'] = "Your request for <b>$noteTitle</b> has been approved by the manager {$userDetail->empName} bearing employee Id {$userDetail->empId} of {$userDetail->longOfficeName}.";
            $mailData['body5'] = 'Have a great day!';

            Mail::to($userEmail)->send(new MyTestMail($mailData));

            return response()->json(['success' => true]);

        case 'Rejected':
            $mailData['title'] = 'Mail From the HRIS System Reject';
            $mailData['body1'] = "Your request for <b>$noteTitle</b> has been rejected by the manager {$userDetail->empName} bearing employee Id {$userDetail->empId} of {$userDetail->longOfficeName}.";
            $mailData['body3'] = 'Reason: ' . $request->remarks;
            $mailData['body4'] = 'click here: http://hris.bpc.bt';
            $mailData['body5'] = 'Never give up. Great things take time';

            Mail::to($userEmail)->send(new MyTestMail($mailData));

            return response()->json(['success' => true]);

            }
}

     
}

?>