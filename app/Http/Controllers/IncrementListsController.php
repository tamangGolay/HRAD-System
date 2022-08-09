<?php
    
namespace App\Http\Controllers;
    
use App\Incrementall;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Str; 
    
class IncrementListsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    {

//         ->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
// ->groupby('year','month')
// ->get();

        $b = DB::table('incrementall')

        ->join('users', 'users.empId', '=', 'incrementall.empId')
        // ->join('payscalemaster', 'users.empId', '=', 'incrementall.empId')
       
    //   ->select('incrementall.id','users.empId','users.basicPay','incrementall.incrementCycle',DB::raw('Year(incrementDueDate) AS incrementDueDate'))

->select('incrementall.id','users.empId','users.basicPay','incrementall.incrementCycle',DB::raw('Year(incrementDueDate) AS incrementDueDate'), DB::raw('Month(incrementDueDate) AS month'))
    
        ->get();
    
        if ($request->ajax()) {  
            
            $data = $b;
           
    
            return Datatables::of($data)

                    ->addIndexColumn()

                    ->filter(function ($instance) use ($request) {
                        
                        if (!empty($request->get('filter'))) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains($row['incrementDueDate'], $request->get('filter')) ? true : false;   
                            });
                        }
                        if (!empty($request->get('month'))) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains($row['month'], $request->get('month')) ? true : false;   
                            });
                        }
                        
                        if (!empty($request->get('search'))) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                if (Str::contains(Str::lower($row['incrementDueDate']), Str::lower($request->get('search')))){
                                    return true;
                                }else if (Str::contains(Str::lower($row['empId']), Str::lower($request->get('search')))) {
                                    return true;
                                }else if (Str::contains(Str::lower($row['incrementCycle']), Str::lower($request->get('search')))) {
                                    return true;
                                }
   
                                return false;
                            });
                        }
   
                    })
                    ->addColumn('action', function($row){
  
                           $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
  
                            return $btn;
                    })

                    // ->addColumn('checkbox', function ($data) {
                    //     return '<input id="'.$data->id.'" name="ids" type="checkbox" />';
                    //   })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    
        return view('Increment.incrementList');
    }


    
}