<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class CertificateBulkUploadController extends Controller
{

    /**
     * Upload CSV and insert into certificate master table
     * certificateId auto-generated: YYYY0001, YYYY0002, ...
     *
     * CSV columns required: eid, trainingId, cerType
     */
    public function bulkUpload(Request $request)
    {
        $request->validate([
            'csv_upload' => 'required|mimes:csv|max:5120',
        ]);

        // ✅ db table name
        $tableName = 'Certificatemaster';

        $file = $request->file('csv_upload');

        $handle = fopen($file->getRealPath(), 'r'); //get file from temporary location, open and get into read format

        if (!$handle) {
            return back()->withErrors(['file' => 'Cannot read CSV file']);
        }


        // Read header row
        $header = fgetcsv($handle);  // fgetcsv is a built in php function to read csv file
        if (!$header) {
            fclose($handle);
            return back()->withErrors(['file' => 'CSV file is empty']); // if there is no header in csv it will return false
        }

        // Lowercase & trim headers
        $header = array_map(fn ($h) => strtolower(trim((string)$h)), $header);


        // Required columns
        $required = ['eid', 'trainingid', 'certype'];
        foreach ($required as $col) {
            if (!in_array($col, $header)) {
                fclose($handle);
                return back()->withErrors(['file' => "Missing column: {$col}. Required: eid, trainingId, cerType"]);
            }
        }

        // Read rows
        $rows = [];
        while (($row = fgetcsv($handle)) !== false) {

            // skip empty row
            if (count(array_filter($row, fn($v) => $v !== null && $v !== '')) === 0) {
                continue;
            }

            // map row with headers
            $data = array_combine($header, $row);

            $eid = isset($data['eid']) ? trim($data['eid']) : null;
            $trainingId = isset($data['trainingid']) ? trim($data['trainingid']) : null;
            $cerType = isset($data['certype']) ? trim($data['certype']) : null;

            if ($eid === '' || $trainingId === '' || $cerType === '') {
                continue; // skip invalid rows
            }

            $rows[] = [
                'eid' => (int)$eid,
                'trainingId' => (int)$trainingId,
                'cerType' => $cerType,
            ];
        }

        fclose($handle);

        if (count($rows) === 0) {
            return redirect()->back()
            ->withErrors(['csv_upload' => 'Your CSV file is empty']);
        }

// Insert with auto certificateId generation
    try {

    DB::transaction(function () use ($tableName, $rows) {

    $year = (int) date('Y'); // 2026

    // 1) Find the biggest certificateId for THIS year (prefix match)
    $maxId = DB::table($tableName)
        ->whereRaw("CAST(certificateId AS CHAR) LIKE ?", [$year . '%'])
        ->lockForUpdate()
        ->max('certificateId');

    // 2) Get next serial number
    if (!$maxId) {
        $nextSerial = 1; // first for the year -> 0001
    } else {
        $serialPart = substr((string)$maxId, 4);  // remove year (first 4 digits)
        $nextSerial = ((int)$serialPart) + 1;
    }

    // 3) Build certificateId as: YEAR + padded serial (min 4 digits)
    //    After 9999 => 10000, so ID becomes 202610000 (unlimited)
    $insert = [];
    foreach ($rows as $r) {
        $certificateIdStr = (string)$year . str_pad((string)$nextSerial, 4, '0', STR_PAD_LEFT);
        $certificateId = (int)$certificateIdStr; // BIGINT

        $nextSerial++;

        $insert[] = [
            'certificateId' => $certificateId,
            'eid' => $r['eid'],
            'trainingId' => $r['trainingId'],
            'cerType' => $r['cerType'],
        ];
    }

    DB::table($tableName)->insert($insert);
});
 }catch (\Exception $e) {

            return back()->withErrors([
                'csv_upload' => 'Something went wrong during upload. Please check your csv file'
            ]);
        }

        return back()->with('success', 'Certificate uploaded successfully! Total rows: ' . count($rows));
    }
}
