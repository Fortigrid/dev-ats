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

class AdController extends Controller
{
	
	protected $rservice;
	public function __construct(RecruitService $rservice)
    {
        $this->middleware('auth');
		$this->rservice=$rservice;
    }
	public function recruit(){
		session()->forget('job');
		session()->forget('details');
		session()->forget('temp');
		//Cache::forget('users');
		return view('recruitment.index');
	}
    public function adIndex(Request $request){
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
		
		if($request->session()->get('job'))
		return view('recruitment.addetail');
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
		
		if($request->session()->get('details') && $request->session()->get('temp')){
		$this->rservice->addAd(session()->all());
		session()->forget('details');
		session()->forget('job');
		session()->forget('temp');
		return redirect('/recruitment/managead');
		}
	    else return redirect('/recruitment/adpost');
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
		if($request->ids=='liveads'){
			if(Auth::user()->role=='admin')
			#$ads= Adjob::with('applicants')->where('active','1')->latest('id')->get();
		    $ads= Adjob::select([
				'adjobs.id',
				\DB::raw('count(applicants.adjob_id) as response'),
				'adjobs.post_date',
				'adjobs.job_title',
				'adjobs.created_by'])
				->leftJoin('applicants', 'adjobs.id', 'applicants.adjob_id')
				->where([['adjobs.active',1]])
				->groupBy('applicants.adjob_id','adjobs.id')
				->get();
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
					
						$query->orWhere('acusers.secondary_office_location','like', '%' . $exp1 . '%');
					}
				})
				->where([['adjobs.active',1]])
				->groupBy('applicants.adjob_id','adjobs.id')
				->get();
			}
		}
		else {
			if(Auth::user()->role=='admin')
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
					
						$query->orWhere('acusers.secondary_office_location','like', '%' . $exp1 . '%');
					}
				})
				->where([['adjobs.active',0]])
				->groupBy('applicants.adjob_id','adjobs.id')
				->get();
				
			}
		}
		if($request->adid !=''){
		$aps= Board::where('adjob_id',$request->adid)->get();
		//print_r($aps); exit;
		return response()->json($aps);
		}
		
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
		//role based restriction
		if(isset($disAd[0])) $this->authorize('views', $disAd[0]);
		//Auth::user()->can('views',$disAd[0]);
		$disAd=$disAd->toArray();
		if(isset($disAd[0])){
		$disAd=$disAd[0];
		if($disAd['active']=='1') $act=1; else $act='0';
		return view('recruitment.displaypost',compact('disAd','childPost','act'));
		}
		else return redirect('/recruitment/managead');
	
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
		
		if($request->session()->get('details') && $request->session()->get('temp')){
		$this->rservice->editAd(session()->all(),$rid);
		session()->forget('details');
		session()->forget('job');
		session()->forget('temp');
		return redirect('/recruitment/managead');
		}
	    else return redirect("/recruitment/managead/$rid/edit");
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
		return view('recruitment.resendaddetail',compact('disAd','bindus','bclassi'));
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
		
		if($request->session()->get('details') && $request->session()->get('temp')){
		$this->rservice->resendAd(session()->all(),$rid);
		session()->forget('details');
		session()->forget('job');
		session()->forget('temp');
		return redirect('/recruitment/managead');
		}
	    else return redirect("/recruitment/managead/$rid/resend");
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
		return view('recruitment.repostaddetail',compact('disAd','bindus','bclassi'));
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
		
		if($request->session()->get('details') && $request->session()->get('temp')){
		$this->rservice->repostAd(session()->all(),$rid);
		session()->forget('details');
		session()->forget('job');
		session()->forget('temp');
		return redirect('/recruitment/managead');
		}
	    else return redirect("/recruitment/managead/$rid/repost");
	}
	
	
	public function displayAll(Request $request,$rid){
		
		$valUrl= request()->segment(4); 
		
		session(['rno'=>$rid]);
		
		$disAd1= $this->rservice->getValue($valUrl,$rid);
		
		if($request->ajax())
		{
			return DataTables::of($disAd1)
					->addColumn('action', function($disAd1){
						$button ='<button type="button"
						name="edit" id="'.$disAd1->id.'"
						class="edit btn btn-primary btn-sm edit
						">Eligible</button> ';
					
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
		}
		
	
	}
	
	
	public function statChange(Request $request,$rid){
		
		session(['rno'=>$rid]);
		$status='';
		if($request->valUrl=='qual'){
		$apps = Applicant::findOrFail($request->id);
		$apps1=$apps->where([["adjob_id", $rid],["id",$request->id]])->get('status')->toArray();
		Applicant::where([["adjob_id", $rid],["id",$request->id]])->update(["status" => 'qualify']);
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
		Applicant::where([["adjob_id", $rid],["id",$request->id]])->update(["status" => 'potential']);
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
		$apps->where([["adjob_id", $rid]])->update(["status" => 'starr']);
		activity()
		->performedOn($apps)
		->causedBy(Auth::user())
		->withProperties(["oldstatus"=>$apps1[0]['status'],"status" => 'starr'])
		->useLog('Applicant status change')
		->log('updated');
		$activity = Activity::all()->last();
		
		$status=$activity->changes;
		}
	    if($request->valUrl=='insc'){
		$apps = Applicant::findOrFail($request->id);
		$apps1=$apps->where([["adjob_id", $rid],["id",$request->id]])->get('status')->toArray();
		Applicant::where([["adjob_id", $rid],["id",$request->id]])->update(["status" => 'inteviewschedule',"mode"=>$request->mode]);
		activity()
		->performedOn($apps)
		->causedBy(Auth::user())
		->withProperties(["oldstatus"=>$apps1[0]['status'],"status" => 'inteviewschedule',"mode"=>$request->mode])
		->useLog('Applicant status change')
		->log('updated');
		$status='Status changed to Interview Scheduled';
		}
	    if($request->valUrl=='invites'){
		$getStat=Applicant::where([["adjob_id", $rid],["id",$request->id]])->get()->toArray();
		if($getStat[0]['status']=='inteviewschedule'){
		$apps = Applicant::findOrFail($request->id);
		$apps1=$apps->where([["adjob_id", $rid],["id",$request->id]])->get('status')->toArray();
		Applicant::where([["adjob_id", $rid],["id",$request->id]])->update(["status" => 'invited']);
		activity()
		->performedOn($apps)
		->causedBy(Auth::user())
		->withProperties(["oldstatus"=>$apps1[0]['status'],"status" => 'invited'])
		->useLog('Applicant status change')
		->log('updated');
		$status='Status changed to Invited';
		}
		else $status='Please schedule the interview to invite';
		}
		return response()->json(['success'=>$status]);
	
	}
	
	public function deleteAd(Request $request,$rid){
		
		//Adjob::where("id", $rid)->update(["active" => 0]);
		$adjob=Adjob::findOrFail($rid);
		$adjob->update(["active" => 0]);
		return response()->json(['success'=>'deleted']);
	}
	
	
}
