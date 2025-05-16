<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class conferenceReportController extends Controller
{
   
    function index(Request $request)
    {
      //After the date is entered it will come as ajax request and fetch the data
     if(request()->ajax())
     {

      if(!empty($request->filter_startdate))
      {
      
      
        $review = DB::table('conferencerequest')
        ->join('officedetails', 'officedetails.id', '=', 'conferencerequest.office_Id')       
        ->join('conference', 'conference.id', '=', 'conferencerequest.conference_id')
        ->join('conferencestatus', 'conferencestatus.ids', '=', 'conferencerequest.status')

         ->select('conferencerequest.id', 'emp_id', 'name','conferencestatus.state','contact_number','conference.Conference_Name', 'conferencerequest.conference_id', 'officeDetails', 'meeting_name', 'start_date', 'end_date')
            
         ->where('start_date','>=',$request->filter_startdate)
         ->where('end_date','<=',$request->filter_enddate)
         ->where('conferencerequest.id','>', 7)
         ->latest('conferencerequest.id'); 
        // ->get();
         
      }
      //When the report page loads 
      else
      {
       
        $review = DB::table('conferencerequest')     
        ->join('officedetails', 'officedetails.id', '=', 'conferencerequest.office_Id')
        ->join('conference', 'conference.id', '=', 'conferencerequest.conference_id')
        ->join('conferencestatus', 'conferencestatus.ids', '=', 'conferencerequest.status')

       ->select('conferencerequest.id', 'emp_id', 'name','conferencestatus.state', 'contact_number', 'conference.Conference_Name', 'conferencerequest.conference_id', 'officeDetails', 'meeting_name', 'start_date', 'end_date')
        ->where('conferencerequest.id','>', 7)
        ->latest('conferencerequest.id');
       
      }
      return datatables()->of($review)->make(true);
     }
    
    }
}

?>