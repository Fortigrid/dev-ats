<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use DB;
use App\User;

class NavComposer
{
   
    
    public function compose(View $view)
    {
		$locas=[];
		if(Auth::check() && Auth::user()->role=='admin'){
		$locas= DB::connection('tracker')->select('select id,location from office_locations');
		$locas=json_decode(json_encode($locas), true);
		}
		else{
			$mergLoc='';
			 if(Auth::check() && Auth::user()->secondary_office_location !='')
				$mergLoc=Auth::user()->office_location.','.Auth::user()->secondary_office_location;
			elseif(Auth::check())
				$mergLoc=Auth::user()->office_location;
			
			
			$mergLoc1=array_filter(explode(',',$mergLoc));
			
			$locas=DB::connection('tracker')->table('office_locations')
				->whereIn('office_locations.id', $mergLoc1)->get();
				
				$locas=json_decode(json_encode($locas), true);
		   
		}
        $view->with(compact('locas'));
    }
}