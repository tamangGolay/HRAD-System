<?php
         
namespace App\Http\Controllers;
          
use App\Vehicles;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class Manage_VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $vehicle = DB::table('vehicledetails')->where('status','0');
        
        if ($request->ajax()) {
            $data = $vehicle;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteVehicle" data-original-title="Delete" class="btn btn-primary btn-sm deleteVehicle">Delete</a>';




    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('vehicle.manage_vehicle',compact('vehicle'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->id);
        Vehicles::updateOrCreate(['id' => $request->id],
                ['vehicle_name' => $request->name, 'vehicle_number' => $request->number]);        
   
        return response()->json(['success'=>'New vehicle saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $conference = Vehicles::find($id);
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
        $query = DB::table('vehicledetails')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Vehicle deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'manage_vehicle');
    }

}