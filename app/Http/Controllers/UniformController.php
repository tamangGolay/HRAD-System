<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Uniform;
use App\UniformEmployee;
use DB;
use Auth;

class UniformController extends Controller
{



    public function index(Request $request)
    {
        dd($request);
        $pay = DB::table('employeeuniform')
        ->join('pantmaster', 'pantmaster.id', '=', 'employeeuniform.pant')
        ->join('shirtmaster', 'shirtmaster.id', '=', 'employeeuniform.shirt')
        ->join('jacketmaster', 'jacketmaster.id', '=', 'employeeuniform.jacket')
        ->join('shoesize', 'shoesize.id', '=', 'employeeuniform.shoe')
        ->join('shoesize as gumboot', 'gumboot.id', '=', 'employeeuniform.shoe')
        ->join('raincoatsize', 'raincoatsize.id', '=', 'employeeuniform.raincoat')
        ->join('officedetails', 'officedetails.id', '=', 'employeeuniform.officeId')
        ->where('status', 0)
        ->select('employeeuniform.id as uniformId','employeeuniform.*','officedetails.shortOfficeName',
        'pantmaster.pantSizeName','shirtmaster.shirtSizeName','jacketmaster.sizeName as jacket',
        'shoesize.ukShoeSize','raincoatsize.sizeName')
                    ->paginate(10000);
        
        if ($request->ajax()) {
            $data = $pay;
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                          



    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('uniform.uniformReport',compact('pay'));
    }

    public function store(Request $request)
    {
     dd($request);
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
                      
                               

     
    return redirect('/home')->with('page', 'uniform')
    ->with('success', 'Data inserted successfully!!!');
    
    
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