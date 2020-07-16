<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Location;
use App\Site;

class Client extends Model
{
    protected $fillable =  [

        'client_name','created_by'

    ];
	public $timestamps = false;
	public function locations(){
		return $this->belongsToMany('App\Location');
		
	}
	public function sites(){
		return $this->belongsToMany('App\Site');
		
	}
}
