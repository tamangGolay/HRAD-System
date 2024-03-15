<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\welfareRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use App\notesheetapprove;
use DB;
use Auth;

class WelfareNewController extends Controller
{
    public function Request_welfare(Request $request)
    {
        $member1Mail= DB::table('welfarecommitte')  
        ->select('welfarecommitte.memberEmail')
        ->where( 'memberType','=','Member 1')
        ->first();

        $member1MailContent = ['title' => 'Mail From the HRIS Welfare System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for welfare form approval with topic: <b>' .$request->topicWelfare. '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: http://hris.bpc.bt', 'body5' => '','body6' => '', ];

            $Request_welfare = new welfareRequest;           //database name n user input name
            $Request_welfare->createdBy = $request->empId;     
            $Request_welfare->emailId = $request->emailId;                           
            $Request_welfare->topic = $request->topicWelfare;             
            $Request_welfare->justification = $request->justification;            
            $Request_welfare->save(); 

            // dd($member1Mail->memberEmail);
            Mail::to($member1Mail->memberEmail) 
            ->send(new MyTestMail($member1MailContent));

            return redirect('home')->with('success', 'Welfare Request Form submitted successfully');

         }

         public function welfareStatusReview()
         {
         
          $welfareStatusReview= DB::table('welfarenote')  
            ->where('createdBy',Auth::user()->empId)
            ->where('cancelled', '=', 'No')         
            ->select('*')
                                             
            ->latest('welfarenote.id') //similar to orderby('welfarenote.id','desc')            
            ->paginate(1000);
         
         $rhtml = view('welfareNew.welfareselfreview')->with(['welfareStatusReview' => $welfareStatusReview])->render();
         
         return response()
           ->json(array(
           'success' => true,
           'html' => $rhtml
         ));
         }

            public function cancelWelfare(Request $request)
            {
                DB::update('update welfarenote set cancelled = ? where id = ?', [$request->cancelled, $request->id]);       
                return redirect('home')->with('error','You have cancelled the Welfare Request!');   
            }
    }