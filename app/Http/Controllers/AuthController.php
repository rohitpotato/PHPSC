<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

use App\User;

class AuthController extends Controller
{

	public function __construct()
	{
		$this->middleware('guest', ['except' => 'signOut']);
	}

	public function getSignup()
	{
		return view('auth.signup');
	}

	public function postSignup(Request $request)
	{
		$this->validate($request,[ 'email' => 'required|unique:users|email|max:255', 'username' => 'required|unique:users|max:20|alpha_dash', 'password' => 'required|min:6']);

		User::create(['email' => request('email'), 'username' => request('username'), 'password' => bcrypt(request('password'))]);

		return redirect()->route('home')->with('info','You have succesfully signed up and can now log in' );

	}
	public function getSignin()
	{
		return view('auth.signin');
	}

	public function postSignin(Request $request)
	{
		$this->validate($request,[ 'email' => 'required', 'password' => 'required']);

		if(! Auth::attempt($request->only(['email', 'password']), $request->has('remember')))
		{
			return redirect()->back()->with('info' , 'Sorry, but your credentials are incorrect');
		}
		return redirect()->route('home')->with('info' , 'You have successfully signed in');

	}

	public function signOut()
	{
		Auth::logout();

		return redirect()->route('home');
	}
}