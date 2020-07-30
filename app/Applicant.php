<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Applicant extends Model
{
	public $timestamps = false;
   public function adjob(){
	   
	   return $this->belongsTo(Adjob::class);
   }
}
