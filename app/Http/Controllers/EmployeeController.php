<?php
         
namespace App\Http\Controllers;
          
use App\employeeContribution;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\Imports\EmployeeImport; 
use Excel;     
use Validator;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

//LekiCSV

    // public function importForm(){

    //     return view('import-form');
    //     }

        public function import(Request $request){

                        // $validator = Validator::make($request->all(), [
            //     'file' => 'required|mimes:xls,xlsx,csv',
            // ]);
     
            // if ($validator->fails()) {
            //     return redirect('home')->with('page', 'allEmployeeContribution')
            //                 ->withErrors($validator)
            //                 ->withInput();
            // }
    // $validator = $this->validate($request,
    //        [ 'file' =>'required|mimes:xls,xlsx,csv'

    //        ]);
           
    // if ($validator->fails()) {

    //     return redirect('home')->with('page', 'allEmployeeContribution')
    //                     ->withErrors($validator)
    //                     ->withInput();
    // }

        try{
                
            
         Excel::import(new EmployeeImport, request()->file('file'));
        
        //  return view('welfare.allEmployeeContribution')
        //  ->with('success', 'Excel Data Imported successfully.');

        return redirect('home')->with('page', 'allEmployeeContribution')
        ->with('success', 'Excel Data Imported successfully.');

                }

        

        catch(\Illuminate\Database\QueryException $e){

            // \Session::flash('error', 'Unable to process request.Error:'.json_encode($e->getMessage(), true));
        //   }
        
        return redirect('home')->with('page', 'allEmployeeContribution')
                                    ->with('error',"Sorry!.The Records must be in csv format only and it should not contains null values or wrong data.");
                
        }
    }
    
    public function tocheckofficeId()
    {       
     
        $tocheckofficeId = DB::table('officedetails')
       
       ->select('id','officeDetails')
        ->paginate(10000000);
    
    
    $rhtml = view('welfare.officeId')->with(['tocheckofficeId' => $tocheckofficeId])->render();
    return response()
      ->json(array(
      'success' => true,
      'html' => $rhtml
    ));
    } 

    public function backtopage()
    {  
    
    $rhtml = view('welfare.allEmployeeContribution')->render();
    return response()
      ->json(array(
      'success' => true,
      'html' => $rhtml
    ));
    }  
    

}
          
        
    