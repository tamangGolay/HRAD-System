<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Uniform;
use App\UniformEmployee;
use DB;
use Auth;
use App\User;
use App\roleusermappings;
use DataTables;


class UniformController extends Controller
{


    public function index(Request $request)
    {
       
        $pay = DB::table('employeeuniform')
        ->join('users', 'users.empId', '=', 'employeeuniform.empId')
        ->join('pantmaster', 'pantmaster.id', '=', 'employeeuniform.pant')
        ->join('shirtmaster', 'shirtmaster.id', '=', 'employeeuniform.shirt')
        ->join('jacketmaster', 'jacketmaster.id', '=', 'employeeuniform.jacket')
        ->join('shoesize', 'shoesize.id', '=', 'employeeuniform.shoe')
        ->join('shoesize as gumboot', 'gumboot.id', '=', 'employeeuniform.shoe')
        ->join('raincoatsize', 'raincoatsize.id', '=', 'employeeuniform.raincoat')
        ->join('officedetails', 'officedetails.id', '=', 'employeeuniform.officeId')
        ->where('employeeuniform.status', 0)
        ->select('users.empId','employeeuniform.id as uniformId','employeeuniform.*','officedetails.shortOfficeName',
        'pantmaster.pantSizeName','shirtmaster.shirtSizeName','jacketmaster.sizeName as jacket',
        'shoesize.ukShoeSize','raincoatsize.sizeName')
        ->paginate(10000);
        
        if ($request->ajax()) {
            $data = $pay;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){                  
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('uniform.uniformReport',compact('pay'));
    }

    public function store(Request $request)
    {

    try{
       
        $existingRecord = UniformEmployee::where('empId', $request->emp_id)
            ->where('year', $request->year)
            ->first();

        if ($existingRecord && $request->id != $existingRecord->id) {
            // If the record already exists and it's not the same record being edited, show an error
            return redirect('home')->with('page', 'uniform')->with('error', 'Record already exists for the given empId and year.');
        }
        
    UniformEmployee::updateOrCreate(['id' => $request->id], 
     ['empId' => $request->emp_id, 
     'officeId' => $request->officeId, 
     'designationID' => $request->designationID, 
     'pant' => $request->pant,
    'shirt' => $request->shirt,
    'jacket' => $request->jacket,
    'shoe' => $request->shoe,
    'gumboot' => $request->gumboot,
    'year' => $request->year,
    'raincoat' => $request->raincoat,
    'createdBy' => $request->emp_id
]);           

    return redirect('home')->with('page', 'uniform')->with('success','Record added successfully!!!');
    }

    catch(\Illuminate\Database\QueryException $e){

        return redirect('home')->with('page', 'uniform')->with('error','Duplicate record!!!');
    
    
    }        
    
}
    //delte indivual record from database

    public function edit($id)
    {
        $User = UniformEmployee::find($id);
        return response()->json($User);
    }

    public function delete(Request $request)
    {

        $query = DB::table('employeeuniform')->where('id', $request->id)
        ->increment('status');

        return response()
            ->json(['success' => 'Detail deleted successfully.']);
    }
    //end of delete user uniform record

   //To redirect to the manage_vehicle page after the management of vehicle
   public function message(Request $request)
   {

       return redirect('home')->with('page', 'uniformReport');
   }
    
    }