<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Adjob;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Applicant;
use App\JobTemplate;
use App\Board;

class RecruitService
{
    protected $data;
   
	
	public function addAd($vals)
	{
		#print_r($vals['details']['broadcast']);
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
		'location'              	=> $vals['details']['location']??'',
		'postcode'              	=> $vals['details']['pcode']??'',
		'video_url'              	=> $vals['details']['vurl']??'',
		'job_summary'              	=> $vals['details']['jsum']??'',
		'detail_job_summary'        => $vals['details']['djob']??'',
		'location_city'             => '',
        'job_template'              => $vals['temp']['jtemp']??'',
		'post_time'              	=> $vals['temp']['posttime']??'',
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
		'location'              	=> $vals['details']['location']??'',
		'postcode'              	=> $vals['details']['pcode']??'',
		'video_url'              	=> $vals['details']['vurl']??'',
		'job_summary'              	=> $vals['details']['jsum']??'',
		'detail_job_summary'        => $vals['details']['djob']??'',
		'location_city'             => '',
        'job_template'              => $vals['temp']['jtemp']??'',
		'post_time'              	=> $vals['temp']['posttime']??'',
		'contact_email'             => '',
		'contact_phone'             => '',
		'cost'              		=> ''
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
		'location'              	=> $vals['details']['location']??'',
		'postcode'              	=> $vals['details']['pcode']??'',
		'video_url'              	=> $vals['details']['vurl']??'',
		'job_summary'              	=> $vals['details']['jsum']??'',
		'detail_job_summary'        => $vals['details']['djob']??'',
		'location_city'             => '',
        'job_template'              => $vals['temp']['jtemp']??'',
		'post_time'              	=> $vals['temp']['posttime']??'',
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
		}
		foreach($bod as $job){
			
			$jobi=$job['board_name'].'industry';
			$jobc=$job['board_name'].'classi';
			
			Board::where([['adjob_id',$adjob->id],['id',$job['id']]])->update(
			  ['board_name'=>$job['board_name'],
			  'industry'=>session("details.$jobi"),
			  'job_class'=> session("details.$jobc")]
			);
		}
		Board::where([['adjob_id',$adjob->id],['industry','']])->delete();
		$vals=[];
		$data=[];
	}
	
	public function getValue($val,$rid){
		
		if($val=='all') return Applicant::with('adjob')->where('adjob_id',$rid)->latest('id')->get();
		if($val=='qual') return Applicant::with('adjob')->where('adjob_id',$rid)->whereIn('status', ['qualify', 'potential', 'starr', 'inteviewschedule', 'invited'])->latest('id')->get();
		if($val=='star') return Applicant::with('adjob')->where('adjob_id',$rid)->whereIn('status', [ 'starr', 'inteviewschedule', 'invited'])->latest('id')->get();
		if($val=='invite') return Applicant::with('adjob')->where('adjob_id',$rid)->whereIn('status', ['invited'])->latest('id')->get();
	}
	
}
	
?>