@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" style="margin-top:20px;">
                <div class="card-header">{{ __('Manage Location') }}</div>
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
					<div class="error2" style="color:red;font-weight:bold"></div>
						<div style="margin:20px 0px;"><button style="float:right"  type="submit" class="btn btn-primary" id="addNew" value="create">Add New</button></div>
					</div>
					<div class="table-responsive"> 
						<table id="location" class="cell-border stripe hover row-border">
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
</div><br>

<div class="modal fade loc" id="ajaxModel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="LocationForm" name="LocationForm" class="form-horizontal">
				@csrf
                   <input type="hidden" name="id" id="location_id">
				   <div class="error" style="color:red;font-weight:bold"></div>
				   <div class="form-group">
                        <label class="col-sm-4 unit_label btn btn-light control-label"data-toggle="collapse" data-target="#demo">Select a Business_Unit</label>
						<div id="demo" class="collapse">
                        <div class="col-sm-6">
							@foreach($business_ids as $business_id)
							<div><input type="checkbox" id="business_unit_id" name="business_unit_id" value="{{$business_id['id']}}"> {{$business_id['business_unit']}}</div>
							@endforeach
                        </div>
						</div>
                    </div>
					
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">State</label>
                        <div class="col-sm-12">
							<div class="box"></div>
							<select name="state" id="state" class="box_1">
								<option value="">Select State</option>
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

                    <div class="form-group loc">
                        <label class="col-sm-2 control-label">Location</label>
                        <div class="col-sm-12">
                           <input class="form-control" type="text" id="locations"  name="location" placeholder="Location" value="" maxlength="50" required=""> 
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn2" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
$(document).ready(function(){
	
	$('#location').DataTable({
		processing: true,
		serverSide: true,
		order: [[ 0, "desc" ]],
		ajax: {
			url: "{{ route('location.index') }}"
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
	
	$('#addNew').click(function () {
        $('#saveBtn2').val("create-user");
        $('#location_id').val('');
        $('#LocationForm').trigger("reset");
        $('#modelHeading').html("Create New Location");
        $('#ajaxModel1').modal('show');
		$("input[id=business_unit_id]").attr('checked',false);
		$(".error").html("");
    });

  $('body').on('click', '.edit', function () {
	  var Locations_id = $(this).attr('id');
	  $("input[id=business_unit_id]").attr('checked',false);
      $.get("location" +'/' + Locations_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Location");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel1').modal('show');
          $('#location_id').val(data.id);
		  var values = data.business_unit_id;
		  //check if comma is there
		  if(values.indexOf(',') > -1) var aFirst = values.split(','); else var aFirst= data.business_unit_id;
          for (var i = 0; i < aFirst.length; i++) {		
			$("input[id=business_unit_id][value='"+aFirst[i]+"']").attr('checked',true); 
		  }
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
				$('.error2').text('Record Deleted');
            },
            error: function (data) {
				 console.log('Error:', data);
            }
        });
		}
    });
	
	
	$('#saveBtn2').click(function (e) {
       e.preventDefault();
	   $(".error").html("");
	   var selectArray = $('input[name="business_unit_id"]:checked').map(function () {  
        return this.value;
        }).get().join(",");
		//alert(selectArray); 
		var state = $('#state').val();
	    var location = $('#locations').val();
		var id= $('#location_id').val();
        $.ajax({
          data: {id:id,
			  business_unit_id: selectArray,
              state: state,
              location: location},
              url: "{{ route('location.store') }}",
              type: "POST",
              dataType: 'json',
          success: function (data) {

              $('#LocationForm').trigger("reset");
              $('#ajaxModel1').modal('hide');
              table.draw();
			  $(".error2").text('Changes Updated !!!');
          },
          error: function (xhr) {
			   var err = JSON.parse(xhr.responseText);
			   if(typeof(err.errors)!= "undefined" && err.errors !== null){
			   if(typeof(err.errors.business_unit_id) != "undefined" && err.errors.business_unit_id !== null)
			   var busi=err.errors.business_unit_id; else busi='';
		       if(typeof(err.errors.state) != "undefined" && err.errors.state !== null)
			   var stat=err.errors.state; else stat='';
		       if(typeof(err.errors.location) != "undefined" && err.errors.location !== null)
			   var loca=err.errors.location; else loca='';
			       $(".error").html("<ul style='list-style-type:none'><li class='first'>"+busi+"</li><li class='mid'>"+stat+"</li><li class='first'>"+loca+"</li></ul>");
			    }
			   else{
				   $(".error").html("<ul style='list-style-type:none'><li class='first'>'Location already added for this state'</li></ul>");
			   }
			  //console.log('Error:', err);
              $('#saveBtn2').html('Save Changes');
          }
      });
    });
  
  $('#saveBtn').click(function (e) {
        e.preventDefault();
        //$(this).html('Sending..');
       alert($('#LocationForm').serialize());
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
        //$(this).html('Sending..');
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
			   //$('.error').text(busi + '<br>'+ stat + '<br>'+ loca);
			  $(".error").html("<ul style='list-style-type:none'><li class='first'>"+busi+"</li><li class='mid'>"+stat+"</li><li class='first'>"+loca+"</li></ul>");
			    //$(".error").append("<ul><li class='first'>"+busi+"</li><li class='mid'>"+stat+"</li><li class='first'>"+loca+"</li></ul>");
			   //$(".d-row").append("<ul><li class="first">"+n["AdvertiserId"]+"</li><li class="mid">"+n["AdvertiserName"]+"</li><li class="first">"+n["ContractStatus"]+"</li></ul>");
              console.log('Error:', err);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
	
 });
 
  </script>
@endsection



