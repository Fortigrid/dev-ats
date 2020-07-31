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

class AdController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	public function recruit(){
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
		
		session(['details'=>$request->except('_token')]);
		if(count($request->session()->get('details',[]))>0) return redirect('/recruitment/adpost/2');
		else  return redirect('/recruitment/adpost/1');
	}
	public function previewPub(Request $request){
		//dd(session()->all());
		if($request->session()->get('details')){
		$JobTemplate = JobTemplate::where('active','1')->get()->toArray();
	    //print_r($JobTemplate);
		return view('recruitment.previewpub',compact('JobTemplate'));
		}
	    else return redirect('/recruitment/adpost');
		
	}
	public function previewPubPost(Request $request){
		//dd(session()->all());
		//session(['details'=>$request->except('_token')]);
		//echo session('job.0'); #for job
		//dd(session()->all());
		$request->validate([
		'jtemp'=> 'required',
		
		]);
		if($request->session()->get('details')){
		session(['temp'=>$request->except('_token')]);
		#session()->forget('details');
		#session()->forget('job');
		return redirect('/recruitment/adpost/3');
		}
	    else return redirect('/recruitment/adpost');
		
	}
	public function jobPub(Request $request){
		if($request->session()->get('details')&& $request->session()->get('temp')){
		
		$tempDetail=JobTemplate::where([['active','1'],['template_name',session('temp.jtemp')]])->get()->toArray();
		$tempDetail=$tempDetail[0];
		return view('recruitment.jobpub',compact('tempDetail'));
		}
	    else return redirect('/recruitment/adpost');
	}
	public function jobPubPost(Request $request){
		
		if($request->session()->get('details') && $request->session()->get('temp')){
		 $data = [
        'broadcast'                   => session('details.broadcast')??'',
        'reference_no'                  => session('details.refno')??'', 
        'job_title'               => session('details.jobtitle')??'',
        'job_type'              => session('details.jobtype')??'',
		'job_time'              => session('details.jobtime')??'',
		'bp1'              		=> session('details.bp1')??'',
		'bp2'              => session('details.bp2')??'',
		'bp3'              => session('details.bp3')??'',
		'sdate'              => session('details.sdate')??'',
		'edate'              => session('details.edate')??'',
		'board'              => '',
		'industry'              => '',
		'job_class'              => '',
		'currency'              => session('details.salary')??'',
		'min'              => session('details.min')??'',
		'max'              => session('details.max')??'',
		'salary_per'              => session('details.stype')??'',
		'salary_desc'              => session('details.sdesc')??'',
		'hide_salary'              => session('details.hides')??'',
		'job_requirement'              => session('details.jdesc')??'',
		'min_exp'              => session('details.mexp')??'',
		'edu_level'              => session('details.elevel')??'',
		'local_resident'              => session('details.lresi')??'',
		'location'              => session('details.location')??'',
		'postcode'              => session('details.pcode')??'',
		'video_url'              => session('details.vurl')??'',
		'job_summary'              => session('details.jsum')??'',
		'detail_job_summary'              => session('details.djob')??'',
		'location_city'              => '',
        'job_template'              => session('temp.jtemp')??'',
		'post_time'              => session('temp.posttime')??'',
		'contact_email'              => '',
		'contact_phone'              => '',
		'cost'              => '',
		'created_by'              => Auth::user()->id
		];
		$adjob=Adjob::create($data);
		foreach(session('job') as $job){
			
			$jobi=$job.'industry';
			$jobc=$job.'classi';
			#echo $adjob->id.'test'.$job.'test1'.session("details.$jobi").session("details.$jobc");
			
			$datas[]=[
			  'adjob_id'=>$adjob->id,
			  'board_name'=>$job,
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc")
			];
		}
		
		Board::insert($datas);
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
		$disAd= Adjob::where('id',$rid)->get()->toArray();
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
		$disAd=$disAd[0];
		$boards=Board::where('adjob_id',$rid)->get()->toArray();
		foreach($boards as $board){
			$bname[]=$board['board_name'];
		}
		$bname=isset($bname) ? $bname : [];
		//echo $vv=implode(',',$dd);
		//print_r(array_values($dd)); exit;
		return view('recruitment.editpost',compact('disAd','bname'));
	}	
	
	public function editChangePost(Request $request,$rid){
		$request->validate([
		'job_board'=> 'required'
		]);
		
		session(['job'=>$request->job_board]);
		//dd(session()->all());
		//echo $rid; exit;
		if($request->session()->has('job')) return redirect("/recruitment/managead/$rid/edit/step1");
		else  return redirect("/recruitment/managead/$rid/edit");
	}	
	
	public function editDetail(Request $request,$rid){
		session(['rno'=>$rid]);
		if($request->session()->get('job')){
		$disAd= Adjob::where('id',$rid)->get()->toArray();
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
		}
	     else  return redirect("/recruitment/managead/$rid/edit");
		
	}
	
	public function editDetailPost(adRequest $request,$rid){
		session(['details'=>$request->except('_token')]);
		if(count($request->session()->get('details',[]))>0) return redirect("/recruitment/managead/$rid/edit/step2");
		else  return redirect("/recruitment/managead/$rid/edit/step1");
		
	}
	
	public function editPub(Request $request,$rid){
		if($request->session()->get('details')){
		$disAd= Adjob::where('id',$rid)->get()->toArray();
		$disAd=$disAd[0];
		$JobTemplate = JobTemplate::where('active','1')->get()->toArray();
	    //print_r($JobTemplate);
		return view('recruitment.editpub',compact('JobTemplate','disAd'));
		}
	    else return redirect("/recruitment/managead/$rid/edit");
	}
	
	public function editPubPost(Request $request,$rid){
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
	
	public function editJobPub(Request $request,$rid){
		
		
		if($request->session()->get('details')&& $request->session()->get('temp')){
		
		$tempDetail=JobTemplate::where([['active','1'],['template_name',session('temp.jtemp')]])->get()->toArray();
		$tempDetail=$tempDetail[0];
		return view('recruitment.editjobpub',compact('tempDetail'));
		}
	    else return redirect("/recruitment/managead/$rid/edit");
	}
	
	public function editJobPubPost(Request $request,$rid){
		
		if($request->session()->get('details') && $request->session()->get('temp')){
		 $data = [
        'broadcast'                   => session('details.broadcast')??'',
        'reference_no'                  => session('details.refno')??'', 
        'job_title'               => session('details.jobtitle')??'',
        'job_type'              => session('details.jobtype')??'',
		'job_time'              => session('details.jobtime')??'',
		'bp1'              		=> session('details.bp1')??'',
		'bp2'              => session('details.bp2')??'',
		'bp3'              => session('details.bp3')??'',
		'sdate'              => session('details.sdate')??'',
		'edate'              => session('details.edate')??'',
		'board'              => '',
		'industry'              => '',
		'job_class'              => '',
		'currency'              => session('details.salary')??'',
		'min'              => session('details.min')??'',
		'max'              => session('details.max')??'',
		'salary_per'              => session('details.stype')??'',
		'salary_desc'              => session('details.sdesc')??'',
		'hide_salary'              => session('details.hides')??'',
		'job_requirement'              => session('details.jdesc')??'',
		'min_exp'              => session('details.mexp')??'',
		'edu_level'              => session('details.elevel')??'',
		'local_resident'              => session('details.lresi')??'',
		'location'              => session('details.location')??'',
		'postcode'              => session('details.pcode')??'',
		'video_url'              => session('details.vurl')??'',
		'job_summary'              => session('details.jsum')??'',
		'detail_job_summary'              => session('details.djob')??'',
		'location_city'              => '',
        'job_template'              => session('temp.jtemp')??'',
		'post_time'              => session('temp.posttime')??'',
		'contact_email'              => '',
		'contact_phone'              => '',
		'cost'              => ''
		];
		
		$adjob=Adjob::where('id',$rid)->update($data);
		
		$bod=Board::where('adjob_id',$rid)->get()->toArray();
		foreach($bod as $jobs){
			$bb[]=$jobs['board_name'];
		}
		
		$cc=array_diff(session('job'),$bb);
		if(count($cc)>0)
		{
		foreach($cc as $job){
		$jobi=$job.'industry';
			$jobc=$job.'classi';
			#echo $adjob->id.'test'.$job.'test1'.session("details.$jobi").session("details.$jobc");
			
			$datas[]=[
			  'adjob_id'=>$rid,
			  'board_name'=>$job,
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc")
			];
		}
		
		Board::insert($datas);
		}
		foreach($bod as $job){
			
			$jobi=$job['board_name'].'industry';
			$jobc=$job['board_name'].'classi';
			#echo $adjob->id.'test'.$job.'test1'.session("details.$jobi").session("details.$jobc");
			
			/*$datas[]=[
			  'board_name'=>$job,
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc")
			];*/
			
			Board::where([['adjob_id',$rid],['id',$job['id']]])->update(
			  ['board_name'=>$job['board_name'],
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc")]
			);
		}
		Board::where([['adjob_id',$rid],['industry','']])->delete();
		
		#Board::insert($datas);
		#$udata = collect($datas); 
		#Board::where('adjob_id',$rid)->update($udata);
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
		$disAd=$disAd[0];
		$boards=Board::where('adjob_id',$rid)->get()->toArray();
		foreach($boards as $board){
			$bname[]=$board['board_name'];
		}
		$bname=isset($bname) ? $bname : [];
		//echo $vv=implode(',',$dd);
		//print_r(array_values($dd)); exit;
		return view('recruitment.resendpost',compact('disAd','bname'));
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
		}
	     else  return redirect("/recruitment/managead/$rid/resend");
		
	}
	
	public function resendDetailPost(adRequest $request,$rid){
		session(['details'=>$request->except('_token')]);
		if(count($request->session()->get('details',[]))>0) return redirect("/recruitment/managead/$rid/resend/step2");
		else  return redirect("/recruitment/managead/$rid/resend/step1");
		
	}
	
	public function resendPub(Request $request,$rid){
		if($request->session()->get('details')){
		$disAd= Adjob::where('id',$rid)->get()->toArray();
		$disAd=$disAd[0];
		$JobTemplate = JobTemplate::where('active','1')->get()->toArray();
	    //print_r($JobTemplate);
		return view('recruitment.resendpub',compact('JobTemplate','disAd'));
		}
	    else return redirect("/recruitment/managead/$rid/resend");
	}
	
	public function resendPubPost(Request $request,$rid){
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
	
	public function resendJobPub(Request $request,$rid){
		
		
		if($request->session()->get('details')&& $request->session()->get('temp')){
		
		$tempDetail=JobTemplate::where([['active','1'],['template_name',session('temp.jtemp')]])->get()->toArray();
		$tempDetail=$tempDetail[0];
		return view('recruitment.resendjobpub',compact('tempDetail'));
		}
	    else return redirect("/recruitment/managead/$rid/resend");
	}
	
	public function resendJobPubPost(Request $request,$rid){
		
		if($request->session()->get('details') && $request->session()->get('temp')){
		 $data = [
        'broadcast'                   => session('details.broadcast')??'',
        'reference_no'                  => session('details.refno')??'', 
        'job_title'               => session('details.jobtitle')??'',
        'job_type'              => session('details.jobtype')??'',
		'job_time'              => session('details.jobtime')??'',
		'bp1'              		=> session('details.bp1')??'',
		'bp2'              => session('details.bp2')??'',
		'bp3'              => session('details.bp3')??'',
		'sdate'              => session('details.sdate')??'',
		'edate'              => session('details.edate')??'',
		'board'              => '',
		'industry'              => '',
		'job_class'              => '',
		'currency'              => session('details.salary')??'',
		'min'              => session('details.min')??'',
		'max'              => session('details.max')??'',
		'salary_per'              => session('details.stype')??'',
		'salary_desc'              => session('details.sdesc')??'',
		'hide_salary'              => session('details.hides')??'',
		'job_requirement'              => session('details.jdesc')??'',
		'min_exp'              => session('details.mexp')??'',
		'edu_level'              => session('details.elevel')??'',
		'local_resident'              => session('details.lresi')??'',
		'location'              => session('details.location')??'',
		'postcode'              => session('details.pcode')??'',
		'video_url'              => session('details.vurl')??'',
		'job_summary'              => session('details.jsum')??'',
		'detail_job_summary'              => session('details.djob')??'',
		'location_city'              => '',
        'job_template'              => session('temp.jtemp')??'',
		'post_time'              => session('temp.posttime')??'',
		'contact_email'              => '',
		'contact_phone'              => '',
		'cost'              => '',
		'created_by'              => Auth::user()->id
		];
		
		$adjob=Adjob::create($data);
		foreach(session('job') as $job){
			
			$jobi=$job.'industry';
			$jobc=$job.'classi';
			#echo $adjob->id.'test'.$job.'test1'.session("details.$jobi").session("details.$jobc");
			
			$datas[]=[
			  'adjob_id'=>$adjob->id,
			  'board_name'=>$job,
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc")
			];
		}
		
		Board::insert($datas);
		
		$bod=Board::where('adjob_id',$adjob->id)->get()->toArray();
		foreach($bod as $jobs){
			$bb[]=$jobs['board_name'];
		}
		
		$cc=array_diff(session('job'),$bb);
		if(count($cc)>0)
		{
		foreach($cc as $job){
		$jobi=$job.'industry';
			$jobc=$job.'classi';
			#echo $adjob->id.'test'.$job.'test1'.session("details.$jobi").session("details.$jobc");
			
			$datas[]=[
			  'adjob_id'=>$rid,
			  'board_name'=>$job,
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc")
			];
		}
		
		Board::insert($datas);
		}
		foreach($bod as $job){
			
			$jobi=$job['board_name'].'industry';
			$jobc=$job['board_name'].'classi';
			#echo $adjob->id.'test'.$job.'test1'.session("details.$jobi").session("details.$jobc");
			
			/*$datas[]=[
			  'board_name'=>$job,
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc")
			];*/
			
			Board::where([['adjob_id',$adjob->id],['id',$job['id']]])->update(
			  ['board_name'=>$job['board_name'],
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc")]
			);
		}
		Board::where([['adjob_id',$adjob->id],['industry','']])->delete();
		
		#Board::insert($datas);
		#$udata = collect($datas); 
		#Board::where('adjob_id',$rid)->update($udata);
		session()->forget('details');
		session()->forget('job');
		session()->forget('temp');
		return redirect('/recruitment/managead');
		}
	    else return redirect("/recruitment/managead/$rid/resend");
	}
	
	
	
	
	public function getValue($val,$rid){
		
		if($val=='all') return Applicant::with('adjob')->where('adjob_id',$rid)->latest('id')->get();
		if($val=='qual') return Applicant::with('adjob')->where('adjob_id',$rid)->whereIn('status', ['qualify', 'potential', 'starr', 'inteviewschedule', 'invited'])->latest('id')->get();
		if($val=='star') return Applicant::with('adjob')->where('adjob_id',$rid)->whereIn('status', [ 'starr', 'inteviewschedule', 'invited'])->latest('id')->get();
		if($val=='invite') return Applicant::with('adjob')->where('adjob_id',$rid)->whereIn('status', ['invited'])->latest('id')->get();
	}
	
	
	public function displayAll(Request $request,$rid){
		
		$valUrl= request()->segment(4); 
		
		session(['rno'=>$rid]);
		
		$disAd1= $this->getValue($valUrl,$rid);
		
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
		//return view('recruitment.displayall',compact('disAd'));
	
	}
	
	/*public function displayQual(Request $request,$rid){
		
		session(['rno'=>$rid]);
		
		$disAd1= Applicant::with('adjob')->where('adjob_id',$rid)->whereIn('status', ['qualify', 'potential'])->get();
		
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
		//return view('recruitment.displayall',compact('disAd'));
	
	}*/
	
	public function statChange(Request $request,$rid){
		
		session(['rno'=>$rid]);
		
		if($request->valUrl=='qual'){
		Applicant::where([["adjob_id", $rid],["id",$request->id]])->update(["status" => 'qualify']);
		}
		if($request->valUrl=='poten'){
		Applicant::where([["adjob_id", $rid],["id",$request->id]])->update(["status" => 'potential']);
		}
	    if($request->valUrl=='stars'){
		Applicant::where([["adjob_id", $rid],["id",$request->id]])->update(["status" => 'starr']);
		}
	    if($request->valUrl=='insc'){
		Applicant::where([["adjob_id", $rid],["id",$request->id]])->update(["status" => 'inteviewschedule']);
		}
	    if($request->valUrl=='invites'){
		Applicant::where([["adjob_id", $rid],["id",$request->id]])->update(["status" => 'invited']);
		}
		return response()->json(['success'=>'Updated']);
	
	}
	
	public function deleteAd(Request $request,$rid){
		
		Adjob::where("id", $rid)->update(["active" => 0]);
		return response()->json(['success'=>'deleted']);
	}
	
	
}
