<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Promotionduelist;
use App\promotionRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use DB;
use Auth;

class PromotionReviewController extends Controller
{
    public function recommendpromotion(Request $request){

          // dd($request);
        // try{
            
            if($request->status == "Recommended" ){  
                $id = DB::table('promotionduelist')->select('id')
                ->where('id',$request->id)
                ->first();   

                promotionRequest::updateOrCreate(['id' => $id->id],
                ['status' =>$request->status]); 
                        
                return redirect('home')->with('success','You have recommended the employee for Promotion');
                }

              if($request->status2 == "Rejected" ){  //&& $request->remarks != ''
                  $id = DB::table('promotionduelist')->select('id')
                  ->where('id',$request->id)
                  ->first();   
  
                  promotionRequest::updateOrCreate(['id' => $id->id],
                  ['status' =>$request->status2, 'rejectReason' =>$request->remarks2]); 
                          
                  return redirect('home')->with('error','You have rejected the Promotion'); 
                  }           
                else{
                    return redirect('home')->with('error','Recommendation could not proceed');  
                }         
        }
        


public function GMrecommendpromotion(Request $request) 
  {
    //  dd($request);


    if($request->status == "Proposed" ){  //&& $request->remarks != ''

        
        $id = DB::table('promotionduelist')->select('id')
        ->where('id',$request->id)
        ->first();


        Promotionduelist::updateOrCreate(['id' => $id->id],
        ['status' =>$request->status]); 

        return redirect('home')->with('success','You have recommended the promotion');
        
    }

    if($request->status2 == "Rejected" ){  //&& $request->remarks != ''
      $id = DB::table('promotionduelist')->select('id')
      ->where('id',$request->id)
      ->first();   

      promotionRequest::updateOrCreate(['id' => $id->id],
      ['status' =>$request->status2,'rejectReason' =>$request->rejectreason]); 
              
      return redirect('home')->with('success','You have Rejected the Promotion');
    }
    else{
       return redirect('home')->with('Sorry','Recommendation Failed');  
    }


  }

  public function directorrecommendpromotion(Request $request) 
  {
   
     if($request->status == "DirRecommend" ){  //&& $request->remarks != ''
         $id = DB::table('promotionduelist')->select('id')
         ->where('id',$request->id)
         ->first();   
     
         promotionRequest::updateOrCreate(['id' => $id->id],
         ['status' =>$request->status]); 
                 
         return redirect('home')->with('success','You have recommended the Promotion');
         }

         if($request->status2 == "Rejected"){
                     $id = DB::table('promotionduelist')->select('id')
                     ->where('id',$request->id)
                     ->first();  
                 
                     promotionRequest::updateOrCreate(['id' => $id->id],
                     ['status' =>$request->status2, 'rejectReason' =>$request->remarks2]);//emp_id is from input name
            
                 return redirect('home')->with('error','You have rejected the Promotion');    
             }
 
             else{
                 return redirect('home')->with('error','You cannot leave the remarks field empty test!!');  
             }
          
 
   }  

}
