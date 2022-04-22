<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Uniform;
use App\UniformEmployee;
use DB;

class UniformController extends Controller
{

    public function store(Request $request)
    {
    // dd($request);
    $uniform = new UniformEmployee;
    $uniform->emp_id = $request->emp_id;
    $uniform->name = $request->name;
    $uniform->contact_number = $request->contact_number;
    $uniform->org_unit_id = $request->divisionh;
    $uniform->pant = $request->pant;
    $uniform->shirt = $request->shirt;
    $uniform->jacket = $request->jacket;
    $uniform->shoe = $request->shoe;
    $uniform->jumboot = $request->jumboot;
    $uniform->raincoat = $request->raincoat;
    $uniform->save();    

    //For IT Division
    //if(dzo = thimphu)
    if($request->divisionh == 44){
        //for pant id = 1
        if($request->pant_id == '1'){
            if($request->pant == 'S'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->increment('S');
            }
            if($request->pant == 'M'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->increment('M');
            }
            if($request->pant == 'L'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->increment('L');
            }
            if($request->pant == 'XL'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->increment('XL');
            }
            if($request->pant == '2XL'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->increment('2XL');
            }
            if($request->pant == '3XL'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->increment('3XL');
            }
            if($request->pant == '4XL'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->increment('4XL');
            }
            if($request->pant == '5XL'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->increment('5XL');
            }
            if($request->pant == '6XL'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->increment('6XL');
            }
        }
        //for shirt id = 2
        if($request->shirt_id == '2'){
            if($request->shirt == 'S'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->increment('S');
            }
            if($request->shirt == 'M'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->increment('M');
            }
            if($request->shirt == 'L'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->increment('L');
            }
            if($request->shirt == 'XL'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->increment('XL');
            }
            if($request->shirt == '2XL'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->increment('2XL');
            }
            if($request->shirt == '3XL'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->increment('3XL');
            }
            if($request->shirt == '4XL'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->increment('4XL');
            }
            if($request->shirt == '5XL'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->increment('5XL');
            }
            if($request->shirt == '6XL'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->increment('6XL');
            }
        }
        //for jacket id = 3
        if($request->jacket_id == '3'){
            if($request->jacket == 'S'){
                $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                ->increment('S');
            }
            if($request->jacket == 'M'){
                $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                ->increment('M');
            }
            if($request->jacket == 'L'){
                $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                ->increment('L');
            }
            if($request->jacket == 'XL'){
                $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                ->increment('XL');
            }
            if($request->jacket == '2XL'){
                $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                ->increment('2XL');
            }
            if($request->jacket == '3XL'){
                $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                ->increment('3XL');
            }
            if($request->jacket == '4XL'){
                $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                ->increment('4XL');
            }
            if($request->jacket == '5XL'){
                $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                ->increment('5XL');
            }
            if($request->jacket == '6XL'){
                $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                ->increment('6XL');
            }
        }
        //for raincoat id = 6
        if($request->raincoat_id == '6'){
            if($request->raincoat == 'S'){
                $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                ->increment('S');
            }
            if($request->raincoat == 'M'){
                $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                ->increment('M');
            }
            if($request->raincoat == 'L'){
                $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                ->increment('L');
            }
            if($request->raincoat == 'XL'){
                $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                ->increment('XL');
            }
            if($request->raincoat == '2XL'){
                $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                ->increment('2XL');
            }
            if($request->raincoat == '3XL'){
                $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                ->increment('3XL');
            }
            if($request->raincoat == '4XL'){
                $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                ->increment('4XL');
            }
            if($request->raincoat == '5XL'){
                $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                ->increment('5XL');
            }
            if($request->raincoat == '6XL'){
                $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                ->increment('6XL');
            }
        }
    }
     
    return redirect('/home')->with('page', 'uniform')
    ->with('success', 'Data inserted successfully!!!');
    
    }

    //logic for decrement 

   
}
