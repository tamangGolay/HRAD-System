<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Roles;
use App\OrgUnit;
use App\Dzongkhags;
use Carbon\Carbon;
use App\Vehicles;
use App\User;
use App\vehiclerequest;
use App\guesthouseroom;
use App\guesthouse;
use App\Grade;
use App\roombed;
use App\gewog;
use App\family;
use App\increment;
use App\office;
use App\Officem;
use App\Department;
use App\officeName;
use App\promotion;
use App\employeeR;
use App\pay;
use App\Relationname;
use App\EmployeeMaster;
use App\Company;
use App\ServiceMaster;
use App\QualificationLevel;
use App\Qualification;
use App\GradeMaster;
use App\village;
use App\town;
use App\drungkhag;
use App\ContractDetailMaster;
use App\DivisionMaster;
use App\place;
use App\Designation;
use App\Resignation;
use App\bank;
use App\OfficeAddress;
use App\Field;
use App\Officedetails;
use App\JacketSize;
use App\Shoesize;
use App\EmployeeQualification;
use App\Qualificationview;
use App\SkillCategory;
use App\SubSkillCategory;
use App\Skillmaster;
use App\notesheetRequest;
use App\notesheetapprove;
use App\Pant;
use App\Shirt;
use App\RainCoatSize;
use App\officeuniform;
use App\GumbootSize;
use App\promotionAll;
use App\Promotionduelist;
use App\promotionRequest;
use App\IncrementView;
use App\empSupervisor;
use App\transferRequest;
use App\jobDescription;
use App\transferProposal; 
use App\EmployeeTwice; 
use App\WfReleaseProcess;
use App\WfBank;
use App\WfRelatives;
use App\transferHistory;
use App\Balance;
use App\v4allocation; 
use App\welfarenoteapproval;
use App\WelfareCommitte;
use App\Models\Attendance;


class FormsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getView(Request $request)
    {
        //create user.
        if ($request->v == "conferenceuser")
        {
            $user = Auth::user();

            $wings = Wing::all();
            $departments = Department::all();
            $divisions = Division::all();

            $roles = $user->role;
            $role_admin = false;
            foreach ($roles as $role)
            {
                if ($role->name == "Admin")
                {
                    $role_admin = true;
                }
            }
                      

            $rhtml = view('conference.conferenceuser')->with(['roles' => $roles, 'wings' => $wings, 'departments' => $departments, 'divisions' => $divisions])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }
        //end of create user.
        

       //User List.
       if ($request->v == "userList")
       {
         
               $roles = Roles::all();
               $OrgUnit = OrgUnit::all();
               $grade = Grade::all();
               $dzongkhag = Dzongkhags::all();         

      

           $userLists = DB::table('users')->join('userrolemapping', 'users.id', '=', 'userrolemapping.user_id')
               ->join('roles', 'users.role_id', '=', 'roles.id')
               ->join('orgunit', 'orgunit.id', '=', 'users.org_unit_id')
               ->join('guesthouserate', 'users.grade', '=', 'guesthouserate.id')
               ->join('dzongkhags', 'dzongkhags.id', '=', 'users.dzongkhag')

               ->select('users.id','users.email','dzongkhags.Dzongkhag_Name','users.gender','guesthouserate.grade','roles.id as rid','users.org_unit_id as oid','users.id as uid','users.emp_id', 'users.contact_number', 'users.designation', 'orgunit.description', 'users.name as uname', 'roles.name')
               ->latest('users.id') //similar to orderby('id','desc')
               ->where('users.status',0)
           
               ->paginate(10000000);

           $rhtml = view('auth.userList')->with(['userList' => $userLists,'roles' => $roles, 'OrgUnit' => $OrgUnit, 'grade' => $grade, 'dzongkhag' => $dzongkhag])->render();
           return response()
               ->json(array(
               'success' => true,
               'html' => $rhtml
           ));
       }
       //end of User List.

//start of employeeList
       if ($request->v == "suit")
       {
        
               $roles = Roles::all();
               $OrgUnit = OrgUnit::all();
               $grade = Grade::all();
               $dzongkhag = Dzongkhags::all();
               $gradeId = DB::table('users')
               ->join('payscalemaster', 'payscalemaster.id', '=', 'users.gradeId')
               ->select('payscalemaster.grade');

    //    User::find(Auth::user()->org_unit_id)->descendants()->get();
    //    dd(User);

        // if() {
           $userLists = DB::table('users')->join('userrolemapping', 'users.id', '=', 'userrolemapping.user_id')
               ->join('roles', 'users.role_id', '=', 'roles.id')
               ->join('orgunit', 'orgunit.id', '=', 'users.org_unit_id')
               ->join('guesthouserate', 'users.grade', '=', 'guesthouserate.id')
               ->join('dzongkhags', 'dzongkhags.id', '=', 'users.dzongkhag')

               ->select('orgunit.id','orgunit.parent_id','dzongkhags.Dzongkhag_Name','users.email','users.gender','guesthouserate.grade','roles.id as rid','users.org_unit_id as oid','users.id as uid','users.emp_id', 'users.contact_number', 'users.designation', 'orgunit.description', 'users.name as uname', 'roles.name')
               ->latest('users.id') //similar to orderby('id','desc')
               ->where('users.org_unit_id',Auth::user()->org_unit_id)
               ->orWhere('orgunit.parent_id',Auth::user()->org_unit_id)
            
           

               ->paginate(10000000);
            // }

          

           $rhtml = view('auth.user')->with(['userList' => $userLists,'gradeId' => $gradeId,'roles' => $roles, 'OrgUnit' => $OrgUnit,'grade' => $grade,'dzongkhag' => $dzongkhag])->render();
           return response()
               ->json(array(
               'success' => true,
               'html' => $rhtml
           ));
       }
       //end of employee List.

       //Pant report.
       if ($request->v == "pantReport")
       {
           $pant = Pant::all();
           $officedetails = Officedetails::all();


          $data = DB::table('employeeuniform')
           ->select('*')
           ->get();
    

       $rhtml = view('uniform.pantReport')->with(['data' => $data,
       'pant' => $pant,'officedetails' => $officedetails
       ])->render();
       return response()
           ->json(array(
           'success' => true,
           'html' => $rhtml
       ));
       }
       //end Pant report.

        //    uniform view

        if ($request->v == "uniform")
        {
 
        
         $pant = Pant::all()->where('status',0);
         $shirt = Shirt::all()->where('status',0);
         $jacket = JacketSize::all()->where('status',0);
         $shoe = Shoesize::all()->where('status',0);
         $gumboot = GumbootSize::all()->where('status',0);
         $raincoat = RainCoatSize::all()->where('status',0);
          
 
                $rhtml = view('uniform.uniform')->with(['shirt' => $shirt,'shoe' => $shoe,'gumboot' => $gumboot, 'raincoat' => $raincoat,'jacket' => $jacket,'pant' => $pant])->render();
                return response()
                    ->json(array(
                    'success' => true,
                    'html' => $rhtml
                ));
    
         }
     //    end uniform view

       //uniform report for individual employee
        //uniform report for individual employee
        if ($request->v == "uniformReport")  {
             
             $pant = Pant::all();
             $shirt = Shirt::all();
             $jacket = JacketSize::all();
             $shoe = Shoesize::all();
            //  ->where('status',0);
             $gumboot = GumbootSize::all();
             $raincoat = RainCoatSize::all();
             $office = Officedetails::all();
             $designation = Designation::all()->where('status',0);
             $usersU = User::all();
 
         $data1 = DB::table('employeeuniform')
         ->join('users', 'users.empId', '=', 'employeeuniform.empId')
         ->join('pantmaster', 'pantmaster.id', '=', 'employeeuniform.pant')
         ->join('shirtmaster', 'shirtmaster.id', '=', 'employeeuniform.shirt')
         ->join('jacketmaster', 'jacketmaster.id', '=', 'employeeuniform.jacket')
         ->join('shoesize', 'shoesize.id', '=', 'employeeuniform.shoe')
         ->join('gumboot', 'gumboot.id', '=', 'employeeuniform.gumboot')
         ->join('raincoatsize', 'raincoatsize.id', '=', 'employeeuniform.raincoat')
         ->join('designationmaster', 'designationmaster.id', '=', 'employeeuniform.designationID')
         ->join('officedetails', 'officedetails.id', '=', 'employeeuniform.officeId') 
         ->select('desisNameLong','users.empName','users.empId','employeeuniform.id as uniformId','employeeuniform.*','officedetails.officeDetails1',
         'pantmaster.pantSizeName','shirtmaster.shirtSizeName','jacketmaster.sizeName as jacket',
         'shoesize.ukShoeSize','shoesize.euShoeSize','raincoatsize.sizeName','gumboot.uKSize','gumboot.eUSize')
        ->where('employeeuniform.status',0)
        ->where('employeeuniform.officeId',Auth::user()->office)
        ->latest('uniformId') 
        ->paginate(10000);
             
 
                $rhtml = view('uniform.uniformReport')->with(['data1' => $data1,
                'shirt' => $shirt,'shoe' => $shoe,'gumboot' => $gumboot, 'raincoat' => $raincoat,'jacket' => $jacket,
                'pant' => $pant, 'office' => $office,'usersU'=>$usersU, 'designation'=>$designation])->render();
                return response()
                    ->json(array(
                    'success' => true,
                    'html' => $rhtml
                ));  
             }         


         if ($request->v == "uniformReportpsd")  {
             
            $pant = Pant::all();
            $shirt = Shirt::all();
            $jacket = JacketSize::all();
            $shoe = Shoesize::all();
           //  ->where('status',0);
            $gumboot = GumbootSize::all();
            $raincoat = RainCoatSize::all();
            $office = Officedetails::all();
            $designation = Designation::all()->where('status',0);
            $usersU = User::all();

        $data12 = DB::table('employeeuniform')
        ->join('users', 'users.empId', '=', 'employeeuniform.empId')
        ->join('pantmaster', 'pantmaster.id', '=', 'employeeuniform.pant')
        ->join('shirtmaster', 'shirtmaster.id', '=', 'employeeuniform.shirt')
        ->join('jacketmaster', 'jacketmaster.id', '=', 'employeeuniform.jacket')
        ->join('shoesize', 'shoesize.id', '=', 'employeeuniform.shoe')
        ->join('gumboot', 'gumboot.id', '=', 'employeeuniform.gumboot')
        ->join('raincoatsize', 'raincoatsize.id', '=', 'employeeuniform.raincoat')
        ->join('designationmaster', 'designationmaster.id', '=', 'employeeuniform.designationID')
        ->join('officedetails', 'officedetails.id', '=', 'employeeuniform.officeId') 
        ->select('desisNameLong','users.empName','users.empId','employeeuniform.id as uniformId','employeeuniform.*','officedetails.officeDetails',
        'pantmaster.pantSizeName','shirtmaster.shirtSizeName','jacketmaster.sizeName as jacket',
        'shoesize.ukShoeSize','shoesize.euShoeSize','raincoatsize.sizeName','gumboot.uKSize','gumboot.eUSize')
       ->where('employeeuniform.status',0)       
       ->latest('uniformId') 
       ->paginate(10000);
            

               $rhtml = view('uniform.uniformReportpsd')->with(['data12' => $data12,
               'shirt' => $shirt,'shoe' => $shoe,'gumboot' => $gumboot, 'raincoat' => $raincoat,'jacket' => $jacket,
               'pant' => $pant, 'office' => $office,'usersU'=>$usersU, 'designation'=>$designation])->render();
               return response()
                   ->json(array(
                   'success' => true,
                   'html' => $rhtml
               ));  
            }


       if ($request->v == "officeuniformReport")  
       {

        $data2 = DB::table('officeuniform') 
        ->join('orgunit', 'orgunit.id', '=', 'officeuniform.org_unit_id')
        ->join('dzongkhags', 'dzongkhags.id', '=', 'officeuniform.dzongkhag')
                         
           ->select('officeuniform.id','officeuniform.org_unit_id','dzongkhags.Dzongkhag_Name', 'orgunit.description','officeuniform.uniform_id','officeuniform.S','officeuniform.M','officeuniform.L', 'officeuniform.XL','officeuniform.Size_2XL','officeuniform.Size_3XL','officeuniform.Size_4XL','officeuniform.Size_5XL','officeuniform.Size_6XL')
           ->where('officeuniform.id',1) 
           ->orwhere('officeuniform.id',2) 
           ->orwhere('officeuniform.id',3) 
           ->orwhere('officeuniform.id',6) 
           ->paginate(10000);

               $rhtml = view('uniform.officeUniformReport')->with(['data2' => $data2])->render();
               return response()
                   ->json(array(
                   'success' => true,
                   'html' => $rhtml
               ));   
        }
        //end of uniform report for office wise

        //View for Total shoe sizes
        if ($request->v == "TotalShoeSizes")  
        {
 
           $data2 = DB::table('officeuniform') 
           ->join('orgunit', 'orgunit.id', '=', 'officeuniform.org_unit_id')
           ->join('dzongkhags', 'dzongkhags.id', '=', 'officeuniform.dzongkhag')
           
                    
              ->select('officeuniform.id','officeuniform.org_unit_id','dzongkhags.Dzongkhag_Name', 'orgunit.description','officeuniform.uniform_id','officeuniform.shoe_3','officeuniform.shoe_4','officeuniform.shoe_5', 'officeuniform.shoe_6','officeuniform.shoe_7','officeuniform.shoe_8','officeuniform.shoe_9','officeuniform.shoe_10','officeuniform.shoe_11','officeuniform.shoe_12','officeuniform.shoe_13','officeuniform.shoe_14','officeuniform.shoe_15','dzongkhag')
              ->where('officeuniform.id',4) 
              ->orwhere('officeuniform.id',5) 
              ->paginate(10000);
   
                  $rhtml = view('uniform.totalShoes')->with(['data2' => $data2])->render();
                  return response()
                      ->json(array(
                      'success' => true,
                      'html' => $rhtml
                  ));   
           }
 
 //end for total shoe sizes;

//uniform shoes report
if ($request->v == "shoesReport")  //form.csv
{   $shoerepo = Officedetails::all();   
    $shoesizerepo = Shoesize::all();

    $name = DB::table('employeeuniform')
    ->join('officedetails', 'officedetails.id', '=', 'employeeuniform.officeId')
    ->join('shoesize', 'shoesize.id', '=', 'employeeuniform.shoe')
   
    ->select('officedetails.longOfficeName','shoesize.ukShoeSize')
    ->where('employeeuniform.status','=', 0);

    $rhtml = view('uniform.shoeReport')->with(['shoerepo'=>$shoerepo,'shoesizerepo'=>$shoesizerepo])->render();
    return response()
    ->json(array(
     'success' => true,
     'html' => $rhtml
      ));
}  
//end

//uniform shoe size
if ($request->v == "shoesize")
{
    $rhtml = view('uniform.shoeSize')->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));
}



// Knowledge Request
if ($request->v == "knowledgeRequest")  //form.csv
{    

 $rhtml = view('knowledge.knowledgeRequest')->render(); 
 return response()
    ->json(array(
     'success' => true,
     'html' => $rhtml
      ));
}  //Knowledge Request end


//KnowledgeReview for Supervisor
if ($request->v == "knowledgeReview")
{
    $userLists = DB::table('knowledgerepository')
        ->join('users', 'users.empId', '=', 'knowledgerepository.createdBy')
        ->join('officedetails', 'officedetails.id', '=', 'knowledgerepository.officeId')

        ->join('officemaster','officemaster.id','=','knowledgerepository.officeId')

        ->select('users.empName','knowledgerepository.*','officedetails.shortOfficeName','officedetails.Address')

        ->latest('knowledgerepository.id') //similar to orderby('id','desc')
        // ->where('knowledgerepository.officeId',Auth::user()->office)

        ->where('officemaster.reportToOffice','=',Auth::user()->office) 
        ->where('knowledgerepository.approvedBy',)
  
        ->paginate(10000000);
     $rhtml = view('knowledge.knowledgeReview')->with(['userList' => $userLists])->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));
}
//end of KnowledgeReview for Supervisor.




        //Contribution report List.
        if ($request->v == "contributionReport")
        {
           
           $data = DB::table('wfcontribution')
   
      ->select('*')
      ->get();
     

        $rhtml = view('welfare.contributionReport')->with(['data' => $data])->render();
        return response()
            ->json(array(
            'success' => true,
            'html' => $rhtml
        ));
        }
        //end Contribution report.

        //knowledgeRepository for employees
if ($request->v == "knowledgeRepository")
{
    $userLists = Officedetails::all();


    $userLists = DB::table('knowledgerepository')
        // ->join('users', 'users.empId', '=', 'knowledgerepository.createdBy')
        ->join('officedetails', 'officedetails.id', '=', 'knowledgerepository.officeId')
     //    ->join('officemaster','officemaster.id','=','users.office')

     ->select('knowledgerepository.empName','knowledgerepository.*','officedetails.officeDetails')

        
         ->paginate(10000000);
     $rhtml = view('knowledge.knowledgeRepository')->with(['userList' => $userLists])->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));
}
//end of KnowledgeRepository.


//Conference Report
if ($request->v == "cReports")

         {            
            $review = DB::table('conferencerequest')
     
       ->select('*')
       ->get();
      

         $rhtml = view('conference.conferenceReport')->with(['review' => $review])->render();
         return response()
             ->json(array(
             'success' => true,
             'html' => $rhtml
         ));
         }

//end of CReports

//Guest House reports

//Conference Report
if ($request->v == "guestHouseReports")
 {
            
 $review= DB::table('roombed')
        

       ->select('*')
       ->latest('roombed.id')

       ->get();
      

         $rhtml = view('guesthouse.guestHouseReports')->with(['review' => $review])->render();
         return response()
             ->json(array(
             'success' => true,
             'html' => $rhtml
         ));
        
         }

// end of guest House Reports

//user list

if ($request->v == "userListHR")
{
 $roles = Roles::all();
 $officedetails = Officedetails::all();
 $dzongkhag = Dzongkhags::all();
 $designation = Designation::all()->where('status',0);


$userLists = DB::table('users')

 ->join('roles', 'users.role_id', '=', 'roles.id')

 ->join('officedetails', 'officedetails.id', '=', 'users.office')
 
 ->join('designationmaster', 'designationmaster.id', '=', 'users.designationId') 

->select('users.*','roles.name','desisNameLong','officedetails.shortOfficeName','officedetails.Address')

 ->latest('users.id') //similar to orderby('id','desc')
 ->where('users.status',0)

 ->paginate(10000000);

$rhtml = view('auth.userListHR')->with(['designation' => $designation,'officedetails' => $officedetails,'userList' => $userLists,'roles' => $roles,'dzongkhag' => $dzongkhag])->render();
return response()
 ->json(array(
 'success' => true,
 'html' => $rhtml
    ));
}
//end of User List.


if ($request->v == "userlistNEW")
{
 $roles = Roles::all();
 $officedetails = Officedetails::all();
 $dzongkhag = Dzongkhags::all();
 $designation = Designation::all()->where('status',0);
 $payscalemaster = pay::all()->where('status',0);

 $userLists = DB::table('users')

 ->join('roles', 'users.role_id', '=', 'roles.id')
 ->join('payscalemaster', 'payscalemaster.id', '=', 'users.gradeId')
 ->join('officedetails', 'officedetails.id', '=', 'users.office') 
 ->join('designationmaster', 'designationmaster.id', '=', 'users.designationId')
 ->select('users.*','roles.name','desisNameLong','officedetails.shortOfficeName','officedetails.Address','officedetails.officeDetails','grade')
 ->latest('users.id') //similar to orderby('id','desc')
 ->where('users.status',0)

 ->paginate(10000000);

$rhtml = view('auth.userListHR1')->with(['designation' => $designation,'officedetails' => $officedetails,'userList' => $userLists,'roles' => $roles,'dzongkhag' => $dzongkhag,'payscalemaster'=>$payscalemaster])->render();

return response()
 ->json(array(
 'success' => true,
 'html' => $rhtml
    ));
}

//new list hr 

       
       if ($request->v == "suit")
       {
        //  dd($request);
               $roles = Roles::all();
               $OrgUnit = OrgUnit::all();
               $grade = Grade::all();
               $dzongkhag = Dzongkhags::all();

       

        // if() {
           $userLists = DB::table('users')->join('userrolemapping', 'users.id', '=', 'userrolemapping.user_id')
               ->join('roles', 'users.role_id', '=', 'roles.id')
               ->join('orgunit', 'orgunit.id', '=', 'users.org_unit_id')
               ->join('guesthouserate', 'users.grade', '=', 'guesthouserate.id')
               ->join('dzongkhags', 'dzongkhags.id', '=', 'users.dzongkhag')

               ->select('orgunit.parent_id','dzongkhags.Dzongkhag_Name','users.email','users.gender','guesthouserate.grade','roles.id as rid','users.org_unit_id as oid','users.id as uid','users.emp_id', 'users.contact_number', 'users.designation', 'orgunit.description', 'users.name as uname', 'roles.name')
               ->latest('users.id') //similar to orderby('id','desc')
               ->where('users.org_unit_id',Auth::user()->org_unit_id)
               ->orWhere('orgunit.parent_id',Auth::user()->org_unit_id)


               ->paginate(10000000);
            // }

           
           $rhtml = view('auth.user')->with(['userList' => $userLists,'roles' => $roles, 'OrgUnit' => $OrgUnit,'grade' => $grade,'dzongkhag' => $dzongkhag])->render();
           return response()
               ->json(array(
               'success' => true,
               'html' => $rhtml
           ));
       }
       //end of User List.


       if ($request->v == "employeeList")
       {
               $roles = Roles::all();
               $officedetails = Officedetails::all();

               $dzongkhag = Dzongkhags::all();
               $designation = Designation::all();
              
               $gg = pay::all();

            $userLists = DB::table('users')
               ->join('roles', 'users.role_id', '=', 'roles.id')
               ->join('officedetails', 'officedetails.id', '=', 'users.office')
               ->join('officemaster','officemaster.id','=','users.office')

            ->select('users.*','roles.name','officedetails.shortOfficeName','officedetails.officeDetails','officedetails.Address'
               )
            ->where('users.status',0)

               ->latest('users.id') //similar to orderby('id','desc')
            //    ->where('users.office',Auth::user()->office)
            //    ->orwhere('officemaster.reportToOffice',Auth::user()->office)
            ->whereIn('users.office', function($query){
                $query->from('officeunder')
                ->select('officeunder.office')
                    ->whereIn('officeunder.head', function($query1){
                    $query1->from('officemaster')
                    ->join('users','officemaster.id' ,'=','users.office')
                    ->select('officemaster.officehead')
                    ->where('users.empId','=', Auth::user()->empId);
                    });
                })
                ->paginate(10000000);
            $rhtml = view('auth.user')->with(['gg' => $gg,'designation' => $designation,'officedetails' => $officedetails,'userList' => $userLists,'roles' => $roles,'dzongkhag' => $dzongkhag])->render();
                 return response()
               ->json(array(
               'success' => true,
               'html' => $rhtml
           ));
       }
       //end of User List.



       //Start oneEmployee
       if ($request->v == "oneEmployee")
       {
        $officedetails = officedetails::all();


           $rhtml = view('welfare.oneEmployee')->with(['officedetails' => $officedetails])
           
           ->render();
           return response()
               ->json(array(
               'success' => true,
               'html' => $rhtml
           ));
       }
       //end of oneEmployee .


       
       //Start oneEmployee
       if ($request->v == "allEmployeeContribution")
       {
        

           $rhtml = view('welfare.allEmployeeContribution')->render();
           return response()
               ->json(array(
               'success' => true,
               'html' => $rhtml
           ));
       }
       //end of oneEmployee .
       
      
           
        

        //admin role and form mapping
        if ($request->v == "role_form")
        {
            $roles = Roles::all();
            //exception to Role Form Mapping.
            $formlist = DB::table('forms')->where('description', '!=', 'Role Form Mapping')
                ->select('id', 'description', DB::raw("(select form_id from roleformmapping where roleformmapping.form_id = forms.id and roleformmapping.role_id='1') as formid"))
                ->get();

            $rhtml = view('role_forms')->with(['formlist' => $formlist, 'roles' => $roles])->render();
            return response()
                ->json(array(
                'success' => true,  
                'html' => $rhtml
            ));
        }

        

        //form
        if ($request->v == "registerVehicle")
        {
            $dzongkhags = Dzongkhags::all();
            $agencies = Agencies::all();

            $rhtml = view('Transportation.registerVehicle')->with(['dzongkhags' => $dzongkhags, 'agencies' => $agencies])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));

        }

        //Tracking Vehicle(To free the vehicle after tour)
        if ($request->v == "Free_vehicle")
        {
            $dzongkhags = Dzongkhags::all();

            $Free_vehicle = DB::table('vehicledetails')->join('dzongkhags', 'vehicledetails.dzo_id', '=', 'dzongkhags.id')
                ->select('vehicledetails.id', 'vehicledetails.vehicle_name', 'vehicledetails.vehicle_type', 'vehicledetails.vehicle_number', 'vehicledetails.model', 'dzongkhags.Dzongkhag_Name', 'vehicledetails.status')
                ->paginate(15);

            $rhtml = view('Tracking_Vehicle.Free_vehicle')->with(['dzongkhags' => $dzongkhags, 'Free_vehicle' => $Free_vehicle])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }
        //Free_vehicle end
        //Request_vehicle
        if ($request->v == "Request_vehicle")
        {

            $id = vehiclerequest::all();// added new

            $dzongkhags = Dzongkhags::all();
	    $vehicles = Vehicles::all()
	    ->where('status',0)	    ;
            $user = Auth::id();

            

$vehicle_name = DB::table('vehiclerequest')->join('vehicledetails', 'vehicledetails.id', '=', 'vehiclerequest.vehicleId')
    ->select('vehicle_name', 'vehicle_number')
    ->get();


$bookedv = DB::table('vehiclerequest')
->join('vehicledetails', 'vehiclerequest.vehicleId', '=', 'vehicledetails.id')
 
    ->where('vehiclerequest.status', 4)
    ->select( 'vehiclerequest.id','vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehicledetails.vehicle_name','vehicledetails.vehicle_number')
    
    ->latest('vehiclerequest.id') //similar to orderby('vehiclerequest.id','desc')

    ->paginate(10000000);



        
    $rhtml = view('Tracking_Vehicle.Request_vehicle')->with(['dzongkhags' => $dzongkhags, 'vehicles' => $vehicles, 'user' => $user, 'bookedv'=> $bookedv])->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));

}
//Request_vehicle end

        //guest house start
        if ($request->v == "GuestHouseBooking")
        {
            $guesthouseroom = guesthouseroom::all();
            $roombed = guesthouseroom::all();       

          
            
            $dzongkhags = Dzongkhags::all();
            $dzongkhag = Dzongkhags::all();
            $dzongkhag2 = Dzongkhags::all();

            $dzongkhag3 = Dzongkhags::all();

            $dzongkhag4 = Dzongkhags::all();
            $dzongkhag90 = Dzongkhags::all();


        
            $user = Auth::id();

         
            

            $rhtml = view('guesthouse.GuestHouseBooking')->with(['roombed'  => $roombed,'guesthouseroom' => $guesthouseroom,'dzongkhags' => $dzongkhags,
            
            'dzongkhag' => $dzongkhag,  'dzongkhag90' => $dzongkhag90,'dzongkhag2' => $dzongkhag2,'dzongkhag3' => $dzongkhag3,'dzongkhag4' => $dzongkhag4,'user' => $user])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));

        }

        //guesthouse end



        //guest house outsider start
        if ($request->v == "GuestHouseBookingOutsider")
        {
            $guesthouseroom = guesthouseroom::all();
            $roombed = guesthouseroom::all();

         

          
            
            $dzongkhags = Dzongkhags::all();
            $dzongkhag = Dzongkhags::all();
            $dzongkhag2 = Dzongkhags::all();

            $dzongkhag3 = Dzongkhags::all();

            $dzongkhag4 = Dzongkhags::all();
            $dzongkhag90 = Dzongkhags::all();


        
            $user = Auth::id();

         
            

            $rhtml = view('guesthouse.GuestHouseBookingOutsider')->with(['roombed'  => $roombed,'guesthouseroom' => $guesthouseroom,'dzongkhags' => $dzongkhags,
            
            'dzongkhag' => $dzongkhag,  'dzongkhag90' => $dzongkhag90,'dzongkhag2' => $dzongkhag2,'dzongkhag3' => $dzongkhag3,'dzongkhag4' => $dzongkhag4,'user' => $user])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));

        }

        //guesthouse end



         //guest house Self
         if ($request->v == "GuestHouseBookingSelf")
         {
             $guesthouseroom = guesthouseroom::all();
             $roombed = guesthouseroom::all();
 
          
 
           
             
             $dzongkhags = Dzongkhags::all();
             $dzongkhag = Dzongkhags::all();
             $dzongkhag2 = Dzongkhags::all();
 
             $dzongkhag3 = Dzongkhags::all();
 
             $dzongkhag4 = Dzongkhags::all();
             $dzongkhag90 = Dzongkhags::all();
 
 
         
             $user = Auth::id();
 
          
             
 
             $rhtml = view('guesthouse.GuestHouseBookingSelf')->with(['roombed'  => $roombed,'guesthouseroom' => $guesthouseroom,'dzongkhags' => $dzongkhags,
             
             'dzongkhag' => $dzongkhag,  'dzongkhag90' => $dzongkhag90,'dzongkhag2' => $dzongkhag2,'dzongkhag3' => $dzongkhag3,'dzongkhag4' => $dzongkhag4,'user' => $user])->render();
             return response()
                 ->json(array(
                 'success' => true,
                 'html' => $rhtml
             ));
 
         }
 
         //guesthouse end

//add Room and bed to old guestHouse
 if ($request->v == "addRoom")
 {


 
    $guesthouseroom = guesthouseroom::all();

 

  
    
    $dzongkhags = Dzongkhags::all();
    $dzongkhag = Dzongkhags::all();
    $dzongkhag2 = Dzongkhags::all();

    $dzongkhag3 = Dzongkhags::all();

    $dzongkhag4 = Dzongkhags::all();



    $user = Auth::id();

    $roombed = DB::table('guesthouseroom')->join('guesthousename', 'guesthousename.id', '=', 'guesthouseroom.guest_house_id')
    ->join('dzongkhags', 'dzongkhags.id', '=', 'guesthouseroom.dzo_id')  




    ->select('guesthouseroom.room_no','guesthouseroom.id as gid','dzongkhags.Dzongkhag_Name','guesthousename.name')
   
   ->latest('guesthouseroom.id') //similar to orderby('roombed.id','desc')            
    ->paginate(10000000);

 
    

    $rhtml = view('guesthouse.addRoom')->with(['roombed'  => $roombed,'guesthouseroom' => $guesthouseroom,'dzongkhags' => $dzongkhags,
    
    'dzongkhag' => $dzongkhag,'dzongkhag2' => $dzongkhag2,'dzongkhag3' => $dzongkhag3,'dzongkhag4' => $dzongkhag4,'user' => $user])->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));
 }
//add room end

        //guest house wangtsa review=1           
        if ($request->v == "ghWangtsa_review")
        {

            try{

            $wangtsaReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                                 ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                                 ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                                 ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                                
                                                 ->where('roombed.guest_house_id', 1)               
            
                                                 ->where('roombed.statusrb', 0)
                                                 ->where('roombed.id','>', 25)

                                 
                                                 ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                         
                                                ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                               ->paginate(10000000);
                                 
                                             $rhtml = view('guesthouse.wangtsaReview')->with(['wangtsaReview' => $wangtsaReview])->render();
                                             return response()
                                                 ->json(array(
                                                 'success' => true,
                                                 'html' => $rhtml
                                             ));
                                            }

                                            catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                                $wangtsaReview = DB::table('roombed')
                                                ->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                                ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                                ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                                ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                               
                                                ->where('roombed.guest_house_id', 1)               
           
                                                ->where('roombed.statusrb', 0)
                                                ->where('roombed.id','>', 25)

                                
                                                ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                               ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                                ->paginate(10000000);
                                
                                            $rhtml = view('guesthouse.wangtsaReviewE')->with(['wangtsaReview' => $wangtsaReview])->render();
                                            return response()
                                                ->json(array(
                                                'success' => true,
                                                'html' => $rhtml
                                            ));
                                             }
                                         }                                     
                                   
//guest house wangtsa review end


//guest house TMO review=2        
        if ($request->v == "ghTMO_review")
        {
        try{
            $tmoReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                                 ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                                 ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                                 ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                                 
                                                 ->where('roombed.guest_house_id', 2)               
            
                                                 ->where('roombed.statusrb', 0)
                                                 ->where('roombed.id','>', 25)

                                 
                                                 ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                                ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                                 ->paginate(10000000);
                                 
                                             $rhtml = view('guesthouse.tmoReview')->with(['tmoReview' => $tmoReview])->render();
                                             return response()
                                                 ->json(array(
                                                 'success' => true,
                                                 'html' => $rhtml
                                             ));
                                            }

                                            catch(\Facade\Ignition\Exceptions\ViewException $e) {

                                                $tmoReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                                ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                                ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                                ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                                
                                                ->where('roombed.guest_house_id', 2)               
           
                                                ->where('roombed.statusrb', 0)
                                                ->where('roombed.id','>', 25)

                                
                                                ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                               ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                                ->paginate(10000000);
                                
                                            $rhtml = view('guesthouse.tmoReviewE')->with(['tmoReview' => $tmoReview])->render();
                                            return response()
                                                ->json(array(
                                                'success' => true,
                                                'html' => $rhtml
                                            ));
                                             }
                                         }                                     
                                   
//guest house TMO review end

//guest house Dhamdum review=3       
if ($request->v == "ghDhamdum_review")
{
try{
    $dhamdumReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 3)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.dhamdhumReview')->with(['dhamdumReview' => $dhamdumReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $dhamdumReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 3)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.dhamdhumReviewE')->with(['dhamdumReview' => $dhamdumReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                                     
                           
//guest house Dhamdum review end

//guest house Jigmeling review=4     
if ($request->v == "ghJigmeling_review")
{
try{
    $jigmelingReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 4)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                         
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.jigmelingReview')->with(['jigmelingReview' => $jigmelingReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $jigmelingReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 4)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.jigmelingReviewE')->with(['jigmelingReview' => $jigmelingReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                                     
                           
//guest house Jigmeling substation review end


//guest house Dhajay review=5       
if ($request->v == "ghDhajay_review")
{
try{
    $dhajayReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 5)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                         
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.dhajayReview')->with(['dhajayReview' => $dhajayReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                         
    $dhajayReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
    ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
    ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
    ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
    
    ->where('roombed.guest_house_id', 5)               

    ->where('roombed.statusrb', 0)
    ->where('roombed.id','>', 25)


    ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
    
   ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
    ->paginate(10000000);

$rhtml = view('guesthouse.dhajayReviewE')->with(['dhajayReview' => $dhajayReview])->render();
return response()
    ->json(array(
    'success' => true,
    'html' => $rhtml
));
                                     }
                                 }                                     
                           
//guest house Dhajay review end

//guest house Dhajay review=6   
if ($request->v == "ghYurmoo_review")
{
try{
    $yurmooReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 6)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.yurmooReview')->with(['yurmooReview' => $yurmooReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $yurmooReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 6)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.yurmooReviewE')->with(['yurmooReview' => $yurmooReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                                     
                           
//guest house yurmoo review end


//guest house Dangapela review=7      
if ($request->v == "ghDagapela_review")
{
try{
    $dagapelaReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 7)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.dagapelaReview')->with(['dagapelaReview' => $dagapelaReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }


                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $dagapelaReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 7)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.dagapelaReviewE')->with(['dagapelaReview' => $dagapelaReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                                     
                           
//guest house Dagapela review end


//guest house TMD Transit camp review=8   
if ($request->v == "ghTMD_review")
{
try{
    $tmdReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 8)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.tmdReview')->with(['tmdReview' => $tmdReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $tmdReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 8)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.tmdReviewE')->with(['tmdReview' => $tmdReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                                     
                           
//guest house TMD Transit camp review end

//Guest House olathang Review= 9  

        if ($request->v == "ghOlathang_review")
        {
            try{
            $olathangReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                                 ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                                 ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                                 ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                                 
                                                 ->where('roombed.guest_house_id', 9)               
            
                                                 ->where('roombed.statusrb', 0)
                                                 ->where('roombed.id','>', 25)

                                 
                                                 ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                                ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                                 ->paginate(10000000);
                                 
                                             $rhtml = view('guesthouse.olathangReview')->with(['olathangReview' => $olathangReview])->render();
                                             return response()
                                                 ->json(array(
                                                 'success' => true,
                                                 'html' => $rhtml
                                             ));
                                            }

                                            catch(\Facade\Ignition\Exceptions\ViewException $e) {

                                             $olathangReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                             ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                             ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                             ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                             
                                             ->where('roombed.guest_house_id', 9)               
        
                                             ->where('roombed.statusrb', 0)
                                             ->where('roombed.id','>', 25)

                             
                                             ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                    
                                            ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                             ->paginate(10000000);
                             
                                         $rhtml = view('guesthouse.olathangReviewE')->with(['olathangReview' => $olathangReview])->render();
                                         return response()
                                             ->json(array(
                                             'success' => true,
                                             'html' => $rhtml
                                         ));
                                        }
                                         }                                     
 //end of olathang guest house review     
 
 
//Guest House pangbesa Review= 10

if ($request->v == "ghPangbesa_review")
{
    try{
        $pangbesaReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 10)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.pangbesaReview')->with(['pangbesaReview' => $pangbesaReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }
                                    catch(\Facade\Ignition\Exceptions\ViewException $e){
                                        $pangbesaReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                            ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                            ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                            ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                            
                                            ->where('roombed.guest_house_id', 10)               
    
                                            ->where('roombed.statusrb', 0)
                                            ->where('roombed.id','>', 25)

                            
                                            ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                            ->paginate(10000000);
                            
                                        $rhtml = view('guesthouse.pangbesaReviewE')->with(['pangbesaReview' => $pangbesaReview])->render();
                                        return response()
                                            ->json(array(
                                            'success' => true,
                                            'html' => $rhtml
                                        ));
                                     }
                                 }                                     
//end of pangbesa guest house review  
 
//DEOTHANG gUEST house=11
if ($request->v == "ghDeothang_review")
{
    try{
        $deothangReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 11)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.deothangReview')->with(['deothangReview' => $deothangReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }
                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                    $deothangReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 11)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.deothangReviewE')->with(['deothangReview' => $deothangReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                                     
//DEOTHANG gUEST house end
 
  
//TM Pinsa gUEST house=12
if ($request->v == "ghPinsa_review")
{
    try{
        $pinsaReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 12)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.pinsaReview')->with(['pinsaReview' => $pinsaReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }
                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $pinsaReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 12)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.pinsaReviewE')->with(['pinsaReview' => $pinsaReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                    }
                                 }                                     
//pinsa gUEST house end

 
//ESSD Tashichholing gUEST house=13
if ($request->v == "ghTashichoeling_review")
{
    try{
        $tashichoelingReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 13)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.tashichoelingReview')->with(['tashichoelingReview' => $tashichoelingReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $tashichoelingReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 13)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.tashichoelingReviewE')->with(['tashichoelingReview' => $tashichoelingReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                                     
//Tashicholling gUEST house end

 
//Dorokha gUEST house=14
if ($request->v == "ghDorokha_review")
{
 try{
    $dorokhaReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 14)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.dorokhaReview')->with(['dorokhaReview' => $dorokhaReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $dorokhaReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 14)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.dorokhaReviewE')->with(['dorokhaReview' => $dorokhaReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                                     
//dorokha gUEST house end

//Kewathang gUEST house=15
if ($request->v == "ghKewathang_review")
{
try{
    $kewathangReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 15)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.kewathangReview')->with(['kewathangReview' => $kewathangReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $kewathangReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 15)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.kewathangReviewE')->with(['kewathangReview' => $kewathangReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                                     
//Kewathang gUEST house end


        //Guest House Garpang Review=16

        if ($request->v == "ghGarpang_review")
        {
            try{
            $garpangReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                                 ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                                 ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                                 ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                                 
                                                 ->where('roombed.guest_house_id', 16)               
            
                                                 ->where('roombed.statusrb', 0)
                                                 ->where('roombed.id','>', 25)

                                 
                                                 ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                                ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                                 ->paginate(10000000);
                                 
                                             $rhtml = view('guesthouse.garpangReview')->with(['garpangReview' => $garpangReview])->render();
                                             return response()
                                                 ->json(array(
                                                 'success' => true,
                                                 'html' => $rhtml
                                             ));
                                            }

                                            catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                                $garpangReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                                ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                                ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                                ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                                
                                                ->where('roombed.guest_house_id', 16)               
           
                                                ->where('roombed.statusrb', 0)
                                                ->where('roombed.id','>', 25)

                                
                                                ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                               ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                                ->paginate(10000000);
                                
                                            $rhtml = view('guesthouse.garpangReviewE')->with(['garpangReview' => $garpangReview])->render();
                                            return response()
                                                ->json(array(
                                                'success' => true,
                                                'html' => $rhtml
                                            ));
                                             }
                                         }                               
                                    
         
//end of garpang guest house review
                                        
 

//chumey GH=17
if ($request->v == "ghChumey_review")
{
    try{

    $chumeyReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 

                                         ->where('roombed.guest_house_id', 17)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.chumeyReview')->with(['chumeyReview' => $chumeyReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }
              catch(\Facade\Ignition\Exceptions\ViewException $e){
                $chumeyReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 

                ->where('roombed.guest_house_id', 17)               

                ->where('roombed.statusrb', 0)
                ->where('roombed.id','>', 25)


                ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
               
               ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                ->paginate(10000000);

            $rhtml = view('guesthouse.chumeyReviewE')->with(['chumeyReview' => $chumeyReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
    }                       
                                 }                               
                            
 //end of chumey guest house review

 //ESD Wangdue GH=18
if ($request->v == "ghESDwangdue_review")
{
try{
    $wangdueReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 18)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.wangdueReview')->with(['wangdueReview' => $wangdueReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $wangdueReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 18)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.wangdueReviewE')->with(['wangdueReview' => $wangdueReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                               
                            
 //end of wangdue guest house review

 //chumey GH=
if ($request->v == "ghTangmachu_review")
{
    try{

    $tangmachuReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 19)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.tangmachuReview')->with(['tangmachuReview' => $tangmachuReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $tangmachuReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 19)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.tangmachuReviewE')->with(['tangmachuReview' => $tangmachuReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                               
                            
 //end of tangmachu guest house review
                                      
 //phuentsholing GH=20
if ($request->v == "ghPhuentsholing_review")
{
try{
    $phuentsholingReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 20)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.phuentsholingReview')->with(['phuentsholingReview' => $phuentsholingReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }

                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $phuentsholingReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag')  
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id') 
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 20)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.phuentsholingReviewE')->with(['phuentsholingReview' => $phuentsholingReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                               
                            
 //end of phuentsholing guest house review
 
 //Transit Camp GH=21
if ($request->v == "ghTransitCamp_review")
{
    try{

    $transitCampReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag') 
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 21)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.transitCampReview')->with(['transitCampReview' => $transitCampReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }
                                

                         
                     
                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $transitCampReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag') 
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 21)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.transitCampReviewE')->with(['transitCampReview' => $transitCampReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                               
                            
 //end of transitCamp guest house review   
 
 // Kilikhar GuestHouse  id=22
if ($request->v == "ghkilikhar_review")
{
    try{

    $kilikharReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag') 
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 22)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.kilikharReview')->with(['kilikharReview' => $kilikharReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }
                                

                         
                     
                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $transitCampReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag') 
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 22)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.kilikharReviewE')->with(['kilikharReview' => $kilikharReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                               
                            
 //kilikhar guest house review   

 // Kanglung GuestHouse  id=23
if ($request->v == "ghkanglung_review")
{
    try{

    $kanglungReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag') 
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 23)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.kanglungReview')->with(['kanglungReview' => $kanglungReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }
                                

                         
                     
                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $transitCampReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag') 
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 23)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.kanglungReviewE')->with(['kanglungReview' => $kanglungReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                               
                            
 // end of kanglung guest house review   

// nangkhor GuestHouse  id=24
if ($request->v == "ghnangkhor_review")
{
    try{

    $nangkhorReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag') 
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 24)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.nangkhorReview')->with(['nangkhorReview' => $nangkhorReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }
                                

                         
                     
                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $transitCampReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag') 
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 24)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.nangkhorReviewE')->with(['nangkhorReview' => $nangkhorReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                               
                            
 // end of nangkhor guest house review   


 // nganglam guesthouse review  gh id =25

if ($request->v == "ghnganglam_review")
{
    try{

    $nganglamReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                         ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag') 
                                         ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                         ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                         
                                         ->where('roombed.guest_house_id', 25)               
    
                                         ->where('roombed.statusrb', 0)
                                         ->where('roombed.id','>', 25)

                         
                                         ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                        
                                        ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                         ->paginate(10000000);
                         
                                     $rhtml = view('guesthouse.nganglamReview')->with(['nganglamReview' => $nganglamReview])->render();
                                     return response()
                                         ->json(array(
                                         'success' => true,
                                         'html' => $rhtml
                                     ));
                                    }
                                

                         
                     
                                    catch(\Facade\Ignition\Exceptions\ViewException $e) {
                                        $nganglamReview = DB::table('roombed')->join('guesthousename', 'guesthousename.id', '=', 'roombed.guest_house_id')
                                        ->join('dzongkhags', 'dzongkhags.id', '=', 'roombed.dzongkhag') 
                                        ->join('orgunit', 'orgunit.id', '=', 'roombed.org_unit_id')  
                                        ->join('guesthouseroom', 'guesthouseroom.id', '=', 'roombed.roomdetails_id') 
                                        
                                        ->where('roombed.guest_house_id', 25)               
   
                                        ->where('roombed.statusrb', 0)
                                        ->where('roombed.id','>', 25)

                        
                                        ->select('guesthouseroom.room_no','guesthouseroom.id as gid','roombed.id','dzongkhags.Dzongkhag_Name','guesthousename.name','orgunit.description','roombed.gender','roombed.name','roombed.emp_id','roombed.check_in','roombed.check_out','roombed.rate')
                                       
                                       ->latest('roombed.id') //similar to orderby('roombed.id','desc')            
                                        ->paginate(10000000);
                        
                                    $rhtml = view('guesthouse.nganglamReviewE')->with(['nganglamReview' => $nganglamReview])->render();
                                    return response()
                                        ->json(array(
                                        'success' => true,
                                        'html' => $rhtml
                                    ));
                                     }
                                 }                               
                            
 //end of nganglam guesthouse  review   

     
 //final GM AFTER MTO
 if ($request->v == "MTOGM_Review")
        
 {  
     $id = vehiclerequest::all();

     $mtoGM = DB::table('vehiclerequest')->join('vehicledetails', 'vehiclerequest.vehicleId', '=', 'vehicledetails.id')

        ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
         ->join('users', 'users.id', '=', 'vehiclerequest.supervisor') //pull gm's name
     
     
         
         ->where('vehiclerequest.status', 4)
         ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.dateOfRequisition', 'vehicledetails.vehicle_name', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit', 'users.name', 'users.designation')
         
         ->latest('vehiclerequest.id') //similar to orderby('vehiclerequest.id','desc')
     
         ->paginate(10000000);

     $rhtml = view('vehicle.generalManagerReview')->with(['mtoGM' => $mtoGM])->render();
     return response()
         ->json(array(
         'success' => true,
         'html' => $rhtml
     ));
 }  
 //END mto GM
                  
 
 //return GM AFTER MTO
 if ($request->v == "Return_Review")
        
 {  
     $id = vehiclerequest::all();

     $returnGM = DB::table('vehiclerequest')->join('vehicledetails', 'vehiclerequest.vehicleId', '=', 'vehicledetails.id')

        ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
         ->join('users', 'users.id', '=', 'vehiclerequest.supervisor') //pull gm's name
     
     
         
         ->where('vehiclerequest.status', 6)  //approve
         ->orwhere('vehiclerequest.status', 5) //rejected
         
         ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'vehiclerequest.status','vehiclerequest.reason','orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.dateOfRequisition', 'vehicledetails.vehicle_name', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit', 'users.name', 'users.designation')
         
         ->latest('vehiclerequest.id') //similar to orderby('vehiclerequest.id','desc')
     
         ->paginate(10000000);

     $rhtml = view('vehicle.ReturnReview')->with(['returnGM' => $returnGM])->render();
     return response()
         ->json(array(
         'success' => true,
         'html' => $rhtml
     ));
 } 
 
 //END return  mto GM

     //CMDPO Review
           if ($request->v == "CMDPO_Review")
        
         {

          $cmdpoReview = DB::table('vehiclerequest')
              ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
          // ->join('users','users.id','=','vehiclerequest.supervisor')//pull users designation
          

              ->where('vehiclerequest.org_unit_id', 73) //field id
          
              ->where('vehiclerequest.status', 0)
              
              ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.designationVf','vehiclerequest.vname', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit', 'vehiclerequest.personalvehicle')

              ->latest('vehiclerequest.id') //similar to orderby('vehiclerequest.id','desc')
          
              ->paginate(10000000);

          $rhtml = view('vehicle.CMDPO_Review')->with(['cmdpoReview' => $cmdpoReview])->render();
          return response()
              ->json(array(
              'success' => true,
              'html' => $rhtml
          ));
      } 
     
     //end of cdmpo
     
      //ICD REview
        if ($request->v == "ICD_Review")
        
        {

            $IcdReview = DB::table('vehiclerequest')
                ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
            // ->join('users','users.id','=','vehiclerequest.supervisor')//pull users designation
            

                ->where('vehiclerequest.org_unit_id', 44) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 45)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 46)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 61)
                ->where('vehiclerequest.status', 0)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.designationVf','vehiclerequest.vname', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit', 'vehiclerequest.personalvehicle')

                ->latest('vehiclerequest.id') //similar to orderby('vehiclerequest.id','desc')
            
                ->paginate(10000000);

            $rhtml = view('vehicle.ICD_Review')->with(['IcdReview' => $IcdReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of ICD Review


        //TD REview
        if ($request->v == "TD_Review")
        {

            $TdReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')

                ->where('vehiclerequest.org_unit_id', 19) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 20)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 21)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 22)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 23)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 53)
                ->where('vehiclerequest.status', 0)
                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.TD_Review')->with(['TdReview' => $TdReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of TD Review
        

        //TCD Review
        if ($request->v == "TCD_Review")
        {

            $TcdReview = DB::table('vehiclerequest')                
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                ->where('vehiclerequest.org_unit_id', 54) //field i
            
                ->where('vehiclerequest.status', 0)
                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date','vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.TCD_Review')->with(['TcdReview' => $TcdReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of TCD Review
        

        //DCD REview
        if ($request->v == "DCD_Review")
        {

            $DcdReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                ->where('vehiclerequest.org_unit_id', 24) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 25)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 26)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 27)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 55)
                ->where('vehiclerequest.status', 0)
                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date',  'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.DCD_Review')->with(['DcdReview' => $DcdReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of DCD Review
        //DCSD REview
        if ($request->v == "DCSD_Review")
        {

            $DcsdReview = DB::table('vehiclerequest')                
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                ->where('vehiclerequest.org_unit_id', 28) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 29)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 30)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 31)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 32)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 56)
                ->where('vehiclerequest.status', 0)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.DCSD_Review')->with(['DcsdReview' => $DcsdReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of DCSD Review
        //HRAD REview
        if ($request->v == "HRAD_Review")
        {

            $HradReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')

                ->where('vehiclerequest.org_unit_id', 33) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 34)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 35)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 57)
                ->where('vehiclerequest.status', 0)
                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date',  'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.HRAD_Review')->with(['HradReview' => $HradReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of HRAD Review
        

        // For sbsf Review
        if ($request->v == "SFSB_Review")
        {

            $sfsbReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                // ->where('vehiclerequest.org_unit_id', 36) //field id
            
                // ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 59)
                ->where('vehiclerequest.status', 0)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date','vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.SFSB_Review')->with(['sfsbReview' => $sfsbReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } ///end of sbsf view

        // for PSD Review
        if ($request->v == "PSD_Review")
        {

            $psdReview = DB::table('vehiclerequest')

            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')

                ->where('vehiclerequest.org_unit_id', 37) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 38)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 39)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 58)
                ->where('vehiclerequest.status', 0)
                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.PSD_Review')->with(['psdReview' => $psdReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }
        //end of PSD Review
        

        //  For ERD Review
        if ($request->v == "ERD_Review")
        {

            $erdReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                ->where('vehiclerequest.org_unit_id', 41) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 42)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 43)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 60)
                ->where('vehiclerequest.status', 0)
                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.ERD_Review')->with(['erdReview' => $erdReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } // end of ERD Review
        

        //  For SPBD Review
        if ($request->v == "SPBD_Review")
        {

            $spbdReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                ->where('vehiclerequest.org_unit_id', 47) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 48)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 62)
                ->where('vehiclerequest.status', 0)
            //  ->orwhere('org_unit_id',43)
            
                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.SPBD_Review')->with(['spbdReview' => $spbdReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } // end of SPBD Review
        

        //Transmission services REview
        if ($request->v == "TS_Review")
        {

            $tsReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                ->where('vehiclerequest.org_unit_id', 10) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 11)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 63)
                ->where('vehiclerequest.status', 0)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date','vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.TS_Review')->with(['tsReview' => $tsReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of Transmission service
        

        //Distribution services REview
        if ($request->v == "DS_Review")
        {

            $dsReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')

                ->where('vehiclerequest.org_unit_id', 12) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 13)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 64)
                ->where('vehiclerequest.status', 0)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.DS_Review')->with(['dsReview' => $dsReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of d service
        

        //HRCS services REview
        if ($request->v == "HRCS_Review")
        {

            $hrcsReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')

                ->where('vehiclerequest.org_unit_id', 14) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 15)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 16)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 65)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 36)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 40)
                ->where('vehiclerequest.status', 0)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.HRCS_Review')->with(['hrcsReview' => $hrcsReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of HRCS service
        //Finance A services REview
        if ($request->v == "FAS_Review")
        {

            $fasReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                ->where('vehiclerequest.org_unit_id', 49) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 50)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 51)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 66)
                ->where('vehiclerequest.status', 0)
                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date',  'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.FAS_Review')->with(['fasReview' => $fasReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of Finance A services REview
        

        //STS REview
        if ($request->v == "STS_Review")
        {

            $stsReview = DB::table('vehiclerequest')

            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                ->where('vehiclerequest.org_unit_id', 17) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 18)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 9)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 67)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 72)
                ->where('vehiclerequest.status', 0)
        
                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.STS_Review')->with(['stsReview' => $stsReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end STS
        //BPSO REview
        if ($request->v == "BPSO_Review")
        {

            $bpsoReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')

                ->where('vehiclerequest.org_unit_id', 68) //field id
            
                ->where('vehiclerequest.status', 0)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.BPSO_Review')->with(['bpsoReview' => $bpsoReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of BPSO
        

        //INTERNAL AUDIT REview
        if ($request->v == "IAD_Review")
        {

            $iadReview = DB::table('vehiclerequest')

            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                ->where('vehiclerequest.org_unit_id', 69) //field id
            
                ->where('vehiclerequest.status', 0)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.IAD_Review')->with(['iadReview' => $iadReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of IAD
        

        //CEO Review
        if ($request->v == "DIR_Review")
        {

            $dirReview = DB::table('vehiclerequest')
            ->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')


                ->where('vehiclerequest.org_unit_id', 3) //field id
            
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 4)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 5)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 6)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 7)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 8)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 70)
                ->where('vehiclerequest.status', 0)
                ->orwhere('vehiclerequest.org_unit_id', 52)
                ->where('vehiclerequest.status', 0)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.designationVf', 'vehiclerequest.dateOfRequisition', 'vehiclerequest.start_date', 'vehiclerequest.end_date','vehiclerequest.purpose', 'vehiclerequest.placesToVisit')
                ->latest('vehiclerequest.id')
                ->paginate(10000000);

            $rhtml = view('vehicle.DIR_Review')->with(['dirReview' => $dirReview])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } //end of DIR REview
        

        //MTO review
        if ($request->v == "MTO_Review")
        {
            try{

            $id = vehiclerequest::all();

            $mtoReview = DB::table('vehiclerequest')->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
            //  ->join('users','users.id','=','vehiclerequest.supervisor')
            
                ->join('users', 'users.id', '=', 'vehiclerequest.supervisor') //pull gm's name
            
                ->where('vehiclerequest.status', 2)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.dateOfRequisition','vehiclerequest.purpose', 'vehiclerequest.placesToVisit', 'users.name', 'users.designation','vehiclerequest.personalvehicle')
                ->orderBy('vehiclerequest.id', 'desc')
                ->paginate(10000000);

            $details = Vehicles::all()
            ->where('status',0); 
            // show only vehicle with status 0 which is available ,1 is deleted vehicle status



            $rhtml = view('vehicle.MTO_Review')->with(['mtoReview' => $mtoReview, 'id' => $id, 'details' => $details])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } 
        //end of DIR REview
        catch(\Facade\Ignition\Exceptions\ViewException $e)
        {

            $id = vehiclerequest::all();

            $mtoReview = DB::table('vehiclerequest')->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
            //  ->join('users','users.id','=','vehiclerequest.supervisor')
            
                // ->join('vehicledetails', 'vehicledetails.id', '=', 'vehiclerequest.vehicleId')
                ->join('users', 'users.id', '=', 'vehiclerequest.supervisor') //pull gm's name
            
                ->where('vehiclerequest.status', 2)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.dateOfRequisition','vehiclerequest.purpose', 'vehiclerequest.placesToVisit', 'users.name', 'users.designation','vehiclerequest.personalvehicle')
                ->orderBy('vehiclerequest.id', 'desc')
                ->paginate(10000000);

            $details = Vehicles::all();

            $rhtml = view('vehicle.vehicle_reviewe')->with(['mtoReview' => $mtoReview, 'id' => $id, 'details' => $details])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));

        }
    }
//mto review end

        //MTO edit review
        if ($request->v == "MTO_EditReview")
        {
            try{

            $id = vehiclerequest::all();

            $mtoEditReview = DB::table('vehiclerequest')->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
            //  ->join('users','users.id','=','vehiclerequest.supervisor')
            
                ->join('users', 'users.id', '=', 'vehiclerequest.supervisor') //pull gm's name
            
                ->where('vehiclerequest.status', 4)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.dateOfRequisition','vehiclerequest.purpose', 'vehiclerequest.placesToVisit', 'users.name', 'users.designation','vehiclerequest.personalvehicle')
                ->orderBy('vehiclerequest.id', 'desc')
                ->paginate(10000000);

            $details = Vehicles::all();

            $rhtml = view('vehicle.MTO Edit View')->with(['mtoEditReview' => $mtoEditReview, 'id' => $id, 'details' => $details])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        } 
        
        catch(\Facade\Ignition\Exceptions\ViewException $e)
        {

            $id = vehiclerequest::all();

            $mtoEditReview = DB::table('vehiclerequest')->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
            //  ->join('users','users.id','=','vehiclerequest.supervisor')
            
                // ->join('vehicledetails', 'vehicledetails.id', '=', 'vehiclerequest.vehicleId')
                ->join('users', 'users.id', '=', 'vehiclerequest.supervisor') //pull gm's name
            
                ->where('vehiclerequest.status', 4)

                ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.dateOfRequisition','vehiclerequest.purpose', 'vehiclerequest.placesToVisit', 'users.name', 'users.designation','vehiclerequest.personalvehicle')
                ->orderBy('vehiclerequest.id', 'desc')
                ->paginate(10000000);

            $details = Vehicles::all();

            $rhtml = view('vehicle.vehicle_reviewe')->with(['mtoEditReview' => $mtoEditReview, 'id' => $id, 'details' => $details])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));

        }
    }
//mto edit review end


        //view for manage conference
        if ($request->v == "manage_conference")
        {

            $conference = conference::all();
            $review = DB::table('conference')
                ->where('status_c','0')
                ->paginate();

            $rhtml = view('conference.manage_conference')->with(['review' => $review,
            
            'conference' => $conference])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }

        //end for view  manage conference

// view for Reports

if ($request->v == "vehicleReport")
{
    $id = vehiclerequest::all();

    $reports = DB::table('vehiclerequest')->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')
    //  ->join('users','users.id','=','vehiclerequest.supervisor')
    
        ->join('vehicledetails', 'vehicledetails.id', '=', 'vehiclerequest.vehicleId')
        ->join('users', 'users.id', '=', 'vehiclerequest.supervisor') //pull gm's name
    
        // ->where('vehiclerequest.status', 0)

        ->select('vehiclerequest.id', 'vehiclerequest.emp_id', 'orgunit.description', 'vehiclerequest.vname', 'vehiclerequest.start_date', 'vehiclerequest.end_date', 'vehiclerequest.dateOfRequisition', 'vehicledetails.vehicle_name', 'vehiclerequest.purpose', 'vehiclerequest.status', 'vehiclerequest.placesToVisit', 'users.name', 'users.designation')
        ->orderBy('vehiclerequest.id', 'desc')
        ->paginate(10000000);

    $details = Vehicles::all();

    $rhtml = view('vehicle.reports')->with(['reports' => $reports, 'id' => $id, 'details' => $details])->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));
} 
    //end of IAD      

//view for manage vehicle
 //view for manage conference

 if ($request->v == "manage_vehicle")
 {

    //  $conference = vehicles::all();
    //  $review = DB::table('vehicledetails')->select('*')
    //      ->paginate();

     $rhtml = view('vehicle.manage_vehicle')->render();
     return response()
         ->json(array(
         'success' => true,
         'html' => $rhtml
     ));
 }

 //view for manage resignation
 
 if ($request->v == "resignationtypemaster")
 {
     $rhtml = view('masterData.resignationMaster')->render();
     return response()
         ->json(array(
         'success' => true,
         'html' => $rhtml
     ));
 }

 //view for manage designation

 if ($request->v == "designationmaster")
 {
     $rhtml = view('masterData.designationMaster')->render();
     return response()
         ->json(array(
         'success' => true,
         'html' => $rhtml
     ));
 }

 //view for manage company

 if ($request->v == "companymaster")
 {
     $rhtml = view('masterData.companyMaster')->render();
     return response()
         ->json(array(
         'success' => true,
         'html' => $rhtml
     ));
 }

  //view for manage leave type
 
  if ($request->v == "leavetypemaster")
  {
      $rhtml = view('masterData.leavetypeMaster')->render();
      return response()
          ->json(array(
          'success' => true,
          'html' => $rhtml
      ));
  }

 //view for manage office

 if ($request->v == "officemaster")
 {
    $officen = officeName::all();
    $reportto = Officedetails::all();
    $placemastern = place::all();  
    //$dzongkhag = Dzongkhags::all(); 
    $offhead = User::all();
    $offadd = OfficeAddress::all();   

   
    $name = DB::table('officemaster')
    ->join('officename AS A', 'A.id', '=', 'officemaster.officeName')
    // ->join('officename AS B', 'B.id', '=', 'officemaster.reportToOffice')
    ->join('users', 'users.empId', '=', 'officemaster.officeHead')
    ->join('office_address', 'office_address.placeId', '=', 'officemaster.officeAddress')
    ->join('officedetails', 'officedetails.id', '=', 'officemaster.reportToOffice')
   ->join('officehead', 'officehead.id', '=', 'officemaster.officeAddress')

   ->select('officehead.NameOfHead','A.longOfficeName','officedetails.officeDetails','office_address.Address','users.empId')
   ->where('officemaster.status',0);

    $rhtml = view('masterData.officeMaster')->with(['officen'=>$officen,'placemastern'=>$placemastern, 'offhead'=>$offhead, 'offadd'=>$offadd, 'reportto'=>$reportto])->render();
     return response()
         ->json(array(
         'success' => true,
         'html' => $rhtml
     ));
 }

 //view for manage department

 if ($request->v == "departmentmaster")
 {
    $employeen = User::all();
    $servicen = ServiceMaster::all();  
    $companyn = Company::all();         
   

    $name = DB::table('departmentmaster')
    ->join('users', 'users.id', '=', 'departmentmaster.deptHead')
    ->join('servicemaster', 'servicemaster.id', '=', 'departmentmaster.deptReportsToService')
    ->join('companymaster', 'companymaster.id', '=', 'departmentmaster.deptReportsToCompany')
    ->select('users.empId','servicemaster.serNameLong','companymaster.comNameLong')

    ->where('departmentmaster.status',0);

     $rhtml = view('masterData.departmentMaster')->with(['employeen'=>$employeen,'servicen'=>$servicen, 'companyn'=>$companyn])->render();
     return response()
         ->json(array(
         'success' => true,
         'html' => $rhtml
     ));
 }

//manage guesthouse
if ($request->v == "manage_guesthouse")
 {

     $conference = guesthouse::all();
     $dzongkhags = Dzongkhags::all();
     $review = DB::table('guesthousename')->select('*')
         ->paginate();

     $rhtml = view('guesthouse.manage_guesthouse')->with(['review' => $review,'dzongkhags'=>$dzongkhags])->render();
     return response()
         ->json(array(
         'success' => true,
         'html' => $rhtml
     ));
 }

 //manage guesthouse room details
if ($request->v == "room_details")
{

    $dzongkhags = Dzongkhags::all();
    $review = DB::table('guesthouseroom')->select('*')
        ->paginate();

    $rhtml = view('guesthouse.room_details')->with(['review' => $review,'dzongkhags'=>$dzongkhags])->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));
}
 //conference reprts
 if ($request->v == "cReports")
       {
                $conference = conference::all();

                $review = DB::table('conferencerequest')->join('orgunit', 'orgunit.id', '=', 'conferencerequest.org_unit_id')
                
                   
                     
                    ->join('conference', 'conference.id', '=', 'conferencerequest.conference_id')
                    ->where('status', 1)
                    ->where('conference_id', '1')
                   
                    ->orwhere('conference_id', '1')
                    ->where('status', 2) 
                    ->where('default',)                   

                    ->orwhere("conference_id", "2")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "3")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "4")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere('conference_id', "5")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "6")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "7")
                    ->where('status', 0)
                    ->where('default',)

                    ->select('conferencerequest.id', 'emp_id', 'name','contact_number','conferencerequest.conference_id', 'orgunit.description', 'conference.Conference_Name', 'meeting_name', 'conference_id', 'start_date', 'end_date','status')

                    ->latest('id') //similar to orderby('id','desc')
                
                
                    ->paginate(50);

                $rhtml = view('conference.conferenceReport')->with(['review' => $review, 'conference' => $conference])->render();
                return response()
                    ->json(array(
                    'success' => true,
                    'html' => $rhtml
                ));
            }
            //end report confrerences


        //view board room
        if ($request->v == "boardroom_review")
        {

            $conference = conference::all();
            $review = DB::table('conferencerequest')->join('orgunit', 'orgunit.id', '=', 'conferencerequest.org_unit_id')
            // ->join('division_tbl','division_tbl.id','=','conferencerequest.div_id')
            // ->join('wing_tbl','wing_tbl.id','=','conferencerequest.wing_id')
            // ->join('department_tbl','department_tbl.id','=','conferencerequest.dept_id')
            
            // ->join('rangeofpeople', 'rangeofpeople.id', '=', 'conferencerequest.no_of_people') 
                ->join('conference', 'conference.id', '=', 'conferencerequest.conference_id')

                ->where('status', 0)
                ->where('conference_id', '1')
                ->where('default',)

            // ->orWhere('conference_id','=','5')
            // ->Where('status','=','0')
            
                ->select('conferencerequest.id', 'emp_id', 'name','contact_number', 'conference.Conference_Name','conferencerequest.conference_id', 'orgunit.description', 'meeting_name', 'start_date', 'end_date')
                ->latest('id')

                ->paginate(50);

            $rhtml = view('conference.boardroom_review')->with(['review' => $review, 'conference' => $conference])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }
        //view status in admin(frontdesk)
        if ($request->v == "booking_review")
        {

            try
            {

                $conference = conference::all();

                $review = DB::table('conferencerequest')->join('orgunit', 'orgunit.id', '=', 'conferencerequest.org_unit_id')
                // ->join('rangeofpeople', 'rangeofpeople.id', '=', 'conferencerequest.no_of_people') 
                    ->join('conference', 'conference.id', '=', 'conferencerequest.conference_id')
                    ->where('status', 1)
                    ->where('conference_id', '1')

                    ->orwhere("conference_id", "2")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "3")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "4")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere('conference_id', "5")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "6")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "7")
                    ->where('status', 0)
                    ->where('default',)

                    ->select('conferencerequest.id', 'emp_id', 'name','contact_number','conferencerequest.conference_id', 'orgunit.description', 'conference.Conference_Name', 'meeting_name', 'conference_id', 'start_date', 'end_date')

                    ->latest('id') //similar to orderby('id','desc')
                

                
                    ->paginate(50);

                $rhtml = view('conference.booking_review')->with(['review' => $review, 'conference' => $conference])->render();
                return response()
                    ->json(array(
                    'success' => true,
                    'html' => $rhtml
                ));

                
            }

            catch(\Facade\Ignition\Exceptions\ViewException $e)
            {  

                $conference = conference::all();

                $review = DB::table('conferencerequest')->join('orgunit', 'orgunit.id', '=', 'conferencerequest.org_unit_id')
                // ->join('rangeofpeople', 'rangeofpeople.id', '=', 'conferencerequest.no_of_people') 
                    ->join('conference', 'conference.id', '=', 'conferencerequest.conference_id')
                    ->where('status', 1)
                    ->where('conference_id', '1')

                    ->orwhere("conference_id", "2")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "3")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "4")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere('conference_id', "5")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "6")
                    ->where('status', 0)
                    ->where('default',)

                    ->orwhere("conference_id", "7")
                    ->where('status', 0)
                    ->where('default',)

                    ->select('conferencerequest.id', 'emp_id', 'name','contact_number','conferencerequest.conference_id', 'orgunit.description', 'conference.Conference_Name', 'meeting_name', 'conference_id', 'start_date', 'end_date')

                    ->latest('id') //similar to orderby('id','desc')
                

                
                    ->paginate(50);

                $rhtml = view('conference.booking_reviewe')->with(['review' => $review, 'conference' => $conference])->render();
                return response()
                    ->json(array(
                    'success' => true,
                    'html' => $rhtml
                ));
                

            }
        }
        //change password for frontdesk and secretary
        if ($request->v == "changepassword")
        {

            $rhtml = view('changepassword')->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }

        //change password for frontdesk and secretary
        if ($request->v == "resetpassword")
        {

            $rhtml = view('auth.resetpassword')->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }

        //user add for login
        if ($request->v == "user")
        {

            $user = Auth::user();
            $grade = Grade::all();
            $dzongkhag = Dzongkhags::all();
            $OrgUnit = OrgUnit::all();
            $roles = roles::all();



          
            $rhtml = view('super admin.user')->with(['roles' => $roles, 'OrgUnit' => $OrgUnit,'dzongkhag' => $dzongkhag,'grade' => $grade])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));

        }


           //role add from admin
           if ($request->v == "roleAdd")
           {
   
              
              
               
               $rhtml = view('super admin.roleAdd')->render();
               return response()
                   ->json(array(
                   'success' => true,
                   'html' => $rhtml
               ));
   
           }

        //user delete for login
        if ($request->v == "userdelete")
        {
            $user = Auth::user();

            $roles = $user->role;
            $role_admin = false;
            foreach ($roles as $role)
            {
                if ($role->name == "Admin")
                {
                    $role_admin = true;
                }
            }
            //admin to add user from any dzongkhags and any roles.
            if ($role_admin)
            {
                $roles = Roles::all();
                $dzongkhags = Dzongkhags::all();
            }
            else
            {
                $roles = Roles::wherein('role_admin', $user->role)
                    ->get();
                $dzongkhags = Dzongkhags::where('id', $user->dzongkhag_id)
                    ->get();
            }

            $rhtml = view('super admin.userdelete')->with(['roles' => $roles, 'dzongkhags' => $dzongkhags])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }

        //vehicle review by supervisor
        if ($request->v == "vehicle_review")
        {

            $vehicle = vehicles::all();

            $review = DB::table('vehiclerequest')->join('orgunit', 'orgunit.id', '=', 'vehiclerequest.org_unit_id')

            // ->join('division_tbl','division_tbl.id','=','conferencerequest.div_id')
            // ->join('wing_tbl','wing_tbl.id','=','conferencerequest.wing_id')
            // ->join('department_tbl','department_tbl.id','=','conferencerequest.dept_id')
            
                ->join('vehicledetails', 'vehicledetails.id', '=', 'vehiclerequest.vehicleId')

                ->select('vehicledetails.id', 'emp_id', 'name', 'designation', 'vehiclerequest.vehicleId', 'orgunit.description', 'vehicledetails.vehicle_name', 'vehicle_number', 'vehicleId', 'start_date', 'end_date', 'purpose', 'placesToVisit', 'supervisor', 'mto')

                ->latest('id') //similar to orderby('id','desc')
            

            
                ->paginate(50);

            $rhtml = view('vehicle.vehicle_review')->with(['review' => $review, 'vehicle' => $vehicle])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }

       //employeemaster
         //Golay's part from here
         if ($request->v == "employeemaster")
         {
 
            $user = Auth::user();
            // $grade = Grade::all();
            $dzongkhag = Dzongkhags::all();
            // $OrgUnit = OrgUnit::all();
            $roles = roles::all(); //here ena mos
            $bk = bank::all();
            $dg = Designation::all()->where('status',0); 
            $rg = Resignation::all(); 
            $gg = pay::all();
            $ff = officeName::all(); 
            $pp = OfficeAddress::all();
            $officedetails = Officedetails::all();     

           


            $bankName = DB::table('employeemaster')
            ->join('bankmaster', 'bankmaster.id', '=', 'employeemaster.bankName')
            ->select('bankmaster.bankName')    
            ->where('employeemaster.status', '=', 0);

            $designationId = DB::table('employeemaster')
            ->join('designationmaster', 'designationmaster.id', '=', 'employeemaster.designationId')
            ->select('designationmaster.desisNameLong')
            ->where('employeemaster.status', '=', 0); 
                
            $resignationTypeId = DB::table('employeemaster')
            ->join('resignationtypemaster', 'resignationtypemaster.id', '=', 'employeemaster.resignationTypeId')
            ->select('resignationtypemaster.resignationType')
            ->where('employeemaster.status', '=', 0);
               
            $gradeId = DB::table('employeemaster')
            ->join('payscalemaster', 'payscalemaster.id', '=', 'employeemaster.gradeId')
            ->select('payscalemaster.grade')
            ->where('employeemaster.status', '=', 0);

            $office = DB::table('employeemaster')
               ->join('officename', 'officename.id', '=', 'employeemaster.office')
               ->select('officename.longOfficeName')
               ->where('employeemaster.status', '=', 0);

           $placeId = DB::table('employeemaster')
               ->join('office_address', 'office_address.placeId', '=', 'employeemaster.placeId')
               ->select('office_address.Address')
               ->where('employeemaster.status', '=', 0);

            $rhtml = view('masterData.employeeMaster')->with(['officedetails'=>$officedetails,'dg' => $dg, 'bk' => $bk,'roles' => $roles,'rg' => $rg, 'gg' => $gg, 'ff' => $ff, 'pp' => $pp,'dzongkhag' => $dzongkhag])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));

        }

        //endemployeemaster


         //officeName
         if ($request->v == "officename")
         {
            $rhtml = view('masterData.officeName')->render();
             return response()
                 ->json(array(
                 'success' => true,
                 'html' => $rhtml
             ));
 
         }

        //end officeName

            //gewogmaster
            if ($request->v == "gewogmaster")
            {
                
                $dzongkhag = Dzongkhags::all()
                ->where('status',0);
                $drungkhag = drungkhag::all()
                ->where('status',0);
                
               $gewog = DB::table('gewogmaster')
               ->join('dzongkhags', 'dzongkhags.id', '=', 'gewogmaster.dzongkhagId')
               ->join('drungkhagmaster', 'drungkhagmaster.id', '=', 'gewogmaster.drungkhagId')
               ->select('dzongkhags.Dzongkhag_Name','drungkhagmaster.drungkhagName')
               ->where('gewogmaster.status',0);         
    
                $rhtml = view('masterData.gewog')->with(['dzongkhag' => $dzongkhag,'drungkhag' =>$drungkhag])->render();
                 return response()
                     ->json(array(
                     'success' => true,
                     'html' => $rhtml
                 ));
     
             }
    
            //end gewogmaster

              //drungkhagmaster
              if ($request->v == "drungkhagmaster")
              {
                  $dzongkhag = Dzongkhags::all();
                  
                       
      
                  $rhtml = view('masterData.drungkhag')->with(['dzongkhag' => $dzongkhag])->render();
                   return response()
                       ->json(array(
                       'success' => true,
                       'html' => $rhtml
                   ));
       
               }
      
              //end drungkhagmaster
  
                //drungkhagmaster
               if ($request->v == "townmaster")
               {
                   $dzongkhag = Dzongkhags::all()
                   ->where('status',0);
                   
                        
       
                   $rhtml = view('masterData.town')->with(['dzongkhag' => $dzongkhag])->render();
                    return response()
                        ->json(array(
                        'success' => true,
                        'html' => $rhtml
                    ));
        
                }
       
               //end townmaster
              
      
                //bankmaster
                if ($request->v == "bankmaster")
                {                           
        
                    $rhtml = view('masterData.bank')->render();
                     return response()
                         ->json(array(
                         'success' => true,
                         'html' => $rhtml
                     ));
         
                 }
        
                //end bankmaster
      
                //villagemaster
                 if ($request->v == "villagemaster")
                 {
                            
                   $gewog = gewog::all()
                   ->where('status',0);
       
       
                     $rhtml = view('masterData.village')->with(['gewog' => $gewog])->render();
                      return response()
                          ->json(array(
                          'success' => true,
                          'html' => $rhtml
                      ));
          
                  }
         
                 //end villagemaster
            
             //placemaster
             if ($request->v == "placemaster")
             {
                        
               $dzongkhag = Dzongkhags::all();               

               $gewog = gewog::all()
               ->where('status',0);

               $village = village::all()
               ->where('status',0);

               $drungkhag = drungkhag::all()
               ->where('status',0);

               $town = town::all()
               ->where('status',0);

   
   
                 $rhtml = view('masterData.place')->with(['village' => $village ,'town' => $town,'drungkhag' => $drungkhag,'gewog' => $gewog,'dzongkhag' => $dzongkhag])->render();
                  return response()
                      ->json(array(
                      'success' => true,
                      'html' => $rhtml
                  ));
      
              }
     
             //end placemaster

         //grade master
        
         if ($request->v == "grademaster")
         {
             $rhtml = view('masterData.gradeMaster')->render();
             return response()
                 ->json(array(
                 'success' => true,
                 'html' => $rhtml
             ));
 
         } 

        //endgrademaster
        //post master
        
    if ($request->v == "postmaster")
    {

    $rhtml = view('masterData.postMaster')->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));

    }

        //end of post master


         //division master
         
         if ($request->v == "divisionmaster")
         {
 
    
             $rhtml = view('masterData.divisionMaster')->render();
             return response()
                 ->json(array(
                 'success' => true,
                 'html' => $rhtml
             ));
 
         }

        //enddivisionmaster


         //contract detail master
         
         if ($request->v == "contractdetails")
         {
            $employeen = User::all()
            ->where('status',0);
           
            $contractdetails = DB::table('contractdetailsmaster')
            ->join('users', 'users.empId', '=', 'contractdetailsmaster.personalNo')
            ->select('users.empId')
            ->where('contractdetailsmaster.status',0);         

             $rhtml = view('masterData.contractDetailMaster')->with(['employeen' => $employeen])->render();
             return response()
                 ->json(array(
                 'success' => true,
                 'html' => $rhtml
             ));
 
         }

        //endcontractdetailmaster

        //service master
         if ($request->v == "servicemaster")
         {
            $services = EmployeeMaster::all()
            ->where('status',0);

            $companym = Company::all()
            ->where('status',0);

            $service = DB::table('servicemaster')
            ->join('employeemaster', 'employeemaster.id', '=', 'servicemaster.serviceHead')
            ->join('companymaster', 'companymaster.id', '=', 'servicemaster.company')
            ->select('servicemaster.id','serNameShort','serNameLong','employeemaster.empId','companymaster.comNameLong')
            ->where('servicemaster.status','0');

 
    
             $rhtml = view('masterData.serviceMaster')->with([ 'services' => $services,'companym' => $companym])->render();
             return response()
                 ->json(array(
                 'success' => true,
                 'html' => $rhtml
             ));
 
         }
        //endservicemaster

         //substation
         if ($request->v == "substationmaster")
         {

             $rhtml = view('masterData.substationMaster')->render();
             return response()
                 ->json(array(
                 'success' => true,
                 'html' => $rhtml
             ));
 
         }

        //end of substation


        if ($request->v == "employee_reporting")
        {
       
            $employee = EmployeeMaster::all()
            ->where('status',0);

           
       
            $rhtml = view('emp.employee_reporting')->with(['employee' => $employee])->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }


         //subdivision
         if ($request->v == "subdivisionmaster")
         {
             
             $subdiv = DivisionMaster::all()
             ->where('status',0);

             $employeemas = User::all()
             ->where('status',0);
 
 
             $subdivisions = DB::table('subdivisionmaster')
             ->join('divisionmaster', 'divisionmaster.id', '=', 'subdivisionmaster.subDivnameLong')
             ->join('users', 'users.id', '=', 'subdivisionmaster.subDivhead')
 
             ->select('divisionmaster.divNameLong','users.empName')
          
             ->where('subdivisionmaster.status',0);   
 
 
 
             $rhtml = view('masterData.subDivisionMaster')->with(['subdiv' => $subdiv, 'employeemas' => $employeemas])->render();
             return response()
                 ->json(array(
                 'success' => true,
                 'html' => $rhtml
             ));
 
         }
         //end of sub division

//payscale

if ($request->v == "pay_scale")
{

    $payscale = DB::table('paysclaemaster')
    ->select('*')
    ->where('paysclaemaster.status',0)
    ->orderBy('payscalemaster.low', 'desc');
    

    $rhtml = view('emp.pay_scale')->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));
}

//familydetails

if ($request->v == "family_details")
{

    $family = Relationname::all()
    ->where('status',0);

    $personal =EmployeeMaster::all()
    ->where('status',0);

    $rhtml = view('emp.family_details')->with(['family' => $family ,'personal' =>$personal])->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));
}

//increment history

if ($request->v == "increment_history")
{
    $increment = User::all();

    $rhtml = view('emp.increment_history')->with(['increment' => $increment])->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));
}

//office reporting
if ($request->v == "office_reporting")
{
    // $office = officeName::all();

    $rhtml = view('emp.office_reporting')->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));
}

//Promotion history
if ($request->v == "promotion_history")
{
    $designationMaster = Designation::all();

    $rhtml = view('emp.promotion_history')->with(['designationMaster' => $designationMaster ])->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));
}

//Promotion history end

// for promotion all
if ($request->v == "promotionall")  //form.csv
{    
    $promo = User::all();

    $b = DB::table('promotionall')
    
    ->join('users', 'users.empId', '=', 'promotionall.empId')
    // ->select('users.empId');
    ->select('users.empId','promotionall.id','promotionall.grade', 'promotionall.gradeCeiling', 'promotionall.yearsToPromote', 'promotionall.doJoining', 'promotionall.doLastPromotion', 'promotionall.promotionDueDate', 'promotionall.modificationReason')
    ->get();

    $rhtml = view('promotion.promotionAll')->with(['promo'=>$promo])->render(); 
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
        ));
}  //end

//promotion list
if ($request->v == "promotionform")  //form.csv
{    

 $rhtml = view('promotion.promotionAllList')->render(); 
 return response()
    ->json(array(
     'success' => true,
     'html' => $rhtml
      ));
}  //end

 // promotion Review Manager
 if ($request->v == "promotionReview")  //form.csv
 {    
   $promotionRequest = promotionRequest::all();
   $officedetails = Officedetails::all();     
   $promotionRequest = DB::table('promotionduelist')
    ->join('officedetails', 'officedetails.id', '=', 'promotionduelist.office') 
    ->join('officeunder','officeunder.office','=','promotionduelist.office')
    ->join('users','users.empId','=','promotionduelist.empId')
    ->join('payscalemaster', 'payscalemaster.id', '=', 'promotionduelist.fromGrade')
    ->join('payscalemaster as ps', 'ps.id', '=', 'promotionduelist.toGrade') 
    //added 2 new line for grade name not id

    ->select('promotionduelist.*','officedetails.longOfficeName','users.empName','payscalemaster.grade as fGrade','ps.grade as tGrade')
    ->latest('promotionduelist.id') //similar to orderby('id','desc')
    // ->where('promotionduelist.office',Auth::user()->office)
    ->where('officeunder.head',Auth::user()->empId)

    ->where('promotionduelist.status','=','Due')
   //  ->where('cancelled','=','No') 
    ->paginate(10000000);

  $rhtml = view('promotion.promotionManagerReview')->with(['promotionRequest' => $promotionRequest, 'officedetails' => $officedetails])->render(); 
  return response()
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 }  //end

 //GM promotion review
 if ($request->v == "gmPromotionReview")  //form.csv
 {  
    $promotiondue =Promotionduelist::all();
    $officedetails = Officedetails::all();

    $promotiondue = DB::table('promotionduelist')

    ->join('officedetails', 'officedetails.id', '=', 'promotionduelist.office')
    ->join('officemaster','officemaster.id','=','promotionduelist.office')
    ->join('officeunder','officeunder.office','=','promotionduelist.office')
    ->join('users','users.empId','=','promotionduelist.empId')
    ->join('payscalemaster', 'payscalemaster.id', '=', 'promotionduelist.fromGrade')
    ->join('payscalemaster as ps', 'ps.id', '=', 'promotionduelist.toGrade') 
    //added 2 new line for grade name not id

    ->select('promotionduelist.*','officedetails.longOfficeName','officemaster.reportToOffice','users.empName','payscalemaster.grade as fGrade','ps.grade as tGrade')
    ->latest('promotionduelist.id') //similar to orderby('id','desc')

   ->where('promotionduelist.status','=','Recommended')
   ->where('promotionduelist.office',Auth::user()->office)  //mam icd
//    ->orwhere('officemaster.reportToOffice',Auth::user()->office  && 'promotionduelist.status','=','Recommended') //gm 
   ->orwhere('officemaster.reportToOffice',Auth::user()->office)
    ->where('promotionduelist.status','=','Recommended')   
   
    ->orwhere('officeunder.head',Auth::user()->empId)
    ->where('promotionduelist.status','=','Recommended')

   ->paginate(10000000);
    

  $rhtml = view('promotion.GMReviewPromotion')->with(['promotiondue' => $promotiondue,'officedetails' => $officedetails])->render();
  return response()
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 }//end

 //Director
 if ($request->v == "stsPromotionReview")  //form.csv
 {  
    $promotiondue =Promotionduelist::all();
    $officedetails = Officedetails::all();

    $promotiondue = DB::table('promotionduelist')

    ->join('officedetails', 'officedetails.id', '=', 'promotionduelist.office')
    ->join('officemaster','officemaster.id','=','promotionduelist.office')
    ->join('officeunder','officeunder.office','=','promotionduelist.office') //added new join
    ->join('users','users.empId','=','promotionduelist.empId')
    ->join('payscalemaster', 'payscalemaster.id', '=', 'promotionduelist.fromGrade')
    ->join('payscalemaster as ps', 'ps.id', '=', 'promotionduelist.toGrade') 
    //added 2 new line for grade name not id

    ->select('promotionduelist.*','officedetails.longOfficeName','officemaster.reportToOffice','officeunder.office','users.empName','payscalemaster.grade as fGrade','ps.grade as tGrade')
    ->latest('promotionduelist.id')         //similar to orderby('id','desc')

//    ->where('promotionduelist.status','=','Proposed')
//    ->where('promotionduelist.office',Auth::user()->office)  //mam icd
   
//  ->orwhere('officemaster.reportToOffice',Auth::user()->office  && 'promotionduelist.status','=','Recommended') //gm  //alredy commented


//    ->orwhere('officemaster.reportToOffice',Auth::user()->office)
//     ->where('promotionduelist.status','=','Proposed')

        ->where('promotionduelist.status','=','Recommended')
        ->where('officeunder.head',Auth::user()->empId) 
        ->paginate(10000000); 


    // ->orwhere('office','=',89)  //IT
    // ->where('promotionduelist.status','=','Proposed') 

    // ->orwhere('office','=',90) // Suit
    // ->where('promotionduelist.status','=','Proposed')

    // ->orwhere('office','=',88)  //fnd (3 for ICD)
    // ->where('promotionduelist.status','=','Proposed')

    // ->orwhere('office','=',72) // RDD
    // ->where('promotionduelist.status','=','Proposed')

    // ->orwhere('office','=',86) // 
    // ->where('promotionduelist.status','=','Proposed')

    // ->orwhere('office','=',87) // GIS
    // ->where('promotionduelist.status','=','Proposed')

    // ->orwhere('office','=',93) //spbd
    // ->where('promotionduelist.status','=','Proposed')

    // ->orwhere('office','=',94) //cspd
    // ->where('promotionduelist.status','=','Proposed')
    // ->paginate(10000000);


// ->orwhere('office','>=',86 ||'office','<=',90  ||'office','=',72 ||'office','=',93 || 'office','=',94 ) //cspd

// ->where('promotionduelist.status','=','Proposed')



    

  $rhtml = view('promotion.STSDirReview')->with(['promotiondue' => $promotiondue,'officedetails' => $officedetails])->render();
  return response()
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 }//end




 // Promotion review FAS Dir
 if ($request->v == "fasPromotionReview")  //form.csv
 {    
    $promotionRequestdir = promotionRequest::all(); 
    $officedetails = Officedetails::all(); 
     
    $promotionRequestdir = DB::table('promotionduelist')
    ->join('officedetails', 'officedetails.id', '=', 'promotionduelist.office') 
   ->join('officemaster','officemaster.id','=','promotionduelist.office')
    ->select('promotionduelist.*','officedetails.longOfficeName','officemaster.reportToOffice')

   ->latest('promotionduelist.id') //similar to orderby('id','desc')

    ->where('promotionduelist.status','=','Proposed') 
    // ->where('cancelled','=','No')
    ->where('promotionduelist.office',Auth::user()->office)
    ->orwhere('officemaster.reportToOffice',Auth::user()->office)
    ->where('promotionduelist.status','=','Proposed') 



    ->paginate(10000000);


    $rhtml = view('promotion.FASDirReviewpromotion')->with([ 'promotionRequestdir' => $promotionRequestdir,'officedetails'=>$officedetails])->render(); 
  return response()
  
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 }  //end

//user_profile
if ($request->v == "user_profile")
{
    $place= place::all();
  $bank= bank::all();
  $officeaddress=Officedetails::all();
  $qualification=Qualificationview::all()->where('empId',Auth::user()->empId);

    $rhtml = view('emp.user_profile')->with(['place' => $place, 'bank' =>$bank, 'officeaddress' =>$officeaddress,
     'qualification' =>$qualification ])->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
     ));
}


//jobDescription
if ($request->v == "jobDescription")
{
   
  $job=jobDescription::all();
  $qualification=Qualificationview::all()->where('empId',Auth::user()->empId);
  $userdetails = DB::table('jobdescription')
    ->join('users', 'users.empId', '=', 'jobdescription.empId')
     ->join('officedetails','officedetails.id', 'users.office') 
    ->select('users.empName','officedetails.longOfficeName')
  ->get();
  


    $rhtml = view('emp.jobDescription')->with(['job' => $job,'userdetails'=>$userdetails ])->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
     ));
}


//start of jobdescription
       if ($request->v == "jobDescriptionReview")
       {
        
        $job=jobDescription::all();
        $qualification=Qualificationview::all()->where('empId',Auth::user()->empId);
        $userdetails = DB::table('jobdescription')
        ->join('users', 'users.empId', '=', 'jobdescription.empId')
         ->join('officedetails','officedetails.id', 'users.office') 
         ->join('officemaster','officemaster.id','=','jobdescription.officeId')



          ->select('jobdescription.*','users.empName','officedetails.officeDetails')
        //   ->where('jobdescription.officeId',Auth::user()->office)

        ->where('officemaster.reportToOffice','=',Auth::user()->office) 
        ->where('jobdescription.approvedBy',) 

          ->WhereNull('dateExpired')
          ->paginate(10000000);
        
      
      
          $rhtml = view('emp.jobDescriptionReview')->with(['job' => $job,'userdetails'=>$userdetails ])->render();
          return response()
              ->json(array(
              'success' => true,
              'html' => $rhtml
           ));
      }

       //end of jobdescription review.


 //jobDescriptionRepository for employees
 if ($request->v == "jobDescriptionRepository")
 {
    

 
     $userLists = DB::table('jobdescription')
          ->join('users', 'users.empId', '=', 'jobdescription.empId')
          ->join('officedetails','officedetails.id', 'users.office') 
      //    ->join('officemaster','officemaster.id','=','users.office')
 
      ->select('jobdescription.*','officedetails.officeDetails','officedetails.Address'
        ,'users.empName' )
       ->where('jobdescription.status','=',1)
       ->WhereNull('dateExpired')
    
          ->paginate(10000000);
      $rhtml = view('emp.jobDescriptionRepository')->with(['userList' => $userLists])->render();
     return response()
         ->json(array(
         'success' => true,
         'html' => $rhtml
     ));
 }
 //end of jobRepository.

//incrementreport
if ($request->v == "incrementReport")
{
      $increment = IncrementView::all();

    $increment = DB::table('viewincrementorder')
    ->join('officedetails','officedetails.id','=','viewincrementorder.officeId')
      ->select('viewincrementorder.*','officedetails.officeDetails')

    // ->select('incrementduelist.*','users.empName')
    // ->where('incrementduelist.status','=','Approved')
    // ->latest('incrementduelist.id')
    ->get(); 

    $rhtml = view('Increment.incrementReport')->with(['increment' => $increment])->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));
}

//notesheetreport
if ($request->v == "notesheetReport")
{
    //  $notesheet = notesheetRequest::all();
    $notesheet = DB::table('notesheet')
    ->join('officedetails','officedetails.id','=','notesheet.officeId')
    ->join('users','users.empId','=','notesheet.createdBy')
    ->select('notesheet.*','notesheet.id as noteId','officedetails.longOfficeName','users.empName')  
        ->where('notesheet.status','=','approved')
        ->latest('notesheet.id')
        ->get();

    $rhtml = view('Notesheet.notesheetReport')->with(['notesheet' => $notesheet])->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));
}


//promotionReport

if ($request->v == "promotionReport")
{
    //  $notesheet = notesheetRequest::all();
    $promotion = DB::table('viewpromotionorder')
    ->select('*')  
     ->latest('viewpromotionorder.id')
     ->where('newDesignation','!=','Designation Not Found')
     ->get();

    $rhtml = view('promotion.promotionReport')->with(['promotion' => $promotion])->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));
}


         //1. view for Qualificationleveltype (Tdee)

         if ($request->v == "qualilevelmaster")  //form.csv
         {    
 
          $rhtml = view('masterData.qualificationLevelType')->render(); 
          return response()
             ->json(array(
              'success' => true,
              'html' => $rhtml
               ));
         }  
         
         //end
 
         //2. view for Qualificationlevel (Tdee)
 
         if ($request->v == "qualificationmaster")  //form.csv
             {  
                
        
        $qualificationlevel = QualificationLevel::all()   //model of other joining table qualilevelmaster
        ->where('status',0);

        $qmaster = Field::all()
        ->where('status',0);

        $quali = DB::table('qualificationmaster')
        ->join('qualilevelmaster', 'qualilevelmaster.id', '=', 'qualificationmaster.qualificationLevelId')
        ->join('fieldmaster','fieldmaster.id','=','qualificationmaster.qualificationField')
        ->select('qualilevelmaster.qualiLevelName','fieldmaster.fieldName')
            ->where('qualificationmaster.status',0);          

       $rhtml = view('masterData.qualificationLevel')->with(['qualificationlevel' => $qualificationlevel,'qmaster'=>$qmaster])->render();
          return response()
             ->json(array(
              'success' => true,
              'html' => $rhtml
               ));
      }  //end
 
 
     //3. relationmaster          
         if ($request->v == "relationmaster")
         {
 
              
 
          $rhtml = view('masterData.relation')->render();
          return response()
                ->json(array(
               'success' => true,
                  'html' => $rhtml
      ));
         }  
 
          //4. Employee Qualificationlevel (Tdee)
 
          if ($request->v == "employeequalificationmaster")  //form.csv
          {     
            $qualification = Qualification::all()   //model of other joining table
            ->where('status',0);
            
            $pno = EmployeeMaster::all()
            ->where('status',0);
            
            $pno = User::all()
            ->where('status',0);

            $empquali = DB::table('employeequalificationmaster')
            ->join('qualificationmaster', 'qualificationmaster.id', '=', 'employeequalificationmaster.id')
            ->join('users','users.id','=','employeequalificationmaster.id')
            ->select('qualificationmaster.qualificationName','users.empId')
            ->where('employeequalificationmaster.status',0);         
 
             $rhtml = view('masterData.employeeQualification')->with(['qualification' => $qualification,'pno'=>$pno])->render();
              return response()
                  ->json(array(
                  'success' => true,
                  'html' => $rhtml     
      

                ));
       } 
        //end
 
       //5. displinary   (tdee)       
       if ($request->v == "displinaryhistorymaster")
       {              
 
        $rhtml = view('masterData.displinary')->render();
        return response()
              ->json(array(
             'success' => true,
                'html' => $rhtml
            ));
       }  //end

       //6. Unitmaster (Tdee)          
       if ($request->v == "unitmaster")
       {
            
 
        $rhtml = view('masterData.unit')->render();
        return response()
              ->json(array(
             'success' => true,
                'html' => $rhtml
            ));
       }  //end

       //7. fieldmaster          
       if ($request->v == "field")     //name in form 
        {              

        $rhtml = view('masterData.field')->render();
        return response()
              ->json(array(
             'success' => true,
                'html' => $rhtml
          ));
         } 

         
       //uniform
       //jacket
         if ($request->v == "jacketsize")  //form.csv
         {    
 
       
          $rhtml = view('uniform.jacketSize')->render(); 
          return response()
             ->json(array(
              'success' => true,
              'html' => $rhtml
               ));
         }  
         //end
         

        //jacket
         if ($request->v == "jacketReport")  //form.csv
         { 

         $jacketsize = JacketSize::all()
         ->where('status',0);  

         $officename = Officedetails::all()
         ->where('status',0);  


         $data = DB::table('employeeuniform')
         


        // ->join('users', 'users.id', '=', 'employeeuniform.empId')
        ->join('jacketmaster', 'jacketmaster.id', '=', 'employeeuniform.jacket')
         ->join('officedetails', 'officedetails.id', '=', 'employeeuniform.officeId')  
         ->select('employeeuniform.id','employeeuniform.empId','officedetails.longOfficeName','jacketmaster.sizeName')	
         ->where('employeeuniform.status',0)  ;
 
       
        $rhtml = view('uniform.jacketReport')->with([ 'jacketsize' => $jacketsize,'officename' => $officename])->render(); 
          return response()
             ->json(array(
              'success' => true,
              'html' => $rhtml
               ));
         }
         //end



        //raincoat

         if ($request->v == "raincoatsize")  //form.csv
         {    
 
       
          $rhtml = view('uniform.rainCoatSize')->render(); 
          return response()
             ->json(array(
              'success' => true,
              'html' => $rhtml
               ));
         }  
         //end




         // uniform pantsize
         if ($request->v == "pantsize")  //form.csv
         {    
 
          $rhtml = view('uniform.pant')->render(); 
          return response()
             ->json(array(
              'success' => true,
              'html' => $rhtml
               ));
         }  //end

          // uniform shirtsize
          if ($request->v == "shirtsize")  //form.csv
          {    
  
           $rhtml = view('uniform.shirt')->render(); 
           return response()
              ->json(array(
               'success' => true,
               'html' => $rhtml
                ));
          }  //end
// gumboot size
 
if ($request->v == "Gumboot")  //form.csv
{    

    $rhtml = view('uniform.gumbootSize')->render(); 
    return response()
    ->json(array(
    'success' => true,
    'html' => $rhtml
     ));
}  //end



// for welfare payment
          if ($request->v == "welfarepayment")  //form.csv
          {    
  
           $rhtml = view('welfare.welfarePayment')->render(); 
           return response()
              ->json(array(
               'success' => true,
               'html' => $rhtml
                ));
          }  //end


//welfare payment report
if ($request->v == "welfarepaymentreport")  //form.csv
{    

 $rhtml = view('welfare.welfarePaymentReport')->render(); 
 return response()
    ->json(array(
     'success' => true,
     'html' => $rhtml
      ));
}  //end

        //welfare refund  
if ($request->v == "refund")  //form.csv
{    

 $rhtml = view('welfare.refund')->render(); 
 return response()
    ->json(array(
     'success' => true,
     'html' => $rhtml
      ));
}  //end

if ($request->v == "refundReport")  //form.csv
{    

 $rhtml = view('welfare.welfareRefundReport')->render(); 
 return response()
    ->json(array(
     'success' => true,
     'html' => $rhtml
      ));
}  //end
//view for manage Welfare Bank

if ($request->v == "wfbank")
{
    $wfbalance = Balance::all();
    
    $rhtml = view('welfare.welfareBank')->with(['wfbalance'=>$wfbalance])->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));
}
//end

//skill category

if ($request->v == "skillcategory")  //form.csv
{    

 $rhtml = view('masterData.skillCategory')->render(); 
 return response()
    ->json(array(
     'success' => true,
     'html' => $rhtml
      ));
}  //end

//skill category
//view for manage skill master

if ($request->v == "skillmaster")
{ 
   $skilm = SubSkillCategory::all(); 

   $b = DB::table('skillmaster')
       ->join('skillsubcategory', 'skillsubcategory.id', '=', 'skillmaster.subCatId')
       ->select('skillsubcategory.subCatName')
       ->where('skillmaster.status','0');

    $rhtml = view('masterData.skillMaster')->with(['skilm'=>$skilm])->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));
}

//sub skill category
if ($request->v == "subskillcategory")  //form.csv
{      
    $subCat = SkillCategory::all()
    ->where('status',0);

    $test = DB::table('skillsubcategory')
    ->join('skillcategorymaster','skillcategorymaster.id','=','skillsubcategory.catId')
    ->select('skillcategorymaster.categoryName')
     ->where('skillsubcategory.status',0);

 $rhtml = view('masterData.skillSubCategory')->with(['subCat'=>$subCat])->render();
  
 return response()
    ->json(array(
     'success' => true,
     'html' => $rhtml
      ));
}  //end

// employee skill map

if ($request->v == "employeeskillmap")  //form.csv
{   

    $emp = User::all()
   ->where('status',0);

   $skills = Skillmaster::all()
   ->where('status',0);

    $empskills = DB::table('employeeskillmap')
    ->join('users', 'users.id', '=', 'employeeskillmap.pNo')
    ->join('skillmaster', 'skillmaster.id', '=', 'employeeskillmap.skillId')
    ->select('employeeskillmap.id','users.empId','skillmaster.skillName','obtainedOn','expiryDate')
    ->where('employeeskillmap.status','0');
    
    

    $rhtml = view('masterData.employeeSkillMap')->with([ 'emp' => $emp,'skills' => $skills])->render();


 return response()
    ->json(array(
     'success' => true,
     'html' => $rhtml
      ));
}  //end

    
 // Notesheet
 if ($request->v == "notesheet")  //form.csv
 {    

  $rhtml = view('Notesheet.notesheetRequest')->render(); 
  return response()
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 }  //end

 if ($request->v == "notesheetReview")  //form.csv  //manager review nootesheet
 {    
    // $roles = Roles::all();
    $notesheetRequest = notesheetRequest::all();    
    $officedetails = Officedetails::all();     
    $notesheetRequest = DB::table('notesheet')
    
    ->join('officedetails', 'officedetails.id', '=', 'notesheet.officeId') 
    ->join('officemaster','officemaster.id','=','notesheet.officeId')
    ->join('officeunder','officeunder.office','=','notesheet.officeId')
    ->join('users','users.empId','=','notesheet.createdBy')
    ->select('notesheet.*','officedetails.longOfficeName','users.empName')

               ->latest('notesheet.id') //similar to orderby('id','desc')

            //    ->where('notesheet.officeId',Auth::user()->office)
            //    ->where('notesheet.status','=','Processing')
            //    ->where('cancelled','=','No')

            //    ->orwhere('officemaster.reportToOffice',Auth::user()->office)
            //    ->where('notesheet.status','=','Processing')
            //    ->where('cancelled','=','No')

               ->where('officeunder.head',Auth::user()->empId) 
               ->where('notesheet.status','=','Processing')
               ->where('cancelled','=','No')
           
               ->paginate(10000000);


  $rhtml = view('Notesheet.Reviewnotesheet')
  ->with([ 'notesheetRequest' => $notesheetRequest,'officedetails' => $officedetails])->render(); 
  return response()
  
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 }  //end


 if ($request->v == "GMReview")  //form.csv
 { 
    
    $notesheetRemarks = notesheetapprove::all(); 
    $officedetails = Officedetails::all(); 
     
    $notesheetRequests = DB::table('notesheet')
    ->join('officedetails', 'officedetails.id', '=', 'notesheet.officeId')     
    ->join('officemaster','officemaster.id','=','notesheet.officeId')
    ->join('officeunder','officeunder.office','=','notesheet.officeId')
    ->join('users','users.empId','=','notesheet.createdBy')
    ->select('notesheet.*','notesheet.id','officedetails.longOfficeName','notesheet.createdBy',
    'topic','justification','notesheet.status','notesheet.officeId','officemaster.reportToOffice','users.empName')
    
    ->latest('notesheet.id') //similar to orderby('id','desc')
   
    //  ->where('notesheet.status','=','Recommended')
    //  
    //  ->where('notesheet.officeId',Auth::user()->office)
    
    //  ->orwhere('officemaster.reportToOffice',Auth::user()->office)
    //  ->where('notesheet.status','=','Recommended')

    ->where('officeunder.head',Auth::user()->empId) 
    ->where('cancelled','=','No')   
    ->where('notesheet.status','=','Recommended')

//    ->orWhere('orgunit.office',Auth::user()->office)
    ->paginate(10000000);
  
  $rhtml = view('Notesheet.GMReviewnotesheet')
  ->with([ 'notesheetRequest' => $notesheetRequests,'notesheetRemarks' => $notesheetRemarks,'officedetails'=>$officedetails])
  ->render(); 
  return response()
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 }  //end



 if ($request->v == "stsdirreview")  //form.csv  for director use this
 {    
    //for all director notesheet review page
    $notesheetRemarks = notesheetapprove::all(); 
    $officedetails = Officedetails::all(); 
     
    $notesheetRequest = DB::table('notesheet')
    ->join('officedetails', 'officedetails.id', '=', 'notesheet.officeId') 
    ->join('officemaster','officemaster.id','=','notesheet.officeId')
    ->join('officeunder','officeunder.office','=','notesheet.officeId')
    ->join('users','users.empId','=','notesheet.createdBy')
    ->select('officeunder.office','notesheet.id','officedetails.longOfficeName','notesheet.createdBy','topic','justification','notesheet.status','notesheet.officeId','officemaster.reportToOffice','users.empName')
    // 'notesheet.approverLevel'

    ->latest('notesheet.id') //similar to orderby('id','desc')

    ->where('notesheet.status','=','GMRecommended') // 
    ->where('cancelled','=','No')

    // ->where('notesheet.officeId',Auth::user()->office)
    // ->orwhere('officemaster.reportToOffice',Auth::user()->office)
    
    ->where('officeunder.head',Auth::user()->empId)  
    
    ->paginate(10000000);

    $rhtml = view('Notesheet.STSDirReviewnotesheet')->with([ 'notesheetRequest' => $notesheetRequest,'notesheetRemarks' => $notesheetRemarks,'officedetails'=>$officedetails])->render(); 
  return response()
  
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 }  //end
 

 if ($request->v == "fasdirreview")  //form.csv
 {    
    $notesheetRemarks = notesheetapprove::all(); 
    $officedetails = Officedetails::all(); 
     
    $notesheetRequest = DB::table('notesheet')
    ->join('officedetails', 'officedetails.id', '=', 'notesheet.officeId') 
   ->join('officemaster','officemaster.id','=','notesheet.officeId')
    ->select('notesheet.id','officedetails.longOfficeName','notesheet.createdBy','topic','justification','notesheet.status','notesheet.officeId','officemaster.reportToOffice')

   ->latest('notesheet.id') //similar to orderby('id','desc')

    ->where('notesheet.status','=','GMRecommended') 
    ->where('cancelled','=','No')
    ->where('notesheet.officeId',Auth::user()->office)

    ->orwhere('officemaster.reportToOffice',Auth::user()->office)
    ->where('notesheet.status','=','GMRecommended')

    ->paginate(10000000);


    $rhtml = view('Notesheet.FASDirReviewnotesheet')->with([ 'notesheetRequest' => $notesheetRequest,'notesheetRemarks' => $notesheetRemarks,'officedetails'=>$officedetails])->render(); 
  return response()
  
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 }  //end


 if ($request->v == "dsdirreview")  //form.csv
 {    

    $notesheetRemarks = notesheetapprove::all(); 
    $officedetails = Officedetails::all(); 
     
    $notesheetRequest = DB::table('notesheet')
    ->join('officedetails', 'officedetails.id', '=', 'notesheet.officeId')

->join('officemaster','officemaster.id','=','notesheet.officeId')
->select('notesheet.id','officedetails.longOfficeName','notesheet.createdBy','topic','justification','notesheet.status','notesheet.officeId','officemaster.reportToOffice')

   ->latest('notesheet.id') //similar to orderby('id','desc')

    ->where('notesheet.status','=','GMRecommended') 
    ->where('cancelled','=','No')
    ->where('notesheet.officeId',Auth::user()->office)

    ->orwhere('officemaster.reportToOffice',Auth::user()->office)
    ->where('notesheet.status','=','GMRecommended')


    ->orwhere('officeId','=',63) // 
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',64) //
    ->where('notesheet.status','=','GMRecommended')
 
    ->orwhere('officeId','=',62) // 
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',65) // 
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',24) 
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',25)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',26)  //esd n essd
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',27)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',28)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',29) 
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',30) 
     ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',31)  
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',32)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',33) 
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',34) 
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',35) 
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',36) 
    ->where('notesheet.status','=','GMRecommended')
 
    ->orwhere('officeId','=',37) 
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',38) 
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',39)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',40)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',41)  
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',42)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',43)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',44)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',45)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',46)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',47)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',48)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',49)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',50)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',51)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',52)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',53)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',54)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',55) 
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',56)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',57)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',58) 
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',59) 
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',60)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',61) 
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',16) 
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',17) 
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',18) 
    ->where('notesheet.status','=','GMRecommended')

    ->paginate(10000000);


    $rhtml = view('Notesheet.DSDirReviewnotesheet')->with([ 'notesheetRequest' => $notesheetRequest,'notesheetRemarks' => $notesheetRemarks,'officedetails'=>$officedetails])->render(); 
  return response()
  
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 }  //end
 if ($request->v == "tsdirreview")  //form.csv
 {    
    $notesheetRemarks = notesheetapprove::all(); 
    $officedetails = Officedetails::all(); 
     
    $notesheetRequest = DB::table('notesheet')
    ->join('officedetails', 'officedetails.id', '=', 'notesheet.officeId')
     ->join('officemaster','officemaster.id','=','notesheet.officeId')
     ->select('notesheet.id','officedetails.longOfficeName','notesheet.createdBy','topic','justification','notesheet.status','notesheet.officeId','officemaster.reportToOffice')

   ->latest('notesheet.id') //similar to orderby('id','desc')

    ->where('notesheet.status','=','GMRecommended')   
    ->where('cancelled','=','No')

    ->where('notesheet.officeId',Auth::user()->office)

    ->orwhere('officemaster.reportToOffice',Auth::user()->office)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',137)  //
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',156)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',157)
    ->where('notesheet.status','=','GMRecommended')

     ->orwhere('officeId','=',158)
     ->where('notesheet.status','=','GMRecommended')

     ->orwhere('officeId','=',159) 
     ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',160)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',161)
    ->where('notesheet.status','=','GMRecommended')
  
    ->orwhere('officeId','=',130)
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',131) 
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',132) 
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',133)
    ->where('notesheet.status','=','GMRecommended')
 
    ->orwhere('officeId','=',138) 
    ->where('notesheet.status','=','GMRecommended')

    ->orwhere('officeId','=',96) 
    ->where('notesheet.status','=','GMRecommended')


    ->paginate(10000000);


    $rhtml = view('Notesheet.TSDirReviewnotesheet')->with([ 'notesheetRequest' => $notesheetRequest,'notesheetRemarks' => $notesheetRemarks,'officedetails'=>$officedetails])->render(); 
  return response()
  
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 }  //end
 

 if ($request->v == "hrdirreview")  //form.csv
 {    
    $notesheetRemarks = notesheetapprove::all(); 
    $officedetails = Officedetails::all(); 
     
    $notesheetRequest = DB::table('notesheet')
    ->join('officedetails', 'officedetails.id', '=', 'notesheet.officeId')

->join('officemaster','officemaster.id','=','notesheet.officeId')
->select('notesheet.id','officedetails.longOfficeName','notesheet.createdBy','topic','justification','notesheet.status','notesheet.officeId','officemaster.reportToOffice')

   ->latest('notesheet.id') //similar to orderby('id','desc')

    ->where('notesheet.status','=','GMRecommended')     
    ->where('cancelled','=','No')
    ->where('notesheet.officeId',Auth::user()->office)
    ->orwhere('officemaster.reportToOffice',Auth::user()->office)

    ->orwhere('officeId','=',78)  //
    ->orwhere('officeId','=',80) // 
    ->orwhere('officeId','=',81) //
    ->orwhere('officeId','=',76) // 
    ->orwhere('officeId','=',74) // 
    ->orwhere('officeId','=',75) // 

    ->paginate(10000000);


    $rhtml = view('Notesheet.HRDirReviewnotesheet')->with([ 'notesheetRequest' => $notesheetRequest,'notesheetRemarks' => $notesheetRemarks,'officedetails'=>$officedetails])->render(); 
  return response()
  
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 }  //end

 // for CEO notesheet approval n recom
 if ($request->v == "CEOreview")  //form.csv
 {    

    $notesheetRemarks = notesheetapprove::all(); 
    $officedetails = Officedetails::all(); 
     
    $notesheetRequest = DB::table('notesheet')
    ->join('officedetails', 'officedetails.id', '=', 'notesheet.officeId') 
    ->join('officemaster','officemaster.id','=','notesheet.officeId')
    ->join('officeunder','officeunder.office','=','notesheet.officeId')
    ->join('users','users.empId','=','notesheet.createdBy')
    ->select('officeunder.office','notesheet.id','officedetails.longOfficeName','notesheet.createdBy','topic','justification','notesheet.status','notesheet.officeId','officemaster.reportToOffice','users.empName')

    ->latest('notesheet.id') //similar to orderby('id','desc')
    ->where('notesheet.status','=','DirectorRecommended') //     
    ->where('cancelled','=','No')      
    ->where('officeunder.head',Auth::user()->empId)  

    ->orwhere('notesheet.status','=','GMRecommended') //     
    ->where('cancelled','=','No')      
    ->where('officeunder.head',Auth::user()->empId)
    ->where('notesheet.createdBy', '=' ,'30003221')  //ERD GM

    ->orwhere('notesheet.createdBy', '=' ,'30002025')   //CS
     ->where('cancelled','=','No')      
     ->where('officeunder.head',Auth::user()->empId)  
        
    ->paginate(10000000);


    $rhtml = view('Notesheet.CEOReviewnotesheet')->with([ 'notesheetRequest' => $notesheetRequest,'notesheetRemarks' => $notesheetRemarks,'officedetails'=>$officedetails])->render(); 
  return response()
  
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 }  //end



 // uniform shirt size report
 if ($request->v == "shirtReport")  //form.csv
 {    
    $officename = officedetails::all()
                ->where('status',0);
    $shirtsize = shirt::all()
                ->where('status',0);

    $shirtsizes = DB::table('employeeuniform')
                  ->join('officedetails', 'officedetails.id', '=', 'employeeuniform.officeId') 
                  ->join('shirtmaster', 'shirtmaster.id', '=', 'employeeuniform.shirt') 
                  ->select('officedetails.longOfficeName','employeeuniform.*','shirtmaster.shirtSizeName')
                  ->where('employeeuniform.status',0);

  $rhtml = view('UniformReport.shirtSizeReport')->with(['officename' => $officename,'shirtsize' => $shirtsize])->render(); 
  return response()
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 }  //end


 //  all office uniform report
 if ($request->v == "officeWiseUniformSizeReport")  //form.csv
 {    
    $officename = officeuniform::all();  
    $officedetailsx = officedetails::all();     

    $officenamez = DB::table('officeuniform')
                //   ->join('officedetails', 'officedetails.id', '=', 'employeeuniform.officeId') 
                ->select('*');                  

  $rhtml = view('UniformReport.officeUniformSizeReport')->with(['officename' => $officename,'officedetailsx'=>$officedetailsx])->render(); 
  return response()
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 }  //end

 //all uniform for all all employee
 //  all office uniform report

 if ($request->v == "allUniformReport")  //form.csv
 {    
    // $officename = officeuniform::all();  
    // $officedetailsx = officedetails::all();     

    $officenamez = DB::table('uniformreport')
                //   ->join('officedetails', 'officedetails.id', '=', 'employeeuniform.officeId') 
                ->select('*')
                ->where('uniformreport.size','!=','0')
                ->where('uniformreport.size','!=','Not Applicable')                
                ->get();                 

  $rhtml = view('UniformReport.allUniformReport')->with(['officenamez' => $officenamez])->render(); 
//   $rhtml = view('UniformReport.allUniformReport')->with(['officename' => $officename,'officedetailsx'=>$officedetailsx,'officenamez' => $officenamez])->render(); 

  return response()
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 }  
 
 //end of all uniform employee









 // for increment all
 
 if ($request->v == "incrementall")  //form.csv
 {   

    $usersemp = User::all(); 

    $skills = DB::table('incrementall')    
    ->join('users', 'users.empId', '=', 'incrementall.empId')
    ->select('incrementall.id','users.empId','incrementall.lastIncrementDate','incrementall.incrementDueDate','incrementall.incrementCycle')
    ->get(); 

  $rhtml = view('Increment.increment')->with(['usersemp' => $usersemp])->render(); 
  return response()
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 }  //end

 if ($request->v == "incrementform")  //form.csv
 {  
    $usersemp = User::all(); 
    $subCat = DB::table('incrementalduelist')      
   
    ->select('*');    
   
  $rhtml = view('Increment.incrementList')->with(['usersemp' => $usersemp])->render();
  return response()
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 } 

 
 if ($request->v == "hrcsPromotionReview")  //form.csv
 {  
    $promotiondue =Promotionduelist::all();
    $officedetails = Officedetails::all();

    $promotiondue = DB::table('promotionduelist')

    ->join('officedetails', 'officedetails.id', '=', 'promotionduelist.office')
    ->join('officemaster','officemaster.id','=','promotionduelist.office')

    ->select('promotionduelist.*','officedetails.longOfficeName','officemaster.reportToOffice')
    ->latest('promotionduelist.id') //similar to orderby('id','desc')

   ->where('promotionduelist.status','=','Proposed')
   ->where('promotionduelist.office',Auth::user()->office)  //mam icd
//    ->orwhere('officemaster.reportToOffice',Auth::user()->office  && 'promotionduelist.status','=','Recommended') //gm 
   ->orwhere('officemaster.reportToOffice',Auth::user()->office)
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',78) 
    ->where('promotionduelist.status','=','Proposed') 

    ->orwhere('office','=',80) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',81) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',76) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',74) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',75)
    ->where('promotionduelist.status','=','Proposed')

    
    ->paginate(10000000);

  $rhtml = view('promotion.HRCSDirReview')->with(['promotiondue' => $promotiondue,'officedetails' => $officedetails])->render();
  return response()
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 }//end

 if ($request->v == "dsPromotionReview")  //form.csv
 {  
    $promotiondue =Promotionduelist::all();
    $officedetails = Officedetails::all();

    $promotiondue = DB::table('promotionduelist')

    ->join('officedetails', 'officedetails.id', '=', 'promotionduelist.office')
    ->join('officemaster','officemaster.id','=','promotionduelist.office')

    ->select('promotionduelist.*','officedetails.longOfficeName','officemaster.reportToOffice')
    ->latest('promotionduelist.id') //similar to orderby('id','desc')

   ->where('promotionduelist.status','=','Proposed')
   ->where('promotionduelist.office',Auth::user()->office)  //mam icd
//    ->orwhere('officemaster.reportToOffice',Auth::user()->office  && 'promotionduelist.status','=','Recommended') //gm 
   ->orwhere('officemaster.reportToOffice',Auth::user()->office)
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',16)  
    ->where('promotionduelist.status','=','Proposed') 

    ->orwhere('office','=',17) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',18) 
 ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',63) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',64) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',62) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',65) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',24) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',27) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',31) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',34)
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',37) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',40) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',43) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',46) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',49) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',52) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',55) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',58) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',61)
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',25) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',26) 
    ->where('promotionduelist.status','=','Proposed')
    ->orwhere('office','=',28) 

    ->where('promotionduelist.status','=','Proposed')
    ->orwhere('office','=',29) 

    ->where('promotionduelist.status','=','Proposed')
    ->orwhere('office','=',32) 

    ->where('promotionduelist.status','=','Proposed')
    ->orwhere('office','=',33) 

    ->where('promotionduelist.status','=','Proposed')
    ->orwhere('office','=',35)

    ->where('promotionduelist.status','=','Proposed')
    ->orwhere('office','=',36) 

    ->where('promotionduelist.status','=','Proposed')
    ->orwhere('office','=',39) 

    ->where('promotionduelist.status','=','Proposed')
    ->orwhere('office','=',41) 

    ->where('promotionduelist.status','=','Proposed')
    ->orwhere('office','=',42)

    ->where('promotionduelist.status','=','Proposed')
    ->orwhere('office','=',44) 

    ->where('promotionduelist.status','=','Proposed')
    ->orwhere('office','=',45)

    ->where('promotionduelist.status','=','Proposed')
    ->orwhere('office','=',48)

    ->where('promotionduelist.status','=','Proposed')
    ->orwhere('office','=',47)

    ->where('promotionduelist.status','=','Proposed')
    ->orwhere('office','=',50) 

    ->where('promotionduelist.status','=','Proposed')
    ->orwhere('office','=',51) 

    ->where('promotionduelist.status','=','Proposed')
    ->orwhere('office','=',54) 

    ->where('promotionduelist.status','=','Proposed')
    ->orwhere('office','=',56) 

    ->where('promotionduelist.status','=','Proposed')
    ->orwhere('office','=',57)

    ->where('promotionduelist.status','=','Proposed')
    ->orwhere('office','=',59)

    ->where('promotionduelist.status','=','Proposed')
    ->orwhere('office','=',60) 

    ->where('promotionduelist.status','=','Proposed')
    
    
    ->paginate(10000000);

  $rhtml = view('promotion.DSDirReview')->with(['promotiondue' => $promotiondue,'officedetails' => $officedetails])->render();
  return response()
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 }//end



 if ($request->v == "tsPromotionReview")  //form.csv
 {  
    $promotiondue =Promotionduelist::all();
    $officedetails = Officedetails::all();

    $promotiondue = DB::table('promotionduelist')

    ->join('officedetails', 'officedetails.id', '=', 'promotionduelist.office')
    ->join('officemaster','officemaster.id','=','promotionduelist.office')

    ->select('promotionduelist.*','officedetails.longOfficeName','officemaster.reportToOffice')
    ->latest('promotionduelist.id') //similar to orderby('id','desc')

   ->where('promotionduelist.status','=','Proposed')
   ->where('promotionduelist.office',Auth::user()->office)  //mam icd
//    ->orwhere('officemaster.reportToOffice',Auth::user()->office  && 'promotionduelist.status','=','Recommended') //gm 
   ->orwhere('officemaster.reportToOffice',Auth::user()->office)
    ->where('promotionduelist.status','=','Proposed')
    ->orwhere('office','=',96)
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',137) 
    ->where('promotionduelist.status','=','Proposed') 

    ->orwhere('office','=',156)
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',157) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',158) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',159) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',160)
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',161)  
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',130) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',131) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',132) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',133) 
    ->where('promotionduelist.status','=','Proposed')

    ->orwhere('office','=',138) 
    ->where('promotionduelist.status','=','Proposed')
    ->paginate(10000000);

  $rhtml = view('promotion.TSDirReview')->with(['promotiondue' => $promotiondue,'officedetails' => $officedetails])->render();
  return response()
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 }//end

//Transfer Request
if ($request->v == "transferRequest")  //form.csv
{    
      
   $officedeta = Officedetails::all();
   $officedetas = Officedetails::all();
   $userdeta =empSupervisor::all()->where('employee',Auth::user()->empId);   
 
   $b= DB::table('transferrequest') 
   ->join('officedetails', 'officedetails.id', '=', 'transferrequest.fromOffice')
   ->join('officedetails AS B', 'B.id', '=', 'transferrequest.toOffice') 
   ->join('employeesupervisor', 'employeesupervisor.supervisor', '=', 'transferrequest.requestToEmp') 
   ->select('employeesupervisor.supervisor','transferrequest.requestDate', 'transferrequest.reason','officedetails.*','officedetails.officeDetails as f','B.officeDetails as tff')
   ->get();

 $rhtml = view('Transfer.transferRequest')->with(['userdeta' => $userdeta,'b' => $b,'officedeta' => $officedeta,'officedetas' => $officedetas])->render(); 
 return response()
    ->json(array(
     'success' => true,
     'html' => $rhtml
      ));
}  //end



//Transfer By Admin
if ($request->v == "normalTransfer")  //form.csv
{    
    $officedd =  DB::table('users')
    ->whereIn('users.office', function($query){
        $query->from('officeunder')
        ->select('officeunder.office')
        ->where('officeunder.head', '=', Auth::user()->empId);
    })
    ->orWhere('users.office',Auth::user()->office)
    ->get();  // emp id for his underoffice for manager or offoce head    


    $officett =  DB::table('officeunder')
        ->join('officedetails','officedetails.id','=','officeunder.office')   
        ->select('officedetails.officeDetails','officeunder.office')
        ->where('officeunder.head', '=', Auth::user()->empId)
        ->orWhere('officedetails.id',Auth::user()->office)->distinct()
            
    ->get();  //only his under office
     

   $userdeta =empSupervisor::all()->where('employee',Auth::user()->empId); //supervisor name 

   $officedds = Officedetails::all();  //office name 

   $b= DB::table('transferrequest')     
   ->join('officedetails', 'officedetails.id', '=', 'transferrequest.fromOffice')
   ->join('officedetails AS B', 'B.id', '=', 'transferrequest.toOffice') 
   ->join('employeesupervisor', 'employeesupervisor.supervisor', '=', 'transferrequest.requestToEmp')    
   ->select('employeesupervisor.supervisor','transferrequest.requestDate', 'transferrequest.reason','officedetails.*','officedetails.officeDetails as f','B.officeDetails as tff')   
   ->get();

 $rhtml = view('Transfer.transferByAdmin')->with(['officedds'=>$officedds,'userdeta' => $userdeta,'officedd' => $officedd,'officett' => $officett])->render(); 
 return response()
    ->json(array(
     'success' => true,
     'html' => $rhtml
      ));
}  //end


//Transfer Request manager review
if ($request->v == "transferRequestReview")   //manager
{   
        
$transferRequest=transferRequest::all();
$users=User::all();

$transferRequest= DB::table('transferrequest') 
->join('officedetails', 'officedetails.id', '=', 'transferrequest.fromOffice')
->join('officedetails AS B', 'B.id', '=', 'transferrequest.toOffice')  
->join('officemaster','officemaster.id','=','transferrequest.fromOffice') 
->join('users','users.empId','=','transferrequest.createdBy') 


->select('transferrequest.*','officedetails.officeDetails as fromOff','B.officeDetails as toOff','users.empName')

 ->latest ('transferrequest.id')

  ->where('transferrequest.fromOffice','=',Auth::user()->office) 
  ->where('transferrequest.status','=','requested')

  ->orwhere('transferrequest.fromOffice','=',Auth::user()->office) 
  ->where('transferrequest.status','=','normal')


  ->orwhere('officemaster.reportToOffice','=',Auth::user()->office) 
  ->where('transferrequest.status','=','requested')

  ->orwhere('officemaster.reportToOffice','=',Auth::user()->office) 
  ->where('transferrequest.status','=','normal')
  
  ->get();  
   
 $rhtml = view('Transfer.transferRequestReview')->with(['transferRequest' => $transferRequest])->render(); 
 return response()
    ->json(array(
     'success' => true,
     'html' => $rhtml
      ));
}  //end


if ($request->v == "gmTransferReview")  //form.csv
{       
    // $transferRequest=transferProposal::all();
    $fromoffice = Officedetails::all();
    $tooffice = Officedetails::all();
    $users=User::all();

 
    $transferRequest = DB::table('transferproposal')
    ->join('officedetails', 'officedetails.id', '=', 'transferproposal.fromOffice')
    ->join('officemaster','officemaster.id','=','transferproposal.fromOffice')
    ->join('officedetails AS B', 'B.id', '=', 'transferproposal.toOffice') 
    ->join('officeunder','officeunder.office','=','transferproposal.fromOffice') 
    ->join('users','users.empId','=','transferproposal.empId') 

    
    ->select('transferproposal.*','officedetails.officeDetails as f','B.officeDetails as tff','users.empName')

    ->where('transferproposal.fromOffice','=',Auth::user()->office) 
    ->where('transferproposal.status','=','proposed')

    ->orwhere('officemaster.reportToOffice',Auth::user()->office)
    ->where('transferproposal.status','=','proposed')

    ->orwhere('officeunder.head',Auth::user()->empId)
    ->where('transferproposal.status','=','proposed')


    ->paginate(10000000);
    
   $rhtml = view('Transfer.transferReviewGM')->with(['transferRequest' => $transferRequest,'fromoffice' => $fromoffice,'tooffice' => $tooffice])->render(); 
    return response()
    ->json(array(
     'success' => true,
     'html' => $rhtml
      ));
}  //end


if ($request->v == "dirReview")  //form.csv
{       
    // $transferRequest=transferProposal::all();
    $fromoffice = Officedetails::all();
    $tooffice = Officedetails::all();
    $users=User::all();

 
    $transferRequest = DB::table('transferproposal')
    ->join('officedetails', 'officedetails.id', '=', 'transferproposal.fromOffice')
   ->join('officedetails AS B', 'B.id', '=', 'transferproposal.toOffice')   
   ->join('officemaster','officemaster.id','=','transferproposal.fromOffice')
   ->join('officeunder','officeunder.office','=','transferproposal.fromOffice')
   ->join('users','users.empId','=','transferproposal.empId') 


   ->select('transferproposal.*','officedetails.officeDetails as f','B.officeDetails as tff','users.empName')

   ->where('officeunder.head',Auth::user()->empId)  
    ->where('transferproposal.status','=','recommended')

    ->paginate(10000000);
    
   $rhtml = view('Transfer.transferReviewDir')->with(['transferRequest' => $transferRequest,'fromoffice' => $fromoffice,'tooffice' => $tooffice,])->render(); 
    return response()
    ->json(array(
     'success' => true,
     'html' => $rhtml
      ));
}  //end


if ($request->v == "hrTransferReview")  //form.csv
{       

    $fromoffice = Officedetails::all();
    $tooffice = Officedetails::all();
    $users=User::all();
 
    $employeeTransfer = DB::table('transferproposal')
    ->join('officedetails', 'officedetails.id', '=', 'transferproposal.fromOffice')
   ->join('officedetails AS B', 'B.id', '=', 'transferproposal.toOffice')  
   ->join('users','users.empId','=','transferproposal.empId')
//    ->join('transferhistory', 'transferhistory.proposalId', '=', 'transferproposal.requestId')  
    ->select('transferproposal.*','officedetails.officeDetails as f','B.officeDetails as tff','users.empName')

    ->where('transferproposal.toGMAction','=','recommended')
    ->where('transferproposal.toDirectorAction','=','recommended')
    ->where('transferproposal.status','=','proposed')

    ->orwhere('transferproposal.status','=','recommended')
    ->where('transferproposal.toGMAction','=','recommended')
    ->where('transferproposal.toDirectorAction','=','recommended')

    ->orwhere('transferproposal.status','=','dirrecommended')
    ->where('transferproposal.toGMAction','=','recommended')
    ->where('transferproposal.toDirectorAction','=','recommended')  



 ->paginate(10000000);
    
   $rhtml = view('Transfer.transferReviewHR')->with(['employeeTransfer' => $employeeTransfer,'fromoffice' => $fromoffice,'tooffice' => $tooffice,])->render(); 
    return response()
    ->json(array(
     'success' => true,
     'html' => $rhtml
      ));
}  //end

if ($request->v == "relieveEmployee")  //form.csv
{       

    $fromoffice = Officedetails::all();
    $tooffice = Officedetails::all();
    $users = User::all();
 
    $employeeTransfer = DB::table('transferhistory')
    ->join('officedetails', 'officedetails.id', '=', 'transferhistory.transferFrom')
   ->join('officedetails AS B', 'B.id', '=', 'transferhistory.transferTo')  
//    ->join('officemaster','officemaster.id','=','transferrequest.transferFrom') 
   ->join('officeunder','officeunder.office','=','transferhistory.transferFrom')
   ->join('users','users.empId','=','transferhistory.empId') 


//    ->join('transferhistory', 'transferhistory.proposalId', '=', 'transferproposal.requestId')  
    ->select('transferhistory.*','officedetails.officeDetails as f','B.officeDetails as tff','users.empName')

    ->where('transferhistory.transferFrom','=',Auth::user()->office) 
    ->where('transferhistory.status','=','Open')
    ->where('transferhistory.relievedBy',)

    ->orwhere('officeunder.head',Auth::user()->empId)  
    ->where('transferhistory.status','=','Open')
    ->where('transferhistory.relievedBy',)


     ->paginate(10000000);
    
   $rhtml = view('Transfer.relieveEmployee')->with(['employeeTransfer' => $employeeTransfer,'fromoffice' => $fromoffice,'tooffice' => $tooffice,])->render(); 
    return response()
    ->json(array(
     'success' => true,
     'html' => $rhtml
      ));
}  //end

//Transfer History report
if ($request->v == "transferhistoryReport")  //form.csv

{   $tranfhisrepo = Officedetails::all();   
    $transprop = transferProposal::all();
    $z = EmployeeTwice::all(); 

    $name = DB::table('transferhistory')
       
    ->join('officedetails', 'officedetails.id', '=', 'transferhistory.transferFrom')
    ->join('officedetails AS B', 'B.id', '=', 'transferhistory.transferTo')
    ->join('officedetails AS D', 'D.id', '=', 'transferhistory.reportToOffice')
    ->join('officedetails AS E', 'E.id', '=', 'transferhistory.reportToOfficeF')
    ->join('transferproposal', 'transferproposal.id', '=', 'transferhistory.id')       
    // ->join('employee4twimc', 'employee4twimc.empId', '=', 'transferhistory.empId') 

    ->select('E.officeDetails as oficereoprtf','transferhistory.empId','transferhistory.transferDate',
    'transferproposal.hRRemarks','B.officeDetails as tooffname',
    'D.officeDetails as oficereoprt',
    'transferhistory.transferType',
    'transferhistory.transferBenefit','officedetails.officeDetails',
    'transferproposal.reasonForTransfer')
    
    // ->select('transferhistory.empId','transferhistory.transferDate',
    // 'transferproposal.hRRemarks','B.officeDetails as tooffname',
    // 'D.officeDetails as oficereoprt',
    // 'transferhistory.transferType',
    // 'transferhistory.transferBenefit','officedetails.officeDetails',
    // 'transferproposal.reasonForTransfer',
    //  'employee4twimc.empName','employee4twimc.grade','employee4twimc.designation')

    ->where('transferhistory.status','=', 'Closed')

     ->get();

    $rhtml = view('Transfer.transferHistoryReport')->with(['tranfhisrepo'=>$tranfhisrepo, 'transprop'=>$transprop, 'z'=>$z  ])->render();
    return response()
    ->json(array(
     'success' => true,
     'html' => $rhtml
      ));
}  
//end

if ($request->v == "wfRelatives")  {   //form.csv

    $welfareReview = WfRelatives::all();

    $pno = User::all();
    $relation = Relationname::all();    

    $wfRelatives = DB::table('wfrelatives')
    ->join('users', 'users.empId', '=', 'wfrelatives.empId')
    ->join('relationmaster', 'relationmaster.id', '=', 'wfrelatives.relation')
     ->select('wfrelatives.id','wfrelatives.cIdNo','wfrelatives.cIDOther','wfrelatives.name','wfrelatives.doB','users.empId','relationshipName')
     ->where('wfrelatives.status','0');    
 
    $rhtml = view('welfare.family_details')->with(['welfareReview' => $welfareReview,'pno' => $pno, $welfareReview,'relation' => $relation])->render(); 
     return response()
     ->json(array(
      'success' => true,
      'html' => $rhtml
       ));
 }  //end



if ($request->v == "welfareReview")  {//form.csv

    if(Auth::user()->empId == 30003084) { //member1
    
    //$welfareReview = WfReleaseProcess::all();

    $welfareReview = DB::table('wfreleaseprocess')
    ->join('view_wfrelatives', 'view_wfrelatives.id', '=', 'wfreleaseprocess.deathOf')
    ->select('view_wfrelatives.relation','wfreleaseprocess.*')
    ->where('wfreleaseprocess.status','=','applied')
    ->get();
    
    $rhtml = view('welfare.welfareReview')->with(['welfareReview' => $welfareReview])->render(); 
    return response()
    ->json(array(
     'success' => true,
     'html' => $rhtml
      ));
    }  //end  

    
    if(Auth::user()->empId == 30002953) { //member2
    
        // $welfareReview = WfReleaseProcess::all()->where
        // ('status','=','under process');

        $welfareReview = DB::table('wfreleaseprocess')
        ->join('view_wfrelatives', 'view_wfrelatives.id', '=', 'wfreleaseprocess.deathOf')
        ->select('view_wfrelatives.relation','wfreleaseprocess.*')
        ->where('wfreleaseprocess.status','=','under process')
        ->get();
         
        $rhtml = view('welfare.welfareReview')->with(['welfareReview' => $welfareReview])->render(); 
         return response()
         ->json(array(
          'success' => true,
          'html' => $rhtml
           ));
         }  //end
    
         if(Auth::user()->empId == 30002940) {//ceo 
    
            
            $welfareReview = DB::table('wfreleaseprocess')
            ->join('view_wfrelatives', 'view_wfrelatives.id', '=', 'wfreleaseprocess.deathOf')
            ->select('view_wfrelatives.relation','wfreleaseprocess.*')
            ->where('wfreleaseprocess.status','=','pending')
            ->get();
            
            
            $rhtml = view('welfare.welfareReview')->with(['welfareReview' => $welfareReview])->render(); 
             return response()
             ->json(array(
              'success' => true,
              'html' => $rhtml
               ));
             }  //end

            }//END HERE

    
//employee joining 
if ($request->v == "employeeJoining")
       
{         
   $transferFrom = Officedetails::all();
   $transferTo = Officedetails::all();
   $empJoining = transferHistory::all(); 
   $users = User::all();                

  $empJoining = DB::table('transferhistory')
              ->join('officedetails', 'officedetails.id', '=', 'transferhistory.transferFrom')
              ->join('officedetails AS B', 'B.id', '=', 'transferhistory.transferTo')  
              ->join('officeunder','officeunder.office','=','transferhistory.transferTo')
              ->join('users','users.empId','=','transferhistory.empId') 

              ->select('transferhistory.*','officedetails.officeDetails as transferFrom','B.officeDetails as transferTo','users.empName')
              
              ->where('transferTo',Auth::user()->office)
              ->where('transferhistory.status','=','Open')
              ->where('transferhistory.relievedBy','!=','NULL')


              ->orwhere('officeunder.head',Auth::user()->empId)  
              ->where('transferhistory.status','=','Open')
              ->where('transferhistory.relievedBy','!=','NULL')
              ->paginate(10000000);

      $rhtml = view('Transfer.employeeJoining')->with(['empJoining'=>$empJoining,'transferFrom'=>$transferFrom,'transferTo'=>$transferTo])->render();
      return response()
          ->json(array(
          'success' => true,
          'html' => $rhtml
      ));
  }
  //end here

  //v4allocation
  if ($request->v == "v4allocation")
  {                           

      $rhtml = view('ip.v4allocation')->render();
       return response()
           ->json(array(
           'success' => true,
           'html' => $rhtml
       ));

   }
   if ($request->v == "ipv6")
{
   

    $rhtml = view('ip.v6allocation')->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));

   
}
//end

// welfareNew Request (TDee: date:12/03/2024)
if ($request->v == "welfare_request")  //form.csv
{    

 $rhtml = view('welfareNew.welfarerequest')->render(); 
 return response()
    ->json(array(
     'success' => true,
     'html' => $rhtml
      ));
}  //end


if ($request->v == "welfareReviewForm") {
    // Check if the user is authenticated
    if (Auth::check()) {

        $memberName1= DB::table('welfarecommitte')
        ->join('users as reviewName1','reviewName1.empId','welfarecommitte.memberEID')       
        ->where( 'memberType','=','Member 1')
        ->select('reviewName1.empName as reviewerName1')
        ->first();
        
        $memberName2= DB::table('welfarecommitte')       
        ->join('users as reviewName2','reviewName2.empId','welfarecommitte.memberEID')       
        ->where( 'memberType','=','Member 2')
        ->select('reviewName2.empName as reviewerName2')
        ->first();
        
        $userId = Auth::user()->empId;
        // Fetch the authenticated user's memberType from the welfarecommitte table
        $userMemberType = DB::table('welfarecommitte')
            ->where('memberEID', '=', $userId)
            ->value('memberType');

        // Query to fetch welfare notes based on user's memberType and status
        $welfareNoteQuery = DB::table('welfarenote')
            ->join('users', 'users.empId', '=', 'welfarenote.createdBy')
            ->join('users as empUser', 'empUser.empId', '=', 'welfarenote.empID') 
            ->select('welfarenote.*', 'users.empName','empUser.empName as employeeName')
            ->latest('welfarenote.id')
            ->where('cancelled', '=', 'No');

        if ($userMemberType == 'Member 1') {
            // If the user is of 'Member 1' type, display forms with status 'Applied'
            $welfareNoteQuery->where('welfarenote.status', '=', 'Applied');
        } elseif ($userMemberType == 'Member 2') {
            // If the user is of 'Member 2' type, display forms with status 'Recommend'
            $welfareNoteQuery->where('welfarenote.status', '=', 'Member1Recommended');
        }
        elseif ($userMemberType == 'Chairperson') {
        // If the user is Chairperson, display forms with status 'Recommend'
        $welfareNoteQuery->where('welfarenote.status', '=', 'Member2Recommended');
        
        }
        // Paginate the results
        $welfareNote = $welfareNoteQuery->paginate(10);

        // Fetch all welfare for other purposes
        $welfare = welfarenoteapproval::all();

                $memberIdentity = DB::table('welfarecommitte')
                ->select('welfarecommitte.*')
                ->Where('welfarecommitte.memberEID','=',Auth::User()->empId)   
                ->first();
   

        // Render the view
        $rhtml = view('welfareNew.welfareReviewForm')->with(['welfareNote' => $welfareNote, 'welfare' => $welfare,'memberIdentity'=>$memberIdentity,'memberName1'=>$memberName1,'memberName2'=>$memberName2])->render();

        // Return JSON response
        return response()->json([
            'success' => true,
            'html' => $rhtml
        ]);
    } else {
        // User is not authenticated
        return response()->json([
            'success' => false,
            'message' => 'User is not authenticated'
        ]);
    }
}

 if ($request->v == "manageCommitte")
{


 $roleType = DB::table('welfarecommitte')
    ->join('users', 'welfarecommitte.memberEID', '=', 'users.empId')
    ->select('users.empName','welfarecommitte.*')
    ->latest('welfarecommitte.id'); //similar to orderby('id','desc')
    // ->where('users.status',0)
    //  ->paginate(10000000);


$rhtml = view('welfareNew.manageWelfareCommitte')->with(['roleType' => $roleType])->render();

    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));

} 

//notesheetreport
if ($request->v == "welfareReport")
{
    //  $notesheet = notesheetRequest::all();
    $welfarereport = DB::table('welfarenoteapproval')
    ->join('welfarenote','welfarenote.id','=','welfarenoteapproval.welfareId')
    ->join('users','users.empId','=','welfarenote.empID')
    ->select('welfarenoteapproval.*','welfarenote.id','welfarenote.topic','welfarenote.empID','welfarenote.relationToEmp','users.empName')  
        ->where('welfarenoteapproval.modifierType','=','Approved')
        ->latest('welfarenoteapproval.id')
        ->get();

    $rhtml = view('welfareNew.welfareReport')->with(['welfarereport' => $welfarereport])->render();
    return response()
        ->json(array(
        'success' => true,
        'html' => $rhtml
    ));
}

//laptop details

if ($request->v == "laptopdetails")  //form.csv
{    

 $rhtml = view('LaptopDetails.laptopReleaseDetails')->render(); 
 return response()
    ->json(array(
     'success' => true,
     'html' => $rhtml
      ));
}  //end


//laptop release Report
if ($request->v == "laptopreport")  //form.csv
{    

 $rhtml = view('LaptopDetails.laptopReleaseReport')->render(); 
 return response()
    ->json(array(
     'success' => true,
     'html' => $rhtml
      ));
}  //end

//attendance
if ($request->v == "attendanceReview")
        {   
            
            $officeHead = DB::connection('mysql')->table('officeunder')
                ->where('head', Auth::user()->empId)
                ->pluck('office'); // This should return an array of office IDs

            // If no offices are found, return this
            if ($officeHead->isEmpty()) {
                return response()->json([
                    'message' => 'No offices found for the current user.',
                    'data' => []
                ]);
            }
            $offices = DB::connection('mysql')->table('officedetails')
            ->whereIn('id', $officeHead)
            ->select('id', 'longOfficeName')
            ->get();


            // Start the query to fetch attendance data from mysql2
            $attendance = DB::connection('mysql2')
                ->table('attendance_january as a')
                ->whereIn('a.office_id', $officeHead)
                ->select('a.*', 'a.office_id')              
                ->get();

            // this part to get the reporttooffice id of the officeid fetch in db
            $officeIdsFromAttendance = $attendance->pluck('office_id')->unique();

            $reportToOffices = DB::connection('mysql')
                ->table('officemaster')
                ->whereIn('id', $officeIdsFromAttendance)
                ->pluck('reportToOffice', 'id');

           
            $rhtml = view('Attendance.attendanceReview')
            ->with([
                //  'reportToOffices' => $reportToOffices, 
                'offices'=>$offices])
            ->render();
            return response()
                ->json(array(
                'success' => true,
                'html' => $rhtml
            ));
        }
//end 
    }
} 
