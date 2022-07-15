<?php
         
namespace App\Http\Controllers;
          
use App\Shirt;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class Manage_ShirtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        $shirt = DB::table('shirtmaster')->where('shirtmaster.status','0');
        
        if ($request->ajax()) {
            $data = $shirt;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm editshirt">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteShirt" data-original-title="Delete" class="btn btn-outline-danger btn-sm deleteShirt">Delete</a>';

   
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('uniform.shirt',compact('shirt'));
    }

   
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Shirt::updateOrCreate(['id' => $request->id],
                ['shirtSizeName' => $request->shirtSizeName,'gender' => $request->gender]);        
   
        return response()->json(['success'=>'Shirt Size Name saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $shirt = Shirt::find($id);
        return response()->json($shirt);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $query = DB::table('shirtmaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Shirt Size Name deleted successfully.']);
    }

    //To redirect to the page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}