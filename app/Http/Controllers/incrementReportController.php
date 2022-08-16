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
  // // ->join('viewincrementorder','viewincrementorder.empId','=','incrementhistorymaster.empId')
  //   ->select('viewincrementorder.*')

    ->join('incrementhistorymaster','incrementhistorymaster.personalNo','=','viewincrementorder.empId')
    ->join('incrementall','incrementall.empId','=','viewincrementorder.empId')
    ->select('viewincrementorder.*','incrementhistorymaster.createdOn','incrementall.incrementCycle',DB::raw('Year(viewincrementorder.incrementDate) AS incrementDate'))	
    ->first();  
    

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

          //   ->addColumn('checkbox', function($row){                                                      
          //     return '<input type="checkbox" name="update_checkbox" data-id=" '.$row->id.'"><label></label>';
          // })

          ->rawColumns(['action','checkbox'])
          ->make(true);
             }   
   return view('Increment.incrementReport');

  }

  public function createIncrementReport ($id){

    // dd($request->all());

    //  $ids = $request->update_ids; 
    //  $ids = count($request->update_ids);
    // //  dd($ids);
    // for($i = 0; $i < $ids; ++$i){

      // $products = Product::where('user_id', $user_id->id)->get();

  
      $increment1 = DB::table('viewincrementorder')
        ->select('*')	
         ->where('id',$id)
         ->first();
                      
      $officeId = DB::table('viewincrementorder')//promotionall table(incrementall)
     ->select('officeId')
     ->where('id',$id)
     ->first();


    $increment = IncrementView::all()
                      ->where('officeId', $officeId->officeId); 
                          
                       
          $pdf = PDF ::loadView ('Increment.indexIncrement', array('increment'=>$increment,'increment1'=>$increment1));
          return $pdf->download ('increment.pdf');
      }
    }

  