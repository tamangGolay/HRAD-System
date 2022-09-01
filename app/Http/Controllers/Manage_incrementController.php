<?php
         
namespace App\Http\Controllers;
          
use App\increment;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class Manage_incrementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)  //pull the data in the front
    {

        $increment = DB::table('incrementhistorymaster')

        ->join('users', 'users.empId', '=', 'incrementhistorymaster.personalNo')
        ->select('incrementhistorymaster.id','incrementhistorymaster.incrementDate',
        'incrementhistorymaster.newBasic',
         'users.empId','incrementhistorymaster.increment');
         
        
        if ($request->ajax()) {
            $data = $increment;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('emp.increment_history',compact('increment'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->id);
        increment::updateOrCreate(['personalNo' => $request->empId],  ['incrementDate' => $request->number, 
        'newBasic' => $request->newBasic,'increment' => $request->increment

    ]);        
   
        return response()->json(['success'=>'Increment details saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     
        $conference = increment::find($id);
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
      
        $query = DB::table('incrementhistorymaster')
        ->where('id', $request->id);
            

        return response()
            ->json(['success' => 'Increment data deleted successfully.']);
    }

    //To redirect to the manage_increment page after the management of increment
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'increment_history');
    }

}