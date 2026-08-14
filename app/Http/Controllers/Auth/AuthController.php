<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;
use App\Roles;
use App\roleusermappings;
use App\Dzongkhags;
use App\user_details;
use DB;
use App\orgunit;
use App\Grade;
use Carbon\Carbon;

class AuthController extends Controller
{
    private $roles;
    private $roles_id = array();
    private $form;

    public function register()
    {
        $roles = Roles::all();
        $orgunit = orgunit::all();
        $grade = Grade::all();
        $dzongkhag = Dzongkhags::all();

        return view('auth.register', compact('roles', 'orgunit', 'grade', 'dzongkhag'));
    }

    public function storeUser(Request $request)
    {
        $user = new User;
        $user->empId = $request->emp_id;
        $user->name =  $request->name;
        $user->email = $request->email;
        $user->password =  Hash::make($request->password);
        $user->org_unit_id = $request->orgunit;
        $user->role_id = $request->role;
        $user->gender = $request->gender;
        $user->grade = $request->grade;
        $user->contact_number = $request->contact_number;
        $user->designation = $request->designation;
        $user->dzongkhag = $request->dzongkhag;
        $user->conference_user = $request->conferenceuser;
        $user->created_by = Auth::id();

        $roleuser = new roleusermappings;
        $roleuser->role_id = $request->role;
        $roleuser->created_by = Auth::id();

        DB::transaction(function () use ($user, $roleuser) {
            $user->save();

            $roleuser->user_id = $user->id;
            $roleuser->save();
        });

        return redirect('home')->with('page', 'user')
            ->with('adduser', 'User Added Successfully!!!');
    }

    public function addRole(Request $request)
    {
        $role = new Roles;
        $role->name = $request->role;
        $role->save();

        return redirect('home')->with('page', 'roleAdd')
            ->with('roleadd', 'Role Successfully Added!!!!!');
    }

    public function registerUser(Request $request)
    {
        $id = DB::table('users')->select('id')
            ->where('empId', $request->emp_id)
            ->first();

        DB::update('update users set email = ? where id = ?', [$request->email, $id->id]);

        return redirect('login')->with('success', 'User Registered Successfully!!!');
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->intended('/home');
        } else {
            return view('auth.login');
        }
    }

    public function firstpage()
    {
        if (Auth::check()) {
            return redirect()->intended('/home');
        } else {
            return view('auth.firstpage');
        }
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('empId', 'password');

        $user = DB::table('users')
            ->where('empId', $request->empId)
            ->first();

        if (!$user) {
            return redirect('login')->with('error', 'Invalid credentials');
        }

        if ($user->locked_until) {
            $lockedUntil = Carbon::parse($user->locked_until);

            if (Carbon::now()->lessThan($lockedUntil)) {
                return redirect('login')->with(
                    'error',
                    'Too many failed login attempts. Your account is locked for 15 minutes. Please try again later.'
                );
            }

            DB::table('users')->where('id', $user->id)->update([
                'failed_attempts' => 0,
                'locked_until' => null
            ]);

            $user->failed_attempts = 0;
            $user->locked_until = null;
        }

        if (Auth::attempt($credentials)) {
            DB::table('users')->where('id', $user->id)->update([
                'failed_attempts' => 0,
                'locked_until' => null
            ]);

            if (Auth::user()->first_time_login) {
                Auth::user()->first_time_login = false;
                Auth::user()->save();

                return view('changepassword', [
                    'first_time_login' => true
                ]);
            }

            return redirect()->intended('/home');
        }

        $failedAttempts = (int) $user->failed_attempts + 1;

        if ($failedAttempts >= 5) {
            DB::table('users')->where('id', $user->id)->update([
                'failed_attempts' => $failedAttempts,
                'locked_until' => Carbon::now()->addMinutes(15)
            ]);

            return redirect('login')->with(
                'error',
                'Too many failed login attempts. Your account is locked for 15 minutes.'
            );
        }

        DB::table('users')->where('id', $user->id)->update([
            'failed_attempts' => $failedAttempts
        ]);

        return redirect('login')->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }

    public function home()
    {
        return view('home');
    }

    public function getForms()
    {
        $this->roles = Auth::user()->role;

        foreach ($this->roles as $role) {
            $this->role_id[] = $role->id;
        }

        $this->form = DB::table('roleformmapping')
            ->wherein('role_id', $this->role_id)
            ->select('forms', 'description')
            ->get();
    }
}
