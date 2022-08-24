<?php
         
namespace App\Http\Controllers;
          
use App\WfBank;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class WelfareBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $b = DB::table('wfbank');
        
        if ($request->ajax()) {
            $data = $b;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                        //    $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteDepartment" data-original-title="Delete" class="btn btn-outline-danger btn-sm deleteDepartment">Delete</a>';    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('welfare.welfareBank',compact('b'));
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

        $oldBalance = DB::table('wfbalance')
            ->select("balance")
            ->first();

        if($request->transaction == "CR"){
            $newBalance = $oldBalance->balance + $request->amount;
            DB::update('update wfbalance set balance = ? where id = ?', [$newBalance, 1]);
            // dd("add");
        }
        else{
            $newBalance = $oldBalance->balance - $request->amount;
            DB::update('update wfbalance set balance = ? where id = ?', [$newBalance, 1]);
            // dd("minus");

        }


       
        WfBank::updateOrCreate(['id' => $request->id],
        ['date' => $request->date, 'narration' => $request->narration, 
        'transaction' => $request->transaction, 'amount' => $request->amount,]);  
        

        

   
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

        $a = WfBank::find($id);
        return response()->json($a);
    }
}