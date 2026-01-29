<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use App\Certificate;
use App\CertificateType;

use App\User;
use DB;
use Auth;

class CertificateController extends Controller
{
    public function uploadCertificate(Request $request)
    {

       $request->validate([
                    'certificateId'     => 'required|unique:certificateverifier,certificateId',
                    'certificateTypeId' => 'required',
                    'issuedFor'         => 'required',
                    'issueDate'         => 'required|date',
                    'issueTo'           => 'required',
                    'venue'             => 'required',
                    'startDate'         => 'required|date',
                    'endDate'           => 'required|date|after_or_equal:startDate',
                    'receivedBy'        => 'required',
                    'authuser'          => 'required',
                ]);


        //  dd($request);
       
            $uploadCertificate = new Certificate;           //database name n user input name              
            $uploadCertificate->certificateId = $request->certificateId;      
            $uploadCertificate->certificateTypeId = $request->certificateTypeId;                            
            $uploadCertificate->issuedFor = $request->issuedFor;             
            $uploadCertificate->issueDate = $request->issueDate;   
            $uploadCertificate->issueTo = $request->issueTo;          //empId    
            $uploadCertificate->venue = $request->venue;    
            $uploadCertificate->startDate = $request->startDate;
            $uploadCertificate->endDate = $request->endDate;      
            $uploadCertificate->receivedBy = $request->receivedBy;         //name              
             $uploadCertificate->createdBy = $request->authuser;              
             $uploadCertificate->save(); 
                  

          return redirect('home')->with('page', 'certificate')  // certificate here is form name from DB
          ->with('success', 'Certificate added sucessfully!');
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
            $cidNo = null;
            $certificateTitle = null;

            // ✅ ONLY fetch CID if certificate exists
            if ($record) {
                // get CID from users table
                $user = User::where('empId', $record->issueTo)->first();
                $cidNo = $user ? $user->cidNo : null;

                  // ✅ get certificate title using ID
                $certificateTitle = DB::table('certificatetype')
                    ->where('id', $record->certificateTypeId)
                    ->value('nameofcertificate');

            }

            return view('Certificate.verifycertificate', [
                'searched' => true,
                'record'   => $record,
                'cidNo'    => $cidNo,
                'certificateTitle' => $certificateTitle,
            ]);
        }


}
          