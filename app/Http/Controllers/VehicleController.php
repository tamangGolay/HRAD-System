<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicles;
use App\vehiclerequest;
use App\vehicleapprove;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use DB;
use Auth;

class VehicleController extends Controller
{

    public function Request_vehicle(Request $request)
    {
        try
         {

            $Request_vehicle = new vehiclerequest;
            $Request_vehicle->emp_id = $request->emp_id;
            $Request_vehicle->vname = $request->name;
            $Request_vehicle->org_unit_id = $request->org_unit_id;
            $Request_vehicle->email = $request->email;
            $Request_vehicle->vehicleId = $request->vehicle; //*
            $Request_vehicle->start_date = $request->start_date;
            $Request_vehicle->end_date = $request->end_date;
            $Request_vehicle->dateOfRequisition = $request->date_of_requisition;
            $Request_vehicle->purpose = $request->purpose;
            $Request_vehicle->placesToVisit = $request->places_to_visit;
            $Request_vehicle->personalvehicle = $request->input('role');
            

            $Request_vehicle->save();

            $org_unit_id = DB::table('vehiclerequest')->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
                ->select('org_unit_id', 'description')
                ->where('status', '=', 0)
                ->where('vehiclerequest.id', '=', $Request_vehicle->id)
                ->first();

            $vehicle_name = DB::table('vehiclerequest')->join('vehicledetails', 'vehicledetails.id', '=', 'vehiclerequest.vehicleId')
                ->select('vehicle_name', 'vehicle_number')
                ->where('vehiclerequest.id', '=', $Request_vehicle->id)
                ->first();

            $employee = ['title' => 'Mail From the BPC System', 'body' => 'Dear ' . $request->name . ',', 'body1' => 'Your vehicle booking initiated on ' . $request->date_of_requisition . ' has been processed, kindly wait for the notice.', 'body2' => 'Note', 'body3' => '*If the request is rejected by supervisor, you will be notified otherwise you will receive notification from MTO only.', 'body4' => '','body5' => '','body6' => '',];

            $supervisior = ['title' => 'Mail From the BPC System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for vehicle requisition from ' . $request->name . ' bearing employee Id ' . $request->emp_id . ' of ' . $org_unit_id->description . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: http://booking.bpc.bt','body5' => '','body6' => '', ];

            Mail::to($request->email)

                ->send(new MyTestMail($employee));

            Mail::to('bosebackup1@gmail.com')
                ->send(new MyTestMail($supervisior));


            //ICD GM
            if ($org_unit_id->org_unit_id == 44 || $org_unit_id->org_unit_id == 45 || $org_unit_id->org_unit_id == 46 || $org_unit_id->org_unit_id == 61)

            {
                Mail::to('nimawtamang@bpc.bt')  //namgaywangchuk@bpc.bt
                    ->send(new MyTestMail($supervisior));

                    Mail::to('bosebackup1@gmail.com')
                    ->send(new MyTestMail($supervisior));
            }
            //ICD GM end

             //CMDPO
         if ($org_unit_id->org_unit_id == 73)

         {
            Mail::to('herukazangpo@bpc.bt')  //herukazangpo@bpc.bt
            ->send(new MyTestMail($supervisior));

            Mail::to('bosebackup1@gmail.com')
            ->send(new MyTestMail($supervisior));
         }

            //TD GM
            if ($org_unit_id->org_unit_id == 19 || $org_unit_id->org_unit_id == 20 || $org_unit_id->org_unit_id == 21
                || $org_unit_id->org_unit_id == 22 || $org_unit_id->org_unit_id == 23 || $org_unit_id->org_unit_id == 53)

            {

                Mail::to('ktobgye@bpc.bt') //ktobgye@bpc.bt
                    ->send(new MyTestMail($supervisior));

                    Mail::to('bosebackup1@gmail.com')
                    ->send(new MyTestMail($supervisior));


            }
            //TD GM end
            

            //TCD GM
            if ($org_unit_id->org_unit_id == 54)
            {

                Mail::to('shamsherpradhan@bpc.bt')  //shamsherpradhan@bpc.bt
                    ->send(new MyTestMail($supervisior));

                    Mail::to('bosebackup1@gmail.com')
                    ->send(new MyTestMail($supervisior));
            }

            // TCD GM end
            

            //DCD GM
            if ($org_unit_id->org_unit_id == 24 || $org_unit_id->org_unit_id == 25 || $org_unit_id->org_unit_id == 26 || $org_unit_id->org_unit_id == 27 || $org_unit_id->org_unit_id == 55)

            {

                Mail::to('drukchudorji@bpc.bt') //drukchudorji@bpc.bt
                    ->send(new MyTestMail($supervisior));

                Mail::to('bosebackup1@gmail.com')
                    ->send(new MyTestMail($supervisior));
            }

            //DCD GM end
            

            //DCSD GM
            if ($org_unit_id->org_unit_id == 28 || $org_unit_id->org_unit_id == 29 || $org_unit_id->org_unit_id == 30 || $org_unit_id->org_unit_id == 31 || $org_unit_id->org_unit_id == 32 || $org_unit_id->org_unit_id == 56)

            {

                Mail::to('chadorphuntsho@bpc.bt') //chadorphuntsho@bpc.bt
                    ->send(new MyTestMail($supervisior));
                
                 Mail::to('bosebackup1@gmail.com')
                    ->send(new MyTestMail($supervisior));
            }

            //DCSD GM end

            //HRAD GM
            if ($org_unit_id->org_unit_id == 33 || $org_unit_id->org_unit_id == 34 || $org_unit_id->org_unit_id == 35 || $org_unit_id->org_unit_id == 57)

            {

                Mail::to('rinchenwangdi@bpc.bt')  //rinchenwangdi@bpc.bt
                    ->send(new MyTestMail($supervisior));
                
                 Mail::to('bosebackup1@gmail.com')
                 ->send(new MyTestMail($supervisior));

            }

            //HRAD GM end

            // For SFSB GM
            if ($org_unit_id->org_unit_id == 36 || $org_unit_id->org_unit_id == 59)

            {

                Mail::to('chhewangrinzin@bpc.bt')   //chhewangrinzin@bpc.bt
                    ->send(new MyTestMail($supervisior));

                Mail::to('bosebackup1@gmail.com')
                    ->send(new MyTestMail($supervisior));

            }

            // sbsf GM end
            

            // PSD GM
            if ($org_unit_id->org_unit_id == 37 || $org_unit_id->org_unit_id == 38 || $org_unit_id->org_unit_id == 39 || $org_unit_id->org_unit_id == 58)

            {

                Mail::to('nim.dorji@bpc.bt')  //nim.dorji@bpc.bt
                    ->send(new MyTestMail($supervisior));

                 Mail::to('bosebackup1@gmail.com')
                    ->send(new MyTestMail($supervisior));

            }

            // PSD GM end
            

            //  For ERD GM
            

            if ($org_unit_id->org_unit_id == 41 || $org_unit_id->org_unit_id == 42 || $org_unit_id->org_unit_id == 43 || $org_unit_id->org_unit_id == 60)

            {

                Mail::to('gorabdorji@bpc.bt')  //gorabdorji@bpc.bt
                    ->send(new MyTestMail($supervisior));
                   
                Mail::to('bosebackup1@gmail.com')
                    ->send(new MyTestMail($supervisior));

            }

            //ERD GM end
            

            //  For SPBD GM
            if ($org_unit_id->org_unit_id == 47 || $org_unit_id->org_unit_id == 48 || $org_unit_id->org_unit_id == 62)

            {

                Mail::to('dechecholing@bpc.bt')  //dechecholing@bpc.bt
                    ->send(new MyTestMail($supervisior));

                 Mail::to('bosebackup1@gmail.com')
                    ->send(new MyTestMail($supervisior));

            }

            //SPBD GM end
            

            //Transmission services Director
            

            if ($org_unit_id->org_unit_id == 10 || $org_unit_id->org_unit_id == 11 || $org_unit_id->org_unit_id == 63)

            {

                Mail::to('thinleygyeltshen@bpc.bt') //thinleygyeltshen@bpc.bt
                    ->send(new MyTestMail($supervisior));
                Mail::to('bosebackup1@gmail.com')
                    ->send(new MyTestMail($supervisior));

            }

            //Transmission services end
            

            //Distribution services Director
            

            if ($org_unit_id->org_unit_id == 12 || $org_unit_id->org_unit_id == 13 || $org_unit_id->org_unit_id == 64)

            {

                Mail::to('sandeeprai@bpc.bt')  //sandeeprai@bpc.bt
                    ->send(new MyTestMail($supervisior));

                 Mail::to('bosebackup1@gmail.com')
                    ->send(new MyTestMail($supervisior));
            }

            //Distribution services end
            

            //HRCS services Director
            if ($org_unit_id->org_unit_id == 14 || $org_unit_id->org_unit_id == 16 || $org_unit_id->org_unit_id == 15 || $org_unit_id->org_unit_id == 65 || $org_unit_id->org_unit_id == 36 || $org_unit_id->org_unit_id == 40)
            {

                Mail::to('sangaytenzin1@bpc.bt')  //sangaytenzin1@bpc.bt
                    ->send(new MyTestMail($supervisior));

                 Mail::to('bosebackup1@gmail.com')
                ->send(new MyTestMail($supervisior));
            }
            //HRCS services end
            

            //Finance and Account services Director
            if ($org_unit_id->org_unit_id == 49 || $org_unit_id->org_unit_id == 50 || $org_unit_id->org_unit_id == 51 || $org_unit_id->org_unit_id == 66)

            {

                Mail::to('kinleydem04@bpc.bt') //kinleydem04@bpc.bt
                    ->send(new MyTestMail($supervisior));

                 Mail::to('bosebackup1@gmail.com')
                    ->send(new MyTestMail($supervisior));

            }

            //Finance and Account services end
            

            //   STS Director
            if ($org_unit_id->org_unit_id == 47 || $org_unit_id->org_unit_id == 48 || $org_unit_id->org_unit_id == 62 || $org_unit_id->org_unit_id == 17 || $org_unit_id->org_unit_id == 18|| $org_unit_id->org_unit_id == 9 || $org_unit_id->org_unit_id == 67 || $org_unit_id->org_unit_id == 72)

            {

                Mail::to('dechendema@bpc.bt')  //dechendema@bpc.bt
                    ->send(new MyTestMail($supervisior));
                 Mail::to('bosebackup1@gmail.com')
                    ->send(new MyTestMail($supervisior));
            }

            // STS end
            //BPSO GM
            if ($org_unit_id->org_unit_id == 68)

            {

                Mail::to('sherub@bpc.bt') // sherub@bpc.bt
                    ->send(new MyTestMail($supervisior));

                 Mail::to('bosebackup1@gmail.com')
                 ->send(new MyTestMail($supervisior));
            }

            // BPSO end
            //INTERNAL AUDIT Chief
            if ($org_unit_id->org_unit_id == 69)

            {

                Mail::to('gempojampel@bpc.bt') //gempojampel@bpc.bt
                    ->send(new MyTestMail($supervisior));

             Mail::to('bosebackup1@gmail.com')
                    ->send(new MyTestMail($supervisior));
            }

            //INTERNAL AUDIT end
            

            //CEO
            if ($org_unit_id->org_unit_id == 3 || $org_unit_id->org_unit_id == 4 || $org_unit_id->org_unit_id == 5 || $org_unit_id->org_unit_id == 6 || $org_unit_id->org_unit_id == 7 || $org_unit_id->org_unit_id == 8 || $org_unit_id->org_unit_id == 70 || $org_unit_id->org_unit_id == 52)

            {

                Mail::to('stobjey@bpc.bt') //stobjey@bpc.bt
                    ->send(new MyTestMail($supervisior));

                 Mail::to('bosebackup1@gmail.com')
                    ->send(new MyTestMail($supervisior));
            }

            //CEO end
            

            return redirect('home')->with('page', 'Request_vehicle')
                ->with('success', ' Requisition Successful');

        } //try end
       
     catch(\Illuminate\Database\QueryException $e)
     {

          return redirect('home')->with('page', 'Request_vehicle')
                ->with('error', 'Cannot leave the fields empty');

         }

    }

    //ICD Vehicle approve
    public function vehicleapprove(Request $request)

    {

        //  dd($request->id);
        $id = DB::table('vehiclerequest')->select('id')
            ->where('id', $request->id)
            ->first();

        $org_unit_id = DB::table('vehiclerequest')->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
            ->select('org_unit_id', 'description')
            ->where('status', '=', 0)
            ->where('vehiclerequest.id', '=', $request->id)
            ->first();

        $supervisior = Auth::id();
        DB::update('update vehiclerequest set supervisor = ? where id = ?', [$supervisior, $id->id]);

        // DB::commit();
        $vehicle = DB::table('vehiclerequest')->where('id', $request->id)
            ->increment('status', 2);

        $name = DB::table('vehiclerequest')->select('vname')
            ->where('id', $request->id)
            ->first();

        $emp_id = DB::table('vehiclerequest')->select('emp_id')
            ->where('id', $request->id)
            ->first();

        $mto = ['title' => 'Mail From the BPC System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for vehicle requisition from ' . $name->vname . ' bearing employee Id ' . $emp_id->emp_id . ' of  ' . $org_unit_id->description . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => 'click here: http://booking.bpc.bt','body5' => '','body6' => '', ];

        Mail::to('nimawtamang@bpc.bt') //MTO
            ->send(new MyTestMail($mto));

        Mail::to('bosebackup1@gmail.com')
            ->send(new MyTestMail($mto));

        //ICD
        if ($org_unit_id->org_unit_id == 44 || $org_unit_id->org_unit_id == 45 || $org_unit_id->org_unit_id == 46 || $org_unit_id->org_unit_id == 61)

        {
            return redirect('home')
            ->with('success', 'You have approved the requisition');
        }

         //CMDPO
         if ($org_unit_id->org_unit_id == 73)

         {
             return redirect('home')
             ->with('success', 'You have approved the requisition');
         }

        //BPSO Vehicle approve        

        if ($org_unit_id->org_unit_id == 68)

        {

            return redirect('home')
            ->with('success', 'You have approved the requisition');
        }
        

        //DCD Vehicle approve
        

        if ($org_unit_id->org_unit_id == 24 || $org_unit_id->org_unit_id == 25 || $org_unit_id->org_unit_id == 26 || $org_unit_id->org_unit_id == 27 || $org_unit_id->org_unit_id == 55)

        {

            return redirect('home')
            ->with('success', 'You have approved the requisition');

        }

        //DCSD Vehicle approve
        if ($org_unit_id->org_unit_id == 28 || $org_unit_id->org_unit_id == 29 || $org_unit_id->org_unit_id == 30 || $org_unit_id->org_unit_id == 31 || $org_unit_id->org_unit_id == 32 || $org_unit_id->org_unit_id == 56)

        {

            return redirect('home')
            ->with('success', 'You have approved the requisition');
        }

        //DIR Vehicle approve
        

        if ($org_unit_id->org_unit_id == 3 || $org_unit_id->org_unit_id == 4 || $org_unit_id->org_unit_id == 5 || $org_unit_id->org_unit_id == 6 || $org_unit_id->org_unit_id == 7 || $org_unit_id->org_unit_id == 8 || $org_unit_id->org_unit_id == 70 || $org_unit_id->org_unit_id == 52)

        {

            return redirect('home')
            ->with('success', 'You have approved the requisition');
        }

        //DS Director Vehicle approve
        

        if ($org_unit_id->org_unit_id == 12 || $org_unit_id->org_unit_id == 13 || $org_unit_id->org_unit_id == 64)

        {

            return redirect('home')
            ->with('success', 'You have approved the requisition');
        }

        //ERD Vehicle approve
        if ($org_unit_id->org_unit_id == 41 || $org_unit_id->org_unit_id == 42 || $org_unit_id->org_unit_id == 43 || $org_unit_id->org_unit_id == 60)

        {

            return redirect('home')
            ->with('success', 'You have approved the requisition');
        }

        //FAS Director Vehicle approve
        if ($org_unit_id->org_unit_id == 49 || $org_unit_id->org_unit_id == 50 || $org_unit_id->org_unit_id == 51 || $org_unit_id->org_unit_id == 66)

        {

            return redirect('home')
            ->with('success', 'You have approved the requisition');
        }

        //HRAD Vehicle approve
        if ($org_unit_id->org_unit_id == 33 || $org_unit_id->org_unit_id == 34 || $org_unit_id->org_unit_id == 35 || $org_unit_id->org_unit_id == 57)

        {

            return redirect('home')
            ->with('success', 'You have approved the requisition');

        }

        //HRCS Director Vehicle approve
        if ($org_unit_id->org_unit_id == 14 || $org_unit_id->org_unit_id == 16 || $org_unit_id->org_unit_id == 15 || $org_unit_id->org_unit_id == 65 || $org_unit_id->org_unit_id == 36 || $org_unit_id->org_unit_id == 40)
        {

            return redirect('home')
            ->with('success', 'You have approved the requisition');
        }

        //IAD Chief Vehicle approve
        if ($org_unit_id->org_unit_id == 69)
        {

            return redirect('home')
            ->with('success', 'You have approved the requisition');
        }

        //PSD Vehicle approve
        if ($org_unit_id->org_unit_id == 37 || $org_unit_id->org_unit_id == 38 || $org_unit_id->org_unit_id == 39 || $org_unit_id->org_unit_id == 58)

        {
            return redirect('home')
            ->with('success', 'You have approved the requisition');
        }

        //SFSB Vehicle approve
        if ($org_unit_id->org_unit_id == 36 || $org_unit_id->org_unit_id == 59)

        {

            return redirect('home')
            ->with('success', 'You have approved the requisition');
        }

        //SPBD Vehicle approve
        if ($org_unit_id->org_unit_id == 47 || $org_unit_id->org_unit_id == 48 || $org_unit_id->org_unit_id == 62)

        {

            return redirect('home')
            ->with('success', 'You have approved the requisition');
        }

        //sts Vehicle approve
        if ($org_unit_id->org_unit_id == 47 || $org_unit_id->org_unit_id == 48 || $org_unit_id->org_unit_id == 62 || $org_unit_id->org_unit_id == 17 || $org_unit_id->org_unit_id == 18|| $org_unit_id->org_unit_id == 9 || $org_unit_id->org_unit_id == 67 || $org_unit_id->org_unit_id == 72)
        {
        return redirect('home')
        ->with('success', 'You have approved the requisition');
    }    

        //TCD Vehicle approve
        if ($org_unit_id->org_unit_id == 54)
        {

            return redirect('home')
            ->with('success', 'You have approved the requisition');
        }

        //TD Vehicle approve
        if ($org_unit_id->org_unit_id == 19 || $org_unit_id->org_unit_id == 20 || $org_unit_id->org_unit_id == 21
            || $org_unit_id->org_unit_id == 22 || $org_unit_id->org_unit_id == 23 || $org_unit_id->org_unit_id == 53)

        {

            return redirect('home')
            ->with('success', 'You have approved the requisition');
        }

        //TS Director Vehicle approve
        if ($org_unit_id->org_unit_id == 10 || $org_unit_id->org_unit_id == 11 || $org_unit_id->org_unit_id == 63)

        {

            return redirect('home')
            ->with('success', 'You have approved the requisition');

        }
    }


    //MTOVehicle approve
    public function MTOapprove(Request $request)
    {
        // dd($request->vehicle);
	    
        $id = DB::table('vehiclerequest')->select('id')
            ->where('id', $request->idl)
            ->first();

        $mto = Auth::id();
        DB::update('update vehiclerequest set mto = ? where id = ?', [$mto, $id->id]);

        // DB::commit();
        $vehicle = DB::table('vehiclerequest')->where('id', $request->idl)
            ->increment('status', 2);

        $name = DB::table('vehiclerequest')->select('vname')
            ->where('id', $request->idl)
            ->first();
        
        $start_date = DB::table('vehiclerequest')->select('start_date')
            ->where('id', $request->idl)
            ->first();

        $end_date = DB::table('vehiclerequest')->select('end_date')
            ->where('id', $request->idl)
            ->first();

        $email = DB::table('vehiclerequest')->select('email')
            ->where('id', $request->idl)
            ->first();

        $emp_id = DB::table('vehiclerequest')->select('emp_id')
            ->where('id', $request->idl)
            ->first();
        
        $placesToVisit = DB::table('vehiclerequest')->select('placesToVisit')
            ->where('id', $request->idl)
            ->first();

        $orgunit = DB::table('vehiclerequest')->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
            ->select('description')
            ->where('vehiclerequest.id', $request->idl)
            ->first();

        $reqDate = DB::table('vehiclerequest')->select('dateOfRequisition')
            ->where('id', '=', $request->idl)
            ->first();

        $vehicle_name = DB::table('vehicledetails')
            ->select('vehicle_name')
            ->where('vehicledetails.id', '=', $request->vehicle)
            ->first();

        $vehicle_id = DB::table('vehicledetails')
            ->select('id')
            ->where('vehicledetails.id', '=', $request->vehicle)
            ->first();
        // dd($vehicle_id->id);  
        DB::update('update vehiclerequest set vehicleId = ? where id = ?', [$vehicle_id->id, $id->id]);

            // dd($vehicle_name->vehicle_name);


        
        $supervisior = ['title' => 'Mail From the BPC System (From MTO)', 'body' => 'Dear sir,', 'body1' => 'This is to inform you that for the tour to ' . $placesToVisit->placesToVisit.', vehicle ' . $vehicle_name->vehicle_name. ' has beeen assigned to ' . $name->vname . '('.$emp_id->emp_id.' ) of '.$orgunit->description.' from '.$start_date->start_date. ' to ' .$end_date->end_date. '.', 'body2' => 'Plese keep note of it la!', 'body3' => '  ','body4' => 'Mr. Rinchen Wangdi','body5' => 'General Manager, HRAD','body6' => 'Email Id: rinchenwangdi@bpc.bt', ];

        $employee = ['title' => 'Mail From the BPC System(From MTO)', 'body' => 'Dear ' . $name->vname . ',', 'body1' => 'Your request for vehicle requisition initiated on Date: ' . $reqDate->dateOfRequisition . ' has been approved.', 'body2' => 'Vehicle: '. $vehicle_name->vehicle_name .' has been asigned to you from '.$start_date->start_date. ' to ' .$end_date->end_date. '.', 'body3' => '', 'body4' => 'Mr. Rinchen Wangdi','body5' => 'General Manager, HRAD','body6' => 'Email Id: rinchenwangdi@bpc.bt',];
        
       

        Mail::to('nimawtamang@bpc.bt')  //piad GM 
        ->send(new MyTestMail($supervisior));

        Mail::to('bosebackup1@gmail.com')
        ->send(new MyTestMail($supervisior));
        
        
        Mail::to($email->email)
            ->send(new MyTestMail($employee));        
            
        Mail::to('bosebackup1@gmail.com')
        ->send(new MyTestMail($employee));

        return redirect('home')
        
        ->with('success', 'You have assigned the vehicle!!');


    }//end vehicle approve

    


//duration extend vehicle

    public function MTOdurationextend(Request $request)
    {
        // dd($request->vehicle);
	    
        $id = DB::table('vehiclerequest')->select('id')
            ->where('id', $request->idl)
            ->first();      

        // DB::commit();
        $vehicle = DB::table('vehiclerequest')->where('id', $request->idl)
            ->increment('status', 1);   
        
            
                
        return redirect('home')->with('success', 'Vehicle is back to HQ and avaliable for use!');
    

    }
//end duration extend




    //Reports Generation

public function date_search(Request $request){


    $fromdate= $request->input('fromdate');
    $todate= $request->input('todate'); 

$org_unit_id = DB::table('vehiclerequest')->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
    ->select('org_unit_id', 'description')
    ->where('status', '=', 0)
    ->get();
    


 $vehicle_name = DB::table('vehiclerequest')->join('vehicledetails', 'vehicledetails.id', '=', 'vehiclerequest.vehicleId')
    ->select('vehicle_name', 'vehicle_number')
    ->get();
    

    $query= DB::table('vehiclerequest')->select('*')
    ->where('start_date', '>=',$fromdate)
    ->where('end_date', '<=',$todate)
    ->get();

    $reports = DB::table('vehiclerequest')->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
    //  ->join('users','users.id','=','vehiclerequest.supervisor')
    
        ->join('vehicledetails', 'vehicledetails.id', '=', 'vehiclerequest.vehicleId')
        ->join('users', 'users.id', '=', 'vehiclerequest.supervisor') //pull gm's name
    
        // ->where('vehiclerequest.status', 0)

        ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.dateOfRequisition', 'vehicledetails.vehicle_name', 'vehiclerequest.purpose', 'vehiclerequest.status', 'vehiclerequest.placesToVisit', 'users.name', 'users.designation')
        ->orderBy('vehiclerequest.id', 'desc')
        ->paginate(10000);

   
    return view('vehicle.reports',compact('reports','query','vehicle_name','org_unit_id'));
     }

    


    //editmto
    public function store(Request $request)
    {

        $end1 = $request->end_date;
        $end = date("Y-m-d ", strtotime($end1));

        vehiclerequest::updateOrCreate(['id' => $request->id], ['end_date' => $end]);

        return response()->json(['success' => 'Meeting Room saved successfully.']);
    }

    public function edit($id)
    {


        $conference = vehiclerequest::find($id);
        return response()->json($conference);
    }

    //vehicle reject(GM supervisor)
    public function vehiclereject(Request $request)
    {

        $id = DB::table('vehiclerequest')->select('id')
            ->where('id', $request->id)
            ->first();

        $org_unit_id = DB::table('vehiclerequest')->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
            ->select('org_unit_id', 'description')
            ->where('status', '=', 0)
            ->where('vehiclerequest.id', '=', $request->id)
            ->first();

        $reason = $request->reason;
        DB::update('update vehiclerequest set reason = ? where id = ?', [$reason, $id->id]);

        $supervisior = Auth::id();
        DB::update('update vehiclerequest set supervisor = ? where id = ?', [$supervisior, $id->id]);

        $vehicle = DB::table('vehiclerequest')->where('id', $request->id)
            ->increment('status');

        $name = DB::table('vehiclerequest')->select('vname')
            ->where('id', $request->id)
            ->first();

        $reqDate = DB::table('vehiclerequest')->select('dateOfRequisition')
            ->where('id', '=', $request->id)
            ->first();

        $vehicle_name = DB::table('vehiclerequest')->join('vehicledetails', 'vehicledetails.id', '=', 'vehiclerequest.vehicleId')
            ->select('vehicle_name', 'vehicle_number')
            ->where('vehiclerequest.id', '=', $request->id)
            ->first();

        $employee = ['title' => 'Mail From the BPC System(Supervisor)', 'body' => 'Dear ' . $name->vname . ',', 'body1' => 'We are sorry to inform you that, your request for vehicle requisition initiated on ' . $reqDate->dateOfRequisition . ' could not be approved. ', 'body2' => ' ', 'body3' => ' Remarks: ' .$request->reason,'body4' => '','body5' => '','body6' => '', ];

        $email = DB::table('vehiclerequest')->select('email')
            ->where('id', '=', $request->id)
            ->first();

        Mail::to($email->email)
            ->send(new MyTestMail($employee));

        Mail::to('bosebackup1@gmail.com')
            ->send(new MyTestMail($employee));
    
        //ICD
        if ($org_unit_id->org_unit_id == 44 || $org_unit_id->org_unit_id == 45 || $org_unit_id->org_unit_id == 46 || $org_unit_id->org_unit_id == 61)

        {
            return redirect('home')
            ->with('error', 'You have rejected the requisition!!');
        }

         //CMDPO
         if ($org_unit_id->org_unit_id == 73)

         {
              return redirect('home')
              ->with('error', 'You have rejected the requisition!!');
        }

        //BPSO Vehicle approve
        

        if ($org_unit_id->org_unit_id == 68)

        {

            return redirect('home')
            ->with('error', 'You have rejected the requisition!!');
        }

        //DCD Vehicle approve
        

        if ($org_unit_id->org_unit_id == 24 || $org_unit_id->org_unit_id == 25 || $org_unit_id->org_unit_id == 26 || $org_unit_id->org_unit_id == 27 || $org_unit_id->org_unit_id == 55)

        {

            return redirect('home')
            ->with('error', 'You have rejected the requisition!!');

        }

        //DCSD Vehicle approve
        if ($org_unit_id->org_unit_id == 28 || $org_unit_id->org_unit_id == 29 || $org_unit_id->org_unit_id == 30 || $org_unit_id->org_unit_id == 31 || $org_unit_id->org_unit_id == 32 || $org_unit_id->org_unit_id == 56)

        {

            return redirect('home')
            ->with('error', 'You have rejected the requisition!!');
        }

        //DIR Vehicle approve
        

        if ($org_unit_id->org_unit_id == 3 || $org_unit_id->org_unit_id == 4 || $org_unit_id->org_unit_id == 5 || $org_unit_id->org_unit_id == 6 || $org_unit_id->org_unit_id == 7 || $org_unit_id->org_unit_id == 8 || $org_unit_id->org_unit_id == 70 || $org_unit_id->org_unit_id == 52)

        {

            return redirect('home')
            ->with('error', 'You have rejected the requisition!!');
        }

        //DS Director Vehicle approve
        

        if ($org_unit_id->org_unit_id == 12 || $org_unit_id->org_unit_id == 13 || $org_unit_id->org_unit_id == 64)

        {

            return redirect('home')
            ->with('error', 'You have rejected the requisition!!');
        }

        //ERD Vehicle approve
        if ($org_unit_id->org_unit_id == 41 || $org_unit_id->org_unit_id == 42 || $org_unit_id->org_unit_id == 43 || $org_unit_id->org_unit_id == 60)

        {

            return redirect('home')
            ->with('error', 'You have rejected the requisition!!');
        }

        //FAS Director Vehicle approve
        if ($org_unit_id->org_unit_id == 49 || $org_unit_id->org_unit_id == 50 || $org_unit_id->org_unit_id == 51 || $org_unit_id->org_unit_id == 66)

        {

            return redirect('home')
            ->with('error', 'You have rejected the requisition!!');
        }

        //HRAD Vehicle approve
        if ($org_unit_id->org_unit_id == 33 || $org_unit_id->org_unit_id == 34 || $org_unit_id->org_unit_id == 35 || $org_unit_id->org_unit_id == 57)

        {

            return redirect('home')
            ->with('error', 'You have rejected the requisition!!');

        }

        //HRCS Director Vehicle approve
        if ($org_unit_id->org_unit_id == 14 || $org_unit_id->org_unit_id == 16 || $org_unit_id->org_unit_id == 15 || $org_unit_id->org_unit_id == 65 || $org_unit_id->org_unit_id == 36 || $org_unit_id->org_unit_id == 40)
        {

            return redirect('home')
            ->with('error', 'You have rejected the requisition!!');
        }

        //IAD Chief Vehicle approve
        if ($org_unit_id->org_unit_id == 69)
        {

            return redirect('home')
            ->with('error', 'You have rejected the requisition!!');
        }

        //PSD Vehicle approve
        if ($org_unit_id->org_unit_id == 37 || $org_unit_id->org_unit_id == 38 || $org_unit_id->org_unit_id == 39 || $org_unit_id->org_unit_id == 58)

        {
            return redirect('home')
            ->with('error', 'You have rejected the requisition!!');
        }

        //SFSB Vehicle approve
        if ($org_unit_id->org_unit_id == 36 || $org_unit_id->org_unit_id == 59)

        {

            return redirect('home')
            ->with('error', 'You have rejected the requisition!!');
        }

        //SPBD Vehicle approve
        if ($org_unit_id->org_unit_id == 47 || $org_unit_id->org_unit_id == 48 || $org_unit_id->org_unit_id == 62)

        {

            return redirect('home')
            ->with('error', 'You have rejected the requisition!!');
        }

        //sts Vehicle approve
        if ($org_unit_id->org_unit_id == 47 || $org_unit_id->org_unit_id == 48 || $org_unit_id->org_unit_id == 62 || $org_unit_id->org_unit_id == 17|| $org_unit_id->org_unit_id == 18 || $org_unit_id->org_unit_id == 9 || $org_unit_id->org_unit_id == 67|| $org_unit_id->org_unit_id == 72)
        {
        return redirect('home')
        ->with('error', 'You have rejected the requisition!!');
        }


        //TCD Vehicle approve
        if ($org_unit_id->org_unit_id == 54)
        {

            return redirect('home')
            ->with('error', 'You have rejected the requisition!!');
        }

        //TD Vehicle approve
        if ($org_unit_id->org_unit_id == 19 || $org_unit_id->org_unit_id == 20 || $org_unit_id->org_unit_id == 21
            || $org_unit_id->org_unit_id == 22 || $org_unit_id->org_unit_id == 23 || $org_unit_id->org_unit_id == 53)

        {

            return redirect('home')
            ->with('error', 'You have rejected the requisition!!');
        }

        //TS Director Vehicle approve
        if ($org_unit_id->org_unit_id == 10 || $org_unit_id->org_unit_id == 11 || $org_unit_id->org_unit_id == 63)

        {

            return redirect('home')
            ->with('error', 'You have rejected the requisition!!');

        }

    }

    //MTO data remove from duration extend
    public function MTOrequestremove(Request $request)
    {

        $vehiclename = DB::table('vehicledetails')->select('vehicle_name')
        ->where('id', '=', $request->vehiclename)
        ->first();             


        $id = DB::table('vehiclerequest')->select('id')
            ->where('id', '=', $request->idl)
            ->first();

         $vehicle = DB::table('vehiclerequest')->where('id', '=', $request->idl)
            ->decrement('status');

            return redirect('home')
            ->with('error', 'You have cancelled the vehicle approved request!');
                          
        }


    //MTO reject
    public function MTOreject(Request $request)
    {

        $vehiclename = DB::table('vehicledetails')->select('vehicle_name')
        ->where('id', '=', $request->vehiclename)
        ->first();

// dd($vehiclename->vehicle_name);               


        $id = DB::table('vehiclerequest')->select('id')
            ->where('id', '=', $request->idl)
            ->first();

        $supervisior = Auth::id();
        DB::update('update vehiclerequest set supervisor = ? where id = ?', [$supervisior, $id->id]);

        $reason = $request->reason;
        DB::update('update vehiclerequest set reason = ? where id = ?', [$reason, $id->id]);

        DB::update('update vehiclerequest set vehicleId = ? where id = ?', [$request->vehiclename, $id->id]);

        // DB::commit();
        $vehicle = DB::table('vehiclerequest')->where('id', '=', $request->idl)
            ->increment('status');

        $name = DB::table('vehiclerequest')->select('vname')
            ->where('id', '=', $request->idl)
            ->first();

        $email = DB::table('vehiclerequest')->select('email')
            ->where('id', '=', $request->idl)
            ->first();

        $emp_id = DB::table('vehiclerequest')->select('emp_id')
            ->where('id', '=', $request->idl)
            ->first();

        $orgunit = DB::table('vehiclerequest')->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
            ->select('description')
            ->where('vehiclerequest.id', '=', $request->idl)
            ->first();

        $vehicle_name = DB::table('vehiclerequest')->join('vehicledetails', 'vehicledetails.id', '=', 'vehiclerequest.vehicleId')
            ->select('vehicle_name', 'vehicle_number')
            ->where('vehiclerequest.id', '=', $request->idl)
            ->first();

        $reqDate = DB::table('vehiclerequest')->select('dateOfRequisition')
            ->where('id', '=', $request->idl)
            ->first();

        $employee = ['title' => 'Mail From the BPC System(MTO)', 'body' => 'Dear ' . $name->vname, 'body1' => 'We are sorry to inform you that, your request vehicle requisition initiated on ' . $reqDate->dateOfRequisition . ' is not available. ', 'body2' => 'Reason:', 'body3' => $request->reason, 'body4' => 'Mr. Rinchen Wangdi', 'body5' => 'General Manager, HRAD', 'body6' => 'Email Id: rinchenwangdi@bpc.bt',];

        // $supervisior = ['title' => 'Mail From the BPC System (MTO to pid)', 'body' => 'Dear sir,', 'body1' => 'This is to inform you that for the tour to ' . $placesToVisit->placesToVisit.', vehicle ' . $vehicle_name->vehicle_name. ' has beeen assigned to ' . $name->vname . '('.$emp_id->emp_id.' ) of '.$orgunit->description.' from '.$start_date->start_date. ' to ' .$end_date->end_date. '.', 'body2' => 'Plese keep note of it', 'body3' => ' MTO ','body4' => '', 'body5' => '', 'body6' => '', ];

        //SUPERVISOR HERE IS PID 

        Mail::to($email->email)
            ->send(new MyTestMail($employee));
    
            Mail::to('bosebackup1@gmail.com')
            ->send(new MyTestMail($employee));
                          
                  
                // Mail::to('bosebackup1@gmail.com')
                // ->send(new MyTestMail($supervisior));

        return redirect('home')
        ->with('error', 'You have rejected the requisition!!');
        
      

    }}

