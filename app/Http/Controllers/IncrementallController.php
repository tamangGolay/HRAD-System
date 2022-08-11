<?php
         
namespace App\Http\Controllers;
          
use App\Vehicles;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\Incrementall;

        
class IncrementallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $increments = DB::table('incrementall')    
        ->join('users', 'users.empId', '=', 'incrementall.empId')
        ->select('incrementall.id','users.empId','incrementall.lastIncrementDate','incrementall.incrementDueDate','incrementall.incrementCycle')
        ->get(); 
        
        if ($request->ajax()) {
            $data = $increments;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="editIncrement btn btn-outline-info btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                        //    $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteIncrement" data-original-title="Delete" class="btn btn-outline-danger btn-sm deleteIncrement">Delete</a>';

                            return $btn;
                    })

                    ->addColumn('checkbox', function($row){  
                                                    
                        return '<input type="checkbox" name="country_checkbox" data-id=" '.$row->id.'"><label></label>';
                    })

                    
                    ->rawColumns(['action','checkbox'])
                    ->make(true);
        }
      
        return view('Increment.increment',compact('increments'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // protected $fillable = ['id','empId','lastIncrementDate','incrementDueDate','incrementCycle','modificationReason'];

        Incrementall::updateOrCreate(['id' => $request->id],  //vehicles
                ['empId' => $request->empId,'lastIncrementDate' => $request->lastIncrementDate,'incrementDueDate' => $request->incrementDueDate,'incrementCycle' => $request->incrementCycle,'modificationReason' => $request->modificationReason]);        
   
        return response()->json(['success'=>'New Skill Category  saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $conference = Incrementall::find($id);
        return response()->json($conference);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
   

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}