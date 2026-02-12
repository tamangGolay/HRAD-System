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
            'record' => null
        ]);
    }

    // Handle verification
    public function verify(Request $request)
    {
        $request->validate([
            'certificateId' => 'required'
        ]);


        $CertificateData = Certificatedata::where('certificateId', $request->certificateId)->first();

        //check if that certificate ID exist in DB

        // Certificate not found
        if (!$CertificateData) {
            return back()->withErrors([
                'certificateId' => 'We couldn’t find a certificate with this ID. Please check and try again.'
            ])->withInput();
        }

        /* -----------------------------------------
       Decide certificate view based on type
    ------------------------------------------ */

        $certificateView = match ($CertificateData->cerType) {
            'Achievement' => 'certificate.types.Achievement',
            'Appreciation' => 'certificate.types.Appreciation',
            'Completion' => 'certificate.types.Completion',
        };



        return view('Certificate.verifycertificate', [
            'searched'        => true,
            'trainingDetails' => $CertificateData,
            'certificateView' => $certificateView,
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
