<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use App\Status;

class HomeController extends Controller
{
	public function index()
	{
		if(Auth::check())
		{
			$statuses = Status::notreply()->where(function($query){

				return $query->where('user_id', Auth::user()->id)->orWhereIn('user_id', Auth::user()->friends()->pluck('id'));
			})->latest()->paginate(10);


			return view('timeline.index',compact('statuses'));
		}
		return view('home');
	}
}