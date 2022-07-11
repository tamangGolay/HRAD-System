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
    protected $table = 'employeemaster';
   

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
'id','empName','empId','BloodGroup','cidNo','dob','gender','appointmentDate','updated_at','created_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
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
