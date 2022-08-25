<?php
         
namespace App\Http\Controllers;
          
use App\jobDescription;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use  App\User;
        
class Manage_jobDescriptionReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)  //pull the data in the front
    {

       
       
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


$approvedBy= Auth::user()->empId;
$status = 1;
$date  = $request->approvedOn;



$jobReview = new jobDescription;
$jobReview->empId = $request->emp_id;
$jobReview->empName = $request->empName;
$jobReview->jobDescription = $request->jobdescription;               
$jobReview->createdOn = $request->createdDate;
$jobReview->officeId = $request->officeId;
$jobReview->approvedOn = $date;
$jobReview->createdBy = $approvedBy;
$jobReview->approvedBy = $approvedBy;
$jobReview->approvedOn = $date;
$jobReview->status = $status;
//$jobReview->dateExpired = $request->createdDate;
$jobReview->save();  

// jobDescription::Create(['empId' => $request->emp_id],  [
//     'jobDescription' => $request->jobdescription, 
//     'createdOn' => $request->createdDate,
//     'createdBy' => $approvedBy, 
//     'officeId' => $request->officeId,
//      'approvedOn' => $date,
//      'approvedBy' => $approvedBy,
//     'dateExpired' => $request->createdDate,
// ]);        

     //DB::update('update jobdescription set jobDescription = ? where id = ?', [$request->jobdescription,$request->id]);
     //DB::update('update jobdescription set status = ? where id = ?', [$status,$request->id]);
    //  DB::update('update jobdescription set approvedOn = ? where id = ?', [$date,$request->id]);
     DB::update('update jobdescription set dateExpired = ? where id = ?', [$request->createdDate,$request->id]);




      
 return response()->json(['success'=>'Updated successfully.']);


    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     
        $conference = jobDescription::find($id);
        return response()->json($conference);
    }
  
    /**empName
     * Remove the specified resource from storage.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {

      
       
    }

    //To redirect to the manage_increment page after the management of increment
    public function message(Request $request)
    {

        return redirect('home')->with('page', 'jobDescriptionReview');
    }

}