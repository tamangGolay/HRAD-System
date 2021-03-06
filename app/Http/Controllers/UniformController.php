<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Uniform;
use App\UniformEmployee;
use DB;
use Auth;
class UniformController extends Controller
{

    public function store(Request $request)
    {
    // dd($request);
    $uniform = new UniformEmployee;
    $uniform->empId = $request->emp_id;
    // $uniform->empName = $request->name;
    // $uniform->contactNumber = $request->contact_number;
    $uniform->officeId = $request->officeId;
    $uniform->pant = $request->pant;
    $uniform->shirt = $request->shirt;
    $uniform->jacket = $request->jacket;
    $uniform->shoe = $request->shoe;
    $uniform->gumboot = $request->gumboot;
    $uniform->raincoat = $request->raincoat;
    $uniform->createdBy = $request->emp_id;

    $uniform->save();  
                    // dd($request);


                    // CREATE TABLE `officepant` (
                    //     `id` int(3) NOT NULL,
                    //     `officeId` int(3) NOT NULL,
                    //     `uniform_id` int(3) NOT NULL,
                    //     `XS-Female` int(8)  NULL,
                    //   `S-Female`int(8) NULL,
                    //   `M-Female`int(8) NULL ,
                    //   `L-Female`int(8) NULL,
                    //    `XL-Female`int(8) NULL,
                    //   `XXL-Female`int(8) NULL,
                    //   `XXXL-Female`int(8) NULL,
                    //   `XS`int(8) NULL,
                    //    `S`int(8) NULL,
                    //   `M`int(8) NULL,
                    //   `L`int(8) NULL,
                    //    `XL`int(8) NULL,
                    //   `XXL`int(8) NULL,
                    //   `XXXL`int(8) NULL,
                    //   `createdBy` int(8) DEFAULT NULL,
                    //   `createdOn` date DEFAULT NULL,
                    //   `modifiedBy` int(8) DEFAULT NULL,
                    //   `modifiedOn` date DEFAULT NULL
                    //   );
                      
                      
  

    //For IT Division
    //if(dzo = thimphu)
    if($request->officeId == Auth::user()->office){
        //for pant id = 1
        if($request->pant_id == 1){
            if($request->pant == 1){
                // dd($request);

                $rv = DB::table('officepant')->where('uniform_id', 1)
                ->increment('XS-Female');
            }
            // if($request->pant == '2'){
            //     $rv = DB::table('officepant')->where('uniform_id', 1)
            //     ->increment('2');
            // }
            // if($request->pant == '3'){
            //     $rv = DB::table('officepant')->where('uniform_id', 1)
            //     ->increment('3');
            // }
            // if($request->pant == '4'){
            //     $rv = DB::table('officepant')->where('uniform_id', 1)
            //     ->increment('4');
            // }
            // if($request->pant == '5'){
            //     $rv = DB::table('officepant')->where('uniform_id', 1)
            //     ->increment('5');
            // }
            // if($request->pant == '6'){
            //     $rv = DB::table('officepant')->where('uniform_id', 1)
            //     ->increment('6');
            // }
            // if($request->pant == '7'){
            //     $rv = DB::table('officepant')->where('uniform_id', 1)
            //     ->increment('7');
            // }
            // if($request->pant == '8'){
            //     $rv = DB::table('officepant')->where('uniform_id', 1)
            //     ->increment('8');
            // }
            // if($request->pant == '9'){
            //     $rv = DB::table('officepant')->where('uniform_id', 1)
            //     ->increment('9');
            // }
            // if($request->pant == '10'){
            //     $rv = DB::table('officepant')->where('uniform_id', 1)
            //     ->increment('10');
            // }if($request->pant == '11'){
            //     $rv = DB::table('officepant')->where('uniform_id', 1)
            //     ->increment('11');
            // }if($request->pant == '12'){
            //     $rv = DB::table('officepant')->where('uniform_id', 1)
            //     ->increment('12');
            // }if($request->pant == '13'){
            //     $rv = DB::table('officepant')->where('uniform_id', 1)
            //     ->increment('13');
            // }if($request->pant == '14'){
            //     $rv = DB::table('officepant')->where('uniform_id', 1)
            //     ->increment('14');
            // }
        }
//         //for shirt id = 2
//         if($request->shirt_id == '2'){
//             if($request->shirt == 'S'){
//                 $rv = DB::table('officepant')->where('uniform_id', 2)
//                 ->increment('S');
//             }
//             if($request->shirt == 'M'){
//                 $rv = DB::table('officepant')->where('uniform_id', 2)
//                 ->increment('M');
//             }
//             if($request->shirt == 'L'){
//                 $rv = DB::table('officepant')->where('uniform_id', 2)
//                 ->increment('L');
//             }
//             if($request->shirt == 'XL'){
//                 $rv = DB::table('officepant')->where('uniform_id', 2)
//                 ->increment('XL');
//             }
//             if($request->shirt == '2XL'){
//                 $rv = DB::table('officepant')->where('uniform_id', 2)
//                 ->increment('Size_2XL');
//             }
//             if($request->shirt == '3XL'){
//                 $rv = DB::table('officepant')->where('uniform_id', 2)
//                 ->increment('Size_3XL');
//             }
//             if($request->shirt == '4XL'){
//                 $rv = DB::table('officepant')->where('uniform_id', 2)
//                 ->increment('Size_4XL');
//             }
//             if($request->shirt == '5XL'){
//                 $rv = DB::table('officepant')->where('uniform_id', 2)
//                 ->increment('Size_5XL');
//             }
//             if($request->shirt == '6XL'){
//                 $rv = DB::table('officepant')->where('uniform_id', 2)
//                 ->increment('Size_6XL');
//             }
//         }
//         //for jacket id = 3
//         if($request->jacket_id == '3'){
//             if($request->jacket == 'S'){
//                 $rv = DB::table('officepant')->where('uniform_id', 3)
//                 ->increment('S');
//             }
//             if($request->jacket == 'M'){
//                 $rv = DB::table('officepant')->where('uniform_id', 3)
//                 ->increment('M');
//             }
//             if($request->jacket == 'L'){
//                 $rv = DB::table('officepant')->where('uniform_id', 3)
//                 ->increment('L');
//             }
//             if($request->jacket == 'XL'){
//                 $rv = DB::table('officepant')->where('uniform_id', 3)
//                 ->increment('XL');
//             }
//             if($request->jacket == '2XL'){
//                 $rv = DB::table('officepant')->where('uniform_id', 3)
//                 ->increment('Size_2XL');
//             }
//             if($request->jacket == '3XL'){
//                 $rv = DB::table('officepant')->where('uniform_id', 3)
//                 ->increment('Size_3XL');
//             }
//             if($request->jacket == '4XL'){
//                 $rv = DB::table('officepant')->where('uniform_id', 3)
//                 ->increment('Size_4XL');
//             }
//             if($request->jacket == '5XL'){
//                 $rv = DB::table('officepant')->where('uniform_id', 3)
//                 ->increment('Size_5XL');
//             }
//             if($request->jacket == '6XL'){
//                 $rv = DB::table('officepant')->where('uniform_id', 3)
//                 ->increment('Size_6XL');
//             }
//         }

//          //for shoe id = 4
//          if($request->shoe_id == '4'){

//             if($request->shoe == '3'){
//                 $rv = DB::table('officepant')->where('uniform_id', 4)
//                 ->increment('shoe_3');
//             }
//             if($request->shoe == '4'){
//                 $rv = DB::table('officepant')->where('uniform_id', 4)
//                 ->increment('shoe_4');
//             }
//             if($request->shoe == '5'){
//                 $rv = DB::table('officepant')->where('uniform_id', 4)
//                 ->increment('shoe_5');
//             }
//             if($request->shoe == '6'){
//                 $rv = DB::table('officepant')->where('uniform_id', 4)
//                 ->increment('shoe_6');
//             }
//             if($request->shoe == '7'){
//                 $rv = DB::table('officepant')->where('uniform_id', 4)
//                 ->increment('shoe_7');
//             }
//             if($request->shoe == '8'){
//                 $rv = DB::table('officepant')->where('uniform_id', 4)
//                 ->increment('shoe_8');
//             }
//             if($request->shoe == '9'){
//                 $rv = DB::table('officepant')->where('uniform_id', 4)
//                 ->increment('shoe_9');
//             }
//             if($request->shoe == '10'){
//                 $rv = DB::table('officepant')->where('uniform_id', 4)
//                 ->increment('shoe_10');
//             }
//             if($request->shoe == '11'){
//                 $rv = DB::table('officepant')->where('uniform_id', 4)
//                 ->increment('shoe_11');
//             }
//             if($request->shoe == '12'){
//                 $rv = DB::table('officepant')->where('uniform_id', 4)
//                 ->increment('shoe_12');            
//             }
//             if($request->shoe == '13'){
//                 $rv = DB::table('officepant')->where('uniform_id', 4)
//                 ->increment('shoe_13');
//             }
//             if($request->shoe == '14'){
//                 $rv = DB::table('officepant')->where('uniform_id', 4)
//                 ->increment('shoe_14');
//             }
//             if($request->shoe == '15'){
//                 $rv = DB::table('officepant')->where('uniform_id', 4)
//                 ->increment('shoe_15');
//             }
//     } // end for shoe id=4

//     //for gumboot id = 5
//     if($request->jumboot_id == '5'){

//         if($request->gumboot == '3'){
//             $rv = DB::table('officepant')->where('uniform_id', 5)
//             ->increment('shoe_3');
//         }
//         if($request->gumboot == '4'){
//             $rv = DB::table('officepant')->where('uniform_id', 5)
//             ->increment('shoe_4');
//         }
//         if($request->gumboot == '5'){
//             $rv = DB::table('officepant')->where('uniform_id', 5)
//             ->increment('shoe_5');
//         }
//         if($request->gumboot == '6'){
//             $rv = DB::table('officepant')->where('uniform_id', 5)
//             ->increment('shoe_6');
//         }
//         if($request->gumboot == '7'){
//             $rv = DB::tabgumbootle('officepant')->where('uniform_id', 5)
//             ->increment('shoe_7');
//         }
//         if($request->gumboot == '8'){
//             $rv = DB::table('officepant')->where('uniform_id', 5)
//             ->increment('shoe_8');
//         }
//         if($request->gumboot == '9'){
//             $rv = DB::table('officepant')->where('uniform_id', 5)
//             ->increment('shoe_9');
//         }
//         if($request->gumboot == '10'){
//             $rv = DB::table('officepant')->where('uniform_id', 5)
//             ->increment('shoe_10');
//         }
//         if($request->gumboot == '11'){
//             $rv = DB::table('officepant')->where('uniform_id', 5)
//             ->increment('shoe_11');
//         }
//         if($request->gumboot == '12'){
//             $rv = DB::table('officepant')->where('uniform_id', 5)
//             ->increment('shoe_12');            
//         }
//         if($request->gumboot == '13'){
//             $rv = DB::table('officepant')->where('uniform_id', 5)
//             ->increment('shoe_13');
//         }
//         if($request->gumboot == '14'){
//             $rv = DB::table('officepant')->where('uniform_id', 5)
//             ->increment('shoe_14');
//         }
//         if($request->gumboot == '15'){
//             $rv = DB::table('officepant')->where('uniform_id', 5)
//             ->increment('shoe_15');
//         }
// } // end for gumboot id=5



//         //for raincoat id = 6
//         if($request->raincoat_id == '6'){
//             if($request->raincoat == 'S'){
//                 $rv = DB::table('officepant')->where('uniform_id', 6)
//                 ->increment('S');
//             }
//             if($request->raincoat == 'M'){
//                 $rv = DB::table('officepant')->where('uniform_id', 6)
//                 ->increment('M');
//             }
//             if($request->raincoat == 'L'){
//                 $rv = DB::table('officepant')->where('uniform_id', 6)
//                 ->increment('L');
//             }
//             if($request->raincoat == 'XL'){
//                 $rv = DB::table('officepant')->where('uniform_id', 6)
//                 ->increment('XL');
//             }
//             if($request->raincoat == '2XL'){
//                 $rv = DB::table('officepant')->where('uniform_id', 6)
//                 ->increment('Size_2XL');
//             }
//             if($request->raincoat == '3XL'){
//                 $rv = DB::table('officepant')->where('uniform_id', 6)
//                 ->increment('Size_3XL');
//             }
//             if($request->raincoat == '4XL'){
//                 $rv = DB::table('officepant')->where('uniform_id', 6)
//                 ->increment('Size_4XL');
//             }
//             if($request->raincoat == '5XL'){
//                 $rv = DB::table('officepant')->where('uniform_id', 6)
//                 ->increment('Size_5XL');
//             }
//             if($request->raincoat == '6XL'){
//                 $rv = DB::table('officepant')->where('uniform_id', 6)
//                 ->increment('Size_6XL');
//             }
//         }
    // }
     
    return redirect('/home')->with('page', 'uniform')
    ->with('success', 'Data inserted successfully!!!');
    
    }
    }
    //delte indivual record from database

    public function destroy($id)
    {
    $rv = UniformEmployee::findOrFail($id);
    // dd($rv);

    $dbPant = DB::table('officepant')->where('uniform_id', 1);
    $dbShirt = DB::table('officepant')->where('uniform_id', 2);
    $dbJacket = DB::table('officepant')->where('uniform_id', 3);
    $dbShoe = DB::table('officepant')->where('uniform_id', 4);
    $dbGumboot = DB::table('officepant')->where('uniform_id', 5);
    $dbRaincoat = DB::table('officepant')->where('uniform_id', 6);



    if($rv->org_unit_id == 44){
        //for pant id = 1
       
            if($rv->pant == 'S'){
                $dbPant->decrement('S');
            }
            if($rv->pant == 'M'){
                $dbPant->decrement('M');
            }
            if($rv->pant == 'L'){
                $dbPant->decrement('L');
            }
            if($rv->pant == 'XL'){
                $dbPant->decrement('XL');
            }
            if($rv->pant == '2XL'){
                $dbPant->decrement('Size_2XL');
            }
            if($rv->pant == '3XL'){
                $dbPant->decrement('Size_3XL');
            }
            if($rv->pant == '4XL'){
                $dbPant->decrement('Size_4XL');
            }
            if($rv->pant == '5XL'){
                $dbPant->decrement('Size_5XL');
            }
            if($rv->pant == '6XL'){
                $dbPant->decrement('Size_6XL');
            }

        
            
             //for shirt id = 2
        
            if($rv->shirt == 'S'){
                $dbShirt->decrement('S');
            }
            if($rv->shirt == 'M'){
                $dbShirt->decrement('M');
            }
            if($rv->shirt == 'L'){
                $dbShirt->decrement('L');
            }
            if($rv->shirt == 'XL'){
                $dbShirt->decrement('XL');
            }
            if($rv->shirt == '2XL'){
                $dbShirt->decrement('Size_2XL');
            }
            if($rv->shirt == '3XL'){
                $dbShirt->decrement('Size_3XL');
            }
            if($rv->shirt == '4XL'){
                $dbShirt->decrement('Size_4XL');
            }
            if($rv->shirt == '5XL'){
                $dbShirt->decrement('Size_5XL');
            }
            if($rv->shirt == '6XL'){
                $dbShirt->decrement('Size_6XL');
            }

                  // for uniform id=3 (jacket)

                if($rv->jacket == 'S'){
                    $dbJacket->decrement('S');
                }
                if($rv->jacket == 'M'){
                    $dbJacket->decrement('M');
                }
                if($rv->jacket == 'L'){
                    $dbJacket->decrement('L');
                }
                if($rv->jacket == 'XL'){
                    $dbJacket->decrement('XL');
                }
                if($rv->jacket == '2XL'){
                    $dbJacket->decrement('Size_2XL');
                }
                if($rv->jacket == '3XL'){
                    $dbJacket->decrement('Size_3XL');
                }
                if($rv->jacket == '4XL'){
                    
                    $dbJacket->decrement('Size_4XL');
                }
                if($rv->jacket == '5XL'){
                    $dbJacket->decrement('Size_5XL');
                }
                if($rv->jacket == '6XL'){
                    $dbJacket->decrement('Size_6XL');
                }
            
    
             //for shoe id = 4
                 
                if($rv->shoe == '3'){
                    $dbShoe->decrement('shoe_3');
                }
                if($rv->shoe == '4'){
                    $dbShoe->decrement('shoe_4');
                }
                if($rv->shoe == '5'){
                    $dbShoe->decrement('shoe_5');
                }
                if($rv->shoe == '6'){
                    $dbShoe->decrement('shoe_6');
                }
                if($rv->shoe == '7'){
                    $dbShoe->decrement('shoe_7');
                }
                if($rv->shoe == '8'){
                    $dbShoe->decrement('shoe_8');
                }
                if($rv->shoe == '9'){
                    $dbShoe->decrement('shoe_9');
                }
                if($rv->shoe == '10'){
                    $dbShoe->decrement('shoe_10');
                }
                if($rv->shoe == '11'){
                    $dbShoe->decrement('shoe_11');
                }
                if($rv->shoe == '12'){
                    $dbShoe->decrement('shoe_12');            
                }
                if($rv->shoe == '13'){
                    $dbShoe->decrement('shoe_13');
                }
                if($rv->shoe == '14'){
                    $dbShoe->decrement('shoe_14');
                }
                if($rv->shoe == '15'){
                    $dbShoe->decrement('shoe_15');
                }
        //for Gumboot id = 5        
    
            if($rv->jumboot == '3'){
                $dbGumboot->decrement('shoe_3');
            }
            if($rv->jumboot == '4'){
                $dbGumboot->decrement('shoe_4');
            }
            if($rv->jumboot == '5'){
                $dbGumboot->decrement('shoe_5');
            }
            if($rv->jumboot == '6'){
                $dbGumboot->decrement('shoe_6');
            }
            if($rv->jumboot == '7'){
                $dbGumboot->decrement('shoe_7');
            }
            if($rv->jumboot == '8'){
                $dbGumboot->decrement('shoe_8');
            }
            if($rv->jumboot == '9'){
                $dbGumboot->decrement('shoe_9');
            }
            if($rv->jumboot == '10'){
                $dbGumboot->decrement('shoe_10');
            }
            if($rv->jumboot == '11'){
                $dbGumboot->decrement('shoe_11');
            }
            if($rv->jumboot == '12'){
                $dbGumboot->decrement('shoe_12');            
            }
            if($rv->jumboot == '13'){
                $dbGumboot->decrement('shoe_13');
            }
            if($rv->jumboot == '14'){
                $dbGumboot->decrement('shoe_14');
            }
            if($rv->jumboot == '15'){
                $dbGumboot->decrement('shoe_15');
            }
        // end for gumboot id=5
    
            //for raincoat id = 6
            
                if($rv->raincoat == 'S'){
                    $dbRaincoat->decrement('S');
                }
                if($rv->raincoat == 'M'){
                    $dbRaincoat->decrement('M');
                }
                if($rv->raincoat == 'L'){
                    $dbRaincoat->decrement('L');
                }
                if($rv->raincoat == 'XL'){
                    $dbRaincoat->decrement('XL');
                }
                if($rv->raincoat == '2XL'){
                    $dbRaincoat->decrement('Size_2XL');
                }
                if($rv->raincoat == '3XL'){
                    $dbRaincoat->decrement('Size_3XL');
                }
                if($rv->raincoat == '4XL'){
                    $dbRaincoat->decrement('Size_4XL');
                }
                if($rv->raincoat == '5XL'){
                    $dbRaincoat->decrement('Size_5XL');
                }
                if($rv->raincoat == '6XL'){
                    $dbRaincoat->decrement('Size_6XL');
                }
        }

    $rv->delete();

    return redirect('/home')->with('page', 'uniformReport')
    ->with('success', 'The record is deleted!! ');
        }
    //end of delete user uniform record

    //delete count from office record
    
    }