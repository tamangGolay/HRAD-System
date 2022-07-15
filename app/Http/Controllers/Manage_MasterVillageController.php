<?php
         
namespace App\Http\Controllers;
          
use App\village;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class Manage_MasterVillageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

       
        $village = DB::table('villagemaster')
        ->join('gewogmaster', 'gewogmaster.id', '=', 'villagemaster.gewogId')
        ->select('villagemaster.id','villagemaster.villageName','gewogmaster.gewogName')
        ->where('villagemaster.status','0');
        
        if ($request->ajax()) {
            $data = $village;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm editvillage">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteofficeName" data-original-title="Delete" class="btn btn-outline-danger btn-sm deletevillage">Delete</a>';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.village',compact('village'));
    }

   
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        village::updateOrCreate(['id' => $request->id],
                ['villageName' => $request->villageName, 
                
                'gewogId' => $request->gewogId]);        
   
        return response()->json(['success'=>'village saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $village = village::find($id);
        return response()->json($village);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $query = DB::table('villagemaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'village deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'manage_vehicle');
    }

}