<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Illuminate\Support\Facades\Auth;

class AuthorizeForms
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //get request uri.
       $uri = str_replace('/','',\Request::getRequestUri());
       $authorized = false;
       $role_id = array();
       //get list of roles assigned to the user.
       $roles = Auth::user()->role;

       foreach($roles as $role)
        {
            $role_id[] = $role->id;
        }

      
        $forms = DB::table('roleFormMapping')->wherein('role_id',$role_id)
                                                    ->select('form_id')
                                                    ->get();

       
        foreach($forms as $form)
        {
            if($uri == $form->forms)
            {
                $authorized = true;
                break;
            }
        }


       if($authorized)
       {
        return $next($request);
       }
       else
       {
        abort(403,'unauthorized');
       }
    }
}
