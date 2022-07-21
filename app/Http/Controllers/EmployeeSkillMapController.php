<?php
         
namespace App\Http\Controllers;
          
use App\Vehicles;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\EmployeeSkillMap;

        
class EmployeeSkillMapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $empskills = DB::table('employeeskillmap')
        ->join('users', 'users.id', '=', 'employeeskillmap.pNo')
        ->join('skillmaster', 'skillmaster.id', '=', 'employeeskillmap.skillId')
        ->select('employeeskillmap.id','users.empId','skillmaster.skillName','obtainedOn','expiryDate')

        ->where('employeeskillmap.status','0');
        
        if ($request->ajax()) {
            $data = $empskills;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="editSkillCategory btn btn-outline-info btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteSkillCategory" data-original-title="Delete" class="btn btn-outline-danger btn-sm deleteSkillCategory">Delete</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.employeeSkillMap',compact('empskills'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        EmployeeSkillMap::updateOrCreate(['id' => $request->id],  //vehicles
                ['pNo' => $request->pNo,'skillId' => $request->skillId,'obtainedOn' => $request->obtainedOn,'expiryDate' => $request->expiryDate]);        
   
        return response()->json(['success'=>'Employee Skills added successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $conference = EmployeeSkillMap::find($id);
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
        
        $query = DB::table('employeeskillmap')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Employee Skill deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}