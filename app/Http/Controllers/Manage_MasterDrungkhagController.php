<?php
         
namespace App\Http\Controllers;
          
use App\drungkhag;
use Illuminate\Http\Request;
use DataTables;
use DB;

        
class Manage_MasterDrungkhagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

       
        $drungkhag = DB::table('drungkhagmaster')
        ->join('dzongkhags', 'dzongkhags.id', '=', 'drungkhagmaster.id')
        ->select('drungkhagmaster.id','drungkhagmaster.drungkhagName','dzongkhags.Dzongkhag_Name')
        ->where('drungkhagmaster.status','0');
        
        if ($request->ajax()) {
            $data = $drungkhag;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editdrungkhag">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteofficeName" data-original-title="Delete" class="btn btn-primary btn-sm deletedrungkhag">Delete</a>';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.drungkhag',compact('drungkhag'));
    }

   
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        drungkhag::updateOrCreate(['id' => $request->id],
                ['drungkhagName' => $request->drungkhagName, 'dzongkhagId' => $request->dzongkhagId]);        
   
        return response()->json(['success'=>'drungkhag saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $drungkhag = drungkhag::find($id);
        return response()->json($drungkhag);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $query = DB::table('drungkhagmaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'drungkhag deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'manage_vehicle');
    }

}