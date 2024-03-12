<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dzongkhags;
use Auth;
use DB;

class HomeController extends Controller
{
    //
    private $roles;
    private $roles_id = array();
    private $form;
    private $formgroup;

    public function __construct()
    {
        $this->middleware('auth');

    }
   
    //go to form.
    public function home()
    {
        $this->getForms();
        $forms = $this->form;
        $formgroups = $this->formgroup;
        $title = "Home";
        $page = "";       

        return view('home', ['title' => $title, 'page' => $page], compact('forms', 'formgroups'));
    }

    

    public function getForms()
    {
        $this->roles = Auth::user()->role;

        foreach ($this->roles as $role)
        {
            $this->role_id[] = $role->id;
        }

        $this->form = DB::table('roleformmapping')
            ->leftjoin('forms', 'roleformmapping.form_id', '=', 'forms.id')
            ->wherein('roleformmapping.role_id', $this->role_id)
            ->where('forms.menu', 'yes')
            ->select('forms.forms', 'forms.description', 'forms.group', 'forms.icon')
            ->get();

        $this->formgroup = DB::table('roleformmapping')
            ->leftjoin('forms', 'roleformmapping.form_id', '=', 'forms.id')
            ->wherein('roleformmapping.role_id', $this->role_id)
            ->where('forms.menu', 'yes')
            ->select('forms.group')
            ->groupBy('forms.group')
            ->get();
    }
}

