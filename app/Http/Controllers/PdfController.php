<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\notesheetRequest;
use App\notesheetapprove;
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
}