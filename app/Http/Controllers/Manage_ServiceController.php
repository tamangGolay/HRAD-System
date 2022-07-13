<?php
         
namespace App\Http\Controllers;
use App\Vehicles;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\ServiceMaster;
use App\Company;

        
class Manage_ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $service = DB::table('servicemaster')
        
        ->join('employeemaster', 'employeemaster.id', '=', 'servicemaster.serviceHead')
        ->join('companymaster', 'companymaster.id', '=', 'servicemaster.company')
        ->select('servicemaster.id','serNameShort','serNameLong','employeemaster.empId','companymaster.comNameLong')
        ->where('servicemaster.status','0');
        
        
        if ($request->ajax()) {
            $data = $service;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteService" data-original-title="Delete" class="btn btn-primary btn-sm deleteService">Delete</a>';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.serviceMaster',compact('service'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         ServiceMaster::updateOrCreate(['id' => $request->id],  //vehicles
                ['serNameShort' => $request->serNameShort, 'serNameLong' => $request->serNameLong, 'serviceHead' => $request->serviceHead,'company' => $request->company]);   
   
        return response()->json(['success'=>'New Service saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $conference = ServiceMaster::find($id);
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
        $query = DB::table('servicemaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Service deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}