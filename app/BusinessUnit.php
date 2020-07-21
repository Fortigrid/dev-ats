<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessUnit extends Model
{
    protected $fillable = ['business_unit','created_by'];
	
	/*public function locations(){
		return $this->hasMany(Location::class);
		
	}*/
}
