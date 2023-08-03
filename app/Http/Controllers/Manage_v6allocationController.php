<?php
         
namespace App\Http\Controllers;
          
use App\v6allocation;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use Carbon\Carbon;
        
class Manage_v6allocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

       
        $bank = DB::table('v6allocation')->where('v6allocation.status','0');
        
        if ($request->ajax()) {
            $data = $bank;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm editipv6">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                        //    $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteofficeName" data-original-title="Delete" class="btn btn-outline-danger btn-sm deleteipv6">Delete</a>';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('ip.v6allocation',compact('bank'));
    }

   
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    
    {
        $authuser = Auth::user()->empId;
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->format('Y-m-d');

        v6allocation::updateOrCreate(['id' => $request->id],
                ['ipV6Address' => $request->v6allocation,'serverName' => $request->serverName,'internalAddress' => $request->internalAddress,'createdBy' => $authuser,'createdOn' =>$formattedDate]);        
   
        return response()->json(['success'=>'ipv6 saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $bank = v6allocation::find($id);
        return response()->json($bank);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $query = DB::table('v6allocation')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'ipv6 deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'manage_vehicle');
    }

}