<?php

namespace App\Http\Controllers;
use App\User;
use Auth;
use Illuminate\Http\Request;

class FriendController extends Controller
{
	public function getIndex()
	{

		$friends = Auth::user()->friends();

		$friendRequests = Auth::user()->friendRequests();

		return view('friends.index',compact('friends', 'friendRequests'));
	}

	public function getAdd($username)
	{
		$user = User::where('username', $username)->first();
		
		if(!$user)
		{
			return redirect()->route('home')->with('info', 'The user could not be found');
		}
		if(Auth::user()->hasFriendRequestPending($user) || $user->hasFriendRequestPending(Auth::user()))
		{
			return redirect()->route('profile.index', ['username' => $user->username])->with('info', 'Friend request already pending');
		}

		if(Auth::user()->isFriendsWith($user))
		{
			return redirect()->route('profile.index',['username' => $user->username])->with('info','You are already friends with this user');
		}
		Auth::user()->addFriend($user);

		return redirect()->route('profile.index', ['username' => $user->username])->with('info',"Friend request sent!");


	}

	public function getAccept($username)
	{
		$user = User::where('username', $username)->first();

		if(!$user)
		{
			return redirect()->route('home')->with('info', 'The user could not be found');
		}

		if(! Auth::user()->hasFriendRequestReceived($user))
		{
			return redirect()->route('home');
		}

		if(! Auth()->user()->id == $user->id)
		{
			return redirect()->route('home');
		}

		Auth::user()->acceptFriendRequest($user);

		return redirect()->route('profile.index',['username' => $user->username])->with('info','Friend Request Accepted');

	}
}