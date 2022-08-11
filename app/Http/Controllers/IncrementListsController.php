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

        try{

        $ids = count($request->countries_ids);//checkbox count

        for($i = 0; $i < $ids; ++$i){

            $incrementYearnMonth[$i] = DB::table('incrementall')
            ->select('incrementDueDate',DB::raw('Year(incrementDueDate) AS year'), DB::raw('Month(incrementDueDate) AS month'))
            ->where('id',$request->countries_ids[$i])
            ->first();
            
            $date = Carbon::now()->toDateString(); // y-m-d   
            $dateyear=date('Y');
            $datemonth=date('m');   
            
            // if($dateyear ==  $incrementYearnMonth[$i]->year){
            //     if($datemonth < $incrementYearnMonth[$i]->month){                


            //     } }    
                            
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
            
            $incrementYearnMonthz[$i] = 'July';
            $incrementYearnMonths[$i] = 'January';  


            if($dateyear ==  $incrementYearnMonth[$i]->year){  //same year before july
                if($datemonth < $incrementYearnMonth[$i]->month){                          
               
              $incrementAll = new Duelist;
              $incrementAll->incrementYear = $incrementYearnMonth[$i]->year;  
              $incrementAll->incrementMonth = $incrementYearnMonthz[$i];
              $incrementAll->empId = $empId[$i]->empId;                //new added            
              $incrementAll->yearlyIncrement = $newIncrement[$i]->increment; 
              $incrementAll->oldBasic = $tempBasic[$i]->basicPay;
               $incrementAll->newBasic = $newBasic[$i];
              $incrementAll->save();             
          
            //   return response()
            //   ->json(['code'=>1, 'msg'=>'Successfull inserted the data(s) into Increment DueList Record!']);

           } 
          }
          
        else if(($dateyear + 1) ==  $incrementYearnMonth[$i]->year){
                 if($datemonth > $incrementYearnMonth[$i]->month +5){                 
            
               $incrementAll = new Duelist;     
               $incrementAll->incrementYear = $incrementYearnMonth[$i]->year;         
               $incrementAll->incrementMonth = $incrementYearnMonths[$i];
               $incrementAll->empId = $empId[$i]->empId;                //new added            
               $incrementAll->yearlyIncrement = $newIncrement[$i]->increment; 
               $incrementAll->oldBasic = $tempBasic[$i]->basicPay;
               $incrementAll->newBasic = $newBasic[$i];
               $incrementAll->save();     
               
        //        return response()
        //   ->json(['code'=>1, 'msg'=>'Successfull inserted the data(s) into Increment DueList Record!']);

            }
        }

            else{

                return response()
                ->json(['code' => 2, 'msg' => 'This employee(s) record are already in Increment Duelist.']);
          
            }

            //  $duelistrecord = new Duelist;
            //  $duelistrecord->incrementYear = $promotionYear[$i];
            //  $duelistrecord->incrementMonth = $promotionMonth[$i];
            //  $duelistrecord->empId = $empId[$i]->empId;      //new added            
            //  $duelistrecord->yearlyIncrement = $newIncrement[$i]->increment; 
            //  $duelistrecord->oldBasic = $tempBasic[$i]->basicPay;
            //  $duelistrecord->newBasic = $newBasic[$i];
            //  $duelistrecord->save();          
        
        }
        // return response()
        // ->json(['code'=>3, 'msg'=>'Sorry!!.This employee(s) are not eligleble for this cycle increment.']); 
       
        return response()
           ->json(['code'=>1, 'msg'=>'Successfull inserted the data(s) into Increment DueList Record!']);

    } 

       catch(\Illuminate\Database\QueryException $e){        
 
        return response()->json(['code'=>3, 'msg'=>'Increment not eligible / Duplicate data entry!!!']); 

    }

}
}

?>