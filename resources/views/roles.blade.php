@extends('layouts.master')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-top:20px;">
                <div class="card-header">{{ __('Manage Roles') }}</div>

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
				   <div >
					<form action="" method="post" id="RolesForm" name="RolesForm">
					@csrf
					@error('business_unit_id')<div class="error" style="color:red;font-weight:bold;">{{ $message }}</div>@enderror 
					@error('state')<div class="error" style="color:red;font-weight:bold;">{{ $message }}</div>@enderror 
					@error('location')<div class="error" style="color:red;font-weight:bold;">{{ $message }}</div>@enderror 
					
					<div class="error" style="color:red;font-weight:bold"></div>
					<select name="business_unit_id" id="business_id">
					<option value="">Select Business ID</option>
					@foreach($business_ids as $business_id)
						<option value="{{$business_id['id']}}" @if( old('business_unit_id')  == $business_id['id']) selected="selected" @endif>{{$business_id['business_unit']}}</option>
					@endforeach
					</select>
					
					<select name="state" id="states">
					 <option value="">Select State</option>
					 <option value="ACT" @if( old('state')  == 'ACT') selected="selected" @endif>ACT</option>
					 <option value="NSW" @if( old('state')  == 'NSW') selected="selected" @endif>NSW</option>
					 <option value="NT" @if( old('state')  == 'NT') selected="selected" @endif>NT</option>
					 <option value="QLD" @if( old('state')  == 'QLD') selected="selected" @endif>QLD</option>
					 <option value="SA" @if( old('state')  == 'SA') selected="selected" @endif>SA</option>
					 <option value="TAS" @if( old('state')  == 'TAS') selected="selected" @endif>TAS</option>
					 <option value="VIC" @if( old('state')  == 'VIC') selected="selected" @endif>VIC</option>
					 <option value="WA" @if( old('state')  == 'WA') selected="selected" @endif>WA</option>
					</select>
					
					<input type="text" id="locationss" name="location" placeholder="Location">  <button type="submit" class="btn btn-primary" id="saveBtn1" value="create">Save changes
                     </button>
					</form>
					</div>
					<div class="table-responsive"> 
						<table id="role">
							<thead>
							<tr>
								<th>ID</th>
								<th>Business Unit </th>
								<th>State</th>
								<th>Location</th>
								<th>Action</th>
							</tr>
							</thead>
						</table>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="LocationForm" name="LocationForm" class="form-horizontal">
                   <input type="hidden" name="id" id="location_id">
				   
				   <div class="form-group">
                        <label class="col-sm-2 control-label">Business_Unit</label>
                        <div class="col-sm-12">
                           <select name="business_unit_id" id="business_unit_id">
					<option>Select Business ID</option>
					@foreach($business_ids as $business_id)
						<option value="{{$business_id['id']}}">{{$business_id['business_unit']}}</option>
					@endforeach
					</select>
                        </div>
                    </div>
					
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">State</label>
                        <div class="col-sm-12">
							<select name="state" id="state">
								<option>Select State</option>
								<option value="ACT">ACT</option>
								<option value="NSW">NSW</option>
								<option value="NT">NT</option>
								<option value="QLD">QLD</option>
								<option value="SA">SA</option>
								<option value="TAS">TAS</option>
								<option value="VIC">VIC</option>
								<option value="WA">WA</option>
							</select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Location</label>
                        <div class="col-sm-12">
                           <input class="form-control" type="text" id="locations"  name="location" placeholder="Location" value="" maxlength="50" required=""> 
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	
	$('#role').DataTable({
		processing: true,
		serverSide: true,
		order: [[ 0, "desc" ]],
		ajax: {
			url: "{{ route('role.index') }}"
		},
		columns: [
			{
				data: 'id',
				name: 'id',
			},
			{
				data: 'business_unit',
				name: 'business_unit',
			},
			{
				data: 'state',
				name: 'state',
			},
			{
				data: 'location',
				name: 'location',
			},
			{
				data: 'action',
				name: 'action',
				orderable: false
			}
		]
	});
});
</script>

<script type="text/javascript">
 $(function () {
	 
  $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
	var table = $('#location').DataTable();
	
  $('body').on('click', '.edit', function () {
	 
	  var Locations_id = $(this).attr('id');
	  
      $.get("location" +'/' + Locations_id +'/edit', function (data) {
		
          $('#modelHeading').html("Edit Location");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#location_id').val(data.id);
		  $('#business_unit_id').val(data.business_unit_id);
          $('#state').val(data.state);
          $('#locations').val(data.location);
      })
  });
  
  $('body').on('click', '.delete', function () {

        var Locations_id = $(this).attr('id');
        var ok =confirm("Are You sure want to delete !");
        if(ok == true){
        $.ajax({
            type: "DELETE",
            url: "location"+'/'+Locations_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
		}
    });
  
  $('#saveBtn').click(function (e) {
        e.preventDefault();
        $.ajax({
          data: $('#LocationForm').serialize(),
          url: "{{ route('location.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {

              $('#LocationForms').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();

          },
          error: function (data) {
			  
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
	
	$('#saveBtn1').click(function (e) {
        e.preventDefault();
        var business_unit_id = $('#business_id').val();
	    var state = $('#states').val();
	    var location = $('#locationss').val();
		//alert(business_unit_id + state + location);
        $.ajax({
          data: {
            business_unit_id: business_unit_id,
            state: state,
            location: location
          },
          url: "{{ route('location.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {

              $('#LocationForms').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();

          },
          error: function (xhr) {
			   var err = JSON.parse(xhr.responseText);
			   if(typeof(err.errors.business_unit_id) != "undefined" && err.errors.business_unit_id !== null)
			   var busi=err.errors.business_unit_id; else busi='';
		       if(typeof(err.errors.state) != "undefined" && err.errors.state !== null)
			   var stat=err.errors.state; else stat='';
		       if(typeof(err.errors.location) != "undefined" && err.errors.location !== null)
			   var loca=err.errors.location; else loca='';
			   $(".error").html("<ul style='list-style-type:none'><li class='first'>"+busi+"</li><li class='mid'>"+stat+"</li><li class='first'>"+loca+"</li></ul>");
			    console.log('Error:', err);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
	
	

 });
 
  </script>
@endsection



