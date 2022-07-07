<?php
         
namespace App\Http\Controllers;
          
use App\office;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class Manage_officeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)  //pull the data in the front
    {

        $office = DB::table('officereportingstructuremaster')->where('status', 0);
        
        if ($request->ajax()) {
            $data = $office;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteOffice" data-original-title="Delete" class="btn btn-primary btn-sm deleteOffice">Delete</a>';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('emp.office_report',compact('office'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        office::updateOrCreate(['officeId' => $request->name],  ['reportsToOffice' => $request->number,  'fromDate' => $request->start,
        'endDate' => $request->end

    ]);        
   
        return response()->json(['success'=>'Office report details saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     
        $conference = office::find($id);
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

      
        $query = DB::table('officereportingstructuremaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Office Report data deleted successfully.']);
    }

    //To redirect to the manage_office page after the management of office
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'office_report');
    }

}