<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\knowledgeRequest;
use App\knowledgeRequestSupervisor;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use App\knowledgeapprove;
use DB;
use Auth;

class KnowledgeController extends Controller
{

    public function supervisorApproval($id)
    {

    
        $knowledgeRemarks = knowledgeapprove::all()
        ->where('noteId',$id);
 
   
      
        return view('knowledge.approve',compact('knowledgeRemarks'));
    }


    public function requestKnowledge(Request $request)
    {

        // dd($request->all());

        // $supervisorEmail= DB::table('employeesupervisor')  
        // ->select('employeesupervisor.emailId')
        // ->where( 'employee',Auth::user()->empId)
        // ->first();

       
        // $userDetail= DB::table('users') 
        // ->join('officedetails', 'officedetails.id', '=', 'users.office')
        // ->select('users.*','officedetails.longOfficeName')
        // ->where( 'users.empId',Auth::user()->empId)
        // ->first();

        // $supervisor = ['title' => 'Mail From the HRIS System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for knowledge from ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: bose.bpc.bt','body5' => '','body6' => '', ];

        // $officeHead= DB::table('employeesupervisor')  
        // ->where( 'supervisor',Auth::user()->empId)
        // ->first();

        // if($officeHead == null)
        // {
            // $supervisorEmail= DB::table('employeesupervisor')  
            // ->select('employeesupervisor.emailId')
            // ->where( 'employee',Auth::user()->empId)
            // ->first();
            
            $requestKnowledge = new knowledgeRequest;
            $requestKnowledge->createdBy = $request->empId;
            $requestKnowledge->problem = $request->problem;
            $requestKnowledge->solution = $request->solution;               
            $requestKnowledge->createdOn = $request->knowledgeDate;
            $requestKnowledge->save();  

           
    
           
        return redirect('home')
        ->with('success', 'knowledge submitted successfully');

 }
 public function selfghCancelBooking()
{

 $selfghCancelBooking= DB::table('knowledge')  
->where( 'createdBy',Auth::user()->empId)
//  ->where('status', '=', 'Processing')

 ->select('*')
                                    
 ->latest('knowledge.id') //similar to orderby('roombed.id','desc')            
  ->paginate(100000000);

$rhtml = view('knowledge.knowledgeCancel')->with(['selfghCancelBooking' => $selfghCancelBooking])->render();
return response()
  ->json(array(
  'success' => true,
  'html' => $rhtml
));
}

public function cancelknowledge(Request $request)
{


    DB::update('update knowledge set cancelled = ? where id = ?', [$request->cancelled, $request->id]);       

    return redirect('home')->with('error','You have cancelled the knowledge');


    //   $id = DB::table('knowledge')
    //             ->select('cancelled','id')
    //             ->where('cancelled',$request->id)
    //             ->first();

    //             // dd($request);

    // if($id == null){
    //     DB::update('update knowledge set cancelled = ? where id = ?', [$request->cancelled, $request->id]);       

    //     return redirect('home')->with('error','You have cancelled the knowledge');

    // }
    // if($id->cancelled == 'Yes'){
    //     return redirect('home')->with('error','You cannot cancel the knowledge now!');
    // }


  }



public function recommendknowledge(Request $request)
{
//  dd($request);
// try{
    
    if($request->status == "Recommended" ){  //&& $request->remarks != ''
        $id = DB::table('knowledge')->select('id')
        ->where('id',$request->id)
        ->first();   
        
    
           $users = new knowledgeapprove;//users is ModelName
            $users->noteId = $id->id;//emp_id is from input name
            $users->modifier =  $request->empId;//EmpName is from dB
            $users->remarks = $request->remarks;
            $users->modiType = $request->status;//emp_id is from input name
            $users->save();
    
        knowledgeRequest::updateOrCreate(['id' => $id->id],
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

        $supervisor = ['title' => 'Mail From the HRIS System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for knowledge from ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: bose.bpc.bt','body5' => '','body6' => '', ];
       
        $userEmail = DB::table('knowledge')
        ->where('id',$id->id)
        ->first(); 
        // dd($userEmail);

        Mail::to($supervisorEmail->emailId) 
        ->cc($userEmail->emailId)
        ->send(new MyTestMail($supervisor)); 
                
        return redirect('home')->with('success','You have recommended and forwarded the knowledge');
        }
    
                if($request->status1 == "Approved" ){
                $id = DB::table('knowledge')->select('id')
                ->where('id',$request->id)
                ->first(); 
                
            
                // $remarks1 = implode(',', $request->remarks1);
                // $GM="GM";
            
                $users = new knowledgeapprove;//users is ModelName
                    $users->noteId = $id->id;//emp_id is from input name
                    $users->modifier =  $request->empId;//EmpName is from dB
                    $users->remarks = $request->remarks1;
                    $users->modiType = $request->status1;//emp_id is from input name
                    $users->save();
            
                knowledgeRequest::updateOrCreate(['id' => $id->id],
                ['status' =>$request->status1]);//emp_id is from input name
                
                //email from here

                $userDetail= DB::table('users') 
                ->join('officedetails', 'officedetails.id', '=', 'users.office')
                ->select('users.*','officedetails.longOfficeName')
                ->where( 'users.empId',Auth::user()->empId)
                ->first();
                
                $approve = ['title' => 'Mail From the HRIS System Approve', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for knowledge from ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: bose.bpc.bt','body5' => '','body6' => '', ];
                
                
               
                $userEmail = DB::table('knowledge')
                ->where('id',$id->id)
                ->first(); 
                // dd($userEmail);
        
                Mail::to($userEmail->emailId) 
                // ->cc($userEmail->emailId)
                ->send(new MyTestMail($approve)); 
            
                return redirect('home')->with('success','You have Approved the knowledge');   
            }

    
                if($request->status2 == "Rejected"){
                    $id = DB::table('knowledge')->select('id')
                    ->where('id',$request->id)
                    ->first();  
                           
                
                    // $remarks2 = implode(',', $request->remarks2);
                    // $GM="GM";
                
                    $users = new knowledgeapprove;//users is ModelName
                        $users->noteId = $id->id;//emp_id is from input name
                        $users->modifier =  $request->empId;//EmpName is from dB
                        $users->remarks = $request->remarks2;
                        $users->modiType = $request->status2;//emp_id is from input name
                        $users->save();
                
                    knowledgeRequest::updateOrCreate(['id' => $id->id],
                    ['status' =>$request->status2]);//emp_id is from input name
                    
                    //email from here
                    $userDetail= DB::table('users') 
                    ->join('officedetails', 'officedetails.id', '=', 'users.office')
                    ->select('users.*','officedetails.longOfficeName')
                    ->where( 'users.empId',Auth::user()->empId)
                    ->first();

                    $reject = ['title' => 'Mail From the HRIS System Reject', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for knowledge from ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: bose.bpc.bt','body5' => '','body6' => '', ];
                   
                
                   
                    $userEmail = DB::table('knowledge')
                    ->where('id',$id->id)
                    ->first(); 
                    // dd($userEmail);
            
                    Mail::to($userEmail->emailId) 
                    // ->cc($userEmail->emailId)
                    ->send(new MyTestMail($reject));
               
                    return redirect('home')->with('error','You have rejected the knowledge');    
                }    
                
                else{
                    return redirect('home')->with('error','You cannot leave the remarks field empty!!');  
                }
                   
             
    
            }
        
    //     catch(\Illuminate\Database\QueryException $t) { 

    //         return redirect('home')->with('error','You cannot leave the remarks field empty!!');  

    //     }
    // }

            

            
 public function GMrecommendknowledge(Request $request) 
 {

    if($request->status == "GMRecommended" ){  //&& $request->remarks != ''
        $id = DB::table('knowledge')->select('id')
        ->where('id',$request->id)
        ->first();   
        
        $re="Recommended";
    
           $users = new knowledgeapprove;         //knowledgeaprove is ModelName
            $users->noteId = $id->id;                 
            $users->modifier =  $request->empId;       //EmpId is from dB
            $users->remarks = $request->remarks;
            $users->modiType = $re;         
            $users->save();
    
        knowledgeRequest::updateOrCreate(['id' => $id->id],
        ['status' =>$request->status]); 
        
        //email from here
        $managerEmail= DB::table('employeesupervisor')  
        ->select('employeesupervisor.emailId')
        ->where( 'employee',Auth::user()->empId)
        ->first();
       
        $managerempid= DB::table('employeesupervisor') 
        ->select('employeesupervisor.supervisor')
        ->where( 'employee',Auth::user()->empId)
        ->first();

       

        $GmEmail= DB::table('employeesupervisor')  
        ->select('employeesupervisor.emailId')
        ->where( 'employee',$managerempid->supervisor)
        ->first();

        $Gmempid=DB::table('employeesupervisor') 
        ->select('employeesupervisor.supervisor')
        ->where( 'employee',$managerempid->supervisor)
        ->first();


        $DirectorEmail= DB::table('employeesupervisor')  
        ->select('employeesupervisor.emailId')
        ->where( 'employee', $Gmempid->supervisor)
        ->first();

    
        $userDetail= DB::table('users') 
        ->join('officedetails', 'officedetails.id', '=', 'users.office')
        ->select('users.*','officedetails.longOfficeName')
        ->where( 'users.empId',Auth::user()->empId)
        ->first();

        $supervisor = ['title' => 'Mail From the HRIS System', 'body' => 'Dear sir/madam,', 'body1' => 
        'You have a request for knowledge from ' . $userDetail->empName . 
        ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.',
         'body2' => '', 'body3' => 'Please kindly do the necessary action,send by GM.', 'body4' => 'click here: bose.bpc.bt','body5' => '','body6' => '', ];
       
        $userEmail = DB::table('knowledge')
        ->where('id',$id->id)
        ->first(); 
     
//  dd($userEmail,$managerempid,$managerEmail,$Gmempid,$GmEmail,$DirectorEmail);


        Mail::to($DirectorEmail->emailId) 
                ->cc([$managerEmail->emailId,$userEmail->emailId])
                ->send(new MyTestMail($supervisor)); 
                
        return redirect('home')->with('success','You have recommended and forwarded the knowledge');
        }
    
                if($request->status1 == "Approved" ){
                $id = DB::table('knowledge')->select('id')
                ->where('id',$request->id)
                ->first(); 
                
            
                // $remarks1 = implode(',', $request->remarks1);
                // $GM="GM";
            
                $users = new knowledgeapprove;//users is ModelName
                    $users->noteId = $id->id;//emp_id is from input name
                    $users->modifier =  $request->empId;//EmpName is from dB
                    $users->remarks = $request->remarks1;
                    $users->modiType = $request->status1;//emp_id is from input name
                    $users->save();
            
                knowledgeRequest::updateOrCreate(['id' => $id->id],
                ['status' =>$request->status1]);//emp_id is from input name
                
                //email from here

                $userDetail= DB::table('users') 
                ->join('officedetails', 'officedetails.id', '=', 'users.office')
                ->select('users.*','officedetails.longOfficeName')
                ->where( 'users.empId',Auth::user()->empId)
                ->first();
                
                $approve = ['title' => 'Mail From the HRIS System Approve', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for knowledge from ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: bose.bpc.bt','body5' => '','body6' => '', ];
                               
               
                $userEmail = DB::table('knowledge')
                ->where('id',$id->id)
                ->first(); 
                // dd($userEmail);
        
                Mail::to($userEmail->emailId) 
                ->cc($managerEmail->emailId)
                ->send(new MyTestMail($approve)); 
            
                return redirect('home')->with('success','You have Approved the knowledge');   
            }

    
                if($request->status2 == "Rejected"){
                    $id = DB::table('knowledge')->select('id')
                    ->where('id',$request->id)
                    ->first();                          
                
                   
                
                    $users = new knowledgeapprove;//users is ModelName
                        $users->noteId = $id->id;//emp_id is from input name
                        $users->modifier =  $request->empId;//EmpName is from dB
                        $users->remarks = $request->remarks2;
                        $users->modiType = $request->status2;//emp_id is from input name
                        $users->save();
                
                    knowledgeRequest::updateOrCreate(['id' => $id->id],
                    ['status' =>$request->status2]);//emp_id is from input name
                    
                    //email from here
                    $userDetail= DB::table('users') 
                    ->join('officedetails', 'officedetails.id', '=', 'users.office')
                    ->select('users.*','officedetails.longOfficeName')
                    ->where( 'users.empId',Auth::user()->empId)
                    ->first();

                    $reject = ['title' => 'Mail From the HRIS System Reject', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for knowledge from ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: bose.bpc.bt','body5' => '','body6' => '', ];
                   
                                  
                    $userEmail = DB::table('knowledge')
                    ->where('id',$id->id)
                    ->first(); 
                    // dd($userEmail);
            
                    Mail::to($userEmail->emailId) 
                    ->cc($managerEmail->emailId)
                    ->send(new MyTestMail($reject));
           
                return redirect('home')->with('error','You have rejected the knowledge');    
            }

            else{
                return redirect('home')->with('error','You cannot leave the remarks field empty test!!');  
            }
         

  }

  public function directorrecommendknowledge(Request $request) 
 {

    if($request->status == "DirectorRecommended" ){  //&& $request->remarks != ''
        $id = DB::table('knowledge')->select('id')
        ->where('id',$request->id)
        ->first();   
        
        $re="Recommended";
    
           $users = new knowledgeapprove;         //knowledgeaprove is ModelName
            $users->noteId = $id->id;                 
            $users->modifier =  $request->empId;       //EmpId is from dB
            $users->remarks = $request->remarks;
            $users->modiType = $re;         
            $users->save();
    
        knowledgeRequest::updateOrCreate(['id' => $id->id],
        ['status' =>$request->status]); 
        
        //email from here
        $managerEmail= DB::table('employeesupervisor')  
        ->select('employeesupervisor.emailId')
        ->where( 'employee',Auth::user()->empId)
        ->first();
       
        $managerempid= DB::table('employeesupervisor') 
        ->select('employeesupervisor.supervisor')
        ->where( 'employee',Auth::user()->empId)
        ->first();       

        $GmEmail= DB::table('employeesupervisor')  
        ->select('employeesupervisor.emailId')
        ->where( 'employee',$managerempid->supervisor)
        ->first();

        $Gmempid=DB::table('employeesupervisor') 
        ->select('employeesupervisor.supervisor')
        ->where( 'employee',$managerempid->supervisor)
        ->first();

        $DirectorEmail= DB::table('employeesupervisor')  
        ->select('employeesupervisor.emailId')
        ->where( 'employee', $Gmempid->supervisor)
        ->first();

        $Driectorempid=DB::table('employeesupervisor') 
        ->select('employeesupervisor.supervisor')
        ->where( 'employee',$Gmempid->supervisor)
        ->first();
        
        $CEOEmail=DB::table('employeesupervisor')  
        ->select('employeesupervisor.emailId')
        ->where( 'employee', $Driectorempid->supervisor)
        ->first();
    
        $userDetail= DB::table('users') 
        ->join('officedetails', 'officedetails.id', '=', 'users.office')
        ->select('users.*','officedetails.longOfficeName')
        ->where( 'users.empId',Auth::user()->empId)
        ->first();

        $supervisor = ['title' => 'Mail From the HRIS System', 'body' => 'Dear sir/madam,', 'body1' => 
        'You have a request for knowledge from ' . $userDetail->empName . 
        ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.',
         'body2' => '', 'body3' => 'Please kindly do the necessary action,send by Director.', 'body4' => 'click here: bose.bpc.bt','body5' => '','body6' => '', ];
       
        $userEmail = DB::table('knowledge')
        ->where('id',$id->id)
        ->first();    

        
        // dd($userEmail,$managerempid,$managerEmail,$Gmempid,$GmEmail,
        // $Driectorempid,$DirectorEmail,$CEOEmail);

       

       
        Mail::to($CEOEmail->emailId) 
         ->cc([$GmEmail->emailId,$managerEmail->emailId,$userEmail->emailId])
         ->send(new MyTestMail($supervisor)); 
                
        return redirect('home')->with('success','You have recommended and forwarded the knowledge');
        }
    
                if($request->status1 == "Approved" ){
                $id = DB::table('knowledge')->select('id')
                ->where('id',$request->id)
                ->first(); 
                
            
                // $remarks1 = implode(',', $request->remarks1);
                // $GM="GM";
            
                $users = new knowledgeapprove;//users is ModelName
                    $users->noteId = $id->id;//emp_id is from input name
                    $users->modifier =  $request->empId;//EmpName is from dB
                    $users->remarks = $request->remarks1;
                    $users->modiType = $request->status1;//emp_id is from input name
                    $users->save();
            
                knowledgeRequest::updateOrCreate(['id' => $id->id],
                ['status' =>$request->status1]);//emp_id is from input name
                
                //email from here

                $userDetail= DB::table('users') 
                ->join('officedetails', 'officedetails.id', '=', 'users.office')
                ->select('users.*','officedetails.longOfficeName')
                ->where( 'users.empId',Auth::user()->empId)
                ->first();
                
                $approve = ['title' => 'Mail From the HRIS System Approve', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for knowledge from ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: bose.bpc.bt','body5' => '','body6' => '', ];
                      
               
                $userEmail = DB::table('knowledge')
                ->where('id',$id->id)
                ->first(); 
                // dd($userEmail);
        
                Mail::to($userEmail->emailId) 
                ->cc([$GmEmail->emailId,$managerEmail->emailId])          
                ->send(new MyTestMail($approve)); 
            
                return redirect('home')->with('success','You have Approved the knowledge');   
            }

    
                if($request->status2 == "Rejected"){
                    $id = DB::table('knowledge')->select('id')
                    ->where('id',$request->id)
                    ->first();  
                           
                                
                    $users = new knowledgeapprove;//users is ModelName
                        $users->noteId = $id->id;//emp_id is from input name
                        $users->modifier =  $request->empId;//EmpName is from dB
                        $users->remarks = $request->remarks2;
                        $users->modiType = $request->status2;//emp_id is from input name
                        $users->save();
                
                    knowledgeRequest::updateOrCreate(['id' => $id->id],
                    ['status' =>$request->status2]);//emp_id is from input name
                    
                    //email from here
                 $userDetail= DB::table('users') 
                    ->join('officedetails', 'officedetails.id', '=', 'users.office')
                    ->select('users.*','officedetails.longOfficeName')
                    ->where( 'users.empId',Auth::user()->empId)
                    ->first();

                    $reject = ['title' => 'Mail From the HRIS System Reject', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for knowledge from ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: bose.bpc.bt','body5' => '','body6' => '', ];
                   
                                  
                    $userEmail = DB::table('knowledge')
                    ->where('id',$id->id)
                    ->first(); 
                    // dd($userEmail);
            
                    Mail::to($userEmail->emailId) 
                    ->cc([$GmEmail->emailId,$managerEmail->emailId])  
                    ->send(new MyTestMail($reject));
           
                return redirect('home')->with('error','You have rejected the knowledge');    
            }

            else{
                return redirect('home')->with('error','You cannot leave the remarks field empty test!!');  
            }
         

  }  
  
  
  public function ceorecommendknowledge(Request $request) 
 {

    // dd($request);   
    //no need CEO recommended status    
       
    
                if($request->status1 == "Approved" ){
                $id = DB::table('knowledge')->select('id')
                ->where('id',$request->id)
                ->first();                 
                        
                $users = new knowledgeapprove;//users is ModelName
                    $users->noteId = $id->id;//emp_id is from input name
                    $users->modifier =  $request->empId;//EmpName is from dB
                    $users->remarks = $request->remarks1;
                    $users->modiType = $request->status1;//emp_id is from input name
                    $users->save();
            
                knowledgeRequest::updateOrCreate(['id' => $id->id],
                ['status' =>$request->status1]);    //emp_id is from input name
                
                //email from here

                // $userDetail= DB::table('users') 
                // ->join('officedetails', 'officedetails.id', '=', 'users.office')
                // ->select('users.*','officedetails.longOfficeName')
                // ->where( 'users.empId',Auth::user()->empId)
                // ->first();
                
                // $approve = ['title' => 'Mail From the HRIS System Approve', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for knowledge from ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: bose.bpc.bt','body5' => '','body6' => '', ];
                
               
                // $userEmail = DB::table('knowledge')
                // ->where('id',$id->id)
                // ->first(); 
                // dd($userEmail);
        
                // Mail::to($userEmail->emailId) 
                // ->cc([$GmEmail->emailId,$managerEmail->emailId])          
                // ->send(new MyTestMail($approve)); 
            
                return redirect('home')->with('success','You have Approved the knowledge');   
            }
    
                if($request->status2 == "Rejected"){
                    $id = DB::table('knowledge')->select('id')
                    ->where('id',$request->id)
                    ->first();  
                           
                     $users = new knowledgeapprove;//users is ModelName
                        $users->noteId = $id->id;//emp_id is from input name
                        $users->modifier =  $request->empId;//EmpName is from dB
                        $users->remarks = $request->remarks2;
                        $users->modiType = $request->status2;//emp_id is from input name
                        $users->save();
                
                    knowledgeRequest::updateOrCreate(['id' => $id->id],
                    ['status' =>$request->status2]);//emp_id is from input name
                    
                    //email from here
                //  $userDetail= DB::table('users') 
                //     ->join('officedetails', 'officedetails.id', '=', 'users.office')
                //     ->select('users.*','officedetails.longOfficeName')
                //     ->where( 'users.empId',Auth::user()->empId)
                //     ->first();

                //     $reject = ['title' => 'Mail From the HRIS System Reject', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for knowledge from ' . $userDetail->empName . ' bearing employee Id ' . $userDetail->empId . ' of  ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: bose.bpc.bt','body5' => '','body6' => '', ];
                   
                                  
                //     $userEmail = DB::table('knowledge')
                //     ->where('id',$id->id)
                //     ->first(); 
                    // dd($userEmail);
            
                    // Mail::to($userEmail->emailId) 
                    // ->cc([$GmEmail->emailId,$managerEmail->emailId])  
                    // ->send(new MyTestMail($reject));
           
                return redirect('home')->with('error','You have rejected the knowledge');    
     }

            else{
                return redirect('home')->with('error','You cannot leave the remarks field empty!');  
        }
         

  }

}
