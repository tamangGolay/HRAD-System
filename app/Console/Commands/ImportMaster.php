<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

use App\Dzongkhags;
use App\Roles;
use App\RoleFormMapping;
use App\User;
use App\RoleUserMappings;
use App\Forms;
use App\OrgUnit;
use App\Uniform;
use App\drungkhag;
use App\town;
use App\gewog;
use App\village;
use App\place;
use App\QualificationLevel; 
use App\bank;
use App\Designation;
use App\Resignation;
use App\Relationname;
use App\Leavetype;
use App\Officem;
use App\officeName;
use App\EmployeeMaster;
use App\ContractDetailMaster;
use App\Qualification;
use App\Field;
use App\pay;
use App\PostMaster;
use App\EmployeeQualification;
use App\Pant;
use App\JacketSize;
use App\Shirt;
use App\Shoesize;
use App\RainCoatSize;
use App\SkillCategory;
use App\SubSkillCategory;
use App\Skillmaster;
use App\officeAdmin;

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
       
        // $this->importDzongkhags('dzongkhags',new Dzongkhags);  //csv n  model
        // $this->importDrungkhags('drungkhagmaster',new drungkhag);
        // $this->importTown('townmaster',new town);
        // $this->importGewog('gewogmaster',new gewog);
        // $this->importVillage('villagemaster',new village);
        // $this->importPlace('placemaster',new place);
        // $this->importOrgUnit('OrgUnit',new OrgUnit);
        // $this->importRoles('roles',new Roles);
        // // $this->importUser('user',new User);
        // // $this->importForms('forms',new Forms);
        // // $this->importRoleForms('roleformaccess',new RoleFormMapping);        
        // // $this->importUserRole('roleuser',new RoleUserMappings);
        // $this->importuniform('uniformcount',new Uniform);
        // $this->importQualiLevel('qualification',new QualificationLevel); 
        // $this->importbank('bank',new bank);
        
        // $this->importdesignation('designation',new Designation);
        // $this->importresignation('resignation',new Resignation);
        // $this->importrelation('relationname',new Relationname);
        // $this->importleavetype('leaveType',new Leavetype);
        // $this->importofficename('officename',new officeName);// csv and model
        // $this->importofficemaster('officeMaster',new Officem);
        // $this->importUser('employeemaster',new EmployeeMaster);   // csv n modal name employee master
        // $this->importForms('forms',new Forms);
        // $this->importRoleForms('roleformaccess',new RoleFormMapping);        
        // $this->importUserRole('roleuser',new RoleUserMappings);   // csv n modal name employee master
        
        // $this->importcontractdetails('contractdetails',new ContractDetailMaster);
        // $this->importfield('field',new Field);
        // $this->importqualificationmaster('qualificationmaster',new Qualification);        
        // $this->importpayscale('payscale',new pay);
        // $this->importpostmaster('postmaster',new PostMaster);
        // $this->importemployeequalification('employeequalification',new EmployeeQualification);
        // $this->importpant('Pant',new Pant);
        // $this->importshirt('Shirt',new Shirt);
        // $this->importjacket('jacket',new JacketSize);
        // $this->importshoesize('shoesize',new Shoesize);
        // $this->importraincoatsize('raincoatsize',new RainCoatSize);
        // $this->importskillcategory('skillcategory',new SkillCategory);
        // $this->importskillsubcategory('skillsubcategory',new SubSkillCategory);  //csv n model
        // $this->importskillmaster('skillmaster',new Skillmaster);
        // $this->importofficeAdmin('officeAdmin',new officeAdmin);
            

     }

     
    
//import post master
public function importpostmaster($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'shortName' => $data[0],  //database field name
                    'longName' => $data[1],
                    'positionSpecificAllowance' => $data[2],
                    'contractAllowance' => $data[3],
                    'communicationAllowance' => $data[4],
                    'type' => $data[5]
                    
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
//end of post master




//function to import pay scale

public function importpayscale($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'grade' => $data[0],  //database field name
                    'low' => $data[1],
                    'increment' => $data[2],
                    'high' => $data[3]
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

//end of pay scale


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

    //  //function to import default user admin.
    //  public function importUser($filename,Model $model) {

    //     if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    //     {
    //         $this->line("Importing ".$filename." tables...");
    //         $i=0;
    //         while( ($data = fgetcsv($handle,10000,',')) !== FALSE)
    //         {               
    //                 $data = [  
                                             

    //                     'name' => $data[0],
    //                     'emp_id' => $data[1],  
    //                     'designation' => $data[2],                      
    //                     'org_unit_id' => $data[3],                      
    //                     'contact_number'=>$data[4],
    //                     'conference_user'=>$data[5],
    //                     'email' => $data[6],
    //                     'role_id' => $data[7],
    //                     'grade' => $data[8],
    //                     'gender' => $data[9],
    //                     'dzongkhag'  => $data[10]             
                                  
                       

    //                 ];
    //                 try{
    //                     if($model::firstorCreate($data)) {
    //                         $i++;
    //                     }
    //                 }
    //                 catch(\Exception $e) {
    //                     $this->error('something went wrong... '.$e);
    //                     return;
    //                 }                
               
                
    //         }

    //         fclose($handle);
    //         $this->line($i." entries successfully added in ".$filename." table");
    //     }
    // }





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

public function importbank($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'bankName' => $data[0]              

                    


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

//function to import qualification levels
public function importQualiLevel($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'qualiLevelName' => $data[0]            
                                    


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

//sonam
//sonam



public function importdesignation($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'desisNameShort' => $data[0],
                    'desisNameLong' => $data[1]            
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

public function importresignation($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'resignationType' => $data[0]                    
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

public function importleavetype($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'leaveType' => $data[0]                    
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

public function importofficemaster($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'officeName' => $data[0],    
                    'officeAddress' => $data[1],    
                    'officeHead' => $data[2],
                    'reportToOffice' => $data[3],
                    'createdBy' => $data[4]
                    

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

public function importofficename($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'shortOfficeName' => $data[0],    
                    'longOfficeName' => $data[1],
                    'officeType' => $data[2],    
                                       
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
//end sonam
// to import services


public function importrelation($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'relationshipName' => $data[0],    
                    'verification' => $data[1]                     
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
//end of service
//contract details import
public function importcontractdetails($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'personalNo' => $data[0],    
                    'startDate' => $data[1],
                    'endDate' => $data[2],
                    'termNo' => $data[3]                      
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
//end of contract details


//function to import User master level for employeemaster
public function importUser($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

            $data = [
                'empId' => $data[0],
                'empName' => $data[1],
                // 'bloodGroup' => $data[2],
                'cidNo' => $data[2],
                'cidOther' => $data[3],
                'dob' => $data[4],
                'gender' => $data[5],
                'appointmentDate' => $data[6],
                'gradeId' => $data[7],
                'designationId' => $data[8],
                'office' => $data[9],
                'basicPay' => $data[10], 
                'employmentType' => $data[11],
                'lastDop' => $data[12],
                'mobileNo' => $data[13],
                'emailId' => $data[14],
                'incrementCycle' => $data[15],
                'role_id' => $data[16]


                // 'empStatus' => $data[11],
                // 'placeId' => $data[15],
                // 'bankName' => $data[16],
                // 'accountNumber' => $data[17],
                // 'resignationTypeId' => $data[18],
                // 'resignationDate' => $data[19], 
                                                      


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



// function to field name
public function importfield($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'fieldName' => $data[0]                      
                                        
                                       
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
//end 

// function to qualification name (Tdee)
public function importqualificationmaster($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'qualificationName' => $data[0],    
                    'qualificationLevelId' => $data[1],
                    'qualificationField' => $data[2]                        
                                       
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
//end 

// function to qualification name (Tdee)
public function importemployeequalification($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'personalNo' => $data[0],    
                    'qualificationId' => $data[1],
                    'yearCompleted' => $data[2]                        
                                       
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
//end 

// function to import pant size name (Tdee)
public function importpant($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'pantSizeName' => $data[0],    
                    'gender' => $data[1]
                                          
                                       
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
//end 

// function to import pant size name (Tdee)
public function importshirt($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'shirtSizeName' => $data[0],    
                    'gender' => $data[1]
                                          
                                       
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
//end 

// function to import rain coat size name (Tdee)
public function importraincoatsize($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'sizeName' => $data[0],    
                    'shouldersCm' => $data[1],
                    'chestCm' => $data[2],
                    'waistCm' => $data[3],
                    'bottomCm' => $data[4],
                    'lengthCm' => $data[5],
                    'sleeveCm' => $data[6],
                    'gender' => $data[7]
                   
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
//end 



// function to import jacket size name 

public function importjacket($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                       
                    'sizeName' => $data[0],    
                    'usUkSize' => $data[1],
                    'euSize' => $data[2],
                    'gender' => $data[3]                         
                                       
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

// function to import Shoe size name 

public function importshoesize($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                      
                            'usShoeSize' => $data[0],    
                            'ukShoeSize' => $data[1],
                            'euShoeSize' => $data[2],
                            'footLengthInches' => $data[3],
                            'footLengthCm' => $data[4],
                            'gender' => $data[5]                         
                                       
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
//end 


// function to import Shoe size name 

public function importskillcategory($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                      
                            'categoryName' => $data[0]  
                                                              
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
//end 

//function to import sub skill category

public function importskillsubcategory($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                      
                            'subCatName' => $data[0],
                            'catId' => $data[1]    
                                                              
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

//function to import skill master

public function importskillmaster($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                      
                            'skillName' => $data[0],
                            'subCatId' => $data[1]    
                                                              
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
//end 

//function to import skill master

public function importofficeAdmin($filename,Model $model) {
    if(($handle = fopen(public_path() . '/master/'.$filename.'.csv','r')) !== FALSE)
    {
        $this->line("Importing ".$filename." tables...");
        $i=0;
        while( ($data = fgetcsv($handle,1000,',')) !== FALSE)
        {               

                $data = [                      
                            'officeId' => $data[0],
                            'officeAdmin' => $data[1]
                                 
                                                              
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
//end 
}