<?php
namespace App\Http\Controllers\admin\login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\login\Login;
use Session;
use Auth;
use App\Models\AdminLogin;

class LoginController extends Controller
{
    public function index() {
        if (Auth::check()) {
            return redirect()->route('admin.listing');
        }
    	return view('admin.login.login');
    }

    public function login_action(Request $request) {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        $users = AdminLogin::where('email', '=', $request->email)->first();
        if ($users === null) {
            return redirect()->route('admin.login')->withError('User not found.');
        }
        else {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                Session::put('id',$users->iAdminId);
                Session::put('email',$request->email);
                $username = $users->vFirstName.' '.$users->vLastName;
                Session::put('vImage',$users->vImage);
                Session::put('username',$username);
                return redirect()->route('admin.listing')->withToastwelcome('Signed in');
            }
            return redirect()->route('admin.login')->withError('Login details are not valid');
        }
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
