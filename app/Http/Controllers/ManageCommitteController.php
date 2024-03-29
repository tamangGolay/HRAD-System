<?php
         
namespace App\Http\Controllers;
          
use App\User;
use App\WelfareCommitte;
use App\roleusermappings;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class ManageCommitteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {  
     $userList = DB::table('welfarecommitte')
    ->join('users', 'welfarecommitte.memberEID', '=', 'users.empId')
    ->select('users.empName','users.empId','welfarecommitte.*')
    ->latest('welfarecommitte.id');      //similar to orderby('id','desc')
                
        if ($request->ajax()) {
            $data = $userList;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('auth.userList',compact('userList'));
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

        WelfareCommitte::updateOrCreate(['id' => $request->id],
                [
                'memberEID' => $request->emp_id,
                'memberEmail' => $request->memberEmail,
                'memberType' => $request->memberType,
                ]);
                  
        return response()->json(['success'=>'Updated successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        // $User = WelfareCommitte::find($id);
        $User = WelfareCommitte::with('user')->find($id);

        return response()->json($User);
    }
  
    

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {
        return redirect('home')->with('page', 'userList');
    }
}
