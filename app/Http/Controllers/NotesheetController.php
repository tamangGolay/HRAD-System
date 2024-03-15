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
        // try{  

        $supervisorEmail= DB::table('employeesupervisor')  
        ->select('employeesupervisor.emailId')
        ->where( 'employee',Auth::user()->empId)
        ->first();


        $userDetail= DB::table('users') 
        ->join('officedetails', 'officedetails.id', '=', 'users.office')
        ->select('users.*','officedetails.longOfficeName')
        ->where( 'users.empId',Auth::user()->empId)
        ->first();

        $supervisor = ['title' => 'Mail From the HRIS System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for notesheet titled <b>' . $request->topic . '</b> from ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: http://hris.bpc.bt', 'body5' => '','body6' => '', ];

        $officeHead= DB::table('employeesupervisor')  
        ->where( 'supervisor',Auth::user()->empId)
        ->first();

        if($officeHead == null) //if the user are from dept n service but not officehead
        {
            $officeType= DB::table('officedetails')
            ->join('users','users.office','=','officedetails.id')
            ->where( 'officedetails.id',Auth::user()->office)
            ->select('officeType')
            ->first();

            // dd($officeType->officeType);
            if($officeType->officeType == 'Section'){ //Department previous
                $status = 'Processing';
            }

            if($officeType->officeType == 'Division'){ //Department previous
                $status = 'Recommended';
            }

            if($officeType->officeType == 'Department'){ //Services prevoius
                $status = 'GMRecommended';
            }

            $supervisorEmail= DB::table('employeesupervisor')  
            ->select('employeesupervisor.emailId')
            ->where( 'employee',Auth::user()->empId)
            ->first();
            
            $Request_notesheet = new notesheetRequest;
            $Request_notesheet->createdBy = $request->empId;
            if($officeType->officeType == 'Division' || $officeType->officeType == 'Department' 
            || $officeType->officeType == 'Section'){
            $Request_notesheet->status = $status;
            }
          
            $Request_notesheet->emailId = $request->emailId;
            $Request_notesheet->officeId = $request->office;               
            $Request_notesheet->topic = $request->topic;     //database name n user input name
            $Request_notesheet->justification = $request->justification;
            $Request_notesheet->createdOn = $request->notesheetDate;
            $Request_notesheet->save(); 
           
    
            // dd($supervisorEmail->emailId);
            Mail::to($supervisorEmail->emailId) 
            ->send(new MyTestMail($supervisor));

            return redirect('home')->with('page','notesheet')
            ->with('success', 'Notesheet submitted successfully1');

        }

        if($officeHead->supervisor == Auth::user()->empId)
        {
            $officeType= DB::table('officedetails')
            ->join('users','users.office','=','officedetails.id')
            ->where( 'officedetails.id',Auth::user()->office)
            ->select('officeType')
            ->first();
            //4th layer
            if($officeType->officeType == 'Unit'|| $officeType->officeType == 'Sub Division' 
            || $officeType->officeType == 'Team'|| $officeType->officeType == 'Substation'){
                $Supervisorstatus = 'Processing';
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
                // dd("4th level");
            }

             //Manager
            if($officeType->officeType == 'Section'){
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
            if($officeType->officeType == 'Division'){ //Department old
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
            if($officeType->officeType == 'Department'){ // Services old
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
        return redirect('home')->with('page','notesheet')
        ->with('success', 'Notesheet submitted successfully2');

        //  } catch(\Illuminate\Database\QueryException $e){        
 
        //     return redirect('home')->with('error',"Sorry!.Somethig went wrong. Maybe you skip a field or your details are missing in system!");
       
        // }

 }

 public function selfghCancelBooking()
{

 $selfghCancelBooking= DB::table('notesheet')  
->where( 'createdBy',Auth::user()->empId)
 ->where('cancelled', '=', 'No')

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

        $notetitle= DB::table('notesheet')  
        ->join('noteapproval', 'noteapproval.noteId', '=', 'notesheet.id')
        ->select('notesheet.topic')
        ->where('notesheet.id',$id->id)
        ->first();


        $supervisor = ['title' => 'Mail From the HRIS System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for notesheet titled <b>' . $notetitle->topic . '</b> recommended by the manager ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: http://hris.bpc.bt', 'body5' => '','body6' => '', ];
       
        $userEmail = DB::table('notesheet')
        ->where('id',$id->id)
        ->first(); 
        // dd($userEmail);

        Mail::to($supervisorEmail->emailId) 
        ->cc($userEmail->emailId)
        ->send(new MyTestMail($supervisor)); 
                
        return redirect('home')
        ->with('success','You have recommended and forwarded the Notesheet');
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


                $notetitle= DB::table('notesheet')  
                ->join('noteapproval', 'noteapproval.noteId', '=', 'notesheet.id')
                ->select('notesheet.topic')
                ->where('notesheet.id',$id->id)
                ->first();
        
                
                $approve = ['title' => 'Mail From the HRIS System', 'body' => 'Dear sir/madam,', 'body1' => 'Your request for notesheet titled <b>' . $notetitle->topic . '</b> has been approved by the manager ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => '', 'body4' => '','body5' => 'Have a great day!','body6' => '', ];
                
                
               
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

                    $notetitle= DB::table('notesheet')  
                    ->join('noteapproval', 'noteapproval.noteId', '=', 'notesheet.id')
                    ->select('notesheet.topic')
                    ->where('notesheet.id',$id->id)
                    ->first();


                    $reject = ['title' => 'Mail From the HRIS System Reject', 'body' => 'Dear sir/madam,', 'body1' => 'Your request for notesheet titled <b>'. $notetitle->topic .'</b> has been rejected by the manager ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Reason: '. $request->remarks2 .'.', 'body4' => 'click here: http://hris.bpc.bt','body5' => 'Never give up. Great things take time','body6' => '', ];
                   
                
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
    $id = DB::table('notesheet')->select('id')
    ->where('id',$request->id)
    ->first();

    $userEmail = DB::table('notesheet')
    ->where('id',$id->id)
    ->first(); 


    $managerEmail= DB::table('employeesupervisor') 
    ->select('employeesupervisor.emailId')
    ->where( 'employee',$userEmail->createdBy)
    ->first();

    // dd($managerEmail->emailId);

    $DirectorEmail= DB::table('employeesupervisor') 
    ->select('employeesupervisor.emailId')
    ->where( 'employee',Auth::user()->empId)
    ->first();

    $notetitle= DB::table('notesheet')  
    ->join('noteapproval', 'noteapproval.noteId', '=', 'notesheet.id')
    ->select('notesheet.topic')
    ->where('notesheet.id',$id->id)
    ->first();

    
    // dd($DirectorEmail->emailId);

    if($request->status == "GMRecommended" ){  //&& $request->remarks != ''
        // $id = DB::table('notesheet')->select('id')
        // ->where('id',$request->id)
        // ->first();   
        
        $re="Recommended";
    
           $users = new notesheetapprove;         //notesheetaprove is ModelName
            $users->noteId = $id->id;                 
            $users->modifier =  $request->empId;       //EmpId is from dB
            $users->remarks = $request->remarks;
            $users->modiType = $re;         
            $users->save();
    
        notesheetRequest::updateOrCreate(['id' => $id->id],
        ['status' =>$request->status]); 
        
        //email from here
        // $managerEmail= DB::table('employeesupervisor')  
        // ->select('employeesupervisor.emailId')
        // ->where( 'employee',Auth::user()->empId)
        // ->first();
       
        // $managerempid= DB::table('employeesupervisor') 
        // ->select('employeesupervisor.supervisor')
        // ->where( 'employee',Auth::user()->empId)
        // ->first();

        // $userEmail = DB::table('notesheet')
        // ->where('id',$id->id)
        // ->first(); 


        // $managerEmail= DB::table('employeesupervisor') 
        // ->select('employeesupervisor.emailId')
        // ->where( 'employee',$userEmail->createdBy)
        // ->first();

        // // dd($managerEmail->emailId);

        // $DirectorEmail= DB::table('employeesupervisor') 
        // ->select('employeesupervisor.emailId')
        // ->where( 'employee',Auth::user()->empId)
        // ->first();
        // // dd($DirectorEmail->emailId);


        // $GmEmail= DB::table('employeesupervisor')  
        // ->select('employeesupervisor.emailId')
        // ->where( 'employee',$managerempid->supervisor)
        // ->first();

        // $Gmempid=DB::table('employeesupervisor') 
        // ->select('employeesupervisor.supervisor')
        // ->where( 'employee',$managerempid->supervisor)
        // ->first();


        // $DirectorEmail= DB::table('employeesupervisor')  
        // ->select('employeesupervisor.emailId')
        // ->where( 'employee', $Gmempid->supervisor)
        // ->first();
    
        $userDetail= DB::table('users') 
        ->join('officedetails', 'officedetails.id', '=', 'users.office')
        ->select('users.*','officedetails.longOfficeName')
        ->where( 'users.empId',Auth::user()->empId)
        ->first();

        $supervisor = ['title' => 'Mail From the HRIS System', 'body' => 'Dear sir/madam,', 'body1' => 
        'You have a request for notesheet titled <b> '. $notetitle->topic . '</b> recommended by GM ' . $userDetail->empName . 
        ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.',
         'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: http://hris.bpc.bt','body5' => '','body6' => 'Have a good day!', ];
       
        
     
//  dd($userEmail,$managerempid,$managerEmail,$Gmempid,$GmEmail,$DirectorEmail);


        Mail::to($DirectorEmail->emailId) 
                ->cc([$managerEmail->emailId,$userEmail->emailId])
                ->send(new MyTestMail($supervisor)); 
                
        return redirect('home')->with('success','You have recommended and forwarded the Notesheet');
        }
    
                if($request->status1 == "Approved" ){
                // $id = DB::table('notesheet')->select('id')
                // ->where('id',$request->id)
                // ->first(); 
                
            
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

                $notetitle= DB::table('notesheet')  
                ->join('noteapproval', 'noteapproval.noteId', '=', 'notesheet.id')
                ->select('notesheet.topic')
                ->where('notesheet.id',$id->id)
                ->first();

            
                
                $approve = ['title' => 'Mail From the HRIS System Approve', 'body' => 'Dear sir/madam,', 'body1' => 'Your request for notesheet titled <b> ' . $notetitle->topic . ' </b>  has been approved by the GM ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => '', 'body4' => '','body5' => 'Be grateful for life.Not everyone made it this far.','body6' => '', ];
                               
               
                // $userEmail = DB::table('notesheet')
                // ->where('id',$id->id)
                // ->first(); 
                // dd($userEmail);

                Mail::to($userEmail->emailId) 
                ->cc($managerEmail->emailId)
                ->send(new MyTestMail($approve)); 
        
                // Mail::to($userEmail->emailId) 
                // ->cc($managerEmail->emailId)
                // ->send(new MyTestMail($approve)); 
            
                return redirect('home')->with('success','You have Approved the Notesheet');   
            }

    
                if($request->status2 == "Rejected"){
                    // $id = DB::table('notesheet')->select('id')
                    // ->where('id',$request->id)
                    // ->first();                          
                
                   
                
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

                    $notetitle= DB::table('notesheet')  
                    ->join('noteapproval', 'noteapproval.noteId', '=', 'notesheet.id')
                    ->select('notesheet.topic')
                    ->where('notesheet.id',$id->id)
                    ->first();



                    $reject = ['title' => 'Mail From the HRIS System Reject', 'body' => 'Dear sir/madam,', 'body1' => 'Your request for notesheet titled <b>' . $notetitle->topic . '</b> has been rejected by the GM ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Reason:' . $request->remarks2 .'.', 'body4' => 'click here: http://hris.bpc.bt', 'body5' => 'Your patience is your power. Smile','body6' => '', ];
                   
                                  
                    // $userEmail = DB::table('notesheet')
                    // ->where('id',$id->id)
                    // ->first(); 
                    // dd($userEmail);
            
                    Mail::to($userEmail->emailId) 
                    ->cc($managerEmail->emailId)
                    ->send(new MyTestMail($reject));

        
           
                return redirect('home')->with('error','You have rejected the Notesheet');    
            }

            else{
                return redirect('home')->with('error','You cannot leave the remarks field empty test!!');  
            }
         

  }

  public function directorrecommendnotesheet(Request $request) 
 {
    $id = DB::table('notesheet')->select('id')
    ->where('id',$request->id)
    ->first(); 

    $CEOEmail=DB::table('employeesupervisor')  
        ->select('employeesupervisor.emailId')
        ->where( 'employee', Auth::user()->empId)
        ->first();
        // dd($CEOEmail->emailId);

        $userEmail = DB::table('notesheet')
        ->where('id',$id->id)
        ->first(); 

        // dd($userEmail->emailId);
        $managerEmail= DB::table('employeesupervisor') 
        ->select('employeesupervisor.emailId','employee')
        ->where( 'employee',$userEmail->createdBy)
        ->first();
        // dd($managerEmail);
        $managerEmp= DB::table('employeesupervisor') 
        ->select('supervisor')
        ->where( 'employee',$userEmail->createdBy)
        ->first();
        // dd($managerEmp);

        $GmEmail= DB::table('employeesupervisor') 
        ->select('employeesupervisor.emailId','employeesupervisor.employee')
        ->where( 'employee',$managerEmp->supervisor)
        ->first();

    if($request->status == "DirectorRecommended" ){  //&& $request->remarks != ''
        // $id = DB::table('notesheet')->select('id')
        // ->where('id',$request->id)
        // ->first();   
        
        $re="Recommended";
    
           $users = new notesheetapprove;         //notesheetaprove is ModelName
            $users->noteId = $id->id;                 
            $users->modifier =  $request->empId;       //EmpId is from dB
            $users->remarks = $request->remarks;
            $users->modiType = $re;         
            $users->save();
    
        notesheetRequest::updateOrCreate(['id' => $id->id],
        ['status' =>$request->status]); 
        
        //email from here
        // $managerEmail= DB::table('employeesupervisor')  
        // ->select('employeesupervisor.emailId')
        // ->where( 'employee',Auth::user()->empId)
        // ->first();
       
        // $managerempid= DB::table('employeesupervisor') 
        // ->select('employeesupervisor.supervisor')
        // ->where( 'employee',Auth::user()->empId)
        // ->first();       

        // $GmEmail= DB::table('employeesupervisor')  
        // ->select('employeesupervisor.emailId')
        // ->where( 'employee',$managerempid->supervisor)
        // ->first();

        // $Gmempid=DB::table('employeesupervisor') 
        // ->select('employeesupervisor.supervisor')
        // ->where( 'employee',$managerempid->supervisor)
        // ->first();

        // $DirectorEmail= DB::table('employeesupervisor')  
        // ->select('employeesupervisor.emailId')
        // ->where( 'employee', $Gmempid->supervisor)
        // ->first();

        // $Driectorempid=DB::table('employeesupervisor') 
        // ->select('employeesupervisor.supervisor')
        // ->where( 'employee',$Gmempid->supervisor)
        // ->first();
        
        // $CEOEmail=DB::table('employeesupervisor')  
        // ->select('employeesupervisor.emailId')
        // ->where( 'employee', Auth::user()->empId)
        // ->first();
        // // dd($CEOEmail->emailId);

        // $userEmail = DB::table('notesheet')
        // ->where('id',$id->id)
        // ->first(); 

        // // dd($userEmail->emailId);
        // $managerEmail= DB::table('employeesupervisor') 
        // ->select('employeesupervisor.emailId','employee')
        // ->where( 'employee',$userEmail->createdBy)
        // ->first();
        // // dd($managerEmail);
        // $managerEmp= DB::table('employeesupervisor') 
        // ->select('supervisor')
        // ->where( 'employee',$userEmail->createdBy)
        // ->first();
        // // dd($managerEmp);

        // $GmEmail= DB::table('employeesupervisor') 
        // ->select('employeesupervisor.emailId','employeesupervisor.employee')
        // ->where( 'employee',$managerEmp->supervisor)
        // ->first();

        // dd($GMEmail->emailId);


    
        $userDetail= DB::table('users') 
        ->join('officedetails', 'officedetails.id', '=', 'users.office')
        ->select('users.*','officedetails.longOfficeName')
        ->where( 'users.empId',Auth::user()->empId)
        ->first();

        $notetitle= DB::table('notesheet')  
        ->join('noteapproval', 'noteapproval.noteId', '=', 'notesheet.id')
        ->select('notesheet.topic')
        ->where('notesheet.id',$id->id)
        ->first();

        $supervisor = ['title' => 'Mail From the HRIS System', 'body' => 'Dear sir/madam,', 'body1' => 
        'You have a request for notesheet titled <b> ' . $notetitle->topic . '</b> recommended by Director ' . $userDetail->empName . 
        ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.',
         'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: http://hris.bpc.bt', 'body5' => 'Kindness always comes back','body6' => '', ];
       
        // $userEmail = DB::table('notesheet')
        // ->where('id',$id->id)
        // ->first();    

        
        // dd($userEmail,$managerempid,$managerEmail,$Gmempid,$GmEmail,
        // $Driectorempid,$DirectorEmail,$CEOEmail);

       

       
        Mail::to($CEOEmail->emailId) 
         ->cc([$GmEmail->emailId,$managerEmail->emailId,$userEmail->emailId])
         ->send(new MyTestMail($supervisor)); 
                
        return redirect('home')->with('success','You have recommended and forwarded the Notesheet');
        }
    
                if($request->status1 == "Approved" ){
                // $id = DB::table('notesheet')->select('id')
                // ->where('id',$request->id)
                // ->first(); 
                
            
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

                $notetitle= DB::table('notesheet')  
                ->join('noteapproval', 'noteapproval.noteId', '=', 'notesheet.id')
                ->select('notesheet.topic')
                ->where('notesheet.id',$id->id)
                ->first();



                
                $approve = ['title' => 'Mail From the HRIS System Approve', 'body' => 'Dear sir/madam,', 'body1' => 'Your request for notesheet titled <b>' . $notetitle->topic . ' </b> has been Approved by the Director ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => '', 'body4' => '','body5' => 'Self-belief and hard work will always earn you success.','body6' => '', ];
                      
               
                // $userEmail = DB::table('notesheet')
                // ->where('id',$id->id)
                // ->first(); 
                // dd($userEmail);
        
                // Mail::to($userEmail->emailId) 
                // ->cc([$GmEmail->emailId,$managerEmail->emailId])          
                // ->send(new MyTestMail($approve)); 
                Mail::to($userEmail->emailId) 
                ->cc([$GmEmail->emailId,$managerEmail->emailId])
                ->send(new MyTestMail($approve)); 
            
                return redirect('home')->with('success','You have Approved the Notesheet');   
            }

    
                if($request->status2 == "Rejected"){
                    // $id = DB::table('notesheet')->select('id')
                    // ->where('id',$request->id)
                    // ->first();  
                           
                                
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


                    $notetitle= DB::table('notesheet')  
                    ->join('noteapproval', 'noteapproval.noteId', '=', 'notesheet.id')
                    ->select('notesheet.topic')
                    ->where('notesheet.id',$id->id)
                    ->first();

                    $reject = ['title' => 'Mail From the HRIS System Reject', 'body' => 'Dear sir/madam,', 'body1' => 'Your request for notesheet titled <b> ' . $notetitle->topic . '</b> has been Rejected by the Director ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Reason:'. $request->remarks2 .'.', 'body4' => '','body5' => 'Your patience is your power. Smile','body6' => '', ];
                   
                                  
                    // $userEmail = DB::table('notesheet')
                    // ->where('id',$id->id)
                    // ->first(); 
                    // dd($userEmail);
            
                    // Mail::to($userEmail->emailId) 
                    // ->cc([$GmEmail->emailId,$managerEmail->emailId])  
                    // ->send(new MyTestMail($reject));

                    Mail::to($userEmail->emailId) 
                    ->cc([$GmEmail->emailId,$managerEmail->emailId])
                    ->send(new MyTestMail($reject));
           
                return redirect('home')->with('error','You have rejected the Notesheet');    
            }

            else{
                return redirect('home')->with('error','You cannot leave the remarks field empty test!!');  
            }
         

  }  
  
  
  public function ceorecommendnotesheet(Request $request) 
 {

    // dd($request);   
    //no need CEO recommended status    
       
    $id = DB::table('notesheet')->select('id')
    ->where('id',$request->id)
    ->first();

    $CEOEmail=DB::table('employeesupervisor')  
    ->select('employeesupervisor.emailId')
    ->where( 'employee', Auth::user()->empId)
    ->first();
    // dd($CEOEmail->emailId);

    $userEmail = DB::table('notesheet')
    ->where('id',$id->id)
    ->first(); 

    // dd($userEmail->emailId);
    $managerEmail= DB::table('employeesupervisor') 
    ->select('employeesupervisor.emailId','employee')
    ->where( 'employee',$userEmail->createdBy)
    ->first();
    // dd($managerEmail);
    $managerEmp= DB::table('employeesupervisor') 
    ->select('supervisor')
    ->where( 'employee',$userEmail->createdBy)
    ->first();
                    // dd($userEmail->emailId);
//
    $GmEmail= DB::table('employeesupervisor') 
    ->select('employeesupervisor.emailId','employeesupervisor.employee')
    ->where( 'employee',$managerEmp->supervisor)
    ->first();
                    // dd($GmEmail->emailId);


    $GmEmp= DB::table('employeesupervisor') 
    ->select('supervisor')
    ->where( 'employee',$managerEmp->supervisor)
    ->first();

    // dd($GmEmp->supervisor);
    $DirectorEmail= DB::table('employeesupervisor') 
    ->select('employeesupervisor.emailId','employeesupervisor.employee')
    ->where( 'employee',$GmEmp->supervisor)
    ->first();

        if($request->status1 == "Approved" ){
                // $id = DB::table('notesheet')->select('id')
                // ->where('id',$request->id)
                // ->first();                 
                        
                $users = new notesheetapprove;//users is ModelName
                    $users->noteId = $id->id;//emp_id is from input name
                    $users->modifier =  $request->empId;//EmpName is from dB
                    $users->remarks = $request->remarks1;
                    $users->modiType = $request->status1;//emp_id is from input name
                    $users->save();
            
                notesheetRequest::updateOrCreate(['id' => $id->id],
                ['status' =>$request->status1]);    //emp_id is from input name
                
                //email from here

//         $CEOEmail=DB::table('employeesupervisor')  
//         ->select('employeesupervisor.emailId')
//         ->where( 'employee', Auth::user()->empId)
//         ->first();
//         // dd($CEOEmail->emailId);

//         $userEmail = DB::table('notesheet')
//         ->where('id',$id->id)
//         ->first(); 

//         // dd($userEmail->emailId);
//         $managerEmail= DB::table('employeesupervisor') 
//         ->select('employeesupervisor.emailId','employee')
//         ->where( 'employee',$userEmail->createdBy)
//         ->first();
//         // dd($managerEmail);
//         $managerEmp= DB::table('employeesupervisor') 
//         ->select('supervisor')
//         ->where( 'employee',$userEmail->createdBy)
//         ->first();
//                         // dd($userEmail->emailId);
// //
//         $GmEmail= DB::table('employeesupervisor') 
//         ->select('employeesupervisor.emailId','employeesupervisor.employee')
//         ->where( 'employee',$managerEmp->supervisor)
//         ->first();
//                         // dd($GmEmail->emailId);


//         $GmEmp= DB::table('employeesupervisor') 
//         ->select('supervisor')
//         ->where( 'employee',$managerEmp->supervisor)
//         ->first();

//         // dd($GmEmp->supervisor);
//         $DirectorEmail= DB::table('employeesupervisor') 
//         ->select('employeesupervisor.emailId','employeesupervisor.employee')
//         ->where( 'employee',$GmEmp->supervisor)
//         ->first();

                // dd($DirectorEmail->emailId);
    //email from here
                 $userDetail= DB::table('users') 
                    ->join('officedetails', 'officedetails.id', '=', 'users.office')
                    ->select('users.*','officedetails.longOfficeName')
                    ->where( 'users.empId',Auth::user()->empId)
                    ->first(); 
                    
                    
                    $notetitle= DB::table('notesheet')  
                    ->join('noteapproval', 'noteapproval.noteId', '=', 'notesheet.id')
                    ->select('notesheet.topic')
                    ->where('notesheet.id',$id->id)
                    ->first();


                $approve = ['title' => 'Mail From the HRIS System Approve', 'body' => 'Dear sir/madam,', 'body1' => 'Your request for notesheet titled <b>' . $notetitle->topic . ' </b>  has been approved by CEO ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => '', 'body4' => '','body5' => ' Positivity always wins.','body6' => '', ];
                
               
                // $userEmail = DB::table('notesheet')
                // ->where('id',$id->id)
                // ->first(); 
                // dd($userEmail);
        
                Mail::to($userEmail->emailId) 
                ->cc([$DirectorEmail->emailId,$GmEmail->emailId,$managerEmail->emailId])          
                ->send(new MyTestMail($approve)); 
            
                return redirect('home')->with('success','You have Approved the Notesheet');   
            }
    
                if($request->status2 == "Rejected"){
                    // $id = DB::table('notesheet')->select('id')
                    // ->where('id',$request->id)
                    // ->first();  
                           
                     $users = new notesheetapprove;//users is ModelName
                        $users->noteId = $id->id;//emp_id is from input name
                        $users->modifier =  $request->empId;//EmpName is from dB
                        $users->remarks = $request->remarks2;
                        $users->modiType = $request->status2;//emp_id is from input name
                        $users->save();


                         
            
                    notesheetRequest::updateOrCreate(['id' => $id->id],
                    ['status' =>$request->status2]);//emp_id is from input name
                    
                    // email from here
                     $userDetail= DB::table('users') 
                    ->join('officedetails', 'officedetails.id', '=', 'users.office')
                    ->select('users.*','officedetails.longOfficeName')
                    ->where( 'users.empId',Auth::user()->empId)
                    ->first();

                    $notetitle= DB::table('notesheet')  
                    ->join('noteapproval', 'noteapproval.noteId', '=', 'notesheet.id')
                    ->select('notesheet.topic')
                    ->where('notesheet.id',$id->id)
                    ->first();


                    $reject = ['title' => 'Mail From the HRIS System Reject', 'body' => 'Dear sir/madam,', 'body1' => 'Your request for notesheet titled  <b>' . $notetitle->topic . ' </b>  has been rejected by CEO ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => '', 'body4' => 'click here: http://hris.bpc.bt', 'body5' => 'Your patience is your power. Smile','body6' => '', ];
                   
                                  
                //     $userEmail = DB::table('notesheet')
                //     ->where('id',$id->id)
                //     ->first(); 
                    // dd($userEmail);
                    Mail::to($userEmail->emailId) 
                    ->cc([$DirectorEmail->emailId,$GmEmail->emailId,$managerEmail->emailId])          
                    ->send(new MyTestMail($reject));
                
                 // Mail::to($userEmail->emailId) 
                    // ->cc([$GmEmail->emailId,$managerEmail->emailId])  
                    // ->send(new MyTestMail($reject));
           
                return redirect('home')->with('error','You have rejected the Notesheet');    
     }

            else{
                return redirect('home')->with('error','You cannot leave the remarks field empty!');  
        }
         

  }

}
