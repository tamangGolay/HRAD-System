<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RoleFormMapping;
use Auth;

class FormRoleMappingCtrl extends Controller
{
    //
    public function store(Request $request)
    {

        $formId = $request->fcheck; //formIds in array.
        $roleId = $request->role;

        //delete existings forms assigned to the role.
        RoleFormMapping::where('role_id', $roleId)->where('form_id', '!=', 110) //role_form.
        
            ->delete();

        //update or insert form(s) for the particular role.
        foreach ($formId as $fId)
        {
            $uid = Auth::id();
            $rf = RoleFormMapping::Create(['role_id' => $roleId, 'form_id' => $fId, 'created_by' => $uid]);

            // for update or create ... use updateOrCreate
            
        }

        return redirect('home')->with('page', 'role_form');

    }
}

