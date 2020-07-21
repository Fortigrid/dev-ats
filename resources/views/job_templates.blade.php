@extends('layouts.master')


@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-top:20px;">
                <div class="card-header">{{ __('Manage Job Template') }}</div>
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
					<div class="error2" style="color:white;font-weight:bold;display:none"></div>
					<button style="float:right"  type="submit" class="btn btn-primary" id="addNew" value="create">Add New</button>
					</div>
					<div class="table-responsive"> 
						<table id="job_template" class="cell-border stripe hover row-border">
							<thead>
							<tr>
								<th>ID</th>
								<th>Business Unit </th>
								<th>Template Name</th>
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
			
                <form id="JtForm" name="JtForm" class="form-horizontal" enctype="multipart/form-data">
				@csrf
				<div class="alert alert-danger print-error-msg" style="display:none">
        <ul></ul>
    </div>
                   <input type="hidden" name="id" id="job_id">
				   <div class="error alert alert-danger" style="color:white;font-weight:bold;display:none"></div>
				   <div class="form-group">
                        <label class="col-sm-2 control-label">Business_Unit</label>
                        <div class="col-sm-12">
						   <select id="business_unit_id" name="business_unit_id">
						   <option value="">Select Business ID</option>
							@foreach($business_ids as $business_id)
							<option    value="{{$business_id['id']}}"> {{$business_id['business_unit']}} </option>
							@endforeach
							</select>
                        </div>
                    </div>
					

                    <div class="form-group">
                        <label class="col-sm-8 control-label">Template Name</label>
                        <div class="col-sm-12">
                           <input class="form-control" type="text" id="template_name"  name="template_name" placeholder="Template Name" value="" maxlength="50" > 
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-8 control-label">Upload Header Image</label>
                        <div class="col-sm-12">
                           <div class="form-group">
							<input type="file" id="header_image" name="header_image" class="form-control{{ $errors->has('header_image') ? ' is-invalid' : '' }}" >
							@if ($errors->has('header_image'))
							<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('header_image') }}</strong>
							</span>
							@endif
							<img style="height:80px;width:120px;" id="imghead" src="">
							</div>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-8 control-label">Content BG Color</label>
                        <div class="col-sm-4">
                           <input class="form-control" type="text" id="content_bg_color" style="background-image:none !important"  name="content_bg_color" placeholder="Content BG Color"  maxlength="50" value="#FFFFFF" 
						   data-jscolor="{closeButton:true, closeText:'Close me!', backgroundColor:'#333', buttonColor:'#FFF'}"> 
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-8 control-label">Upload Footer Image</label>
                        <div class="col-sm-12">
                           <div class="form-group">
							<input type="file" id="footer_image" name="footer_image" class="form-control{{ $errors->has('footer_image') ? ' is-invalid' : '' }}" >
							@if ($errors->has('footer_image'))
							<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('footer_image') }}</strong>
							</span>
							@endif
							<img style="height:80px;width:120px;" id="imgfoot" src="">
							</div>
                        </div>
                    </div>
					
					<!--<div class="form-group radio-toggle">
                        <label class="col-sm-8 control-label">Template Name</label>
                        <div class="col-sm-12">
                           <input  type="radio" class="stat" name="status" value="1" maxlength="50" checked> ON
						   <input type="radio"  class="stat" name="status" value="0" maxlength="50" required=""> OFF
                        </div>
                    </div>
					
					<div class="form-group radio-toggle">
					
					 <div class="form-check">
						<label class="form-check-label">
						<input class="form-check-input stat" type="radio" name="status" id="status1" value="1">
						ON
						</label>
						<label class="form-check-label">
						<input class="form-check-input stat" type="radio" name="status" id="status2" value="0">
						OFF
						</label>
					</div>
					</div> <br><br>-->
					
					
					
					<div class="form-group ">
					<label class="col-sm-8 control-label">Status</label>
					<p class="field switch" style="padding-left:8px;">
					<input style="display:none" type="radio" id="radio1" name="status" value="1"  checked />.
					<input style="display:none" type="radio" id="radio2" name="status" value="0"/>.
					<label for="radio1" class="cb-enable selected"><span>ON</span></label>
					<label for="radio2" class="cb-disable"><span>OFF</span></label>
					</p></div>  

                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn2" value="create">Save changes
                     </button>
                    </div>
                </form>
				
				<!--<div class="success alert alert-success">
                            Image Upload Successfully
                        </div>
                        <form enctype="multipart/form-data" id="imageUpload">
                            <div class="form-group">
                                <label><strong>Image : </strong></label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-success">Save</button>
                            </div>
                        </form>          -->  
            </div>
        </div>
    </div>
</div>
<style>
.cb-enable, .cb-disable, .cb-enable span, .cb-disable span { background: url(http://demos.devgrow.com/switch/switch.gif) repeat-x; display: block; float: left; }
	.cb-enable span, .cb-disable span { line-height: 30px; display: block; background-repeat: no-repeat; font-weight: bold; }
	.cb-enable span { background-position: left -90px; padding: 0 10px; }
	.cb-disable span { background-position: right -180px;padding: 0 10px; }
	.cb-disable.selected { background-position: 0 -30px; }
	.cb-disable.selected span { background-position: right -210px; color: #fff; }
	.cb-enable.selected { background-position: 0 -60px; }
	.cb-enable.selected span { background-position: left -150px; color: #fff; }
	.switch label { cursor: pointer; }
</style>
<script src="{{ asset('js/jscolor.js') }}"></script>

<script type="text/javascript">
$(document).ready(function(){
	
	jscolor.presets.default = {
    height: 181,              // make the picker box a little bigger
    position: 'left',        // position the picker to the right of the target
    previewPosition: 'left', // display color preview on the right side
    previewSize: 40,          // make color preview bigger
	backgroundImage: '',
	};
	
	
	$(".cb-enable").click(function(){
		var parent = $(this).parents('.switch');
		$('.cb-disable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', true);
	});
	$(".cb-disable").click(function(){
		var parent = $(this).parents('.switch');
		$('.cb-enable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', false);
	});
	
	$('#job_template').DataTable({
		processing: true,
		serverSide: true,
		order: [[ 0, "desc" ]],
		ajax: {
			url: "{{ route('job-template.index') }}"
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
				data: 'template_name',
				name: 'template_name',
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
	var table = $('#job_template').DataTable();
	//$("input[class=status][value=1]").prop('checked', true);
	$('#addNew').click(function () {
        $('#saveBtn2').val("create-template");
        $('#job_id').val('');
        $('#JtForm').trigger("reset");
        $('#modelHeading').html("Create New Job Template");
        $('#ajaxModel1').modal('show');
		//$("input[id=business_unit_id]").attr('checked',false);
		$(".error").html("");
		$('#imghead').attr("src","");
		$('#imgfoot').attr("src","");
		$('#imghead').hide();
		$('#imgfoot').hide();
		$("input[name=status][value=1]").prop('checked', true);
		  var parent = $(".cb-enable").parents('.switch');
		$('.cb-disable',parent).removeClass('selected');
		$(".cb-enable").addClass('selected');
		$('.checkbox',parent).attr('checked', true);
		$(".print-error-msg").css('display','none');
    });

  $('body').on('click', '.edit', function () {
	  var Job_id = $(this).attr('id');
	  //$("input[id=business_unit_id]").attr('checked',false);
	  $(".print-error-msg").css('display','none');
      $.get("job-template" +'/' + Job_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Job Template");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel1').modal('show');
          $('#job_id').val(data.id);
		  $('#business_unit_id').val(data.business_unit_id);
          $('#template_name').val(data.template_name);
          $('#content_bg_color').val(data.content_bg_color);
		  $('#imghead').show();
		  $('#imgfoot').show();
		  $('#imghead').attr("src", "http://localhost:8000/storage/uploads/"+data.header_image);
		   $('#imgfoot').attr("src", "http://localhost:8000/storage/uploads/"+data.footer_image);
		  //$('.stat').val(data.status);
		  $("input[name=status][value=" + data.status + "]").prop('checked', true);
		  if(data.status=='0'){
			 
			  var parent = $(".cb-disable").parents('.switch');
		$('.cb-enable',parent).removeClass('selected');
		$(".cb-disable").addClass('selected');
		$('.checkbox',parent).attr('checked', false);
		  }
		  else{
			  
			  var parent = $(".cb-enable").parents('.switch');
		$('.cb-disable',parent).removeClass('selected');
		$(".cb-enable").addClass('selected');
		$('.checkbox',parent).attr('checked', true);
		  }
      })
  });
  
  $('body').on('click', '.delete', function () {
        var Job_id = $(this).attr('id');
        var ok =confirm("Are You sure want to delete !");
        if(ok == true){
        $.ajax({
            type: "DELETE",
            url: "job-template"+'/'+Job_id,
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
	
	
	
	
	$(document).ready(function () {
            $('.success').hide();// or fade, css display however you'd like.
        });
	
	 $('#JtForm').on('submit',(function(e) {
		
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
             
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
               type:'POST',
               url: "{{ route('job-template.store')}}",
               data:formData,
               cache:false,
               contentType: false,
               processData: false,
             
                 complete: function(response) 
                {
                    if($.isEmptyObject(response.responseJSON.error)){
                            $('.success').show();
                           setTimeout(function(){
                           $('.success').hide();
                        }, 5000);
						  $('#JtForm').trigger("reset");
              $('#ajaxModel1').modal('hide');
              table.draw();
                    }else{
                        printErrorMsg(response.responseJSON.error);
                    }
                }

            });
        
       function printErrorMsg(msg){
               $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
       }
		
		}));
 
	
 });
 
  </script>
@endsection



