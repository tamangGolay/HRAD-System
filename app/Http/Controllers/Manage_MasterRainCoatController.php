<?php
         
namespace App\Http\Controllers;
          
use App\RainCoatSize;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class Manage_MasterRainCoatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

       
        $bank = DB::table('raincoatsize')
        ->where('raincoatsize.status','0');
        

       


        if ($request->ajax()) {
            $data = $bank;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm editraincoat">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteraincoat" data-original-title="Delete" class="btn btn-outline-danger btn-sm deleteraincoat">Delete</a>';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('uniform.rainCoatSize',compact('bank'));
    }

   
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        RainCoatSize::updateOrCreate(['id' => $request->id],
                ['sizeName' => $request->sizeName,'shouldersCm'=>$request->shouldersCm,'chestCm'=>$request->chestCm,'waistCm'=>$request->waistCm,'bottomCm'=>$request->bottomCm,'lengthCm'=>$request->lengthCm,'sleeveCm'=>$request->sleeveCm]);        
   
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

        $bank = RainCoatSize::find($id);
        return response()->json($bank);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $query = DB::table('raincoatsize')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Rain Coat size name deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}