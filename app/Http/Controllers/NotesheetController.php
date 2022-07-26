<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\notesheetRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use DB;
use Auth;

class NotesheetController extends Controller
{

    public function Request_notesheet(Request $request)
    {
        //dd($request);
    
        // try
        //  {
            $Request_notesheet = new notesheetRequest;
            $Request_notesheet->createdBy = $request->empId;  
            // $Request_notesheet->empName = $request->empName;
            // $Request_notesheet->emailId = $request->emailId;               
            $Request_notesheet->topic = $request->topic;     //database name n user input name
            $Request_notesheet->justification = $request->justification;
            // $Request_notesheet->createdBy = $request->createdBy;                     

            $Request_notesheet->save();           

            return redirect('home')
                ->with('success', 'Notesheet submitted successfully');

        // } //try end
       
    //  catch(\Illuminate\Database\QueryException $e)
    //  {

    //       return redirect('home')->with('page', 'refund')
    //             ->with('error', 'Cannot leave the fields empty test');

    //      }

    }
}

