<?php
         
namespace App\Http\Controllers;
          
use App\promotionAll;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class promotionAllController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
   
    {
        // dd($request);
        $b = DB::table('promotionall')
        ->join('users', 'users.empId', '=', 'promotionall.empId')
        ->join('payscalemaster', 'payscalemaster.id', '=', 'promotionall.grade')
        ->select('users.empId','empName','promotionall.id', 'promotionall.gradeCeiling', 'promotionall.yearsToPromote', 'promotionall.doJoining', 'promotionall.doLastPromotion', 'promotionall.promotionDueDate', 'promotionall.modificationReason','payscalemaster.grade')
        ->get();
        
        if ($request->ajax()) {
            $data = $b;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('checkbox', function($row){
                        return '<input id="checkboxColumn" type="checkbox" name="checkboxColumn" data-id="'.$row->id.'"><label></label>';
                    })
               
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                        //    $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deletePromotionAll" data-original-title="Delete" class="btn btn-outline-danger btn-sm deletePromotionAll">Delete</a>';    
                            return $btn;
                    })
                    ->rawColumns(['action','checkbox'])

                    // ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('promotion.promotionAll',compact('b'));
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
 
        promotionAll::updateOrCreate(['id' => $request->id],
        ['empId' => $request->empId, 'grade' => $request->grade, 'gradeCeiling' => $request->gradeCeiling, 'yearsToPromote' => $request->yearsToPromote, 
        'doJoining' => $request->doJoining, 'doLastPromotion' => $request->doLastPromotion, 'promotionDueDate' => $request->promotionDueDate, 'modificationReason'=>$request->modificationReason]);    
        
        return response()->json(['success'=>'saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $a = promotionAll::find($id);
        return response()->json($a);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    // public function delete(Request $request)
    // {
    //     $query = DB::table('promotionall')->where('id', $request->id)
    //     ->increment('status');

    //     return response()
    //         ->json(['success' => 'Deleted successfully.']);
    // }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}