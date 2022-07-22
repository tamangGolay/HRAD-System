<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class ContributionReportController extends Controller
{
   
    function index(Request $request)
    {


      if(request()->ajax())
     {


      if(!empty($request->filter_startdate))
      {


      
// dd($request->filter_startdate);
       $data = DB::table('wfcontribution')
       ->join('officename','officename.id', 'wfcontribution.officeId')

       //  ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
       //  ->join('vehiclestatus', 'vehiclestatus.id', '=', 'vehiclerequest.status')
       //  ->join('vehicledetails', 'vehicledetails.id', '=', 'vehiclerequest.vehicleId')
 
         //  ->select('users.designation','vehiclerequest.emp_id','vname','orgunit.description','dateOfRequisition','vehiclerequest.id','start_date','end_date','vehicledetails.vehicle_name','purpose','placesToVisit', 'users.name','vehiclestatus.action')
 
         ->select('wfcontribution.*','officename.longOfficeName')
        ->where('wfcontribution.contributionDate','>=',$request->filter_startdate) 
        ->where('wfcontribution.contributionDate','<=',$request->filter_enddate) 

  

         ->get();
      }
      else
      {
       

       $data = DB::table('wfcontribution')
       ->join('officename','officename.id', 'wfcontribution.officeId')

       //  ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
       //  ->join('vehiclestatus', 'vehiclestatus.id', '=', 'vehiclerequest.status')
       //  ->join('vehicledetails', 'vehicledetails.id', '=', 'vehiclerequest.vehicleId')
       //MTO names
 
      
       ->select('wfcontribution.*','officename.longOfficeName')  

      // ->select('users.name','users.designation', 'vehiclerequest.id','vehiclerequest.purpose','vehiclerequest.placesToVisit','vehiclestatus.action','vehicledetails.vehicle_name','vehiclerequest.emp_id','vname','orgunit.description','dateOfRequisition','start_date','end_date')      
	     
    // ->where('vehiclerequest.status',3) 
    //  ->orwhere('vehiclerequest.status',4) 
    //  ->orwhere('vehiclerequest.status',5) 
      
	       
      ->get();
      }
      
      return datatables()->of($data)->make(true);
     }
    
    }
}

?>
