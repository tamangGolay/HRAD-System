<?php
         
namespace App\Http\Controllers;
          
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\EmployeeQualification; 

        
class EmpQualificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

          //$empquali = DB::table('employeequalificationmaster')->where('status','0');
          
         $empquali = DB::table('employeequalificationmaster')
          ->join('employeemaster', 'employeemaster.id', '=', 'employeequalificationmaster.personalNo')
          ->join('qualificationmaster','qualificationmaster.id','=','employeequalificationmaster.qualificationId') 

          ->select('employeequalificationmaster.id','employeemaster.empId','qualificationmaster.qualificationName','yearCompleted')
          ->where('employeequalificationmaster.status','0');  

         if ($request->ajax()) {
            $data = $empquali;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
     $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
     $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteEmpQualification" data-original-title="Delete" class="btn btn-primary btn-sm deleteEmpQualification">Delete</a>';

    
         return $btn;
              })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.employeeQualification',compact('empquali'));
    }     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {          
        EmployeeQualification::updateOrCreate(['id' => $request->id], 
                ['personalNo' => $request->personalNo, 
                'qualificationId' => $request->qualificationId,'yearCompleted' => $request->yearCompleted,]);        
   
        return response()->json(['success'=>'New qualification saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {           
        
        $empquali = EmployeeQualification::find($id);
        return response()->json($empquali);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $query = DB::table('employeequalificationmaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Employee Qualification deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}