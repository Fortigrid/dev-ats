@extends('layouts.master')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" style="margin-top:20px;">
                <div class="card-header"><b>{{ __('Preview and Publish Ad') }}</b></div>
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
				   <b>Choose job-> Ad details -> Publish</b>
				   <form method="POST">
				   @csrf
				   <p>Please Enter the details for this advert</p>
				   <p>Please provide values for the mandatory fields marked with red astericks</p>
				   <p></p>
					<!--<div class="form-group row">
        <label for="inputEmail" class="col-sm-2 col-form-label">Broadcast as *</label>
        <div class="col-sm-5">
            <select name="broadcast">
				<option value="">Select</option>
				<option value="1">Resourcing Team</option>
			</select>
        </div>
    </div>-->
	
    <div class="form-group row">
	
        <label for="inputPassword"  class="col-sm-2 col-form-label">Reference No. *</label>
        <div class="col-sm-5">
		{{session('details.refno')}}
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Title. *</label>
        <div class="col-sm-5">
            {{session('details.jobtitle')}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Template. *</label>
        <div class="col-sm-5">
            <select name="jtemp">
			<option value="">Select Template</option>
			@foreach($JobTemplate as $jtemp)
			<option value="{{$jtemp['template_name']}}">{{$jtemp['template_name']}}</option>
			@endforeach
			</select>
        </div>
    </div>
	
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Job Type and Specifies</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Type</label>
        <div class="col-sm-4">
            
			{{session('details.jobtype')}}
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Full/Part Time</label>
        <div class="col-sm-4">
          
			{{session('details.jobtime')}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Bullet Point 1</label>
        <div class="col-sm-6">
			{{session('details.bp1')}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Bullet Point 2</label>
        <div class="col-sm-6">
            {{session('details.bp2')}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Bullet Point 3</label>
        <div class="col-sm-6">
            {{session('details.bp3')}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Proposed Start Date</label>
        <div class="col-sm-6">
           
			 {{session('details.sdate')}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Proposed End Date</label>
        <div class="col-sm-6">
            
			 {{session('details.edate')}}
        </div>
    </div>
	
	

	 <hr class="col-md-12">
	 <h5 class="col-md-12">Industry and Sector Information</h5>
	@foreach(Session::get('job') as $board)
	<div class="form-group row">
	 <label for="inputPassword" class="col-sm-2 col-form-label">{{$board}} Industry *</label>
        <div class="col-sm-5">
            {{session('details.industry')}}
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Classification *</label>
        <div class="col-sm-5">
            
				 {{session('details.classi')}}
			
        </div>
    </div>
	@endforeach 
	
	
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Salary and Benefit Information</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Numeric Salary + Description</label>
        <div class="col-sm-1">
            
			 {{session('details.salary')}}
			</div>
			 <label for="inputPassword" class="col-sm-2 col-form-label">Salary From</label>
			<div class="col-sm-2">
			{{session('details.min')}}
			</div>
			 <label for="inputPassword" class="col-sm-2 col-form-label">Salary To</label>
			<div class="col-sm-2">
			{{session('details.max')}}
			</div>
			 <label for="inputPassword" class="col-sm-2 col-form-label">Salary is per</label>
			<div class="col-sm-1">
			
			{{session('details.stype')}}
			</div>
			<label for="inputPassword" class="col-sm-2 col-form-label">Salary Benefits</label>
			<div class="col-sm-2">
			{{session('details.sdesc')}}
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Hide Numeric Salary *</label>
        <div class="col-sm-2">
             {{session('details.hides')}}
        </div>
    </div>
	
	
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Skills and Experience</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Description</label>
        <div class="col-sm-8">
            
			{{session('details.jdesc')}}
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Minimum Experience</label>
        <div class="col-sm-4">
            
			{{session('details.mexp')}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Education Level</label>
        <div class="col-sm-4">
           
			{{session('details.elevel')}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Local Residents only</label>
        <div class="col-sm-4">
            
			{{session('details.lresi')}}
        </div>
    </div>
	
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Location Information</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Location *</label>
        <div class="col-sm-5">
            {{session('details.location')}}
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Postcode/Zipcode of job location(optional)</label>
        <div class="col-sm-5">
           
			{{session('details.pcode')}}
        </div>
    </div>
	
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Client and Applicant Information, etc.</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Video URL</label>
        <div class="col-sm-7">
            
			{{session('details.vurl')}}
        </div>
    </div>
	
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Main Description Details</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Summary/Introduction *</label>
        <div class="col-sm-7">
             <textarea name="jsum"> {{session('details.jsum')}}</textarea>
        </div>
    </div>
	<div class="form-group row">
	
        <label for="inputPassword" class="col-sm-2 col-form-label">Detailed Job Description *</label>
        <div class="col-sm-7">
            <textarea name="djob">{{session('details.djob')}}</textarea>
        </div>
    </div>
	
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Posting Time</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Deliver this advert at</label>
        <div class="col-sm-7">
            <select name="posttime">
				
				<option value="<?php echo now();?>">Now</option>
				<option value="Part-time">Part-time</option>
			</select>
			 <select name="posttime1">
				
				<option value="<?php echo date('Y-m-d');?>">Today</option>
				<option value="Part-time">Part-time</option>
			</select>
        </div>
    </div>
	
	
    <div class="form-group row">
        <div class="col-sm-10 offset-sm-2">
            <button type="submit" class="btn btn-primary">Post Ad</button> 
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



