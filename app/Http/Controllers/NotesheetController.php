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
        
        // dd("hello");
       
    
        
            $Request_notesheet = new notesheetRequest;
            $Request_notesheet->createdBy = $request->empId;
            $Request_notesheet->officeId = $request->office;               
            $Request_notesheet->topic = $request->topic;     //database name n user input name
            $Request_notesheet->justification = $request->justification;
            $Request_notesheet->createdOn = $request->notesheetDate;
            $Request_notesheet->save();  
            
            $reqnote = DB::table('notesheet1')
            ->select('*')
            ->where('status','=','Processing')            
            ->first();

            return redirect('home')
                ->with('success', 'Notesheet submitted successfully');

 }
 public function selfghCancelBooking()
{

 $selfghCancelBooking= DB::table('notesheet')  
->where( 'createdBy',Auth::user()->empId)
//  ->where('status', '=', 'Processing')

 ->select('*')
                                    
 ->latest('notesheet.id') //similar to orderby('roombed.id','desc')            
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


    DB::update('update notesheet set status = ? where id = ?', [$request->status, $request->id]);       

  return redirect('home')->with('error','You have cancelled the Notesheet');

}

public function recommendnotesheet(Request $request)
{
    //dd($request->status);
    if($request->status == "Recommended"){
    $id = DB::table('notesheet')->select('id')
    ->where('id',$request->id)
    ->first(); 
    

    $remarks = implode(',', $request->remarks);
    // $GM="GM";

    $users = new notesheetapprove;//users is ModelName
        $users->noteId = $id->id;//emp_id is from input name
        $users->modifier =  $request->empId;//EmpName is from dB
        $users->remarks = $remarks;
        $users->modiType = $request->status;//emp_id is from input name
        $users->save();

    notesheetRequest::updateOrCreate(['id' => $id->id],
    ['status' =>$request->status]);//emp_id is from input name
    }

    if($request->status == "Rejected"){
        $id = DB::table('notesheet')->select('id')
        ->where('id',$request->id)
        ->first(); 
        
    
        $remarks = implode(',', $request->remarks);
        // $GM="GM";
    
        $users = new notesheetapprove;//users is ModelName
            $users->noteId = $id->id;//emp_id is from input name
            $users->modifier =  $request->empId;//EmpName is from dB
            $users->remarks = $remarks;
            $users->modiType = $request->status;//emp_id is from input name
            $users->save();
    
        notesheetRequest::updateOrCreate(['id' => $id->id],
        ['status' =>$request->status]);//emp_id is from input name
        }


        if($request->status == "Approved"){
            $id = DB::table('notesheet')->select('id')
            ->where('id',$request->id)
            ->first(); 
            
        
            $remarks = implode(',', $request->remarks);
            // $GM="GM";
        
            $users = new notesheetapprove;//users is ModelName
                $users->noteId = $id->id;//emp_id is from input name
                $users->modifier =  $request->empId;//EmpName is from dB
                $users->remarks = $remarks;
                $users->modiType = $request->status;//emp_id is from input name
                $users->save();
        
            notesheetRequest::updateOrCreate(['id' => $id->id],
            ['status' =>$request->status]);//emp_id is from input name
            }
    

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
   

  return redirect('home')->with('success','You have recommended and forwarded the Notesheet');

}



}

