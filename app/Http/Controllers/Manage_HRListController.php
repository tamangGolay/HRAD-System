<?php         
namespace App\Http\Controllers;          
use App\User;
use App\RoleUserMappings;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use App\Roles;
use App\pay;
use App\Officedetails;
use App\Designation;

class Manage_HRListController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
     public function index(Request $request)
     { 

 $roles = Roles::all();
 $officedetails = Officedetails::all();
 $designation = Designation::all()->where('status',0);
 $payscalemaster = pay::all()->where('status',0);

 $NEW = DB::table('users')
->join('roles', 'users.role_id', '=', 'roles.id')
->join('payscalemaster', 'payscalemaster.id', '=', 'users.gradeId')
 ->join('officedetails', 'officedetails.id', '=', 'users.office') 
 ->join('designationmaster', 'designationmaster.id', '=', 'users.designationId') 

->select('users.*','roles.name','desisNameLong','officedetails.shortOfficeName','officedetails.Address','officedetails.officeDetails','grade')

->where('users.status','0');
         
         if ($request->ajax()) {
             $data = $NEW;
             return Datatables::of($data)
                     ->addIndexColumn()
                     ->addColumn('action', function($row){
    
      $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm editHRUSER">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
      $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteNEW" data-original-title="Delete" class="btn btn-outline-danger btn-sm deleteNEW">Delete</a>';
 
     
          return $btn;
               })
                     ->rawColumns(['action'])
                     ->make(true);
         }
       
         return view('auth.userListHR1',compact('NEW','designation','officedetails','roles','payscalemaster'));
     }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


            User::updateOrCreate(['id' => $request->id],
                ['empName' => $request->empName,
                 'empId' => $request->empId,
                 'cidNo' => $request->cidNo,
                 'role_id' => $request->role,
                 'office' => $request->office,
                 'gradeId' => $request->gradeId,
                 'gender' => $request->gender, //null
                 'empStatus' => $request->empStatus,
                'designationId' => $request->designation,
                'incrementCycle' => $request->incrementCycle,
                'emailId' => $request->emailId,
                'dob' => $request->dob,
                'appointmentDate' => $request->appointmentDate,
                'lastDop' => $request->lastDop,
                'basicPay' => $request->basicPay,
                'mobileNo' => $request->mobileNo,
                'dob' => $request->dob,
                'created_by' => Auth::id()

                ]); 


                 RoleUserMappings::updateOrCreate(['user_id' => $request->id],
                 [
                 'role_id' => $request->role,
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
        $User = User::find($id);
        return response()->json($User);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {

        $query = DB::table('users')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'User deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'userList');
    }
    

}
