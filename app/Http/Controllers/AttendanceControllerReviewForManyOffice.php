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


class AttendanceControllerReviewForManyOffice extends Controller
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
                }
            }

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
                
                 $attendance = $attendance->map(function ($item) use ($reportToOffices, $officeDetailsfull,$officeHead) {

                $office = $officeDetailsfull->firstWhere('id', $item->office_id);
                $item->officeDetails = $office ? $office->officeDetails : null;  // Add the office name to the attendance
               
             //$item->reportToOffice = $reportToOffices->get($item->office_id, null);
             $reportToOffice = $reportToOffices->get($item->office_id, null);
             $item->reportToOffice = $reportToOffice;                  

          
            $item->canApproveReject = false;
            
            // Case 1: Logged-in user is a head of this office (not only their own office)
                 if (in_array($item->office_id, $officeHead->toArray())) {
                      $item->canApproveReject = true;
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
                     
                        // Normal office name filter
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
 
} 
