<?php

namespace App\Http\Controllers;
use App\User;
use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
	public function getProfile($username)
	{
		$user = User::where('username', $username)->first();

		if(!$user)
		{
			abort(404);

		}
		$statuses = $user->statuses()->notReply()->get();

		return view('profile.index',compact('user','statuses'));
	}

	public function getEdit()
	{
		return view('profile.edit');

	}

	public function postEdit(Request $request)
	{
		$this->validate($request, ['first_name' => 'alpha|max:50', 'last_name' => 'alpha|max:50', 'location' => 'max:20']);

		Auth::user()->update(['first_name' => request('first_name'), 'last_name' => request('last_name') , 'location' => request('location')]);

		return redirect()->route('profile.edit')->with('info','You profile has been successfully updated');

	}
}