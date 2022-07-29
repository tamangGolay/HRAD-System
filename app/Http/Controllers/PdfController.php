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
    $notesheet = DB::table('notesheet1')
     ->join('officedetails','officedetails.id','=','notesheet1.officeId')
     ->join('users','users.empId','=','notesheet1.createdBy')
       ->select('notesheet1.*','users.empName')	
        ->where('notesheet1.id',$id)
        ->first();

        $userName = DB::table('notesheet1')
        ->join('users','users.empId','=','notesheet1.createdBy')
       ->select('*')	
        ->where('notesheet1.id',$id)
        ->first();

        $pdf = PDF ::loadView ('Notesheet.index', array('userName'=>$userName,'notesheet'=>$notesheet,'notesheetapprove'=>$notesheetapprove));
        return $pdf->download ('notesheet.pdf');
    }
}