<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\adRequest;
use App\Adjob;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Applicant;
use App\JobTemplate;
use App\Board;
use App\Services\RecruitService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Models\Activity;
use DB;

class AdController extends Controller
{
	
	protected $rservice;
	public function __construct(RecruitService $rservice)
    {
        $this->middleware('auth');
		$this->rservice=$rservice;
    }
	public function recruit(){
		
		//Cache::forget('users');
		return view('recruitment.index');
	}
    public function adIndex(Request $request){
		session()->forget('job');
		session()->forget('details');
		session()->forget('temp');
		session(['job'=>'']);
		session(['details'=>'']);
		session(['temp'=>'']);
		//Cache::forget('users');
		return view('recruitment.adindex');
	}
	public function adIndexPost(Request $request){
		$request->validate([
		'job_board'=> 'required'
		]);
		
		session(['job'=>$request->job_board]);
		
		if($request->session()->has('job')) return redirect('/recruitment/adpost/1');
		else  return redirect('/recruitment/adpost');
	}
	public function adDetail(Request $request){
		//dd(session()->all());
		
		if($request->session()->get('job')){
		// auto increment Reference no
		$refno=DB::select("show table status WHERE name='adjobs'");
		$refno=json_decode(json_encode($refno), true);
		$refno=$refno[0]['Auto_increment'];
		return view('recruitment.addetail',compact('refno')); }
	     else  return redirect('/recruitment/adpost');
	}
	public function adDetailPost(adRequest $request){
		#print_r($request->all());exit;
		if($request->has('back') && $request->back=='back' ){
			return redirect('/recruitment/adpost');
		}
		else{
		session(['details'=>$request->except('_token')]);
		if(count($request->session()->get('details',[]))>9) return redirect('/recruitment/adpost/2');
		else  return redirect('/recruitment/adpost/1');
		}
	}
	
	public function previewPub(Request $request){
		//dd(session()->all());
		$loc='';
		if($request->session()->get('details')){
		$JobTemplate=$this->rservice->roleBased(Auth::user()->role,Auth::user()->office_location,Auth::user()->secondary_office_location);
	    //print_r($JobTemplate);
		return view('recruitment.previewpub',compact('JobTemplate'));
		}
	    else return redirect('/recruitment/adpost');
		
	}
	public function previewPubPost(Request $request){
		//dd(session()->all());
		if($request->has('back') && $request->back=='back'){
			return redirect('/recruitment/adpost/1');
		}else{
		$request->validate([
		'jtemp'=> 'required',
		
		],['jtemp.required'=>'Please select the Job Template']);
		if($request->session()->get('details')){
		session(['temp'=>$request->except('_token')]);
		return redirect('/recruitment/adpost/3');
		}
	    else return redirect('/recruitment/adpost');
		}
		
	}
	public function jobPub(Request $request){
		if($request->session()->get('details')&& $request->session()->get('temp')){
		
		$tempDetail=JobTemplate::where([['active','1'],['id',session('temp.jtemp')]])->get()->toArray();
		$tempDetail=$tempDetail[0];
		return view('recruitment.jobpub',compact('tempDetail'));
		}
	    else return redirect('/recruitment/adpost');
	}
	public function jobPubPost(Request $request){
		if($request->has('back') && $request->back=='back'){
			return redirect('/recruitment/adpost/2');
		}else{
		if($request->session()->get('details') && $request->session()->get('temp')){
		$this->rservice->addAd(session()->all());
		session()->forget('details');
		session()->forget('job');
		session()->forget('temp');
		return redirect('/recruitment/managead');
		}
	    else return redirect('/recruitment/adpost');
		}
	}
	public function manageAd(Request $request){
		session()->forget('job');
		session()->forget('details');
		session()->forget('temp');
	  
		$ads=$this->rservice->roleBasedAd(Auth::user()->role,Auth::user()->office_location,Auth::user()->secondary_office_location);
	   
		if($request->ajax())
		{
			return DataTables::of($ads)
					->addColumn('action', function($ads){
						$button ='<button type="button"
						name="edit" id="'.$ads->id.'"
						class="edit btn btn-primary btn-sm edits
						">Quick view</button> ';
					
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
		}
		return view('recruitment.managepost');
	}
	
	public function allAd(Request $request){
		$mergLoc=Auth::user()->office_location.','.Auth::user()->secondary_office_location;
		 $mergLoc1=array_filter(explode(',',$mergLoc));
		 $sesloc='';
		 $sesloc=session()->get('locations');
		if($request->ids=='liveads'){
			if(Auth::user()->role=='admin'){
			
			//location based filter
				if(!empty($sesloc)) {
				$sesloc=array_filter(explode(',',$sesloc));
				$creby=[];
				
				$usr= User::where(function($query) use ($sesloc){
					foreach($sesloc as $exp1){
				   $query->orWhere('acusers.office_location','like', '%' . $exp1 . '%');
					
						//$query->orWhere('acusers.secondary_office_location','like', '%' . $exp1 . '%');
						$query->orWhere(DB::raw("find_in_set($exp1,acusers.secondary_office_location)"),">",DB::raw("'0'"));
					}
				})
				->get(['id'])->toArray();
				
				foreach($usr as $us){
					$creby[]=$us['id'];
				}
				// for adding admin user
				$creby[]='1';
			
				$ads= Adjob::select([
				'adjobs.id',
				\DB::raw('count(applicants.adjob_id) as response'),
				'adjobs.post_date',
				'adjobs.job_title',
				'adjobs.created_by',
				\DB::raw('(CASE 
                        WHEN (boards.board_name = "Adzuna" && (NOW() < boards.expiry_date && datediff(expiry_date,NOW()) <= 7)) THEN "1" 
                        WHEN (boards.board_name = "Jora" && (NOW() < boards.expiry_date && datediff(expiry_date,NOW()) <= 7)) THEN "1" 
						WHEN (boards.board_name = "Seek" && (NOW() < boards.expiry_date && datediff(expiry_date,NOW()) <= 7)) THEN "1" 
                        ELSE "0" 
                        END) AS expiry')
				])
				->leftJoin('boards', 'adjobs.id', 'boards.adjob_id')
				->leftJoin('applicants', 'adjobs.id', 'applicants.adjob_id')
				->whereIn('adjobs.created_by', $creby)
				->where([['adjobs.active',1]])
				->groupBy('applicants.adjob_id','adjobs.id')
				->get();
				
				}
				else{
				$ads= Adjob::select([
				'adjobs.id',
				\DB::raw('count(applicants.adjob_id) as response'),
				'adjobs.post_date',
				'adjobs.job_title',
				'adjobs.created_by',
				\DB::raw('(CASE 
                        WHEN (boards.board_name = "Adzuna" && (NOW() < boards.expiry_date && datediff(expiry_date,NOW()) <= 7)) THEN "1" 
                        WHEN (boards.board_name = "Jora" && (NOW() < boards.expiry_date && datediff(expiry_date,NOW()) <= 7)) THEN "1" 
						WHEN (boards.board_name = "Seek" && (NOW() < boards.expiry_date && datediff(expiry_date,NOW()) <= 7)) THEN "1" 
                        ELSE "0" 
                        END) AS expiry')
				])
				->leftJoin('boards', 'adjobs.id', 'boards.adjob_id')
				->leftJoin('applicants', 'adjobs.id', 'applicants.adjob_id')
				->where([['adjobs.active',1]])
				->groupBy('applicants.adjob_id','adjobs.id')
				->get();
				}
			}
		    else{ //state or consult
				//location based filter
				if(!empty($sesloc)) {
				$sesloc=array_filter(explode(',',$sesloc));
				$ads= Adjob::select([
				'adjobs.id',
				\DB::raw('count(applicants.adjob_id) as response'),
				'adjobs.post_date',
				'adjobs.job_title',
				'adjobs.created_by',
				\DB::raw('(CASE 
                        WHEN (boards.board_name = "Adzuna" && (NOW() < boards.expiry_date && datediff(expiry_date,NOW()) <= 7)) THEN "1" 
                        WHEN (boards.board_name = "Jora" && (NOW() < boards.expiry_date && datediff(expiry_date,NOW()) <= 7)) THEN "1" 
						WHEN (boards.board_name = "Seek" && (NOW() < boards.expiry_date && datediff(expiry_date,NOW()) <= 7)) THEN "1" 
                        ELSE "0" 
                        END) AS expiry')
				])
				->leftJoin('boards', 'adjobs.id', 'boards.adjob_id')
				->leftJoin('applicants', 'adjobs.id', 'applicants.adjob_id')
				->join('acusers', 'acusers.id', 'adjobs.created_by')
				->where(function($query) use ($sesloc){
					foreach($sesloc as $exp1){
				   $query->orWhere('acusers.office_location','like', '%' . $exp1 . '%');
					
						//$query->orWhere('acusers.secondary_office_location','like', '%' . $exp1 . '%');
						$query->orWhere(DB::raw("find_in_set($exp1,acusers.secondary_office_location)"),">",DB::raw("'0'"));
					}
				})
				->where([['adjobs.active',1]])
				->groupBy('applicants.adjob_id','adjobs.id')
				->get();
				}
				else{
				$ads= Adjob::select([
				'adjobs.id',
				\DB::raw('count(applicants.adjob_id) as response'),
				'adjobs.post_date',
				'adjobs.job_title',
				'adjobs.created_by',
				\DB::raw('(CASE 
                        WHEN (boards.board_name = "Adzuna" && (NOW() < boards.expiry_date && datediff(expiry_date,NOW()) <= 7)) THEN "1" 
                        WHEN (boards.board_name = "Jora" && (NOW() < boards.expiry_date && datediff(expiry_date,NOW()) <= 7)) THEN "1" 
						WHEN (boards.board_name = "Seek" && (NOW() < boards.expiry_date && datediff(expiry_date,NOW()) <= 7)) THEN "1" 
                        ELSE "0" 
                        END) AS expiry')
				])
				->leftJoin('boards', 'adjobs.id', 'boards.adjob_id')
				->leftJoin('applicants', 'adjobs.id', 'applicants.adjob_id')
				->join('acusers', 'acusers.id', 'adjobs.created_by')
				->where(function($query) use ($mergLoc1){
					foreach($mergLoc1 as $exp1){
				   $query->orWhere('acusers.office_location','like', '%' . $exp1 . '%');
					
						//$query->orWhere('acusers.secondary_office_location','like', '%' . $exp1 . '%');
						$query->orWhere(DB::raw("find_in_set($exp1,acusers.secondary_office_location)"),">",DB::raw("'0'"));
					}
				})
				->where([['adjobs.active',1]])
				->groupBy('applicants.adjob_id','adjobs.id')
				->get();
				}
			}
		}
		else {
			if(Auth::user()->role=='admin'){
			#$ads= Adjob::with('applicants')->where('active','0')->latest('id')->get();
		    $ads= Adjob::select([
				'adjobs.id',
				\DB::raw('count(applicants.adjob_id) as response'),
				'adjobs.post_date',
				'adjobs.job_title',
				'adjobs.created_by'])
				->leftJoin('applicants', 'adjobs.id', 'applicants.adjob_id')
				->where([['adjobs.active',0]])
				->groupBy('applicants.adjob_id','adjobs.id')
				->get();
			}
		    else{
				$ads= Adjob::select([
				'adjobs.id',
				\DB::raw('count(applicants.adjob_id) as response'),
				'adjobs.post_date',
				'adjobs.job_title',
				'adjobs.created_by'])
				->leftJoin('applicants', 'adjobs.id', 'applicants.adjob_id')
				->join('acusers', 'acusers.id', 'adjobs.created_by')
				->where(function($query) use ($mergLoc1){
					foreach($mergLoc1 as $exp1){
				   $query->orWhere('acusers.office_location','like', '%' . $exp1 . '%');
					
						//$query->orWhere('acusers.secondary_office_location','like', '%' . $exp1 . '%');
						$query->orWhere(DB::raw("find_in_set($exp1,acusers.secondary_office_location)"),">",DB::raw("'0'"));
					}
				})
				->where([['adjobs.active',0]])
				->groupBy('applicants.adjob_id','adjobs.id')
				->get();
				
			}
		}
		if($request->adid !=''){
			
		#$aps= Board::where('adjob_id',$request->adid)->get();
		/*$aps= Board::select([
		         'boards.id',
				'boards.board_name',
				\DB::raw('count(applicants.applicant_source) as response'),
				'boards.expiry_date'
				])
				->leftJoin('applicants', 'boards.adjob_id', 'applicants.adjob_id')
				->where('boards.adjob_id',$request->adid)
				->groupBy('boards.board_name')
				->get();*/
		//print_r($aps); exit;
		$qry="select boards.id,applicants.applicant_source as board_name, count(applicants.applicant_source) as response,boards.expiry_date from `applicants` join boards on applicants.`adjob_id`=boards.`adjob_id` where `applicants`.`adjob_id` = $request->adid and applicants.`applicant_source`=boards.`board_name` and applicants.active=1 group by applicants.applicant_source";
		$aps = DB::select(DB::raw($qry));
		$aps=json_decode(json_encode($aps), true);
		$aps1= Board::where('adjob_id',$request->adid)->get()->toArray();
		
		//Comparing board and applicant table and adding missing in the array
		
		foreach($aps as $apps){
			
			$bb[]=$apps['board_name'];
			
			
		}
		if(isset($bb))
		foreach($bb as $cc) $dd[]=$cc;
		
		//print_r($dd); exit;
		foreach($aps1 as $app){
			if(isset($dd)){
			if(!in_array($app['board_name'],$dd))
			$apb[]=$app;
			}
			else $apb[]=$app;
		}
		
		if(count($aps1)> count($aps)){
		if(isset($apb[0]))
		array_push($aps,$apb[0]);
	    if(isset($apb[1]))
		array_push($aps,$apb[1]);
	     if(isset($apb[2]))
		array_push($aps,$apb[2]);
		}
	
	    #print_r($aps);
		 
		#exit;
		return response()->json($aps);
		}
		
		//Job delete
		if($request->deleids !=''){
		$adjob= new Adjob;
		$request->deleids=array_filter(explode(',',$request->deleids));
		$delad= Adjob::whereIn('id',$request->deleids)->update(['active'=>0]);
		activity()
		->performedOn($adjob)
		->causedBy(Auth::user())
		->withProperties(['deleted ids'=>$request->deleids,
			  'old'=>'active=1',
			  'active'=>0])
		->useLog('Job that are deleted')
		->log('deleted');
		return response()->json('Jobs deleted');
		}
		
		//Board delete popup
		if($request->deleboards !=''){
		$bcount='';
		$counts='';
		$adss1= Adjob::withCount('boards')->where([['id',$request->jobid],['active','1']])->get()->toArray();
		$bcount=$adss1[0]['boards_count'];
		$counts=count($request->deleboards);
		//delete based on count
		if($bcount==$counts){
		Adjob::where('id',$request->jobid)->update(['active'=>0]);
		Applicant::where([['adjob_id',$request->jobid],['applicant_source',$request->deleboname]])->update(['active'=>0]);
		$delad= Board::whereIn('id',$request->deleboards)->delete();
		$stat='job deleted';
		}
		else{
		$delad= Board::whereIn('id',$request->deleboards)->delete();
		Applicant::where([['adjob_id',$request->jobid],['applicant_source',$request->deleboname]])->update(['active'=>0]);
		$stat='board deleted';
		}
		
		return response()->json($stat);
		}
		
		if($request->ajax())
		{
			return DataTables::of($ads)
					->addColumn('action', function($ads){
						$button ='<button type="button"
						name="edit" id="'.$ads->id.'"
						class="edit btn btn-primary btn-sm edits
						">Quick view</button> ';
					
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
		}
		
    }	
	public function displayAd(Request $request,$rid){
		session(['rno'=>$rid]);
		$act='0';
		//$disAd= Adjob::where([['id',$rid],['active','1']])->get()->toArray();
		$disAd= Adjob::with('boards')->where('id',$rid)->take(1)->get();
		$childPost=Adjob::with('boards')->where('cost',$rid)->take(1)->get('id');
		$childPost=isset($childPost) ? $childPost=$childPost : $childPost=[];
		//location for invite candidate based on role
		$locations=$this->rservice->roleBasedLocation(Auth::user()->role,Auth::user()->office_location,Auth::user()->secondary_office_location);
		
		//role based restriction
		if(isset($disAd[0])) $this->authorize('views', $disAd[0]);
		//Auth::user()->can('views',$disAd[0]);
		$disAd=$disAd->toArray();
		if(isset($disAd[0])){
		$disAd=$disAd[0];
		if($disAd['active']=='1') $act=1; else $act='0';
		return view('recruitment.displaypost',compact('disAd','childPost','act','locations'));
		}
		else return redirect('/recruitment/managead');
	
	}
	
	public function locaBasedConsult(Request $request,$rid){
		
		if($request->loca!=''){
			$consults=$this->rservice->locaBasedConsul($request->loca);
		}
		return $consults;
	}
	
	public function editChange(Request $request,$rid){
		session(['job'=>'']);
		session(['details'=>'']);
		session(['temp'=>'']);
		$disAd= Adjob::where('id',$rid)->get();
		if(isset($disAd[0])) $this->authorize('views', $disAd[0]);
		$disAd=$disAd->toArray();
		if(isset($disAd[0])){
		$disAd=$disAd[0];
		
		$boards=Board::where('adjob_id',$rid)->get()->toArray();
		foreach($boards as $board){
			$bname[]=$board['board_name'];
		}
		$bname=isset($bname) ? $bname : [];
		return view('recruitment.editpost',compact('disAd','bname'));
		}
		else return redirect('/recruitment/managead');
	}	
	
	public function editChangePost(Request $request,$rid){
		$request->validate([
		'job_board'=> 'required'
		]);
		
		session(['job'=>$request->job_board]);
		if($request->session()->has('job')) return redirect("/recruitment/managead/$rid/edit/step1");
		else  return redirect("/recruitment/managead/$rid/edit");
	}	
	
	public function editDetail(Request $request,$rid){
		session(['rno'=>$rid]);
		if($request->session()->get('job')){
		$disAd= Adjob::where('id',$rid)->get()->toArray();
		if(isset($disAd[0])){
		$disAd=$disAd[0];
		$boards=Board::where('adjob_id',$rid)->get()->toArray();
		foreach($boards as $board){
			$bname[]=$board['board_name'];
			$bindus[]=$board['industry'];
			$bclassi[]=$board['job_class'];
		}
		$bindus=isset($bindus) ? $bindus : [];
		$bclassi=isset($bclassi) ? $bclassi : [];
		return view('recruitment.editaddetail',compact('disAd','bindus','bclassi'));
		} else return redirect("/recruitment/managead/$rid/edit");
		}
	     else  return redirect("/recruitment/managead/$rid/edit");
		
	}
	
	public function editDetailPost(adRequest $request,$rid){
		if($request->has('back') && $request->back=='back'){
			return redirect("/recruitment/managead/$rid/edit");
		}
		else{
		session(['details'=>$request->except('_token')]);
		if(count($request->session()->get('details',[]))>0) return redirect("/recruitment/managead/$rid/edit/step2");
		else  return redirect("/recruitment/managead/$rid/edit/step1");
		}
	}
	
	public function editPub(Request $request,$rid){
		if($request->session()->get('details')){
		$disAd= Adjob::where('id',$rid)->get()->toArray();
		if(isset($disAd[0])){
		$disAd=$disAd[0];
		
		#$JobTemplate = JobTemplate::where('active','1')->get()->toArray();
		$JobTemplate=$this->rservice->roleBased(Auth::user()->role,Auth::user()->office_location,Auth::user()->secondary_office_location);
	    //print_r($JobTemplate);
		return view('recruitment.editpub',compact('JobTemplate','disAd'));
		} else return redirect("/recruitment/managead/$rid/edit");
		}
	    else return redirect("/recruitment/managead/$rid/edit");
	}
	
	public function editPubPost(Request $request,$rid){
		if($request->has('back') && $request->back=='back'){
			return redirect("/recruitment/managead/$rid/edit/step1");
		}else{
		if($request->jtemp!=''){
		if($request->session()->get('details')){
		session(['temp'=>$request->except('_token')]);
		#session()->forget('details');
		#session()->forget('job');
		return redirect("/recruitment/managead/$rid/edit/step3");
		}
	    else return redirect("/recruitment/managead/$rid/edit");
		}
		else{
			return redirect("/recruitment/managead/$rid/edit/step2")->with('errorMessage', 'Please select template');
		}
		}
	}
	
	public function editJobPub(Request $request,$rid){
		
		
		if($request->session()->get('details')&& $request->session()->get('temp')){
		
		$tempDetail=JobTemplate::where([['active','1'],['id',session('temp.jtemp')]])->get()->toArray();
		$tempDetail=$tempDetail[0];
		return view('recruitment.editjobpub',compact('tempDetail'));
		}
	    else return redirect("/recruitment/managead/$rid/edit");
	}
	
	public function editJobPubPost(Request $request,$rid){
		if($request->has('back') && $request->back=='back'){
			return redirect("/recruitment/managead/$rid/edit/step2");
		}else{
		if($request->session()->get('details') && $request->session()->get('temp')){
		$this->rservice->editAd(session()->all(),$rid);
		session()->forget('details');
		session()->forget('job');
		session()->forget('temp');
		return redirect('/recruitment/managead');
		}
	    else return redirect("/recruitment/managead/$rid/edit");
		}
	}
	
	
	//clone----------------------------------------------------
	public function resendChange(Request $request,$rid){
		session(['job'=>'']);
		session(['details'=>'']);
		session(['temp'=>'']);
		$disAd= Adjob::where('id',$rid)->get();
		if(isset($disAd[0])) $this->authorize('views', $disAd[0]);
		$disAd=$disAd->toArray();
		if(isset($disAd[0])){
		$disAd=$disAd[0];
		$boards=Board::where('adjob_id',$rid)->get()->toArray();
		foreach($boards as $board){
			$bname[]=$board['board_name'];
		}
		$bname=isset($bname) ? $bname : [];
		//echo $vv=implode(',',$dd);
		//print_r(array_values($dd)); exit;
		return view('recruitment.resendpost',compact('disAd','bname'));
		} return redirect("/recruitment/managead");
	}	
	
	public function resendChangePost(Request $request,$rid){
		$request->validate([
		'job_board'=> 'required'
		]);
		
		session(['job'=>$request->job_board]);
		//dd(session()->all());
		//echo $rid; exit;
		if($request->session()->has('job')) return redirect("/recruitment/managead/$rid/resend/step1");
		else  return redirect("/recruitment/managead/$rid/resend");
	}	
	
	public function resendDetail(Request $request,$rid){
		session(['rno'=>'']);
		if($request->session()->get('job')){
		$disAd= Adjob::where('id',$rid)->get()->toArray();
		if(isset($disAd[0])){
		$disAd=$disAd[0];
		$boards=Board::where('adjob_id',$rid)->get()->toArray();
		foreach($boards as $board){
			$bname[]=$board['board_name'];
			$bindus[]=$board['industry'];
			$bclassi[]=$board['job_class'];
		}
		$bindus=isset($bindus) ? $bindus : [];
		$bclassi=isset($bclassi) ? $bclassi : [];
		//auto increament for Reference
		$refno=DB::select("show table status WHERE name='adjobs'");
		$refno=json_decode(json_encode($refno), true);
		$refno=$refno[0]['Auto_increment'];
		return view('recruitment.resendaddetail',compact('disAd','bindus','bclassi','refno'));
		} else  return redirect("/recruitment/managead/$rid/resend");
		}
	     else  return redirect("/recruitment/managead/$rid/resend");
		
	}
	
	public function resendDetailPost(adRequest $request,$rid){
		if($request->has('back') && $request->back=='back'){
			return redirect("/recruitment/managead/$rid/resend");
		}
		else{
		session(['details'=>$request->except('_token')]);
		if(count($request->session()->get('details',[]))>0) return redirect("/recruitment/managead/$rid/resend/step2");
		else  return redirect("/recruitment/managead/$rid/resend/step1");
		}
	}
	
	public function resendPub(Request $request,$rid){
		if($request->session()->get('details')){
		$disAd= Adjob::where('id',$rid)->get()->toArray();
		if(isset($disAd[0])){
		$disAd=$disAd[0];
		#$JobTemplate = JobTemplate::where('active','1')->get()->toArray();
		$JobTemplate=$this->rservice->roleBased(Auth::user()->role,Auth::user()->office_location,Auth::user()->secondary_office_location);
	    //print_r($JobTemplate);
		return view('recruitment.resendpub',compact('JobTemplate','disAd'));
		} else return redirect("/recruitment/managead/$rid/resend");
		}
	    else return redirect("/recruitment/managead/$rid/resend");
	}
	
	public function resendPubPost(Request $request,$rid){
		if($request->has('back') && $request->back=='back'){
			return redirect("/recruitment/managead/$rid/resend/step1");
		}else{
		if($request->jtemp!=''){
		if($request->session()->get('details')){
		session(['temp'=>$request->except('_token')]);
		#session()->forget('details');
		#session()->forget('job');
		return redirect("/recruitment/managead/$rid/resend/step3");
		}
	    else return redirect("/recruitment/managead/$rid/resend");
		}
		else{
			return redirect("/recruitment/managead/$rid/resend/step2")->with('errorMessage', 'Please select template');
		}
		}
	}
	
	public function resendJobPub(Request $request,$rid){
		
		
		if($request->session()->get('details')&& $request->session()->get('temp')){
		
		$tempDetail=JobTemplate::where([['active','1'],['id',session('temp.jtemp')]])->get()->toArray();
		$tempDetail=$tempDetail[0];
		return view('recruitment.resendjobpub',compact('tempDetail'));
		}
	    else return redirect("/recruitment/managead/$rid/resend");
	}
	
	public function resendJobPubPost(Request $request,$rid){
		if($request->has('back') && $request->back=='back'){
			return redirect("/recruitment/managead/$rid/resend/step2");
		}else{
		if($request->session()->get('details') && $request->session()->get('temp')){
		$this->rservice->resendAd(session()->all(),$rid);
		session()->forget('details');
		session()->forget('job');
		session()->forget('temp');
		return redirect('/recruitment/managead');
		}
	    else return redirect("/recruitment/managead/$rid/resend");
		}
	}
	
	//re-post----------------------------------------------------
	public function repostChange(Request $request,$rid){
		session(['job'=>'']);
		session(['details'=>'']);
		session(['temp'=>'']);
		$disAd= Adjob::where('id',$rid)->get();
		if(isset($disAd[0])) $this->authorize('views', $disAd[0]);
		$disAd=$disAd->toArray();
		if(isset($disAd[0])){
		$disAd=$disAd[0];
		$boards=Board::where('adjob_id',$rid)->get()->toArray();
		foreach($boards as $board){
			$bname[]=$board['board_name'];
		}
		$bname=isset($bname) ? $bname : [];
		//echo $vv=implode(',',$dd);
		//print_r(array_values($dd)); exit;
		return view('recruitment.repostpost',compact('disAd','bname'));
		} return redirect("/recruitment/managead");
	}	
	
	public function repostChangePost(Request $request,$rid){
		$request->validate([
		'job_board'=> 'required'
		]);
		
		session(['job'=>$request->job_board]);
		//dd(session()->all());
		//echo $rid; exit;
		if($request->session()->has('job')) return redirect("/recruitment/managead/$rid/repost/step1");
		else  return redirect("/recruitment/managead/$rid/repost");
	}	
	
	public function repostDetail(Request $request,$rid){
		session(['rno'=>'']);
		if($request->session()->get('job')){
		$disAd= Adjob::where('id',$rid)->get()->toArray();
		if(isset($disAd[0])){
		$disAd=$disAd[0];
		$boards=Board::where('adjob_id',$rid)->get()->toArray();
		foreach($boards as $board){
			$bname[]=$board['board_name'];
			$bindus[]=$board['industry'];
			$bclassi[]=$board['job_class'];
		}
		$bindus=isset($bindus) ? $bindus : [];
		$bclassi=isset($bclassi) ? $bclassi : [];
		//auto increament for Reference
		$refno=DB::select("show table status WHERE name='adjobs'");
		$refno=json_decode(json_encode($refno), true);
		$refno=$refno[0]['Auto_increment'];
		return view('recruitment.repostaddetail',compact('disAd','bindus','bclassi','refno'));
		} else  return redirect("/recruitment/managead/$rid/repost");
		}
	     else  return redirect("/recruitment/managead/$rid/repost");
		
	}
	
	public function repostDetailPost(adRequest $request,$rid){
		if($request->has('back') && $request->back=='back'){
			return redirect("/recruitment/managead/$rid/repost");
		}
		else{
		session(['details'=>$request->except('_token')]);
		if(count($request->session()->get('details',[]))>0) return redirect("/recruitment/managead/$rid/repost/step2");
		else  return redirect("/recruitment/managead/$rid/repost/step1");
		}
	}
	
	public function repostPub(Request $request,$rid){
		if($request->session()->get('details')){
		$disAd= Adjob::where('id',$rid)->get()->toArray();
		if(isset($disAd[0])){
		$disAd=$disAd[0];
		#$JobTemplate = JobTemplate::where('active','1')->get()->toArray();
		$JobTemplate=$this->rservice->roleBased(Auth::user()->role,Auth::user()->office_location,Auth::user()->secondary_office_location);
	    //print_r($JobTemplate);
		return view('recruitment.resendpub',compact('JobTemplate','disAd'));
		} else return redirect("/recruitment/managead/$rid/repost");
		}
	    else return redirect("/recruitment/managead/$rid/repost");
	}
	
	public function repostPubPost(Request $request,$rid){
		if($request->has('back') && $request->back=='back'){
			return redirect("/recruitment/managead/$rid/repost/step1");
		}else{
		if($request->jtemp!=''){
		if($request->session()->get('details')){
		session(['temp'=>$request->except('_token')]);
		#session()->forget('details');
		#session()->forget('job');
		return redirect("/recruitment/managead/$rid/repost/step3");
		}
	    else return redirect("/recruitment/managead/$rid/repost");
		}
		else{
			return redirect("/recruitment/managead/$rid/repost/step2")->with('errorMessage', 'Please select template');
		}
		}
	}
	
	public function repostJobPub(Request $request,$rid){
		
		
		if($request->session()->get('details')&& $request->session()->get('temp')){
		
		$tempDetail=JobTemplate::where([['active','1'],['id',session('temp.jtemp')]])->get()->toArray();
		$tempDetail=$tempDetail[0];
		return view('recruitment.repostjobpub',compact('tempDetail'));
		}
	    else return redirect("/recruitment/managead/$rid/repost");
	}
	
	public function repostJobPubPost(Request $request,$rid){
		if($request->has('back') && $request->back=='back'){
			return redirect("/recruitment/managead/$rid/repost/step2");
		}else{
		if($request->session()->get('details') && $request->session()->get('temp')){
		$this->rservice->repostAd(session()->all(),$rid);
		session()->forget('details');
		session()->forget('job');
		session()->forget('temp');
		return redirect('/recruitment/managead');
		}
	    else return redirect("/recruitment/managead/$rid/repost");
		}
	}
	
	
	public function displayAll(Request $request,$rid){
		
		$valUrl= request()->segment(4); 
		
		session(['rno'=>$rid]);
		
		$disAd1= $this->rservice->getValue($valUrl,$rid);
		
		if($request->ajax())
		{
			return DataTables::of($disAd1)
					->make(true);
		}
		
	
	}
	
	public function fetchJobApp(Request $request){
		
		$disAd1=[];
		$disAd1= $this->rservice->toolTips($request->emails);
		
		return $disAd1;
	}
	
	
	public function statChange(Request $request,$rid){
		
		session(['rno'=>$rid]);
		$status='';
		if($request->title==''){
		if($request->valUrl=='qual'){
		$apps = Applicant::findOrFail($request->id);
		$apps1=$apps->where([["adjob_id", $rid],["id",$request->id]])->get('status')->toArray();
		Applicant::where([["adjob_id", $rid],["id",$request->id]])->update(["status" => '2']);
		activity()
		->performedOn($apps)
		->causedBy(Auth::user())
		->withProperties(["oldstatus"=>$apps1[0]['status'],"status" => 'qualify'])
		->useLog('Applicant status change')
		->log('updated');
		$status='Status changed to Qualified';
		}
		if($request->valUrl=='poten'){
		$apps = Applicant::findOrFail($request->id);
		$apps1=$apps->where([["adjob_id", $rid],["id",$request->id]])->get('status')->toArray();
		Applicant::where([["adjob_id", $rid],["id",$request->id]])->update(["status" => '1']);
		activity()
		->performedOn($apps)
		->causedBy(Auth::user())
		->withProperties(["oldstatus"=>$apps1[0]['status'],"status" => 'potential'])
		->useLog('Applicant status change')
		->log('updated');
		$status='Status changed to Potential';
		}
	    if($request->valUrl=='stars'){
		$apps = Applicant::findOrFail($request->id);
		$apps1=$apps->where([["adjob_id", $rid],["id",$request->id]])->get('status')->toArray();
		$apps->where([["adjob_id", $rid],["id",$request->id]])->update(["status" => '3']);
		activity()
		->performedOn($apps)
		->causedBy(Auth::user())
		->withProperties(["oldstatus"=>$apps1[0]['status'],"status" => 'starr'])
		->useLog('Applicant status change')
		->log('updated');
		$activity = Activity::all()->last();
		
		$status='Status changed to Starred';;
		}
	    if($request->valUrl=='insc'){
		$apps = Applicant::findOrFail($request->id);
		$apps1=$apps->where([["adjob_id", $rid],["id",$request->id]])->get('status')->toArray();
		Applicant::where([["adjob_id", $rid],["id",$request->id]])->update(["status" => '4',"mode"=>$request->mode]);
		activity()
		->performedOn($apps)
		->causedBy(Auth::user())
		->withProperties(["oldstatus"=>$apps1[0]['status'],"status" => 'interviewschedule',"mode"=>$request->mode])
		->useLog('Applicant status change')
		->log('updated');
		$status='Status changed to Interview Scheduled';
		}
	    if($request->ids=='invites'){
		//$getStat=Applicant::where([["adjob_id", $rid],["id",$request->id]])->get()->toArray();
		//if($getStat[0]['status']=='interviewschedule'){
		//{"success":{"invite_id":"re-invite","ids":"invites","vals":"3","fname":null,"mname":null,"lname":"Tutu","pname":null,"location":null,"consultant":null,"company":null,"email":"tutu@test.com","mobile":null,"adate":null,"atime":null}}
		if($request->invite_id=='re-invite'){
			DB::connection('tracker')->table('candidates')->where([["email_address",$request->email]])->update(
			['first_name' => $request->fname, 'last_name' => $request->lname, 'registration_office'=> $request->location, 'consultant_id'=>$request->consultant, 'company'=>$request->company, 'email_address'=>$request->email,
			'mobile_number'=>$request->mobile, 'appointment_date'=>$request->adate, 'appointment_time'=>$request->atime, 'reinvite_flag'=>'1']
			);
		}
		else{
			$lastId=DB::connection('tracker')->table('candidates')->insertGetId(
			['first_name' => $request->fname, 'last_name' => $request->lname, 'registration_office'=> $request->location, 'consultant_id'=>$request->consultant, 'company'=>$request->company, 'email_address'=>$request->email,
			'mobile_number'=>$request->mobile, 'appointment_date'=>$request->adate, 'appointment_time'=>$request->atime]
			);
			
			DB::connection('tracker')->table('candidates_additional')->insert(
			['candidate_id' => $lastId, 'active_candidate' => 'Pdg' ]
			);
			
		}
		$apps = Applicant::findOrFail($request->vals);
		$apps1=$apps->where([["adjob_id", $rid],["id",$request->vals]])->get('status')->toArray();
		Applicant::where([["adjob_id", $rid],["id",$request->vals]])->update(["status" => '5']);
		activity()
		->performedOn($apps)
		->causedBy(Auth::user())
		->withProperties(["oldstatus"=>$apps1[0]['status'],"status" => 'invited'])
		->useLog('Applicant status change')
		->log('updated');
		$status=$request->all();
		//}
		//else $status='Please schedule the interview to invite';
		}
		return response()->json(['success'=>$status]);
		}
		else{
		//reverse
		
		if($request->title=='potential applicant'){	
		$apps = Applicant::findOrFail($request->id);
		$apps1=$apps->where([["adjob_id", $rid],["id",$request->id]])->get('status')->toArray();
		if($apps1[0]['status'] !='invited' && $apps1[0]['status'] !='interviewschedule'){
		Applicant::where([["adjob_id", $rid],["id",$request->id]])->update(["status" => '']);
		activity()
		->performedOn($apps)
		->causedBy(Auth::user())
		->withProperties(["oldstatus"=>$apps1[0]['status'],"status" => 'no status'])
		->useLog('Applicant status reverted')
		->log('updated');
		$status='Status reverted to no status';
		}
		else $status="Status can't be reverted since it is scheduled or invited";
		}
		if($request->title=='qualified applicant'){	
		$apps = Applicant::findOrFail($request->id);
		$apps1=$apps->where([["adjob_id", $rid],["id",$request->id]])->get('status')->toArray();
		if($apps1[0]['status'] !='invited' && $apps1[0]['status'] !='interviewschedule'){
		Applicant::where([["adjob_id", $rid],["id",$request->id]])->update(["status" => '1']);
		activity()
		->performedOn($apps)
		->causedBy(Auth::user())
		->withProperties(["oldstatus"=>$apps1[0]['status'],"status" => 'potential'])
		->useLog('Applicant status reverted')
		->log('updated');
		$status='Status reverted to potential';
		}
		else $status="Status can't be reverted since it is scheduled or invited";
		}
		
		if($request->title=='starred applicant'){	
		$apps = Applicant::findOrFail($request->id);
		$apps1=$apps->where([["adjob_id", $rid],["id",$request->id]])->get('status')->toArray();
		if($apps1[0]['status'] !='invited' && $apps1[0]['status'] !='interviewschedule'){
		Applicant::where([["adjob_id", $rid],["id",$request->id]])->update(["status" => '2']);
		activity()
		->performedOn($apps)
		->causedBy(Auth::user())
		->withProperties(["oldstatus"=>$apps1[0]['status'],"status" => 'qualified'])
		->useLog('Applicant status reverted')
		->log('updated');
		$status='Status reverted to qualified';
		}
		else $status="Status can't be reverted since it is scheduled or invited";
		}
		/*if($request->title=='interview scheduled for applicant'){	
		$apps = Applicant::findOrFail($request->id);
		$apps1=$apps->where([["adjob_id", $rid],["id",$request->id]])->get('status')->toArray();
		Applicant::where([["adjob_id", $rid],["id",$request->id]])->update(["status" => 'starr','mode'=>'']);
		activity()
		->performedOn($apps)
		->causedBy(Auth::user())
		->withProperties(["oldstatus"=>$apps1[0]['status'],"status" => 'starred'])
		->useLog('Applicant status reverted')
		->log('updated');
		$status='Status reverted to starred';
		}*/
		return response()->json(['success'=>$status]);	
		}	
	
	}
	
	public function deleteAd(Request $request,$rid){
		
		//Adjob::where("id", $rid)->update(["active" => 0]);
		$adjob=Adjob::findOrFail($rid);
		$adjob->update(["active" => 0]);
		return response()->json(['success'=>'deleted']);
	}
	
	public function locaSession(Request $request){
		session(['locations'=>'']);
		
		return session(['locations'=>$request->searchedLocation]);
		
	}
	
	public function draftIndex(Request $request){
	$draft=DB::table('drafts')->get();
	if($request->ajax())
		{
			return DataTables::of($draft)
					->addColumn('action', function($draft){
						$button ='<a href="/recruitment/managead/'.$draft->id.'/draft"
						name="edit" id="'.$draft->id.'"
						class="edit btn btn-primary btn-sm edit
						"><img src="../css/img/edit-icon.png" /></button> ';
						$button .=' <button type="button"
						name="delete" id="'.$draft->id.'"
						class="delete btn btn-danger btn-sm delete
						"><img src="../css/img/remove-icon.png" /></button>';
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
		}
		return view('recruitment/draftindex');
	}
	public function draftAdd(Request $request){
		$totref=[];
		
		
		$refno=DB::select("show table status WHERE name='adjobs'");
		$refno=json_decode(json_encode($refno), true);
		$refno=$refno[0]['Auto_increment'];
		
		$refnos=DB::table('drafts')->select('reference_no')->get();
		$refnos=json_decode(json_encode($refnos), true);

		if(!empty($refnos))
		foreach($refnos as $ref) $totref[]=$ref['reference_no'];
	    else $totref=[];
		
		if(!in_array($refno,$totref)){
		$board=implode(',',$request->boards);
		$insId=DB::table('drafts')->insertGetID(
		['board' => $board, 'reference_no' => $refno]
		);
			DB::table('drafts')
              ->where('id', $insId)
              ->update(['id' => $refno]);
		
				
		foreach($request->boards as $bor)
				$insIds=DB::table('dboards')->insert(
		['board_name' => $bor, 'adjob_id' => $refno]
		);
		
				
				
		}
		else{
			
			
			DB::table('drafts')
              ->where('reference_no', $request->refno)
			  ->update(['broadcast' => $request->broadcast, 'reference_no' => $request->refno,'job_title'=>$request->jobtitle]);
              
	
			DB::table('drafts')
              ->where('reference_no', $request->refno)
              ->update(['job_type' => $request->jobtype, 'job_time'=> $request->jobtime, 'bp1'=>$request->bp1, 'bp2'=>$request->bp2, 'bp3'=>$request->bp3, 'sdate'=>$request->sdate, 'edate'=>$request->edate ]);
	
			$boards=DB::table('dboards')->where('adjob_id', $request->refno)->get();
			$boards=json_decode(json_encode($boards), true);
			
			foreach($boards as $boardup){
				$jobi=$boardup['board_name'].'industry';
				$jobc=$boardup['board_name'].'classi';
			
			DB::table('dboards')->where([['adjob_id',$boardup['adjob_id']],['id',$boardup['id']]])->update(
			  ['board_name'=>$boardup['board_name'],
			  'industry'=>$request->$jobi,
			  'job_class'=> $request->$jobc
			  ]
			);
			
			}
			
			
			DB::table('drafts')
              ->where('reference_no', $request->refno)
              ->update(['currency' => $request->salary, 'min'=> $request->min, 'max'=>$request->max, 'salary_per'=>$request->stype, 'salary_desc'=>$request->sdesc, 'hide_salary'=>$request->hides]);
	
			
			DB::table('drafts')
              ->where('reference_no', $request->refno)
              ->update(['job_requirement' => $request->jdesc, 'min_exp'=> $request->mexp, 'edu_level'=>$request->elevel, 'local_resident'=>$request->lresi, 'work_permission'=>$request->work_permissions]);

			DB::table('drafts')
              ->where('reference_no', $request->refno)
			  ->update(['location' => $request->location, 'postcode' => $request->pcode]);
			  
			DB::table('drafts')
              ->where('reference_no', $request->refno)
			  ->update(['video_url' => $request->vurl, 'video_pos' => $request->vid_pos]);
			  
			DB::table('drafts')
              ->where('reference_no', $request->refno)
			  ->update(['job_summary' => $request->jsum, 'detail_job_summary' => $request->djob]);
			  
			DB::table('drafts')
              ->where('reference_no', $request->refno)
			  ->update(['job_template' => session('temp.jtemp')]);
              
		}
	
	}
	
	
	public function draftChange(Request $request,$rid){
		session(['job'=>'']);
		session(['details'=>'']);
		session(['temp'=>'']);
		$disAd= DB::table('drafts')->where('id',$rid)->get();
		$disAd=json_decode(json_encode($disAd), true);
		//if(isset($disAd[0])) $this->authorize('views', $disAd[0]);
		//$disAd=$disAd->toArray();
		if(isset($disAd[0])){
		$disAd=$disAd[0];
		$boards=DB::table('dboards')->where('adjob_id',$rid)->get();
		$boards=json_decode(json_encode($boards), true);
		foreach($boards as $board){
			$bname[]=$board['board_name'];
		}
		$bname=isset($bname) ? $bname : [];
		//echo $vv=implode(',',$dd);
		//print_r(array_values($dd)); exit;
		return view('recruitment.draftpost',compact('disAd','bname'));
		} return redirect("/recruitment/draft");
	}	
	
	public function draftChangePost(Request $request,$rid){
		$request->validate([
		'job_board'=> 'required'
		]);
		
		session(['job'=>$request->job_board]);
		//dd(session()->all());
		//echo $rid; exit;
		if($request->session()->has('job')) return redirect("/recruitment/managead/$rid/draft/step1");
		else  return redirect("/recruitment/managead/$rid/draft");
	}	
	
	public function draftDetail(Request $request,$rid){
		session(['rno'=>'']);
		if($request->session()->get('job')){
		$disAd= DB::table('drafts')->where('id',$rid)->get();
		$disAd=json_decode(json_encode($disAd), true);
		if(isset($disAd[0])){
		$disAd=$disAd[0];
		$boards=DB::table('dboards')->where('adjob_id',$rid)->get();
		$boards=json_decode(json_encode($boards), true);
		foreach($boards as $board){
			$bname[]=$board['board_name'];
			$bindus[]=$board['industry'];
			$bclassi[]=$board['job_class'];
		}
		$bindus=isset($bindus) ? $bindus : [];
		$bclassi=isset($bclassi) ? $bclassi : [];
		//auto increament for Reference
		$refno=DB::select("show table status WHERE name='adjobs'");
		$refno=json_decode(json_encode($refno), true);
		$refno=$refno[0]['Auto_increment'];
		return view('recruitment.draftaddetail',compact('disAd','bindus','bclassi','refno'));
		} else  return redirect("/recruitment/managead/$rid/draft");
		}
	     else  return redirect("/recruitment/managead/$rid/draft");
		
	}
	
	public function draftDetailPost(adRequest $request,$rid){
		if($request->has('back') && $request->back=='back'){
			return redirect("/recruitment/managead/$rid/draft");
		}
		else{
		session(['details'=>$request->except('_token')]);
		if(count($request->session()->get('details',[]))>0) return redirect("/recruitment/managead/$rid/draft/step2");
		else  return redirect("/recruitment/managead/$rid/draft/step1");
		}
	}
	
	public function draftPub(Request $request,$rid){
		if($request->session()->get('details')){
		$disAd= DB::table('drafts')->where('id',$rid)->get();
		$disAd=json_decode(json_encode($disAd), true);
		if(isset($disAd[0])){
		$disAd=$disAd[0];
		#$JobTemplate = JobTemplate::where('active','1')->get()->toArray();
		$JobTemplate=$this->rservice->roleBased(Auth::user()->role,Auth::user()->office_location,Auth::user()->secondary_office_location);
	    //print_r($JobTemplate);
		return view('recruitment.draftpub',compact('JobTemplate','disAd'));
		} else return redirect("/recruitment/managead/$rid/draft");
		}
	    else return redirect("/recruitment/managead/$rid/draft");
	}
	
	public function draftPubPost(Request $request,$rid){
		if($request->has('back') && $request->back=='back'){
			return redirect("/recruitment/managead/$rid/draft/step1");
		}else{
		if($request->jtemp!=''){
		if($request->session()->get('details')){
		session(['temp'=>$request->except('_token')]);
		#session()->forget('details');
		#session()->forget('job');
		return redirect("/recruitment/managead/$rid/draft/step3");
		}
	    else return redirect("/recruitment/managead/$rid/draft");
		}
		else{
			return redirect("/recruitment/managead/$rid/draft/step2")->with('errorMessage', 'Please select template');
		}
		}
	}
	
	public function draftJobPub(Request $request,$rid){
		
		
		if($request->session()->get('details')&& $request->session()->get('temp')){
		
		$tempDetail=JobTemplate::where([['active','1'],['id',session('temp.jtemp')]])->get()->toArray();
		$tempDetail=$tempDetail[0];
		return view('recruitment.draftjobpub',compact('tempDetail'));
		}
	    else return redirect("/recruitment/managead/$rid/draft");
	}
	
	public function draftJobPubPost(Request $request,$rid){
		if($request->has('back') && $request->back=='back'){
			return redirect("/recruitment/managead/$rid/draft/step2");
		}else{
		if($request->session()->get('details') && $request->session()->get('temp')){
		$this->rservice->resendAd(session()->all(),$rid);
		session()->forget('details');
		session()->forget('job');
		session()->forget('temp');
		return redirect('/recruitment/managead');
		}
	    else return redirect("/recruitment/managead/$rid/draft");
		}
	}
	
	public function scheduler(Request $request){
		return view('recruitment.inscheduler');
	}
	
	public function bRules(Request $request){
		return view('brules');
	}
	
	
}
