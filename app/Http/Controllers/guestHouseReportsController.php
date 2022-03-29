<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class guestHouseReportsController extends Controller
{
   
    function index(Request $request)
    {

      

     if(request()->ajax())
     {

      if(!empty($request->filter_startdate))
      {
        $data = DB::table('roombed')
        ->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 

      
        ->select('guesthouseroom.id as bed','guesthouseroom.room_no','guesthouseroom.bed_no','guesthouseroom.id','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name as ghid','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
        ->where('check_in','>=',$request->filter_startdate)
        ->where('check_out','<=',$request->filter_enddate)
	      ->latest('roombed.id')

  
	 ->where('roombed.id','>',25)
   ->where('roombed.statusrb','>=',2)
        ->get();
        
     }
      else
      {
       

        $data = DB::table('roombed')
        ->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 

      
        ->select('guesthouseroom.id as bed','guesthouseroom.room_no', 'guesthouseroom.bed_no','guesthouseroom.id','dzongkhags.Dzongkhag_Name','guesthousename.name as ghid','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
        // ->where('start_date','>=',$request->filter_startdate)
        // ->where('end_date','<=',$request->filter_enddate)
        ->latest('roombed.id')
       ->where('roombed.id','>',25)
       ->where('roombed.statusrb','>=',2)
	     ->get();
        
      }
      return datatables()->of($data)->make(true);
     }
    
    
}
    
  }

?>
