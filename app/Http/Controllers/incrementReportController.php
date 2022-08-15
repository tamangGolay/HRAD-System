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


    $name = DB::table('incrementduelist')
     ->join('viewincrementorder','viewincrementorder.empId','=','incrementduelist.empId')
       ->select('incrementduelist.*','viewincrementorder.designation','viewincrementorder.grade','viewincrementorder.empName')	
        // ->where('notesheet.id',$id)
        ->first();


      

        // $userName = DB::table('incrementduelist')
        
        // ->select('incrementduelist.*')
        // ->where('incrementduelist.status','=','Approved')
        // ->latest('incrementduelist.id')
        // ->get(); 

        $pdf = PDF ::loadView ('Increment.indexIncrement', array('increment'=>$increment,'name'=>$name));
        return $pdf->download ('increment.pdf');
    }
}

// $pdf = PDF ::loadView ('Notesheet.index', array('userName'=>$userName,'date'=>$date,'increment'=>$increment,'notesheetapprove'=>$notesheetapprove));
