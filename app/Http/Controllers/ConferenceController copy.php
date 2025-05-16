<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\conference;
use App\conferencerequest;
use App\conferencebook;
use App\conferenceapprove;

use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use Carbon\Carbon;
Use Exception;
use Auth;
use Illuminate\Support\Facades\DB;


class ConferenceController extends Controller
{

    public function conference(Request $request)
    {
        //Pulling conference_user value 1 or 0  from users table 
        $conference_user = DB::table('users')
            ->select('conference_user')
            ->where('users.empId', $request->empId)
            ->first();
   
        try
        {

            $start = $request->start_date;
            $end = $request->end_date;

            // dd($start, $end);

            if($start ==  $end){

                return redirect('/cbook')
                    ->with('error1', 'Start time and end time cannot be same');

            }
         

            if ($conference_user->conference_user == 1)
            {

             
                $start1 = $request->start_date;
                $end1 = $request->end_date;
                $start = date("Y-m-d H:i:s", strtotime($start1));
                $end = date("Y-m-d H:i:s", strtotime($end1));
              

                //1.Between logic
                $id = DB::table('conferencerequest')->select('conference_id')
                    ->where('conference_id', $request->conference)
                    ->select('id')
                    ->where('status','=',0)
                    ->where('start_date', '<=', $start)
                    ->Where('end_date', '>=', $end)
                    ->first();

                //2.End in between logic
                $eid = DB::table('conferencerequest')->select('conference_id')
                    ->where('conference_id', '=', $request->conference)
                    ->select('id')
                    ->where('start_date', '>',$start)
                    ->where('start_date', '<=', $end)
                    ->where('end_date', '>=', $end)
                    ->where('status','=',0)
                    ->first();

                //3.start in between logic
                $endid = DB::table('conferencerequest')->select('conference_id')
                    ->where('conference_id', $request->conference)
                    ->select('id')
                    ->where('status','=',0)
                    ->where('end_date', '<', $end)
                    ->where('start_date', '<=', $start)
                    ->where('end_date', '>=', $start)
                  
                    ->first();

                    // dd($eid,$endid);
                    //4.Out of bound logic
                $outid = DB::table('conferencerequest')->select('conference_id')
                    ->where('conference_id', $request->conference)
                    ->select('id')
                    ->where('status','=',0)
                    ->where('start_date', '>=', $start)
                    ->where('end_date', '<=', $end)
                    ->first();

                //Checking clash for same meeting hall
                
                   
                //Comparing the database data with form data

                        $start_date = DB::table('conferencerequest')->select('conference_id')
                            ->where('conference_id', $request->conference)
                            ->select('start_date')
                            ->where('start_date', '<=', $start)->count();

                        $end_date = DB::table('conferencerequest')->select('conference_id')
                            ->where('conference_id', $request->conference)
                            ->select('end_date')
                            ->where('end_date', '>=', $end)->count();

                        
                        //Clash condition for between
                        if (($start_date > 0 && $end_date > 0))
                        {

                            //Handling cancel

                            $cancel = DB::table('conferencerequest')
                            ->select('status')
                            ->where('conferencerequest.id', $id->id)
                            ->first();

                           

                            $id = $id->id - 5;//Handling the dummy data


                  if($cancel->status == '1' || $cancel->status == '2'){

			  
		    $id = DB::table('conferencerequest')
                    ->select('conference_id')
                    ->where('conference_id', $request->conference)
                    ->select('id')
                    ->where('status','=',0)

                    ->where('start_date', '<=', $start)
                    ->Where('end_date', '>=', $end)
                    ->first();   

		    $conference = new conferencebook;
                    $conference->emp_id = $request->empId;
                    $conference->name = $request->name;
                    $conference->office_Id = $request->divisionh;

                    $conference->contact_number = $request->contact_number;
                    // $conference->no_of_people = $request->no_of_people;
                    $conference->start_date = $start;
                    $conference->end_date = $end;

                    $conference->conference_id = $request->conference;
                    $conference->meeting_name = $request->meeting_name;

                    $conference->save();

                    //$conference->id, pulling the latest booked id
                    $counterv = $conference->id - 5;

                    //If it is boardroom then display different message 
		
    if ($request->conference == 1)
                    {

                                       
                        $supervisior = [
                            'title' => 'Mail From the BPC System', 
                        'body' => 'Dear sir/madam,',
                         'body1' => 'You have a request for board room approval from ' . $request->name . ' bearing employee id ' . $request->empId . ' of ' . $request->division . '.',
                        'body2' => '', 
                         'body3' => 'Please kindly do the necessary action.', 
                         'body4' => '',
                         'body5' => '', 
                         'body6' => '', ];
        
                        Mail::to('tashidema@bpc.bt')//
                            ->send(new MyTestMail($supervisior));
                        // Mail::to('bosebackup1@gmail.com')
                        //     ->send(new MyTestMail($supervisior));

                        return redirect('/cbook')
                         ->with('alert-message', 'Your booking have beeen initiated with booking number ' . $counterv);
                }

                    else
                    {

                        return redirect('/cbook')
                            ->with('alert-message', 'Booking successfully done with booking number ' . $counterv);

                   }


                  }   
                  
                  else{
                    return redirect()->route('/clash', $id)
                    ->with('clash', "Booking Clashed!!!");

                  }

                           
                        }


                        //Clash condition for end between

                        else if (($eid != null))
                        {
                            $cancel = DB::table('conferencerequest')
                            ->select('status')
                            ->where('conferencerequest.id',$eid->id)
                            ->first();


                            $id = $eid->id - 5;
                     

                  if($cancel->status == '1' || $cancel->status == '2'){

                    $conference = new conferencebook;
                    $conference->emp_id = $request->empId;
                    $conference->name = $request->name;
                    $conference->office_Id = $request->divisionh;

                    $conference->contact_number = $request->contact_number;
                    // $conference->no_of_people = $request->no_of_people;
                    $conference->start_date = $start;
                    $conference->end_date = $end;

                    $conference->conference_id = $request->conference;
                    $conference->meeting_name = $request->meeting_name;

                    $conference->save();

                    //$conference->id, pulling the latest booked id
                    $counterv = $conference->id - 5;

                    //If it is boardroom then display different message 
                    if ($request->conference == 1)
                  {
                    $supervisior = ['title' => 'Mail From the BPC System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for board room approval from ' . $request->name . ' bearing employee Id ' . $request->empId . ' of ' . $request->division . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => '','body5' => '', 'body6' => '',  ];
        
                  Mail::to('tashidema@bpc.bt')//
                    ->send(new MyTestMail($supervisior));
                //   Mail::to('bosebackup1@gmail.com')
                // ->send(new MyTestMail($supervisior));

                        return redirect('/cbook')
                           ->with('alert-message', 'Your booking have beeen initiated with booking number ' . $counterv);
                    }
		   
                   else
                    {
                        return redirect('/cbook')
                            ->with('alert-message', 'Booking successfully done with booking number ' . $counterv);

                    }


                  }   
                  
                  else{
                    return redirect()->route('/clash', $id)
                    ->with('clash', "Booking Clashed!!!");

                  }

                        }

                        
                        else if (($endid != null))
                        {

                            $cancel = DB::table('conferencerequest')->select('status')
                            ->where('conferencerequest.id', $endid->id)
                            ->first();

                            $id = $endid->id - 5;                       

                  if($cancel->status == '1' || $cancel->status == '2'){

                    $conference = new conferencebook;
                    $conference->emp_id = $request->empId;
                    $conference->name = $request->name;
                    $conference->office_Id = $request->divisionh;

                    $conference->contact_number = $request->contact_number;
                    // $conference->no_of_people = $request->no_of_people;
                    $conference->start_date = $start;
                    $conference->end_date = $end;

                    $conference->conference_id = $request->conference;
                    $conference->meeting_name = $request->meeting_name;

                    $conference->save();

                    //$conference->id, pulling the latest booked id
                    $counterv = $conference->id - 5;

                    //If it is boardroom then display different message 
                    if ($request->conference == 1)
                   {

                        $supervisior = ['title' => 'Mail From the BPC System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for board room approval from ' . $request->name . ' bearing employee id ' . $request->empId . ' of ' . $request->division . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => '','body5' => '', 'body6' => '', ];
        
                        Mail::to('tashidema@bpc.bt')//tashipenjor@bpc.bt
                            ->send(new MyTestMail($supervisior));
                            // Mail::to('bosebackup1@gmail.com')
                            // ->send(new MyTestMail($supervisior));

                        return redirect('/cbook')
                            ->with('alert-message', 'Your booking have beeen initiated with booking number ' . $counterv);
                   }

                    else
                  {

                        return redirect('/cbook')
                            ->with('alert-message', 'Booking successfully done with booking number ' . $counterv);

                   }


                  }   
                  
                  else{
                    return redirect()->route('/clash', $id)
                    ->with('clash', "Booking Clashed!!!");

                  }

                        }

                       
                        else if (($outid != null))
                        {

                            
                            $cancel = DB::table('conferencerequest')->select('status')
                            ->where('conferencerequest.id', $outid->id)
                            ->first();

                            $id = $outid->id - 5;

                  if($cancel->status == '1' || $cancel->status == '2'){

                    $conference = new conferencebook;
                    $conference->emp_id = $request->empId;
                    $conference->name = $request->name;
                    $conference->office_Id = $request->divisionh;

                    $conference->contact_number = $request->contact_number;
                    // $conference->no_of_people = $request->no_of_people;
                    $conference->start_date = $start;
                    $conference->end_date = $end;

                    $conference->conference_id = $request->conference;
                    $conference->meeting_name = $request->meeting_name;

                    $conference->save();

                    //$conference->id, pulling the latest booked id
                    $counterv = $conference->id - 5;

                    //If it is boardroom then display different message 
                    if ($request->conference == 1)
                    {

                        $supervisior = ['title' => 'Mail From the BPC System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for board room approval from ' . $request->name . ' bearing employee id ' . $request->empId . ' of ' . $request->division . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => '','body5' => '', 'body6' => '',  ];
        
                        Mail::to('tashidema@bpc.bt') //
                            ->send(new MyTestMail($supervisior));
                            // Mail::to('bosebackup1@gmail.com')
                            // ->send(new MyTestMail($supervisior));

                        return redirect('/cbook')
                            ->with('alert-message', 'Your booking have beeen initiated with booking number ' . $counterv);
                    }

                    else
                    {

                        return redirect('/cbook')
                            ->with('alert-message', 'Booking successfully done with booking number ' . $counterv);

                   }


                  }   
                  
                  else{
                    return redirect()->route('/clash', $id)
                    ->with('clash', "Booking Clashed!!!");

                  }

                        }

                        //if different meeting room or all of the conditions are not true

                        else
                        {

                            $conference = new conferencebook;
                            $conference->emp_id = $request->empId;
                            $conference->name = $request->name;
                            $conference->office_Id = $request->divisionh;

                            $conference->contact_number = $request->contact_number;
                            // $conference->no_of_people = $request->no_of_people;
                            $conference->start_date = $start;
                            $conference->end_date = $end;

                            $conference->conference_id = $request->conference;
                            $conference->meeting_name = $request->meeting_name;

                            $conference->save();

                            //$conference->id, pulling the latest booked id
                            $counterv = $conference->id - 5;

                            //If it is boardroom then display different message 
                            if ($request->conference == 1)
                            {

                                $supervisior = ['title' => 'Mail From the BPC System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for board room approval from ' . $request->name . ' bearing employee id ' . $request->empId . ' of ' . $request->division . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => '','body5' => '', 'body6' => '',  ];
        
                                Mail::to('tashidema@bpc.bt') //
                                    ->send(new MyTestMail($supervisior));
                                    // Mail::to('bosebackup1@gmail.com')
                                    // ->send(new MyTestMail($supervisior));

                                return redirect('/cbook')
                                   ->with('alert-message', 'Your booking have beeen initiated with booking number ' . $counterv);
                            }

                            else
                            {

                                return redirect('/cbook')
                                    ->with('alert-message', 'Booking successfully done with booking number ' . $counterv);

                            }

                        }



            }

            else
            {
                return redirect('/cbook')
                    ->with('error1', 'NOT ALLOWED TO BOOK! YOU DONT HAVE ACCESS TO THIS');

            }
        }


       
//Handling the exception

        catch(\Exception $e)
        {


           //Not allowed to book if user is not present in database 
            if(($conference_user == null)){
                return redirect('/cbook')
                ->with('error1', 'Not allowed to book! null');

            }

            else if (($eid != null))
            {

                // dd("1");


                $cancel = DB::table('conferencerequest')->select('status')
                ->where('conferencerequest.id',$eid->id)
                ->first();


                $id = $eid->id - 5;





         

                if($cancel->status == '1' || $cancel->status == '2'){

                    $conference = new conferencebook;
                    $conference->emp_id = $request->empId;
                    $conference->name = $request->name;
                    $conference->office_Id = $request->divisionh;

                    $conference->contact_number = $request->contact_number;
                    // $conference->no_of_people = $request->no_of_people;
                    $conference->start_date = $start;
                    $conference->end_date = $end;

                    $conference->conference_id = $request->conference;
                    $conference->meeting_name = $request->meeting_name;

                    $conference->save();

                    //$conference->id, pulling the latest booked id
                    $counterv = $conference->id - 5;

                    //If it is boardroom then display different message 
                    if ($request->conference == 1)
                    {
                        $supervisior = ['title' => 'Mail From the BPC System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for board room approval from ' . $request->name . ' bearing employee Id ' . $request->empId . ' of ' . $request->division . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => '','body5' => '', 'body6' => '',  ];

                        Mail::to('tashidema@bpc.bt')//
                            ->send(new MyTestMail($supervisior));
                         //  Mail::to('bosebackup1@gmail.com')
                            // ->send(new MyTestMail($supervisior));

                        return redirect('/cbook')
                            ->with('alert-message', 'Your booking have beeen initiated with booking number ' . $counterv);
                    }

                    else
                    {

                        return redirect('/cbook')
                            ->with('alert-message', 'Booking successfully done with booking number ' . $counterv);

                    }


                }   
                
                else{
                    return redirect()->route('/clash', $id)
                    ->with('clash', "Booking Clashed!!!");

                }

                // $id = $eid->id -5 ;


                // return redirect()->route('/clash', $id)
                //     ->with('clash', "Booking Clashed!!!");

            }

            else if (($endid != null))
            {
		    // dd("2");
	
		     $cancel = DB::table('conferencerequest')->select('status')
                            ->where('conferencerequest.id', $endid->id)
                            ->first();

                            $id = $endid->id - 5;







                  if($cancel->status == '1' || $cancel->status == '2'){

                    $conference = new conferencebook;
                    $conference->emp_id = $request->empId;
                    $conference->name = $request->name;
                    $conference->office_Id = $request->divisionh;

                    $conference->contact_number = $request->contact_number;
                    // $conference->no_of_people = $request->no_of_people;
                    $conference->start_date = $start;
                    $conference->end_date = $end;

                    $conference->conference_id = $request->conference;
                    $conference->meeting_name = $request->meeting_name;

                    $conference->save();

                    //$conference->id, pulling the latest booked id
                    $counterv = $conference->id - 5;

                    //If it is boardroom then display different message
 if ($request->conference == 1)
                   {

                       $supervisior = ['title' => 'Mail From the BPC System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for board room approval from ' . $request->name . ' bearing employee id ' . $request->empId . ' of ' . $request->division . '.', 'body2' => '', 'body3' => 'Please kindly do the necessary action.', 'body4' => '','body5' => '', 'body6' => '', ];

                       Mail::to('tashidema@bpc.bt')//tashidema
                           ->send(new MyTestMail($supervisior));
                        //    Mail::to('bosebackup1@gmail.com')
                        //    ->send(new MyTestMail($supervisior));

                       return redirect('/cbook')
                           ->with('alert-message', 'Your booking have beeen initiated with booking number ' . $counterv);
                   }

                   else
                   {

                        return redirect('/cbook')
                            ->with('alert-message', 'Booking successfully done with booking number ' . $counterv);

                    }


                  }

                

                  else{
                    return redirect()->route('/clash', $id)
                    ->with('clash', "Booking Clashed!!!");

                  }


               // $id = $endid->id -5 ;


               // return redirect()->route('/clash', $id)
                 //   ->with('clash', "Booking Clashed!!!");

            }

            else if (($outid != null))
            {

                // dd("3");


                $id = $outid->id -5 ;


                return redirect()->route('/clash', $id)
                    ->with('clash', "Booking Clashed!!!");

            }

           

            else{



             $conference = new conferencebook;
             $conference->emp_id = $request->empId;
             $conference->name = $request->name;
             $conference->office_Id = $request->divisionh;

             $conference->contact_number = $request->contact_number;
            //  $conference->no_of_people = $request->no_of_people;
             $conference->start_date = $start;
             $conference->end_date = $end;
             $conference->conference_id = $request->conference;
             $conference->meeting_name = $request->meeting_name;

             $conference->save();

             $id_count = $conference->id - 5;

            

	     
            if ($request->conference == 1)
            {

               $supervisior = ['title' => 'Mail From the BPC System', 'body' => 'Dear sir/madam,', 'body1' => 'You have a request for board room approval from ' . $request->name . ' bearing employee id ' . $request->empId . ' of ' . $request->division . '', 'body2' => '.', 'body3' => 'Please kindly do the necessary action.', 'body4' => '','body5' => '', 'body6' => '',  ];
        
               Mail::to('tashidema@bpc.bt')//tsheringwangmo99
                   ->send(new MyTestMail($supervisior));

                //    Mail::to('bosebackup1@gmail.com')
                //    ->send(new MyTestMail($supervisior));

                return redirect('/cbook')
                    ->with('alert-message', 'Your booking have beeen initiated with booking number ' . $id_count);
            }

            else
            {

                 return redirect('/cbook')
                     ->with('alert-message', 'Booking successfully done with booking number ' .$id_count);

             }

            }
          
        }

      
        
    }

//End of post data from conferenceBooking form

    //When PA tshering wangmo approves the board room, it fires this function conferenceapprove 
    public function conferenceapprove(Request $request)
    {
    // Increment the status of the specified conference request
    DB::table('conferencerequest')
    ->where('id', $request->id)
    ->increment('status');

        return redirect('home')
           ->with('page', 'boardroom_review')
            ->with('success', 'You have approved the board room request!');            

    }

//Boardroom approve end   

    //conference reject for board room 
    public function conferencereject(Request $request)
    {

        // Update the reason for rejecting the request
                DB::table('conferencerequest')
                ->where('id', $request->id)
                ->update(['reason' => $request->reason]);

        // Increment the status by 2 to indicate rejection
            DB::table('conferencerequest')
                ->where('id', $request->id)
                ->increment('status', 2);       

        return redirect('home')
            ->with('page', 'boardroom_review')
            ->with('error', 'You have rejected the boardroom request!');
           

    }
//Board room reject end    

//The data will be updated from here
    public function store(Request $request)
    {
        $start1 = $request->start_date;
        $end1 = $request->end_date;
        $start = date("Y-m-d H:i:s", strtotime($start1));
        $end = date("Y-m-d H:i:s", strtotime($end1));

        conferenceRequest::updateOrCreate(['id' => $request->id], ['conference_id' => $request->conference, 'end_date' => $end, 'start_date' => $start]);

        return response()->json(['success' => 'Meeting Room saved successfully.']);
    }
//End of updated data    

//FrontDesk edit modal data 
    public function edit($id)
    {
        
        $conference = conferenceRequest::find($id);
        return response()->json($conference);
    }

//End of  frontDesk edit    

//Cancelling the meeting room from front desk
    public function delete(Request $request)
    {
        $query = DB::table('conferencerequest')->where('id', $request->id)
            ->increment('status');

        return response()
            ->json(['success' => 'Meeting Room cancelled successfully.']);
    }

//end of canceling meeting room

//Loading the booking review page after updating the data
    public function message(Request $request)
    {
        return redirect('home')->with('page', 'booking_review');
    }
//End of loading page

//Track Status page after you insert booking id or employee number
    public function trackview(Request $request)
    {

        if (DB::table('conferencerequest')->where('conferencerequest.emp_id', $request->empId)
            ->orWhere('conferencerequest.id', $request->empId)

            ->exists())
        {
            

            $id = $request->empId + 5;

            if($id < 30000000)
            {

            $review = DB::table('conferencerequest')->join('officedetails', 'officedetails.id', '=', 'conferencerequest.office_Id')
            // ->join('rangeofpeople', 'rangeofpeople.id', '=', 'conferencerequest.no_of_people')                   
            ->join('conference', 'conference.id', '=', 'conferencerequest.conference_id')

                ->Where('conferencerequest.id', $id)
                ->select('conferencerequest.id', 'conferencerequest.conference_id', 'conferencerequest.reason','emp_id', 'name','contact_number','conference.Conference_Name', 'officedetails.officeDetails', 'meeting_name', 'start_date', 'end_date', 'status')
                ->latest('id')
                ->paginate(10000);

            return view('track', compact('review'));

            }
            
            else{
                $review = DB::table('conferencerequest')->join('officedetails', 'officedetails.id', '=', 'conferencerequest.office_Id')
                // ->join('rangeofpeople', 'rangeofpeople.id', '=', 'conferencerequest.no_of_people') 
                  ->join('conference', 'conference.id', '=', 'conferencerequest.conference_id')
                  ->where('conferencerequest.emp_id', $request->empId)
                ->select('conferencerequest.id', 'conferencerequest.conference_id', 'conferencerequest.reason','emp_id', 'name','contact_number','conference.Conference_Name', 'officedetails.officeDetails', 'meeting_name', 'start_date', 'end_date', 'status')
                ->latest('id')
                ->paginate(10000);

            return view('track', compact('review'));
            }
        }

        else
        {
        $review = DB::table('conferencerequest')
        
            ->join('conference', 'conference.id', '=', 'conferencerequest.conference_id')
                ->join('officedetails', 'officedetails.id', '=', 'conferencerequest.office_Id')

                ->where('conference_id', '1')
                ->Where('status', '130')
                ->orWhere('conference_id', '5')
                ->Where('status', '130')

                ->paginate(15);

            return view('track', compact('review'));
        }
    }
//end of Tracking piage    
}
