<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class OneEmployeeController extends Controller
{
    //view page
    public function index()
    {
        return view('welfare.oneEmployee');
    }

    public function saveRecord(Request $request){
// dd($request);
        foreach($request->empId as $key=>$insert){

            $saveRecord = [

                'empId' => $request->empId[$key],               
                'contributionDate' => $request->contributionDate[$key],
                'amount' => $request->amount[$key],
                'year' => $request->Year[$key],
                'month' => $request->month[$key],
                'officeId' => $request->officeName[$key],

            ];
            DB::table('wfcontribution')->insert($saveRecord);
        }

        return redirect('home')
        ->with('success', 'Data inserted successfully!');

    }



}