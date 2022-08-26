<?php
         
namespace App\Http\Controllers;
          
use App\jobDescription;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use  App\User;
        
class Manage_jobDescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)  //pull the data in the front
    {

       
        $grade = DB::table('users')

           ->join('bankmaster', 'bankmaster.id', '=', 'users.bankName')
         //->join('users', 'users.designation', '=', 'designationmaster.id')
        ->select('users.id','users.empId','users.cidNo',
        'users.dob','users.bloodGroup','users.empName',
        'users.gender', 'users.appointmentDate','users.grade',
        'users.designation','users.basicPay','users.empStatus','users.mobileNo',
        'users.emailId','users.placeId','users.bankName','users.accountNumber',
        'users.resignationType','users.resignationDate','users.employmentType','users.incrementCycle',
        'bankmaster.bankName'
        )
      ->where('users.status','0');
  
      	
  
      
      
      
      	
      	
      
        if ($request->ajax()) {
            $data = $increment;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteIncrement" data-original-title="Delete" class="btn btn-primary btn-sm deleteIncrement">Delete</a>';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('emp.increment_history',compact('increment'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
   {
    $createdBy= Auth::user()->empId;

        
       jobDescription::updateOrCreate(['empId' => $request->emp_id],  [
               'jobDescription' => $request->jobdescription, 'createdOn' => $request->createdDate,
               'createdBy' => $createdBy, 'officeId' => $request->officeId,
               'empName' => $request->nameid,
    ]);        
 
        return redirect('home')->with('page', 'jobDescription');

    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     
        $conference = increment::find($id);
        return response()->json($conference);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {

      
        $query = DB::table('incrementhistorymaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Increment data deleted successfully.']);
    }

    //To redirect to the manage_increment page after the management of increment
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'increment_history');
    }

}