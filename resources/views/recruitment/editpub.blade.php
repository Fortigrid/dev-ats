@extends('layouts.master')


@section('content')
<div class="container job_board pub">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Preview and Publish Ad') }}</div>
                <div class="card-body">
                  @if($errors->any())
					  <div class="alert alert-warning alert-dismissible fade show">
							<button type="button" class="close remove" data-dismiss="alert">&times;</button>
					<strong>Opps Something went wrong!</strong>
					<hr>
						<ul>
						@foreach ($errors->all() as $error)
							<li> {{ $error }} </li>
						@endforeach
						</ul>
					</div>
					<!--<div class="alert alert-danger">
						<p><strong>Opps Something went wrong</strong></p>
						<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
						</ul>
					</div>-->
				 @endif
				 @if(!empty(session('errorMessage')))
					 <div class="alert alert-danger">
						{{ session('errorMessage') }}
					 </div>
				 @endif
				 <div>
				   <b>Choose job-> Ad details -> Publish</b>
				   <form method="POST">
				   @csrf
				   <p>Please Enter the details for this advert</p>
				   <p><b>Please provide values for the mandatory fields marked with astericks</b></p>
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
	
        <label for="inputPassword"  class="col-sm-2 col-form-label">Reference No. *:</label>
        <div class="col-sm-4">
		{{session('details.refno')}}
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Title. * :</label>
        <div class="col-sm-4">
            {{session('details.jobtitle')}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Template* :</label>
        <div class="col-sm-4">
            <select name="jtemp">
			<option value="">Select Template</option>
			@foreach($JobTemplate as $jtemp)
			<option value="{{$jtemp['id']}}" @if($jtemp['id']==$disAd['job_template']) selected @endif>{{$jtemp['template_name']}}</option>
			@endforeach
			</select>
        </div>
    </div>
	
	<div class="form-group row">

	 <h5 class="col-md-12">Job Type and Specifies</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Type:</label>
        <div class="col-sm-4">
            
			{{session('details.jobtype')}}
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Full/Part Time:</label>
        <div class="col-sm-4">
          
			{{session('details.jobtime')}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Bullet Point 1:</label>
        <div class="col-sm-4">
			{{session('details.bp1')}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Bullet Point 2:</label>
        <div class="col-sm-4">
            {{session('details.bp2')}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Bullet Point 3:</label>
        <div class="col-sm-4">
            {{session('details.bp3')}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Proposed Start Date:</label>
        <div class="col-sm-4">
           
			 {{session('details.sdate')}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Proposed End Date:</label>
        <div class="col-sm-4">
            
			 {{session('details.edate')}}
        </div>
    </div>
	
	


	 <h5 class="col-md-12">Industry and Sector Information</h5>
	@foreach(Session::get('job') as $board)
	<div class="form-group row">
	 <label for="inputPassword" class="col-sm-2 col-form-label">{{$board}} Industry *:</label>
        <div class="col-sm-4">
            {{session('details.'.$board.'industry')}}
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Classification *:</label>
        <div class="col-sm-4">
            
				 {{session('details.'.$board.'classi')}}
			
        </div>
    </div>
	@endforeach 
	
	
	<div class="form-group row">
	 <h5 class="col-md-12">Salary and Benefit Information</h5>
        <label for="inputPassword" class="col-sm-12 col-form-label"><b>Numeric Salary + Description</b></label>
		<hr>
        <div class="col-md-2">
			<label for="inputPassword" class="col-form-label">Numeric Salary:</label>
		</div>
		<div class="col-md-2">
			 {{session('details.salary')}}
		</div>
		<div class="col-md-2">
			 <label for="inputPassword" class="col-form-label">Salary From :</label>
		</div>
		<div class="col-md-2">
			{{session('details.min')}}
		</div>
		<div class="col-md-2">
			 <label for="inputPassword" class="col-form-label">Salary To :</label>
		</div>
		<div class="col-md-2">
			{{session('details.max')}}
		</div>
		<div class="col-md-2">
			 <label for="inputPassword" class="col-form-label">Salary is per :</label>
		</div>
			<div class="col-md-2">
			
			{{session('details.stype')}}
			</div>
			<div class="col-md-2">
			<label for="inputPassword" class="col-form-label">Salary Benefits :</label>
			</div>
			<div class="col-md-2">
			{{session('details.sdesc')}}
        </div>
		</div>
    </div>
    <div class="form-group row">
		<div class="col-md-2">
        <label for="inputPassword" class="col-form-label">Hide Numeric Salary *:</label>
		</div>
        <div class="col-sm-4">
             {{session('details.hides')}}
        </div>
    </div>
	
	
	<div class="form-group row">

	 <h5 class="col-md-12">Skills and Experience</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Description:</label>
        <div class="col-sm-8">
            
			{{session('details.jdesc')}}
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Minimum Experience:</label>
        <div class="col-sm-4">
            
			{{session('details.mexp')}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Education Level:</label>
        <div class="col-sm-4">
           
			{{session('details.elevel')}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Local Residents only:</label>
        <div class="col-sm-4">
            
			{{session('details.lresi')}}
        </div>
    </div>
	
	<div class="form-group row">

	 <h5 class="col-md-12">Location Information</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Location *:</label>
        <div class="col-sm-5">
            {{session('details.location')}}
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Postcode/Zipcode of job location(optional):</label>
        <div class="col-sm-5">
           
			{{session('details.pcode')}}
        </div>
    </div>
	
	<div class="form-group row">

	 <h5 class="col-md-12">Client and Applicant Information, etc.</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Video URL:</label>
        <div class="col-sm-7">
            
			{{session('details.vurl')}}
        </div>
    </div>
	
	<div class="form-group row">

	 <h5 class="col-md-12">Main Description Details</h5>
        <label for="inputPassword" class="col-sm-4 col-form-label">Job Summary/Introduction *</label>
        <div class="col-sm-7">

             <textarea name="jsum" rows="4" cols="50">  {{strip_tags(session('details.jsum'))}}</textarea>

        </div>
    </div>
	<div class="form-group row">
	
        <label for="inputPassword" class="col-sm-4 col-form-label">Detailed Job Description *</label>
        <div class="col-sm-7">

            <textarea name="djob" rows="4" cols="50">{{strip_tags(session('details.djob'))}}</textarea>

        </div>
    </div>
	
	<div class="form-group row">

	 <h5 class="col-md-12">Posting Time</h5>
        <label for="inputPassword" class="col-sm-4 col-form-label">Deliver this advert at:</label>
        <div class="col-sm-3">
            <select name="posttime">
				
				<option value="Now" >Now</option>
	<option value="12am">12am</option>
	<option value="1am">1am</option>
	<option value="2am">2am</option>
	<option value="3am">3am</option>
	<option value="4am">4am</option>
	<option value="5am">5am</option>
	<option value="6am">6am</option>
	<option value="7am">7am</option>
	<option value="8am">8am</option>
	<option value="9am">9am</option>
	<option value="10am">10am</option>
	<option value="11am">11am</option>
	<option value="12pm">12pm</option>
	<option value="1pm">1pm</option>
	<option value="2pm">2pm</option>
	<option value="3pm">3pm</option>
	<option value="4pm">4pm</option>
	<option value="5pm">5pm</option>
	<option value="6pm">6pm</option>
	<option value="7pm">7pm</option>
	<option value="8pm">8pm</option>
	<option value="9pm">9pm</option>
	<option value="10pm">10pm</option>
	<option value="11pm">11pm</option>
				
			</select>
		</div>
		<div class="col-sm-3">
			 <select name="posttime1">
				
				<option value="<?php echo date('d/m/Y');?>">Today</option>
				<option value="<?php echo $date = date('d/m/Y', strtotime("+1 day"));?>"><?php echo date('l', strtotime("+1 day"));?></option>
				<option value="<?php echo $date = date('d/m/Y', strtotime("+2 day"));?>"><?php echo date('l', strtotime("+2 day"));?></option>
				<option value="<?php echo $date = date('d/m/Y', strtotime("+3 day"));?>"><?php echo date('l', strtotime("+3 day"));?></option>
				<option value="<?php echo $date = date('d/m/Y', strtotime("+4 day"));?>"><?php echo date('l', strtotime("+4 day"));?></option>
				<option value="<?php echo $date = date('d/m/Y', strtotime("+5 day"));?>"><?php echo date('l', strtotime("+5 day"));?></option>
				<option value="<?php echo $date = date('d/m/Y', strtotime("+6 day"));?>"><?php echo date('l', strtotime("+6 day"));?></option>
				<option value="<?php echo $date = date('d/m/Y', strtotime("+7 day"));?>">Week <?php echo date('l', strtotime("+7 day"));?></option>
				<option value="<?php echo $date = date('d/m/Y', strtotime("+8 day"));?>">Week <?php echo date('l', strtotime("+8 day"));?></option>
				<option value="<?php echo $date = date('d/m/Y', strtotime("+9 day"));?>">Week <?php echo date('l', strtotime("+9 day"));?></option>
				<option value="<?php echo $date = date('d/m/Y', strtotime("+10 day"));?>">Week <?php echo date('l', strtotime("+10 day"));?></option>
				<option value="<?php echo $date = date('d/m/Y', strtotime("+11 day"));?>">Week <?php echo date('l', strtotime("+11 day"));?></option>
				<option value="<?php echo $date = date('d/m/Y', strtotime("+12 day"));?>">Week <?php echo date('l', strtotime("+12 day"));?></option>
				<option value="<?php echo $date = date('d/m/Y', strtotime("+13 day"));?>">Week <?php echo date('l', strtotime("+13 day"));?></option>
				
			</select>
        </div>
    </div>
	
	
    <div class="form-group row">
        <div class="col-md-12">
            <button type="submit" class="button-1" name="back" value="back"><span>Prev</span></button>
			<button type="submit" class="button-2 float-md-right" name="next"><span>Next</span></button>
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



