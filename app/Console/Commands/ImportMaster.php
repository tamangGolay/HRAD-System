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
use App\guesthouse;
use App\guestHouseRoom;
use App\roomBed;
use App\status;
use App\guestHouseRate;
use App\conferenceStatus;
use App\rangeofpeople;


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
        $this->importOrgUnit('OrgUnit',new OrgUnit);
        $this->importRoles('roles',new Roles);
        $this->importUser('user',new User);
        $this->importForms('forms',new Forms);
        $this->importRoleForms('roleformaccess',new RoleFormMapping);        
        $this->importUserRole('roleuser',new RoleUserMappings);
        $this->importrangeofpeople('rangeofpeople',new rangeofpeople);
        $this->importvehicle('vehicleDetails',new vehicles);
        $this->importguestHouse('guestHouseName',new guesthouse);//.csv and modelname
        $this->importguestHouseRoom('guestHouseRoom',new guestHouseRoom);//.csv and modelname
        $this->importrb_book('roomBed',new roomBed);//.csv and modelname
        $this->importstatus('status',new status);//.csv and modelname
        $this->importgHouseRate('guestHouseRate',new guestHouseRate);
        $this->importconStatus('conferenceStatus',new conferenceStatus);

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
     //function to import divisions list.
     public function importGewogs($filename,Model $model) {
        if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
        {
            $this->line("Importing ".$filename." tables...");
            $i=0;
            while( ($data = fgetcsv($handle,100,',')) !== FALSE)
            {               

                    $data = [                       
                        'gewog_name' => $data[0],
                        'dzongkhag_id' => $data[1],
                        'type' => $data[2]
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
 
//function to import Facility list
public function importguestHouse($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,100,',')) !== FALSE)
        {               

                $data = [                       
                    'name' => $data[0], 
                    'dzo_id' => $data[1]
                                        
                      
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



//function to import guest house room
public function importguestHouseRoom($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'room_no' => $data[0], 
                    'bed_no' => $data[1],
                    'guest_house_id' => $data[2],
                    'dzo_id' => $data[3]


      
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


//function to import roomBed
public function importrb_book($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'guest_house_id' => $data[0], 
                    'org_unit_id' => $data[1],
                    'emp_id' => $data[2],
                    'dzongkhag' => $data[3], 
                    'roomdetails_id' => $data[4], 
                    'gender' => $data[5],
                    'name' => $data[6],
                    'check_in' => $data[7], 
                    'check_out' => $data[8],
                    'email' => $data[9]


                    
      
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


}