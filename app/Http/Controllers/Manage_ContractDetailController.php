<?php
         
namespace App\Http\Controllers;
          
use App\Vehicles;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\ContractDetailMaster;

        
class Manage_ContractDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $contractdetail = DB::table('contractdetailsmaster')
        ->join('employeemaster', 'employeemaster.id', '=', 'contractdetailsmaster.personalNo')
        ->select('contractdetailsmaster.id','employeemaster.empId','startDate','endDate','termNo')
        ->where('contractdetailsmaster.status','0');



        // $gewog = DB::table('gewogmaster')
        // ->join('dzongkhags', 'dzongkhags.id', '=', 'gewogmaster.dzongkhagId')
        // ->select('gewogmaster.id','gewogmaster.gewogName','dzongkhags.Dzongkhag_Name');

        
        if ($request->ajax()) {
            $data = $contractdetail;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteContractdetail" data-original-title="Delete" class="btn btn-primary btn-sm deleteContractdetail">Delete</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.contractDetailMaster',compact('contractdetail'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ContractDetailMaster::updateOrCreate(['id' => $request->id],  //contract detail
                ['personalNo' => $request->personalNo, 'startDate' => $request->startDate, 'endDate' => $request->endDate,'termNo' => $request->termNo]);        
   
        return response()->json(['success'=>'New Contract Details saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $conference = ContractDetailMaster::find($id);
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
        $query = DB::table('contractdetailsmaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'contract detail deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}