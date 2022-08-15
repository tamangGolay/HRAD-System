<?php
    
namespace App\Http\Controllers;    
use App\Incrementall;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Str; 
use App\Duelist;
use App\User;
use App\increment;
    
class IncrementListsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
       {
        $b = DB::table('incrementduelist')
        ->select('*')      
     
        ->get();
    
        if ($request->ajax()) {              
            $data = $b;           
    
            return Datatables::of($data)

                    ->addIndexColumn()

                    // ->filter(function ($instance) use ($request) {
                        
                    //     if (!empty($request->get('filter'))) {
                    //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                    //             return Str::contains($row['incrementDueDate'], $request->get('filter')) ? true : false;   
                    //         });
                    //     }
                    //     if (!empty($request->get('month'))) {
                    //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                    //             return Str::contains($row['month'], $request->get('month')) ? true : false;   
                    //         });
                    //     }
                        
                    //     if (!empty($request->get('search'))) {
                    //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                    //             if (Str::contains(Str::lower($row['incrementDueDate']), Str::lower($request->get('search')))){
                    //                 return true;
                    //             }else if (Str::contains(Str::lower($row['empId']), Str::lower($request->get('search')))) {
                    //                 return true;
                    //             }else if (Str::contains(Str::lower($row['incrementCycle']), Str::lower($request->get('search')))) {
                    //                 return true;
                    //             }
   
                    //             return false;
                    //         });
                    //     }   
                    // })

                    ->addColumn('checkbox', function($row){  
                                                    
                                return '<input type="checkbox" name="update_checkbox" data-id=" '.$row->id.'"><label></label>';
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
              $incrementAll->incrementMonth = $incrementYearnMonthz[$i];  //july
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
                ->json(['code' => 2, 'msg' => 'This employee(s) are not eligleble for this cycle increment.']);
             }

                  
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

  public function updateDuelist(Request $request){

    $ids = count($request->update_ids);//checkbox count

        for($i = 0; $i < $ids; ++$i){

            $empId[$i] = DB::table('incrementduelist')    // table(incrementall)
            ->select('empId')
            ->where('id',$request->update_ids[$i])
            ->first();

            $newBasicz[$i] = DB::table('incrementduelist')    // table(incrementduelist)
            ->select('newBasic')
            ->where('id',$request->update_ids[$i])
            ->first();

            User::updateOrCreate(['empId' => $empId[$i]->empId],
                                 ['basicPay' =>$newBasicz[$i]->newBasic]);
            
            //1. end for users table

            $incrementDate [$i]= DB::table('incrementduelist')
            ->join('incrementall','incrementall.empId','=','incrementduelist.empId')
            ->select('incrementall.incrementDueDate')
            ->where('incrementduelist.id',$request->update_ids[$i])
            ->first();

            $fromGrade [$i]= DB::table('incrementduelist')              //incrementall n users  table
            ->join('users', 'users.empId', '=', 'incrementduelist.empId')            
            ->select('users.gradeId')
            ->where('incrementduelist.id',$request->update_ids[$i])
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

            $tempBasic[$i] = DB::table('users')                 //users table
            ->join('incrementduelist', 'incrementduelist.empId', '=', 'users.empId')
            ->select('users.basicPay')
            ->where('incrementduelist.id',$request->update_ids[$i])
            ->first();

            if($tempBasic[$i]->basicPay + $newIncrement[$i]->increment < $newMinimum[$i]->low) {
                $newBasic[$i] = $tempBasic[$i]->basicPay;
        
            }
            else{

               if($tempBasic[$i]->basicPay >  $oldMaximum[$i]->high){
                   $tempBasic[$i]->basicPay = $oldMaximum[$i]->high;                
            }
               $diffPay[$i] = $tempBasic[$i]->basicPay - $newMinimum[$i]->low;
               $noOfIncrement[$i]= 1 + round($diffPay[$i]/$newIncrement[$i]->increment);
               $newBasic[$i] = $newMinimum[$i]->low + $newIncrement[$i]->increment * $noOfIncrement[$i];
            }

            $updateIncrementHistory = new increment;
            $updateIncrementHistory->personalNo = $empId[$i]->empId;
            $updateIncrementHistory->increment = $newIncrement[$i]->increment;
            $updateIncrementHistory->incrementDate = $incrementDate[$i]->incrementDueDate;
            $updateIncrementHistory->newBasic = $newBasic[$i];
            $updateIncrementHistory->save();  

            //2. end for incremnethistroy master data

            $newIncrementDate[$i] = DB::table('incrementall')
            ->select('incrementDueDate',DB::raw('Year(incrementDueDate) AS year'), DB::raw('Month(incrementDueDate) AS month'))
            ->where('id',$request->countries_ids[$i])
            ->first();

            $newDate[$i] = $newIncrementDate[$i]->year + 1; //for new year

            //new date for incremental table for update
            

            Incrementall::updateOrCreate(['empId' => $empId[$i]->empId],
                                         ['lastIncrementDate' =>$incrementDate[$i]->incrementDueDate],
                                         ['incrementDate' => $newDate[$i]],);

                    }


    return response()
    ->json(['code'=>1, 'msg'=>'Successfull updated the data(s) into 3 tables: users, incrementhistroymaster,& incrementall']);

 
 }


}

?>