<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Duelist;
use DataTables;
use App\IncrementView;

use DB;

use PDF;
// use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;


class incrementReportController extends Controller
{
  public function index(Request $request)
  {


   $increment = DB::table('viewincrementorder')
  // ->join('viewincrementorder','viewincrementorder.empId','=','incrementhistorymaster.empId')
    ->select('viewincrementorder.*')

  // ->select('incrementduelist.*','users.empName')
  // ->where('incrementduelist.status','=','Approved')
  // ->latest('incrementduelist.id')
       ->get(); 

   if ($request->ajax()) {              
       $data = $increment;           

       return Datatables::of($data)

               ->addIndexColumn()

              //  ->addColumn('checkbox', function($row){  
                                               
              //              return '<input type="checkbox" name="update_checkbox" data-id=" '.$row->id.'"><label></label>';
              //          })

              ->addColumn('action', function($row){

              $btn = '<a href="incrementReport/{{$increment->id}}" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm edit">Download</a>&nbsp;&nbsp;&nbsp;&nbsp';
              // $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteraincoat" data-original-title="Delete" class="btn btn-outline-danger btn-sm deleteraincoat">Delete</a>';

              return $btn;
            })
                       ->rawColumns(['action'])
                       ->make(true);
                     }    
   return view('Increment.incrementsReport');

  }

    public function createIncrementReport ($id) {


    $increment = IncrementView::all()->where('id',$id);
      
    $increment = DB::table('viewincrementorder')

         //->join('viewincrementorder','viewincrementorder.empId','=','incrementduelist.empId')
            ->join('incrementhistorymaster','incrementhistorymaster.personalNo','=','viewincrementorder.empId')
            
          // ->select('incrementduelist.*','viewincrementorder.designation','viewincrementorder.grade','viewincrementorder.empName')	
            ->select('viewincrementorder.id','viewincrementorder.officeAddress','viewincrementorder.longOfficeName','viewincrementorder.empId','viewincrementorder.empName','viewincrementorder.oldBasic','viewincrementorder.newBasic','viewincrementorder.increment','incrementhistorymaster.createdOn',DB::raw('Year(incrementDate) AS incrementDate'))	

        // ->where('incrementduelist.id',$id)
        ->first();          

        $pdf = PDF ::loadView ('Increment.indexIncrement', array('increment'=>$increment));
        return $pdf->download ('increment.pdf');
    }
}

// $pdf = PDF ::loadView ('Notesheet.index', array('userName'=>$userName,'date'=>$date,'increment'=>$increment,'notesheetapprove'=>$notesheetapprove));
