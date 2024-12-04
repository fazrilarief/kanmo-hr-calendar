<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login_form()
    {
        $dept = Department::all();

        return view('auth.login', compact('dept'));
    }

    public function login_admin(Request $request)
    {
        $credentials = $request->validate([
            'department' => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::guard('admin')->user();
            if ($user) {
                return redirect()->route('admin.dashboard');
            }
        }

        return redirect()->back()->withInput()->withErrors(['Invalid login credentials']);
    }

    public function logout_admin(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/bot-chat/admin');
    }
}
