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


        //  dd($request);
        EmployeeMaster::updateOrCreate(['empId' => $request->emp_id],  ['empName' => $request->name, 
         'mobileNo' => $request->contact_number,
        'division' => $request->office,
         'dob' => $request->dob,
          'cidNo' => $request->cid, 
         'designation' => $request->designationId,
          'gradeId' => $request->gradeId ,
          'empStatus' => $request->empstatus, 
         'appointmentDate' => $request->appointment,
          'basicPay' => $request->basicpay,
          'lastDop' => $request->lastdop, 
          'emailId' => $request->emailid, 
        'office' =>$request->office, 
        'fixedNo' => $request->fixed,
        'extension' => $request->extension,
         'employmentType' => $request->employmenttype,
          'incrementCycle' => $request->incrementcycle
    ]);        
 

//'placeId' => $request->placeId,'resignationDate' => $request->resignationdate, 'resignationType' => $request->resignationtypeId ,
   //'bankName' => $request->bankname, 'accountNumber' => $request->accountnumber, 'bloodGroup' => $request->blood,
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


    // added this to update emial and phone number in user profile.
    public function updateContact(Request $request)
{
    $request->validate([
        'contact_number' => 'nullable',
        'emailid'        => 'nullable|email',
    ]);

    $empId = auth()->user()->empId;

    $data = [];

    if ($request->filled('contact_number')) {
        $data['mobileNo'] = $request->contact_number;
    }

    if ($request->filled('emailid')) {
        $data['emailId'] = $request->emailid;
    }

    // If nothing was changed
    if (empty($data)) {
        return back()->with('message', 'No changes detected.');
    }

    EmployeeMaster::where('empId', $empId)->update($data);

     
    return redirect('home')
        ->with('page', 'user_profile')
        ->with('success', 'Details updated successfully.!');
}


}