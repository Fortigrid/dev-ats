<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Adjob extends Model
{
    protected $fillable =  [

		'reference_no',	'job_title'	,'broadcast','job_type','job_time','bp1','bp2','bp3','sdate','edate','board','industry','job_class','currency','min','max','salary_per','salary_desc','hide_salary','job_requirement','min_exp','edu_level','local_resident','location','postcode','video_url','job_summary','detail_job_summary','location_city','job_template','post_time','contact_email','contact_phone','cost','active','created_on','created_by'	
    ];
	public $timestamps = false;
	
	public function applicants(){
		return $this->hasMany(Applicant::class);
		
	}
	public function boards(){
		return $this->hasMany(Board::class);
		
	}
}
