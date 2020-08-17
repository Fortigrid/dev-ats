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
		return view('recruitment.index');
	}
    public function adIndex(Request $request){
		session(['job'=>'']);
		session(['details'=>'']);
		session(['temp'=>'']);
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
	   $ads= Adjob::with('applicants')->where('active','1')->latest('id')->get();
	  
	   
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
		if($request->ids=='liveads'){
			$ads= Adjob::with('applicants')->where('active','1')->latest('id')->get();
		}
		else $ads= Adjob::with('applicants')->where('active','0')->latest('id')->get();
		
		if($request->adid !=''){
		$aps= Board::where('adjob_id',$request->adid)->get();
		//print_r($aps); exit;
		return response()->json($aps);
		}
		
		if($request->deleids !=''){
		$request->deleids=explode(',',$request->deleids);
		$delad= Adjob::whereIn('id',$request->deleids)->update(['active'=>0]);
		
		return response()->json('deleted');
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
		//$disAd= Adjob::where([['id',$rid],['active','1']])->get()->toArray();
		$disAd= Adjob::where('id',$rid)->take(1)->get();
		//role based restriction
		if(isset($disAd[0])) $this->authorize('views', $disAd[0]);
		//Auth::user()->can('views',$disAd[0]);
		$disAd=$disAd->toArray();
		if(isset($disAd[0])){
		$disAd=$disAd[0];
		
		return view('recruitment.displaypost',compact('disAd'));
		}
		else return redirect('/recruitment/managead');
	
	}
	
	public function editChange(Request $request,$rid){
		session(['job'=>'']);
		session(['details'=>'']);
		session(['temp'=>'']);
		$disAd= Adjob::where('id',$rid)->get()->toArray();
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
	
	
	
	public function resendChange(Request $request,$rid){
		session(['job'=>'']);
		session(['details'=>'']);
		session(['temp'=>'']);
		$disAd= Adjob::where('id',$rid)->get()->toArray();
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
		Applicant::where([["adjob_id", $rid],["id",$request->id]])->update(["status" => 'qualify']);
		$status='Status changed to Qualify';
		}
		if($request->valUrl=='poten'){
		Applicant::where([["adjob_id", $rid],["id",$request->id]])->update(["status" => 'potential']);
		$status='Status changed to Potential';
		}
	    if($request->valUrl=='stars'){
		Applicant::where([["adjob_id", $rid],["id",$request->id]])->update(["status" => 'starr']);
		$status='Status changed to Starred';
		}
	    if($request->valUrl=='insc'){
		Applicant::where([["adjob_id", $rid],["id",$request->id]])->update(["status" => 'inteviewschedule',"mode"=>$request->mode]);
		$status='Status changed to Interview Scheduled';
		}
	    if($request->valUrl=='invites'){
		$getStat=Applicant::where([["adjob_id", $rid],["id",$request->id]])->get()->toArray();
		if($getStat[0]['status']=='inteviewschedule'){
		Applicant::where([["adjob_id", $rid],["id",$request->id]])->update(["status" => 'invited']);
		$status='Status changed to Invited';
		}
		else $status='Please schedule the interview to invite';
		}
		return response()->json(['success'=>$status]);
	
	}
	
	public function deleteAd(Request $request,$rid){
		
		Adjob::where("id", $rid)->update(["active" => 0]);
		return response()->json(['success'=>'deleted']);
	}
	
	
}
