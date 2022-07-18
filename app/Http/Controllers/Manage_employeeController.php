<?php
         
namespace App\Http\Controllers;
          
use App\employeeR;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class Manage_employeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)  //pull the data in the front
    {

        $employee = DB::table('empreportingstructuremaster')
        ->join('users', 'users.id', '=', 'empreportingstructuremaster.personalNo')
        ->select('empreportingstructuremaster.id','empreportingstructuremaster.reportsToOffice',
        'empreportingstructuremaster.reportsToEmployee','empreportingstructuremaster.fromDate',
        'empreportingstructuremaster.endDate','users.empId')
      ->where('empreportingstructuremaster.status','0');
  
        
        if ($request->ajax()) {
            $data = $employee;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteEmployee" data-original-title="Delete" class="btn btn-primary btn-sm deleteEmployee">Delete</a>';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('emp.employee_reporting',compact('employee'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->id);
        employeeR::updateOrCreate(['personalNo' => $request->name],  ['reportsToOffice' => $request->number,  'reportsToEmployee' => $request->employee,
        'fromDate' => $request->start, 'endDate' => $request->end

    ]);        
   
        return response()->json(['success'=>'Employee Reporting details saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     
        $conference = employeeR::find($id);
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

      
        $query = DB::table('empreportingstructuremaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Employee reporting data deleted successfully.']);
    }

    //To redirect to the manage_employee page after the management of employee
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'employee_reporting');
    }

}