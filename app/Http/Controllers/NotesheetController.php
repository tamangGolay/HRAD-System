<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\notesheetRequest;
use App\notesheetRequestSupervisor;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use App\notesheetapprove;
use DB;
use Auth;

class NotesheetController extends Controller
{

    public function supervisorApproval($id)
    {

    
        $notesheetRemarks = notesheetapprove::all()
        ->where('noteId',$id);
 
   
      
        return view('Notesheet.approve',compact('notesheetRemarks'));
    }


    public function Request_notesheet(Request $request)
    {

        $supervisorEmail= DB::table('employeesupervisor')  
        ->select('employeesupervisor.emailId')
        ->where( 'employee',Auth::user()->empId)
        ->first();

       
        $userDetail= DB::table('users') 
        ->join('officedetails', 'officedetails.id', '=', 'users.office')
        ->select('users.*','officedetails.longOfficeName')
        ->where( 'users.empId',Auth::user()->empId)
        ->first();

        $supervisor = ['title' => 'Mail From the HRIS System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for notesheet from ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: bose.bpc.bt','body5' => '','body6' => '', ];

        $officeHead= DB::table('employeesupervisor')  
        ->where( 'supervisor',Auth::user()->empId)
        ->first();

        if($officeHead == null)
        {
            $supervisorEmail= DB::table('employeesupervisor')  
            ->select('employeesupervisor.emailId')
            ->where( 'employee',Auth::user()->empId)
            ->first();
            
            $Request_notesheet = new notesheetRequest;
            $Request_notesheet->createdBy = $request->empId;
            $Request_notesheet->emailId = $request->emailId;
            $Request_notesheet->officeId = $request->office;               
            $Request_notesheet->topic = $request->topic;     //database name n user input name
            $Request_notesheet->justification = $request->justification;
            $Request_notesheet->createdOn = $request->notesheetDate;
            $Request_notesheet->save();  

           
    
            // dd($supervisorEmail->emailId);
            Mail::to($supervisorEmail->emailId) 
            ->send(new MyTestMail($supervisor));

            return redirect('home')
            ->with('success', 'Notesheet submitted successfully');

        }

        if($officeHead->supervisor == Auth::user()->empId)
        {
            $officeType= DB::table('officedetails')
            ->join('users','users.office','=','officedetails.id')
            ->where( 'officedetails.id',Auth::user()->office)
            ->select('officeType')
            ->first();
             //Manager
            if($officeType->officeType == 'Division' || $officeType->officeType == 'Sub Division'
            || $officeType->officeType == 'Unit' || $officeType->officeType == 'Substation'
            ){
                $Supervisorstatus = 'Recommended';
                $Request_notesheet = new notesheetRequest;
                $Request_notesheet->status = $Supervisorstatus;
                $Request_notesheet->createdBy = $request->empId;
                $Request_notesheet->emailId = $request->emailId;
                $Request_notesheet->officeId = $request->office;               
                $Request_notesheet->topic = $request->topic;     //database name n user input name
                $Request_notesheet->justification = $request->justification;
                $Request_notesheet->createdOn = $request->notesheetDate;
                $Request_notesheet->save();  
                Mail::to($supervisorEmail->emailId) 
                ->send(new MyTestMail($supervisor));
                // dd("Manager");
            }
            //GM

        //    dd($officeType->officeType);
            if($officeType->officeType == 'Department'){
                $Supervisorstatus = 'GMRecommended';
                $Request_notesheet = new notesheetRequest;
                $Request_notesheet->status = $Supervisorstatus;
                $Request_notesheet->createdBy = $request->empId;
                $Request_notesheet->emailId = $request->emailId;
                $Request_notesheet->officeId = $request->office;               
                $Request_notesheet->topic = $request->topic;     //database name n user input name
                $Request_notesheet->justification = $request->justification;
                $Request_notesheet->createdOn = $request->notesheetDate;
                $Request_notesheet->save(); 
                Mail::to($supervisorEmail->emailId) 
                ->send(new MyTestMail($supervisor)); 
                // dd("GM");
            }
            //Director
            if($officeType->officeType == 'Services'){
                $Supervisorstatus = 'DirectorRecommended';
                $Request_notesheet = new notesheetRequest;
                $Request_notesheet->status = $Supervisorstatus;
                $Request_notesheet->createdBy = $request->empId;
                $Request_notesheet->emailId = $request->emailId;
                $Request_notesheet->officeId = $request->office;               
                $Request_notesheet->topic = $request->topic;     //database name n user input name
                $Request_notesheet->justification = $request->justification;
                $Request_notesheet->createdOn = $request->notesheetDate;
                $Request_notesheet->save(); 
                Mail::to($supervisorEmail->emailId) 
                ->send(new MyTestMail($supervisor)); 
                // dd("Director");

            }
        }
        // else{

        //     $Request_notesheet = new notesheetRequest;
        //     $Request_notesheet->createdBy = $request->empId;
        //     $Request_notesheet->officeId = $request->office;               
        //     $Request_notesheet->topic = $request->topic;     //database name n user input name
        //     $Request_notesheet->justification = $request->justification;
        //     $Request_notesheet->createdOn = $request->notesheetDate;
        //     $Request_notesheet->save();  
            
        //     // $reqnote = DB::table('notesheet')
        //     // ->select('*')
        //     // ->where('status','=','Processing')            
        //     // ->first();
        // }
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


    DB::update('update notesheet set cancelled = ? where id = ?', [$request->cancelled, $request->id]);       

    return redirect('home')->with('error','You have cancelled the Notesheet');


    //   $id = DB::table('notesheet')
    //             ->select('cancelled','id')
    //             ->where('cancelled',$request->id)
    //             ->first();

    //             // dd($request);

    // if($id == null){
    //     DB::update('update notesheet set cancelled = ? where id = ?', [$request->cancelled, $request->id]);       

    //     return redirect('home')->with('error','You have cancelled the Notesheet');

    // }
    // if($id->cancelled == 'Yes'){
    //     return redirect('home')->with('error','You cannot cancel the Notesheet now!');
    // }


  }



public function recommendnotesheet(Request $request)
{
//  dd($request);
// try{
    
    if($request->status == "Recommended" ){  //&& $request->remarks != ''
        $id = DB::table('notesheet')->select('id')
        ->where('id',$request->id)
        ->first();   
        
    
           $users = new notesheetapprove;//users is ModelName
            $users->noteId = $id->id;//emp_id is from input name
            $users->modifier =  $request->empId;//EmpName is from dB
            $users->remarks = $request->remarks;
            $users->modiType = $request->status;//emp_id is from input name
            $users->save();
    
        notesheetRequest::updateOrCreate(['id' => $id->id],
        ['status' =>$request->status]); 
        
        //email from here
        $supervisorEmail= DB::table('employeesupervisor')  
        ->select('employeesupervisor.emailId')
        ->where( 'employee',Auth::user()->empId)
        ->first();

       
        $userDetail= DB::table('users') 
        ->join('officedetails', 'officedetails.id', '=', 'users.office')
        ->select('users.*','officedetails.longOfficeName')
        ->where( 'users.empId',Auth::user()->empId)
        ->first();

        $supervisor = ['title' => 'Mail From the HRIS System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for notesheet from ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: bose.bpc.bt','body5' => '','body6' => '', ];
       
        $userEmail = DB::table('notesheet')
        ->where('id',$id->id)
        ->first(); 
        // dd($userEmail);

        Mail::to($supervisorEmail->emailId) 
        ->cc($userEmail->emailId)
        ->send(new MyTestMail($supervisor)); 
                
        return redirect('home')->with('success','You have recommended and forwarded the Notesheet');
        }
    
                if($request->status1 == "Approved" ){
                $id = DB::table('notesheet')->select('id')
                ->where('id',$request->id)
                ->first(); 
                
            
                // $remarks1 = implode(',', $request->remarks1);
                // $GM="GM";
            
                $users = new notesheetapprove;//users is ModelName
                    $users->noteId = $id->id;//emp_id is from input name
                    $users->modifier =  $request->empId;//EmpName is from dB
                    $users->remarks = $request->remarks1;
                    $users->modiType = $request->status1;//emp_id is from input name
                    $users->save();
            
                notesheetRequest::updateOrCreate(['id' => $id->id],
                ['status' =>$request->status1]);//emp_id is from input name
                
                //email from here

                $userDetail= DB::table('users') 
                ->join('officedetails', 'officedetails.id', '=', 'users.office')
                ->select('users.*','officedetails.longOfficeName')
                ->where( 'users.empId',Auth::user()->empId)
                ->first();
                
                $approve = ['title' => 'Mail From the HRIS System Approve', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for notesheet from ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: bose.bpc.bt','body5' => '','body6' => '', ];
                
                
               
                $userEmail = DB::table('notesheet')
                ->where('id',$id->id)
                ->first(); 
                // dd($userEmail);
        
                Mail::to($userEmail->emailId) 
                // ->cc($userEmail->emailId)
                ->send(new MyTestMail($approve)); 
            
                return redirect('home')->with('success','You have Approved the Notesheet');   
            }

    
                if($request->status2 == "Rejected"){
                    $id = DB::table('notesheet')->select('id')
                    ->where('id',$request->id)
                    ->first();  
                           
                
                    // $remarks2 = implode(',', $request->remarks2);
                    // $GM="GM";
                
                    $users = new notesheetapprove;//users is ModelName
                        $users->noteId = $id->id;//emp_id is from input name
                        $users->modifier =  $request->empId;//EmpName is from dB
                        $users->remarks = $request->remarks2;
                        $users->modiType = $request->status2;//emp_id is from input name
                        $users->save();
                
                    notesheetRequest::updateOrCreate(['id' => $id->id],
                    ['status' =>$request->status2]);//emp_id is from input name
                    
                    //email from here
                    $userDetail= DB::table('users') 
                    ->join('officedetails', 'officedetails.id', '=', 'users.office')
                    ->select('users.*','officedetails.longOfficeName')
                    ->where( 'users.empId',Auth::user()->empId)
                    ->first();

                    $reject = ['title' => 'Mail From the HRIS System Reject', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for notesheet from ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: bose.bpc.bt','body5' => '','body6' => '', ];
                   
                
                   
                    $userEmail = DB::table('notesheet')
                    ->where('id',$id->id)
                    ->first(); 
                    // dd($userEmail);
            
                    Mail::to($userEmail->emailId) 
                    // ->cc($userEmail->emailId)
                    ->send(new MyTestMail($reject));
               
                    return redirect('home')->with('error','You have rejected the Notesheet');    
                }    
                
                else{
                    return redirect('home')->with('error','You cannot leave the remarks field empty!!');  
                }
                   
             
    
            }
        
    //     catch(\Illuminate\Database\QueryException $t) { 

    //         return redirect('home')->with('error','You cannot leave the remarks field empty!!');  

    //     }
    // }

            

            
public function GMrecommendnotesheet(Request $request) 
{

    if($request->status == "Recommended" ){  //&& $request->remarks != ''
        $id = DB::table('notesheet')->select('id')
        ->where('id',$request->id)
        ->first();
        
        // $re="Recommended";        
    
           $users = new notesheetapprove;//users is ModelName
            $users->noteId = $id->id;//emp_id is from input name
            $users->modifier =  $request->empId;//EmpName is from dB
            $users->remarks = $request->remarks;
            $users->modiType = $request->status;//emp_id is from input name
            $users->save();
    
        notesheetRequest::updateOrCreate(['id' => $id->id],
        ['status' =>$request->status]); 
        
        //email from here
        // $supervisorEmail= DB::table('employeesupervisor')  
        // ->select('employeesupervisor.emailId')
        // ->where( 'employee',Auth::user()->empId)
        // ->first();

       
        // $userDetail= DB::table('users') 
        // ->join('officedetails', 'officedetails.id', '=', 'users.office')
        // ->select('users.*','officedetails.longOfficeName')
        // ->where( 'users.empId',Auth::user()->empId)
        // ->first();

        // $supervisor = ['title' => 'Mail From the HRIS System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for notesheet from ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: bose.bpc.bt','body5' => '','body6' => '', ];
       
        // $userEmail = DB::table('notesheet')
        // ->where('id',$id->id)
        // ->first(); 
        // // dd($userEmail);

        // Mail::to($supervisorEmail->emailId) 
        // ->cc($userEmail->emailId)
        // ->send(new MyTestMail($supervisor)); 
                
        return redirect('home')->with('success','You have recommended and forwarded the Notesheet');
        }

        if($request->status1 == "Approved" ){
            $id = DB::table('notesheet')->select('id')
            ->where('id',$request->id)
            ->first(); 
                   
            // $re="Approved";
        
            $users = new notesheetapprove;//users is ModelName
                $users->noteId = $id->id;//emp_id is from input name
                $users->modifier =  $request->empId;//EmpName is from dB
                $users->remarks = $request->remarks1;
                $users->modiType = $request->status;  //emp_id is from input name
                $users->save();
        
            notesheetRequest::updateOrCreate(['id' => $id->id],
            ['status' =>$request->status1]);//emp_id is from input name
            
            //email from here

            // $userDetail= DB::table('users') 
            // ->join('officedetails', 'officedetails.id', '=', 'users.office')
            // ->select('users.*','officedetails.longOfficeName')
            // ->where( 'users.empId',Auth::user()->empId)
            // ->first();
            
            // $approve = ['title' => 'Mail From the HRIS System Approve', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for notesheet from ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: bose.bpc.bt','body5' => '','body6' => '', ];
            
            
           
            // $userEmail = DB::table('notesheet')
            // ->where('id',$id->id)
            // ->first(); 
            // // dd($userEmail);
    
            // Mail::to($userEmail->emailId) 
            // // ->cc($userEmail->emailId)
            // ->send(new MyTestMail($approve)); 
        
             return redirect('home')->with('success','You have Approved the Notesheet');   
         }


            if($request->status2 == "Rejected"){
                $id = DB::table('notesheet')->select('id')
                ->where('id',$request->id)
                ->first();                      
            
                // $re="Rejected";
            
                $users = new notesheetapprove;//users is ModelName
                    $users->noteId = $id->id;//emp_id is from input name
                    $users->modifier =  $request->empId;//EmpName is from dB
                    $users->remarks = $request->remarks2;
                    $users->modiType = $request->status;//emp_id is from input name
                    $users->save();
            
                notesheetRequest::updateOrCreate(['id' => $id->id],
                ['status' =>$request->status2]);//emp_id is from input name
                
                //email from here
                // $userDetail= DB::table('users') 
                // ->join('officedetails', 'officedetails.id', '=', 'users.office')
                // ->select('users.*','officedetails.longOfficeName')
                // ->where( 'users.empId',Auth::user()->empId)
                // ->first();

                // $reject = ['title' => 'Mail From the HRIS System Reject', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for notesheet from ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: bose.bpc.bt','body5' => '','body6' => '', ];
               
            
               
                // $userEmail = DB::table('notesheet')
                // ->where('id',$id->id)
                // ->first(); 
                // // dd($userEmail);
        
                // Mail::to($userEmail->emailId) 
                // // ->cc($userEmail->emailId)
                // ->send(new MyTestMail($reject));
           
                return redirect('home')->with('error','You have rejected the Notesheet');    
            }

            else{
                return redirect('home')->with('error','You cannot leave the remarks field empty test!!');  
            }
         

  }
}
