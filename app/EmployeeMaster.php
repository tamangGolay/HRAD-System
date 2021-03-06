<?php

namespace App; 

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Agencies;
use App\RoleFormMapping;
use App\RoleUserMappings;
use DB;
 
class EmployeeMaster extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';
   

//    public function agency()
  //  {
    //    return $this->belongsTo(Agencies::class);
   // }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


protected $fillable = [ 
    'id','empName','empId','bloodGroup','cidNo','cidOther','dob','gender','appointmentDate','gradeId','designationId',
    'office','basicPay','empStatus','lastDop','fixedNo','extension',
    'mobileNo','emailId','placeId','resignationTypeId','resignationDate','employmentType','incrementType','password',

    'status','first_time_login','role_id'];

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     * 
     * 
     */

    public $timestamps = false;
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsToMany(Roles::class,'userrolemapping','user_id','role_id');
    }
    
}
