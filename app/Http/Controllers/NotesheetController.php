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


    public function selfghCancelBooking()
{

 $selfghCancelBooking= DB::table('notesheet')  
->where( 'createdBy',Auth::user()->empId)
//  ->where('status', '=', 'Processing')

 ->select('*')
                                    
 ->latest('notesheet.noteId') //similar to orderby('roombed.id','desc')            
  ->paginate(100000000);

$rhtml = view('Notesheet.notesheetCancel')->with(['selfghCancelBooking' => $selfghCancelBooking])->render();
return response()
  ->json(array(
  'success' => true,
  'html' => $rhtml
));
}

public function cancelNotesheet(Request $request)
{

    $id = DB::table('notesheet')->select('noteId')
    ->where('noteId',$request->noteId)
    ->first();
 

    $conference1 = DB::table('notesheet')->where('noteId', $request->noteId);

    // $request->status = 'Approved';
    //     $request->update();   
    $status = $request->status;
    DB::update('update notesheet set status = "Approved" where noteId = ?', [$status, $id->noteId]);       

        return redirect('home')->with('error','You have cancelled the Notesheet');

}



}

