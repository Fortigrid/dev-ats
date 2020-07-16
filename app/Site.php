<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable =  [

        'site_name','created_by'

    ];
	public $timestamps = false;
	
	public function clients(){
		return $this->belongsToMany('App\Client');
		
	}
	public function agencies(){
		return $this->belongsToMany('App\Agency');
		
	}
}
