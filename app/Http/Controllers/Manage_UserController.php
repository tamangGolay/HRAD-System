<?php
         
namespace App\Http\Controllers;
          
use App\User;
use App\roleusermappings;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class Manage_UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    
    public function index(Request $request)
    {

        $userList = DB::table('users')->join('userrolemapping', 'users.id', '=', 'userrolemapping.user_id')
        ->join('roles', 'users.role_id', '=', 'roles.id')
        ->join('orgunit', 'orgunit.id', '=', 'users.org_unit_id')
        ->join('dzongkhags', 'dzongkhags.id', '=', 'users.dzongkhag')
        ->join('guesthouserate', 'users.grade', '=', 'guesthouserate.id')

        ->select('users.id','users.email','dzongkhags.Dzongkhag_Name','users.gender','guesthouserate.grade','roles.id as rid','users.org_unit_id as oid','users.id as uid','users.emp_id', 'users.contact_number', 'users.designation', 'orgunit.description', 'users.name as uname', 'roles.name')
        ->latest('users.id') //similar to orderby('id','desc')
        ->where('users.status','0')
        ->paginate(10000);
        
        
        if ($request->ajax()) {
            $data = $userLists;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="delete" data-original-title="Delete" class="btn btn-primary btn-sm delete">Delete</a>';




    
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
            User::updateOrCreate(['id' => $request->id],
                ['name' => $request->name,
                 'emp_id' => $request->emp_id,
                 'contact_number' => $request->contact_number,
                 'role_id' => $request->role,
                 'org_unit_id' => $request->org_unit,
                 'grade' => $request->grade,
                 'gender' => $request->gender,
                'designation' => $request->designation,
                'dzongkhag' => $request->dzongkhag,
                'email' => $request->email,


                'conference_user' => $request->conferenceuser
                
                ]); 

                 roleusermappings::updateOrCreate(['user_id' => $request->id],
                 [
                 'role_id' => $request->role
                  
                  ]); 
                 
              
   
        return response()->json(['success'=>'Updated successfully.']);
    }



    // //For HR
    // public function b(Request $request)
    // {
   
    //         User::updateOrCreate(['id' => $request->id],
    //             ['name' => $request->name,
    //              'contact_number' => $request->contact_number,
    //              'org_unit_id' => $request->orgunit,
    //              'egender' => $request->gender,

    //              ]); 

                 
                 
              
   
    //     return response()->json(['success'=>'Updated successfully.']);
    // }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $User = User::find($id);
        return response()->json($User);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {


        $isconferenceuser = DB::table('users')->select('conference_user')
        ->where('id', $request->id)
        ->first();
        if($isconferenceuser->conference_user == 1){//For headquarter employee 
            $query = DB::table('users')->where('id', $request->id)
            ->decrement('conference_user');

        }

        $query = DB::table('users')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'User deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'userList');
    }

}
