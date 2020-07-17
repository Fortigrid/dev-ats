<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable =  [

        'role_name','created_by'

    ];
	public $timestamps = false;
	public function locations(){
		return $this->belongsToMany('App\Location');
		
	}
	public function sites(){
		return $this->belongsToMany('App\Site');
		
	}
	public function clients(){
		return $this->belongsToMany('App\Client');
		
	}
	public function agencies(){
		return $this->belongsToMany('App\Agency');
		
	}
	public function business_units(){
		return $this->belongsToMany('App\BusinessUnit');
		
	}
	
}
