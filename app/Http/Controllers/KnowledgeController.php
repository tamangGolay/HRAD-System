<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\knowledgeRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use App\knowledgeapprove;
use DB;
use Auth;

class KnowledgeController extends Controller
{


    public function index(Request $request)
    {

        $userList = DB::table('knowledgerepository')
        ->join('users', 'users.empId', '=', 'knowledgerepository.createdBy')
        ->join('officedetails', 'officedetails.id', '=', 'knowledgerepository.officeId')
     //    ->join('officemaster','officemaster.id','=','users.office')

     ->select('users.empName','knowledgerepository.*','officedetails.shortOfficeName','officedetails.Address'
        )

        ->latest('users.id') //similar to orderby('id','desc')
        ->where('users.office',Auth::user()->office)
   
         ->paginate(10000000);
        
        if ($request->ajax()) {
            $data = $userList;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="delete" data-original-title="Delete" class="btn btn-primary btn-sm delete">Delete</a>';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('knowledge.knowledgeReview',compact('userList'));
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
            $requestKnowledge->officeId = $request->office;
            $requestKnowledge->save();  

           
    
           
        return redirect('home')
        ->with('success', 'knowledge submitted successfully');

 }


 public function store(Request $request)
 {

    // dd($request->all());
        $approvedBy= Auth::user()->empId;
        $status = 1;
        $date  = $request->approvedOn;


             DB::update('update knowledgerepository set problem = ? where id = ?', [$request->problem,$request->id]);
             DB::update('update knowledgerepository set solution = ? where id = ?', [$request->solution,$request->id]);
             DB::update('update knowledgerepository set status = ? where id = ?', [$status,$request->id]);
             DB::update('update knowledgerepository set approvedOn = ? where id = ?', [$date,$request->id]);
             DB::update('update knowledgerepository set approvedBy = ? where id = ?', [$approvedBy,$request->id]);




              
         return response()->json(['success'=>'Updated successfully.']);
 }


 public function edit($id)
 {

    // dd($id);

     $KnowledgeRequest = KnowledgeRequest::find($id);
     return response()->json($KnowledgeRequest);
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
