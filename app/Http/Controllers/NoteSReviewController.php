<?php
        
namespace App\Http\Controllers;
          
use App\notesheetRequest;
use App\RoleUserMappings;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
        
class NoteSReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */    
    public function index(Request $request)
    {

    $notesheetRequest = DB::table('notesheet')
    ->join('officedetails', 'officedetails.id', '=', 'notesheet.officeId')     
    ->join('officemaster','officemaster.id','=','notesheet.officeId')
    ->select('notesheet.id','officedetails.longOfficeName','notesheet.createdBy','topic','justification','notesheet.status','notesheet.officeId','officemaster.reportToOffice')
//    ->latest('notesheet.id') //similar to orderby('id','desc')

    ->where('notesheet.status','=','Recommended')
    ->where('cancelled','=','No')
    ->where('notesheet.officeId',Auth::user()->office)    
    ->orwhere('officemaster.reportToOffice',Auth::user()->office)
    ->where('notesheet.status','=','Recommended')
    ->get();

//    ->orWhere('orgunit.office',Auth::user()->office)
    // ->paginate(10000000);
        
        
        if ($request->ajax()) {
            $data = $notesheetRequests;
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
      
        return view('Notesheet.GMReviewnotesheet',compact('notesheetRequest'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        notesheetRequest::updateOrCreate(['id' => $request->id],
                ['justification' => $request->justification,                                 
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
        $User = notesheetRequest::find($id);
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
        $query = DB::table('notesheet')->where('id', $request->id);         

        return response()
            ->json(['success' => 'User deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'GMReviewnotesheet');
    }

}
