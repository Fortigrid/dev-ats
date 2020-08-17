<?php

namespace App\Providers;

use App\Policies\AdjobPolicy;
use App\User;
use App\Adjob;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Auth;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
		Adjob::class => AdjobPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
		//$user=auth->user();
	    //$user=User::all();
		//dd($user);
		
		Gate::define('view-user',function($user){
			return $user->hasRole('admin');
		});
		
        //
    }
}
