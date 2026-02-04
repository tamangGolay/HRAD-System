<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use App\Certificate;
use App\User;
use DB;
use Auth;

class CertificateController extends Controller
{
public function uploadCertificate(Request $request)
{
    // Base validation rules
    $rules = [
        'certificateId'     => 'required|unique:certificateverifier,certificateId',
        'certificateTypeId' => 'required',
        'issuedFor'         => 'required|string',
        'issueDate'         => 'required|date',
        'issueTo'           => 'required',
        'receivedBy'        => 'required',
        'authuser'          => 'required',
    ];

    // If certificate type is NOT 1 or 2 → require venue & dates
    if (
        (int)$request->certificateTypeId !== 1 &&
        (int)$request->certificateTypeId !== 2
    ) {
        $rules['venue']     = 'required|string';
        $rules['startDate'] = 'required|date';
        $rules['endDate']   = 'required|date|after_or_equal:startDate';
    } else {
        // For type 1 or 2 → optional
        $rules['venue']     = 'nullable|string';
        $rules['startDate'] = 'nullable|date';
        $rules['endDate']   = 'nullable|date';
    }

    $validated = $request->validate($rules);

    $uploadCertificate = new Certificate;
    $uploadCertificate->certificateId     = $validated['certificateId'];
    $uploadCertificate->certificateTypeId = $validated['certificateTypeId'];
    $uploadCertificate->issuedFor         = $validated['issuedFor'];
    $uploadCertificate->issueDate         = $validated['issueDate'];
    $uploadCertificate->issueTo           = $validated['issueTo'];
    $uploadCertificate->receivedBy        = $validated['receivedBy'];
    $uploadCertificate->createdBy         = $validated['authuser'];

    // Save venue & dates only if type is NOT 1 or 2
    if (
        (int)$validated['certificateTypeId'] !== 1 &&
        (int)$validated['certificateTypeId'] !== 2
    ) {
        $uploadCertificate->venue     = $validated['venue'];
        $uploadCertificate->startDate = $validated['startDate'];
        $uploadCertificate->endDate   = $validated['endDate'];
    } else {
        $uploadCertificate->venue     = null;
        $uploadCertificate->startDate = null;
        $uploadCertificate->endDate   = null;
    }

    $uploadCertificate->save();

    return redirect('home')
        ->with('page', 'certificate')
        ->with('success', 'Certificate added successfully!');
}


        //check duplicate certiciate
        public function check(Request $request)
        {
           
        $request->validate([
            'certificateId' => 'required|string'
        ]);

        $exists = Certificate::where('certificateId', $request->certificateId)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    
        }

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

        $record = Certificate::where('certificateId', $request->certificateId)->first();

        //check if that certificate ID exist in DB

        // Certificate not found
        if (!$record) {
            return back()->withErrors([
                'certificateId' => 'We couldn’t find a certificate with this ID. Please check and try again.'
            ])->withInput();
        }

        // get CID number from USERS
        $CID_Users = User::where('empId', $record->issueTo)->first();

        // optional: get just the cidNo
        $cidNo = $CID_Users ? $CID_Users->cidNo : null;  //db name cidNo


          /* -----------------------------------------
       Decide certificate view based on type
    ------------------------------------------ */

    $certificateView = match ($record->certificateTypeId) {
        1 => 'certificate.types.Achievement',
        2 => 'certificate.types.Appreciation',
        3 => 'certificate.types.Completion',
        4 => 'certificate.types.Participation',
        default => 'certificate.types.Completion', // fallback
    };

    return view('Certificate.verifycertificate', [
        'searched'        => true,
        'record'          => $record,
        'cidNo'           => $cidNo,
        'certificateView' => $certificateView,
    ]);
                 
    }

    }
          