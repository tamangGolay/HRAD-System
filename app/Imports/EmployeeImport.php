<?php

namespace App\Imports;
use App\Users;

use App\employeeContribution;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;

class EmployeeImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {



        //  dd($row);
        return new employeeContribution([
            
            
             
              'empId'  => $row[0],
              'contributionDate'  =>  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1]),
              'year'   => $row[2],
              'month'    => $row[3],
              'amount'  => $row[4],
              'officeId' =>  $row[5],
             
              
             
        
            ]);


        //    if(!empty($insert_data))
        //    {
        //     DB::table('wfcontribution')->insert($insert_data);
        //    }
          
        // }
    
    }}

    

