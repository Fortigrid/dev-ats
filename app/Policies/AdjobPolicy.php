<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Adjob;
use Illuminate\Support\Facades\Auth;
use Request;

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
		 $mergLoc=Auth::user()->office_location.','.Auth::user()->secondary_office_location;
		 $mergLoc1=array_filter(explode(',',$mergLoc));
				  $adid=[];
				 $ads= Adjob::select([
				'adjobs.id',
				'adjobs.response',
				'adjobs.post_time',
				'adjobs.job_title',
				'adjobs.created_by'])
				->join('acusers', 'acusers.id', 'adjobs.created_by')
				->where(function($query) use ($mergLoc1){
					foreach($mergLoc1 as $exp1){
				   $query->orWhere('acusers.office_location','like', '%' . $exp1 . '%');
					
						$query->orWhere('acusers.secondary_office_location','like', '%' . $exp1 . '%');
					}
				})
				->where([['adjobs.active',1]])
				->get();
				
				foreach($ads as $ad){
					$adid[]=$ad['id'];
				}
				$url_segment = Request::segment(3);
				
				 
		if($user->role == 'admin')
			return true;
		elseif($user->role == 'state' ){
			if(in_array($url_segment,$adid))
			return true;
		    else return false;
		}
		    elseif($user->role == 'consult')
			if(in_array($url_segment,$adid))
			return true;
		    else return false;
			else
			return false;
	}
	
	//how to use with and without parameter
	public function views1(User $user, Adjob $adjob)
	{
		// pass in controller like this if need parameter 
		#$disAd= Adjob::where('id',$rid)->get();
		
		# $this->authorize('views', $disAd[0]);
		
		// here $user->id == $adjob->created_by;
	}
	
	public function views2(User $user)
	{
		// pass in controller like this if need parameter 
		# $this->authorize('views');
	}
	
}
