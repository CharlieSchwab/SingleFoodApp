<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller {
	public function login() {
		// dd(\Hash::make('123456'));

		if (Auth::check()) {
			return redirect('admin/dashboard');
		}
		return view('admin.auth.login');
	}

	public function Postlogin(Request $request) {
		if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'is_delete' => '0'], true)) {
			if(empty(Auth::user()->status))
			{	
				if(Auth::user()->is_admin == 1 || Auth::user()->is_admin == 2)
				{
					return redirect()->intended('admin/dashboard');		
				}
				else
				{
					Auth::logout();
					return redirect()->back()->with('error', 'Please enter the correct credentials');	
				}
			}
			else
			{
				Auth::logout();
				return redirect()->back()->with('error', 'Please enter the correct credentials');	
			}
		} else {
			return redirect()->back()->with('error', 'Please enter the correct credentials');
		}
	}

	// Auth logout
	public function logout() {
		Auth::logout();
		return redirect(url(''));
	}
}
