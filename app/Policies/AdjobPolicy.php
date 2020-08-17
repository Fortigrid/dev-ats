<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Adjob;
use Illuminate\Support\Facades\Auth;

class AdjobPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //echo 'test'; exit;
    }
	
	public function views(User $user, Adjob $adjob)
	{
		//dd($user->id);
		//return $user->id == $adjob->created_by;
		if($user->role == 'admin')
			return true;
		    elseif($user->role == 'consult' && $user->id==$adjob->created_by)
			return true;
			else
			return false;
	}
}
