@extends('layouts.master')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mtop">
                <div class="card-header">{{ __('Manage Client') }}</div>
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
				 <div class="table-responsive new"> 
						<table id="client" class="cell-border stripe hover row-border">
							<thead>
							<tr>
								<th>ID</th>
								<th>Client Name</th>
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
                <form id="ClientForm" name="ClientForm" class="form-horizontal">
				@csrf
                   <input type="hidden" name="id" id="client_id">
				   <div class="error" style="color:red;font-weight:bold"></div>
				   <div class="error1" style="color:red;font-weight:bold"></div>
				  
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Client Name</label>
                        <div class="col-sm-12">
                           <input class="form-control" type="text" id="clients"  name="client_name" placeholder="Client name" value="" maxlength="50" required=""> 
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label">Location</label>
                        <div class="col-sm-12" >
							<select id="multiselect" name="locations" multiple="multiple">
							@foreach($locations as $location)
								<option value="{{$location['id']}}"> {{$location['location']}}</option>
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
<style>

</style>
<script type="text/javascript">
$(document).ready(function(){
	
	$('#client').DataTable({
		processing: true,
		serverSide: true,
		order: [[ 0, "desc" ]],
		ajax: {
			url: "{{ route('client.index') }}"
		},
		columns: [
			{
				data: 'id',
				name: 'id',
			},
			{
				data: 'client_name',
				name: 'client_name',
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
	var table = $('#client').DataTable();
	if($('#multiselect').val()==''){
	 //$('#saveBtn2').prop('disabled', true);
	}
	
	$('#addNew').click(function () {
        $('#saveBtn2').val("create-user");
        $('#client_id').val('');
        $('#ClientForm').trigger("reset");
        $('#modelHeading').html("Create New Client");
        $('#ajaxModel1').modal('show');
		$("input[id=locations]").attr('checked',false);
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
	  
	  var Client_id = $(this).attr('id');
	  if($('#multiselect').val()==''){
			//$('#saveBtn2').prop('disabled', false);
	  }
	  //$("input[id=locations]").attr('checked',false);
	  $(".error").html("");
	  console.log($('#multiselect').val());
	    
      $.get("client" +'/' + Client_id +'/edit', function (data) {
		 
          $('#modelHeading').html("Edit Client");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel1').modal('show');
          $('#client_id').val(data.id);
		  $('#clients').val(data.client_name);
		 
		  if(data.locationss != ''){
			   //alert(data.locationss);
			values = data.locationss;
			if(values.indexOf(',') > -1) aFirst = values.split(','); else aFirst= data.locationss;
				$('#multiselect').multiselect('select', aFirst);
		  }
		  else{
			 // alert(data.locationss);
			  $('.error').text("The Location which was selected, doesn't exist. Please select another location.");
		  }
      })
	  
  });
  
  $('body').on('click', '.delete', function () {
        var Client_id = $(this).attr('id');
        var ok =confirm("Are You sure want to delete !");
        if(ok == true){
        $.ajax({
            type: "DELETE",
            url: "client"+'/'+Client_id,
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
			//$(".error1").html("<ul style='list-style-type:none'><li class='first'>Please select atleast one Location</li></ul>");
		}
		else { $(".error1").html("");}
		var selectArray1 =$('#multiselect').val();
		var client_name = $('#clients').val();
		var id= $('#client_id').val();
        $.ajax({
          data: {id:id,
			  client_location: selectArray1,
              client_name: client_name},
              url: "{{ route('client.store') }}",
              type: "POST",
              dataType: 'json',
          success: function (data) {
              $('#ClientForm').trigger("reset");
              $('#ajaxModel1').modal('hide');
              table.draw();
			  $(".error2").text('Changes Updated !!!');
          },
          error: function (xhr) {
			   var err = JSON.parse(xhr.responseText);
			   if(typeof(err.errors)!= "undefined" && err.errors !== null){
			    if(typeof(err.errors.client_name) != "undefined" && err.errors.client_name !== null)
			    var busi=err.errors.client_name; else busi='';
			    if(typeof(err.errors.client_location) != "undefined" && err.errors.client_location !== null)
			    var busi1=err.errors.client_location; else busi1='';
			       $(".error").html("<ul style='list-style-type:none'><li class='first'>"+busi+"</li><li class='first'>"+busi1+"</li></ul>");
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



