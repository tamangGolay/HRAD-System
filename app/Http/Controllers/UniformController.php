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
                ->increment('Size_2XL');
            }
            if($request->pant == '3XL'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->increment('Size_3XL');
            }
            if($request->pant == '4XL'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->increment('Size_4XL');
            }
            if($request->pant == '5XL'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->increment('Size_5XL');
            }
            if($request->pant == '6XL'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->increment('Size_6XL');
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
                ->increment('Size_2XL');
            }
            if($request->shirt == '3XL'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->increment('Size_3XL');
            }
            if($request->shirt == '4XL'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->increment('Size_4XL');
            }
            if($request->shirt == '5XL'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->increment('Size_5XL');
            }
            if($request->shirt == '6XL'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->increment('Size_6XL');
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
                ->increment('Size_2XL');
            }
            if($request->jacket == '3XL'){
                $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                ->increment('Size_3XL');
            }
            if($request->jacket == '4XL'){
                $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                ->increment('Size_4XL');
            }
            if($request->jacket == '5XL'){
                $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                ->increment('Size_5XL');
            }
            if($request->jacket == '6XL'){
                $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                ->increment('Size_6XL');
            }
        }

         //for shoe id = 4
         if($request->shoe_id == '4'){

            if($request->shoe == '3'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                ->increment('shoe_3');
            }
            if($request->shoe == '4'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                ->increment('shoe_4');
            }
            if($request->shoe == '5'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                ->increment('shoe_5');
            }
            if($request->shoe == '6'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                ->increment('shoe_6');
            }
            if($request->shoe == '7'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                ->increment('shoe_7');
            }
            if($request->shoe == '8'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                ->increment('shoe_8');
            }
            if($request->shoe == '9'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                ->increment('shoe_9');
            }
            if($request->shoe == '10'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                ->increment('shoe_10');
            }
            if($request->shoe == '11'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                ->increment('shoe_11');
            }
            if($request->shoe == '12'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                ->increment('shoe_12');            
            }
            if($request->shoe == '13'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                ->increment('shoe_13');
            }
            if($request->shoe == '14'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                ->increment('shoe_14');
            }
            if($request->shoe == '15'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                ->increment('shoe_15');
            }
    } // end for shoe id=4

    //for gumboot id = 5
    if($request->jumboot_id == '5'){

        if($request->jumboot == '3'){
            $shoe = DB::table('officeuniform')->where('uniform_id', 5)
            ->increment('shoe_3');
        }
        if($request->jumboot == '4'){
            $shoe = DB::table('officeuniform')->where('uniform_id', 5)
            ->increment('shoe_4');
        }
        if($request->jumboot == '5'){
            $shoe = DB::table('officeuniform')->where('uniform_id', 5)
            ->increment('shoe_5');
        }
        if($request->jumboot == '6'){
            $shoe = DB::table('officeuniform')->where('uniform_id', 5)
            ->increment('shoe_6');
        }
        if($request->jumboot == '7'){
            $shoe = DB::table('officeuniform')->where('uniform_id', 5)
            ->increment('shoe_7');
        }
        if($request->jumboot == '8'){
            $shoe = DB::table('officeuniform')->where('uniform_id', 5)
            ->increment('shoe_8');
        }
        if($request->jumboot == '9'){
            $shoe = DB::table('officeuniform')->where('uniform_id', 5)
            ->increment('shoe_9');
        }
        if($request->jumboot == '10'){
            $shoe = DB::table('officeuniform')->where('uniform_id', 5)
            ->increment('shoe_10');
        }
        if($request->jumboot == '11'){
            $shoe = DB::table('officeuniform')->where('uniform_id', 5)
            ->increment('shoe_11');
        }
        if($request->jumboot == '12'){
            $shoe = DB::table('officeuniform')->where('uniform_id', 5)
            ->increment('shoe_12');            
        }
        if($request->jumboot == '13'){
            $shoe = DB::table('officeuniform')->where('uniform_id', 5)
            ->increment('shoe_13');
        }
        if($request->jumboot == '14'){
            $shoe = DB::table('officeuniform')->where('uniform_id', 5)
            ->increment('shoe_14');
        }
        if($request->jumboot == '15'){
            $shoe = DB::table('officeuniform')->where('uniform_id', 5)
            ->increment('shoe_15');
        }
} // end for gumboot id=5



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
                ->increment('Size_2XL');
            }
            if($request->raincoat == '3XL'){
                $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                ->increment('Size_3XL');
            }
            if($request->raincoat == '4XL'){
                $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                ->increment('Size_4XL');
            }
            if($request->raincoat == '5XL'){
                $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                ->increment('Size_5XL');
            }
            if($request->raincoat == '6XL'){
                $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                ->increment('Size_6XL');
            }
        }

        
    }
     
    return redirect('/home')->with('page', 'uniform')
    ->with('success', 'Data inserted successfully!!!');
    
    }

    //delte indivual record from database

    public function destroy($id)
    {
    $rv = UniformEmployee::findOrFail($id);

    // $id = DB::table('employeeuniform')->select('id')
    // ->where('id', $id)
    // ->first();

    $org_unit_id = DB::table('employeeuniform')->join('orgunit', 'orgunit.id', '=', 'employeeuniform.org_unit_id')
    ->select('org_unit_id', 'description')
    ->where('employeeuniform.id', '=', $id)
    ->first();

    $pant = DB::table('employeeuniform')->select('pant')
    ->where('id', '=', $id)
    ->first();  
    
    // dd($pant->pant);
    
    $shirt = DB::table('employeeuniform')->select('shirt')
    ->where('id', '=', $id)
    ->first();   

    $jacket = DB::table('employeeuniform')->select('jacket')
    ->where('id', '=', $id)
    ->first();   

    $raincoat = DB::table('employeeuniform')->select('raincoat')
    ->where('id', '=', $id)
    ->first();   

    $shoe = DB::table('employeeuniform')->select('shoe')
    ->where('id', '=', $id)
    ->first();   

    $jumboot = DB::table('employeeuniform')->select('jumboot')
    ->where('id', '=', $id)
    ->first();   

    if($org_unit_id->org_unit_id == 44){
        //for pant id = 1
        
            if($pant->pant == 'S'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->decrement('S');
            }
            if($pant->pant == 'M'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->decrement('M');
            }
            if($pant->pant == 'L'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->decrement('L');
            }
            if($pant->pant == 'XL'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->decrement('XL');
            }
            if($pant->pant == '2XL'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->decrement('Size_2XL');
            }
            if($pant->pant == '3XL'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->decrement('Size_3XL');
            }
            if($pant->pant == '4XL'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->decrement('Size_4XL');
            }
            if($pant->pant == '5XL'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->decrement('Size_5XL');
            }
            if($pant->pant == '6XL'){
                $pant = DB::table('officeuniform')->where('uniform_id', 1)
                ->decrement('Size_6XL');
            }
            
             //for shirt id = 2
        
            if($shirt->shirt == 'S'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->decrement('S');
            }
            if($shirt->shirt == 'M'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->decrement('M');
            }
            if($shirt->shirt == 'L'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->decrement('L');
            }
            if($shirt->shirt == 'XL'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->decrement('XL');
            }
            if($shirt->shirt == '2XL'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->decrement('Size_2XL');
            }
            if($shirt->shirt == '3XL'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->decrement('Size_3XL');
            }
            if($shirt->shirt == '4XL'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->decrement('Size_4XL');
            }
            if($shirt->shirt == '5XL'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->decrement('Size_5XL');
            }
            if($shirt->shirt == '6XL'){
                $shirt = DB::table('officeuniform')->where('uniform_id', 2)
                ->decrement('Size_6XL');
                  }

                  // for uniform id=3 (jacket)

                if($jacket->jacket == 'S'){
                    $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                    ->decrement('S');
                }
                if($jacket->jacket == 'M'){
                    $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                    ->decrement('M');
                }
                if($jacket->jacket == 'L'){
                    $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                    ->decrement('L');
                }
                if($jacket->jacket == 'XL'){
                    $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                    ->decrement('XL');
                }
                if($jacket->jacket == '2XL'){
                    $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                    ->decrement('Size_2XL');
                }
                if($jacket->jacket == '3XL'){
                    $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                    ->decrement('Size_3XL');
                }
                if($jacket->jacket == '4XL'){
                    $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                    ->decrement('Size_4XL');
                }
                if($jacket->jacket == '5XL'){
                    $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                    ->decrement('Size_5XL');
                }
                if($jacket->jacket == '6XL'){
                    $jacket = DB::table('officeuniform')->where('uniform_id', 3)
                    ->decrement('Size_6XL');
                }
            
    
             //for shoe id = 4
                 
                if($shoe->shoe == '3'){
                    $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                    ->decrement('shoe_3');
                }
                if($shoe->shoe == '4'){
                    $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                    ->decrement('shoe_4');
                }
                if($shoe->shoe == '5'){
                    $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                    ->decrement('shoe_5');
                }
                if($shoe->shoe == '6'){
                    $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                    ->decrement('shoe_6');
                }
                if($shoe->shoe == '7'){
                    $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                    ->decrement('shoe_7');
                }
                if($shoe->shoe == '8'){
                    $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                    ->decrement('shoe_8');
                }
                if($shoe->shoe == '9'){
                    $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                    ->decrement('shoe_9');
                }
                if($shoe->shoe == '10'){
                    $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                    ->decrement('shoe_10');
                }
                if($shoe->shoe == '11'){
                    $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                    ->decrement('shoe_11');
                }
                if($shoe->shoe == '12'){
                    $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                    ->decrement('shoe_12');            
                }
                if($shoe->shoe == '13'){
                    $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                    ->decrement('shoe_13');
                }
                if($shoe->shoe == '14'){
                    $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                    ->decrement('shoe_14');
                }
                if($shoe->shoe == '15'){
                    $shoe = DB::table('officeuniform')->where('uniform_id', 4)
                    ->decrement('shoe_15');
                }
        
    
        //for Gumboot id = 5        
    
            if($jumboot->jumboot == '3'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 5)
                ->decrement('shoe_3');
            }
            if($jumboot->jumboot == '4'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 5)
                ->decrement('shoe_4');
            }
            if($jumboot->jumboot == '5'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 5)
                ->decrement('shoe_5');
            }
            if($jumboot->jumboot == '6'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 5)
                ->decrement('shoe_6');
            }
            if($jumboot->jumboot == '7'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 5)
                ->decrement('shoe_7');
            }
            if($jumboot->jumboot == '8'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 5)
                ->decrement('shoe_8');
            }
            if($jumboot->jumboot == '9'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 5)
                ->decrement('shoe_9');
            }
            if($jumboot->jumboot == '10'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 5)
                ->decrement('shoe_10');
            }
            if($jumboot->jumboot == '11'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 5)
                ->decrement('shoe_11');
            }
            if($jumboot->jumboot == '12'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 5)
                ->decrement('shoe_12');            
            }
            if($jumboot->jumboot == '13'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 5)
                ->decrement('shoe_13');
            }
            if($jumboot->jumboot == '14'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 5)
                ->decrement('shoe_14');
            }
            if($jumboot->jumboot == '15'){
                $shoe = DB::table('officeuniform')->where('uniform_id', 5)
                ->decrement('shoe_15');
            }
        // end for gumboot id=5
    
    
    
            //for raincoat id = 6
            
                if($raincoat->raincoat == 'S'){
                    $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                    ->decrement('S');
                }
                if($raincoat->raincoat == 'M'){
                    $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                    ->decrement('M');
                }
                if($raincoat->raincoat == 'L'){
                    $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                    ->decrement('L');
                }
                if($raincoat->raincoat == 'XL'){
                    $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                    ->decrement('XL');
                }
                if($raincoat->raincoat == '2XL'){
                    $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                    ->decrement('Size_2XL');
                }
                if($raincoat->raincoat == '3XL'){
                    $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                    ->decrement('Size_3XL');
                }
                if($raincoat->raincoat == '4XL'){
                    $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                    ->decrement('Size_4XL');
                }
                if($raincoat->raincoat == '5XL'){
                    $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                    ->decrement('Size_5XL');
                }
                if($raincoat->raincoat == '6XL'){
                    $raincoat = DB::table('officeuniform')->where('uniform_id', 6)
                    ->decrement('Size_6XL');
                }
        

            
            
                               
        }

    $rv->delete();

    return redirect('/home')->with('page', 'uniformReport')
    ->with('success', 'The record is deleted!! ');
        }
    //end of delete user uniform record

    //delete count from office record
    
    }