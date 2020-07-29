@extends('layouts.master')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-top:20px;">
                <div class="card-header">{{ $disAd['job_title']}}</div>

                <div class="card-body">
                   
					
					<div class="table-responsive"> 
						<table id="managepost" class="cell-border stripe hover row-border">
							<thead>
							<tr>
								<th><a href="#">Ad Details </a> &nbsp;&nbsp;&nbsp;</th>
								<th><a href="/recruitment/managead/{{ $disAd['id']}}/all">All Applicants </a> &nbsp;&nbsp;&nbsp;</th>
								<th><a href="#" id="qauls">Qualified Applicants </a> &nbsp;&nbsp;&nbsp;</th>
								<th><a href="#">Starred Applicants </a> &nbsp;&nbsp;&nbsp;</th>
								<th><a href="#">Invited Applicants </a> &nbsp;&nbsp;</th>
							</tr>
							</thead>
						</table>
					</div>
					<div class="table-responsive"> 
					
						<table id="displayall" class="cell-border stripe hover row-border">
							<thead>
							<tr>
								<th>Status</th>
								<th>Applicant</th>
								<th>Source</th>
								<th>Date</th>
								<th>Tags</th>
								<th>CV</th>
							</tr>
							</thead>
						</table>
						
						<table id="displayqual" style="display:none" class="cell-border stripe hover row-border">
							<thead>
							<tr>
								<th>Status</th>
								<th>Applicant</th>
								<th>Source</th>
								<th>Date</th>
								<th>Tags</th>
								<th>CV</th>
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
	var rno={{session('rno')}}
	var cols=[];
	cols= [
			{
				data: 'status',
				name: 'status',
				fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
				if(oData.status==''){
            $(nTd).append("<a id='qu' style='border:1px solid black' href='/recruitment/managead/"+oData.id+"'>Q</a>&nbsp;&nbsp;");
		    $(nTd).append("<a id='pot' style='border:1px solid black' href='/recruitment/managead/"+oData.id+"'>P</a>&nbsp;&nbsp;");
			$(nTd).append("<a id='star' style='border:1px solid black' href='/recruitment/managead/"+oData.id+"'>S</a>&nbsp;&nbsp;");
			$(nTd).append("<a id='is' style='border:1px solid black' href='/recruitment/managead/"+oData.id+"'>IS</a>&nbsp;&nbsp;");
			$(nTd).append("<a id='in' style='border:1px solid black' href='/recruitment/managead/"+oData.id+"'>I</a>");
				}
				if(oData.status=='qualify'){
            $(nTd).append("<a style='border:1px solid red'>Q</a>&nbsp;&nbsp;");
		    $(nTd).append("<a id='pot' style='border:1px solid black' href='/recruitment/managead/"+oData.id+"'>P</a>&nbsp;&nbsp;");
			$(nTd).append("<a id='star' style='border:1px solid black' href='/recruitment/managead/"+oData.id+"'>S</a>&nbsp;&nbsp;");
			$(nTd).append("<a id='is' style='border:1px solid black' href='/recruitment/managead/"+oData.id+"'>IS</a>&nbsp;&nbsp;");
			$(nTd).append("<a id='in' style='border:1px solid black' href='/recruitment/managead/"+oData.id+"'>I</a>&nbsp;&nbsp;");
				}
				if( oData.status=='potential'){
            $(nTd).append("<a style='border:1px solid red'>Q</a>&nbsp;&nbsp;");
		    $(nTd).append("<a style='border:1px solid red'>P</a>&nbsp;&nbsp;");
			$(nTd).append("<a id='star' style='border:1px solid black' href='/recruitment/managead/"+oData.id+"'>S</a>&nbsp;&nbsp;");
			$(nTd).append("<a id='is' style='border:1px solid black' href='/recruitment/managead/"+oData.id+"'>IS</a>&nbsp;&nbsp;");
			$(nTd).append("<a id='in' style='border:1px solid black' href='/recruitment/managead/"+oData.id+"'>I</a>&nbsp;&nbsp;");
				}
				if(oData.status=='star'){
            $(nTd).append("<a style='border:1px solid red'>Q</a>&nbsp;&nbsp;");
		    $(nTd).append("<a style='border:1px solid red'>P</a>&nbsp;&nbsp;");
			$(nTd).append("<a style='border:1px solid red'>S</a>&nbsp;&nbsp;");
			$(nTd).append("<a id='is' href='/recruitment/managead/"+oData.id+"'>IS</a>&nbsp;&nbsp;");
			$(nTd).append("<a id='in' href='/recruitment/managead/"+oData.id+"'>I</a>&nbsp;&nbsp;");
				}
				if(oData.status=='inteviewschedule'){
            $(nTd).append("<a style='border:1px solid red'>Q</a>&nbsp;&nbsp;");
		    $(nTd).append("<a style='border:1px solid red'>P</a>&nbsp;&nbsp;");
			$(nTd).append("<a style='border:1px solid red'>S</a>&nbsp;&nbsp;");
			$(nTd).append("<a style='border:1px solid red'>IS</a>&nbsp;&nbsp;");
			$(nTd).append("<a id='in' href='/recruitment/managead/"+oData.id+"'>I</a>&nbsp;&nbsp;");
				}
				if(oData.status=='invite'){
            $(nTd).append("<a style='border:1px solid red'>Q</a>&nbsp;&nbsp;");
		    $(nTd).append("<a style='border:1px solid red'>P</a>&nbsp;&nbsp;");
			$(nTd).append("<a style='border:1px solid red'>S</a>&nbsp;&nbsp;");
			$(nTd).append("<a style='border:1px solid red'>IS</a>&nbsp;&nbsp;");
			$(nTd).append("<a style='border:1px solid red'>I</a>&nbsp;&nbsp;");
				}
			}
				
			},
			{
				data: 'applicant_name',
				name: 'applicant_name',
			},
			{
				data: 'applicant_source',
				name: 'applicant_source',
				
			},
			{
				data: 'applied_date',
				name: 'applied_date',
			},
			{
				data: 'action',
				name: 'action',
				orderable: false
			},
			{
				data: 'cv',
				name: 'cv',
			}
		];
		
		var table = $('#displayall').DataTable();
		var table1 = $('#displayqual').DataTable();
		
	$('#displayall').DataTable({
		destroy: true,
		processing: true,
		serverSide: true,
		 paging: false,
    searching: false,
		order: [[ 0, "desc" ]],
		ajax: {
			
			url: "/recruitment/managead" +'/' + rno +'/all'
		},
		columns: cols
	});
	
	$("#qauls").click(function(){
		
		
	$('#displayqual').show();
	$('#displayall').hide();
	$('#displayqual').DataTable({
		destroy: true,
		processing: true,
		serverSide: true,
		 paging: false,
    searching: false,
		order: [[ 0, "desc" ]],
		ajax: {
			
			url: "/recruitment/managead" +'/' + rno +'/qual'
		},
		columns: cols
	});
	
	});
});
</script>




@endsection



