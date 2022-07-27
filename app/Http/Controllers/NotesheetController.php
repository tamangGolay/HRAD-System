<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\notesheetRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use App\notesheetapprove;
use DB;
use Auth;

class NotesheetController extends Controller
{

    public function Request_notesheet(Request $request)
    {
        //dd($request);
    
        
            $Request_notesheet = new notesheetRequest;
            $Request_notesheet->createdBy = $request->empId;
            $Request_notesheet->officeId = $request->office;               
            $Request_notesheet->topic = $request->topic;     //database name n user input name
            $Request_notesheet->justification = $request->justification;

            $Request_notesheet->save();           

            return redirect('home')
                ->with('success', 'Notesheet submitted successfully');

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


    DB::update('update notesheet set status = ? where noteId = ?', [$request->status, $request->noteId]);       

  return redirect('home')->with('error','You have cancelled the Notesheet');

}

public function recommendnotesheet(Request $request)
{
    $id = DB::table('notesheet')->select('noteId')
    ->where('noteId',$request->noteId)
    ->first()
    ;
    $remarks = implode(',', $request->remarks);

    $users = new notesheetapprove;//users is ModelName
        $users->noteId = $id->noteId;//emp_id is from input name
        $users->modifier =  $request->empId;//EmpName is from dB
        $users->remarks = $remarks;
        $users->save();

     


    // notesheetapprove::updateOrCreate(['noteId' => $id->noteId],
    //     ['remarks' => $remarks,'modifier' => $request->empId]);    
        
// DB::update('update noteapproval set remarks = ? where noteId = ?', [$request->, $request->noteId]);       

// dd($request);
  

    // $remarks = DB::table('notesheet')->select('noteId')
    //  ->where('noteId',$request->noteId)
    //  ->first()
    //  ;



    // ->first();
 //DB::update('update notesheet set remarks = ? where noteId = ?', [$request->status, $request->noteId]);       

  return redirect('home')->with('error','You have recommended and forwarded the Notesheet');

}



}

