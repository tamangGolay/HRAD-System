<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\welfareRequest;
use App\welfarenoteapproval;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use PDF;
use App\Models\User;


class WelfareReportController extends Controller
{

     public function createWF_PDF ($id) {

    $welfareapprove = welfarenoteapproval::all()->where('welfareId',$id);
    $welfare = welfareRequest::find($id);

        $userName = DB::table('welfarenote')
        ->join('users','users.empId','=','welfarenote.createdBy')
        ->select('*')	
        ->where('welfarenote.id',$id)
        ->first();


        // Manually fetch empName for each $welfareapprove
        $welfareapproveSup = $welfareapprove->map(function ($approve) {
          $user = DB::table('users')->where('empId', $approve->modifier)->first();
          $approve->empName = $user ? $user->empName : ''; // Set empName or an empty string if not found
          return $approve;
      });
      
        
        $pdf = PDF ::loadView ('welfareNew.WFReport', array('userName'=>$userName,'welfare'=>$welfare,'welfareapprove'=>$welfareapprove,'welfareapproveSup'=>$welfareapproveSup));
        return $pdf->download ('WFreport.pdf');
    }

    }