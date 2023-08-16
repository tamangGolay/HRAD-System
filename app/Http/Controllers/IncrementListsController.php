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
        ->join('users','users.empId','=','incrementduelist.empId')
        ->select('incrementduelist.*','users.empName')    
        ->get();
    
        if ($request->ajax()) {              
            $data = $b;           
    
            return Datatables::of($data)

                    ->addIndexColumn()

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
            
            // y-m-d   
            $dateyear=date('Y');
            $datemonth=date('m'); 

            if($dateyear ==  $incrementYearnMonth[$i]->year){  //same year before july
                if($datemonth < $incrementYearnMonth[$i]->month){                      
               

                                                    
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
            if([$i] == [$ids-1])
            return response()->json(['code'=>1, 'msg'=>'Data inserted into Increment duelist!!!']); 


           } 
          }
          
        if(($dateyear + 1) ==  $incrementYearnMonth[$i]->year){
                 if($datemonth > $incrementYearnMonth[$i]->month +5){     
                               
                                                    
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
        if([$i] == [$ids-1])
        return response()->json(['code'=>1, 'msg'=>'Data inserted into Increment duelist!!!']); 


            }
        }

            else{

                if([$i] == [$ids-1]){
                return response()
                ->json(['code' =>3, 'msg' => 'This employee(s) are not eligleble for this cycle increment.']);
             } 
            }

                  
        }
       
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

            $newBasic[$i] = DB::table('incrementduelist')    // table(incrementduelist)
            ->select('newBasic')
            ->where('id',$request->update_ids[$i])
            ->first();

            User::updateOrCreate(['empId' => $empId[$i]->empId],
                                 ['basicPay' =>$newBasic[$i]->newBasic]);
            
            //1. end for users table

            $incrementDate[$i]= DB::table('incrementduelist')
            ->join('incrementall','incrementall.empId','=','incrementduelist.empId')
            ->select('incrementall.incrementDueDate')
            ->where('incrementduelist.id',$request->update_ids[$i])
            ->first();       
            
            

            $newIncrement[$i]= DB::table('incrementduelist')
            ->select('yearlyIncrement')
            ->where('id',$request->update_ids[$i])
            ->first();  
            
            increment::updateOrCreate(['personalNo' => $empId[$i]->empId],
                                    ['increment' => $newIncrement[$i]->yearlyIncrement,
                                    'incrementDate' => $incrementDate[$i]->incrementDueDate,
                                    'newBasic' => $newBasic[$i]->newBasic]);
           
            

            //2. end for incrementhistroy master data

            $newIncrementDate[$i] = DB::table('incrementduelist')
            ->join('incrementall','incrementall.empId','=','incrementduelist.empId')
            ->select('incrementall.incrementDueDate',DB::raw('Year(incrementDueDate) AS year'), DB::raw('Month(incrementDueDate) AS month'))
            ->where('incrementduelist.id',$request->update_ids[$i])
            ->first();
            
            $newYear[$i]=$newIncrementDate[$i]->year + 1;
            $newDate[$i] = $newYear[$i] . '/' .$newIncrementDate[$i]->month.'/'. '01';         
                   
            // dd( $newDate[$i]);

            Incrementall::updateOrCreate(['empId' => $empId[$i]->empId],
                                         ['lastIncrementDate' =>$incrementDate[$i]->incrementDueDate,
                                          'incrementDueDate' => $newDate[$i] ] );
                    }
    return response()
    ->json(['code'=>1, 'msg'=>'Successfull updated the data(s) into 3 tables: users, incrementhistroymaster,& incrementall']);

 
   }
   
}

?>