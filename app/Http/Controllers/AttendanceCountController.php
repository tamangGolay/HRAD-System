<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;


class AttendanceCountController extends Controller
{
    function index(Request $request)
    {      

        if (request()->ajax()) {
            // Get the offices where the current user is the head
            $officeHead = DB::connection('mysql')->table('officeunder')
                ->where('head', Auth::user()->empId)
                ->pluck('office');

            if ($officeHead->isEmpty()) {
                return response()->json([
                    'message' => 'No offices found for the current user.',
                    'data' => []
                ]);
            }

            // Get the selected month (e.g., "January")
            $selectedMonth = $request->filter_month;
            $tableName = "attendance" . $selectedMonth."_counter";          
           
            $attendance = collect();
            
            // Check if the table exists
            // if (Schema::connection('mysql2')->hasTable($tableName)) {
            if (DB::connection('mysql2')->select("SHOW TABLES LIKE '$tableName'")) {


                $attendance = DB::connection('mysql2')
                    ->table($tableName . ' as a')
                    ->whereIn('a.office_id', $officeHead)
                    ->select('a.*', 'a.office_id')
                    ->get();
            }

            $officeIdsFromAttendance = $attendance->pluck('office_id')->unique();
            
            $reportToOffices = DB::connection('mysql')
                ->table('officemaster')
                ->whereIn('id', $officeIdsFromAttendance)
                ->pluck('reportToOffice', 'id');
            
            $officeDetailsfull = DB::connection('mysql')
                ->table('officedetails as o')
                ->whereIn('o.id', $officeHead)
                ->select('o.id', 'o.officeDetails')
                ->get();
            
            $attendance = $attendance->map(function ($item) use ($reportToOffices, $officeDetailsfull) {
                $office = $officeDetailsfull->firstWhere('id', $item->office_id);
                $item->officeDetails = $office ? $office->officeDetails : null;
                $item->reportToOffice = $reportToOffices->get($item->office_id, null);
                return $item;
            });
            // replaced all longoffice name with officeDetails
            // Apply office name filter if provided
            if (!empty($request->office_name)) {
                $attendance = $attendance->filter(function ($item) use ($request) {
                    return stripos($item->officeDetails, $request->office_name) !== false;
                });
            }
            
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
