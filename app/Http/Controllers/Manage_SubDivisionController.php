<?php
         
namespace App\Http\Controllers;
use App\Vehicles;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\SubDivisionMaster;


        
class Manage_SubDivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function index(Request $request)
    {
         
    
        $subdivision = DB::table('subdivisionmaster')
        ->join('divisionmaster', 'divisionmaster.id', '=', 'subdivisionmaster.subDivreportsTodivision')
        ->join('employeemaster', 'employeemaster.id', '=', 'subdivisionmaster.subDivhead')

        ->select('subdivisionmaster.id','subDivnameShort','subDivnameLong','employeemaster.empName','divisionmaster.divNameLong','subDivreportsTodepartment','subDivreportsToservice','subDivreportsTocompany','subDivreportsToEmp')
        
        ->where('subdivisionmaster.status','0');

        
        if ($request->ajax()) {
            $data = $subdivision;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteSubDivision" data-original-title="Delete" class="btn btn-outline-danger btn-sm deleteSubDivision">Delete</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.subDivisionMaster',compact('subdivision'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     SubDivisionMaster::updateOrCreate(['id' => $request->id],  //vehicles
        ['subDivnameShort' => $request->subDivnameShort, 'subDivnameLong' => $request->subDivnameLong, 'subDivhead' => $request->subDivhead,'subDivreportsTodivision' => $request->subDivreportsTodivision, 'subDivreportsTodepartment' => $request->subDivreportsTodepartment, 'subDivreportsToservice' => $request->subDivreportsToservice, 'subDivreportsTocompany' => $request->subDivreportsTocompany,'subDivreportsToEmp' => $request->subDivreportsToEmp] );  
   
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

        $conference = SubDivisionMaster::find($id);
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
        $query = DB::table('subdivisionmaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Sub Division deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}