<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceExport;
use Illuminate\Support\Facades\Storage;

class AttendanceAlert extends Mailable
{
    use Queueable, SerializesModels;

    protected $tableName;

    public function __construct($tableName)
    {
        $this->tableName = $tableName;
    }

    public function build()
    {
        $fileName = 'Attendance_Report_' . now()->format('Y_m_d') . '.xlsx';
        $filePath = storage_path('app/' . $fileName);

        // Generate and save the Excel file
        Excel::store(new AttendanceExport($this->tableName), $fileName, 'local');

        return $this->subject('Monthly Attendance Report')
            ->view('emails.attendance_alert')
            ->attach($filePath);
    }
}
