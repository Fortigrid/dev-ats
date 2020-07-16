<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessUnit extends Model
{
    protected $fillable = ['business_unit'];
	
	public function locations(){
		return $this->hasMany(Location::class);
		
	}
}
