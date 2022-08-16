<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Duelist;
use DataTables;
use App\promotionorder;

use DB;

use PDF;
// use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;


class promotionReportController extends Controller
{
  public function index(Request $request)
  {


   $promotion = DB::table('viewpromotionorder')
  // ->join('viewincrementorder','viewincrementorder.empId','=','incrementhistorymaster.empId')
    ->select('viewpromotionorder.*')

  // ->select('incrementduelist.*','users.empName')
  // ->where('incrementduelist.status','=','Approved')
  // ->latest('incrementduelist.id')
       ->get(); 

   if ($request->ajax()) {              
       $data = $promotion;           

       return Datatables::of($data)

               ->addIndexColumn()

              //  ->addColumn('checkbox', function($row){  
                                               
              //              return '<input type="checkbox" name="update_checkbox" data-id=" '.$row->id.'"><label></label>';
              //          })

            //   ->addColumn('action', function($row){

            //   $btn = '<a href="incrementReport/{{$increment->id}}" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm edit">Download</a>&nbsp;&nbsp;&nbsp;&nbsp';
            //   // $btn = $btn .'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" id="deleteraincoat" data-original-title="Delete" class="btn btn-outline-danger btn-sm deleteraincoat">Delete</a>';

            //   return $btn;
            // })

            ->addColumn('checkbox', function($row){                                                      
              return '<input type="checkbox" name="update_checkbox" data-id=" '.$row->id.'"><label></label>';
          })

          ->rawColumns(['action','checkbox'])
          ->make(true);
             }   
   return view('promotion.promotionReport');

  }

  public function createIncrementReport (Request $request){

   
     $ids = count($request->update_ids);
    //  dd($ids);
    for($i = 0; $i < $ids; ++$i){
  
      $promotion[$i] = promotionorder::all()
                      ->where('id',$request->update_ids[$i]);      
                          
                       
          $pdf[$i] = PDF ::loadView ('promotion.promotionindex', array('promotion'=>$promotion[$i]));
          return $pdf[$i]->download ('promotion.pdf');
      }
    }

  }
 