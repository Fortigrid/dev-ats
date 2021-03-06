@extends('layouts.master')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" style="margin-top:20px;">
                <div class="card-header">{{ __('Manage Business Unit') }}</div>

                <div class="card-body">
					<div>
					<form action="" method="post" id="BusinessForms">
					<div class="business">
						<button type="button" class="ad_btn" data-toggle="collapse" data-target="#demo">Add Business Unit</button>
					</div>
					<div id="demo" class="collapse business">
					@csrf
					<div class="error" style="color:red;font-weight:bold"></div>
					<div class="unit"><input type="text" class="effect-2" id="business_units" name="business_unit" placeholder="Business Unit" required> 
					<span class="focus-border"></span>
					<!--<input type="submit" name="submit" value="Add Business Unit">-->
					<span class="dld" type="submit"  id="saveBtn1" value="create"><img src="{{ asset('css/img/save-icon.png') }}" />
                     </span>
					@error('business_unit')<div class="error" style="color:red;font-weight:bold;">{{ $message }}</div>@enderror 
					</div>
					</div><hr>
					</form>
					</div>
					<div class="table-responsive table-striped"> 
						<table id="business" class="cell-border stripe hover row-border">
							<thead>
							<tr>
								<th>ID</th>
								<th>Business Unit</th>
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
				<button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
			<div class="error1" style="color:red;font-weight:bold"></div>
                <form id="BusinessForm" name="BusinessForm" class="form-horizontal">
				@csrf
                   <input type="hidden" name="id" id="business_id">
				  

                    <div class="form-group">
                        <label class="col-sm-6 control-label">Business Unit</label>
                        <div class="col-sm-12 unit">
                           
							  <input class="form-control effect-1" type="text" id="business_unit"  name="business_unit" placeholder="Business Unit" value="" maxlength="50"> 
								<span class="focus-border"></span>
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="button-3" id="saveBtn" value="create">Save
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	
	$('#business').DataTable({
		processing: true,
		serverSide: true,
		order: [[ 0, "desc" ]],
		ajax: {
			url: "{{ route('business.index') }}"
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
	var table = $('#business').DataTable();
  $('body').on('click', '.edit', function () {
	 
	  var Business_id = $(this).attr('id');
	  
      $.get("business" +'/' + Business_id +'/edit', function (data) {
		
          $('#modelHeading').html("Edit Business");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#business_id').val(data.id);
		  $('#business_unit').val(data.business_unit);
      })
  });
  
  $('body').on('click', '.delete', function () {

        var Business_id = $(this).attr('id');
        var ok =confirm("Are You sure want to delete !");
        if(ok == true){
        $.ajax({
            type: "DELETE",
            url: "business"+'/'+Business_id,
            success: function (data) {
                table.draw();
				$('.error').text('Record Deleted');
            },
            error: function (data) {
				 
                console.log('Error:', data);
            }
        });
		}
    });
  
  $('#saveBtn').click(function (e) {
        e.preventDefault();
        //$(this).html('Sending..');
       //alert($('#BusinessForm').serialize());
        $.ajax({
          data: $('#BusinessForm').serialize(),
          url: "{{ route('business.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {

              $('#BusinessForms').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
			   $('.error').text('Business Unit Updated !!!');

          },
          error: function (xhr) {
			  var err = JSON.parse(xhr.responseText);
			   $('.error1').text(err.errors.business_unit);
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
	
	$('#saveBtn1').click(function (e) {
        e.preventDefault();
        //$(this).html('Sending..');
      var business_unit = $('#business_units').val();
	   
		//alert(business_unit_id + state + location);
        $.ajax({
          data: {
            business_unit: business_unit
          },
          url: "{{ route('business.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {

              $('#BusinessForms').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
			  $('.error').text('New Business Unit Added !!!');

          },
          error: function (xhr) {
			  var err = JSON.parse(xhr.responseText);
			   $('.error').text(err.errors.business_unit);
              console.log('Error:', JSON.stringify(xhr.responseText));
              $('#saveBtn').html('Save Changes');
          }
      });
    });
	
	

 });
 
  </script>

@endsection



