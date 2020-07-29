@extends('layouts.master')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" style="margin-top:20px;">
                <div class="card-header"><b>{{ __('Post Ad') }}</b></div>
                <div class="card-body">
                  @if($errors->any())
					<div class="alert alert-danger">
						<p><strong>Opps Something went wrong</strong></p>
						<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
						</ul>
					</div>
				 @endif
				 <div>
				   <b>Job Boards --> Ad Details</b><br>
				   <form method="Post">
				   @csrf
				   <p>Please Enter the details for this advert</p>
				   <p>Please provide values for the mandatory fields marked with red astericks</p>
				   <p></p>
					<div class="form-group row">
        <label for="inputEmail" class="col-sm-2 col-form-label">Broadcast as *</label>
        <div class="col-sm-5">
            <select name="broadcast">
				<option value="">Select</option>
				<option value="Resourcing Team" @if(session('details.broadcast')=='Resourcing Team') selected="selected" @elseif($disAd['broadcast']=='Resourcing Team') selected="selected" @endif>Resourcing Team</option>
			</select>
        </div>
    </div>
	
    <div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Main Advert Information</h5>
        <label for="inputPassword"  class="col-sm-2 col-form-label">Reference No. *</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="refno" id="reference" value="@if(session('details.refno')) {{session('details.refno')}} @else {{$disAd['reference_no']}} @endif">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Title. *</label>
        <div class="col-sm-5">
            <input type="text" name="jobtitle" class="form-control" id="job" value="@if(session('details.jobtitle')) {{session('details.jobtitle')}} @else {{$disAd['job_title']}} @endif">
        </div>
    </div>
	
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Job Type and Specifies</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Type</label>
        <div class="col-sm-4">
            <select name="jobtype">
				<option value="">Select</option>
				<option value="Permanent" @if(session('details.jobtype')=='Permanent') selected="selected" @elseif($disAd['job_type']=='Permanent') selected="selected" @endif>Permanent</option>
				<option value="Contract" @if(session('details.jobtype')=='Contract') selected="selected" @elseif($disAd['job_type']=='Contract') selected="selected" @endif>Contract</option>
			</select>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Full/Part Time</label>
        <div class="col-sm-4">
           <select name="jobtime">
				<option value="">Select</option>
				<option value="Full-time" @if(session('details.jobtime')=='Full-time') selected="selected" @elseif($disAd['job_time']=='Full-time') selected="selected" @endif>Full-time</option>
				<option value="Part-time" @if(session('details.jobtime')=='Part-time') selected="selected" @elseif($disAd['job_time']=='Part-time') selected="selected" @endif>Part-time</option>
			</select>
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Bullet Point 1</label>
        <div class="col-sm-6">
            <input type="text" name="bp1" class="form-control" id="bp1" value="@if(session('details.bp1')) {{session('details.bp1')}} @else {{$disAd['bp1']}} @endif">
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Bullet Point 2</label>
        <div class="col-sm-6">
            <input type="text" name="bp2" class="form-control" id="bp2" value="@if(session('details.bp2')) {{session('details.bp2')}} @else {{$disAd['bp2']}} @endif">
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Bullet Point 3</label>
        <div class="col-sm-6">
            <input type="text" name="bp3" class="form-control" id="bp3" value="@if(session('details.bp3')) {{session('details.bp3')}} @else {{$disAd['bp3']}} @endif">
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Proposed Start Date</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="sdate" id="" value="@if(session('details.sdate')) {{session('details.sdate')}} @else {{$disAd['sdate']}} @endif">
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Proposed End Date</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="edate" id="" value="@if(session('details.edate')) {{session('details.edate')}} @else {{$disAd['edate']}} @endif">
        </div>
    </div>
	
	

	 <hr class="col-md-12">
	 <h5 class="col-md-12">Industry and Sector Information</h5>
	@foreach(Session::get('job') as $board)
	<div class="form-group row">
	 <label for="inputPassword" class="col-sm-2 col-form-label">{{$board}} Industry *</label>
        <div class="col-sm-5">
            <select name="{{$board}}industry">
				<option value="">Select</option>
				<option value="IT" @if(in_array('IT',$bindus)) selected="selected" @endif>IT</option>
			</select>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Classification *</label>
        <div class="col-sm-5">
            <select name="{{$board}}classi">
				<option value="">Select</option>
				<option value="Admin" @if(in_array('Admin',$bclassi)) selected="selected" @endif>Admin</option>
			</select>
        </div>
    </div>
	@endforeach 
	
	
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Salary and Benefit Information</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Numeric Salary + Description</label>
        <div class="col-sm-1">
            <select name="salary">
				<option value="">Select</option>
				<option value="AUD" @if(session('details.salary')=='AUD') selected="selected" @elseif($disAd['currency']=='AUD') selected="selected" @endif>AUD</option>
			</select>
			</div>
			<div class="col-sm-2">
			<input type="text" name="min" placeholder="Min" class="form-control" id="job" value="@if(session('details.min')) {{session('details.min')}} @else {{$disAd['min']}} @endif ">
			</div>
			<div class="col-sm-2">
			<input type="text" name="max" placeholder="Max" class="form-control" id="job" value="@if(session('details.max')) {{session('details.max')}} @else {{$disAd['max']}} @endif ">
			</div>
			<div class="col-sm-1">
			<select name="stype">
				<option value="">Select</option>
				<option value="Annum" @if(session('details.stype')=='Annum') selected="selected" @elseif($disAd['salary_per']=='Annum') selected="selected" @endif>Annum</option>
				<option value="Monthly" @if(session('details.stype')=='Monthly') selected="selected" @elseif($disAd['salary_per']=='Monthly') selected="selected" @endif>Monthly</option>
			</select>
			</div>
			<div class="col-sm-2">
			<input type="text" name="sdesc" class="form-control" id="job" value="@if(session('details.sdesc')) {{session('details.sdesc')}} @else {{old('sdesc')}} @endif ">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Hide Numeric Salary *</label>
        <div class="col-sm-2">
            <select name="hides">
				<option value="">Select</option>
				<option value="Yes" @if(session('details.hides')=='Yes') selected="selected" @elseif($disAd['hide_salary']=='Yes') selected="selected" @endif>Yes</option>
				<option value="No" @if(session('details.hides')=='No') selected="selected" @elseif($disAd['hide_salary']=='No') selected="selected" @endif>No</option>
			</select>
        </div>
    </div>
	
	
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Skills and Experience</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Description</label>
        <div class="col-sm-8">
            <textarea name="jdesc">@if(session('details.jdesc')) {{session('details.jdesc')}} @else {{$disAd['job_requirement']}} @endif </textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Minimum Experience</label>
        <div class="col-sm-4">
            <select name="mexp">
				<option value="">Select</option>
				<option value="No Minimum" @if(session('details.mexp')=='No') selected="selected" @elseif($disAd['min_exp']=='No') selected="selected" @endif>No Minimum</option>
			</select>
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Education Level</label>
        <div class="col-sm-4">
            <select name="elevel">
				<option value="">Select</option>
				<option value="Not Specified" @if(session('details.elevel')=='Not Specified') selected="selected" @elseif($disAd['edu_level']=='Not Specified') selected="selected" @endif>Not Specified</option>
			</select>
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Local Residents only</label>
        <div class="col-sm-4">
            <select name="lresi">
				<option value="">Select</option>
				<option value="no" @if(session('details.lresi')=='no') selected="selected" @elseif($disAd['local_resident']=='no') selected="selected" @endif>no</option>
				<option value="yes" @if(session('details.lresi')=='yes') selected="selected" @elseif($disAd['local_resident']=='yes') selected="selected" @endif>yes</option>
				
			</select>
        </div>
    </div>
	
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Location Information</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Location *</label>
        <div class="col-sm-5">
            <input type="text" name="location" class="form-control" id="reference" value="@if(session('details.location')) {{session('details.location')}} @else {{$disAd['location']}} @endif">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Postcode/Zipcode of job location(optional)</label>
        <div class="col-sm-5">
            <input type="text" name="pcode" class="form-control" id="job" value="@if(session('details.pcode')) {{session('details.pcode')}} @else {{$disAd['postcode']}} @endif">
        </div>
    </div>
	
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Client and Applicant Information, etc.</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Video URL</label>
        <div class="col-sm-7">
            <input type="text" name="vurl" class="form-control" id="reference" value="@if(session('details.vurl')) {{session('details.vurl')}} @else {{$disAd['video_url']}} @endif">
        </div>
    </div>
	
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Main Description Details</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Summary/Introduction *</label>
        <div class="col-sm-7">
             <textarea name="jsum">@if(session('details.jsum')) {{session('details.jsum')}} @else {{$disAd['job_summary']}} @endif</textarea>
        </div>
    </div>
	<div class="form-group row">
	
        <label for="inputPassword" class="col-sm-2 col-form-label">Detailed Job Description *</label>
        <div class="col-sm-7">
            <textarea name="djob">@if(session('details.djob')) {{session('details.djob')}} @else {{$disAd['detail_job_summary']}} @endif</textarea>
        </div>
    </div>
	
	
    <div class="form-group row">
        <div class="col-sm-10 offset-sm-2">
            <button type="submit" class="btn btn-primary">Prev</button> <button type="submit" class="btn btn-primary">Next</button>
        </div>
    </div>
					</form>
				 </div>
              </div>
           </div>
        </div>
    </div>
</div><br>



@endsection



