<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WfReleaseProcess;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use DB;
use Auth;

class PaymentReleaseController extends Controller
{

    public function paymentRelease(Request $request)
    {
         
        try
         {
            $Request_payment = new WfReleaseProcess;
            $Request_payment->empId = $request->empId;
            $Request_payment->requestDate = $request->requestDate;
            $Request_payment->amount = $request->amount;
            $Request_payment->reason = $request->reason;
            $Request_payment->deathOf = $request->relation;                 
            $Request_payment->save();       
        
            return redirect('home')
                ->with('success', 'You have requested for welfare release payment!');

        }  //try end
       
     catch(\Illuminate\Database\QueryException $e)
     {

          return redirect('home')
                ->with('error', 'Cannot leave the fields empty');

         }

    }

    public function welfareReview(Request $request)
    {
        // dd("here");

         if($request->empId == 30003084){//member1

            if($request->status == "request"){

                dd("recommended");

            $member1Action = "recommended";
            $status = "under process";

            DB::update('update wfreleaseprocess set member1Id = ? where id = ?', [$request->empId, $request->id]);
            DB::update('update wfreleaseprocess set member1Action = ? where id = ?', [$member1Action, $request->id]);
            DB::update('update wfreleaseprocess set member1ActionDate = ? where id = ?', [$request->welfareReviewDate, $request->id]);
            DB::update('update wfreleaseprocess set status = ? where id = ?', [$status, $request->id]);

            dd("Okay");
            $email = ['title' => 'Mail From the HRIS System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a promotion list for ', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => '','body5' => '','body6' => '', ];
                Mail::to('nimawtamang@bpc.bt') //member 2
                        ->send(new MyTestMail($email)); 
            }

            if($request->status == "rejected"){
                dd("m1Reject");

                $email = ['title' => 'Mail From the HRIS System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a promotion list for ', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => '','body5' => '','body6' => '', ];
                Mail::to('nimawtamang@bpc.bt') //company Secretary
                        ->send(new MyTestMail($email)); 

            }
        }

        if($request->empId == 30002953){//member2

            if($request->status == "request"){
                dd("m2recommended");



            $member2Action = "recommended";
            $status = "pending";

            DB::update('update wfreleaseprocess set member2id = ? where id = ?', [$request->empId, $request->id]);
            DB::update('update wfreleaseprocess set member2Action = ? where id = ?', [$member2Action, $request->id]);
            DB::update('update wfreleaseprocess set member2ActionDate = ? where id = ?', [$request->welfareReviewDate, $request->id]);
            DB::update('update wfreleaseprocess set status = ? where id = ?', [$status, $request->id]);

            $email = ['title' => 'Mail From the HRIS System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a promotion list for ', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => '','body5' => '','body6' => '', ];
            Mail::to('') //chair
                    ->send(new MyTestMail($email)); 
            }
            if($request->status == "rejected"){

                dd("m2Reject");


                $email = ['title' => 'Mail From the HRIS System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a promotion list for ', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => '','body5' => '','body6' => '', ];
                Mail::to('nimawtamang@bpc.bt') //company Secretary
                        ->send(new MyTestMail($email));

            }
        }

        if($request->empId == 30002940){//ceo

            if($request->status == "request"){


            $chairAction = "approved";
            $status = "approved";

            DB::update('update wfreleaseprocess set chairEmpId = ? where id = ?', [$request->empId, $request->id]);
            DB::update('update wfreleaseprocess set chairAction = ? where id = ?', [$chairAction, $request->id]);
            DB::update('update wfreleaseprocess set chairActionDate = ? where id = ?', [$request->welfareReviewDate, $request->id]);
            DB::update('update wfreleaseprocess set status = ? where id = ?', [$status, $request->id]);
            // dd("ahem");

            // $email = ['title' => 'Mail From the HRIS System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a promotion list for ', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => '','body5' => '','body6' => '', ];
            // Mail::to('') //secretary
            //         ->send(new MyTestMail($email)); 

            $empId = DB::table('wfreleaseprocess')
            ->select('wfreleaseprocess.empId')
            ->where('wfreleaseprocess.id',$request->id)
            ->first();
            $amount = DB::table('wfreleaseprocess')
            ->select('wfreleaseprocess.amount')
            ->where('wfreleaseprocess.id',$request->id)
            ->first();

            $reason = DB::table('wfreleaseprocess')
            ->select('wfreleaseprocess.reason')
            ->where('wfreleaseprocess.id',$request->id)
            ->first();

                    
                    
            $Request_payment = new WfReleaseProcess;
            $Request_payment->empId = $empId->empId;
            $Request_payment->requestDate = $request->welfareReviewDate;
            $Request_payment->amount = $amount->amount;
            $Request_payment->reason = $reason->reason;
            $Request_payment->save();  

            dd("approve");

            }
            
        if($request->status == "rejected"){
                dd("chairReject");

            $email = ['title' => 'Mail From the HRIS System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a promotion list for ', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => '','body5' => '','body6' => '', ];
            Mail::to('nimawtamang@bpc.bt') //company Secretary
                    ->send(new MyTestMail($email));
        }

        }

    }   

}

    

