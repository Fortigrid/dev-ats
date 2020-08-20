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
		'sdate'              		=> $vals['details']['sdate']??'',
		'edate'              		=> $vals['details']['edate']??'',
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
		foreach($vals['job'] as $job){
			
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
		activity()
		->performedOn($adjob)
		->causedBy(Auth::user())
		->withProperties($datas)
		->useLog('Applicant Board created')
		->log('created');
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
		'sdate'              		=> $vals['details']['sdate']??'',
		'edate'              		=> $vals['details']['edate']??'',
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
			
			$datas[]=[
			  'adjob_id'=>$rid,
			  'board_name'=>$job,
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc")
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
			
			Board::where([['adjob_id',$rid],['id',$job['id']]])->update(
			  ['board_name'=>$job['board_name'],
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc")]
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
		Board::where([['adjob_id',$rid],['industry','']])->delete();
		activity()
		->performedOn($adjob)
		->causedBy(Auth::user())
		->withProperties(['industry'=>''])
		->useLog('Applicant Board deleted')
		->log('deleted board whose industry updated to null see the above log');
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
		'sdate'              		=> $vals['details']['sdate']??'',
		'edate'              		=> $vals['details']['edate']??'',
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
		foreach(session('job') as $job){
			
			$jobi=$job.'industry';
			$jobc=$job.'classi';
			
			
			$datas[]=[
			  'adjob_id'=>$adjob->id,
			  'board_name'=>$job,
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc")
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
			
			
			$datas[]=[
			  'adjob_id'=>$rid,
			  'board_name'=>$job,
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc")
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
			
			Board::where([['adjob_id',$adjob->id],['id',$job['id']]])->update(
			  ['board_name'=>$job['board_name'],
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc")]
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
		Board::where([['adjob_id',$adjob->id],['industry','']])->delete();
		activity()
		->performedOn($adjob)
		->causedBy(Auth::user())
		->withProperties(['industry'=>''])
		->useLog('Applicant Board deleted')
		->log('deleted board whose industry updated to null see the above log');
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
		'sdate'              		=> $vals['details']['sdate']??'',
		'edate'              		=> $vals['details']['edate']??'',
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
		foreach(session('job') as $job){
			
			$jobi=$job.'industry';
			$jobc=$job.'classi';
			
			
			$datas[]=[
			  'adjob_id'=>$adjob->id,
			  'board_name'=>$job,
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc")
			];
		}
		
		Board::insert($datas);
		activity()
		->performedOn($adjob)
		->causedBy(Auth::user())
		->withProperties($datas)
		->useLog('Applicant Board created')
		->log('repost created using job id $rid');
		
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
			
			
			$datas[]=[
			  'adjob_id'=>$rid,
			  'board_name'=>$job,
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc")
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
			
			Board::where([['adjob_id',$adjob->id],['id',$job['id']]])->update(
			  ['board_name'=>$job['board_name'],
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc")]
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
		Board::where([['adjob_id',$adjob->id],['industry','']])->delete();
		activity()
		->performedOn($adjob)
		->causedBy(Auth::user())
		->withProperties(['industry'=>''])
		->useLog('Applicant Board deleted')
		->log('deleted board whose industry updated to null see the above log');
		$vals=[];
		$data=[];
	}
	
	public function getValue($val,$rid){
		
		if($val=='all') return Applicant::with('adjob')->where('adjob_id',$rid)->latest('id')->get();
		if($val=='qual') return Applicant::with('adjob')->where('adjob_id',$rid)->whereIn('status', ['qualify', 'potential', 'starr', 'inteviewschedule', 'invited'])->latest('id')->get();
		if($val=='star') return Applicant::with('adjob')->where('adjob_id',$rid)->whereIn('status', [ 'starr', 'inteviewschedule', 'invited'])->latest('id')->get();
		if($val=='invite') return Applicant::with('adjob')->where('adjob_id',$rid)->whereIn('status', ['invited'])->latest('id')->get();
	}
	
	public function roleBased($role,$location,$slocation=''){
		$loc='';
		$sloc='';
		$mergLoc='';
		$JobTemplate =[];
		$loc=$location;
		$sloc=$slocation;
		$mergLoc=$loc.','.$sloc;
		//string to array
		$mergLoc=array_filter(explode(',',$mergLoc));
		if($role=="admin"){
				$JobTemplate = JobTemplate::where('active','1')->get()->toArray();
			}
			elseif($role=="state"){
				
				if($loc!=''){
					#$JobTemplate = JobTemplate::where([['business_unit_id',$loc],['active','1']])->get()->toArray();
					$JobTemplate = JobTemplate::whereIn('business_unit_id',$mergLoc)->where('active','1')->get()->toArray();
				}
				else{
					$JobTemplate = JobTemplate::where('active','1')->get()->toArray();
				}
			}
			elseif($role=="consult"){
				
				if($loc!=''){
					#$JobTemplate = JobTemplate::where([['business_unit_id',$loc],['active','1']])->get()->toArray();
					$JobTemplate = JobTemplate::whereIn('business_unit_id',$mergLoc)->where('active','1')->get()->toArray();
				}
				else{
					$JobTemplate = JobTemplate::where('active','1')->get()->toArray();
				}
			}
			
			else{
				$JobTemplate = JobTemplate::where('active','1')->get()->toArray();
			}
			
			return $JobTemplate;
	}
	
	public function roleBasedAd($role,$location,$slocation=''){
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
		
		if($role=="admin"){
				$ads= Adjob::with('applicants')->where('active','1')->latest('id')->get();
			}
			elseif($role=="state"){
				$ads= Adjob::select([
				'adjobs.id',
				'adjobs.response',
				'adjobs.post_date',
				'adjobs.job_title',
				'adjobs.created_by'])
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
			elseif($role=="consult"){
				$ads= Adjob::select([
				'adjobs.id',
				'adjobs.response',
				'adjobs.post_date',
				'adjobs.job_title',
				'adjobs.created_by'])
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
			
			else{
				$ads= Adjob::with('applicants')->where('active','1')->latest('id')->get();
			}
			
			return $ads;
	}
	
}
	
?>