<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use App\Mail\Ghtestmail;




class MailController extends Controller
{
    public function sendEmail()
    {

        dispatch(new MyTestMail());
        // $details =[
        //     'title' => 'Mail From the BPC System',
        //     'body' => 'This is system generated mail, do not reply.'
        // ];

        // Mail::to("lekiyangdon@bpc.bt")->send(new MyTestMail($details));
        // return "Email Sent";
    }
}
