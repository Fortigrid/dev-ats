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
	public function __construct()
    {
        $this->middleware('auth');
    }
     public function appliIndex(Request $request){
		 $mergLoc=Auth::user()->office_location.','.Auth::user()->secondary_office_location;
		 $mergLoc1=array_filter(explode(',',$mergLoc));
		if(Auth::user()->role=='admin')
		$aps= Applicant::with('adjob')->latest('id')->get();
	    else{
			$aps= Applicant::join('adjobs', 'adjobs.id','applicants.adjob_id')
				->join('acusers', 'acusers.id', 'adjobs.created_by')
				->where(function($query) use ($mergLoc1){
					foreach($mergLoc1 as $exp1){
				   $query->orWhere('acusers.office_location','like', '%' . $exp1 . '%');
					
						$query->orWhere('acusers.secondary_office_location','like', '%' . $exp1 . '%');
					}
				})
				->where([['adjobs.active',1]])
				->get();
		}
		
		if($request->ajax())
		{
			return DataTables::of($aps)
					->addColumn('action', function($aps){
						$button ='<a href="#" id="'.$aps->download.'" data-rel="popup" data-position-to="window" class="preview">Preview</a> <a href="../downloads/'.$aps->download.'"
						name="view" id="'.$aps->id.'"
						class="edit btn btn-primary btn-sm edit
						">CV Download</a> ';
					
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
		}
		return view('recruitment.manageappli');
	}
	public function cvSearch(Request $request){
		 $mergLoc=Auth::user()->office_location.','.Auth::user()->secondary_office_location;
		 $mergLoc1=array_filter(explode(',',$mergLoc));
		if(Auth::user()->role=='admin')
		$aps= Applicant::with('adjob')->latest('id')->get();
	    else{
			$aps= Applicant::join('adjobs', 'adjobs.id','applicants.adjob_id')
				->join('acusers', 'acusers.id', 'adjobs.created_by')
				->where(function($query) use ($mergLoc1){
					foreach($mergLoc1 as $exp1){
				   $query->orWhere('acusers.office_location','like', '%' . $exp1 . '%');
					
						$query->orWhere('acusers.secondary_office_location','like', '%' . $exp1 . '%');
					}
				})
				->where([['adjobs.active',1]])
				->get();
		}
		if($request->ajax())
		{
			return DataTables::of($aps)
					->addColumn('action', function($aps){
						$button ='<a href="#" id="'.$aps->download.'" data-rel="popup" data-position-to="window" class="preview">Preview</a> <a href="../downloads/'.$aps->download.'"
						name="view" id="'.$aps->id.'"
						class="edit btn btn-primary btn-sm edit
						">CV Download</a> ';
					
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
		}
		return view('recruitment.cvsearch');
	}
	
	public function responses(Request $request){
		#link to redirect to response page
		#https://secure.indeed.com/account/oauth?client_id=f6b3065e95dd2eccb72a82f935cff8e4a1a79ad300f6334444f084d8778077c0&response_type=code&redirect_uri=http://localhost:8000/response
		#print_r($request->all()); 
		$url='https://secure.indeed.com/oauth/tokens';
		$rtoken='';
		$token="code=".$request->code."&client_id=f6b3065e95dd2eccb72a82f935cff8e4a1a79ad300f6334444f084d8778077c0&client_secret=ccxbDmknqnVgnNhrVMwAxyCzisWJeGdBtut5nIs1oPkAVtGQfHV54J5OXcl08jbX&redirect_uri=http://localhost:8000/response&grant_type=authorization_code";
		 $headers = array();

$headers[] = 'Accept: application/json';
$headers[] = 'application/x-www-form-urlencoded; charset=utf-8';
		$curl = curl_init($url);    // we init curl by passing the url
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl,CURLOPT_POST,true);   // to send a POST request
    curl_setopt($curl,CURLOPT_POSTFIELDS,$token);   // indicate the data to send
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);   // to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);   // to stop cURL from verifying the peer's certificate.
    $result = curl_exec($curl);   // to perform the curl session
    curl_close($curl);   // to close the curl session

    
	 $result = json_decode($result, TRUE);
	 
	 print_r($result);exit;
	/* $rtoken='W5Kggj4N6E4';
	 
	 $token1="refresh_token=".$rtoken."&client_id=f6b3065e95dd2eccb72a82f935cff8e4a1a79ad300f6334444f084d8778077c0&client_secret=ccxbDmknqnVgnNhrVMwAxyCzisWJeGdBtut5nIs1oPkAVtGQfHV54J5OXcl08jbX&grant_type=refresh_token";
	 
	 $headers1[] = 'Accept: application/json';
$headers1[] = 'application/x-www-form-urlencoded; charset=utf-8';
		$curl = curl_init($url);    // we init curl by passing the url
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers1);
    curl_setopt($curl,CURLOPT_POST,true);   // to send a POST request
    curl_setopt($curl,CURLOPT_POSTFIELDS,$token1);   // indicate the data to send
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);   // to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);   // to stop cURL from verifying the peer's certificate.
    $result1 = curl_exec($curl);   // to perform the curl session
    curl_close($curl);   // to close the curl session
	 
	  print_r($result1); exit;*/
	}
	
	public function campaign(){
		
		$url='https://employers.indeed.com/api/v1/account';
		$acsessCode='eyJraWQiOiIxYmVlMzgxOC1hY2RjLTQ3YTUtYjdlNy02NDg3Yzk5NDNjZGUiLCJ0eXAiOiJKV1QiLCJhbGciOiJFUzI1NiJ9.eyJzdWIiOiI1OThlOTYyN2VhMDM3NDYxIiwiYXpwIjoiZjZiMzA2NWU5NWRkMmVjY2I3MmE4MmY5MzVjZmY4ZTRhMWE3OWFkMzAwZjYzMzQ0NDRmMDg0ZDg3NzgwNzdjMCIsImlzcyI6Imh0dHBzOlwvXC9zZWN1cmUuaW5kZWVkLmNvbSIsImV4cCI6MTU5NzIwODMxNSwiaWF0IjoxNTk3MjA0NzE1fQ.uOd5fSXDxyZ5WJkZb6ucQwHgYy524KiFdZ25EQnEZx-wpk5lEBL4ev_z7Is7RcIP09TEzO-ewFkMPjUML0x-IA';
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Accept: application/json';
		$headers[] = "Authorization: Bearer ".$acsessCode;
		$curl = curl_init($url);    // we init curl by passing the url
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //curl_setopt($curl,CURLOPT_POST,true);   // to send a POST request
   //curl_setopt($curl,CURLOPT_POSTFIELDS,$token);   // indicate the data to send
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);   // to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);   // to stop cURL from verifying the peer's certificate.
    $result = curl_exec($curl);   // to perform the curl session
    curl_close($curl);   // to close the curl session

    
	 $result = json_decode($result, TRUE);
	 
	 print_r($result);exit;
	 
	 /*
	 $url='https://employers.indeed.com/api/v1/campaigns';
		$acsessCode='eyJraWQiOiIxYmVlMzgxOC1hY2RjLTQ3YTUtYjdlNy02NDg3Yzk5NDNjZGUiLCJ0eXAiOiJKV1QiLCJhbGciOiJFUzI1NiJ9.eyJzdWIiOiI1OThlOTYyN2VhMDM3NDYxIiwiYXpwIjoiZjZiMzA2NWU5NWRkMmVjY2I3MmE4MmY5MzVjZmY4ZTRhMWE3OWFkMzAwZjYzMzQ0NDRmMDg0ZDg3NzgwNzdjMCIsImlzcyI6Imh0dHBzOlwvXC9zZWN1cmUuaW5kZWVkLmNvbSIsImV4cCI6MTU5NzEzOTE0NSwiaWF0IjoxNTk3MTM1NTQ1fQ.iDHnRv-jqBFOqF-tCmV752-G_Qd1N2GT8gUUnJDZI2vz0HMTv7qWyKGfh-J8oEADFj4k8cNzZmWX0Ea0dytV8A';
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Accept: application/json';
		$headers[] = "Authorization: Bearer ".$acsessCode;
		
		$token='{
  "name": "Full stack",
  "status": "DELETED",
  "trackingToken": "test_chi",
  "jobsSourceId": "55675634",
  "jobsToInclude": "ALL",
  "jobsQuery": "PHP",
  "jobsTitle": "software engineer",
  "jobsCompany": "test",
  "jobsLocation": "Sydney",
  "jobsLocationRadius": 5,
  "budgetOptimizationTarget": "AUTOMATIC",
  "budgetOnetimeLimit": 10000,
  "budgetMonthlyLimit": 10000,
  "budgetDailyLimit": 100,
  "budgetFirstMonthBehavior": "startNowFullAmount",
  "maxCpc": 100,
  "budgetOnetimeDuration": 10
}';
		
		
		$curl = curl_init($url);    // we init curl by passing the url
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl,CURLOPT_POST,true);   // to send a POST request
   curl_setopt($curl,CURLOPT_POSTFIELDS,$token);   // indicate the data to send
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);   // to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);   // to stop cURL from verifying the peer's certificate.
    $result = curl_exec($curl);   // to perform the curl session
    curl_close($curl);   // to close the curl session

    
	 $result = json_decode($result, TRUE);
	 
	 print_r($result);exit;
	 */
	 
	 
	 
	}
	
}
