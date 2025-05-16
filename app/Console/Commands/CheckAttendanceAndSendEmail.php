<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AttendanceAlert;
use Illuminate\Support\Facades\Log;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;

class CheckAttendanceAndSendEmail extends Command
{
    
    protected $signature = 'attendance:check-send-email';
    protected $description = 'Send monthly attendance report as an email attachment';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // $selectedMonth = strtolower(now()->format('F')); // e.g., 'march'
        $selectedMonth=3;
        $tableName = "attendance" . $selectedMonth . "_counter";

        Mail::to('tashidema@bpc.bt')->send(new AttendanceAlert($tableName));

        $this->info('Attendance report email sent successfully.');
    }
}