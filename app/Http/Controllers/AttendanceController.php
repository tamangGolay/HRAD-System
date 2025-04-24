<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Mail;
use App\Mail\AttendanceMail;
use App\User;


class AttendanceController extends Controller
{

    function index(Request $request)
    {
        if (request()->ajax()) {
            // Get the offices where the current user is the head
            $officeHead = DB::connection('mysql')->table('officeunder')
                ->where('head', Auth::user()->empId)
                ->pluck('office');

            // If no offices are found, return this
            if ($officeHead->isEmpty()) {
                return response()->json([
                    'message' => 'No offices found for the current user.',
                    'data' => []
                ]);
            }

            // Determine the range of months based on filter dates
            $startDate = Carbon::parse($request->filter_startdate ?? now()->startOfMonth());
            $endDate = Carbon::parse($request->filter_enddate ?? now());

            $months = [];
            while ($startDate->lessThanOrEqualTo($endDate)) {
                $months[] = strtolower($startDate->format('F')); // Get full month name
                $startDate->addMonth();
            }

            // Fetch attendance data from all relevant tables
            $attendance = collect();
            foreach ($months as $month) {
                $tableName = "attendance_$month"; 

                // Check if table exists to avoid errors
                if (Schema::connection('mysql2')->hasTable($tableName)) {
                    $records = DB::connection('mysql2')
                        ->table($tableName . ' as a')
                        ->whereIn('a.office_id', $officeHead)
                        ->select('a.*', 'a.office_id')
                        ->get();

                    $attendance = $attendance->merge($records);
                }
            }

            // ** Filter the dataset to include only yesterday's records : added at last**
            // $yesterday = Carbon::yesterday()->format('Y-m-d');
            // $attendance = $attendance->filter(function ($item) use ($yesterday) {
            //     return $item->date == $yesterday;
            // });

            // Only apply "yesterday" filter if no date filter is provided
            if (empty($request->filter_startdate) && empty($request->filter_enddate)) {
                $yesterday = Carbon::yesterday()->format('Y-m-d');
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


            $attendance = $attendance->map(function ($item) use ($reportToOffices, $officeDetailsfull) {

                $office = $officeDetailsfull->firstWhere('id', $item->office_id);
                $item->officeDetails = $office ? $office->officeDetails : null;  // Add the office name to the attendance
               
                // Add reportToOffice info

                $item->reportToOffice = $reportToOffices->get($item->office_id, null);
                return $item;
            });

            // Apply filters for start and end date if provided
            if (!empty($request->filter_startdate) && !empty($request->filter_enddate)) {
                $attendance = $attendance->filter(function ($item) use ($request) {
                    return $item->date >= $request->filter_startdate && $item->date <= $request->filter_enddate;
                });
            }

            // Apply office name filter if provided
            if (!empty($request->office_name)) {
                $attendance = $attendance->filter(function ($item) use ($request) {
                    return stripos($item->officeDetails, $request->office_name) !== false;
                });
            }

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

        $month = Carbon::parse($date)->format('F');

        $table_name = 'attendance_' . strtolower($month);

        $model = DB::connection('mysql2')->table($table_name);

        $query = $model->where('id', $request->id)
        ->update([
            'status' => $status,
            'remarks_supervisor' => $remark // Save remark
        ]);

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }

    public function updateStatusReject(Request $request)
    {
        
        $validated = $request->validate([
            'id' => 'required',
            'date' => 'required|date', 
            'status' => 'required|string',
            'remarkReject' => 'nullable|string'
        ]);

        $date = $validated['date'];  
        $status = $validated['status'];
        $remark = $validated['remarkReject'];

        $month = Carbon::parse($date)->format('F');

        $table_name = 'attendance_' . strtolower($month);

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

        $mailContent = ['title' => 'Mail From the Attendance System ( Office Attendance Notification )', 'body' => 'Dear sir/madam,', 
                                                                                                    'body1' => 'This is to inform you that you reported late to the office on date <b>' . $request->date . '</b>',                                                                                                    
                                                                                                    'body2' => 'Kindly review the remarks provided by your supervisor below.',
                                                                                                    'body3' => 'Remarks: <b>' . $request->remarkReject . '</b>',
                                                                                                    'body4' => '<b>Please be mindful of your check-in and check-out, as repeated offenses may result in complications.</b>', ];                                                                                                 
                                                                                                    


        Mail::to($GETemailID->emailID)              // send to this address:GETemailID
        ->send(new AttendanceMail($mailContent));           //mail content 
        
      
                           
        $query = $model->where('id', $request->id)
        ->update([
            'status' => $status,
            'remarks_supervisor' => $remark // Save remark
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
