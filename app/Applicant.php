<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;
use Illuminate\Support\Facades\Auth;

class Applicant extends Model
{
	use LogsActivity, CausesActivity;
	public $timestamps = false;
	
	
	
	protected $fillable = [	'adjob_id','applicant_name','applicant_for','applicant_source','applied_date','cv','download','mode','status'];
    
    protected static $logAttributes = ['adjob_id','applicant_name','applicant_for','applicant_source','applied_date','cv','download','mode','status'];
	
	
	
	protected static $logName = 'user';
	
	public function getVal($q){
		
		return $q->getChanges();
		
	}

   public function adjob(){
	   
	   return $this->belongsTo(Adjob::class);
   }
}
