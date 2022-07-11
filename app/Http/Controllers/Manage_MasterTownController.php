<?php
         
namespace App\Http\Controllers;
          
use App\town;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class Manage_MasterTownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

       
        $town = DB::table('townmaster')
        ->join('dzongkhags', 'dzongkhags.id', '=', 'townmaster.dzongkhagId')
        ->select('townmaster.townClass','townmaster.id','townmaster.townName','dzongkhags.Dzongkhag_Name')
        ->where('townmaster.status','0');
        
        if ($request->ajax()) {
            $data = $town;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edittown">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteofficeName" data-original-title="Delete" class="btn btn-primary btn-sm deletetown">Delete</a>';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.town',compact('town'));
    }

   
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        town::updateOrCreate(['id' => $request->id],
                ['townName' => $request->townName, 
                'townClass' => $request->townClass,
                'dzongkhagId' => $request->dzongkhagId]);        
   
        return response()->json(['success'=>'town saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $town = town::find($id);
        return response()->json($town);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $query = DB::table('townmaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'town deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'manage_vehicle');
    }

}