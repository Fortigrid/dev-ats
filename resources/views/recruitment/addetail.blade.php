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
				   <form method="POST">
				   @csrf
				   <p>Please Enter the details for this advert</p>
				   <p>Please provide values for the mandatory fields marked with red astericks</p>
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
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Main Advert Information</h5>
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
				<option value="IT">IT</option>
			</select>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Job Classification *</label>
        <div class="col-sm-5">
            <select name="{{$board}}classi">
				<option value="">Select</option>
				<option value="Admin">Admin</option>
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
				<option value="AUD">AUD</option>
			</select>
			</div>
			<div class="col-sm-2">
			<input type="text" name="min" class="form-control" id="job" value="@if(session('details.min')) {{session('details.min')}} @else {{old('min')}} @endif ">
			</div>
			<div class="col-sm-2">
			<input type="text" name="max" class="form-control" id="job" value="@if(session('details.max')) {{session('details.max')}} @else {{old('max')}} @endif ">
			</div>
			<div class="col-sm-1">
			<select name="stype">
				<option value="">Select</option>
				<option value="Annum">Annum</option>
				<option value="Monthly">Monthly</option>
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
				<option value="No Minimum">No Minimum</option>
			</select>
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Education Level</label>
        <div class="col-sm-4">
            <select name="elevel">
				<option value="">Select</option>
				<option value="Not Specified">Not Specified</option>
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
        <div class="col-sm-7">
            <input type="text" name="vurl" class="form-control" id="reference" value="@if(session('details.vurl')) {{session('details.vurl')}} @else {{old('vurl')}} @endif">
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
    </div>
	
	
    <div class="form-group row">
        <div class="col-sm-10 offset-sm-2">
		   
            <button type="submit" class="btn btn-primary" name="back" value="back">Prev</button> <button type="submit" class="btn btn-primary" name="next">Next</button>
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



