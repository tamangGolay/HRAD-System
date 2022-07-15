<?php
         
namespace App\Http\Controllers;
          
use App\Field;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class Manage_FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

       
        $field = DB::table('fieldmaster')->where('fieldmaster.status','0');
        
        if ($request->ajax()) {
            $data = $field;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm editfield">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteField" data-original-title="Delete" class="btn btn-outline-danger btn-sm deleteField">Delete</a>';

   
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.field',compact('field'));
    }

   
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Field::updateOrCreate(['id' => $request->id],
                ['fieldName' => $request->fieldName]);        
   
        return response()->json(['success'=>'Field Name saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $fd = Field::find($id);
        return response()->json($fd);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $query = DB::table('fieldmaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Field Name deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}