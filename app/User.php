<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;

class User extends Authenticatable
{
    use Notifiable,LogsActivity, CausesActivity;
	
	protected $table= 'acusers';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
	protected static $logFillable = true;
	
	public function hasRole($role){
     
	 #$vv=User::where('role',$role)->first();
	 $users = Cache::remember('users', 60, function () use ($role){
		 return User::where([ ['role',$role], ['id', Auth::user()->id] ])->first();
	 });
     if($users)
	 {
		
		return true;
	 }
	 elseif(Auth::user()->role=='state') { return true;}
	 
	return false;
	
	}


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
