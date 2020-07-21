<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobTemplate extends Model
{
    protected $fillable =  [

        'business_unit_id','template_name','header_image','content_bg_color','footer_image','status','created_by'

    ];
	public $timestamps = false;
}
