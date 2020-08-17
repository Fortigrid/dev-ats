<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Board;
use Illuminate\Http\Request;

class adRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		#print_r(session('job')); exit;
		#print_r($this->request->all()); 
		#echo session('rno');
		#$bal= $this->request->get('back');
		#exit;
		#$regex="/^https\\://[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(:[a-zA-Z0-9]*)?/?([a-zA-Z0-9\-\._\?\,\'/\\\+&amp;%\$#\=~])*$/";
		$videoregex="/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/";
		if($this->request->get('back')=='back'){
			return $rules=[];
		}
		else{
        $rules= [
        'broadcast'=> 'required',
		'refno'=> 'required|regex:/^[a-zA-Z0-9]+$/|unique:adjobs,reference_no,'.session('rno'),
		'jobtitle'=>'required|regex:/^[a-zA-Z0-9 ]+$/',
		'hides'=>'required',
		'location'=>'required|regex:/^[a-zA-Z0-9, ]+$/',
		'jsum'=>'required',
		'djob'=>'required',
		'bp1'=>'sometimes|nullable|regex:/^[a-zA-Z0-9., ]+$/',
		'bp2'=>'sometimes|nullable|regex:/^[a-zA-Z0-9., ]+$/',
		'bp3'=>'sometimes|nullable|regex:/^[a-zA-Z0-9., ]+$/',
		'sdate'=>'sometimes|nullable|date_format:Y-m-d',
		'edate'=>'sometimes|nullable|date_format:Y-m-d',
		'min'=>'sometimes|nullable|regex:/^[0-9]+$/',
		'max'=>'sometimes|nullable|regex:/^[0-9]+$/',
		'sdesc'=>'sometimes|nullable|regex:/^[a-zA-Z0-9., ]+$/',
		'jdesc'=>'sometimes|nullable|regex:/^[a-zA-Z0-9., ]+$/',
		'pcode'=>'sometimes|nullable|regex:/^[a-zA-Z0-9., ]+$/',
		'vurl'=>array("nullable", "regex:".$videoregex)
        ];
		foreach(session('job') as $job){
			$rules[$job.'industry']= 'required';
			$rules[$job.'classi']= 'required';
		}
		
		
		return $rules;
		}
    }
	
	public function messages()
    {
        return [
            'broadcast.required' => 'Please select the Broadcast as',
            'refno.required' => 'Reference No. is required!',
            'jobtitle.required' => 'Job Title is required!',
			'hides.required'=> 'Hide Numeric Salary field is required!',
			'location.required'=> 'Location field is required!',
			'jsum.required'=> 'Job Summary field is required!',
			'djob.required'=> 'Detailed Job Description field is required!',
			
        ];
    }
}
