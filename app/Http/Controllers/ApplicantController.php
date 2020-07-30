<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Adjob;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Applicant;
use App\JobTemplate;
use App\Board;

class ApplicantController extends Controller
{
     public function appliIndex(Request $request){
		$aps= Applicant::with('adjob')->latest('id')->get();
		if($request->ajax())
		{
			return DataTables::of($aps)
					->addColumn('action', function($aps){
						$button ='<button type="button"
						name="view" id="'.$aps->id.'"
						class="edit btn btn-primary btn-sm edit
						">View</button> ';
					
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
		}
		return view('recruitment/manageappli');
	}
}
