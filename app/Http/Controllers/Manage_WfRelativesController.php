<?php
         
namespace App\Http\Controllers;
          
use App\Vehicles;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\WfRelatives;
use App\User;
use App\ViewWfRelatives;

        
class Manage_WfRelativesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $wfRelatives = DB::table('wfrelatives')
      ->join('users', 'users.empId', '=', 'wfrelatives.empId')
      ->join('relationmaster', 'relationmaster.id', '=', 'wfrelatives.relation')
      ->select('wfrelatives.id','wfrelatives.cIdNo','wfrelatives.cIDOther','wfrelatives.name','wfrelatives.doB','users.empId','relationshipName')
      ->where('wfrelatives.status','0');

    
        
        if ($request->ajax()) {
            $data = $wfRelatives;

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteFamily" data-original-title="Delete" class="btn btn-outline-danger btn-sm deleteFamily">Delete</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('welfare.family_details',compact('wfRelatives'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        WfRelatives::updateOrCreate(['id' => $request->id],  //contract detail
                ['empId' => $request->empId, 'name' => $request->name, 'cIdNo' => $request->cIdNo,'cIDOther' => $request->cIDOther,'doB' => $request->doB,'relation' => $request->relation]);        
   
            
        return response()->json(['success'=>'New Family Details saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $conference = WfRelatives::find($id);
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
        $query = DB::table('wfrelatives')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Family details deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}