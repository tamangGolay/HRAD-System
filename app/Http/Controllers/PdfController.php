<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\notesheetRequest;
use App\notesheetapprove;
use App\promotionorder;
use DB;

use PDF;
// use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;


class PdfController extends Controller
{
     public function createPDF ($id) {


    $notesheetapprove = notesheetapprove::all()->where('noteId',$id);
    $notesheet = notesheetRequest::find($id);
    //For officeName in the report(pdf)
    $date = DB::table('notesheet')
     ->join('officedetails','officedetails.id','=','notesheet.officeId')
       ->select('*')	
        ->where('notesheet.id',$id)
        ->first();

        $userName = DB::table('notesheet')
        ->join('users','users.empId','=','notesheet.createdBy')
       ->select('*')	
        ->where('notesheet.id',$id)
        ->first();

        $pdf = PDF ::loadView ('Notesheet.index', array('userName'=>$userName,'date'=>$date,'notesheet'=>$notesheet,'notesheetapprove'=>$notesheetapprove));
        return $pdf->download ('notesheet.pdf');
    }

    public function createpromotionPDF ($id) {
      


      $officeId = DB::table('viewpromotionorder')
      ->select('officeId') 
      ->where('id',$id)
     ->first();

     $empId= DB::table('viewpromotionorder')
     ->select('viewpromotionorder.empId')  
     ->where('id',$id)
      ->first();
      

     $promotion=DB::select('call populateReportingStructure(?)',array($empId->empId));

      $promotion = promotionorder::all()->where('officeId',$officeId->officeId);
      
  
          $pdf = PDF ::loadView ('promotion.promotionindex', array('promotion'=>$promotion));
          return $pdf->download ('promotion.pdf');
      }
}