<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $fillable =  [

        'agency_name','created_by'

    ];
	public $timestamps = false;
	
	public function sites(){
		return $this->belongsToMany('App\Site');
	}
}
