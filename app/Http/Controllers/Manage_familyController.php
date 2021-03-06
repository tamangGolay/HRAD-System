<?php
         
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\family;
use Illuminate\Http\Request;
use DataTables;
use DB;

        
class Manage_familyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)  //pull the data in the front
    {

        $family = DB::table('familydetailsmaster')
        ->join('users', 'users.id', '=', 'familydetailsmaster.personalNo')
              ->join('relationmaster', 'relationmaster.id', '=', 'familydetailsmaster.relation')
        ->select('familydetailsmaster.id','familydetailsmaster.personalNo','familydetailsmaster.relativeName'
        ,'familydetailsmaster.cidNo','familydetailsmaster.cidOther','familydetailsmaster.dob','familydetailsmaster.gender','relationmaster.relationshipName','users.empId'
        )
        ->where('familydetailsmaster.status','0');
        


        
        if ($request->ajax()) {
            $data = $family;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteFamily" data-original-title="Delete" class="btn btn-outline-danger btn-sm deleteFamily">Delete</a>';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('emp.family_details',compact('family'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // for getting either of the cid no
        $validator = validator::make($request->all(),[
            'cidNo' => 'required_without:cidOther',
            'cidOther' => 'required:cidNo',
            ]);       

        family::updateOrCreate(['personalNo' => $request->name],  ['relativeName' => $request->number, 'cidNo' => $request->cidNo, 'cidOther' => $request->cidOther,  'dob' => $request->dob,
        'gender' => $request->gender, 'relation' => $request->relation
    

    ]);
    
            // // for getting either of the cid no
            // $request = validate([
            //     'cidNo' => 'required_without:cidOther',
            //     'cidOther' => 'required_without:cidNo',
            //     ]);
   
        return response()->json(['success'=>'Family details saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     
        $conference = family::find($id);
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


        $query = DB::table('familydetailsmaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Family data deleted successfully.']);
    }

    //To redirect to the manage_family page after the management of family
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'family_details');
    }

}