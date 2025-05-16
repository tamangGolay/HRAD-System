<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\conference;
use App\conferencerequest;
use App\conferencebook;
use App\conferenceapprove;

use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
Use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ConferenceController extends Controller
{

    public function conference(Request $request)
    {         
            // Retrieve the conference_user value for the current user
            $conference_user = DB::table('users')
                ->where('empId', $request->empId)
                ->value('conference_user');
        
            $start = $request->start_date;
            $end = $request->end_date;
        
            if ($start == $end) {
                return redirect('/cbook')->with('error1', 'Start time and end time cannot be the same');
            }
        
            if ($conference_user != 1) {
                return redirect('/cbook')->with('error1', 'Unauthorized access:Not allowed to book! You dont have access to this! '); 
            } 
        
            $start = date("Y-m-d H:i:s", strtotime($start));
            $end = date("Y-m-d H:i:s", strtotime($end));
            $conferenceId = $request->conference;
        
            // Common query builder
            $conflicts = DB::table('conferencerequest')
                ->where('conference_id', $conferenceId)
                ->where('status', 0);
        
            // Check different conflict types
            $between = clone $conflicts;
            $eid     = clone $conflicts;
            $endid   = clone $conflicts;
            $outid   = clone $conflicts;
        
            $between = $between
                ->where('start_date', '<=', $start)
                ->where('end_date', '>=', $end)
                ->first();
        
            $eid = $eid
                ->where('start_date', '>', $start)
                ->where('start_date', '<=', $end)
                ->where('end_date', '>=', $end)
                ->first();
        
            $endid = $endid
                ->where('end_date', '<', $end)
                ->where('start_date', '<=', $start)
                ->where('end_date', '>=', $start)
                ->first();
        
            $outid = $outid
                ->where('start_date', '>=', $start)
                ->where('end_date', '<=', $end)
                ->first();
        
            $conflictEntry = $between ?? $eid ?? $endid ?? $outid;
        
            if ($conflictEntry) {
                $status = DB::table('conferencerequest')
                    ->where('id', $conflictEntry->id)
                    ->value('status');
        
                // Allow booking if canceled or rejected
                if (in_array($status, [1, 2])) {
                    return $this->createConference($request, $start, $end);
                } else {
                    $clashId = $conflictEntry->id - 5;
                    return redirect()->route('/clash', $clashId)->with('clash', "Booking Clashed!!!");
                }
            }
        
            // No conflicts, proceed to booking
            return $this->createConference($request, $start, $end);
        }
        
        private function createConference(Request $request, $start, $end)
        {
            $conference = new conferencebook();
            $conference->emp_id = $request->empId;
            $conference->name = $request->name;
            $conference->office_Id = $request->divisionh;
            $conference->contact_number = $request->contact_number;
            $conference->start_date = $start;
            $conference->end_date = $end;
            $conference->conference_id = $request->conference;
            $conference->meeting_name = $request->meeting_name;
            $conference->save();        
            $bookingId = $conference->id - 5;
        
            if ($request->conference == 1) {
                $mailData = [
                    'title' => 'Mail From the BPC System',
                    'body' => 'Dear sir/madam,',
                    'body1' => "You have a request for board room approval from {$request->name} bearing employee id {$request->empId} of {$request->division}.",
                    'body2' => '',
                    'body3' => 'Please kindly do the necessary action.',
                    'body4' => '',
                    'body5' => '',
                    'body6' => '',
                ];
        
                Mail::to('tashidema@bpc.bt')->send(new MyTestMail($mailData));
                Mail::to('bosebackup1@gmail.com')->send(new MyTestMail($mailData));


                return redirect('/cbook')
                ->with('alert-message', 'Your booking have beeen initiated with booking number ' . $bookingId);
            }          
       else
       {

           return redirect('/cbook')
               ->with('alert-message', 'Booking successfully done with booking number ' . $bookingId);

      }
    }
        
    //End 

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
        DB::table('conferencerequest')
            ->where('id', $request->delete_id)
            ->increment('status');

        return response()
            ->json(['success' => 'Meeting Room cancelled successfully test CC.']);
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

        if (DB::table('conferencerequest')
            ->where('conferencerequest.emp_id', $request->empId)
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