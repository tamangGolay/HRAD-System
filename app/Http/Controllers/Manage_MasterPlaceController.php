<?php
         
namespace App\Http\Controllers;
          
use App\place;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class Manage_MasterPlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $place = DB::table('placemaster')
        ->join('dzongkhags', 'dzongkhags.id', '=', 'placemaster.dzongkhagId')
        ->join('gewogmaster', 'gewogmaster.id', '=', 'placemaster.gewogId')
        ->join('villagemaster', 'villagemaster.id', '=', 'placemaster.villageId')
        ->join('townmaster', 'townmaster.id', '=', 'placemaster.townId')
        ->join('drungkhagmaster', 'drungkhagmaster.id', '=', 'placemaster.drungkhagId')

        // ->select('townmaster.townName','placemaster.placeCategory','placemaster.id','villagemaster.villageName',
        //  'drungkhagmaster.drungkhagName','gewogmaster.gewogName','dzongkhags.Dzongkhag_Name')
       
        ->select('placemaster.placeCategory','drungkhagmaster.drungkhagName','townmaster.townName','placemaster.id','villagemaster.villageName','dzongkhags.Dzongkhag_Name',
        'gewogmaster.gewogName')
        ->where('placemaster.status','0');
        
        
        if ($request->ajax()) {
            $data = $place;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editplace">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteofficeName" data-original-title="Delete" class="btn btn-primary btn-sm deleteplace">Delete</a>';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.place',compact('place'));
    }

   
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        place::updateOrCreate(['id' => $request->id],
                ['villageId' => $request->villageId,
                'townId' => $request->townId,
                'dzongkhagId' => $request->dzongkhagId,
                'drungkhagId' => $request->drungkhagId,
                'gewogId' => $request->gewogId,
                'placeCategory' => $request->placeCategory]);        
   
        return response()->json(['success'=>'Place saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $place = place::find($id);
        return response()->json($place);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $query = DB::table('placemaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Place deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'manage_vehicle');
    }

}