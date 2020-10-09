@extends('layouts.master')

@section('content')
<div class="container job_board" onload="initialize()">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" style="margin-top:20px;">
                <div class="card-header">{{ __('Post Ad') }}</div>
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
						
					</div>-->
				 @endif
				 <div>
				   <b>Job Boards --> Ad Details</b><br>
				   <form method="POST" id="adpost">
				   @csrf
				   <p>Please Enter the details for this advert</p>
				   <p><b>Please provide values for the mandatory fields marked with red astericks</b></p>
				   <p></p>
				   <div class="progress-bar"></div>
				   <fieldset>
					<div class="form-group row">
        <label for="inputEmail" class="col-sm-2 col-form-label">Broadcast as *</label>
        <div class="col-sm-5">
            <select name="broadcast" id="broadcast">
				<option value="">Select</option>
				<option value="Resourcing Team" @if(session('details.broadcast')=='Resourcing Team') selected="selected" @elseif(old('broadcast')=='Resourcing Team') selected="selected" @endif>Resourcing Team</option>
			</select>
        </div>
    </div>
	
    <div class="form-group row">
	 <hr>
	 <div class="col-md-12"><h5>Main Advert Information</h5></div>
        <label for="inputPassword"  class="col-sm-2 col-form-label">Reference No. *</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="refno" id="reference" value="{{$refno}}" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Title. *</label>
        <div class="col-sm-5">
            <input type="text" name="jobtitle" class="form-control" id="job" @if(session('details.jobtitle') !='' || old('jobtitle') !='') value="@if(session('details.jobtitle')) {{session('details.jobtitle')}} @else {{old('jobtitle')}} @endif " @else value="" @endif>
        </div>
    </div>
	<button type="submit" class="button-1" name="back" value="back"><span>Prev</span></button>
	<input type="button" class="next-form btn btn-info" value="Next" />
	</fieldset>
	<fieldset>
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Job Type and Specifies</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Type</label>
        <div class="col-sm-4">
            <select name="jobtype" id="jobtype">
				<option value="">Select</option>
				<option value="Permanent" @if(session('details.jobtype')=='Permanent') selected="selected" @elseif(old('jobtype')=='Permanent') selected="selected" @endif>Permanent</option>
				<option value="Contract" @if(session('details.jobtype')=='Contract') selected="selected" @elseif(old('jobtype')=='Contract') selected="selected" @endif>Contract</option>
				<option value="Temporary" @if(session('details.jobtype')=='Temporary') selected="selected" @elseif(old('jobtype')=='Temporary') selected="selected" @endif>Temporary</option>
			</select>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Full/Part Time</label>
        <div class="col-sm-4">
           <select name="jobtime" id="jobtime">
				<option value="">Select</option>
				<option value="Full-time" @if(session('details.jobtime')=='Full-time') selected="selected" @elseif(old('jobtime')=='Full-time') selected="selected" @endif>Full-time</option>
				<option value="Part-time" @if(session('details.jobtime')=='Part-time') selected="selected" @elseif(old('jobtime')=='Part-time') selected="selected" @endif>Part-time</option>
			</select>
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Bullet Point 1</label>
        <div class="col-sm-6">
            <input type="text" name="bp1" class="form-control" id="bp1" @if(session('details.bp1') !='' || old('bp1') !='') value="@if(session('details.bp1')) {{session('details.bp1')}} @else {{old('bp1')}} @endif" @else value="" @endif>
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Bullet Point 2</label>
        <div class="col-sm-6">
            <input type="text" name="bp2" class="form-control" id="bp2" @if(session('details.bp2') !='' || old('bp2') !='') value="@if(session('details.bp2')) {{session('details.bp2')}} @else {{old('bp2')}} @endif" @else value="" @endif>
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Bullet Point 3</label>
        <div class="col-sm-6">
            <input type="text" name="bp3" class="form-control" id="bp3" @if(session('details.bp3') !='' || old('bp3') !='') value="@if(session('details.bp3')) {{session('details.bp3')}} @else {{old('bp3')}} @endif" @else value="" @endif>
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Proposed Start Date</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="sdate" autocomplete="off" id="sdate" value="@if(session('details.sdate')) {{session('details.sdate')}} @else {{old('sdate')}} @endif">
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Proposed End Date</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="edate" autocomplete="off" id="edate" value="@if(session('details.edate')) {{session('details.edate')}} @else {{old('edate')}} @endif">
        </div>
    </div>
	<input type="button" name="previous" class="previous-form btn btn-default" value="Previous" />
<input type="button" name="next" class="next-form btn btn-info" value="Next" />
	</fieldset>
	
    <fieldset>
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Industry and Sector Information</h5>
	@foreach(Session::get('job') as $board)
	<div class="form-group row">
	 <label for="inputPassword" class="col-sm-2 col-form-label">{{$board}} Industry *</label>
        <div class="col-sm-5">
            <select name="{{$board}}industry" class="boards">
				<option value="">Select</option>
				<option value="Accountancy" @if(session('details.'.$board.'industry')=='Accountancy') selected="selected" @elseif(old($board.'industry')=='Accountancy') selected="selected" @endif>Accountancy</option>
 
  <option value="Admin and Secretarial" @if(session('details.'.$board.'industry')=='Admin and Secretarial') selected="selected" @elseif(old($board.'industry')=='Admin and Secretarial') selected="selected" @endif>Admin and Secretarial</option>
 
  <option value="Advertising and PR" @if(session('details.'.$board.'industry')=='Advertising and PR') selected="selected" @elseif(old($board.'industry')=='Advertising and PR') selected="selected" @endif>Advertising and PR</option>
 
  <option value="Aerospace" @if(session('details.'.$board.'industry')=='Aerospace') selected="selected" @elseif(old($board.'industry')=='Aerospace') selected="selected" @endif>Aerospace</option>
 
  <option value="Agriculture Fishing and Forestry" @if(session('details.'.$board.'industry')=='Agriculture Fishing and Forestry') selected="selected" @elseif(old($board.'industry')=='Agriculture Fishing and Forestry') selected="selected" @endif>Agriculture Fishing and Forestry</option>
 
  <option value="Arts" @if(session('details.'.$board.'industry')=='Arts') selected="selected" @elseif(old($board.'industry')=='Arts') selected="selected" @endif>Arts</option>
 
  <option value="Automotive" @if(session('details.'.$board.'industry')=='Automotive') selected="selected" @elseif(old($board.'industry')=='Automotive') selected="selected" @endif>Automotive</option>
 
  <option value="Banking" @if(session('details.'.$board.'industry')=='Banking') selected="selected" @elseif(old($board.'industry')=='Banking') selected="selected" @endif>Banking</option>
 
  <option value="Building and Construction" @if(session('details.'.$board.'industry')=='Building and Construction') selected="selected" @elseif(old($board.'industry')=='Building and Construction') selected="selected" @endif>Building and Construction</option>
 
  <option value="Call Centre and Customer Service" @if(session('details.'.$board.'industry')=='Call Centre and Customer Service') selected="selected" @elseif(old($board.'industry')=='Call Centre and Customer Service') selected="selected" @endif>Call Centre and Customer Service</option>
 
  <option value="Community Services" @if(session('details.'.$board.'industry')=='Community Services') selected="selected" @elseif(old($board.'industry')=='Community Services') selected="selected" @endif>Community Services </option>
 
  <option value="Consultancy" @if(session('details.'.$board.'industry')=='Consultancy') selected="selected" @elseif(old($board.'industry')=='Consultancy') selected="selected" @endif>Consultancy</option>
 
  <option value="Defence and Military" @if(session('details.'.$board.'industry')=='Defence and Military') selected="selected" @elseif(old($board.'industry')=='Defence and Military') selected="selected" @endif>Defence and Military</option>
 
  <option value="Design and Creative" @if(session('details.'.$board.'industry')=='Design and Creative') selected="selected" @elseif(old($board.'industry')=='Design and Creative') selected="selected" @endif>Design and Creative</option>
 
  <option value="Education and Training" @if(session('details.'.$board.'industry')=='Education and Training') selected="selected" @elseif(old($board.'industry')=='Education and Training') selected="selected" @endif>Education and Training</option>
 
  <option value="Electronics" @if(session('details.'.$board.'industry')=='Electronics') selected="selected" @elseif(old($board.'industry')=='Electronics') selected="selected" @endif>Electronics</option>
 
  <option value="Engineering" @if(session('details.'.$board.'industry')=='Engineering') selected="selected" @elseif(old($board.'industry')=='Engineering') selected="selected" @endif>Engineering</option>
 
  <option value="Fashion" @if(session('details.'.$board.'industry')=='Fashion') selected="selected" @elseif(old($board.'industry')=='Fashion') selected="selected" @endif>Fashion</option>
 
  <option value="Financial Services" @if(session('details.'.$board.'industry')=='Financial Services') selected="selected" @elseif(old($board.'industry')=='Financial Services') selected="selected" @endif>Financial Services</option>
 
  <option value="FMCG" @if(session('details.'.$board.'industry')=='FMCG') selected="selected" @elseif(old($board.'industry')=='FMCG') selected="selected" @endif>FMCG</option>
 
  <option value="Graduates and Trainees" @if(session('details.'.$board.'industry')=='Graduates and Trainees') selected="selected" @elseif(old($board.'industry')=='Graduates and Trainees') selected="selected" @endif>Graduates and Trainees</option>
 
  <option value="Health and Safety" @if(session('details.'.$board.'industry')=='Health and Safety') selected="selected" @elseif(old($board.'industry')=='Health and Safety') selected="selected" @endif>Health and Safety</option>
 
  <option value="Healthcare ->" @if(session('details.'.$board.'industry')=='Healthcare ->') selected="selected" @elseif(old($board.'industry')=='Healthcare ->') selected="selected" @endif>Healthcare -&gt;</option>
 
  <option value="Hospitality and Catering" @if(session('details.'.$board.'industry')=='Hospitality and Catering') selected="selected" @elseif(old($board.'industry')=='Hospitality and Catering') selected="selected" @endif>Hospitality and Catering</option>
 
  <option value="Human Resources and Personnel" @if(session('details.'.$board.'industry')=='Human Resources and Personnel') selected="selected" @elseif(old($board.'industry')=='Human Resources and Personnel') selected="selected" @endif>Human Resources and Personnel</option>
 
  <option value="Insurance" @if(session('details.'.$board.'industry')=='Insurance') selected="selected" @elseif(old($board.'industry')=='Insurance') selected="selected" @endif>Insurance</option>
 
  <option value="IT" @if(session('details.'.$board.'industry')=='IT') selected="selected" @elseif(old($board.'industry')=='IT') selected="selected" @endif>IT</option>
 
  <option value="Legal" @if(session('details.'.$board.'industry')=='Legal') selected="selected" @elseif(old($board.'industry')=='Legal') selected="selected" @endif>Legal</option>
 
  <option value="Leisure and Sport" @if(session('details.'.$board.'industry')=='Leisure and Sport') selected="selected" @elseif(old($board.'industry')=='Leisure and Sport') selected="selected" @endif>Leisure and Sport</option>
 
  <option value="Logistics Distribution and Supply Chain" @if(session('details.'.$board.'industry')=='Logistics Distribution and Supply Chain') selected="selected" @elseif(old($board.'industry')=='Logistics Distribution and Supply Chain') selected="selected" @endif>Logistics Distribution and Supply Chain</option>
 
  <option value="Manufacturing and Production" @if(session('details.'.$board.'industry')=='Manufacturing and Production') selected="selected" @elseif(old($board.'industry')=='Manufacturing and Production') selected="selected" @endif>Manufacturing and Production</option>
 
  <option value="Marketing" @if(session('details.'.$board.'industry')=='Marketing') selected="selected" @elseif(old($board.'industry')=='Marketing') selected="selected" @endif>Marketing</option>
 
  <option value="Media" @if(session('details.'.$board.'industry')=='Media') selected="selected" @elseif(old($board.'industry')=='Media') selected="selected" @endif>Media</option>
 
  <option value="Medical and Nursing" @if(session('details.'.$board.'industry')=='Medical and Nursing') selected="selected" @elseif(old($board.'industry')=='Medical and Nursing') selected="selected" @endif>Medical and Nursing</option>
 
  <option value="Mining" @if(session('details.'.$board.'industry')=='Mining') selected="selected" @elseif(old($board.'industry')=='Mining') selected="selected" @endif>Mining </option>
 
  <option value="New Media and Internet" @if(session('details.'.$board.'industry')=='New Media and Internet') selected="selected" @elseif(old($board.'industry')=='New Media and Internet') selected="selected" @endif>New Media and Internet</option>
 
  <option value="Not for Profit and Charities" @if(session('details.'.$board.'industry')=='Not for Profit and Charities') selected="selected" @elseif(old($board.'industry')=='Not for Profit and Charities') selected="selected" @endif>Not for Profit and Charities</option>
 
  <option value="Oil and Gas" @if(session('details.'.$board.'industry')=='Oil and Gas') selected="selected" @elseif(old($board.'industry')=='Oil and Gas') selected="selected" @endif>Oil and Gas </option>
 
  <option value="Pharmaceuticals" @if(session('details.'.$board.'industry')=='Pharmaceuticals') selected="selected" @elseif(old($board.'industry')=='Pharmaceuticals') selected="selected" @endif>Pharmaceuticals</option>
 
  <option value="Property and Housing" @if(session('details.'.$board.'industry')=='Property and Housing') selected="selected" @elseif(old($board.'industry')=='Property and Housing') selected="selected" @endif>Property and Housing</option>
 
  <option value="Public Sector and Government" @if(session('details.'.$board.'industry')=='Public Sector and Government') selected="selected" @elseif(old($board.'industry')=='Public Sector and Government') selected="selected" @endif>Public Sector and Government</option>
 
  <option value="Purchasing and Procurement" @if(session('details.'.$board.'industry')=='Purchasing and Procurement') selected="selected" @elseif(old($board.'industry')=='Purchasing and Procurement') selected="selected" @endif>Purchasing and Procurement</option>
 
  <option value="Real Estate and Property" @if(session('details.'.$board.'industry')=='Real Estate and Property') selected="selected" @elseif(old($board.'industry')=='Real Estate and Property') selected="selected" @endif>Real Estate and Property </option>
 
  <option value="Recruitment Consultancy" @if(session('details.'.$board.'industry')=='Recruitment Consultancy') selected="selected" @elseif(old($board.'industry')=='Recruitment Consultancy') selected="selected" @endif>Recruitment Consultancy</option>
 
  <option value="Retail" @if(session('details.'.$board.'industry')=='Retail') selected="selected" @elseif(old($board.'industry')=='Retail') selected="selected" @endif>Retail</option>
 
  <option value="Sales" @if(session('details.'.$board.'industry')=='Sales') selected="selected" @elseif(old($board.'industry')=='Sales') selected="selected" @endif>Sales</option>
 
  <option value="Science and Research" @if(session('details.'.$board.'industry')=='Science and Research') selected="selected" @elseif(old($board.'industry')=='Science and Research') selected="selected" @endif>Science and Research</option>
 
  <option value="Senior Appointments" @if(session('details.'.$board.'industry')=='Senior Appointments') selected="selected" @elseif(old($board.'industry')=='Senior Appointments') selected="selected" @endif>Senior Appointments</option>
 
  <option value="Social Care" @if(session('details.'.$board.'industry')=='Social Care') selected="selected" @elseif(old($board.'industry')=='Social Care') selected="selected" @endif>Social Care</option>
 
  <option value="Telecommunications" @if(session('details.'.$board.'industry')=='Telecommunications') selected="selected" @elseif(old($board.'industry')=='Telecommunications') selected="selected" @endif>Telecommunications</option>
 
  <option value="Trade and Services" @if(session('details.'.$board.'industry')=='Trade and Services') selected="selected" @elseif(old($board.'industry')=='Trade and Services') selected="selected" @endif>Trade and Services </option>
 
  <option value="Transport and Rail" @if(session('details.'.$board.'industry')=='Transport and Rail') selected="selected" @elseif(old($board.'industry')=='Transport and Rail') selected="selected" @endif>Transport and Rail</option>
 
  <option value="Travel and Tourism" @if(session('details.'.$board.'industry')=='Travel and Tourism') selected="selected" @elseif(old($board.'industry')=='Travel and Tourism') selected="selected" @endif>Travel and Tourism</option>
 
  <option value="Utilities" @if(session('details.'.$board.'industry')=='Utilities') selected="selected" @elseif(old($board.'industry')=='Utilities') selected="selected" @endif>Utilities</option>
 
  <option value="Other/General" @if(session('details.'.$board.'industry')=='Other/General') selected="selected" @elseif(old($board.'industry')=='Other/General') selected="selected" @endif>Other/General</option>
			</select>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Classification *</label>
        <div class="col-sm-5">
            <select name="{{$board}}classi" class="classis">
				<option value="">Select</option>
					<option value="Accountancy" @if(session('details.'.$board.'classi')=='Accountancy') selected="selected" @elseif(old($board.'classi')=='Accountancy') selected="selected" @endif>Accountancy</option>
 
  <option value="Admin and Secretarial" @if(session('details.'.$board.'classi')=='Admin and Secretarial') selected="selected" @elseif(old($board.'classi')=='Admin and Secretarial') selected="selected" @endif>Admin and Secretarial</option>
 
  <option value="Advertising and PR" @if(session('details.'.$board.'classi')=='Advertising and PR') selected="selected" @elseif(old($board.'classi')=='Advertising and PR') selected="selected" @endif>Advertising and PR</option>
 
  <option value="Aerospace" @if(session('details.'.$board.'classi')=='Aerospace') selected="selected" @elseif(old($board.'classi')=='Aerospace') selected="selected" @endif>Aerospace</option>
 
  <option value="Agriculture Fishing and Forestry" @if(session('details.'.$board.'classi')=='Agriculture Fishing and Forestry') selected="selected" @elseif(old($board.'classi')=='Agriculture Fishing and Forestry') selected="selected" @endif>Agriculture Fishing and Forestry</option>
 
  <option value="Arts" @if(session('details.'.$board.'classi')=='Arts') selected="selected" @elseif(old($board.'classi')=='Arts') selected="selected" @endif>Arts</option>
 
  <option value="Automotive" @if(session('details.'.$board.'classi')=='Automotive') selected="selected" @elseif(old($board.'classi')=='Automotive') selected="selected" @endif>Automotive</option>
 
  <option value="Banking" @if(session('details.'.$board.'classi')=='Banking') selected="selected" @elseif(old($board.'classi')=='Banking') selected="selected" @endif>Banking</option>
 
  <option value="Building and Construction" @if(session('details.'.$board.'classi')=='Building and Construction') selected="selected" @elseif(old($board.'classi')=='Building and Construction') selected="selected" @endif>Building and Construction</option>
 
  <option value="Call Centre and Customer Service" @if(session('details.'.$board.'classi')=='Call Centre and Customer Service') selected="selected" @elseif(old($board.'classi')=='Call Centre and Customer Service') selected="selected" @endif>Call Centre and Customer Service</option>
 
  <option value="Community Services" @if(session('details.'.$board.'classi')=='Community Services') selected="selected" @elseif(old($board.'classi')=='Community Services') selected="selected" @endif>Community Services </option>
 
  <option value="Consultancy" @if(session('details.'.$board.'classi')=='Consultancy') selected="selected" @elseif(old($board.'classi')=='Consultancy') selected="selected" @endif>Consultancy</option>
 
  <option value="Defence and Military" @if(session('details.'.$board.'classi')=='Defence and Military') selected="selected" @elseif(old($board.'classi')=='Defence and Military') selected="selected" @endif>Defence and Military</option>
 
  <option value="Design and Creative" @if(session('details.'.$board.'classi')=='Design and Creative') selected="selected" @elseif(old($board.'classi')=='Design and Creative') selected="selected" @endif>Design and Creative</option>
 
  <option value="Education and Training" @if(session('details.'.$board.'classi')=='Education and Training') selected="selected" @elseif(old($board.'classi')=='Education and Training') selected="selected" @endif>Education and Training</option>
 
  <option value="Electronics" @if(session('details.'.$board.'classi')=='Electronics') selected="selected" @elseif(old($board.'classi')=='Electronics') selected="selected" @endif>Electronics</option>
 
  <option value="Engineering" @if(session('details.'.$board.'classi')=='Engineering') selected="selected" @elseif(old($board.'classi')=='Engineering') selected="selected" @endif>Engineering</option>
 
  <option value="Fashion" @if(session('details.'.$board.'classi')=='Fashion') selected="selected" @elseif(old($board.'classi')=='Fashion') selected="selected" @endif>Fashion</option>
 
  <option value="Financial Services" @if(session('details.'.$board.'classi')=='Financial Services') selected="selected" @elseif(old($board.'classi')=='Financial Services') selected="selected" @endif>Financial Services</option>
 
  <option value="FMCG" @if(session('details.'.$board.'classi')=='FMCG') selected="selected" @elseif(old($board.'classi')=='FMCG') selected="selected" @endif>FMCG</option>
 
  <option value="Graduates and Trainees" @if(session('details.'.$board.'classi')=='Graduates and Trainees') selected="selected" @elseif(old($board.'classi')=='Graduates and Trainees') selected="selected" @endif>Graduates and Trainees</option>
 
  <option value="Health and Safety" @if(session('details.'.$board.'classi')=='Health and Safety') selected="selected" @elseif(old($board.'classi')=='Health and Safety') selected="selected" @endif>Health and Safety</option>
 
  <option value="Healthcare ->" @if(session('details.'.$board.'classi')=='Healthcare ->') selected="selected" @elseif(old($board.'classi')=='Healthcare ->') selected="selected" @endif>Healthcare -&gt;</option>
 
  <option value="Hospitality and Catering" @if(session('details.'.$board.'classi')=='Hospitality and Catering') selected="selected" @elseif(old($board.'classi')=='Hospitality and Catering') selected="selected" @endif>Hospitality and Catering</option>
 
  <option value="Human Resources and Personnel" @if(session('details.'.$board.'classi')=='Human Resources and Personnel') selected="selected" @elseif(old($board.'classi')=='Human Resources and Personnel') selected="selected" @endif>Human Resources and Personnel</option>
 
  <option value="Insurance" @if(session('details.'.$board.'classi')=='Insurance') selected="selected" @elseif(old($board.'classi')=='Insurance') selected="selected" @endif>Insurance</option>
 
  <option value="IT" @if(session('details.'.$board.'classi')=='IT') selected="selected" @elseif(old($board.'classi')=='IT') selected="selected" @endif>IT</option>
 
  <option value="Legal" @if(session('details.'.$board.'classi')=='Legal') selected="selected" @elseif(old($board.'classi')=='Legal') selected="selected" @endif>Legal</option>
 
  <option value="Leisure and Sport" @if(session('details.'.$board.'classi')=='Leisure and Sport') selected="selected" @elseif(old($board.'classi')=='Leisure and Sport') selected="selected" @endif>Leisure and Sport</option>
 
  <option value="Logistics Distribution and Supply Chain" @if(session('details.'.$board.'classi')=='Logistics Distribution and Supply Chain') selected="selected" @elseif(old($board.'classi')=='Logistics Distribution and Supply Chain') selected="selected" @endif>Logistics Distribution and Supply Chain</option>
 
  <option value="Manufacturing and Production" @if(session('details.'.$board.'classi')=='Manufacturing and Production') selected="selected" @elseif(old($board.'classi')=='Manufacturing and Production') selected="selected" @endif>Manufacturing and Production</option>
 
  <option value="Marketing" @if(session('details.'.$board.'classi')=='Marketing') selected="selected" @elseif(old($board.'classi')=='Marketing') selected="selected" @endif>Marketing</option>
 
  <option value="Media" @if(session('details.'.$board.'classi')=='Media') selected="selected" @elseif(old($board.'classi')=='Media') selected="selected" @endif>Media</option>
 
  <option value="Medical and Nursing" @if(session('details.'.$board.'classi')=='Medical and Nursing') selected="selected" @elseif(old($board.'classi')=='Medical and Nursing') selected="selected" @endif>Medical and Nursing</option>
 
  <option value="Mining" @if(session('details.'.$board.'classi')=='Mining') selected="selected" @elseif(old($board.'classi')=='Mining') selected="selected" @endif>Mining </option>
 
  <option value="New Media and Internet" @if(session('details.'.$board.'classi')=='New Media and Internet') selected="selected" @elseif(old($board.'classi')=='New Media and Internet') selected="selected" @endif>New Media and Internet</option>
 
  <option value="Not for Profit and Charities" @if(session('details.'.$board.'classi')=='Not for Profit and Charities') selected="selected" @elseif(old($board.'classi')=='Not for Profit and Charities') selected="selected" @endif>Not for Profit and Charities</option>
 
  <option value="Oil and Gas" @if(session('details.'.$board.'classi')=='Oil and Gas') selected="selected" @elseif(old($board.'classi')=='Oil and Gas') selected="selected" @endif>Oil and Gas </option>
 
  <option value="Pharmaceuticals" @if(session('details.'.$board.'classi')=='Pharmaceuticals') selected="selected" @elseif(old($board.'classi')=='Pharmaceuticals') selected="selected" @endif>Pharmaceuticals</option>
 
  <option value="Property and Housing" @if(session('details.'.$board.'classi')=='Property and Housing') selected="selected" @elseif(old($board.'classi')=='Property and Housing') selected="selected" @endif>Property and Housing</option>
 
  <option value="Public Sector and Government" @if(session('details.'.$board.'classi')=='Public Sector and Government') selected="selected" @elseif(old($board.'classi')=='Public Sector and Government') selected="selected" @endif>Public Sector and Government</option>
 
  <option value="Purchasing and Procurement" @if(session('details.'.$board.'classi')=='Purchasing and Procurement') selected="selected" @elseif(old($board.'classi')=='Purchasing and Procurement') selected="selected" @endif>Purchasing and Procurement</option>
 
  <option value="Real Estate and Property" @if(session('details.'.$board.'classi')=='Real Estate and Property') selected="selected" @elseif(old($board.'classi')=='Real Estate and Property') selected="selected" @endif>Real Estate and Property </option>
 
  <option value="Recruitment Consultancy" @if(session('details.'.$board.'classi')=='Recruitment Consultancy') selected="selected" @elseif(old($board.'classi')=='Recruitment Consultancy') selected="selected" @endif>Recruitment Consultancy</option>
 
  <option value="Retail" @if(session('details.'.$board.'classi')=='Retail') selected="selected" @elseif(old($board.'classi')=='Retail') selected="selected" @endif>Retail</option>
 
  <option value="Sales" @if(session('details.'.$board.'classi')=='Sales') selected="selected" @elseif(old($board.'classi')=='Sales') selected="selected" @endif>Sales</option>
 
  <option value="Science and Research" @if(session('details.'.$board.'classi')=='Science and Research') selected="selected" @elseif(old($board.'classi')=='Science and Research') selected="selected" @endif>Science and Research</option>
 
  <option value="Senior Appointments" @if(session('details.'.$board.'classi')=='Senior Appointments') selected="selected" @elseif(old($board.'classi')=='Senior Appointments') selected="selected" @endif>Senior Appointments</option>
 
  <option value="Social Care" @if(session('details.'.$board.'classi')=='Social Care') selected="selected" @elseif(old($board.'classi')=='Social Care') selected="selected" @endif>Social Care</option>
 
  <option value="Telecommunications" @if(session('details.'.$board.'classi')=='Telecommunications') selected="selected" @elseif(old($board.'classi')=='Telecommunications') selected="selected" @endif>Telecommunications</option>
 
  <option value="Trade and Services" @if(session('details.'.$board.'classi')=='Trade and Services') selected="selected" @elseif(old($board.'classi')=='Trade and Services') selected="selected" @endif>Trade and Services </option>
 
  <option value="Transport and Rail" @if(session('details.'.$board.'classi')=='Transport and Rail') selected="selected" @elseif(old($board.'classi')=='Transport and Rail') selected="selected" @endif>Transport and Rail</option>
 
  <option value="Travel and Tourism" @if(session('details.'.$board.'classi')=='Travel and Tourism') selected="selected" @elseif(old($board.'classi')=='Travel and Tourism') selected="selected" @endif>Travel and Tourism</option>
 
  <option value="Utilities" @if(session('details.'.$board.'classi')=='Utilities') selected="selected" @elseif(old($board.'classi')=='Utilities') selected="selected" @endif>Utilities</option>
 
  <option value="Other/General" @if(session('details.'.$board.'classi')=='Other/General') selected="selected" @elseif(old($board.'classi')=='Other/General') selected="selected" @endif>Other/General</option>

			</select>
        </div>
    </div>
	@endforeach 
	<input type="button" name="previous" class="previous-form btn btn-default" value="Previous" />
<input type="button" name="next" class="next-form btn btn-info" value="Next" />
	</fieldset>
	
	<fieldset>
	<div class="form-group row">
	
	 
		<div class="col-md-12"><h5>Salary and Benefit Information</h5></div>
			<div class="col-md-12">
				<label for="inputPassword" class="col-form-label">Numeric Salary + Description</label>
			</div>
        <div class="col-md-2">
            <select name="salary" id="salary">
				<option value="">Select currency</option>
				<option value="AUD" @if(session('details.salary')=='AUD') selected="selected" @elseif(old('salary')=='AUD') selected="selected" @endif>AUD</option>
				<option value="GBP" @if(session('details.salary')=='GBP') selected="selected" @elseif(old('salary')=='GBP') selected="selected" @endif>GBP</option>
				<option value="EUR" @if(session('details.salary')=='EUR') selected="selected" @elseif(old('salary')=='EUR') selected="selected" @endif>EUR</option>
				<option value="USD" @if(session('details.salary')=='USD') selected="selected" @elseif(old('salary')=='USD') selected="selected" @endif>USD</option>
				<option value="NZD" @if(session('details.salary')=='NZD') selected="selected" @elseif(old('salary')=='NZD') selected="selected" @endif>NZD</option>
			</select>
			</div>

			<div class="col-md-2">
			<input type="text" name="min" class="form-control" id="minsal" placeholder="Minimum Salary"  @if(session('details.min') !='' || old('min') !='')value="@if(session('details.min')) {{session('details.min')}} @else {{old('min')}}@endif" @else value=""@endif>
			</div>
			<div class="col-md-2">
			<input type="text" name="max" class="form-control" placeholder="Maximum Salary" id="maxsal" @if(session('details.max') !='' || old('max') !='')value="@if(session('details.max')) {{session('details.max')}} @else {{old('max')}}@endif" @else value=""@endif>

			</div>
			<div class="col-md-2">
			<select name="stype" id="stype">
				<option value="">Select salary/per</option>
				<option value="Annum" @if(session('details.stype')=='Annum') selected="selected" @elseif(old('stype')=='Annum') selected="selected" @endif>Annum</option>
				<option value="Month" @if(session('details.stype')=='Month') selected="selected" @elseif(old('stype')=='Month') selected="selected" @endif>Month</option>
				<option value="week" @if(session('details.stype')=='week') selected="selected" @elseif(old('stype')=='week') selected="selected" @endif>Week</option>
				<option value="day" @if(session('details.stype')=='day') selected="selected" @elseif(old('stype')=='day') selected="selected" @endif>Day</option>
				<option value="hour" @if(session('details.stype')=='hour') selected="selected" @elseif(old('stype')=='hour') selected="selected" @endif>Hour</option>
			</select>
			</div>

			<div class="col-md-2">
			<input type="text" name="sdesc" placeholder="Salary Description" class="form-control" id="sdesc" @if(session('details.sdesc') !='' || old('sdesc') !='')value="@if(session('details.sdesc')) {{session('details.sdesc')}}@else {{old('sdesc')}}@endif" @else value=""@endif>

        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-form-label">Hide Numeric Salary *</label>
        <div class="col-sm-2">
            <select name="hides" id="hides">
				<option value="">Select</option>
				<option value="Yes"  @if(session('details.hides')=='Yes') selected="selected" @elseif(old('hides')=='Yes') selected="selected" @endif>Yes</option>
				<option value="No" @if(session('details.hides')=='No') selected="selected" @elseif(old('hides')=='No') selected="selected" @endif>No</option>
			</select>
        </div>
    </div>
	<input type="button" name="previous" class="previous-form btn btn-default" value="Previous" />
<input type="button" name="next" class="next-form btn btn-info" value="Next" />
	</fieldset>
	
	<fieldset>
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Skills and Experience</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Description</label>
        <div class="col-sm-8">
            <textarea name="jdesc" id="jdesc">@if(session('details.jdesc')) {{session('details.jdesc')}} @else {{old('jdesc')}} @endif </textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Minimum Experience</label>
        <div class="col-sm-4">
            <select name="mexp" id="mexp">
				<option value="">Select</option>
				<option value="0" @if(session('details.mexp')=='0') selected="selected" @elseif(old('mexp')=='0') selected="selected" @endif>No Minimum</option>
				  <option value="1" @if(session('details.mexp')=='1') selected="selected" @elseif(old('mexp')=='1') selected="selected" @endif>1 year</option>  
				  <option value="2" @if(session('details.mexp')=='2') selected="selected" @elseif(old('mexp')=='2') selected="selected" @endif>2 years</option>  
				  <option value="3" @if(session('details.mexp')=='3') selected="selected" @elseif(old('mexp')=='3') selected="selected" @endif>3 years</option>  
				  <option value="4" @if(session('details.mexp')=='4') selected="selected" @elseif(old('mexp')=='4') selected="selected" @endif>4 years</option>
				  <option value="5" @if(session('details.mexp')=='5') selected="selected" @elseif(old('mexp')=='5') selected="selected" @endif>5 years</option>
				  <option value="6" @if(session('details.mexp')=='6') selected="selected" @elseif(old('mexp')=='6') selected="selected" @endif>6 years</option>
				  <option value="7" @if(session('details.mexp')=='7') selected="selected" @elseif(old('mexp')=='7') selected="selected" @endif>7 years</option>
				  <option value="8" @if(session('details.mexp')=='8') selected="selected" @elseif(old('mexp')=='8') selected="selected" @endif>8 years</option>
				  <option value="9" @if(session('details.mexp')=='9') selected="selected" @elseif(old('mexp')=='9') selected="selected" @endif>9 years</option>
				  <option value="10" @if(session('details.mexp')=='10') selected="selected" @elseif(old('mexp')=='10') selected="selected" @endif>10 years</option>
				  <option value="11" @if(session('details.mexp')=='11') selected="selected" @elseif(old('mexp')=='11') selected="selected" @endif>11 years</option>
				  <option value="12" @if(session('details.mexp')=='12') selected="selected" @elseif(old('mexp')=='12') selected="selected" @endif>12 years</option>
				  <option value="13" @if(session('details.mexp')=='13') selected="selected" @elseif(old('mexp')=='13') selected="selected" @endif>13 years</option>
				  <option value="14" @if(session('details.mexp')=='14') selected="selected" @elseif(old('mexp')=='14') selected="selected" @endif>14 years</option>
				  <option value="15" @if(session('details.mexp')=='15') selected="selected" @elseif(old('mexp')=='15') selected="selected" @endif>15 years</option>
				  <option value="16" @if(session('details.mexp')=='16') selected="selected" @elseif(old('mexp')=='16') selected="selected" @endif>16 years</option>
			</select>
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Education Level</label>
        <div class="col-sm-4">
            <select name="elevel" id="elevel">
				<option value="">Select</option>
				<option value="BBTECH_RESERVED_NULL" @if(session('details.elevel')=='BBTECH_RESERVED_NULL') selected="selected" @elseif(old('elevel')=='BBTECH_RESERVED_NULL') selected="selected" @endif>Not Specified</option> 
			    <option value="Primary School/Junior High" @if(session('details.elevel')=='Primary School/Junior High') selected="selected" @elseif(old('elevel')=='Primary School/Junior High') selected="selected" @endif>Primary School/Junior High</option>  
			    <option value="Secondary School/High School" @if(session('details.elevel')=='Secondary School/High School') selected="selected" @elseif(old('elevel')=='Secondary School/High School') selected="selected" @endif>Secondary School/High School</option> 
			    <option value="College/Pre-University" @if(session('details.elevel')=='College/Pre-University') selected="selected" @elseif(old('elevel')=='College/Pre-University') selected="selected" @endif>College/Pre-University</option>  
			    <option value="Vocational/Professional Qualification" @if(session('details.elevel')=='Vocational/Professional Qualification') selected="selected" @elseif(old('elevel')=='Vocational/Professional Qualification') selected="selected" @endif>Vocational/Professional Qualification</option>  
			    <option value="Associate Degree/Diploma" @if(session('details.elevel')=='Associate Degree/Diploma') selected="selected" @elseif(old('elevel')=='Associate Degree/Diploma') selected="selected" @endif>Associate Degree/Diploma</option>  
			    <option value="Bachelor Degree" @if(session('details.elevel')=='Bachelor Degree') selected="selected" @elseif(old('elevel')=='Bachelor Degree') selected="selected" @endif>Bachelor Degree</option>  
			    <option value="Post Graduate Diploma" @if(session('details.elevel')=='Post Graduate Diploma') selected="selected" @elseif(old('elevel')=='Post Graduate Diploma') selected="selected" @endif>Post Graduate Diploma</option>  
			    <option value="Master's Degree" @if(session('details.elevel')=="Master's Degree") selected="selected" @elseif(old('elevel')=="Master's Degree") selected="selected" @endif>Master's Degree</option>  
			    <option value="Doctorate (PHD)" @if(session('details.elevel')=='Doctorate (PHD)') selected="selected" @elseif(old('elevel')=='Doctorate (PHD)') selected="selected" @endif>Doctorate (PHD)</option>  
			</select>
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Local Residents only</label>
        <div class="col-sm-4">
            <select name="lresi" id="lresi">
				<option value="">Select</option>
				<option value="no" @if(session('details.lresi')=='no') selected="selected" @elseif(old('lresi')=='no') selected="selected" @endif>no</option>
				<option value="yes" @if(session('details.lresi')=='yes') selected="selected" @elseif(old('lresi')=='yes') selected="selected" @endif>yes</option>
				
			</select>
        </div>
    </div>
	
	<div class="form-group row">
	
        <label for="inputPassword" class="col-sm-2 col-form-label">Work Permissions</label>
        <div class="col-sm-4">
           <select name="work_permissions" id="work_permissions">  
  <option value="No permission required to work in the country" @if(session('details.work_permissions')=='No permission required to work in the country') selected="selected" @elseif(old('work_permissions')=='No permission required to work in the country') selected="selected" @endif>No permission required to work in the country</option> 
  <option value="Candidates require a work visa" @if(session('details.work_permissions')=='Candidates require a work visa') selected="selected" @elseif(old('work_permissions')=='Candidates require a work visa') selected="selected" @endif>Candidates require a work visa</option>  
  <option value="Candidates must be a resident of the country" @if(session('details.work_permissions')=='Candidates must be a resident of the country') selected="selected" @elseif(old('work_permissions')=='Candidates must be a resident of the country') selected="selected" @endif>Candidates must be a resident of the country</option>  
</select>
        </div>
    </div>
	<input type="button" name="previous" class="previous-form btn btn-default" value="Previous" />
<input type="button" name="next" class="next-form btn btn-info" value="Next" />
	</fieldset>
	
	<fieldset>
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Location Information</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Location *</label>
        <div class="col-sm-5" id="locationField1">
		
            <input type="text"  name="location" class="form-control locat"  @if(session('details.location') !='' || old('location') !='') value="@if(session('details.location')) {{session('details.location')}} @else {{old('location')}} @endif" @else value="" @endif>
             <!--<input id="autocomplete" type="text" onFocus="geolocate()" name="location" class="form-control"  id="reference" value="@if(session('details.location')) {{session('details.location')}} @else {{old('location')}} @endif">-->
 
		</div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Postcode/Zipcode of job location(optional)</label>
        <div class="col-sm-5">
            <input type="text" name="pcode" id="pcode" class="form-control" id="job" @if(session('details.pcode') !='' || old('pcode') !='') value="@if(session('details.pcode')) {{session('details.pcode')}} @else {{old('pcode')}} @endif" @else value="" @endif>
        </div>
    </div>
	<input type="button" name="previous" class="previous-form btn btn-default" value="Previous" />
<input type="button" name="next" class="next-form btn btn-info" value="Next" />
	</fieldset>
	
	<fieldset>
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Client and Applicant Information, etc.</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Video URL</label>
        <div class="col-sm-5">
            <input type="text" name="vurl" id="vurl" class="form-control" id="reference" @if(session('details.vurl') !='' || old('vurl') !='') value="@if(session('details.vurl')) {{session('details.vurl')}} @else {{old('vurl')}} @endif" @else value="" @endif>
        </div>
    </div>
	
	<div class="form-group row">
	
        <label for="inputPassword" class="col-sm-2 col-form-label">Youtube Video Position</label>
        <div class="col-sm-4">
           <select name="vid_pos" id="vid_pos"> 
			<option value="Above" @if(session('details.vid_pos')=='Above') selected="selected" @elseif(old('vid_pos')=='Above') selected="selected" @endif>Above</option> 
			<option value="Below" @if(session('details.vid_pos')=='Below') selected="selected" @elseif(old('vid_pos')=='Below') selected="selected" @endif>Below</option>
			</select>
        </div>
    </div>
	<input type="button" name="previous" class="previous-form btn btn-default" value="Previous" />
<input type="button" name="next" class="next-form btn btn-info" value="Next" />
	</fieldset>
	
	<fieldset>
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Main Description Details</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Summary/Introduction *</label>
        <div class="col-sm-7">
             <textarea name="jsum" id="jsum" class="ckeditor">@if(session('details.jsum')) {{session('details.jsum')}} @else {{old('jsum')}} @endif</textarea>
			 <div id="err" style="display:none;color:red;">Please enter the Job Summary</div>
        </div>
    </div>
	<div class="form-group row">
	
        <label for="inputPassword" class="col-sm-2 col-form-label">Detailed Job Description *</label>
        <div class="col-sm-7">
            <textarea name="djob" id="djob" class="ckeditor">@if(session('details.djob')) {{session('details.djob')}} @else {{old('djob')}} @endif</textarea>
			<div id="err1" style="display:none;color:red;">Please enter the Detailed Job Description</div>
        </div>
    </div>
	<input type="button" name="previous" class="previous-form btn btn-default" value="Previous" />
	
    <div class="form-group row">
        <div class="col-md-12">
            <!--<button type="submit" class="button-1" name="back" value="back"><span>Prev</span></button>-->
			
			<button type="submit" class="button-2 float-md-right" name="next"><span>Next</span></button>
        </div>
    </div>
	</fieldset>
					</form>
				 </div>
              </div>
           </div>
        </div>
    </div>
</div><br>
<style type="text/css">
#adpost fieldset:not(:first-of-type) {
display: none;
}
select.error, input.error{
	border:2px solid red !important;
}
.error{
	color:red;
}
.errors{
	color:red;
	border:2px solid red !important;
}
.errs{
	content:'Please enter description';
}
</style>

    <link href= 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'> 
 <script src= "https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" > </script> 
<!--script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgP9NffZxolSBM7vbqTEjpShXAHtxcWb4&libraries=places"></script-->
        <script>
		 $( function() {
    $( "#sdate" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  
   $( function() {
    $( "#edate" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
		
		
		$(document).ready(function(){
var form_count = 1, previous_form, next_form, total_forms;
total_forms = $("fieldset").length;

$(".button-2").click(function(e){
	
	 var messageLength = CKEDITOR.instances['jsum'].getData().replace(/<[^>]*>/gi, '').length;
	 
     if( !messageLength ) {
              
				$('#cke_jsum').addClass('errors');
				$('#err').show();
                e.preventDefault();
            }
     var messageLength1 = CKEDITOR.instances['djob'].getData().replace(/<[^>]*>/gi, '').length;
		 
     if( !messageLength1 ) {
              
				$('#cke_djob').addClass('errors');
				$('#err1').show();
                e.preventDefault();
            }
			
			
			var jsum = $('#jsum').val();
			var djob = $('#djob').val();

$.ajax({

									type: "POST",
									url: "/recruitment/draftAdd",
									data: {jsum:jsum,djob:djob},
									dataType: 'json',
									
									success: function(response) {
									}
								});
			
});		

$(".next-form").click(function(){

var form = $("#adpost");
		form.validate({
			
			rules: {
				broadcast: {
					required: true,
				},
				refno: {
					required: true,
				},
				jobtitle: {
					required: true,
					minlength: 4,
				},
				hides: {
					required: true,
				},
				location: {
					required: true,
				},
				jsum: {
					required: true,
				},
				djob: {
					required: true,
				},
			},
			messages: {
				broadcast: {
					required: "broadcast field required",
				},
				refno: {
					required: "Reference no field required",
				},
				jobtitle: {
					required: "Job Title field required",
				},
				hides: {
					required: "Hide Numeric salary required",
				},
				location: {
					required: "Location field required",
				},
				jsum: {
					required: "Job Summary field required",
				},
				djob: {
					required: "Detailed Job Decription field required",
				},
			}
			
			
	});
	
	
	 $('.boards').each(function() {
			 $(this).rules("add", 
            {
                required: true,
                messages: {
                    required: "board is required",
                }
            });
			});
			
	$('.classis').each(function() {
			 $(this).rules("add", 
            {
                required: true,
                messages: {
                    required: "classification is required",
                }
            });
			});
			
		if (form.valid() == true){
        var broad=$('#adpost').val();
		$.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
             
            
            var formData = new FormData($('#adpost')[0]);
			

$.ajax({

									type: "POST",
									url: "/recruitment/draftAdd",
									data: formData,
									dataType: 'json',
									cache : false,
									contentType: false,
									processData: false,
									success: function(response) {
									}
								});

			
previous_form = $(this).parent();
next_form = $(this).parent().next();
next_form.show();
previous_form.hide();
setProgressBarValue(++form_count);
		}
});
$(".previous-form").click(function(){
previous_form = $(this).parent();
next_form = $(this).parent().prev();
next_form.show();
previous_form.hide();
setProgressBarValue(--form_count);
});
setProgressBarValue(form_count);
function setProgressBarValue(value){
var percent = parseFloat(100 / total_forms) * value;
percent = percent.toFixed();
$(".progress-bar")
.css("width",percent+"%")
.html(percent+"%");
}
});		
		
		
		
		//initialize(); #disabled for live use only
            var autocomplete;
            function initialize() {
              autocomplete = new google.maps.places.Autocomplete(
                  /** @type {HTMLInputElement} */(document.getElementById('autocomplete')),
                  { types: ['geocode'] });
              google.maps.event.addListener(autocomplete, 'place_changed', function() {
              });
            }
        </script>
        <script>
		
		$(document).ready(function(){
			$('#adpost').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
			
		});
		
          
			
			
			
			var placeSearch, autocomplete;

var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};

function initAutocomplete() {
  // Create the autocomplete object, restricting the search predictions to
  // geographical location types.
  autocomplete = new google.maps.places.Autocomplete(
      document.getElementById('autocomplete'), {types: ['geocode']});

  // Avoid paying for data that you don't need by restricting the set of
  // place fields that are returned to just the address components.
  autocomplete.setFields(['address_component']);

  // When the user selects an address from the drop-down, populate the
  // address fields in the form.
  autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();

  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }

  // Get each component of the address from the place details,
  // and then fill-in the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle(
          {center: geolocation, radius: position.coords.accuracy});
      autocomplete.setBounds(circle.getBounds());
    });
  }
}
        </script>
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.ckeditor').ckeditor();
		
    });
	
	CKEDITOR.on('instanceReady', function () {
    $.each(CKEDITOR.instances, function (instance) {
        CKEDITOR.instances[instance].document.on("keyup", CK_jQ);
        CKEDITOR.instances[instance].document.on("paste", CK_jQ);
        CKEDITOR.instances[instance].document.on("keypress", CK_jQ);
        CKEDITOR.instances[instance].document.on("blur", CK_jQ);
        CKEDITOR.instances[instance].document.on("change", CK_jQ);
    });
});

function CK_jQ() {
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
}
</script>


@endsection



