@extends('layouts.master')

@section('content')
<div class="container job_board">
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
					<div class="form-group row">
        <label for="inputEmail" class="col-sm-2 col-form-label">Broadcast as *</label>
        <div class="col-sm-5">
            <select name="broadcast">
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
            <input type="text" class="form-control" name="refno" id="reference" value="@if(session('details.refno')) {{session('details.refno')}} @else {{old('refno')}} @endif">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Title. *</label>
        <div class="col-sm-5">
            <input type="text" name="jobtitle" class="form-control" id="job" value="@if(session('details.jobtitle')) {{session('details.jobtitle')}} @else {{old('jobtitle')}} @endif">
        </div>
    </div>
	
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Job Type and Specifies</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Type</label>
        <div class="col-sm-4">
            <select name="jobtype">
				<option value="">Select</option>
				<option value="Permanent">Permanent</option>
				<option value="Contract">Contract</option>
				<option value="Temporary">Temporary</option>
			</select>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Full/Part Time</label>
        <div class="col-sm-4">
           <select name="jobtime">
				<option value="">Select</option>
				<option value="Full-time">Full-time</option>
				<option value="Part-time">Part-time</option>
			</select>
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Bullet Point 1</label>
        <div class="col-sm-6">
            <input type="text" name="bp1" class="form-control" id="bp1" value="@if(session('details.bp1')) {{session('details.bp1')}} @else {{old('bp1')}} @endif">
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Bullet Point 2</label>
        <div class="col-sm-6">
            <input type="text" name="bp2" class="form-control" id="bp2" value="@if(session('details.bp2')) {{session('details.bp2')}} @else {{old('bp2')}} @endif">
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Bullet Point 3</label>
        <div class="col-sm-6">
            <input type="text" name="bp3" class="form-control" id="bp3" value="@if(session('details.bp3')) {{session('details.bp3')}} @else {{old('bp3')}} @endif">
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Proposed Start Date</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="sdate" id="" value="@if(session('details.sdate')) {{session('details.sdate')}} @else {{old('sdate')}} @endif">
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Proposed End Date</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="edate" id="" value="@if(session('details.edate')) {{session('details.edate')}} @else {{old('edate')}} @endif">
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
				<option value="Accountancy">Accountancy</option>
 
  <option value="Admin and Secretarial">Admin and Secretarial</option>
 
  <option value="Advertising and PR">Advertising and PR</option>
 
  <option value="Aerospace">Aerospace</option>
 
  <option value="Agriculture Fishing and Forestry">Agriculture Fishing and Forestry</option>
 
  <option value="Arts">Arts</option>
 
  <option value="Automotive">Automotive</option>
 
  <option value="Banking">Banking</option>
 
  <option value="Building and Construction">Building and Construction</option>
 
  <option value="Call Centre and Customer Service">Call Centre and Customer Service</option>
 
  <option value="Community Services">Community Services </option>
 
  <option value="Consultancy">Consultancy</option>
 
  <option value="Defence and Military">Defence and Military</option>
 
  <option value="Design and Creative">Design and Creative</option>
 
  <option value="Education and Training">Education and Training</option>
 
  <option value="Electronics">Electronics</option>
 
  <option value="Engineering">Engineering</option>
 
  <option value="Fashion">Fashion</option>
 
  <option value="Financial Services">Financial Services</option>
 
  <option value="FMCG">FMCG</option>
 
  <option value="Graduates and Trainees">Graduates and Trainees</option>
 
  <option value="Health and Safety">Health and Safety</option>
 
  <option value="Healthcare ->">Healthcare -&gt;</option>
 
  <option value="Hospitality and Catering">Hospitality and Catering</option>
 
  <option value="Human Resources and Personnel">Human Resources and Personnel</option>
 
  <option value="Insurance">Insurance</option>
 
  <option value="IT">IT</option>
 
  <option value="Legal">Legal</option>
 
  <option value="Leisure and Sport">Leisure and Sport</option>
 
  <option value="Logistics Distribution and Supply Chain">Logistics Distribution and Supply Chain</option>
 
  <option value="Manufacturing and Production">Manufacturing and Production</option>
 
  <option value="Marketing">Marketing</option>
 
  <option value="Media">Media</option>
 
  <option value="Medical and Nursing">Medical and Nursing</option>
 
  <option value="Mining">Mining </option>
 
  <option value="New Media and Internet">New Media and Internet</option>
 
  <option value="Not for Profit and Charities">Not for Profit and Charities</option>
 
  <option value="Oil and Gas">Oil and Gas </option>
 
  <option value="Pharmaceuticals">Pharmaceuticals</option>
 
  <option value="Property and Housing">Property and Housing</option>
 
  <option value="Public Sector and Government">Public Sector and Government</option>
 
  <option value="Purchasing and Procurement">Purchasing and Procurement</option>
 
  <option value="Real Estate and Property">Real Estate and Property </option>
 
  <option value="Recruitment Consultancy">Recruitment Consultancy</option>
 
  <option value="Retail">Retail</option>
 
  <option value="Sales">Sales</option>
 
  <option value="Science and Research">Science and Research</option>
 
  <option value="Senior Appointments">Senior Appointments</option>
 
  <option value="Social Care">Social Care</option>
 
  <option value="Telecommunications">Telecommunications</option>
 
  <option value="Trade and Services">Trade and Services </option>
 
  <option value="Transport and Rail">Transport and Rail</option>
 
  <option value="Travel and Tourism">Travel and Tourism</option>
 
  <option value="Utilities">Utilities</option>
 
  <option value="Other/General">Other/General</option>
			</select>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Classification *</label>
        <div class="col-sm-5">
            <select name="{{$board}}classi">
				<option value="">Select</option>
					<option value="Accountancy">Accountancy</option>
 
  <option value="Admin and Secretarial">Admin and Secretarial</option>
 
  <option value="Advertising and PR">Advertising and PR</option>
 
  <option value="Aerospace">Aerospace</option>
 
  <option value="Agriculture Fishing and Forestry">Agriculture Fishing and Forestry</option>
 
  <option value="Arts">Arts</option>
 
  <option value="Automotive">Automotive</option>
 
  <option value="Banking">Banking</option>
 
  <option value="Building and Construction">Building and Construction</option>
 
  <option value="Call Centre and Customer Service">Call Centre and Customer Service</option>
 
  <option value="Community Services">Community Services </option>
 
  <option value="Consultancy">Consultancy</option>
 
  <option value="Defence and Military">Defence and Military</option>
 
  <option value="Design and Creative">Design and Creative</option>
 
  <option value="Education and Training">Education and Training</option>
 
  <option value="Electronics">Electronics</option>
 
  <option value="Engineering">Engineering</option>
 
  <option value="Fashion">Fashion</option>
 
  <option value="Financial Services">Financial Services</option>
 
  <option value="FMCG">FMCG</option>
 
  <option value="Graduates and Trainees">Graduates and Trainees</option>
 
  <option value="Health and Safety">Health and Safety</option>
 
  <option value="Healthcare ->">Healthcare -&gt;</option>
 
  <option value="Hospitality and Catering">Hospitality and Catering</option>
 
  <option value="Human Resources and Personnel">Human Resources and Personnel</option>
 
  <option value="Insurance">Insurance</option>
 
  <option value="IT">IT</option>
 
  <option value="Legal">Legal</option>
 
  <option value="Leisure and Sport">Leisure and Sport</option>
 
  <option value="Logistics Distribution and Supply Chain">Logistics Distribution and Supply Chain</option>
 
  <option value="Manufacturing and Production">Manufacturing and Production</option>
 
  <option value="Marketing">Marketing</option>
 
  <option value="Media">Media</option>
 
  <option value="Medical and Nursing">Medical and Nursing</option>
 
  <option value="Mining">Mining </option>
 
  <option value="New Media and Internet">New Media and Internet</option>
 
  <option value="Not for Profit and Charities">Not for Profit and Charities</option>
 
  <option value="Oil and Gas">Oil and Gas </option>
 
  <option value="Pharmaceuticals">Pharmaceuticals</option>
 
  <option value="Property and Housing">Property and Housing</option>
 
  <option value="Public Sector and Government">Public Sector and Government</option>
 
  <option value="Purchasing and Procurement">Purchasing and Procurement</option>
 
  <option value="Real Estate and Property">Real Estate and Property </option>
 
  <option value="Recruitment Consultancy">Recruitment Consultancy</option>
 
  <option value="Retail">Retail</option>
 
  <option value="Sales">Sales</option>
 
  <option value="Science and Research">Science and Research</option>
 
  <option value="Senior Appointments">Senior Appointments</option>
 
  <option value="Social Care">Social Care</option>
 
  <option value="Telecommunications">Telecommunications</option>
 
  <option value="Trade and Services">Trade and Services </option>
 
  <option value="Transport and Rail">Transport and Rail</option>
 
  <option value="Travel and Tourism">Travel and Tourism</option>
 
  <option value="Utilities">Utilities</option>
 
  <option value="Other/General">Other/General</option>
			</select>
        </div>
    </div>
	@endforeach 
	
	
	<div class="form-group row">
	
	 
		<div class="col-md-12"><h5>Salary and Benefit Information</h5></div>
			<div class="col-md-12">
				<label for="inputPassword" class="col-form-label">Numeric Salary + Description</label>
			</div>
        <div class="col-md-2">
            <select name="salary">
				<option value="">Select</option>
				<option value="AUD">AUD</option>
				<option value="GBP">GBP</option>
				<option value="EUR">EUR</option>
				<option value="USD">USD</option>
				<option value="NZD">NZD</option>
			</select>
			</div>

			<div class="col-md-2">
			<input type="text" name="min" class="form-control" id="job" placeholder="Minimum" value="@if(session('details.min')) {{session('details.min')}} @else {{old('min')}}@endif">
			</div>
			<div class="col-md-2">
			<input type="text" name="max" class="form-control" placeholder="Maximum" id="job" value="@if(session('details.max')) {{session('details.max')}} @else {{old('max')}}@endif">

			</div>
			<div class="col-md-2">
			<select name="stype">
				<option value="">Select</option>
				<option value="Annum">Annum</option>
				<option value="Month">Month</option>
				<option value="week">Week</option>
				<option value="day">Day</option>
				<option value="hour">Hour</option>
			</select>
			</div>

			<div class="col-md-2">
			<input type="text" name="sdesc" placeholder="Description" class="form-control" id="job" value="@if(session('details.sdesc')) {{session('details.sdesc')}}@else {{old('sdesc')}}@endif">

        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-form-label">Hide Numeric Salary *</label>
        <div class="col-sm-2">
            <select name="hides">
				<option value="">Select</option>
				<option value="Yes">Yes</option>
				<option value="No">No</option>
			</select>
        </div>
    </div>
	
	
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Skills and Experience</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Description</label>
        <div class="col-sm-8">
            <textarea name="jdesc">@if(session('details.jdesc')) {{session('details.jdesc')}} @else {{old('jdesc')}} @endif </textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Minimum Experience</label>
        <div class="col-sm-4">
            <select name="mexp">
				<option value="">Select</option>
				<option value="0">No Minimum</option>
				  <option value="1">1 year</option>  
				  <option value="2">2 years</option>  
				  <option value="3">3 years</option>  
				  <option value="4">4 years</option>
				  <option value="5">5 years</option>
				  <option value="6">6 years</option>
				  <option value="7">7 years</option>
				  <option value="8">8 years</option>
				  <option value="9">9 years</option>
				  <option value="10">10 years</option>
				  <option value="11">11 years</option>
				  <option value="12">12 years</option>
				  <option value="13">13 years</option>
				  <option value="14">14 years</option>
				  <option value="15">15 years</option>
				  <option value="16">16 years</option>
			</select>
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Education Level</label>
        <div class="col-sm-4">
            <select name="elevel">
				<option value="">Select</option>
				<option value="BBTECH_RESERVED_NULL">Not Specified</option> 
			    <option value="Primary School/Junior High">Primary School/Junior High</option>  
			    <option value="Secondary School/High School">Secondary School/High School</option> 
			    <option value="College/Pre-University">College/Pre-University</option>  
			    <option value="Vocational/Professional Qualification">Vocational/Professional Qualification</option>  
			    <option value="Associate Degree/Diploma">Associate Degree/Diploma</option>  
			    <option value="Bachelor Degree">Bachelor Degree</option>  
			    <option value="Post Graduate Diploma">Post Graduate Diploma</option>  
			    <option value="Master's Degree">Master's Degree</option>  
			    <option value="Doctorate (PHD)">Doctorate (PHD)</option>  
			</select>
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Local Residents only</label>
        <div class="col-sm-4">
            <select name="lresi">
				<option value="">Select</option>
				<option value="no">no</option>
				<option value="yes">yes</option>
				
			</select>
        </div>
    </div>
	
	<div class="form-group row">
	
        <label for="inputPassword" class="col-sm-2 col-form-label">Work Permissions</label>
        <div class="col-sm-4">
           <select name="work_permissions">  
  <option value="No permission required to work in the country">No permission required to work in the country</option> 
  <option value="Candidates require a work visa">Candidates require a work visa</option>  
  <option value="Candidates must be a resident of the country">Candidates must be a resident of the country</option>  
</select>
        </div>
    </div>
	
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Location Information</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Location *</label>
        <div class="col-sm-5" id="locationField1">
		
            <input id="autocomplete" type="text" name="location" class="form-control"  id="reference" value="@if(session('details.location')) {{session('details.location')}} @else {{old('location')}} @endif">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Postcode/Zipcode of job location(optional)</label>
        <div class="col-sm-5">
            <input type="text" name="pcode" class="form-control" id="job" value="@if(session('details.pcode')) {{session('details.pcode')}} @else {{old('pcode')}} @endif">
        </div>
    </div>
	
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Client and Applicant Information, etc.</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Video URL</label>
        <div class="col-sm-5">
            <input type="text" name="vurl" class="form-control" id="reference" value="@if(session('details.vurl')) {{session('details.vurl')}} @else {{old('vurl')}} @endif">
        </div>
    </div>
	
	<div class="form-group row">
	
        <label for="inputPassword" class="col-sm-2 col-form-label">Youtube Video Position</label>
        <div class="col-sm-4">
           <select name="vid_pos" > 
			<option value="Above">Above</option> 
			<option value="Below">Below</option>
			</select>
        </div>
    </div>
	
	<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Main Description Details</h5>
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Summary/Introduction *</label>
        <div class="col-sm-7">
             <textarea name="jsum" class="ckeditor">@if(session('details.jsum')) {{session('details.jsum')}} @else {{old('jsum')}} @endif</textarea>
        </div>
    </div>
	<div class="form-group row">
	
        <label for="inputPassword" class="col-sm-2 col-form-label">Detailed Job Description *</label>
        <div class="col-sm-7">
            <textarea name="djob" class="ckeditor">@if(session('details.djob')) {{session('details.djob')}} @else {{old('djob')}} @endif</textarea>
        </div>
    </div>-->
	
	
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4tCB1eAaR4AcLCp5Mq0RTY6hffyIZU_g&libraries=places"></script>
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
		
            var autocomplete;
            function initialize() {
              autocomplete = new google.maps.places.Autocomplete(
                  /** @type {HTMLInputElement} */(document.getElementById('autocomplete')),
                  { types: ['geocode'] });
              google.maps.event.addListener(autocomplete, 'place_changed', function() {
              });
            }
			
			
			
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
</script>


@endsection



