<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class PantReportController extends Controller
{
   
    function index(Request $request)
    {


      if(request()->ajax())
     {


      if(!empty($request->filter_startdate))
      {

// dd($request);
      $data = DB::table('employeeuniform')
      ->join('officedetails','officedetails.id', 'employeeuniform.officeId')
      ->join('users','users.empId', 'employeeuniform.empId')
      ->join('pantmaster','pantmaster.id','=','employeeuniform.pant')
      ->join('shirtmaster','shirtmaster.id','=','employeeuniform.shirt')
      ->select('shirtmaster.shirtSizeName','employeeuniform.shirt','users.empName','pantmaster.pantSizeName','employeeuniform.empId','employeeuniform.id as pantId','employeeuniform.pant','officedetails.longOfficeName')  
      ->where('employeeuniform.officeId',$request->filter_startdate)
      // ->where('employeeuniform.pant',$request->filter_enddate)
      // ->orWhere('employeeuniform.shirt',$request->filter_enddate)

      ->get();
      }
      else
      {
       

       $data = DB::table('employeeuniform')
       ->join('officedetails','officedetails.id', 'employeeuniform.officeId')
       ->join('users','users.empId', 'employeeuniform.empId')
       ->join('pantmaster','pantmaster.id','=','employeeuniform.pant')
       ->join('shirtmaster','shirtmaster.id','=','employeeuniform.shirt')
       ->select('shirtmaster.shirtSizeName','employeeuniform.shirt','users.empName','pantmaster.pantSizeName','employeeuniform.empId','employeeuniform.id as pantId','employeeuniform.pant','officedetails.longOfficeName')  
  
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
