<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AttendanceCountController extends Controller
{
    public function index(Request $request)
{
    if ($request->ajax()) {

        $month  = $request->filter_month;   // 1–12
        $year   = $request->filter_year;    // YYYY
        $office = $request->office_name;


        // ✅ Check if all 3 filters are selected
        if (empty($month) || empty($year) || empty($office)) {
            return response()->json([
                'data' => [] // empty table
            ]);
        }

        // Base query from SINGLE VIEW
        $attendance = DB::connection('mysql2')
            ->table('attendance_counter as a')
            ->select('a.*')
            ->when($month, fn($q) => $q->where('a.month_number', $month))
            ->when($year, fn($q) => $q->where('a.year', $year))
            ->get();

        // Attach officeDetails manually
        $officeDetailsfull = DB::connection('mysql')
            ->table('officedetails')
            ->pluck('officeDetails', 'id');

        $attendance->transform(function ($item) use ($officeDetailsfull) {
            $item->officeDetails = $officeDetailsfull[$item->office_id] ?? null;
            return $item;
        });

        // Apply office filter
        if (!empty($office)) {
            $attendance = $attendance->filter(function ($item) use ($office) {
                return stripos($item->officeDetails, $office) !== false;
            })->values(); // reindex
        }

        return datatables()->of($attendance)
            ->rawColumns([]) // optional
            ->make(true);

    } else {
        return response()->json([
            'message' => 'No attendance table found for the selected month.',
            'data' => []
        ]);
    }
}
}
