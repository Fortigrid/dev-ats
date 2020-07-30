<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable =  [

        'adjob_id','board_name','industry','job_class','response','expiry_date'

    ];
	public function adjob(){
	   
	   return $this->belongsTo(Adjob::class);
   }
}
