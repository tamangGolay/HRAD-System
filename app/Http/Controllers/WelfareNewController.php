<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use App\welfareRequest;
use App\welfarenoteapproval;
use DB;
use Auth;

class WelfareNewController extends Controller
{
    public function Request_welfare(Request $request)
    {
        $member1Mail= DB::table('welfarecommitte')  
        ->select('welfarecommitte.memberEmail')
        ->where( 'memberType','=','Member 1')
        ->first();

        $member1MailContent = ['title' => 'Mail From the HRIS Welfare System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for welfare form approval with topic: <b>' .$request->topicWelfare. '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: http://hris.bpc.bt', 'body5' => '','body6' => '', ];

            $Request_welfare = new welfareRequest;           //database name n user input name
            $Request_welfare->createdBy = $request->empId;     
            $Request_welfare->emailId = $request->emailId;                           
            $Request_welfare->topic = $request->topicWelfare;             
            $Request_welfare->justification = $request->justification;            
            $Request_welfare->save(); 

            // dd($member1Mail->memberEmail);
            Mail::to($member1Mail->memberEmail) 
            ->send(new MyTestMail($member1MailContent));           

          return redirect('home')->with('page', 'welfare_request')
          ->with('success', 'Welfare Request Form submitted successfully');
        }
          
         public function welfareStatusReview()
         {
         
          $welfareStatusReview= DB::table('welfarenote')  
            ->where('createdBy',Auth::user()->empId)
            ->where('cancelled', '=', 'No')         
            ->select('*')
                                             
            ->latest('welfarenote.id') //similar to orderby('welfarenote.id','desc')            
            ->paginate(1000);
         
         $rhtml = view('welfareNew.welfareselfreview')->with(['welfareStatusReview' => $welfareStatusReview])->render();
         
         return response()
           ->json(array(
           'success' => true,
           'html' => $rhtml
         ));
         }

        public function cancelWelfare(Request $request)
        {
            DB::update('update welfarenote set cancelled = ? where id = ?', [$request->cancelled, $request->id]);       
            return redirect('home')->with('error','You have cancelled the Welfare Request!');   
        }

             /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        welfareRequest::updateOrCreate(['id' => $request->id],
                ['justification' => $request->justification,                                 
                ]); 
                   
        return response()->json(['success'=>'Updated successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $User = welfareRequest::find($id);
        return response()->json($User);
    }

    public function viewRemarks($id)
    {    
        $welfareRemarks = welfarenoteapproval::all()
        ->where('welfareId',$id);   
      
        return view('welfareNew.remarks',compact('welfareRemarks'));
    }

    
    public function recommendWelfare(Request $request) 
    {
       $id = DB::table('welfarenote')->select('id')
       ->where('id',$request->id)
       ->first();                           
       
       $member2Email = DB::table('welfarecommitte')
       ->select('welfarecommitte.memberEmail','welfarecommitte.memberType')
       ->where('memberType','=','Member 2')
       ->first();

       $welfareCommitte = DB::table('welfarecommitte')
       ->select('welfarecommitte.memberType')
       ->where('memberEID','=',Auth::User()->empId)
       ->first();

             
      if($request->status == "Recommended") {
        
                    if($welfareCommitte->memberType == "Member 1"){ 
                      
                          $re="Member1Recommended";
                  
                          $welfarenoteapproval = new welfarenoteapproval;         //notesheetaprove is ModelName
                          $welfarenoteapproval->welfareId = $id->id;                 
                          $welfarenoteapproval->modifier =  $request->empId;       //EmpId is from dB
                          $welfarenoteapproval->remarks = $request->remarks;
                          $welfarenoteapproval->modifierType = $re;         
                          $welfarenoteapproval->save();
                  
                      welfareRequest::updateOrCreate(['id' => $id->id],
                      ['status' =>$re]);                    
                  
                      $userDetail= DB::table('users') 
                      ->join('welfarecommitte', 'welfarecommitte.memberEID', '=', 'users.empId')
                      ->select('users.empName','welfarecommitte.memberType')
                      ->where('memberType','=','Member 1')
                      ->first();

                      $welfaretitle= DB::table('welfarenote')  
                      ->join('welfarenoteapproval', 'welfarenoteapproval.welfareId', '=', 'welfarenote.id')
                      ->select('welfarenote.topic')
                      ->where('welfarenote.id',$id->id)
                      ->first();
              
                      $member2EmailContent = ['title' => 'Mail From the HRIS Welfare System', 'body' => 'Dear sir/madam,', 'body1' => 
                      'You have a request for welfare titled <b> '. $welfaretitle->topic . '</b> recommended by Committe Member 1 Mr/Mrs.' . $userDetail->empName .  '.',
                        'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: http://hris.bpc.bt','body5' => '','body6' => 'Have a good day!', ];
                      
                          Mail::to($member2Email->memberEmail)                    
                              ->send(new MyTestMail($member2EmailContent)); 

                      return redirect('home')
                        ->with('success','You have recommended and forwarded the Welfare Request');
                      }  

                      
                      elseif($welfareCommitte->memberType == "Member 2"){   
                      
                        $re="Member2Recommended";
                
                        $welfarenoteapproval = new welfarenoteapproval;         //notesheetaprove is ModelName
                        $welfarenoteapproval->welfareId = $id->id;                 
                        $welfarenoteapproval->modifier =  $request->empId;       //EmpId is from dB
                        $welfarenoteapproval->remarks = $request->remarks;
                        $welfarenoteapproval->modifierType = $re;         
                        $welfarenoteapproval->save();
                
                    welfareRequest::updateOrCreate(['id' => $id->id],
                    ['status' =>$re]);                    
                
                    $userDetail= DB::table('users') 
                    ->join('welfarecommitte', 'welfarecommitte.memberEID', '=', 'users.empId')
                    ->select('users.empName','welfarecommitte.memberType')
                    ->where('memberType','=','Member 2')
                    ->first();

                    $welfaretitle= DB::table('welfarenote')  
                    ->join('welfarenoteapproval', 'welfarenoteapproval.welfareId', '=', 'welfarenote.id')
                    ->select('welfarenote.topic')
                    ->where('welfarenote.id',$id->id)
                    ->first();

                      $member3Email = DB::table('welfarecommitte')
                      ->select('welfarecommitte.memberEmail','welfarecommitte.memberType')
                      ->where('memberType','=','Chairperson')
                      ->first();
                    
            
                    $member3EmailContent = ['title' => 'Mail From the HRIS Welfare System', 'body' => 'Dear sir/madam,', 'body1' => 
                    'You have a request for welfare titled <b> '. $welfaretitle->topic . '</b> recommended by Committe Member 2 Mr/Mrs.' . $userDetail->empName .  '.',
                      'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: http://hris.bpc.bt','body5' => '','body6' => 'Have a good day!', ];
                    
                        Mail::to($member3Email->memberEmail)                    
                            ->send(new MyTestMail($member3EmailContent)); 

                    return redirect('home')
                        ->with('success','You have recommended and forwarded the Welfare Request');
                    } } 


    elseif($request->status1 == "Approved"){

                        if($welfareCommitte->memberType == "Chairperson"){
                        
                        $re="ChairpersonRecommended";
                
                        $welfarenoteapproval = new welfarenoteapproval;         //notesheetaprove is ModelName
                        $welfarenoteapproval->welfareId = $id->id;                 
                        $welfarenoteapproval->modifier =  $request->empId;       //EmpId is from dB
                        $welfarenoteapproval->remarks = $request->remarks;
                        $welfarenoteapproval->modifierType = $request->status1;         
                        $welfarenoteapproval->save();
                
                        welfareRequest::updateOrCreate(['id' => $id->id],
                        ['status' =>$re]);                    
                
                    $userDetail= DB::table('users') 
                    ->join('welfarecommitte', 'welfarecommitte.memberEID', '=', 'users.empId')
                    ->select('users.empName','welfarecommitte.memberType')
                    ->where('memberType','=','Chairperson')
                    ->first();

                    $welfaretitle= DB::table('welfarenote')  
                      ->join('welfarenoteapproval', 'welfarenoteapproval.welfareId', '=', 'welfarenote.id')
                      ->select('welfarenote.topic')
                      ->where('welfarenote.id',$id->id)
                      ->first();

                    $userEmail = DB::table('welfarenote')
                                  ->where('id',$id->id)
                                  ->first(); 

                    $EmailMemberSecretary = ['title' => 'Mail From the HRIS Welfare System', 'body' => 'Dear sir/madam,', 'body1' => 
                    'Your request for welfare titled <b> '. $welfaretitle->topic . '</b> has been approved by the Chairperson Mr.' . $userDetail->empName .  '.',
                      'body2' => '', 'body3' => '', 'body4' => '','body5' => '','body6' => 'The future belongs to those who believe in the beauty of their dreams!', ];
                                    
                        Mail::to($userEmail->emailId)                    
                            ->send(new MyTestMail($EmailMemberSecretary)); 

                    return redirect('home')
                        ->with('success','You have approved Welfare Request!');
                    }   
                  }                         
                    
    elseif($request->status2 == "Rejected"){  
      
                  if($welfareCommitte->memberType == "Member 1"){
                   
                    $welfarenoteapproval = new welfarenoteapproval;         //notesheetaprove is ModelName
                    $welfarenoteapproval->welfareId = $id->id;                 
                    $welfarenoteapproval->modifier =  $request->empId;       //EmpId is from dB
                    $welfarenoteapproval->remarks = $request->remarks;
                    $welfarenoteapproval->modifierType = $request->status2;         
                    $welfarenoteapproval->save();
            
                  welfareRequest::updateOrCreate(['id' => $id->id],
                  ['status' =>$request->status2]);   
                                              
                  $userDetail= DB::table('users') 
                  ->join('welfarecommitte', 'welfarecommitte.memberEID', '=', 'users.empId')
                  ->select('users.empName','welfarecommitte.memberType')
                  ->where('memberType','=','Member 1')
                  ->first();  
                  
                  $welfaretitle= DB::table('welfarenote')  
                  ->join('welfarenoteapproval', 'welfarenoteapproval.welfareId', '=', 'welfarenote.id')
                  ->select('welfarenote.topic')
                  ->where('welfarenote.id',$id->id)
                  ->first();
      
                  $rejectWelfare = ['title' => 'Mail From the HRIS Welfare System', 'body' => 'Dear sir/madam,', 'body1' => 'Your request for welfare titled <b>' . $welfaretitle->topic . '</b> has been rejected by committe member 1 Mr/Mrs.' . $userDetail->empName . '.', 'body2' => '', 'body3' => 'Reason:' . $request->remarks2 .'.', 'body4' => 'click here: http://hris.bpc.bt', 'body5' => 'Your patience is your power. Smile','body6' => '', ];
                                                    
                    $userEmail = DB::table('welfarenote')
                    ->where('id',$id->id)
                    ->first();                       
               
                       Mail::to($userEmail->emailId)                       
                       ->send(new MyTestMail($rejectWelfare));
                         
                   return redirect('home')
                      ->with('error','You have rejected the Welfare Request!');    
               }

               elseif($welfareCommitte->memberType == "Member 2"){
                   
                $welfarenoteapproval = new welfarenoteapproval;         //notesheetaprove is ModelName
                $welfarenoteapproval->welfareId = $id->id;                 
                $welfarenoteapproval->modifier =  $request->empId;       //EmpId is from dB
                $welfarenoteapproval->remarks = $request->remarks;
                $welfarenoteapproval->modifierType = $request->status2;         
                $welfarenoteapproval->save();
        
              welfareRequest::updateOrCreate(['id' => $id->id],
              ['status' =>$request->status2]);   
                                          
              $userDetail= DB::table('users') 
              ->join('welfarecommitte', 'welfarecommitte.memberEID', '=', 'users.empId')
              ->select('users.empName','welfarecommitte.memberType')
              ->where('memberType','=','Member 2')
              ->first();  
              
              $welfaretitle= DB::table('welfarenote')  
              ->join('welfarenoteapproval', 'welfarenoteapproval.welfareId', '=', 'welfarenote.id')
              ->select('welfarenote.topic')
              ->where('welfarenote.id',$id->id)
              ->first();
  
              $rejectWelfare = ['title' => 'Mail From the HRIS Welfare System', 'body' => 'Dear sir/madam,', 'body1' => 'Your request for welfare titled <b>' . $welfaretitle->topic . '</b> has been rejected by committe member 2 Mr/Mrs.' . $userDetail->empName . '.', 'body2' => '', 'body3' => 'Reason:' . $request->remarks2 .'.', 'body4' => 'click here: http://hris.bpc.bt', 'body5' => 'Your patience is your power. Smile','body6' => '', ];
                                                
                $userEmail = DB::table('welfarenote')
                ->where('id',$id->id)
                ->first();                       
           
                   Mail::to($userEmail->emailId)                       
                   ->send(new MyTestMail($rejectWelfare));
                     
               return redirect('home')
                    ->with('error','You have rejected the Welfare Request!');    
              }

                else{
                  //chairperson as memberType in else part
                        
                  $welfarenoteapproval = new welfarenoteapproval;         //notesheetaprove is ModelName
                  $welfarenoteapproval->welfareId = $id->id;                 
                  $welfarenoteapproval->modifier =  $request->empId;       //EmpId is from dB
                  $welfarenoteapproval->remarks = $request->remarks;
                  $welfarenoteapproval->modifierType = $request->status2;         
                  $welfarenoteapproval->save();
          
                welfareRequest::updateOrCreate(['id' => $id->id],
                ['status' =>$request->status2]);   
                                            
                $userDetail= DB::table('users') 
                ->join('welfarecommitte', 'welfarecommitte.memberEID', '=', 'users.empId')
                ->select('users.empName','welfarecommitte.memberType')
                ->where('memberType','=','Chairperson')
                ->first();  
                
                $welfaretitle= DB::table('welfarenote')  
                ->join('welfarenoteapproval', 'welfarenoteapproval.welfareId', '=', 'welfarenote.id')
                ->select('welfarenote.topic')
                ->where('welfarenote.id',$id->id)
                ->first();

                $rejectWelfare = ['title' => 'Mail From the HRIS Welfare System', 'body' => 'Dear sir/madam,', 'body1' => 'Your request for welfare titled <b>' . $welfaretitle->topic . '</b> has been rejected by Chairperson Mr.' . $userDetail->empName . '.', 'body2' => '', 'body3' => 'Reason:' . $request->remarks2 .'.', 'body4' => 'click here: http://hris.bpc.bt', 'body5' => 'Your patience is your power. Smile','body6' => '', ];
                                                  
                  $userEmail = DB::table('welfarenote')
                  ->where('id',$id->id)
                  ->first();                       
            
                    Mail::to($userEmail->emailId)                       
                    ->send(new MyTestMail($rejectWelfare));
                      
                return redirect('home')
                    ->with('error','You have rejected the Welfare Request!');    
            }}
   
    else{

          return redirect('home')
              ->with('error','You cannot leave the remarks field empty test!!');  
      }           
   
     }
  
  }