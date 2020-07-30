@extends('layouts.master')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-top:20px;">
                <div class="card-header">{{ __('Manage Ads') }}</div>
				
				<div class="table-responsive"> 
						<table class="cell-border stripe hover row-border">
							<thead>
							<tr>
								<th><a id="lads">Live Ads </a> &nbsp;&nbsp;&nbsp;</th>
								<th><a  id="eads">Expired Ads </a> &nbsp;&nbsp;&nbsp;</th>
								
							</tr>
							</thead>
						</table>
					</div>

                <div class="card-body">
                   
					<div >
					
					</div>
					<div class="table-responsive"> 
						<table id="" class="cell-border stripe hover row-border appli">
							<thead>
							<tr>
								<th>Responses</th>
								<th>Date</th>
								<th>Job Title</th>
								<th>Created by</th>
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
			
                
				<div class="alert alert-danger print-error-msg" style="display:none">
        <ul></ul>
    </div>
                   <input type="hidden" name="id" id="id">
				   <input type="hidden" name="val" id="val">
					
					
					<div class="form-group ">
					<label class="col-sm-8 control-label">Status</label>
					<p class="field switch" style="padding-left:8px;">
					<input type="checkbox" class="mode" id="radio1" name="status" value="email" />Adzuna ->response
					<input type="checkbox" class="mode" id="radio2" name="status" value="text"/>Jora ->response
					<input type="checkbox" class="mode" id="radio2" name="status" value="msg"/>Seek ->response
					</p></div>  

                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary edit" id="saveBtn2" value="create">Save changes
                     </button>
                    </div>
                
				
			
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	
	$.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
	
	var cols=[];
	
	cols= [
			{
				data: 'response',
				name: 'response',
			},
			{
				data: 'post_time',
				name: 'post_time',
			},
			{
				data: 'job_title',
				name: 'job_title',
				fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
            $(nTd).html("<a href='/recruitment/managead/"+oData.id+"'>"+oData.job_title+"</a>");
        }
			},
			{
				data: 'created_by',
				name: 'created_by',
			},
			{
				data: 'action',
				name: 'action',
				orderable: false
			}
		];
	
	/*$('#managepost').DataTable({
		processing: true,
		serverSide: true,
		order: [[ 0, "desc" ]],
		ajax: {
			url: "{{ route('mpost') }}"
		},
		columns: cols
	});*/
	
	
	
	
	$('.appli').attr('id','liveads')
	
	
	$('#liveads').show();
	
	var bb= $('.appli').attr('id');
	//alert(bb);
	//$('#liveads tbody').on('click', 'a[class="edits"]' , function () {
		$('body').on('click', '.edits', function () {
		//alert('test');
		$('#ajaxModel1').modal('show');
	});
	
	
	
	
	$('#liveads').DataTable({
		destroy: true,
		processing: true,
		serverSide: true,
		order: [[ 1, "desc" ]],
		ajax: {
			data:{ids:'liveads'},
			url: "/recruitment/managead"
		},
		columns: cols
	});
	
	
	$("#lads").click(function(){
	$('.appli').attr('id','liveads')
	
	
	$('#liveads').show();
	
	$('#liveads').DataTable({
		destroy: true,
		processing: true,
		serverSide: true,
		order: [[ 1, "desc" ]],
		ajax: {
			type: "POST",
			data:{ids:'liveads'},
			url: "/recruitment/managead"
		},
		columns: cols
	});
	});
	
	
	$("#eads").click(function(){
	$('.appli').attr('id','expads')
	
	
	$('#expads').show();
	
	$('#expads').DataTable({
		destroy: true,
		processing: true,
		serverSide: true,
		order: [[ 0, "desc" ]],
		ajax: {
			type: "POST",
			data:{ids:'expads'},
			url: "/recruitment/managead"
		},
		columns: cols
	});
	});
	
	
	
});
</script>


@endsection



