<?php
         
namespace App\Http\Controllers;

use App\Skillmaster;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class SkillMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {      
        $b = DB::table('skillmaster')
        ->join('skillsubcategory', 'skillsubcategory.id', '=', 'skillmaster.subCatId')

       ->select('skillsubcategory.subCatName','skillmaster.id','skillmaster.skillName')

       ->where('skillmaster.status','0');
        
        if ($request->ajax()) {
            $data = $b;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteSkillmaster" data-original-title="Delete" class="btn btn-outline-danger btn-sm deleteSkillmaster">Delete</a>';    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.skillMaster',compact('b'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
     {
// dd($request);
       
        Skillmaster::updateOrCreate(['id' => $request->id],
        ['skillName' => $request->skillName, 'subCatId' => $request->subCatId]);    
        

   
        return response()->json(['success'=>'Saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $a = Skillmaster::find($id);
        return response()->json($a);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request) 
    {
        $query = DB::table('skillmaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}