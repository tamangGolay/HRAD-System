<?php
         
namespace App\Http\Controllers;
          
use App\promotion;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class Manage_promotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)  //pull the data in the front
    {

        $promotion = DB::table('promotionhistorymaster')      

        ->join('users', 'users.id', '=', 'promotionhistorymaster.personalNo')
        ->join('grademaster', 'grademaster.id', '=', 'promotionhistorymaster.gradeFrom')
        // >join('grademaster as g', 'g.id', '=', 'promotionhistorymaster.gradeTo')
     ->select('promotionhistorymaster.id','promotionhistorymaster.promotionDate',
     'promotionhistorymaster.gradeFrom','promotionhistorymaster.gradeTo',
     'promotionhistorymaster.nextDue', 'promotionhistorymaster.remarks','users.empId','grademaster.grade')
   ->where('promotionhistorymaster.status','0');
        
        if ($request->ajax()) {
            $data = $promotion;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteVehicle" data-original-title="Delete" class="btn btn-outline-danger btn-sm deleteVehicle">Delete</a>';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('emp.promotion_history',compact('promotion'));
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
        promotion::updateOrCreate(['personalNo' => $request->name],  ['promotionDate' => $request->number,  'gradeFrom' => $request->from,
        'gradeTo' => $request->to, 'nextDue' => $request->next, 'remarks' => $request->remarks
    
      
    ]);        
   
        return response()->json(['success'=>'Promotion details saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     
        $conference = promotion::find($id);
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

      
        $query = DB::table('promotionhistorymaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Promotion data deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'promotion_history');
    }

}