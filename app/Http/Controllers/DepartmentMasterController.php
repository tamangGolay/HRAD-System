<?php
         
namespace App\Http\Controllers;
          
use App\Vehicles;
use App\Department;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class DepartmentMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $b = DB::table('departmentmaster')
        ->join('users', 'users.id', '=', 'departmentmaster.deptHead')
       ->join('servicemaster', 'servicemaster.id', '=', 'departmentmaster.deptReportsToService')
       ->join('companymaster', 'companymaster.id', '=', 'departmentmaster.deptReportsToCompany')

    //    ->select('dzongkhags.Dzongkhag_Name','officemaster.id','officename.longOfficeName','placemaster.dzongkhagId','officemaster.officeHead')
       // ->select('officemaster.id','placemaster.placeName','officemaster.officeAddress','officemaster.officeHead')
       ->select('deptNameShort','deptNameLong','users.empId','servicemaster.serNameLong','companymaster.comNameLong','departmentmaster.id','departmentmaster.deptHead','departmentmaster.deptReportsToService','departmentmaster.deptReportsToCompany')

        ->where('departmentmaster.status','0');
        
        if ($request->ajax()) {
            $data = $b;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteDepartment" data-original-title="Delete" class="btn btn-primary btn-sm deleteDepartment">Delete</a>';    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.departmentMaster',compact('b'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
     {
// dd($request);
       
        Department::updateOrCreate(['id' => $request->id],
        ['deptNameShort' => $request->deptNameShort, 'deptNameLong' => $request->deptNameLong, 
        'deptHead' => $request->deptHead, 'deptReportsToService' => $request->deptReportsToService,
         'deptReportsToCompany' => $request->deptReportsToCompany]);    
        

   
        return response()->json(['success'=>'Saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $a = Department::find($id);
        return response()->json($a);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $query = DB::table('departmentmaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}