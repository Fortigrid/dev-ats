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
					
					@csrf
					<div class="error2" style="color:red;font-weight:bold"></div>
					<button type="submit" class="btn btn-primary" id="addNew" value="create" style="float:right">Add New</button>
					
					</div>
					<div class="table-responsive"> 
						<table id="role">
							<thead>
							<tr>
								<th>ID</th>
								<th>Role Name</th>
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

<div class="modal fade" id="ajaxModel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="RoleForm" name="RoleForm" class="form-horizontal">
				@csrf
                   <input type="hidden" name="id" id="role_id">
				   <div class="error" style="color:red;font-weight:bold"></div>
				   <div class="form-group">
                        <label class="col-sm-6 control-label">Role Name</label>
                        <div class="col-sm-12">
                           <input class="form-control" type="text" id="roles"  name="role_name" placeholder="Role Name" value="" maxlength="50" required=""> 
                        </div>
                    </div>
				   <div class="form-group">
                        <label class="col-sm-2 control-label">Business_Unit</label>
                        <div class="col-sm-12">
                           <select name="business_unit" id="business_unit" multiple="multiple">
					
					@foreach($business_ids as $business_id)
						<option value="{{$business_id['id']}}">{{$business_id['business_unit']}}</option>
					@endforeach
					</select>
                        </div>
                    </div>
					
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Location</label>
                        <div class="col-sm-12">
							 <select name="location" id="location" multiple="multiple">
					
					@foreach($locations as $location)
						<option value="{{$location['id']}}">{{$location['location']}}</option>
					@endforeach
					</select>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Client</label>
                        <div class="col-sm-12">
							 <select size="10" name="client" id="client" multiple="multiple">
					
					@foreach($clients as $client)
						<option value="{{$client['id']}}">{{$client['client_name']}}</option>
					@endforeach
					</select>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Site</label>
                        <div class="col-sm-12">
							 <select name="site" id="site" multiple="multiple">
					
					@foreach($sites as $site)
						<option value="{{$site['id']}}">{{$site['site_name']}}</option>
					@endforeach
					</select>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Agency</label>
                        <div class="col-sm-12">
							 <select name="agency" id="agency" multiple="multiple">
					
					@foreach($agencies as $agency)
						<option value="{{$agency['id']}}">{{$agency['agency_name']}}</option>
					@endforeach
					</select>
                        </div>
                    </div>
					


                    <!--<div class="form-group">
                        <label class="col-sm-2 control-label">Location</label>
                        <div class="col-sm-12">
                           <input class="form-control" type="text" id="locations"  name="location" placeholder="Location" value="" maxlength="50" required=""> 
                        </div>
                    </div>-->

                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn2" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
ul.dropdown-menu{
	overflow-y:scroll !important;
	height:300px !important;
}
</style>
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
				data: 'role_name',
				name: 'role_name',
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
	 
   $('#business_unit').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
			enableHTML: false,
            filterPlaceholder: 'Search for something...',
			onChange: function(option, checked, select) {
                //alert('Changed option ' + $(option).val() + '.');
				$('#location').val('');
		$('#client').val('');
		$('#site').val('');
		$('#agency').val('');
            }
        }); 
	$('#location').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
			enableHTML: false,
            filterPlaceholder: 'Search for something...'
        });
	$('#client').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
			enableHTML: false,
            filterPlaceholder: 'Search for something...'
        }); 
	$('#site').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
			enableHTML: false,
            filterPlaceholder: 'Search for something...'
        }); 
	$('#agency').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
			enableHTML: false,
            filterPlaceholder: 'Search for something...'
        }); 
	 
	 $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
	var table = $('#role').DataTable();
	if($('#multiselect').val()==''){
	 //$('#saveBtn2').prop('disabled', true);
	}
	
	$('#addNew').click(function () {
		$('#business_unit').val('');
	    $('#location').val('');
		$('#client').val('');
		$('#site').val('');
		$('#agency').val('');
		$('#business_unit').multiselect('refresh');
		$('#location').multiselect('refresh'); 
		$('#client').multiselect('refresh');
		$('#site').multiselect('refresh');
		$('#agency').multiselect('refresh');
        $('#saveBtn2').val("create-user");
        $('#role_id').val('');
        $('#RoleForm').trigger("reset");
        $('#modelHeading').html("Create New Role");
        $('#ajaxModel1').modal('show');
		//$("input[id=locations]").attr('checked',false);
		$(".error").html("");
		$(".error1").html("");
		 //$('#multiselect').multiselect('refresh');
		
    });

  $('body').on('click', '.edit', function () {
		$('#business_unit').val('');
		$('#location').val('');
		$('#client').val('');
		$('#site').val('');
		$('#agency').val('');
	    $('#business_unit').multiselect('refresh');
		$('#location').multiselect('refresh'); 
		$('#client').multiselect('refresh');
		$('#site').multiselect('refresh');
		$('#agency').multiselect('refresh');
	  var Role_id = $(this).attr('id');
	 
	  $(".error").html("");
      $.get("role" +'/' + Role_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Role");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel1').modal('show');
          $('#role_id').val(data.id);
		  $('#roles').val(data.role_name);
		  var values = data.business;
		  var values1 = data.locations;
		  var values2 = data.clients;
		  var values3 = data.sites;
		  var values4 = data.agencies;
		  if(values.indexOf(',') > -1) var aFirst = values.split(','); else var aFirst= data.business;
		  if(values1.indexOf(',') > -1) var aFirst1 = values1.split(','); else var aFirst1= data.locations;
		  if(values2.indexOf(',') > -1) var aFirst2 = values2.split(','); else var aFirst2= data.clients;
		  if(values3.indexOf(',') > -1) var aFirst3 = values3.split(','); else var aFirst3= data.sites;
		  if(values4.indexOf(',') > -1) var aFirst4 = values4.split(','); else var aFirst4= data.agencies;
		  $('#business_unit').multiselect('select', aFirst);
		  $('#location').multiselect('select', aFirst1);
		  $('#client').multiselect('select', aFirst2);
		  $('#site').multiselect('select', aFirst3);
		  $('#agency').multiselect('select', aFirst4);
      })
  });
  
  $('body').on('click', '.delete', function () {
        var Role_id = $(this).attr('id');
        var ok =confirm("Are You sure want to delete !");
        if(ok == true){
        $.ajax({
            type: "DELETE",
            url: "role"+'/'+Role_id,
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
	
	$('#business_unit').change(function(){

		var businessArray =$('#business_unit').val();
		$('#business_unit').multiselect('refresh');
		 $('#location').multiselect('refresh');
		 $('#client').multiselect('refresh');
		 $('#site').multiselect('refresh');
		 $('#agency').multiselect('refresh');
		var data1='';
		$('#location').val();
		$.ajax({
          data: {
			  business_unit: businessArray
			  },
              url: "/home",
              type: "POST",
              dataType: 'json',
          success: function (data1) {
			 
			  if(data1 !=''){ 
			 
			 $('#business_unit').multiselect('refresh');
			  $('#location').multiselect('refresh'); 
			  $('#client').multiselect('refresh');
				$('#site').multiselect('refresh');
				$('#agency').multiselect('refresh');
              $('#location').multiselect('select',data1.loc.split(','));
			   $('#client').multiselect('select',data1.client.split(','));
			    $('#site').multiselect('select',data1.site.split(','));
				$('#agency').multiselect('select',data1.agency.split(','));
			  }
		      else { //alert('notok'); 
			  $('#business_unit').val('');
			  $('#location').val('');
			  $('#client').val('');
				$('#site').val('');
				$('#agency').val('');
			  $('#business_unit').multiselect('refresh');
			  $('#location').multiselect('refresh'); 
			  $('#client').multiselect('refresh');
				$('#site').multiselect('refresh');
				$('#agency').multiselect('refresh');
			  }
			  //$('#location').multiselect('select',data.getv);
			  //$(".error2").text('Changes Updated !!!');
          },
          error: function (xhr) {
			  console.log('Error:', err);
		  }
		});
	});
	
	$('#saveBtn2').click(function (e) {
        e.preventDefault();
	    $(".error").html("");
	    
		var businessArray =$('#business_unit').val();
		var locationArray =$('#location').val();
		var clientArray =$('#client').val();
		var siteArray =$('#site').val();
		var agencyArray =$('#agency').val();
		var role_name = $('#roles').val();
		var id= $('#role_id').val();
        $.ajax({
          data: {id:id,
			  role_business_unit: businessArray,
			  role_location: locationArray,
			  role_client: clientArray,
			  role_site: siteArray,
			  role_agency: agencyArray,
              role_name: role_name},
              url: "{{ route('role.store') }}",
              type: "POST",
              dataType: 'json',
          success: function (data) {
              $('#RoleForm').trigger("reset");
              $('#ajaxModel1').modal('hide');
              table.draw();
			  $(".error2").text('Changes Updated !!!');
          },
          error: function (xhr) {
			   var err = JSON.parse(xhr.responseText);
			   if(typeof(err.errors)!= "undefined" && err.errors !== null){
			    if(typeof(err.errors.role_name) != "undefined" && err.errors.role_name !== null)
			    var busi=err.errors.role_name; else busi='';
			    if(typeof(err.errors.role_business_unit) != "undefined" && err.errors.role_business_unit !== null)
			    var busi1=err.errors.role_business_unit; else busi1='';
			    if(typeof(err.errors.role_location) != "undefined" && err.errors.role_location !== null)
			    var busi2=err.errors.role_location; else busi2='';
			    if(typeof(err.errors.role_client) != "undefined" && err.errors.role_client !== null)
			    var busi3=err.errors.role_client; else busi3='';
				if(typeof(err.errors.role_site) != "undefined" && err.errors.role_site !== null)
			    var busi4=err.errors.role_site; else busi4='';
				if(typeof(err.errors.role_agency) != "undefined" && err.errors.role_agency !== null)
			    var busi5=err.errors.role_agency; else busi5='';
			       $(".error").html("<ul style='list-style-type:none'><li class='first'>"+busi+"</li><li class='first'>"+busi1+"</li><li class='first'>"+busi2+"</li><li class='first'>"+busi3+"</li><li class='first'>"+busi4+"</li><li class='first'>"+busi5+"</li></ul>");
			   }
			   else{
				   $(".error").html("<ul style='list-style-type:none'><li class='first'>'Client already added '</li></ul>");
			   }
			  console.log('Error:', err);
              $('#saveBtn2').html('Save Changes');
          }
      });
    });
	

 });
 
  </script>
@endsection



