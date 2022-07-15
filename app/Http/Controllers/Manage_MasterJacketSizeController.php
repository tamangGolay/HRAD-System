<?php
         
namespace App\Http\Controllers;
          
use App\JacketSize;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class Manage_MasterJacketSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

       
        $bank = DB::table('jacketmaster')->where('jacketmaster.status','0');
        
        if ($request->ajax()) {
            $data = $bank;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm editjacket">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteJacket" data-original-title="Delete" class="btn btn-outline-danger btn-sm deleteJacket">Delete</a>';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('uniform.jacketmaster',compact('bank'));
    }

   
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        JacketSize::updateOrCreate(['id' => $request->id],
                ['sizeName' => $request->sizeName,'usUkSize'=>$request->usUkSize,'euSize'=>$request->euSize,'gender'=>$request->gender]);        
   
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

        $bank = JacketSize::find($id);
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
        $query = DB::table('jacketmaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Jacket size name deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}