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



