<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use App\Status;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $fillable = [
        'username', 'email', 'password', 'first_name', 'last_name', 'location'];
    

   
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getName()
    {
    	if($this->first_name && $this->last_name)
    	{
    		return "{$this->first_name} {$this->last_name}";
    	}
    	if($this->first_name)
    	{
    		return $this->first_name;
    	}
    	return null;
    }

    public function getNameOrUsername()
    {
    	return $this->getName() ?: $this->username;
    }

    public function getFirstNameorUsername()
    {
    	return $this->first_name ?: $this->username;
    }

    public function getAvatarUrl()
    {
        return 'https://www.gravatar.com/avatar/{{ md5($this->email) }}?d=mm&s=40';
    }
    public function friendsofMine()
    {
        return $this->belongsToMany('App\User', 'friends', 'user_id', 'friend_id');
    }
    public function friendof()
    {
        return $this->belongsToMany('App\User', 'friends', 'friend_id', 'user_id');
    }

    public function friends()
    {
        return $this->friendsofMine()->wherePivot('accepted', true)->get()->merge($this->friendof()->wherePivot('accepted', true)->get());
    }

    public function friendRequests()
    {
        return $this->friendsofMine()->wherePivot('accepted', false)->get();
    }

   public function friendRequestsPending()
    {
        return $this->friendof()->wherePivot('accepted', false)->get();
    }

    public function hasFriendRequestPending(User $user)
     {
         return (bool) $this->friendRequestsPending()->where('id', $user->id)->count();
     }

     public function hasFriendRequestReceived(User $user)
    {
        return (bool) $this->friendRequests()->where('id', $user->id)->count();
    }

    public function addFriend(User $user)
    {
        $this->friendof()->attach($user->id);
    }

    public function acceptFriendRequest(User $user)
    {
        $this->friendRequests()->where('id', $user->id)->first()->pivot->update(['accepted' => true,]);
    }

    public function isFriendsWith(User $user)
    {
        return (bool) $this->friends()->where('id', $user->id)->count();
    }

    public function statuses()
    {
        return $this->hasMany('App\Status','user_id');
    }

    public function hasLikedStatus(Status $status)
    {
        return (bool) $status->likes->where('likeable_id',$status->id)->where('likeable_type',get_class($status))->where('user_id', $this->id)->count();
    }
    public function likes()
    {
        return $this->hasMany('App\Like','user_id');
    }
}
