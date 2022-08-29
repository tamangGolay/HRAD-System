<?php
         
namespace App\Http\Controllers;
          
use App\jobDescription;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;

class JobRepositoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        
       
        $userList = DB::table('jobdescription')
                ->join('officedetails', 'officedetails.id', '=', 'jobdescription.officeId')
       ->select('jobdescription.*','officedetails.officeDetails','officedetails.Address')
        ->where('jobdescription.status','1')
        ->WhereNull('dateExpired');
        
        if ($request->ajax()) {
            $data = $userList;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-success btn-sm editknowledge">View</a>&nbsp;&nbsp;&nbsp;&nbsp';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('emp.jobDescriptionRepository',compact('userList'));
    }

   
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        town::updateOrCreate(['id' => $request->id],
                ['townName' => $request->townName, 
                'townClass' => $request->townClass,
                'dzongkhagId' => $request->dzongkhagId]);        
   
        return response()->json(['success'=>'town saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $KnowledgeRequest = jobDescription::find($id);
        return response()->json($KnowledgeRequest);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $query = DB::table('townmaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'town deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'manage_vehicle');
    }

}