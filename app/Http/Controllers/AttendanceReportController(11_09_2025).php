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

            // Check if the table exists
            $tableExists = DB::connection('mysql2')->select("SHOW TABLES LIKE '$tableName' ");
           
            if (!$tableExists) {
                return datatables()->of(collect([]))->toJson();
            }

            // Build the main query - JUST select from the attendance table
            $query = DB::connection('mysql2')->table($tableName . ' as a');

            // Get office details for later
            $officeDetailsfull = DB::connection('mysql')
                ->table('officedetails')
                ->pluck('officeDetails', 'id');

          
                        // Count the total records for this month using a NEW clean query
            $recordsTotal = DB::connection('mysql2')->table($tableName)->count();

            // 1. Apply SORTING from DataTables
          
                $query->orderBy('a.id','asc');
            

            // 2. Apply PAGINATION from DataTables (This fixes your timeout!)
            if ($request->length != -1) { // -1 means "show all"
                $query->offset($request->start)->limit($request->length);
            }

            // Get only the ONE PAGE of results
            $attendance = $query->get();

            // NOW, on this small page of results, attach office details
            $attendance->transform(function ($item) use ($officeDetailsfull) {
                $item->officeDetails = $officeDetailsfull[$item->office_id] ?? null;
                return $item;
            });

            // 3. NOW, apply your CUSTOM office filter on this small page
            $requestedOfficeName = trim($request->office_name);

            if (!empty($requestedOfficeName)) {

                    if ($requestedOfficeName === 'Direct Report') {
                    // Prepare Direct Report variables
                    $authOfficeId = Auth::user()->office;
                    $authUserId = Auth::user()->empId;

                    $officeUnderHeads = DB::connection('mysql')
                        ->table('officeunder')
                        ->pluck('head');

                    $reportToOffices = DB::connection('mysql')
                        ->table('officemaster')
                        ->pluck('reportToOffice', 'id');

                    // Apply Direct Report filter
                    $attendance = $attendance->filter(function ($item) use ($authOfficeId, $authUserId, $officeUnderHeads, $reportToOffices) {
                        // Condition 1: Users in the same office except logged-in user
                        if ($item->office_id == $authOfficeId && $item->user_id != $authUserId) {
                            return true;
                        }

                        // Condition 2: User is office head and their office reports to logged-in user's office
                        if ($officeUnderHeads->contains($item->user_id) && (($reportToOffices[$item->office_id] ?? null) == $authOfficeId)) {
                            return true;
                        }

                        return false;
                    })->values();

                    // Count after Direct Report filter
                    $recordsFiltered = $attendance->count();
            } else {

                $attendance = $attendance->filter(function ($item) use ($requestedOfficeName) {
                    return trim($item->officeDetails) === $requestedOfficeName;
                })->values();
                // Get the count after this specific filter
                $recordsFiltered = $attendance->count();
            } 
        }
            else {

                // If no office filter was applied, the filtered count is the total
                $recordsFiltered = $recordsTotal;
            }

            // Return the results to DataTables
            return datatables()->of($attendance)
                ->with([
                    'draw' => $request->draw,
                    'recordsTotal' => $recordsTotal,
                    'recordsFiltered' => $recordsFiltered,
                ])
                ->toJson();
        }

        return response()->json(['message' => 'Invalid request.'], 400);
    }
}