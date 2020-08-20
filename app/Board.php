<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;

class Board extends Model
{
	use LogsActivity, CausesActivity;
    protected $fillable =  [

        'adjob_id','board_name','industry','job_class','response','expiry_date'

    ];
	protected static $logFillable = true;
	
	public function adjob(){
	   
	   return $this->belongsTo(Adjob::class);
   }
}
