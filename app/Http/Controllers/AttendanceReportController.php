<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceReportController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            // Get the selected month (e.g., "january")
            $selectedMonth = strtolower($request->filter_month);
            $tableName = "attendance_" . $selectedMonth;

            $attendance = collect();

            // Check if the table exists
            $tableExists = DB::connection('mysql2')->select("SHOW TABLES LIKE '$tableName' ");
           
            if ($tableExists) {
                $attendance = DB::connection('mysql2')
                    ->table($tableName . ' as a')
                    ->select('a.*')
                    ->get();

                $officeDetailsfull = DB::connection('mysql')
                    ->table('officedetails')
                    ->pluck('officeDetails', 'id');

                // Attach officeDetails manually
                $attendance->transform(function ($item) use ($officeDetailsfull) {
                    $item->officeDetails = $officeDetailsfull[$item->office_id] ?? null;
                    return $item;
                });

                // Apply office name filter if provided
                if (!empty($request->office_name)) {
                    $attendance = $attendance->filter(function ($item) use ($request) {
                        return stripos($item->officeDetails, $request->office_name) !== false;
                    })->values(); // reindex
                }

                return datatables()->of($attendance)->make(true);
            } else {
                return response()->json([
                    'message' => 'No attendance table found for the selected month.',
                    'data' => []
                ]);
            }
        }

        return response()->json([
            'message' => 'Invalid request.',
            'data' => []
        ]);
    }
}
