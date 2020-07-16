<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable =  [

        'role_name','business_unit_id','location_id' ,'client', 'site', 'agency', 'created_by' , 'deleted_by' ,'deleted_status'

    ];
}
