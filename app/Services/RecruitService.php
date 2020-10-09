<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Adjob;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Applicant;
use App\JobTemplate;
use App\Board;
use App\User;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;
use DB;
use Illuminate\Support\Facades\Cache;

class RecruitService
{
	use LogsActivity, CausesActivity;
    protected $data;
   
	
	public function addAd($vals)
	{
		
		$data = [
        'broadcast'               	=> $vals['details']['broadcast']??'',
        'reference_no'            	=> $vals['details']['refno']??'', 
        'job_title'               	=> $vals['details']['jobtitle']??'',
        'job_type'              	=> $vals['details']['jobtype']??'',
		'job_time'              	=> $vals['details']['jobtime']??'',
		'bp1'              			=> $vals['details']['bp1']??'',
		'bp2'              			=> $vals['details']['bp2']??'',
		'bp3'              			=> $vals['details']['bp3']??'',
		'sdate'              		=> $vals['details']['sdate'],
		'edate'              		=> $vals['details']['edate'],
		'board'              		=> '',
		'industry'              	=> '',
		'job_class'              	=> '',
		'currency'              	=> $vals['details']['salary']??'',
		'min'              			=> $vals['details']['min']??'',
		'max'              			=> $vals['details']['max']??'',
		'salary_per'              	=> $vals['details']['stype']??'',
		'salary_desc'              	=> $vals['details']['sdesc']??'',
		'hide_salary'              	=> $vals['details']['hides']??'',
		'job_requirement'           => $vals['details']['jdesc']??'',
		'min_exp'              		=> $vals['details']['mexp']??'',
		'edu_level'              	=> $vals['details']['elevel']??'',
		'local_resident'            => $vals['details']['lresi']??'',
		'work_permission'           => $vals['details']['work_permissions']??'',
		'location'              	=> $vals['details']['location']??'',
		'postcode'              	=> $vals['details']['pcode']??'',
		'video_url'              	=> $vals['details']['vurl']??'',
		'video_pos'              	=> $vals['details']['vid_pos']??'',
		'job_summary'              	=> $vals['details']['jsum']??'',
		'detail_job_summary'        => $vals['details']['djob']??'',
		'location_city'             => '',
        'job_template'              => $vals['temp']['jtemp']??'',
		'post_time'              	=> $vals['temp']['posttime']??'',
		'post_date'              	=> $vals['temp']['posttime1']??'',
		'contact_email'             => '',
		'contact_phone'             => '',
		'cost'              		=> '',
		'created_by'              	=> Auth::user()->id
		];
		$adjob=Adjob::create($data);
		//reference no
		$adjob->where("id", $adjob->id)->update(["reference_no" => $adjob->id]);
		//expiry date
		
		
		foreach($vals['job'] as $job){
			$jobi=$job.'industry';
			$jobc=$job.'classi';
			#echo $adjob->id.'test'.$job.'test1'.session("details.$jobi").session("details.$jobc");
			$exdate = '';
			if($job=='Adjuna') $exdate = date('Y-m-d', strtotime("+30 day", strtotime($vals['temp']['posttime1'])));
			if($job=='Jora') $exdate = date('Y-m-d', strtotime("+20 day", strtotime($vals['temp']['posttime1'])));
			if($job=='Seek') $exdate = date('Y-m-d', strtotime("+15 day", strtotime($vals['temp']['posttime1'])));
			$datas[]=[
			  'adjob_id'=>$adjob->id,
			  'board_name'=>$job,
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc"),
			  'expiry_date'=>$exdate
			];
		}
		
		Board::insert($datas);
		activity()
		->performedOn($adjob)
		->causedBy(Auth::user())
		->withProperties($datas)
		->useLog('Applicant Board created')
		->log('created');
		
		
		// Delete draft
		DB::table('drafts')->where('id', $vals['details']['refno'])->delete();
		DB::table('dboards')->where('adjob_id', $vals['details']['refno'])->delete();
		
		$vals=[];
		$data=[];
		
	}
	
	public function editAd($vals, $rid){
		$data = [
        'broadcast'                 => $vals['details']['broadcast']??'',
        'reference_no'              => $vals['details']['refno']??'', 
        'job_title'               	=> $vals['details']['jobtitle']??'',
        'job_type'              	=> $vals['details']['jobtype']??'',
		'job_time'              	=> $vals['details']['jobtime']??'',
		'bp1'              			=> $vals['details']['bp1']??'',
		'bp2'              			=> $vals['details']['bp2']??'',
		'bp3'              			=> $vals['details']['bp3']??'',
		'sdate'              		=> $vals['details']['sdate'],
		'edate'              		=> $vals['details']['edate'],
		'board'              		=> '',
		'industry'              	=> '',
		'job_class'              	=> '',
		'currency'              	=> $vals['details']['salary']??'',
		'min'              			=> $vals['details']['min']??'',
		'max'              			=> $vals['details']['max']??'',
		'salary_per'              	=> $vals['details']['stype']??'',
		'salary_desc'              	=> $vals['details']['sdesc']??'',
		'hide_salary'              	=> $vals['details']['hides']??'',
		'job_requirement'           => $vals['details']['jdesc']??'',
		'min_exp'              		=> $vals['details']['mexp']??'',
		'edu_level'              	=> $vals['details']['elevel']??'',
		'local_resident'            => $vals['details']['lresi']??'',
		'work_permission'           => $vals['details']['work_permissions']??'',
		'location'              	=> $vals['details']['location']??'',
		'postcode'              	=> $vals['details']['pcode']??'',
		'video_url'              	=> $vals['details']['vurl']??'',
		'video_pos'              	=> $vals['details']['vid_pos']??'',
		'job_summary'              	=> $vals['details']['jsum']??'',
		'detail_job_summary'        => $vals['details']['djob']??'',
		'location_city'             => '',
        'job_template'              => $vals['temp']['jtemp']??'',
		'post_time'              	=> $vals['temp']['posttime']??'',
		'post_date'              	=> $vals['temp']['posttime1']??'',
		'contact_email'             => '',
		'contact_phone'             => '',
		'cost'              		=> ''
		];
		#$adjob=Adjob::where('id',$rid)->update($data);
		$adjob = Adjob::findOrFail($rid);
		$adjob->update($data);
		
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
			$exdate = '';
			if($job=='Adjuna') $exdate = date('Y-m-d', strtotime("+30 day", strtotime($vals['temp']['posttime1'])));
			if($job=='Jora') $exdate = date('Y-m-d', strtotime("+20 day", strtotime($vals['temp']['posttime1'])));
			if($job=='Seek') $exdate = date('Y-m-d', strtotime("+15 day", strtotime($vals['temp']['posttime1'])));
			$datas[]=[
			  'adjob_id'=>$rid,
			  'board_name'=>$job,
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc"),
			  'expiry_date'=>$exdate
			];
		}
		
		Board::insert($datas);
		
		activity()
		->performedOn($adjob)
		->causedBy(Auth::user())
		->withProperties($datas)
		->useLog('Applicant Board created')
		->log('created');
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
			$exdate = '';
			if($job['board_name']=='Adjuna') $exdate = date('Y-m-d', strtotime("+30 day", strtotime($vals['temp']['posttime1'])));
			if($job['board_name']=='Jora') $exdate = date('Y-m-d', strtotime("+20 day", strtotime($vals['temp']['posttime1'])));
			if($job['board_name']=='Seek') $exdate = date('Y-m-d', strtotime("+15 day", strtotime($vals['temp']['posttime1'])));
			
			Board::where([['adjob_id',$rid],['id',$job['id']]])->update(
			  ['board_name'=>$job['board_name'],
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc"),
			  'expiry_date'=>$exdate
			  ]
			);
			
			
		activity()
		->performedOn($adjob)
		->causedBy(Auth::user())
		->withProperties(['board_name'=>$job['board_name'],
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc")])
		->useLog('Applicant Board updated')
		->log('updated');
		}
		$vv=Board::where([['adjob_id',$rid],['industry','']])->delete();
		if($vv==1){
		activity()
		->performedOn($adjob)
		->causedBy(Auth::user())
		->withProperties(['industry'=>''])
		->useLog('Applicant Board deleted')
		->log('deleted board whose industry updated to null see the above log');
		}
		$vals=[];
		$data=[];
	}
	
	public function resendAd($vals, $rid){
		$data = [
        'broadcast'                 => $vals['details']['broadcast']??'',
        'reference_no'              => $vals['details']['refno']??'', 
        'job_title'               	=> $vals['details']['jobtitle']??'',
        'job_type'              	=> $vals['details']['jobtype']??'',
		'job_time'              	=> $vals['details']['jobtime']??'',
		'bp1'              			=> $vals['details']['bp1']??'',
		'bp2'              			=> $vals['details']['bp2']??'',
		'bp3'              			=> $vals['details']['bp3']??'',
		'sdate'              		=> $vals['details']['sdate'],
		'edate'              		=> $vals['details']['edate'],
		'board'              		=> '',
		'industry'              	=> '',
		'job_class'              	=> '',
		'currency'              	=> $vals['details']['salary']??'',
		'min'              			=> $vals['details']['min']??'',
		'max'              			=> $vals['details']['max']??'',
		'salary_per'              	=> $vals['details']['stype']??'',
		'salary_desc'              	=> $vals['details']['sdesc']??'',
		'hide_salary'              	=> $vals['details']['hides']??'',
		'job_requirement'           => $vals['details']['jdesc']??'',
		'min_exp'              		=> $vals['details']['mexp']??'',
		'edu_level'              	=> $vals['details']['elevel']??'',
		'local_resident'            => $vals['details']['lresi']??'',
		'work_permission'           => $vals['details']['work_permissions']??'',
		'location'              	=> $vals['details']['location']??'',
		'postcode'              	=> $vals['details']['pcode']??'',
		'video_url'              	=> $vals['details']['vurl']??'',
		'video_pos'              	=> $vals['details']['vid_pos']??'',
		'job_summary'              	=> $vals['details']['jsum']??'',
		'detail_job_summary'        => $vals['details']['djob']??'',
		'location_city'             => '',
        'job_template'              => $vals['temp']['jtemp']??'',
		'post_time'              	=> $vals['temp']['posttime']??'',
		'post_date'              	=> $vals['temp']['posttime1']??'',
		'contact_email'             => '',
		'contact_phone'             => '',
		'cost'              		=> '',
		'created_by'              	=> Auth::user()->id
		];
		
		$adjob=Adjob::create($data);
		$adjob->where("id", $adjob->id)->update(["reference_no" => $adjob->id]);
		foreach(session('job') as $job){
			
			$jobi=$job.'industry';
			$jobc=$job.'classi';
			
			$exdate = '';
			if($job=='Adjuna') $exdate = date('Y-m-d', strtotime("+30 day", strtotime($vals['temp']['posttime1'])));
			if($job=='Jora') $exdate = date('Y-m-d', strtotime("+20 day", strtotime($vals['temp']['posttime1'])));
			if($job=='Seek') $exdate = date('Y-m-d', strtotime("+15 day", strtotime($vals['temp']['posttime1'])));
			$datas[]=[
			  'adjob_id'=>$adjob->id,
			  'board_name'=>$job,
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc"),
			  'expiry_date'=>$exdate
			];
		}
		
		Board::insert($datas);
		activity()
		->performedOn($adjob)
		->causedBy(Auth::user())
		->withProperties($datas)
		->useLog('Applicant Board created')
		->log("clone created using job id $rid");
		
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
			
			$exdate = '';
			if($job=='Adjuna') $exdate = date('Y-m-d', strtotime("+30 day", strtotime($vals['temp']['posttime1'])));
			if($job=='Jora') $exdate = date('Y-m-d', strtotime("+20 day", strtotime($vals['temp']['posttime1'])));
			if($job=='Seek') $exdate = date('Y-m-d', strtotime("+15 day", strtotime($vals['temp']['posttime1'])));
			$datas[]=[
			  'adjob_id'=>$rid,
			  'board_name'=>$job,
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc"),
			  'expiry_date'=>$exdate
			];
		}
		
		Board::insert($datas);
		activity()
		->performedOn($adjob)
		->causedBy(Auth::user())
		->withProperties($datas)
		->useLog('Applicant Board created')
		->log('created');
		}
		foreach($bod as $job){
			
			$jobi=$job['board_name'].'industry';
			$jobc=$job['board_name'].'classi';
			
			$exdate = '';
			if($job['board_name']=='Adjuna') $exdate = date('Y-m-d', strtotime("+30 day", strtotime($vals['temp']['posttime1'])));
			if($job['board_name']=='Jora') $exdate = date('Y-m-d', strtotime("+20 day", strtotime($vals['temp']['posttime1'])));
			if($job['board_name']=='Seek') $exdate = date('Y-m-d', strtotime("+15 day", strtotime($vals['temp']['posttime1'])));
			Board::where([['adjob_id',$adjob->id],['id',$job['id']]])->update(
			  ['board_name'=>$job['board_name'],
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc"),
			  'expiry_date'=>$exdate
			  ]
			);
			activity()
		->performedOn($adjob)
		->causedBy(Auth::user())
		->withProperties( ['board_name'=>$job['board_name'],
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc")])
		->useLog('Applicant Board updated')
		->log('updated');
		}
		$vv=Board::where([['adjob_id',$adjob->id],['industry','']])->delete();
		if($vv==1){ activity()
		->performedOn($adjob)
		->causedBy(Auth::user())
		->withProperties(['industry'=>''])
		->useLog('Applicant Board deleted')
		->log('deleted board whose industry updated to null see the above log');
		}
		
		// Delete draft
		DB::table('drafts')->where('id', $vals['details']['refno'])->delete();
		DB::table('dboards')->where('adjob_id', $vals['details']['refno'])->delete();
		$vals=[];
		$data=[];
	}
	
	public function repostAd($vals, $rid){
		$data = [
        'broadcast'                 => $vals['details']['broadcast']??'',
        'reference_no'              => $vals['details']['refno']??'', 
        'job_title'               	=> $vals['details']['jobtitle']??'',
        'job_type'              	=> $vals['details']['jobtype']??'',
		'job_time'              	=> $vals['details']['jobtime']??'',
		'bp1'              			=> $vals['details']['bp1']??'',
		'bp2'              			=> $vals['details']['bp2']??'',
		'bp3'              			=> $vals['details']['bp3']??'',
		'sdate'              		=> $vals['details']['sdate'],
		'edate'              		=> $vals['details']['edate'],
		'board'              		=> '',
		'industry'              	=> '',
		'job_class'              	=> '',
		'currency'              	=> $vals['details']['salary']??'',
		'min'              			=> $vals['details']['min']??'',
		'max'              			=> $vals['details']['max']??'',
		'salary_per'              	=> $vals['details']['stype']??'',
		'salary_desc'              	=> $vals['details']['sdesc']??'',
		'hide_salary'              	=> $vals['details']['hides']??'',
		'job_requirement'           => $vals['details']['jdesc']??'',
		'min_exp'              		=> $vals['details']['mexp']??'',
		'edu_level'              	=> $vals['details']['elevel']??'',
		'local_resident'            => $vals['details']['lresi']??'',
		'work_permission'           => $vals['details']['work_permissions']??'',
		'location'              	=> $vals['details']['location']??'',
		'postcode'              	=> $vals['details']['pcode']??'',
		'video_url'              	=> $vals['details']['vurl']??'',
		'video_pos'              	=> $vals['details']['vid_pos']??'',
		'job_summary'              	=> $vals['details']['jsum']??'',
		'detail_job_summary'        => $vals['details']['djob']??'',
		'location_city'             => '',
        'job_template'              => $vals['temp']['jtemp']??'',
		'post_time'              	=> $vals['temp']['posttime']??'',
		'post_date'              	=> $vals['temp']['posttime1']??'',
		'contact_email'             => '',
		'contact_phone'             => '',
		'cost'              		=> $rid,
		'created_by'              	=> Auth::user()->id
		];
		
		$adjob=Adjob::create($data);
		$adjob->where("id", $adjob->id)->update(["reference_no" => $adjob->id]);
		foreach(session('job') as $job){
			
			$jobi=$job.'industry';
			$jobc=$job.'classi';
			
			$exdate = '';
			if($job=='Adjuna') $exdate = date('Y-m-d', strtotime("+30 day", strtotime($vals['temp']['posttime1'])));
			if($job=='Jora') $exdate = date('Y-m-d', strtotime("+20 day", strtotime($vals['temp']['posttime1'])));
			if($job=='Seek') $exdate = date('Y-m-d', strtotime("+15 day", strtotime($vals['temp']['posttime1'])));
			$datas[]=[
			  'adjob_id'=>$adjob->id,
			  'board_name'=>$job,
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc"),
			  'expiry_date'=>$exdate
			];
		}
		
		Board::insert($datas);
		activity()
		->performedOn($adjob)
		->causedBy(Auth::user())
		->withProperties($datas)
		->useLog('Applicant Board created')
		->log("repost created using job id $rid");
		
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
			
			$exdate = '';
			if($job=='Adjuna') $exdate = date('Y-m-d', strtotime("+30 day", strtotime($vals['temp']['posttime1'])));
			if($job=='Jora') $exdate = date('Y-m-d', strtotime("+20 day", strtotime($vals['temp']['posttime1'])));
			if($job=='Seek') $exdate = date('Y-m-d', strtotime("+15 day", strtotime($vals['temp']['posttime1'])));
			$datas[]=[
			  'adjob_id'=>$rid,
			  'board_name'=>$job,
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc"),
			  'expiry_date'=>$exdate
			];
		}
		
		Board::insert($datas);
		activity()
		->performedOn($adjob)
		->causedBy(Auth::user())
		->withProperties($datas)
		->useLog('Applicant Board created')
		->log('created');
		}
		foreach($bod as $job){
			
			$jobi=$job['board_name'].'industry';
			$jobc=$job['board_name'].'classi';
			$exdate = '';
			if($job['board_name']=='Adjuna') $exdate = date('Y-m-d', strtotime("+30 day", strtotime($vals['temp']['posttime1'])));
			if($job['board_name']=='Jora') $exdate = date('Y-m-d', strtotime("+20 day", strtotime($vals['temp']['posttime1'])));
			if($job['board_name']=='Seek') $exdate = date('Y-m-d', strtotime("+15 day", strtotime($vals['temp']['posttime1'])));
			Board::where([['adjob_id',$adjob->id],['id',$job['id']]])->update(
			  ['board_name'=>$job['board_name'],
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc"),
			  'expiry_date'=>$exdate
			  ]
			);
			activity()
		->performedOn($adjob)
		->causedBy(Auth::user())
		->withProperties(['board_name'=>$job['board_name'],
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc")])
		->useLog('Applicant Board updated')	  
		->log('updated');
		}
		$vv=Board::where([['adjob_id',$adjob->id],['industry','']])->delete();
		if($vv==1){
		activity()
		->performedOn($adjob)
		->causedBy(Auth::user())
		->withProperties(['industry'=>''])
		->useLog('Applicant Board deleted')
		->log('deleted board whose industry updated to null see the above log');
		}
		$vals=[];
		$data=[];
	}
	
	
	public function getAllEvent(){
		$stat=[];
		$eve=Applicant::select([
				'applicant_email as title',
				'start_date as start',
				'end_date as end' 
		        ])
			->where([['active','1']])->get();
		$eve=json_decode(json_encode($eve), true);
		return $eve;
	}
	
	public function getEvent($rid){
		$stat=[];
		$eve=Applicant::select([
				'applicant_email as title',
				'start_date as start',
				'end_date as end' 
		        ])
			->where([['adjob_id',$rid],['active','1']])->get();
		$eve=json_decode(json_encode($eve), true);
		return $eve;
	}
	
	public function getValue($val,$rid){
		
		#if($val=='all') return Applicant::with('adjob')->where('adjob_id',$rid)->latest('id')->get();
		if($val=='all'){
		return Applicant::select([
				'applicants.id',
				'applicants.status',
				'applicants.applicant_name',
				'applicants.applicant_email',
				'applicants.applicant_source',
				'applicants.applied_date',
				'applicants.download',
				'applicants.start_date',
				\DB::raw('count(applicants.applicant_email) as jobsappli'),
				'admin_tracker.candidates.email_address',
				'admin_tracker.candidates.appointment_date',
				'admin_tracker.candidates.appointment_time',
				'admin_tracker.candidates_additional.active_candidate',
				]
				)
				->leftJoin('admin_tracker.candidates', 'admin_tracker.candidates.email_address', 'applicants.applicant_email')
				->leftJoin('admin_tracker.candidates_additional', 'admin_tracker.candidates_additional.candidate_id', 'admin_tracker.candidates.id')
				->where([['adjob_id',$rid],['applicants.active','1']])
				->groupBy('applicants.id')
				->get();
		}
		
		if($val=='qual'){ 
		#return Applicant::with('adjob')->where('adjob_id',$rid)->whereIn('status', ['qualify', 'starr', 'interviewschedule', 'invited'])->latest('id')->get();
		
		return Applicant::select([
				'applicants.id',
				'applicants.status',
				'applicants.applicant_name',
				'applicants.applicant_email',
				'applicants.applicant_source',
				'applicants.applied_date',
				'applicants.download',
				'applicants.start_date',
				\DB::raw('count(applicants.applicant_email) as jobsappli'),
				'admin_tracker.candidates.email_address',
				'admin_tracker.candidates.appointment_date',
				'admin_tracker.candidates.appointment_time',
				'admin_tracker.candidates_additional.active_candidate',
				]
				)
				->leftJoin('admin_tracker.candidates', 'admin_tracker.candidates.email_address', 'applicants.applicant_email')
				->leftJoin('admin_tracker.candidates_additional', 'admin_tracker.candidates_additional.candidate_id', 'admin_tracker.candidates.id')
				->where([['adjob_id',$rid],['applicants.active','1']])
				->whereIn('applicants.status', ['5','4','3', '2','1'])
				->groupBy('applicants.id')
				->orderBy('applicants.status', 'desc')
				->get();
		
		}
		//if($val=='poten') return Applicant::with('adjob')->where('adjob_id',$rid)->whereIn('status', [ 'potential', 'starr', 'interviewschedule', 'invited'])->latest('id')->get();
		if($val=='star') {
			#return Applicant::with('adjob')->where('adjob_id',$rid)->whereIn('status', [ '3', '4','5'])->latest('id')->get();
			return Applicant::select([
				'applicants.id',
				'applicants.status',
				'applicants.applicant_name',
				'applicants.applicant_email',
				'applicants.applicant_source',
				'applicants.applied_date',
				'applicants.download',
				'applicants.start_date',
				\DB::raw('count(applicants.applicant_email) as jobsappli'),
				'admin_tracker.candidates.email_address',
				'admin_tracker.candidates.appointment_date',
				'admin_tracker.candidates.appointment_time',
				'admin_tracker.candidates_additional.active_candidate',
				]
				)
				->leftJoin('admin_tracker.candidates', 'admin_tracker.candidates.email_address', 'applicants.applicant_email')
				->leftJoin('admin_tracker.candidates_additional', 'admin_tracker.candidates_additional.candidate_id', 'admin_tracker.candidates.id')
				->where([['adjob_id',$rid],['applicants.active','1']])
				->whereIn('applicants.status', ['5','4','3'])
				->groupBy('applicants.id')
				->orderBy('applicants.status', 'desc')
				->get();
		
		}
		//if($val=='isc') return Applicant::with('adjob')->where('adjob_id',$rid)->whereIn('status', [ 'interviewschedule', 'invited'])->latest('id')->get();
		if($val=='invite') { 
		#return Applicant::with('adjob')->where('adjob_id',$rid)->whereIn('status', ['5'])->latest('id')->get();
		return Applicant::select([
				'applicants.id',
				'applicants.status',
				'applicants.applicant_name',
				'applicants.applicant_email',
				'applicants.applicant_source',
				'applicants.applied_date',
				'applicants.download',
				'applicants.start_date',
				\DB::raw('count(applicants.applicant_email) as jobsappli'),
				'admin_tracker.candidates.email_address',
				'admin_tracker.candidates.appointment_date',
				'admin_tracker.candidates.appointment_time',
				'admin_tracker.candidates_additional.active_candidate',
				]
				)
				->leftJoin('admin_tracker.candidates', 'admin_tracker.candidates.email_address', 'applicants.applicant_email')
				->leftJoin('admin_tracker.candidates_additional', 'admin_tracker.candidates_additional.candidate_id', 'admin_tracker.candidates.id')
				->where([['adjob_id',$rid],['applicants.active','1']])
				->whereIn('applicants.status', ['5'])
				->groupBy('applicants.id')
				->orderBy('applicants.status', 'desc')
				->get();
		
		}
	}
	
	public function toolTips($emails){
		$values=[];
		$value=[];
		$values= Applicant::select([
				\DB::raw('count(applytrack.applicants.applicant_email) as jobsappli'),
				'admin_tracker.candidates.appointment_date',
				'admin_tracker.candidates.appointment_time'
				]
				)
				->leftJoin('admin_tracker.candidates', 'admin_tracker.candidates.email_address', 'applytrack.applicants.applicant_email')
				->where('applytrack.applicants.applicant_email',$emails)
				->whereIn('applicants.status', ['1', '2', '3', '4','5'])
				->groupBy('applytrack.applicants.applicant_email')
				->get();
		if(isset($values[0])){
			$value=$values[0];
		return $value;}
	    else return $value='';
	}
	
	public function roleBasedLocation($role,$location,$slocation=''){
		
		if($slocation !='')
		$mergLoc=$location.','.$slocation;
		else
		$mergLoc=$location;
		
		
		if($role=='admin'){
		$locations=DB::connection('tracker')->select('select id,location from office_locations');
		}
		else{
		$locations=DB::connection('tracker')->select('select id,location from office_locations where id IN ('.$mergLoc.')');
		}
		$locations=json_decode(json_encode($locations), true);
		return $locations;
	}
	
	public function locaBasedConsul($location){
		
		$consultants= User::select([
				 'id',
				 'first_name'
				])
				->where(function($query) use ($location){
					
				   $query->orWhere('office_location','like', '%' . $location . '%');
					
						$query->orWhere(
						DB::raw("find_in_set($location,secondary_office_location)"),">",DB::raw("'0'")
						);
					
				})
				->where([['status',1]])
				->groupBy('id')
				->get();
		return $consultants;
	}
	
	public function roleBased($role,$location,$slocation=''){
		$loc='';
		$sloc='';
		$mergLoc='';
		$JobTemplate =[];
		$loc=$location;
		$sloc=$slocation;
		if($slocation !='')
		$mergLoc=$loc.','.$sloc;
	    else $mergLoc=$loc;
		//string to array
		$mergLoc=array_filter(explode(',',$mergLoc));
		$sesloc='';
		
		//location based filter
		$sesloc=session()->get('locations');
		if($role=="admin"){
			    //location based filter
			    if(!empty($sesloc)) {
				$sesloc=array_filter(explode(',',$sesloc));
				$JobTemplate = JobTemplate::whereIn('business_unit_id',$sesloc)->where([['active','1'],['status','1']])->get()->toArray();
				}
				else{
				$JobTemplate = JobTemplate::where([['active','1'],['status','1']])->get()->toArray();
				}
			}
			elseif($role=="state"){
				
				if($loc!=''){
					//location based filter
					if(!empty($sesloc)) {
					$sesloc=array_filter(explode(',',$sesloc));
					$JobTemplate = JobTemplate::whereIn('business_unit_id',$sesloc)->where([['active','1'],['status','1']])->get()->toArray();
					}
					else{
					$JobTemplate = JobTemplate::whereIn('business_unit_id',$mergLoc)->where([['active','1'],['status','1']])->get()->toArray();
					}
				}
				else{
					$JobTemplate = JobTemplate::where([['active','1'],['status','1']])->get()->toArray();
				}
			}
			elseif($role=="consult"){
				
				if($loc!=''){
					//location based filter
					if(!empty($sesloc)) {
					$sesloc=array_filter(explode(',',$sesloc));
					$JobTemplate = JobTemplate::whereIn('business_unit_id',$sesloc)->where([['active','1'],['status','1']])->get()->toArray();
					}
					else{
					$JobTemplate = JobTemplate::whereIn('business_unit_id',$mergLoc)->where([['active','1'],['status','1']])->get()->toArray();
					}
				}
				else{
					$JobTemplate = JobTemplate::where([['active','1'],['status','1']])->get()->toArray();
				}
			}
			
			else{
				$JobTemplate = JobTemplate::where([['active','1'],['status','1']])->get()->toArray();
			}
			
			return $JobTemplate;
	}
	
	public function expired(){
		
	}
	
	public function roleBasedAd($role,$location,$slocation=''){
		$sesloc='';
		$loc='';
		$sloc='';
		$mergLoc='';
		$ads=[];
		$loc=$location;
		$sloc=$slocation;
		$mergLoc=$sloc;
		//string to array
		$mergLoc=array_filter(explode(',',$mergLoc));
		$mergLoc1=$loc.','.$sloc;
		$mergLoc1=array_filter(explode(',',$mergLoc1));
		
		$adss1= Adjob::withCount('boards')->withCount('applicants')->with('boards')->where('active','1')->latest('id')->get()->toArray();
		//print_r($adss1); exit;
		//location based filter
		$sesloc=session()->get('locations');
		
		
		
		foreach($adss1 as $adds){
			$i=0;
			foreach($adds['boards'] as $boar){
				
				if(NOW() > $boar['expiry_date']){
				 
				$i=$i+1; 
				}
				
			}
			//checking expiry date count with board count and in-activate
			if($i == $adds['boards_count'])
			Adjob::where("id", $adds['id'])->update(["active" => 0]);
		    
			//updating response if changed
			if($adds['response'] != $adds['applicants_count'])
		    Adjob::where("id", $adds['id'])->update(["response" => $adds['applicants_count']]);
			
		}
		//role based filter
		if($role=="admin"){
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
				#\DB::raw('count(applicants.adjob_id) as response'),
				'adjobs.response',
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
				#\DB::raw('count(applicants.adjob_id) as response'),
				'adjobs.response',
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
			elseif($role=="state"){
				//location based filter
				if(!empty($sesloc)) {
				$sesloc=array_filter(explode(',',$sesloc));
				$ads= Adjob::select([
				'adjobs.id',
				#\DB::raw('count(applicants.adjob_id) as response'),
				'adjobs.response',
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
				#\DB::raw('count(applicants.adjob_id) as response'),
				'adjobs.response',
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
			elseif($role=="consult"){
				//location based filter
				if(!empty($sesloc)) {
				$sesloc=array_filter(explode(',',$sesloc));
				$ads= Adjob::select([
				'adjobs.id',
				#\DB::raw('count(applicants.adjob_id) as response'),
				'adjobs.response',
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
				#\DB::raw('count(applicants.adjob_id) as response'),
				'adjobs.response',
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
			
			else{
				$ads= Adjob::with('applicants')->where('active','1')->latest('id')->get();
			}
			
			return $ads;
	}
	
	function get_random_password($chars_min=6, $chars_max=8, $use_upper_case=false, $include_numbers=false, $include_special_chars=false)
	{
    $length = rand($chars_min, $chars_max);
    $selection = 'aeuoyibcdfghjklmnpqrstvwxz';
    if($include_numbers) {
        $selection .= "1234567890";
    }
    if($include_special_chars) {
        $selection .= "!@\"#$%&[]{}?|";
    }
                            
    $password = "";
    for($i=0; $i<$length; $i++) {
        $current_letter = $use_upper_case ? (rand(0,1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];            
        $password .=  $current_letter;
    }                
    
	return $password;
	}
	
}
	
?>