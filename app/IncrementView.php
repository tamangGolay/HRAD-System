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
 
class IncrementView extends Authenticatable
{
    use Notifiable;
    protected $table = 'viewincrementorder';
   

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
    'id','officeAddress','oldBasic','officeId','incrementDate','newBasic','increment','grade','designation','empName','empId'];

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
