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
      

     $structure=DB::select('call populateReportingStructure(?)',array($empId->empId));


    //   $promotion= DB::table('viewpromotionorder')
    //   ->join('promotioncopies','promotioncopies.empId','=','viewpromotionorder.empId')
    //  ->select('promotioncopies.copies','viewpromotionorder.*')  
    //  ->where('viewpromotionorder.empId',$empId->empId)
    //  ->orWhere('viewpromotionorder.officeId',$officeId->officeId)
    //   ->first();

      $promotion = promotionorder::all()->where('officeId',$officeId->officeId);

         $copy= DB::table('viewpromotionorder')
      ->join('promotioncopies','promotioncopies.empId','=','viewpromotionorder.empId')
     ->select('promotioncopies.copies')  
     ->where('viewpromotionorder.empId',$empId->empId)
     ->first();
 
     $scripts1 = explode(',', $copy->copies);
     $scripts = implode(',', $scripts1);  
     
 

  $grade=DB::table('viewpromotionorder')
  ->join('payscalemaster','payscalemaster.id','=','viewpromotionorder.newGrade')
 ->select('payscalemaster.grade')  
 ->where('viewpromotionorder.empId',$empId->empId)
 ->first();

 $year=DB::table('viewpromotionorder')
  ->select(DB::raw('Year(viewpromotionorder.promotionDate) AS promotionDate'))  
 ->where('viewpromotionorder.empId',$empId->empId)
 ->first();

 $gradeId=DB::table('viewpromotionorder')
->select('viewpromotionorder.newGrade')  
->where('viewpromotionorder.empId',$empId->empId)
->first();

$ceo = DB::table('officehead') 
->Where('officehead.officeId','=','1')
->select('officehead.HeadOfOffice','officehead.designation')  
->first();


$hrGM =DB::table('officehead') 
->Where('officehead.officeId','=','9')
->select('officehead.HeadOfOffice','officehead.designation')  
->first();


          $pdf = PDF ::loadView ('promotion.promotionindex', array('promotion'=>$promotion,
          'copy'=>$copy,'grade'=>$grade ,'year'=>$year,'gradeId'=>$gradeId,
          'ceo'=>$ceo,'hrGM'=>$hrGM,'scripts'=>$scripts,
        ));
          return $pdf->download ('promotion.pdf');
      }
}