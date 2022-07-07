<?php
         
namespace App\Http\Controllers;
          

use Illuminate\Http\Request;
use DataTables;
use DB;
use App\QualificationLevel; 

        
class QualilevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $vehicle = DB::table('qualilevelmaster')->where('status','0');
        
        if ($request->ajax()) {
            $data = $vehicle;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
     $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
     $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteQualilevel" data-original-title="Delete" class="btn btn-primary btn-sm deleteQualilevel">Delete</a>';

    
         return $btn;
              })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.qualificationLevelType',compact('vehicle'));
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
        QualificationLevel::updateOrCreate(['id' => $request->id], 
                ['qualiLevelName' => $request->qualiLevelName]);        
   
        return response()->json(['success'=>'New qualificationLevel saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $conference = QualificationLevel::find($id);
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
        $query = DB::table('qualilevelmaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Qualification deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}