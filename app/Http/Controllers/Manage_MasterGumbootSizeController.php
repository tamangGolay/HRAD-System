<?php
         
namespace App\Http\Controllers;
          
use App\GumbootSize;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class Manage_MasterGumbootSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

       
        $bank = DB::table('gumboot')->where('gumboot.status','0');
        
        if ($request->ajax()) {
            $data = $bank;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm editgumboot">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deletegumboot" data-original-title="Delete" class="btn btn-outline-danger btn-sm deletegumboot">Delete</a>';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('uniform.gumbootSize',compact('bank'));
    }

   
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
       // protected $fillable = ['id','eUSize','uSSize','uKSize','innerSLengthCm','bootLengthCm','innerSWidthCm','bootWidthCm','bootOpeningCm','status'];

    public function store(Request $request)
    {
        GumbootSize::updateOrCreate(['id' => $request->id],
                ['eUSize' => $request->eUSize,'uSSize'=>$request->uSSize,'uKSize'=>$request->uKSize,'innerSLengthCm'=>$request->innerSLengthCm,'bootLengthCm'=>$request->bootLengthCm, 'innerSWidthCm'=>$request->innerSWidthCm,'bootWidthCm'=>$request->bootWidthCm,'bootOpeningCm'=>$request->bootOpeningCm]);        
   
        return response()->json(['success'=>'bank saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $gboot = GumbootSize::find($id);
        return response()->json($gboot);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $query = DB::table('gumboot')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Gumboot Size deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}