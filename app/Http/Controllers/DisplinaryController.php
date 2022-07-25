<?php
         
namespace App\Http\Controllers;
          
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\DisplinaryHistory; 

        
class DisplinaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // $quali = DB::table('displinaryhistorymaster')->where('status','0');   
        $quali = DB::table('displinaryhistorymaster')
        ->join('users', 'users.id', '=', 'displinaryhistorymaster.personalNo')
        ->select('displinaryhistorymaster.id','users.empId','displinaryhistorymaster.incrementDate','displinaryhistorymaster.case','displinaryhistorymaster.actionTaken')
        ->where('displinaryhistorymaster.status','0');

        
        if ($request->ajax()) {
            $data = $quali;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
     $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
     $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteDisplinary" data-original-title="Delete" class="btn btn-outline-danger btn-sm deleteDisplinary">Delete</a>';

    
         return $btn;
              })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.displinary',compact('quali'));
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
        DisplinaryHistory::updateOrCreate(['id' => $request->id], 
                ['personalNo' => $request->personalNo,
                'incrementDate' => $request->incrementDate,
                'case' => $request->case,
                'actionTaken' => $request->actionTaken,]);        
   
        return response()->json(['success'=>'New displinary saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $conference = DisplinaryHistory::find($id);
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
        $query = DB::table('displinaryhistorymaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Displinary deleted successfully.']);
    }

    //To redirect to the manage_quali page after the management of quali
    public function message(Request $request)
    {

        return redirect('home');
    }

}