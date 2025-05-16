<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromCollection,WithHeadings
{
    protected $tableName;

    public function __construct($tableName)
    {
        $this->tableName = $tableName;
    }

   
    public function collection()
    {

        // Step 1: Fetch office details from 'mysql' connection
            $officeDetails = DB::connection('mysql')
            ->table('officedetails')
            ->select('id', 'longOfficeName')
            ->get()
            ->keyBy('id'); 

            // Step 2: Fetch attendance data from 'mysql2' connection
            $attendanceRecords = DB::connection('mysql2')
            ->table($this->tableName)
            ->where('checkin_late_count', '>=', 3)
            ->orWhere('checkout_early_count', '>=', 3)
            ->select('user_id', 'empName', 'office_id', 'checkin_on_time_count', 'checkin_late_count', 'checkout_on_time_count', 'checkout_early_count')
            ->get();

        // Step 3: Replace office_id with longOfficeName
        $attendanceRecords->transform(function ($record) use ($officeDetails) {
            $record->office_name = $officeDetails[$record->office_id]->longOfficeName ?? 'Unknown Office';
            unset($record->office_id); // Remove office_id if not needed
            return $record;
        });

        // Return final modified records
        return $attendanceRecords;
    }

     // Define the headings (column names)
     public function headings(): array
     {
         return [
             'User ID',
             'Employee Name',            
             'Check-in On Time Count',
             'Check-in Late Count',
             'Checkout On Time Count',
             'Checkout Early Count',
             'Office Name',
         ];
     }

     
 
}
