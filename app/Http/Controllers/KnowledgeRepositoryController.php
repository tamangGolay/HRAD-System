<?php
         
namespace App\Http\Controllers;
          
use App\KnowledgeRequest;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;

class KnowledgeRepositoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

       
        $userList = DB::table('knowledgerepository')
        // ->join('users', 'users.empId', '=', 'knowledgerepository.createdBy')
        ->join('officedetails', 'officedetails.id', '=', 'knowledgerepository.officeId')
     //    ->join('officemaster','officemaster.id','=','users.office')

     ->select('knowledgerepository.empName','knowledgerepository.*','officedetails.officeDetails')

       
        ->where('knowledgerepository.status','1');
        
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
      
        return view('knowledge.knowledgeReview',compact('userList'));
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

        $KnowledgeRequest = KnowledgeRequest::find($id);
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