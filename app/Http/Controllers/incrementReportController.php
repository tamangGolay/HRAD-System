<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Duelist;
use DB;

use PDF;
// use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;


class incrementReportController extends Controller
{
     public function createIncrementReport ($id) {


    $increment = Duelist::all()->where('id',$id);
    // $increment = Duelist::find($id);
    // $increment = Duelist::find($id);
    //For officeName in the report(pdf)
    // $date = DB::table('notesheet')
    //  ->join('officedetails','officedetails.id','=','notesheet.officeId')
    //    ->select('*')	
    //     ->where('notesheet.id',$id)
    //     ->first();

        // $userName = DB::table('incrementduelist')
        // ->select('incrementduelist.*')
        // ->where('incrementduelist.status','=','Approved')
        // ->latest('incrementduelist.id')
        // ->get(); 

        $pdf = PDF ::loadView ('Increment.indexIncrement', array('increment'=>$increment));
        return $pdf->download ('increment.pdf');
    }
}

// $pdf = PDF ::loadView ('Notesheet.index', array('userName'=>$userName,'date'=>$date,'increment'=>$increment,'notesheetapprove'=>$notesheetapprove));
