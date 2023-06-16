<?php
         
namespace App\Http\Controllers;
       
use App\v4allocation;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;

class Manage_IPv4Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        $ipv4 = DB::table('v4allocation')->where('v4allocation.status','0');
        
        if ($request->ajax()) {
            $data = $ipv4;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm editipv4">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                        $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteofficeName" data-original-title="Delete" class="btn btn-outline-danger btn-sm deletebank">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('ip.v4allocation',compact('ipv4'));
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
        $user = Auth::user()->empId;
        $datex = date('Y-m-d'); 

        v4allocation::updateOrCreate(['id' => $request->id],
                ['ipV4Address' => $request->ipV4Address,
                'serverName' => $request->serverName,
                'createdBy' => $user,
                'createdOn' => $datex,
                'internalAddress' => $request->internalAddress]);        
   
        return response()->json(['success'=>'ipV4 saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $v4 = v4allocation::find($id);
        return response()->json($v4);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $query = DB::table('v4allocation')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'IPv4 deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'v4allocation');
    }

}