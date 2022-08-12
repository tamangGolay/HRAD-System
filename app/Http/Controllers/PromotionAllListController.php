<?php

namespace App\Http\Controllers;
use App\promotionAll;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use DataTables;
use App\Promotionduelist;

      

class PromotionAllListController extends Controller
{
   /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */       

public function index(Request $request)

{
    $b = DB::table('promotionduelist')
//  ->join('users', 'users.empId', '=', 'promotionall.empId')
 ->join('officedetails', 'officedetails.id', '=', 'promotionduelist.office')

//  ->select('users.basicPay','promotionall.id','promotionall.empId','promotionall.grade',DB::raw('Year(promotionDueDate) AS promotionDueDate'),DB::raw('month(promotionDueDate) AS month'))
        ->select('promotionduelist.*','officedetails.officeDetails')
        ->where('promotionduelist.status','=','Approved') 
        
        ->get();

     if ($request->ajax()) {
        $data=$b;
        // $data = promotionAll::latest()->get();
        return Datatables::of($data)

        ->addIndexColumn()
               
        ->addColumn('checkbox', function($row){
         return '<input id="checkboxColumn" type="checkbox" name="checkboxColumn" data-id="'.$row->id.'"><label></label>';
         })
           
         ->rawColumns(['actions','checkbox'])
        ->make(true);

               

    }

    return view('promotion.promotionAllList');

}

public function insertSelectedCountries(Request $request){

        
    try{

    $ids = count($request->promotion_ids);//checkbox count

    // dd($ids);

    for($i = 0; $i < $ids; ++$i){

        $promotion[$i] = DB::table('promotionall')//promotionall table(incrementall)
        ->select('promotionDueDate',DB::raw('Year(promotionDueDate) AS year'),DB::raw('month(promotionDueDate) AS month'))
        ->where('id',$request->promotion_ids[$i])
        ->first();
        $date = date('Y');
        // dd($promotion[$i]->year, $date);



        if($date = date('Y') + 1 ==  $promotion[$i]->year){
            if($promotion[$i]->month < 7)
            {
                // dd("January records");
                // $id[$i] = implode(' ',  $request->promotion_ids);
        $empId[$i] = DB::table('promotionall')//promotionall table(incrementall)
        ->select('empId')
        ->where('id',$request->promotion_ids[$i])
        ->first();
        // dd($empId[$i]->empId);

        $fromGrade[$i] = DB::table('users')//users table
        ->join('promotionall', 'promotionall.empId', '=', 'users.empId')
        ->select('users.gradeId')
        ->where('promotionall.id',$request->promotion_ids[$i])
        ->first();
        
        $tempBasic[$i] = DB::table('users')//users table
        ->join('promotionall', 'promotionall.empId', '=', 'users.empId')
        ->select('users.basicPay')
        ->where('promotionall.id',$request->promotion_ids[$i])
        ->first();

        
        $oldIncrement [$i]= DB::table('payscalemaster')
        ->select('payscalemaster.increment')
        ->where('payscalemaster.id','=',$fromGrade[$i]->gradeId)
        ->first();

        $incrementCycle[$i] = DB::table('users')//users table
        ->join('promotionall', 'promotionall.empId', '=', 'users.empId')
        ->select('users.incrementCycle')
        ->where('promotionall.id',$request->promotion_ids[$i])
        ->first();

        

        // dd($tempBasic[$i]->basicPay);


        // $fromGrade [$i]= DB::table('promotionall')//promotionall table
        // ->join('payscalemaster', 'payscalemaster.grade', '=', 'promotionall.grade')
        // // ->where('payscalemaster.id',$request->promotion_ids[$i])
        // ->select('payscalemaster.id')
        // ->first();

        // dd($fromGrade [$i]->grade);

        // $fromGrade [$i] = 7;
        // dd($fromGrade [$i]);

      

        // if($i == 0){
        //     dd($fromGrade[$i]->gradeId);
        // }
        
        $toGrade [$i]= $fromGrade[$i]->gradeId - 1;
        // $toGrade [$i]= $fromGrade[$i] - 1;//test
        // dd($toGrade [$i]);


        // $toGradeIncrement [$i]= DB::table('payscalemaster')//promotionall table
        // ->where('id',$request->promotion_ids[$i])
        // ->select('grade')
        // ->first();

            // dd($toGrade[$i]);

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
        // ->where('payscalemaster.id','=',$fromGrade[$i])//test
        ->first();


        $office[$i] = DB::table('users')//users table
        ->join('promotionall', 'promotionall.empId', '=', 'users.empId')
        ->select('users.office')
        ->where('promotionall.id',$request->promotion_ids[$i])
        ->first();

        // if($i == 0){
        //     dd($office[$i]->office);
        // }


        // $promotionYear [$i] = 2023;
        // $promotionMonth [$i]= 'July';
        // $fromGrade [0]= 'B1';
        // $toGrade [0]= 'A2';
        // $fromGrade [1]= 'B3';
        // $toGrade [1]= 'A3';
        // $fromGrade [$i]= 'A2';
        // $toGrade [$i]= 'A1';
        // $tempBasic [$i]= 34860; //From users old basicPay
        // $newIncrement [$i]= 850; //New Increment of the latest grade A3
        // $newMinimum [$i]= 34085; //Minimum basicPay of new grade
        // $oldMaximum [$i]= 46485; //Maximum basicPay of Old grade
        

        if ($promotion[$i]->month == 1){
            $promotion[$i]->month = 'January';
            if($incrementCycle[$i]->incrementCycle == $promotion[$i]->month){
                
                $tempBasic[$i]->basicPay =  $tempBasic[$i]->basicPay + $oldIncrement [$i]->increment;
                // dd($tempBasic[$i]->basicPay);

                if($tempBasic[$i]->basicPay + $newIncrement[$i]->increment < $newMinimum[$i]->low) {
                    $newBasic[$i] = $tempBasic[$i]->basicPay;
                    // dd("hello");
                }
                else{
                   if($tempBasic[$i]->basicPay >  $oldMaximum[$i]->high){
                       $tempBasic[$i]->basicPay = $oldMaximum[$i]->high;
    
                } 
                   $diffPay[$i] = $tempBasic[$i]->basicPay - $newMinimum[$i]->low;
                   $noOfIncrement[$i]= 1 + round($diffPay[$i]/$newIncrement[$i]->increment);
                   $newBasic[$i] = $newMinimum[$i]->low + $newIncrement[$i]->increment * $noOfIncrement[$i];
                // dd("zoo");
                }

            }

            else{

                if($tempBasic[$i]->basicPay + $newIncrement[$i]->increment < $newMinimum[$i]->low) {
                    $newBasic[$i] = $tempBasic[$i]->basicPay;
                    // dd("hello");
                }
                else{
                   if($tempBasic[$i]->basicPay >  $oldMaximum[$i]->high){
                       $tempBasic[$i]->basicPay = $oldMaximum[$i]->high;
    
                } 
                   $diffPay[$i] = $tempBasic[$i]->basicPay - $newMinimum[$i]->low;
                   $noOfIncrement[$i]= 1 + round($diffPay[$i]/$newIncrement[$i]->increment);
                   $newBasic[$i] = $newMinimum[$i]->low + $newIncrement[$i]->increment * $noOfIncrement[$i];
                // dd("zoo");
                }

                
            }
        }
        

       





       

        $promotionAll = new Promotionduelist;
        if ($promotion[$i]->month == 1){
            $promotion[$i]->month = 'January';
            $promotionAll->promotionMonth = $promotion[$i]->month;

        }
        
         $promotionAll->promotionYear = $promotion[$i]->year;
         $promotionAll->empId = $empId[$i]->empId;//new added
         $promotionAll->fromGrade = $fromGrade[$i]->gradeId;
         $promotionAll->toGrade = $toGrade[$i];
         $promotionAll->oldBasic = $tempBasic[$i]->basicPay;
         $promotionAll->newBasic = $newBasic[$i];
         $promotionAll->office = $office[$i]->office;
         $promotionAll->save();
// dd($i);
         if([$i] == [$ids-1])
         return response()->json(['code'=>1, 'msg'=>'Data inserted into promotion duelist!!!']); 
         
        }
           
        //    dd( $date = date('Y') - 1,$date = date('Y'));
        }
        if($date = date('Y') == $promotion[$i]->year){
            if($promotion[$i]->month > 6)
            {
                // dd("July records");


                // $id[$i] = implode(' ',  $request->promotion_ids);
        $empId[$i] = DB::table('promotionall')//promotionall table(incrementall)
        ->select('empId')
        ->where('id',$request->promotion_ids[$i])
        ->first();
        // dd($empId[$i]->empId);

        $tempBasic[$i] = DB::table('users')//users table
        ->join('promotionall', 'promotionall.empId', '=', 'users.empId')
        ->select('users.basicPay')
        ->where('promotionall.id',$request->promotion_ids[$i])
        ->first();

        // dd($tempBasic[$i]->basicPay);


        // $fromGrade [$i]= DB::table('promotionall')//promotionall table
        // ->join('payscalemaster', 'payscalemaster.grade', '=', 'promotionall.grade')
        // // ->where('payscalemaster.id',$request->promotion_ids[$i])
        // ->select('payscalemaster.id')
        // ->first();

        // dd($fromGrade [$i]->grade);

        // $fromGrade [$i] = 7;
        // dd($fromGrade [$i]);

        $fromGrade[$i] = DB::table('users')//users table
        ->join('promotionall', 'promotionall.empId', '=', 'users.empId')
        ->select('users.gradeId')
        ->where('promotionall.id',$request->promotion_ids[$i])
        ->first();

        // if($i == 0){
        //     dd($fromGrade[$i]->gradeId);
        // }
        
        $toGrade [$i]= $fromGrade[$i]->gradeId - 1;
        // $toGrade [$i]= $fromGrade[$i] - 1;//test
        // dd($toGrade [$i]);


        // $toGradeIncrement [$i]= DB::table('payscalemaster')//promotionall table
        // ->where('id',$request->promotion_ids[$i])
        // ->select('grade')
        // ->first();

            // dd($toGrade[$i]);

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
        // ->where('payscalemaster.id','=',$fromGrade[$i])//test
        ->first();


        $office[$i] = DB::table('users')//users table
        ->join('promotionall', 'promotionall.empId', '=', 'users.empId')
        ->select('users.office')
        ->where('promotionall.id',$request->promotion_ids[$i])
        ->first();

        // if($i == 0){
        //     dd($office[$i]->office);
        // }


        // $promotionYear [$i] = 2023;
        // $promotionMonth [$i]= 'July';
        // $fromGrade [0]= 'B1';
        // $toGrade [0]= 'A2';
        // $fromGrade [1]= 'B3';
        // $toGrade [1]= 'A3';
        // $fromGrade [$i]= 'A2';
        // $toGrade [$i]= 'A1';
        // $tempBasic [$i]= 34860; //From users old basicPay
        // $newIncrement [$i]= 850; //New Increment of the latest grade A3
        // $newMinimum [$i]= 34085; //Minimum basicPay of new grade
        // $oldMaximum [$i]= 46485; //Maximum basicPay of Old grade
        if ($promotion[$i]->month == 7){
            $promotion[$i]->month = 'July';
            if($incrementCycle[$i]->incrementCycle == $promotion[$i]->month){
                
                $tempBasic[$i]->basicPay =  $tempBasic[$i]->basicPay + $oldIncrement [$i]->increment;

                if($tempBasic[$i]->basicPay + $newIncrement[$i]->increment < $newMinimum[$i]->low) {
                    $newBasic[$i] = $tempBasic[$i]->basicPay;
                    // dd("hello");
                }
                else{
                   if($tempBasic[$i]->basicPay >  $oldMaximum[$i]->high){
                       $tempBasic[$i]->basicPay = $oldMaximum[$i]->high;
    
                } 
                   $diffPay[$i] = $tempBasic[$i]->basicPay - $newMinimum[$i]->low;
                   $noOfIncrement[$i]= 1 + round($diffPay[$i]/$newIncrement[$i]->increment);
                   $newBasic[$i] = $newMinimum[$i]->low + $newIncrement[$i]->increment * $noOfIncrement[$i];
                // dd("zoo");
                }

            }

            else{

                if($tempBasic[$i]->basicPay + $newIncrement[$i]->increment < $newMinimum[$i]->low) {
                    $newBasic[$i] = $tempBasic[$i]->basicPay;
                    // dd("hello");
                }
                else{
                   if($tempBasic[$i]->basicPay >  $oldMaximum[$i]->high){
                       $tempBasic[$i]->basicPay = $oldMaximum[$i]->high;
    
                } 
                   $diffPay[$i] = $tempBasic[$i]->basicPay - $newMinimum[$i]->low;
                   $noOfIncrement[$i]= 1 + round($diffPay[$i]/$newIncrement[$i]->increment);
                   $newBasic[$i] = $newMinimum[$i]->low + $newIncrement[$i]->increment * $noOfIncrement[$i];
                // dd("zoo");
                }

                
            }
        }

       





       

        $promotionAll = new Promotionduelist;
      
        if($promotion[$i]->month == 7){
            $promotion[$i]->month = 'July';
            $promotionAll->promotionMonth = $promotion[$i]->month;
        }
         $promotionAll->promotionYear = $promotion[$i]->year;
         $promotionAll->empId = $empId[$i]->empId;//new added
         $promotionAll->fromGrade = $fromGrade[$i]->gradeId;
         $promotionAll->toGrade = $toGrade[$i];
         $promotionAll->oldBasic = $tempBasic[$i]->basicPay;
         $promotionAll->newBasic = $newBasic[$i];
         $promotionAll->office = $office[$i]->office;
         $promotionAll->save();

         if([$i] == [$ids-1]){          
         return response()->json(['code'=>1, 'msg'=>'Data inserted into promotion duelist!!!']); 
         }
                
            }
            // return response()->json(['code'=>1, 'msg'=>'Data inserted into promotion duelist!!!']); 

        }

        else{
            // dd("other year");
            if([$i] == [$ids-1]){
            return response()->json(['code'=>2, 'msg'=>'Not eligilble for promotion right now!!!']); 
            }
        }

        
        

    // dd($request->promotion_ids);
    // $id = implode(' ', $request->promotion_ids);
    // foreach ($request->promotion_ids as $id => $value){
    //     $tempBasic = 34860; //From payScale master old basicPay
    //     $newIncrement = 850; //New Increment of the latest grade A3
    //     $newMinimum = 34085; //Minimum basicPay of new grade
    //     $oldMaximum = 46485; //Maximum basicPay of Old grade
    //     if($tempBasic + $newIncrement < $newMinimum) {
    //         $newBasic = $tempBasic;
    //         // dd("hello");
    //     }
    //     else{
    //        if($tempBasic >  $oldMaximum){
    //            $tempBasic = $oldMaximum;
    //         //    dd("oops");

    //     } 
    //        $diffPay = $tempBasic - $newMinimum;
    //        $noOfIncrement= 1 + round($diffPay/$newIncrement);
    //        $newBasic = $newMinimum + $newIncrement * $noOfIncrement;
    //     // dd("zoo");
    //     }
    //     $empId = DB::table('countries')
    //     ->select('empId')
    //     ->where('id',$value)
    //     ->first();
    //     $grade = 'A2';
    //     // $basicPay = 50000;
    //     // DB::update('update countries set grade = ? where id = ?', [$grade, $value]);
    //     // DB::update('update users set basicPay = ? where empId = ?', [$newBasic, $empId->empId]);

    //     Guesthouse::updateOrCreate(['id' => $request->id],
    //         ['dzo_id' => $request->name, 'name' => $request->guesthouse]);

    }
    return response()->json(['code'=>1, 'msg'=>'Data inserted into promotion duelist!!!']); 
}
catch(\Illuminate\Database\QueryException $e){

    // if($promotion[$i]->promotionDueDate == null){

    //     return response()->json(['code'=>2, 'msg'=>'Promotion not eligible for some seleted employees!!!']); 

    // }

    return response()->json(['code'=>2, 'msg'=>'Promotion not eligible / Duplicate data entry!!!']); 


}

}

}


?>
