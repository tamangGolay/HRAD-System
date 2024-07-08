<?php
         
namespace App\Http\Controllers;
          
use App\Vehicles;
use App\Company;
use Illuminate\Http\Request;
use DataTables;
use DB;
        
class CompanyMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $b = DB::table('companymaster')->where('status','0');
        
        if ($request->ajax()) {
            $data = $b;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm edit">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp';
                           $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteCompany" data-original-title="Delete" class="btn btn-outline-danger btn-sm deleteCompany">Delete</a>';    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('masterData.companyMaster',compact('b'));
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
       
        Company::updateOrCreate(['id' => $request->id],
        ['comNameShort' => $request->comNameShort, 
        'comNameLong' => $request->comNameLong, 
        'comReportsTo' => $request->comReportsTo]);    
        

   
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

        $a = Company::find($id);
        return response()->json($a);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $query = DB::table('companymaster')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Company deleted successfully.']);
    }

    //To redirect to the manage_vehicle page after the management of vehicle
    public function message(Request $request)
    {

        return redirect('home');
    }

}