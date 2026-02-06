<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\AttendanceMail;
use App\User;


class AttendanceController extends Controller
{

    function index(Request $request)
    {
        if (request()->ajax()) {
            // Get the offices where the current user is the head
            $officeHead = DB::connection('mysql')
                ->table('officeunder')
                ->where('head', Auth::user()->empId)
                ->pluck('office');

            // If no offices are found, return this
            if ($officeHead->isEmpty()) {
                return response()->json([
                    'message' => 'No offices found for the current user.',
                    'data' => []
                ]);
            }

            
            $attendance = collect();
            
                $tableName = "attendance_record"; 

             
                    $records = DB::connection('mysql2')
                        ->table($tableName . ' as a')
                        ->whereIn('a.office_id', $officeHead)
                        ->where('a.user_id', '!=', Auth::user()->empId) // 👈 Exclude self
                        
                        ->whereNull('a.status')
                        ->where(function ($query) {
                            $query->where('a.checkin_status', 'Late')
                                ->orWhere('a.checkout_status', 'Early')
                                ->orWhere('a.checkout_status', 'NA')
                                ->orWhere('a.checkin_status', 'Absent');
                        })

                        ->select('a.*', 'a.office_id')
                        ->get();

                    $attendance = $attendance->merge($records);
                // }
            // }

            // Only apply "yesterday" filter if no date filter is provided
            if (empty($request->filter_startdate) && empty($request->filter_enddate)) {
                $yesterday = Carbon::yesterday()->format('Y-m-d');
                // dd($yesterday);
                $attendance = $attendance->filter(function ($item) use ($yesterday) {
                    return $item->date == $yesterday;
                });
            }


            $officeIdsFromAttendance = $attendance->pluck('office_id')->unique();

            $reportToOffices = DB::connection('mysql')
                ->table('officemaster')
                ->whereIn('id', $officeIdsFromAttendance)
                ->pluck('reportToOffice', 'id');

            // Fetch office details from mysql
            $officeDetailsfull = DB::connection('mysql')
                ->table('officedetails as o')
                ->whereIn('o.id', $officeHead)
                ->select('o.id', 'o.officeDetails')
                ->get();
                
            $officeUnderHeads = DB::connection('mysql')
                ->table('officeunder')
                ->pluck('head'); // office => head            

                // Maps office => head
      $officeHeadMapping = DB::connection('mysql')
                ->table('officeunder')
                ->get()
                ->groupBy('office')
                ->map(function ($group) {
                    return $group->pluck('head')->toArray(); // get all heads as array per office
                });

            $attendance = $attendance->map(function ($item) use ($reportToOffices, $officeDetailsfull,$officeHead,$officeUnderHeads,$officeHeadMapping) {

                $office = $officeDetailsfull->firstWhere('id', $item->office_id);
                $item->officeDetails = $office ? $office->officeDetails : null;  // Add the office name to the attendance
               
             //$item->reportToOffice = $reportToOffices->get($item->office_id, null);
             $reportToOffice = $reportToOffices->get($item->office_id, null);
             $item->reportToOffice = $reportToOffice;                  

            $authOfficeId = Auth::user()->office;
            $authUserId = Auth::user()->empId;
            $item->canApproveReject = false;
            
         // ✅ Case 1: Logged-in user is working in their own office and is one of the office heads
  
                    if (
                    $item->office_id == $authOfficeId &&
                    in_array($authOfficeId, $officeHead->toArray())
                     ) {
                  
                     $item->canApproveReject = true;
                    }
        // ✅ Case 2: The user (item->user_id) is a head of a sub-office,and that sub-office reports to the logged-in user's office

                    elseif (($officeUnderHeads->contains($item->user_id)) && $reportToOffice == $authOfficeId)
                    {
                    $item->canApproveReject = true;

                   }
    // ✅ Case 3: The logged-in user is one of the heads of the item's office, and that office reports to the logged-in user's office
                   
                //     elseif (
                //         isset($officeHeadMapping[$item->office_id]) &&
                //         in_array($authUserId, $officeHeadMapping[$item->office_id]) &&
                //         $reportToOffice == $authOfficeId)
                        
                //         {

                //         $item->canApproveReject = true;
                //    }
                    else {
                          $item->canApproveReject = false;
                    }
              
                return $item;
            });


            // ✅ Only keep records the user is allowed to review
            $attendance = $attendance->filter(function ($item) {
                return $item->canApproveReject === true;
            })->values(); // 👈 Reindex collection

            // Apply filters for start and end date if provided
            if (!empty($request->filter_startdate) && !empty($request->filter_enddate)) {
                $attendance = $attendance->filter(function ($item) use ($request) {
                    return $item->date >= $request->filter_startdate && $item->date <= $request->filter_enddate;
                });
            }

            // Apply office name filter if provided with Direct report as new office list
                if (!empty($request->office_name)) {
                    if ($request->office_name === 'Direct Report') {
                        $authOfficeId = Auth::user()->office;
                        $authUserId = Auth::user()->empId;

                        $attendance = $attendance->filter(function ($item) use ($authOfficeId, $authUserId, $officeUnderHeads, $reportToOffices) {
                            // ✅ Condition 1: User is in the same office as logged in user                           
                            if ($item->office_id == $authOfficeId && $item->user_id != $authUserId) {
                                return true;
                            }

                            // ✅ Condition 2: User is a head, and their office reports to logged-in user’s office
                            if ($officeUnderHeads->contains($item->user_id) && $item->reportToOffice == $authOfficeId) {
                                return true;
                            }

                            return false;
                        });
                    } else {
                        // Normal office name filter
                        $attendance = $attendance->filter(function ($item) use ($request) {
                            return stripos($item->officeDetails, $request->office_name) !== false;
                        });
                    }
                }


            // if (!empty($request->office_name)) {
            //     $attendance = $attendance->filter(function ($item) use ($request) {
            //         return stripos($item->officeDetails, $request->office_name) !== false;
            //     });
            // }

            // If no records found
            if ($attendance->isEmpty()) {
                return response()->json([
                    'message' => 'No attendance records found for the selected criteria.',
                    'data' => []
                ]);
            }

            return datatables()->of($attendance)->make(true);
        }
    }
 
    public function updateStatus(Request $request)
    {
        ($request);

        $validated = $request->validate([
            'id' => 'required',
            'date' => 'required|date', 
            'status' => 'required|string',
            'remark' => 'nullable|string'
        ]);

        $date = $validated['date'];  
        $status = $validated['status'];
        $remark = $validated['remark']; // Get remark input
        
        //added on 8th september 2025
        $authUserEmpId = Auth::user()->empId;

      
        $table_name = 'attendance_record';

        $model = DB::connection('mysql2')->table($table_name);

        $query = $model->where('id', $request->id)
        ->update([
            'status' => $status,
            'remarks_supervisor' => $remark, // Save remark
            'modifiedBy' => $authUserEmpId,
        ]);

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }

    public function updateStatusReject(Request $request)
    {
        
        $validated = $request->validate([
            'id' => 'required',
            'date' => 'required|date', 
            'status' => 'required|string',
            // 'remarkReject' => 'nullable|string'
        ]);

        $date = $validated['date'];  
        $status = $validated['status'];
        // $remark = $validated['remarkReject'];

        //added on 15th september 2025
        $authUserEmpId = Auth::user()->empId;

        $table_name = 'attendance_record';

        $model = DB::connection('mysql2')->table($table_name);

        $GETemailID = $model->where('id', $request->id)->first();

        if ($GETemailID) {
            // Fetch the emailID from the 'users' table based on empID = user_id
            $emailID = DB::connection('mysql')->table('users')
                ->where('empId', $GETemailID->user_id)
                ->value('emailId'); // Get only the emailID value        
            // Add emailID to the attendance record
            $GETemailID->emailID = $emailID ?? null;
        }  

        // $mailContent = ['title' => 'Mail From the Attendance System ( Office Attendance Notification )', 'body' => 'Dear sir/madam,', 
        //                                                                                             'body1' => 'This is to inform you that you reported late to the office on date <b>' . $request->date . '</b>',                                                                                                    
        //                                                                                             'body2' => '',
        //                                                                                             'body3' => '',
        //                                                                                             // 'body3' => 'Remarks: <b>' . $request->remarkReject . '</b>',
        //                                                                                             'body4' => '<b>Please be mindful of your check-in and check-out, as repeated offenses may result in complications.</b>', ];                                                                                                 
                                                                                                    


        // Mail::to($GETemailID->emailID)              // send to this address:GETemailID
        // ->send(new AttendanceMail($mailContent));           //mail content 
        
      
                           
        $query = $model->where('id', $request->id)
        ->update([
            'status' => $status,
            'modifiedBy' => $authUserEmpId,

            // 'remarks_supervisor' => $remark 
            // Save remark
        ]);
        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }

    //reset device id
    public function resetDevice(Request $request)
{
    $empId = $request->input('empId');
    $employee = User::where('empId', $empId)->first();

    if (!$employee) {
        return response()->json(['message' => 'Employee not found.'], 404);
    }

    $employee->deviceId = null;
    $employee->save();

    return response()->json(['message' => 'Device ID reset successfully.']);
}

}
