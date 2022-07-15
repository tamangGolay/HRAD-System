<?php
         
namespace App\Http\Controllers;
          
use App\gewog;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class Manage_MasterGewogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

       
        $gewog = DB::table('gewogmaster')
        ->join('dzongkhags', 'dzongkhags.id', '=', 'gewogmaster.dzongkhagId')
        ->join('drungkhagmaster', 'drungkhagmaster.id', '=', 'gewogmaster.drungkhagId')
         ->select('gewogmaster.id','gewogmaster.gewogName','dzongkhags.Dzongkhag_Name',
         'drungkhagmaster.drungkhagName'
         )
        ->where('gewogmaster.status','0');
        
        if ($request->ajax()) {
            $data = $gewog;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm editgewog">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteofficeName" data-original-title="Delete" class="btn btn-outline-danger btn-sm deletegewog">Delete</a>';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.gewog',compact('gewog'));
    }

   
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        gewog::updateOrCreate(['id' => $request->id],
                ['gewogName' => $request->gewogName,
                'drungkhagId' => $request->drungkhagId,
                'dzongkhagId' => $request->dzongkhagId]);        
   
        return response()->json(['success'=>'Gewog saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $gewog = gewog::find($id);
        return response()->json($gewog);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $query = DB::table('gewogmaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Gewog deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'manage_vehicle');
    }

}