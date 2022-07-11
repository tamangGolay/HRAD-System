<?php
         
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;
use App\Unit;

        
class ManageUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $a = DB::table('unitmaster')
            ->select('id','unitNameShort','unitNameLong','unitHead')
            ->where('status','0');
        
        if ($request->ajax()) {
            $data = $a;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteUnit" data-original-title="Delete" class="btn btn-primary btn-sm deleteUnit">Delete</a>';
                             return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.unit',compact('a'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         Unit::updateOrCreate(['id' => $request->id],  //Unit is modal name
                ['unitNameShort' => $request->unitNameShort, 'unitNameLong' => $request->unitNameLong, 'unitHead' => $request->unitHead,]);  
   
        return response()->json(['success'=>'New Unit saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $u = Unit::find($id);
        return response()->json($u);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $query = DB::table('unitmaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Unit deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}