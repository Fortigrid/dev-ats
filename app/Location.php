<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Client;

class Location extends Model
{
	
	protected $fillable =  [

        'business_unit_id', 'state', 'location'

    ];

    
	public function business_unit(){
		return $this->belongsTo(BusinessUnit::class);
	}
	public function clients(){
		return belongsToMany('App\Client');
	}
}
