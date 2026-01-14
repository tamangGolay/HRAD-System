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

class Hr_ServicesCEOController extends Controller
{
  public function index(Request $request)
  {
      if ($request->ajax()) {
          $query = DB::table('hrservice')
          ->join('officedetails','officedetails.id','hrservice.officeId')
          ->join('users','users.empId','hrservice.createdBy')
          ->join('officeunder','officeunder.office','=','hrservice.officeId')
          
          ->select('hrservice.*','officeDetails','empName')

          ->where(function ($query) {
            $query->where('hrservice.status', 'DirectorRecommended')
            // below line only for 3 employee under ceo, added on 14/01/2026
                ->orWhere(function ($q) {
              $q->where('hrservice.status', 'Processing')
                ->where('hrservice.officeId', 83);
                    });
            })

          ->where('officeunder.head',Auth::user()->empId)
          ->where('cancelled','=','No');
          
  
          if (!empty($request->serviceType)) {
              $query->where('serviceType', $request->serviceType);
          }
  
          $review = $query->get();
  
          return datatables()->of($review)->make(true);
      }        
  }

  
  public function CEO_hrservice(Request $request)
  {
    $id = DB::table('hrservice')->where('id', $request->id)->value('id');
    if (!$id) return back()->with('error', 'Invalid HR Service ID');

    if (!in_array($request->status, ['Approved', 'Rejected']) || empty($request->remarks)) {
        return response()->json(['success' => false, 'message' => 'You cannot leave the remarks field empty!!']);
        //return redirect('home')->with('page', 'CEOReviewHrService')->with('error', 'You cannot leave the remarks field empty!!');
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
        ->select('users.empName', 'users.empId', 'officedetails.officeDetails')
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
        case 'Approved':
            $mailData['body1'] = "Your request for <b>$noteTitle</b> has been approved by the CEO Mr.{$userDetail->empName}. The HR focal will now review your request and proceed accordingly.";
            $mailData['body5'] = 'Have a great day!';

            Mail::to($userEmail)->send(new MyTestMail($mailData));


              // ✅ Email to Hr person for notification purpose (tsheringchoden@bpc.bt)
            $HR_Focal_Email = 'tashidema@bpc.bt'; 
            $HR_MailData['title'] = "Approval Notification for $noteTitle";
            $HR_MailData['body'] = "Dear sir/madam,";            
            $HR_MailData['body1'] = "The HR Services request titled <b>$noteTitle</b> submitted by {$userDetail->empName} has been <strong>approved</strong> by CEO.";
            $HR_MailData['body2'] = 'Please do necessary action.';
            $HR_MailData['body3'] = '';
            $HR_MailData['body4'] = '';
            $HR_MailData['body5'] = 'Regards, HR System Notification';
            $HR_MailData['body6'] = '';

            Mail::to($HR_Focal_Email)->send(new MyTestMail($HR_MailData));

            return response()->json(['success' => true]);

        case 'Rejected':
            $mailData['title'] = 'Mail From the HRIS System Reject';
            $mailData['body1'] = "Your request for <b>$noteTitle</b> has been rejected by the CEO Mr.{$userDetail->empName}.";
            $mailData['body3'] = 'Reason: ' . $request->remarks;
            $mailData['body4'] = 'click here: http://hris.bpc.bt';
            $mailData['body5'] = 'Never give up. Great things take time';

            Mail::to($userEmail)->send(new MyTestMail($mailData));

            return response()->json(['success' => true]);

            }
}
     
}

?>