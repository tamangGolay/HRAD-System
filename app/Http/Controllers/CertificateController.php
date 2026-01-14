<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use App\Certificate;
use DB;
use Auth;

class CertificateController extends Controller
{
    public function uploadCertificate(Request $request)
    {

        $request->validate([
         'certificateId' => 'required|unique:certificateverifier,certificateId']);


        // dd($request);
       
            $uploadCertificate = new Certificate;           //database name n user input name
              
            $uploadCertificate->certificateId = $request->certificateId;                           
            $uploadCertificate->issuedFor = $request->issuedFor;             
            $uploadCertificate->issueDate = $request->issueDate;   
            $uploadCertificate->issueTo = $request->issueTo;          //empId        
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


    }
          