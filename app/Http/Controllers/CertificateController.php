<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Certificatedata;
use Illuminate\Support\Facades\DB;


class CertificateController extends Controller
{
    // Show public verification page
    public function index()
    {
        return view('Certificate.verifycertificate', [
            'searched' => false,
            'trainingDetails' => null,
            'certificateView' => null
        ]);
    }


    // Handle verification
    public function verify(Request $request)
{
    $request->validate([
        'certificateId' => 'required'
    ]);

    $search = trim($request->certificateId);

    // First check if it's an exact Certificate ID (single result priority)
    $singleCertificate = Certificatedata::where('certificateId', $search)->first();

    // If exact certificate ID found → show single certificate (UNCHANGED LOGIC)
    if ($singleCertificate) {

        $certificateView = match ($singleCertificate->cerType ?? '') {
            'Appreciation' => 'certificate.types.Appreciation',
            'Completion'   => 'certificate.types.Completion',
            'Participation'  => 'certificate.types.Participation',
            default        => null,
        };

        return view('Certificate.verifycertificate', [
            'searched'        => true,
            'trainingDetails' => $singleCertificate,
            'certificateView' => $certificateView,
            'allCertificates' => null,
            'search'          => $search,
            'searchInput' => $request->certificateId
        ]);
    }

    // Otherwise treat as Employee ID → paginate (1 certificate per page)
    $certificates = Certificatedata::where('eid', $search)
    ->orderBy('certificateId', 'desc')
    ->get();

    // Not found
    if ($certificates->isEmpty()) {
        return view('Certificate.verifycertificate', [
            'searched'        => true,
            'trainingDetails' => null,
            'certificateView' => null,
            'allCertificates' => null,
            'search'          => $search,
            'searchInput' => $request->certificateId
        ]);
    }

    // Multiple certificates (paginated)
    return view('Certificate.verifycertificate', [
        'searched'        => true,
        'trainingDetails' => null,
        'certificateView' => null,
        'allCertificates' => $certificates,
        'search'          => $search,
        'searchInput' => $request->certificateId
        
    ]);
}

    //send dat to report controller

    public function getData(Request $request)
    {
        $query = DB::table('CertificateData');

         // If no filter or a dummy value, return empty
    if (!$request->certificateType || $request->certificateType === '___empty___') {
        $query->whereRaw('1 = 0'); // returns zero rows
    } else {
        $query->where('cerType', $request->certificateType);
    }

        return datatables()->of($query)->make(true);
    }

}
