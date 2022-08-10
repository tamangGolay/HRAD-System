<?php
    
namespace App\Http\Controllers;
    
use App\Incrementall;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Str; 
use App\Duelist;
    
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
                    ->addColumn('checkbox', function($row){  
                                                    
                                return '<input type="checkbox" name="country_checkbox" data-id=" '.$row->id.'"><label></label>';
                            })

                            ->rawColumns(['checkbox'])
                            ->make(true);
                          }
    
        return view('Increment.incrementList');
    }

    public function insertDuelist(Request $request){

        // Incrementall
        // Duelist
        $ids = count($request->countries_ids);//checkbox count

        for($i = 0; $i < $ids; ++$i){

           // $id[$i] = implode(' ',  $request->countries_ids);
            
            $empId[$i] = DB::table('incrementall')    // table(incrementall)
            ->select('empId')
            ->where('id',$request->countries_ids[$i])
            ->first();

            $tempBasic[$i] = DB::table('users')                 //users table
            ->join('incrementall', 'incrementall.empId', '=', 'users.empId')
            ->select('users.basicPay')
            ->where('incrementall.id',$request->countries_ids[$i])
            ->first();

            $fromGrade [$i]= DB::table('incrementall')              //incrementall n users  table
            ->join('users', 'users.empId', '=', 'incrementall.empId')            
            ->select('users.gradeId')
            ->where('incrementall.id',$request->countries_ids[$i])
            ->first();

            $toGrade [$i]= $fromGrade[$i]->gradeId;

            $newIncrement [$i]= DB::table('payscalemaster')
            ->select('payscalemaster.increment')
            ->where('payscalemaster.id','=',$toGrade [$i])
            ->first();

            $newMinimum [$i]= DB::table('payscalemaster')
            ->select('payscalemaster.low')
            ->where('payscalemaster.id','=',$toGrade [$i])
            ->first();

            $oldMaximum [$i]= DB::table('payscalemaster')
            ->select('payscalemaster.high')
            ->where('payscalemaster.id','=',$fromGrade[$i]->gradeId)
            ->first();

            // if($i == 0){
            //     dd($oldMaximum[$i]);
            // }

            $promotionYear [$i] = 2023;
            $promotionMonth [$i]= 'July';

            if($tempBasic[$i]->basicPay + $newIncrement[$i]->increment < $newMinimum[$i]->low) {
                $newBasic[$i] = $tempBasic[$i]->basicPay;
        //    dd("hello");
            }
            else{

               if($tempBasic[$i]->basicPay >  $oldMaximum[$i]->high){
                   $tempBasic[$i]->basicPay = $oldMaximum[$i]->high;                  

            }
               $diffPay[$i] = $tempBasic[$i]->basicPay - $newMinimum[$i]->low;
               $noOfIncrement[$i]= 1 + round($diffPay[$i]/$newIncrement[$i]->increment);
               $newBasic[$i] = $newMinimum[$i]->low + $newIncrement[$i]->increment * $noOfIncrement[$i];

            }      

             $duelistrecord = new Duelist;
             $duelistrecord->incrementYear = $promotionYear[$i];
             $duelistrecord->incrementMonth = $promotionMonth[$i];
             $duelistrecord->empId = $empId[$i]->empId;      //new added            
             $duelistrecord->yearlyIncrement = $newIncrement[$i]->increment; 
             $duelistrecord->oldBasic = $tempBasic[$i]->basicPay;
             $duelistrecord->newBasic = $newBasic[$i];
             $duelistrecord->save();          
        
        }
        return response()
        ->json(['code'=>1, 'msg'=>'Successfull inserted the data(s) into Increment DueList Record!']); 
    }      

       

        

    
}