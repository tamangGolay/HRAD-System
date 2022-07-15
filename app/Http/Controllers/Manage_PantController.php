<?php
         
namespace App\Http\Controllers;
          
use App\Pant;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class Manage_PantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        $pant = DB::table('pantmaster')->where('pantmaster.status','0');
        
        if ($request->ajax()) {
            $data = $pant;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editpant">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deletePant" data-original-title="Delete" class="btn btn-primary btn-sm deletePant">Delete</a>';

   
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('uniform.pant',compact('pant'));
    }

   
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Pant::updateOrCreate(['id' => $request->id],
                ['pantSizeName' => $request->pantSizeName,'gender' => $request->gender]);        
   
        return response()->json(['success'=>'PantSize Name saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $pd = Pant::find($id);
        return response()->json($pd);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $query = DB::table('pantmaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'PantSize Name deleted successfully.']);
    }

    //To redirect to the page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}