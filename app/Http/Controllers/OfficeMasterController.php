<?php
         
namespace App\Http\Controllers;
          
use App\Vehicles;
use App\Officem;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class OfficeMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
 
        $b = DB::table('officemaster')
        ->join('officename', 'officename.id', '=', 'officemaster.officeName')
       ->join('placemaster', 'placemaster.id', '=', 'officemaster.officeAddress')
        ->select('officemaster.id','officename.longOfficeName','placemaster.placeName','officemaster.officeHead')
       // ->select('officemaster.id','placemaster.placeName','officemaster.officeAddress','officemaster.officeHead')
        ->where('officemaster.status','0');


        if ($request->ajax()) {
            $data = $b;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteOffice" data-original-title="Delete" class="btn btn-primary btn-sm deleteOffice">Delete</a>';    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.officeMaster',compact('b'));
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
       
        Officem::updateOrCreate(['id' => $request->id],
        ['officeName' => $request->officeName, 'officeAddress' => $request->officeAddress, 'officeHead' => $request->officeHead]);    
        

   
        return response()->json(['success'=>'New office saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $a = Officem::find($id);
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
        $query = DB::table('officemaster')->where('id', $request->id)
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