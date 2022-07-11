<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

use App\Dzongkhags;
use App\Roles;
use App\RoleFormMapping;
use App\User;
use App\RoleUserMappings;
use App\Facility;
use App\Forms;
use App\conferenceRequest;
use App\OrgUnit;
use App\conference;
use App\Vehicles;
use App\roomBed;
use App\status;
use App\guestHouseRate;
use App\conferenceStatus;
use App\rangeofpeople;
use App\Uniform;
use App\drungkhag;
use App\town;
use App\gewog;
use App\village;
use App\place;



class ImportMaster extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'master:import';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'To import master data.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->importDzongkhags('dzongkhags',new Dzongkhags);
        $this->importDrungkhags('drungkhagmaster',new drungkhag);
        $this->importTown('townmaster',new town);
        $this->importGewog('gewogmaster',new gewog);
        $this->importVillage('villagemaster',new village);
        $this->importPlace('placemaster',new place);
        $this->importOrgUnit('OrgUnit',new OrgUnit);
        $this->importRoles('roles',new Roles);
        $this->importUser('user',new User);
        $this->importForms('forms',new Forms);
        $this->importRoleForms('roleformaccess',new RoleFormMapping);        
        $this->importUserRole('roleuser',new RoleUserMappings);
        $this->importrangeofpeople('rangeofpeople',new rangeofpeople);
        $this->importvehicle('vehicleDetails',new vehicles);
        $this->importstatus('status',new status);//.csv and modelname
        $this->importgHouseRate('guestHouseRate',new guestHouseRate);
        $this->importconStatus('conferenceStatus',new conferenceStatus);
        $this->importuniform('uniformcount',new Uniform);

              }

    //function to import agencies list.
    public function importDzongkhags($filename,Model $model) {
        if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
        {
            $this->line("Importing ".$filename." tables...");
            $i=0;
            while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
            {
                $data = [
                        'Dzongkhag_Name' => $data[0]              
                    ];
                try{
                    if($model::firstorCreate($data)) {
                        $i++;
                    }
                }
                catch(\Exception $e) {
                    $this->error('something went wrong... '.$e);
                    return;
                }
            }

            fclose($handle);
            $this->line($i." entries successfully added in ".$filename." table");
        }
    }


     //function to import drungkhag list.
     public function importDrungkhags($filename,Model $model) {
        if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
        {
            $this->line("Importing ".$filename." tables...");
            $i=0;
            while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
            {
                $data = [
                        'drungkhagName' => $data[0],  
                        'dzongkhagId' => $data[1]              
            
                    ];
                try{
                    if($model::firstorCreate($data)) {
                        $i++;
                    }
                }
                catch(\Exception $e) {
                    $this->error('something went wrong... '.$e);
                    return;
                }
            }

            fclose($handle);
            $this->line($i." entries successfully added in ".$filename." table");
        }
    }

     //function to import town list.
     public function importTown($filename,Model $model) {
        if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
        {
            $this->line("Importing ".$filename." tables...");
            $i=0;
            while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
            {
                $data = [
                        'townName' => $data[0],  
                        'townClass' => $data[1],  
                        'dzongkhagId' => $data[2]              
            
                    ];
                try{
                    if($model::firstorCreate($data)) {
                        $i++;
                    }
                }
                catch(\Exception $e) {
                    $this->error('something went wrong... '.$e);
                    return;
                }
            }

            fclose($handle);
            $this->line($i." entries successfully added in ".$filename." table");
        }
    }
     //function to import Gewog list.
     public function importGewog($filename,Model $model) {
        if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
        {
            $this->line("Importing ".$filename." tables...");
            $i=0;
            while( ($data = fgetcsv($handle,100,',')) !== FALSE)
            {               

                    $data = [                       
                        'gewogName' => $data[0],
                        'drungkhagId' => $data[1],
                        'dzongkhagId' => $data[2]
                    ];
                    try{
                        if($model::firstorCreate($data)) {
                            $i++;
                        }
                    }
                    catch(\Exception $e) {
                        $this->error('something went wrong... '.$e);
                        return;
                    }                
                               
            }

            fclose($handle);
            $this->line($i." entries successfully added in ".$filename." table");
        }
    }

     //function to import Gewog list.
     public function importVillage($filename,Model $model) {
        if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
        {
            $this->line("Importing ".$filename." tables...");
            $i=0;
            while( ($data = fgetcsv($handle,100,',')) !== FALSE)
            {               

                    $data = [
                        'villageId' => $data[0],
                       
                        'villageName' => $data[1],
                        'gewogId' => $data[2]
                    ];
                    try{
                        if($model::firstorCreate($data)) {
                            $i++;
                        }
                    }
                    catch(\Exception $e) {
                        $this->error('something went wrong... '.$e);
                        return;
                    }                
                               
            }

            fclose($handle);
            $this->line($i." entries successfully added in ".$filename." table");
        }
    }


     //function to import Gewog list.
     public function importPlace($filename,Model $model) {
        if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
        {
            $this->line("Importing ".$filename." tables...");
            $i=0;
            while( ($data = fgetcsv($handle,100,',')) !== FALSE)
            {               

                    $data = [                       
                        'villageId' => $data[0],
                        'townId' => $data[1],
                        'gewogId' => $data[2],
                        'drungkhagId' => $data[3],
                         'dzongkhagId' => $data[4],
                        'placeCategory' => $data[5]
                    ];
                    try{
                        if($model::firstorCreate($data)) {
                            $i++;
                        }
                    }
                    catch(\Exception $e) {
                        $this->error('something went wrong... '.$e);
                        return;
                    }                
                               
            }

            fclose($handle);
            $this->line($i." entries successfully added in ".$filename." table");
        }
    }

    //function to import ghouserate
public function importgHouseRate($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'grade' => $data[0],
                    'rate' => $data[1]  


                ];
                try{
                    if($model::firstorCreate($data)) {
                        $i++;
                    }
                }
                catch(\Exception $e) {
                    $this->error('something went wrong... '.$e);
                    return;
                }                
           
            
        }

        fclose($handle);
        $this->line($i." entries successfully added in ".$filename." table");
    }
}


     
    

     //function to import roles.
     public function importRoles($filename,Model $model) {
        if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
        {
            $this->line("Importing ".$filename." tables...");
            $i=0;
            while( ($data = fgetcsv($handle,100,',')) !== FALSE)
            {               
                   
                    $data = [                       
                        'name' => $data[0]
                       
                    ];
                    try{
                        if($model::firstorCreate($data)) {
                            $i++;
                        }
                    }
                    catch(\Exception $e) {
                        $this->error('something went wrong... '.$e);
                        return;
                    }                
                               
            }

            fclose($handle);
            $this->line($i." entries successfully added in ".$filename." table");
        }
    }  

     //function to import forms.
     public function importForms($filename,Model $model) {
        if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
        {
            $this->line("Importing ".$filename." tables...");
            $i=0;
            while( ($data = fgetcsv($handle,100,',')) !== FALSE)
            {               
                 
                    $data = [                                               
                        'forms' => $data[0],
                        'description' => $data[1],
                        'group' => $data[2],
                        'menu' => $data[3],
                        'icon' => $data[4]
                    ];
                    try{
                        if($model::firstorCreate($data)) {
                            $i++;
                        }
                    }
                    catch(\Exception $e) {
                        $this->error('something went wrong... '.$e);
                        return;
                    }                
               
                
            }

            fclose($handle);
            $this->line($i." entries successfully added in ".$filename." table");
        }
    }


     //function to import form and role mapping.
     public function importRoleForms($filename,Model $model) {
        if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
        {
            $this->line("Importing ".$filename." tables...");
            $i=0;
            while( ($data = fgetcsv($handle,100,',')) !== FALSE)
            {               
                    
                    $data = [                                               
                        'role_id' => $data[0],
                        'form_id' => $data[1],
                        'created_by' => $data[2]
                    ];
                    try{
                        if($model::firstorCreate($data)) {
                            $i++;
                        }
                    }
                    catch(\Exception $e) {
                        $this->error('something went wrong... '.$e);
                        return;
                    }                
               
                
            }

            fclose($handle);
            $this->line($i." entries successfully added in ".$filename." table");
        }
    }

     //function to import default user admin.
     public function importUser($filename,Model $model) {

        if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
        {
            $this->line("Importing ".$filename." tables...");
            $i=0;
            while( ($data = fgetcsv($handle,10000,',')) !== FALSE)
            {               
                    $data = [  
                                             

                        'name' => $data[0],
                        'emp_id' => $data[1],  
                        'designation' => $data[2],                      
                        'org_unit_id' => $data[3],                      
                        'contact_number'=>$data[4],
                        'conference_user'=>$data[5],
                        'email' => $data[6],
                        'role_id' => $data[7],
                        'grade' => $data[8],
                        'gender' => $data[9],
                        'dzongkhag'  => $data[10]             
                                  
                       

                    ];
                    try{
                        if($model::firstorCreate($data)) {
                            $i++;
                        }
                    }
                    catch(\Exception $e) {
                        $this->error('something went wrong... '.$e);
                        return;
                    }                
               
                
            }

            fclose($handle);
            $this->line($i." entries successfully added in ".$filename." table");
        }
    }





     //function to import user and role mapping.
     public function importUserRole($filename,Model $model) {
        if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
        {
            $this->line("Importing ".$filename." tables...");
            $i=0;
            while( ($data = fgetcsv($handle,100,',')) !== FALSE)
            {               
                  
                    $data = [                       
                        'user_id' => $data[0],
                        'role_id' => $data[1],
                        'created_by' => $data[2]
                    ];
                    try{
                        if($model::firstorCreate($data)) {
                            $i++;
                        }
                    }
                    catch(\Exception $e) {
                        $this->error('something went wrong... '.$e);
                        return;
                    }                
               
                
            }

            fclose($handle);
            $this->line($i." entries successfully added in ".$filename." table");
        }
    }

    
   




    

    //function to import division.
    public function importOrgUnit($filename,Model $model) {
        if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
        {
            $this->line("Importing ".$filename." tables...");
            $i=0;
            while( ($data = fgetcsv($handle,100,',')) !== FALSE)
            {               

                    $data = [                       
                        'code' => $data[0],
                        'description' => $data[1],
                        'parent_id' => $data[2]

                          

                    ];
                    try{
                        if($model::firstorCreate($data)) {
                            $i++;
                        }
                    }
                    catch(\Exception $e) {
                        $this->error('something went wrong... '.$e);
                        return;
                    }                
               
                
            }

            fclose($handle);
            $this->line($i." entries successfully added in ".$filename." table");
        }
    }
      


    

     //function to import rangeofpeople.
     public function importrangeofpeople($filename,Model $model) {
        if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
        {
            $this->line("Importing ".$filename." tables...");
            $i=0;
            while( ($data = fgetcsv($handle,100,',')) !== FALSE)
            {               

                    $data = [                       
                        'range' => $data[0]
                        

                     
                    ];
                    try{
                        if($model::firstorCreate($data)) {
                            $i++;
                        }
                    }
                    catch(\Exception $e) {
                        $this->error('something went wrong... '.$e);
                        return;
                    }                
               
                
            }

            fclose($handle);
            $this->line($i." entries successfully added in ".$filename." table");
        }
    }



   


//function to import vehicle details.
public function importvehicle($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,100,',')) !== FALSE)
        {               

                $data = [                       
                    'vehicle_name' => $data[0], 
                    'vehicle_number' => $data[1]
                                        
                 
                ];
                try{
                    if($model::firstorCreate($data)) {
                        $i++;
                    }
                }
                catch(\Exception $e) {
                    $this->error('something went wrong... '.$e);
                    return;
                }                
           
            
        }

        fclose($handle);
        $this->line($i." entries successfully added in ".$filename." table");
    }
}
 


//function to import status
public function importstatus($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [    
                    'ids' => $data[0] ,
                   
                    'action' => $data[1] 

                ];
                try{
                    if($model::firstorCreate($data)) {
                        $i++;
                    }
                }
                catch(\Exception $e) {
                    $this->error('something went wrong... '.$e);
                    return;
                }                
           
            
        }

        fclose($handle);
        $this->line($i." entries successfully added in ".$filename." table");
    }
}







public function importconStatus($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'ids' => $data[0],
                    'state' => $data[1]

                    


                ];
                try{
                    if($model::firstorCreate($data)) {
                        $i++;
                    }
                }
                catch(\Exception $e) {
                    $this->error('something went wrong... '.$e);
                    return;
                }                
           
            
        }

        fclose($handle);
        $this->line($i." entries successfully added in ".$filename." table");
    }
}


public function importuniform($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'org_unit_id' => $data[0],
                    'uniform_id' => $data[1],  
                    'S' => $data[2],                      
                    'M' => $data[3],                      
                    'L'=>$data[4],
                    'XL'=>$data[5],
                    'Size_2XL' => $data[6],
                    'Size_3XL' => $data[7],
                    'Size_4XL' => $data[8],
                    'Size_5XL' => $data[9],
                    'Size_6XL'  => $data[10],
                    'shoe_3' =>$data[11],
                    'shoe_4' =>$data[12],
                    'shoe_5' =>$data[13],
                    'shoe_6' =>$data[14],
                    'shoe_7' =>$data[15],
                    'shoe_8' =>$data[16],
                    'shoe_9' =>$data[17],
                    'shoe_10' =>$data[18],
                    'shoe_11' =>$data[19],
                    'shoe_12' =>$data[20],
                    'shoe_13' =>$data[21],
                    'shoe_14' =>$data[22],
                    'shoe_15' =>$data[23],                   
                    'dzongkhag'  => $data[24]                    


                ];
                try{
                    if($model::firstorCreate($data)) {
                        $i++;
                    }
                }
                catch(\Exception $e) {
                    $this->error('something went wrong... '.$e);
                    return;
                }                
           
            
        }

        fclose($handle);
        $this->line($i." entries successfully added in ".$filename." table");
    }
}


}