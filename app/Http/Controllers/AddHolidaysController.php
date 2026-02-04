<?php
         
namespace App\Http\Controllers;
          
use App\Holidays;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class AddHolidaysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $b = DB::connection('mysql2')->table('holidays')->where('status', 'active');

        
        if ($request->ajax()) {
            $data = $b;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('Attendance.addHolidays',compact('b'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
     {
       
        Holidays::updateOrCreate(['id' => $request->id],
        ['holiday_date' => $request->holidayDate, 'holiday_name' => $request->holidayName, 'status' => $request->status]);    
        
        return response()->json(['success'=>'New Holidays saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $a = Holidays::find($id);
        return response()->json($a);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    
    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}