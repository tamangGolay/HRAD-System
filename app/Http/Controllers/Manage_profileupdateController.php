<?php
         
namespace App\Http\Controllers;
          
use App\EmployeeMaster;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class Manage_profileupdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)  //pull the data in the front
    {

        $grade = DB::table('employeemaster')

           ->join('bankmaster', 'bankmaster.id', '=', 'employeemaster.bankName')
         //->join('employeemaster', 'employeemaster.designation', '=', 'designationmaster.id')
        ->select('employeemaster.id','employeemaster.empId','employeemaster.cidNo',
        'employeemaster.dob','employeemaster.bloodGroup','employeemaster.empName',
        'employeemaster.gender', 'employeemaster.appointmentDate','employeemaster.grade',
        'employeemaster.designation','employeemaster.basicPay','employeemaster.empStatus','employeemaster.mobileNo',
        'employeemaster.emailId','employeemaster.placeId','employeemaster.bankName','employeemaster.accountNumber',
        'employeemaster.resignationType','employeemaster.resignationDate','employeemaster.employmentType','employeemaster.incrementCycle',
        'bankmaster.bankName'
        )
      ->where('employeemaster.status','0');
  
      	
  
      
      
      
      	
      	
      
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


        //  dd($request);
        EmployeeMaster::updateOrCreate(['empId' => $request->emp_id],  ['empName' => $request->name,  'mobileNo' => $request->contact_number,
        'office' => $request->division, 'dob' => $request->dob, 'cidNo' => $request->cid,  'bloodGroup' => $request->blood,
         'designation' => $request->designationId, 'grade' => $request->gradeId ,'empStatus' => $request->empstatus, 'appointmentDate' => $request->appointment,
          'basicPay' => $request->basicpay,'lastDop' => $request->lastdop, 'emailId' => $request->emailid, 'place' => $request->placeId,
        'bankName' => $request->bankname, 'accountNumber' => $request->accountnumber, 'resignationType' => $request->resignationtypeId ,
        'resignationDate' => $request->resignationdate, 'employmentType' => $request->employmenttype, 'incrementCycle' => $request->incrementcycle
    ]);        
 


    // $employee = new EmployeeMaster;
    //                 $employee->empId = $request->emp_id;
    //                 $employee->empName = $request->name;
    //                 $employee->bloodGroup = $request->blood;

    //                 $employee->cidNo = $request->cid;

    //                 $employee->save();

        // return response()->json(['success'=>'User details saved successfully.']);
        return redirect('home')->with('page', 'user_profile');

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