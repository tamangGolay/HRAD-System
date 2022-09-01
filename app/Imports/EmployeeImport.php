<?php

namespace App\Imports;
use App\Users;

use App\employeeContribution;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;

class EmployeeImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $row['contributiondate'] = date('Y-m-d',strtotime($row['contributiondate']));
        // dd($row);

    //     dd( \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1])
    // );
    
        return new employeeContribution([             
             
              'empId'  => $row['empid'],
              'contributionDate'  =>  $row['contributiondate'],
              'year'   => $row['year'],
              'month'    => $row['month'],
              'amount'  => $row['amount'],
              'officeId' =>  $row['officeid']
             
              
             
        
            ]);


        //    if(!empty($insert_data))
        //    {
        //     DB::table('wfcontribution')->insert($insert_data);
        //    }
          
        // }
    
    }}

    

