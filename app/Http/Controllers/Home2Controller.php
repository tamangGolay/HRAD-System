<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dzongkhags;
use Auth;
use DB;
use App\Roles;
use App\Officedetails;
use App\Designation;
use App\pay;

class Home2Controller extends Controller
{   
    //go to form.
    public function userlistNEW()
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
    }
        
 