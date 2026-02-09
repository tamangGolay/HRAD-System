<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AttendanceReportController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $selectedMonth = strtolower($request->filter_month);
            $tableName = "attendance_" . $selectedMonth;

            $tableExists = DB::connection('mysql2')->select("SHOW TABLES LIKE '$tableName' ");

            if ($tableExists) {
                // 🔹 Keep your connection + select, but NO ->get()
                $query = DB::connection('mysql2')
                    ->table($tableName . ' as a')
                    ->select('a.*');

                // Your office details mapping
                $officeDetailsfull = DB::connection('mysql')
                    ->table('officedetails')
                    ->pluck('officeDetails', 'id');


                    // Columns you want searchable (excluding virtual columns)
                $searchableColumns = [
                    'a.empName',
                    'a.user_id',
                    'a.date',
                    'a.check_in_address',
                    'a.check_in_time',
                    'a.checkin_remarks',
                    'a.checkin_status',
                    'a.check_out_address',
                    'a.check_out_time',
                    'a.checkout_remarks',
                    'a.checkout_status',
                    'a.status',
                ];

                return datatables()->of($query)
                    ->addColumn('officeDetails', function ($row) use ($officeDetailsfull) {
                        return $officeDetailsfull[$row->office_id] ?? null;
                    })
                    ->filter(function ($query) use ($request, $officeDetailsfull,$searchableColumns) {
                         $searchValue = trim($request->search['value'] ?? '');
                        $requestedOfficeName = trim($request->office_name);                       
                        


                     // 1️⃣ Global search
                if ($searchValue) {
                    $query->where(function ($q) use ($searchValue, $searchableColumns, $officeDetailsfull) {
                        foreach ($searchableColumns as $col) {
                            $q->orWhere($col, 'like', "%{$searchValue}%");
                        }

                        // 🔹 Virtual column search: officeDetails
                        $matchingOfficeIds = array_keys(
                            $officeDetailsfull->filter(fn($v) => str_contains(strtolower($v), strtolower($searchValue)))->toArray()
                        );
                        if (!empty($matchingOfficeIds)) {
                            $q->orWhereIn('a.office_id', $matchingOfficeIds);
                        }
                    });
                }

                        if (!empty($requestedOfficeName)) {
                            if ($requestedOfficeName === 'Direct Report') {
                                $authOfficeId = Auth::user()->office;
                                $authUserId   = Auth::user()->empId;

                                $officeUnderHeads = DB::connection('mysql')
                                    ->table('officeunder')
                                    ->pluck('head');

                                if (!$officeUnderHeads->contains($authUserId)) {
                                    $query->whereRaw('1 = 0'); // force empty
                                } else {
                                    $reportToOffices = DB::connection('mysql')
                                        ->table('officemaster')
                                        ->pluck('reportToOffice', 'id');

                                    // Apply "Direct Report" rules (still on DB query)
                                    $query->where(function ($subQuery) use ($authOfficeId, $authUserId, $officeUnderHeads, $reportToOffices) {
                                        $subQuery
                                            ->where(function ($q1) use ($authOfficeId, $authUserId) {
                                                $q1->where('a.office_id', $authOfficeId)
                                                   ->where('a.user_id', '!=', $authUserId);
                                            })
                                            ->orWhere(function ($q2) use ($authOfficeId, $officeUnderHeads, $reportToOffices) {
                                                $q2->whereIn('a.user_id', $officeUnderHeads)
                                                   ->where(function ($q3) use ($authOfficeId, $reportToOffices) {
                                                       $q3->whereIn('a.office_id', array_keys($reportToOffices->toArray()))
                                                          ->whereRaw('? = ?', [$reportToOffices[$authOfficeId] ?? null, $authOfficeId]);
                                                   });
                                            });
                                    });
                                }
                            } else {
                                // Normal office filter
                                $officeIds = array_keys(
                                    $officeDetailsfull->filter(fn($o) => trim($o) === $requestedOfficeName)->toArray()
                                );

                                if (!empty($officeIds)) {
                                    $query->whereIn('a.office_id', $officeIds);
                                } else {
                                    $query->whereRaw('1 = 0'); // no match
                                }
                            }
                        }
                    })
                    ->make(true);
            }

            return response()->json([
                'message' => 'No attendance table found for the selected month.',
                'data' => []
            ]);
        }

        return response()->json([
            'message' => 'Invalid request.',
            'data' => []
        ]);
    }
}
