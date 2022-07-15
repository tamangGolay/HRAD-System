<?php
         
namespace App\Http\Controllers;
use App\Vehicles;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\SubstationMaster;

        
class Manage_SubstationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $a = DB::table('substationmaster')
        ->select('id','ssNameShort','ssNameLong','ssHead','ssReportsToUnit','ssReportsToSubDivision','ssReportsToDivision','ssReportsToDepartment', 'ssReportsToService','ssReportsToCompany','ssReportsToEmp','status')
        ->where('status','0');
        
        if ($request->ajax()) {
            $data = $a;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteSubstation" data-original-title="Delete" class="btn btn-outline-danger btn-sm deleteSubstation">Delete</a>';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.substationMaster',compact('a'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {
         SubstationMaster::updateOrCreate(['id' => $request->id],  //vehicles
                ['ssNameShort' => $request->ssNameShort, 'ssNameLong' => $request->ssNameLong,'ssHead' => $request->ssHead,'ssReportsToUnit' => $request->ssReportsToUnit,'ssReportsToSubDivision' => $request->ssReportsToSubDivision,'ssReportsToDivision' => $request->ssReportsToDivision,'ssReportsToDepartment' => $request->ssReportsToDepartment,'ssReportsToService' => $request->ssReportsToService,'ssReportsToCompany' => $request->ssReportsToCompany,'ssReportsToEmp' => $request->ssReportsToEmp]);  
   
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

        $conference = SubstationMaster::find($id);
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
        $query = DB::table('substationmaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Substation deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}