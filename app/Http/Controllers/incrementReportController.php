<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Duelist;
use DataTables;
use App\IncrementView;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;

use DB;

use PDF;
// use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;


class incrementReportController extends Controller
{
  public function index(Request $request)
  {


   $increment = DB::table('viewincrementorder')
  

    ->join('incrementhistorymaster','incrementhistorymaster.personalNo','=','viewincrementorder.empId')
    ->join('incrementall','incrementall.empId','=','viewincrementorder.empId')
    ->select('viewincrementorder.*','incrementhistorymaster.createdOn','incrementall.incrementCycle',DB::raw('Year(viewincrementorder.incrementDate) AS incrementDate'))	
    ->first();  
    

   if ($request->ajax()) {              
       $data = $increment;           

       return Datatables::of($data)

               ->addIndexColumn()
              ->addColumn('action', function($row){

              $btn = '<a href="incrementReport/{{$increment->id}}" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-info btn-sm edit">Download</a>&nbsp;&nbsp;&nbsp;&nbsp';
              
              return $btn;
            })

        
          ->rawColumns(['action','checkbox'])
          ->make(true);
             }   
   return view('Increment.incrementReport');

  }

  public function createIncrementReport ($id){

     
      $officeId = DB::table('viewincrementorder')//promotionall table(incrementall)
      ->select('officeId')
      ->where('id',$id)
      ->first();

      $empId = DB::table('viewincrementorder')//promotionall table(incrementall)
      ->select('empId')
      ->where('id',$id)
      ->first();

      $officeAddress = DB::table('viewincrementorder')//promotionall table(incrementall)
      ->join('officedetails','officedetails.id','=','viewincrementorder.officeId')
      ->select('officedetails.officeDetails')
      ->where('viewincrementorder.officeId','=',$officeId->officeId)
      ->first();

    
 
      $headDesignation = DB::table('officehead')
      ->join('viewincrementorder','viewincrementorder.officeId','=','officehead.OfficeId')
        ->select('officehead.designation')
         ->where('officehead.OfficeId', '=',$officeId->officeId)
         ->first();

      $GmName = DB::table('users')
         ->select('users.empName')
         ->whereIn('users.empId', function($query){
          $query->from('officemaster')
          ->select('officemaster.officeHead')
              ->where('officemaster.id', 9);
              })->first();

      $PiadDesignation = DB::table('designationmaster')
                  ->join('users','designationmaster.id','=','users.designationid')
                    ->select('designationmaster.desisnamelong')
                    // ->where('users.designationid', '=', 'designationmaster.id')
                    ->where('users.empid', '=', function($query){
                      $query->from('officemaster')
                      ->select('officemaster.officehead')
                      ->where('officemaster.id', '=', 75);
                    })
                    ->first();


      $increment1 = DB::table('viewincrementorder')
      ->join('incrementall','incrementall.empId','=','viewincrementorder.empId')
        ->select('viewincrementorder.*','incrementall.incrementCycle',DB::raw('Year(viewincrementorder.incrementDate) AS incrementDate'))
        // ->select('*')	
         ->where('viewincrementorder.id',$id)
         ->first();
                      
    

    $increment = IncrementView::all()
                      ->where('officeId', $officeId->officeId); 
                          
                      $pdf = PDF ::loadView ('Increment.indexIncrement', array('increment'=>$increment,
          
                      'increment1'=>$increment1,'headDesignation'=>$headDesignation,'GmName'=>$GmName,
                      'officeAddress'=>$officeAddress,'PiadDesignation'=>$PiadDesignation
                    
                    ));
    //email
    $userDetail= DB::table('users') 
    ->join('officedetails', 'officedetails.id', '=', 'users.office')
    ->select('users.*','officedetails.longOfficeName')
    ->where( 'users.empId',$empId->empId)
    ->first();

    $OfficeHead = DB::table('employeesupervisor')
        ->join('viewincrementorder','viewincrementorder.empId','=','employeesupervisor.employee')
        ->select('employeesupervisor.emailId')
        ->where('employeesupervisor.employee',$empId->empId)
         ->first();

    $PiadEmail = DB::table('users')
         ->select('users.emailId')
         ->where('users.empid', '=', function($query){
          $query->from('officemaster')
          ->select('officemaster.officehead')
          ->where('officemaster.id', '=', 75);
        })
        ->first();

    $HrAdmin = DB::table('users')
          ->select('users.emailId')
           ->where('users.office', $officeId->officeId)
          //  ->where('users.empId',$empId->empId)
          ->where('users.role_id',8)
           ->first();
   

        if($HrAdmin == null){
         

            $email = ['title' => 'Mail From the HRIS System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a increment list for ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'http://hris.bpc.bt/incrementReport1/'.$id. '.','body5' => '','body6' => '', ];
                                    Mail::to('nimawtamang@bpc.bt') 
 
                    ->send(new MyTestMail($email)); 
          }

          else{
            

              $email = ['title' => 'Mail From the HRIS System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a increment list for ' .$userDetail->longOfficeName . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' =>'http://hris.bpc.bt/incrementReport1/'.$id. '.','body5' => '','body6' => '', ];

                Mail::to('nimawtamang@bpc.bt') 


               
                    ->send(new MyTestMail($email)); 

          }
    //email end

    return $pdf->download ('increment.pdf');

    return redirect('home')->with('page', 'incrementReport')
    ->with('success','Mail has been sent!!!!');

      }


      public function createIncrementReport1 ($id){

        // $products = Product::where('user_id', $user_id->id)->get();
        $officeId = DB::table('viewincrementorder')//promotionall table(incrementall)
        ->select('officeId')
        ->where('id',$id)
        ->first();
  
        $empId = DB::table('viewincrementorder')//promotionall table(incrementall)
        ->select('empId')
        ->where('id',$id)
        ->first();
  
        $officeAddress = DB::table('viewincrementorder')//promotionall table(incrementall)
        ->join('officedetails','officedetails.id','=','viewincrementorder.officeId')
        ->select('officedetails.officeDetails')
        ->where('viewincrementorder.officeId',$officeId->officeId)
        ->first();
  
   
        $headDesignation = DB::table('officehead')
        ->join('viewincrementorder','viewincrementorder.officeId','=','officehead.OfficeId')
          ->select('officehead.designation')
           ->where('officehead.officeId', $officeId->officeId)
           ->first();
  
        $GmName = DB::table('users')
           ->select('users.empName')
           ->whereIn('users.empId', function($query){
            $query->from('officemaster')
            ->select('officemaster.officeHead')
                ->where('officemaster.id', 9);
                })->first();
  
        $PiadDesignation = DB::table('designationmaster')
                    ->join('users','designationmaster.id','=','users.designationid')
                      ->select('designationmaster.desisnamelong')
                      // ->where('users.designationid', '=', 'designationmaster.id')
                      ->where('users.empid', '=', function($query){
                        $query->from('officemaster')
                        ->select('officemaster.officehead')
                        ->where('officemaster.id', '=', 75);
                      })
                      ->first();
  
  
        $increment1 = DB::table('viewincrementorder')
        ->join('incrementall','incrementall.empId','=','viewincrementorder.empId')
          ->select('viewincrementorder.*','incrementall.incrementCycle',DB::raw('Year(viewincrementorder.incrementDate) AS incrementDate'))
          // ->select('*')	
           ->where('viewincrementorder.id',$id)
           ->first();
                        
      
  
      $increment = IncrementView::all()
                        ->where('officeId', $officeId->officeId); 
                            
                        $pdf = PDF ::loadView ('Increment.indexIncrement', array('increment'=>$increment,
            
                        'increment1'=>$increment1,'headDesignation'=>$headDesignation,'GmName'=>$GmName,
                        'officeAddress'=>$officeAddress,'PiadDesignation'=>$PiadDesignation
                      
                      ));
      //email
      $userDetail= DB::table('users') 
      ->join('officedetails', 'officedetails.id', '=', 'users.office')
      ->select('users.*','officedetails.longOfficeName')
      ->where( 'users.empId',$empId->empId)
      ->first();
  
      $OfficeHead = DB::table('employeesupervisor')
          ->join('viewincrementorder','viewincrementorder.empId','=','employeesupervisor.employee')
          ->select('employeesupervisor.emailId')
          ->where('employeesupervisor.employee',$empId->empId)
           ->first();
  
      $PiadEmail = DB::table('users')
           ->select('users.emailId')
           ->where('users.empid', '=', function($query){
            $query->from('officemaster')
            ->select('officemaster.officehead')
            ->where('officemaster.id', '=', 75);
          })
          ->first();
  
      $HrAdmin = DB::table('users')
            ->select('users.emailId')
             ->where('users.office', $officeId->officeId)
            //  ->where('users.empId',$empId->empId)
            ->where('users.role_id',8)
             ->first();
    
  
    return $pdf->download ('increment.pdf');

    
  
        }
    }

  