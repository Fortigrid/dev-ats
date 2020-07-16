@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-top:20px;">
                <div class="card-header">{{ __('Manage Agency') }}</div>

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
						<button style="float:right"  type="submit" class="btn btn-primary" id="addNew" value="create">Add New</button>
					</div>
					<div class="table-responsive"> 
						<table id="agency" class="cell-border stripe hover row-border">
							<thead>
							<tr>
								<th>ID</th>
								<th>Agency Name</th>
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

<div class="modal fade" id="ajaxModel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="AgencyForm" name="AgencyForm" class="form-horizontal">
				@csrf
                   <input type="hidden" name="id" id="agency_id">
				   <div class="error" style="color:red;font-weight:bold"></div>
				   <div class="error1" style="color:red;font-weight:bold"></div>
				  
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Agency Name</label>
                        <div class="col-sm-12">
                           <input class="form-control" type="text" id="agencys"  name="agency_name" placeholder="Agency name" value="" maxlength="50" required=""> 
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label">Site</label>
                        <div class="col-sm-12" >
							<select id="multiselect" name="sites" multiple="multiple">
							@foreach($sites as $site)
								<option value="{{$site['id']}}"> {{$site['site_name']}}</option>
							@endforeach
							</select>
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
	
	$('#agency').DataTable({
		processing: true,
		serverSide: true,
		order: [[ 0, "desc" ]],
		ajax: {
			url: "{{ route('agency.index') }}"
		},
		columns: [
			{
				data: 'id',
				name: 'id',
			},
			{
				data: 'agency_name',
				name: 'agency_name',
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
	 
	 $('#multiselect').multiselect({
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
	var table = $('#agency').DataTable();
	
	if($('#multiselect').val()==''){
	 $('#saveBtn2').prop('disabled', true);
	}
	
	$('#addNew').click(function () {
        $('#saveBtn2').val("create-user");
        $('#agency_id').val('');
        $('#AgencyForm').trigger("reset");
        $('#modelHeading').html("Create New Agency");
        $('#ajaxModel1').modal('show');
		$(".error").html("");
		$(".error1").html("");
		$('#multiselect').multiselect('refresh');
		if($('#multiselect').val()==''){
			$('#saveBtn2').prop('disabled', true);
		}
    });

   $('body').on('click', '.edit', function () {
	  $('#multiselect').val('');
	  var Agency_id = $(this).attr('id');
	  if($('#multiselect').val()==''){
		$('#saveBtn2').prop('disabled', false);
	  }
	  $(".error").html("");
      $.get("agency" +'/' + Agency_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Agency");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel1').modal('show');
          $('#agency_id').val(data.id);
		  $('#agencys').val(data.agency_name);
		  var values = data.sitess;
		  //check if comma is there
		  if(values.indexOf(',') > -1) var aFirst = values.split(','); else var aFirst= data.clientss;
		  $('#multiselect').multiselect('select', aFirst);
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
	
	$('#multiselect').change(function(){
		if($('#multiselect').val()!=''){
			$('#saveBtn2').prop('disabled', false);
		}
	});

	$('#saveBtn2').click(function (e) {
       e.preventDefault();
	   $(".error").html("");
	   if($('#multiselect').val()==''){
			$(".error1").html("<ul style='list-style-type:none'><li class='first'>Please select atleast one Site</li></ul>");
		}
		else { $(".error1").html(""); }
		var selectArray1 =$('#multiselect').val(); 
		var agency_name = $('#agencys').val();
		var id= $('#agency_id').val();
        $.ajax({
				data: {id:id,
			    agency_site: selectArray1,
                agency_name: agency_name},
				url: "{{ route('agency.store') }}",
				type: "POST",
				dataType: 'json',
		  success: function (data) {

              $('#AgencyForm').trigger("reset");
              $('#ajaxModel1').modal('hide');
              table.draw();
			  $(".error2").text('Changes Updated !!!');
          },
          error: function (xhr) {
			   var err = JSON.parse(xhr.responseText);
			   if(typeof(err.errors)!= "undefined" && err.errors !== null){
			   if(typeof(err.errors.agency_name) != "undefined" && err.errors.agency_name !== null)
					var busi=err.errors.agency_name; else busi='';
					$(".error").html("<ul style='list-style-type:none'><li class='first'>"+busi+"</li></ul>");
			   }
			   else{
				   $(".error").html("<ul style='list-style-type:none'><li class='first'>'Agency already added '</li></ul>");
			   }
			  console.log('Error:', err);
              $('#saveBtn2').html('Save Changes');
          }
      });
    });
  

 });
 
  </script>
@endsection



