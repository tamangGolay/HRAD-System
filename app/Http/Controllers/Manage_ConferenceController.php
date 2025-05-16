<?php
         
namespace App\Http\Controllers;
          
use App\conference;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class Manage_ConferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
   //Only pulling the status 0 conference
        $conference = DB::table('conference')->where('status_c','0');
        
        if ($request->ajax()) {
            $data =  $conference;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   //The button for the manage conference is defined here
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="d" data-original-title="Delete" class="btn btn-danger btn-sm d">Delete</a>';
                           return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('manage_conference',compact('conference'));
    }
//End of index page    
     
//The post data of manage conferece from modal comes here  
    public function store(Request $request)
    {
        // dd($request);

        conference::updateOrCreate(['id' => $request->id],
                ['Conference_Name' => $request->name, 'location' => $request->location, 'capacity' => $request->capacity, 'range_id' => $request->range_id]);        
   
        return response()->json(['success'=>'Meeting Room saved successfully.']);
    }
//The end of store
    
//The id from the manage page is passed here and the data is returned to the 
//blade view page
    public function edit($id)
    {
        $conference = conference::find($id);
        return response()->json($conference);
    }
//End of edit     

//Deleting the conference from manage conference
    public function deleteConference(Request $request)
    {

        // dd($request);


        $query = DB::table('conference')->where('id', $request->id)
            ->increment('status_c');

        return response()
            ->json(['success' => 'Meeting Room deleted successfully.']);
    }
//end of delete conference

//Redirecting the page after update of conference manage
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'manage_conference');
    }
//end of redirect     
   
}