@extends('layouts.master')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card recruitment">
                <div class="card-header">{{ __('Manage Site') }}</div>
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
					<button style="float:right"  type="submit" class="button-3" id="addNew" value="create">Add New</button>
				 </div>
				 <div class="table-responsive new"> 
					<table id="site" class="cell-border stripe hover row-border">
						<thead>
							<tr>
								<th>ID</th>
								<th>Site Name</th>
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
                <form id="SiteForm" name="SiteForm" class="form-horizontal">
				@csrf
                   <input type="hidden" name="id" id="site_id">
				   <div class="error" style="color:red;font-weight:bold"></div>
				   <div class="error1" style="color:red;font-weight:bold"></div>
				  
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Site Name</label>
                        <div class="col-sm-12 unit">
                           <input class="form-control effect-1" type="text" id="sites"  name="site_name" placeholder="Site name" value="" maxlength="50" required=""> 
						   <span class="focus-border"></span>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label">Client</label>
                        <div class="col-sm-12" >
							<select id="multiselect" name="clients" multiple="multiple">
							@foreach($clients as $client)
								<option value="{{$client['id']}}"> {{$client['client_name']}}</option>
							@endforeach
							</select>
						</div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="button-3" id="saveBtn2" value="create">Save
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>

</style>
<script type="text/javascript">
$(document).ready(function(){
	
	$('#site').DataTable({
		processing: true,
		serverSide: true,
		order: [[ 0, "desc" ]],
		ajax: {
			url: "{{ route('site.index') }}"
		},
		columns: [
			{
				data: 'id',
				name: 'id',
			},
			{
				data: 'site_name',
				name: 'site_name',
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
            filterPlaceholder: 'Search for something...',
			maxHeight: 300
        }); 
	 
	 $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
	var table = $('#site').DataTable();
	
	if($('#multiselect').val()==''){
	 //$('#saveBtn2').prop('disabled', true);
	}
	
	$('#addNew').click(function () {
        $('#saveBtn2').val("create-user");
        $('#site_id').val('');
        $('#SiteForm').trigger("reset");
        $('#modelHeading').html("Create New Site");
        $('#ajaxModel1').modal('show');
		$(".error").html("");
		$(".error1").html("");
		 $('#multiselect').multiselect('refresh');
		 if($('#multiselect').val()==''){
			//$('#saveBtn2').prop('disabled', true);
		}
    });

   $('body').on('click', '.edit', function () {
	  $('#multiselect').val('');
	  $('#multiselect').multiselect('refresh');
	  var Site_id = $(this).attr('id');
	  if($('#multiselect').val()==''){
		//$('#saveBtn2').prop('disabled', false);
	  }
	  $(".error").html("");
      $.get("site" +'/' + Site_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Site");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel1').modal('show');
          $('#site_id').val(data.id);
		  $('#sites').val(data.site_name);
		  var values = data.clientss;
		  //check if comma is there
		  if(values.indexOf(',') > -1) var aFirst = values.split(','); else var aFirst= data.clientss;
		  $('#multiselect').multiselect('select', aFirst);
      })
  });
  
  $('body').on('click', '.delete', function () {
        var Site_id = $(this).attr('id');
        var ok =confirm("Are You sure want to delete !");
        if(ok == true){
        $.ajax({
            type: "DELETE",
            url: "site"+'/'+Site_id,
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
	
	$('#multiselect').change(function(){
		if($('#multiselect').val()!=''){
			//$('#saveBtn2').prop('disabled', false);
		}
	});
	
	$('#saveBtn2').click(function (e) {
       e.preventDefault();
	   $(".error").html("");
	   if($('#multiselect').val()==''){
			//$(".error1").html("<ul style='list-style-type:none'><li class='first'>Please select atleast one Client</li></ul>"); 
		}
	   else { $(".error1").html(""); }
	   var selectArray1 =$('#multiselect').val();
	   var site_name = $('#sites').val();
	   var id= $('#site_id').val();
        $.ajax({
           data: {id:id,
			   site_client: selectArray1,
               site_name: site_name},
               url: "{{ route('site.store') }}",
               type: "POST",
               dataType: 'json',
          success: function (data) {
              $('#SiteForm').trigger("reset");
              $('#ajaxModel1').modal('hide');
              table.draw();
			  $(".error2").text('Changes Updated !!!');
          },
          error: function (xhr) {
			   var err = JSON.parse(xhr.responseText);
			   if(typeof(err.errors)!= "undefined" && err.errors !== null){
			   if(typeof(err.errors.site_name) != "undefined" && err.errors.site_name !== null)
					var busi=err.errors.site_name; else busi='';
				if(typeof(err.errors.site_client) != "undefined" && err.errors.site_client !== null)
			    var busi1=err.errors.site_client; else busi1='';
					$(".error").html("<ul style='list-style-type:none'><li class='first'>"+busi+"</li><li class='first'>"+busi1+"</li></ul>");
			   }
			   else{
				   $(".error").html("<ul style='list-style-type:none'><li class='first'>'Site already added '</li></ul>");
			   }
			  console.log('Error:', err);
              $('#saveBtn2').html('Save Changes');
          }
      });
    });
  
 });
 
  </script>
@endsection



