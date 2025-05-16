<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class VehicleReportController extends Controller
{
   
    function index(Request $request)
    {     

     if(request()->ajax())
     {

      if(!empty($request->filter_startdate))
      {    
        $data = DB::table('vehiclerequest')
        ->join('officedetails', 'officedetails.id', '=', 'vehiclerequest.office_id')
          ->join('vehicledetails', 'vehicledetails.id', '=', 'vehiclerequest.vehicleId')
          ->join('users', 'users.id', '=', 'vehiclerequest.supervisor')  
          ->join('designationmaster', 'designationmaster.id', '=', 'users.designationId')
      
          ->where('vehiclerequest.status', '=', 'MTO Approved')
          ->where('start_date','>=',$request->filter_startdate)
          ->where('end_date','<=',$request->filter_enddate)
            ->select(
            'vehiclerequest.id',
            'vehiclerequest.emp_id',
             'vehiclerequest.vname',
            'officedetails.officeDetails',
            'vehiclerequest.dateOfRequisition',
            'vehiclerequest.start_date',
            'vehiclerequest.end_date',
            'vehicledetails.vehicle_name',
            'vehiclerequest.purpose',
            'vehiclerequest.placesToVisit',
            'users.empName',
            'designationmaster.desisNameLong',
            'vehiclerequest.status'
        )     

         ->get();
      }
      else
      {
       

     $data = DB::table('vehiclerequest')
     ->join('officedetails', 'officedetails.id', '=', 'vehiclerequest.office_id')
      ->join('vehicledetails', 'vehicledetails.id', '=', 'vehiclerequest.vehicleId')
      ->join('users', 'users.id', '=', 'vehiclerequest.supervisor')  
      ->join('designationmaster', 'designationmaster.id', '=', 'users.designationId')
   
       ->where('vehiclerequest.status', '=', 'MTO Approved')
      
        ->select(
            'vehiclerequest.id',
            'vehiclerequest.emp_id',
             'vehiclerequest.vname',
            'officedetails.officeDetails',
            'vehiclerequest.dateOfRequisition',
            'vehiclerequest.start_date',
            'vehiclerequest.end_date',
            'vehicledetails.vehicle_name',
            'vehiclerequest.purpose',
            'vehiclerequest.placesToVisit',
            'users.empName',
            'designationmaster.desisNameLong',
            'vehiclerequest.status'
        )     

         ->get();
      }
      
      return datatables()->of($data)->make(true);
     }
    
    }
}

?>
