<?php
         
namespace App\Http\Controllers;
          
use App\pay;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class Manage_payController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $pay = DB::table('payscalemaster')
        ->where('status', 0)
        ->orderBy('payscalemaster.low', 'desc');
        
        if ($request->ajax()) {
            $data = $pay;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deletePay" data-original-title="Delete" class="btn btn-outline-danger btn-sm deletePay">Delete</a>';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('emp.pay_scale',compact('pay'));
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
        pay::updateOrCreate(['id' => $request->id],  ['grade' => $request->name, 'low' => $request->number, 'increment' => $request->increment,
        'high' => $request->high
    

    ]);        
   
        return response()->json(['success'=>'New pay saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     
        $conference = pay::find($id);
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
        $query = DB::table('payscalemaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Payscale data deleted successfully.']);
    }

    //To redirect to the manage_pay page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'pay_scale');
    }

}