<?php
         
namespace App\Http\Controllers;
          
use App\officeName;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class Manage_MasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $officeName = DB::table('officename')->where('status','0');
        
        if ($request->ajax()) {
            $data = $officeName;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm editOfficeName">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteofficeName" data-original-title="Delete" class="btn btn-outline-danger btn-sm deleteOfficeName">Delete</a>';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.officeName',compact('officeName'));
    }

  
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        officeName::updateOrCreate(['id' => $request->id],
                ['shortOfficeName' => $request->shortOfficeName, 'longOfficeName' => $request->longOfficeName,
                 'officeType' => $request->officeType]);        
   
        return response()->json(['success'=>'Office Name saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $conference = officeName::find($id);
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
        $query = DB::table('officeName')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Office Name deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}