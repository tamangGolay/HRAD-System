<?php
         
namespace App\Http\Controllers;
          
use App\employeeContribution;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\Imports\EmployeeImport; 
use Excel;     
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

    public function importForm(){

        return view('import-form');
        }

        public function import(Request $request){

            // dd($request);
           $this->validate($request,
           [ 'file' =>'required|mimes:xls,xlsx,csv'

           ]   );
            
         Excel::import(new EmployeeImport, request()->file('file'));
        


        return back()->with('success', 'Excel Data Imported successfully.');

    }

}
           
        
    