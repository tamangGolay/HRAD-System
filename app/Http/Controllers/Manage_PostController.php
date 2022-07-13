<?php
         
namespace App\Http\Controllers;
          
use App\Vehicles;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\PostMaster;

        
class Manage_PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $postm = DB::table('postmaster')
        ->select('id','shortName','longName','positionSpecificAllowance','contractAllowance','communicationAllowance','type')
        ->where('status','0');
       
        if ($request->ajax()) {

            $data = $postm;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteGrade" data-original-title="Delete" class="btn btn-primary btn-sm deleteGrade">Delete</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.Master',compact('postm'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        PostMaster::updateOrCreate(['id' => $request->id],  //vehicles
                ['shortName' => $request->shortName, 'longName' => $request->longName,'positionSpecificAllowance' => $request->positionSpecificAllowance,'contractAllowance' => $request->contractAllowance,'communicationAllowance' => $request->communicationAllowance,'type' => $request->type]);        
   
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

        $conference = PostMaster::find($id);
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
        $query = DB::table('postmaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'post master deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}