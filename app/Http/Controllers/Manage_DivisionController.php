<?php
         
namespace App\Http\Controllers;
use App\Vehicles;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\DivisionMaster;

        
class Manage_DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $a = DB::table('divisionmaster')
        
        ->join('employeemaster', 'employeemaster.id', '=', 'divisionmaster.divHead')
        ->join('dzongkhags','dzongkhags.id','=','divisionmaster.divDzoId')
        ->join('dzongkhags as a','a.id','=','divisionmaster.deptDzoId')
        ->join('dzongkhags as b','b.id','=','divisionmaster.serviceDzoId')

        ->select('divisionmaster.id','divNameShort','divNameLong','dzongkhags.Dzongkhag_Name','employeemaster.empId','divReportsToDepartment','a.Dzongkhag_Name as C','divReportsToService','b.Dzongkhag_Name as D','divReportsToCompany')
        ->where('divisionmaster.status','0');
              
        if ($request->ajax()) {
            $data = $a;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteDivision" data-original-title="Delete" class="btn btn-primary btn-sm deleteDivision">Delete</a>';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.divisionMaster',compact('a'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         DivisionMaster::updateOrCreate(['id' => $request->id],  //vehicles
                ['divNameShort' => $request->divNameShort, 'divNameLong' => $request->divNameLong, 'divDzoId' => $request->divDzoId,'divHead' => $request->divHead, 
                'divReportsToDepartment' => $request->divReportsToDepartment,'deptDzoId' => $request->deptDzoId,'divReportsToService' => $request->divReportsToService,
                'serviceDzoId' => $request->serviceDzoId,'divReportsToCompany' => $request->divReportsToCompany]);  
   
        return response()->json(['success'=>'New vehicle saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $conference = DivisionMaster::find($id);
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
        $query = DB::table('divisionmaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Division deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}