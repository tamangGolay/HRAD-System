<?php
         
namespace App\Http\Controllers;
          
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\Qualification; 

        
class MasterQualiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $quali = DB::table('qualificationmaster')->where('status','0');
        
        if ($request->ajax()) {
            $data = $quali;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
     $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
     $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteQualification" data-original-title="Delete" class="btn btn-primary btn-sm deleteQualification">Delete</a>';

    
         return $btn;
              })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.qualificationLevel',compact('quali'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  dd($request);
        Qualification::updateOrCreate(['id' => $request->id], 
                ['qualificationLevelId' => $request->qualificationLevelId,
                'qualificationShortName' => $request->qualificationShortName,
                'qualificationLongName' => $request->qualificationLongName]);        
   
        return response()->json(['success'=>'New qualification saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $conference = Qualification::find($id);
        return response()->json($conference);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $query = DB::table('qualificationmaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Qualification deleted successfully.']);
    }

    //To redirect to the manage_quali page after the management of quali
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'qualificationLevel');
    }

}