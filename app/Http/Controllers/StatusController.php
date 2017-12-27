<?php

namespace App\Http\Controllers;
use Auth;
use App\status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
	public function postStatus(Request $request)
	{
		$this->validate($request, ['status' => 'required|max:1000']);

		 Auth::user()->statuses()->create(['body' => request('status')]);

		 return redirect()->route('home')->with("info",'Status Posted!');

	}

	public function editStatus(Status $id)
	{
			return view('status.edit',compact('id'));
	}
	public function updateStatus(Status $id, Request $request)
	{
		$this->validate($request,['body' => 'required']);

		
		$input = request(['body']);

		$id->fill($input)->save();

		return redirect()->route('home')->with('info', 'Status Updated');

	}

	public function deleteStatus($id)
	{
		$status = Status::find($id);

		$replies = Status::where('parent_id', $id);

		$status->delete();

		$replies->delete();
		

		return redirect()->route('home')->with('info', "Post deleted successfully");
	}

	public function postReply(Request $request, $statusId)
	{
		$this->validate($request,["reply-{$statusId}" => 'required|max:100']);

		$status = Status::notReply()->find($statusId);

		if(!$status)
		{
			return redirect()->route('home');
		}

		if(! Auth::user()->isFriendsWith($status->user) && Auth::user()->id !== $status->user->id)
		{
			return redirect()->route('home');
		}

		$reply = Status::create(['body' => $request->input("reply-{$statusId}"),])->user()->associate(Auth::user());
		
		$status->replies()->save($reply);

		
		return redirect()->route('home')->with('info', "Reply Posted to " .$status->user->username. " 's post !");
	}
	
	public function getLike($statusId)
	{
		$status = Status::find($statusId);

		if(!$status)
		{
			return redirect()->route('home');
		}

		if(!Auth::user()->isFriendsWith($status->user))
		{
			return redirect()->route('home');
		}

		if(Auth::user()->hasLikedStatus($status))
		{
			return redirect()->route('home');
		}

		$like = Auth::user()->likes()->create([]);

		$status->likes()->save($like);   

		return redirect()->back()->with('info', 'You liked '. $status->user->username." 's post!"  );
	}

	public function editComment($replyId)
	{
		$reply = Status::find($replyId);

		return view('timeline.comment_edit',compact('reply'));
	}
	
	public function updateComment(Request $request, Status $replyId)
	{

		$this->validate($request,['body' => 'required|max:1000']);

		$input = request(['body']);

		$replyId->fill($input)->save();

		return redirect()->back()->with('info','Comment Updated!');
	}
}