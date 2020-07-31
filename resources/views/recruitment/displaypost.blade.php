@extends('layouts.master')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-top:20px;">
                <div class="card-header">{{ $disAd['job_title']}}</div>
				
				<div class="table-responsive"> 
						<table id="managepost" class="cell-border stripe hover row-border">
							<thead>
							<tr>
								<th><a id="detail">Ad Details </a> &nbsp;&nbsp;&nbsp;</th>
								<th><a  id="all">All Applicants </a> &nbsp;&nbsp;&nbsp;</th>
								<th><a id="qauls">Qualified Applicants </a> &nbsp;&nbsp;&nbsp;</th>
								<th><a id="star">Starred Applicants </a> &nbsp;&nbsp;&nbsp;</th>
								<th><a id="invite">Invited Applicants </a> &nbsp;&nbsp;</th>
							</tr>
							</thead>
						</table>
					</div>

                <div class="card-body" id="manageposts">
                   
					
					
					<div >
						<div class="form-group row">
	 <hr class="col-md-12">
	 <h5 class="col-md-12">Details</h5>
	  <div style="width:100%;text-align:right;"><a href="/recruitment/managead/{{$disAd['id']}}/edit" style="text-decoration:underline">Edit</a> <a id="del" href="#" style="text-decoration:underline">Delete</a> <a href="/recruitment/managead/{{$disAd['id']}}/resend" style="text-decoration:underline">Resend</a></div>
	  <hr class="col-md-12">
        <label for="inputPassword"  class="col-sm-2 col-form-label">Consultant:</label>
        <div class="col-sm-5">
		{{ $disAd['created_by']}}
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword"  class="col-sm-2 col-form-label">Job Ref:</label>
        <div class="col-sm-5">
		{{ $disAd['reference_no']}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword"  class="col-sm-2 col-form-label">Job Title:</label>
        <div class="col-sm-5">
		{{ $disAd['job_title']}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword"  class="col-sm-2 col-form-label">Job Type:</label>
        <div class="col-sm-5">
		{{ $disAd['job_type']}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword"  class="col-sm-2 col-form-label">Employment Start date:</label>
        <div class="col-sm-5">
		{{ $disAd['sdate']}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword"  class="col-sm-2 col-form-label">Job Classification:</label>
        <div class="col-sm-5">
		{{ $disAd['job_class']}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword"  class="col-sm-2 col-form-label">Location:</label>
        <div class="col-sm-5">
		{{ $disAd['location']}}
        </div>
    </div>
	<div class="form-group row">
        <label for="inputPassword"  class="col-sm-2 col-form-label">Salary:</label>
        <div class="col-sm-5">
		{{ $disAd['currency']}} {{ $disAd['min']}} {{ $disAd['max']}} {{ $disAd['salary_per']}} {{ $disAd['salary_desc']}}
        </div>
    </div>
	
					</div>
                </div>
				
				
				<div class="card-body" id="displayalls" >
                   
					
					<div class="error" style="font-weight:bold;color:red"></div>
					<div class="table-responsive"> 
					
						<table id="displayall" class="cell-border stripe hover row-border appli">
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
						
						<!--<table id="displayqual" style="display:none" class="cell-border stripe hover row-border">
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
						</table>-->
						
						
						
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
					<label class="col-sm-8 control-label">Mode</label>
					<p class="field switch" style="padding-left:8px;">
					<input type="radio" class="mode" id="radio1" name="status" value="email" />Email
					<input type="radio" class="mode" id="radio2" name="status" value="text"/>Text
					<input type="radio" class="mode" id="radio2" name="status" value="msg"/>Msg
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
	var rno={{session('rno')}}
	var cols=[];
	cols= [
			{
				data: 'status',
				render: function (dataField) { return ''; },
				fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
				if(oData.status==''){
            $(nTd).append("<a class='stat' id='qual' rel='"+oData.id+"' style='border:1px solid black;text-decoration:underline' >Q</a>&nbsp;&nbsp;");
		    $(nTd).append("<a class='stat' id='poten' rel='"+oData.id+"' style='border:1px solid black;text-decoration:underline' >P</a>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='stars' rel='"+oData.id+"' style='border:1px solid black;text-decoration:underline' >S</a>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='insc' rel='"+oData.id+"' style='border:1px solid black;text-decoration:underline' >IS</a>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='invites' rel='"+oData.id+"' style='border:1px solid black;text-decoration:underline' >I</a>");
				}
				if(oData.status=='qualify'){
            $(nTd).append("<a  style='border:1px solid red;background-color:blue'>Q</a>&nbsp;&nbsp;");
		    $(nTd).append("<a class='stat' id='poten' rel='"+oData.id+"' style='border:1px solid black;text-decoration:underline'>P</a>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='stars' rel='"+oData.id+"' style='border:1px solid black;text-decoration:underline'>S</a>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='insc' rel='"+oData.id+"' style='border:1px solid black;text-decoration:underline'>IS</a>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='invites' rel='"+oData.id+"' style='border:1px solid black;text-decoration:underline'>I</a>&nbsp;&nbsp;");
				}
				if( oData.status=='potential'){
            $(nTd).append("<a style='border:1px solid red;background-color:blue'>Q</a>&nbsp;&nbsp;");
		    $(nTd).append("<a style='border:1px solid red;background-color:blue'>P</a>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='stars' rel='"+oData.id+"' style='border:1px solid black;text-decoration:underline'>S</a>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='insc' rel='"+oData.id+"' style='border:1px solid black;text-decoration:underline'>IS</a>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='invites' rel='"+oData.id+"' style='border:1px solid black;text-decoration:underline'>I</a>&nbsp;&nbsp;");
				}
				if(oData.status=='starr'){
            $(nTd).append("<a style='border:1px solid red;background-color:blue'>Q</a>&nbsp;&nbsp;");
		    $(nTd).append("<a style='border:1px solid red;background-color:blue'>P</a>&nbsp;&nbsp;");
			$(nTd).append("<a style='border:1px solid red;background-color:blue'>S</a>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='insc' rel='"+oData.id+"' style='border:1px solid black;text-decoration:underline'>IS</a>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='invites' rel='"+oData.id+"' style='border:1px solid black;text-decoration:underline'>I</a>&nbsp;&nbsp;");
				}
				if(oData.status=='inteviewschedule'){
            $(nTd).append("<a style='border:1px solid red;background-color:blue'>Q</a>&nbsp;&nbsp;");
		    $(nTd).append("<a style='border:1px solid red;background-color:blue'>P</a>&nbsp;&nbsp;");
			$(nTd).append("<a style='border:1px solid red;background-color:blue'>S</a>&nbsp;&nbsp;");
			$(nTd).append("<a style='border:1px solid red;background-color:blue'>IS</a>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='invites' rel='"+oData.id+"' style='border:1px solid black;text-decoration:underline'>I</a>&nbsp;&nbsp;");
				}
				if(oData.status=='invited'){
            $(nTd).append("<a style='border:1px solid red;background-color:blue'>Q</a>&nbsp;&nbsp;");
		    $(nTd).append("<a style='border:1px solid red;background-color:blue'>P</a>&nbsp;&nbsp;");
			$(nTd).append("<a style='border:1px solid red;background-color:blue'>S</a>&nbsp;&nbsp;");
			$(nTd).append("<a style='border:1px solid red;background-color:blue'>IS</a>&nbsp;&nbsp;");
			$(nTd).append("<a style='border:1px solid red;background-color:blue'>I</a>&nbsp;&nbsp;");
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
		
	$('#displayalls').hide();
	$('#displayqual').hide();
	$('#displayall').hide();
	
	$.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
	
		
		var table = $('#displayall').DataTable();
		var table1 = $('#displayqual').DataTable();
		
		//------------------------------change status------------------------------------------
		var id='';
		var val='';
		
		$('#displayall tbody').on('click', 'a[class="stat"]' , function () {
		var id='';
		var val='';
		var id=$(this).prop('id');
		//alert(id);
		var val=$(this).prop('rel');
		//alert(val);
		if(id!=='insc'){
		 $.ajax({
            type: "POST",
			data:{valUrl:id, id:val},
            url: "/recruitment/managead" +'/' + rno +'/statChange',
			dataType: 'json',
            success: function (data) {
				//alert('test');
                $('#displayall').DataTable().draw();
				 $('#displayqual').DataTable().draw();
				 $('#displaystar').DataTable().draw();
				 $('#displayinvite').DataTable().draw();
				 //console.log(data.success);
				$('.error').text(data.success);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
		}
		else{
			$('#ajaxModel1').modal('show');
			$('#id').val(id);
			$('#val').val(val);
			
		}
	});
	
	
	//--------------------------------status for interview schedule----------------------------------
       $('body').on('click', '#saveBtn2', function () {
		 //alert('test');
		var id= $('#id').val();
		var val= $('#val').val();
		var mode= $('.mode').val();
		if($('.mode').is(':checked')){
			var modes=$('.mode').val();
			//alert(modes);
			$.ajax({
            type: "POST",
			data:{valUrl:id, id:val, mode:mode},
            url: "/recruitment/managead" +'/' + rno +'/statChange',
			dataType: 'json',
            success: function (data) {
				//alert('test');
				$('#ajaxModel1').modal('hide');
                $('#displayall').DataTable().draw();
				 $('#displayqual').DataTable().draw();
				 $('#displaystar').DataTable().draw();
				 $('#displayinvite').DataTable().draw();
				$('.error').text(data.success);
            },
            error: function (data) {
				$('#ajaxModel1').modal('show');
                console.log('Error:', data);
            }
        });
			}
			else {  alert('select a option'); $('#ajaxModel1').modal('show'); }
	});
		

    // -------------------------tab press-----------------------------------------------
	$("#detail").click(function(){
		
	$('#displayalls').hide();
	$('#displayqual').hide();
	$('#displayall').hide();
	$('#manageposts').show();
	});
	
	
	$("#all").click(function(){
	$('.appli').attr('id','displayall')
	$('#displayalls').show();
	
	$('#displayall').show();
	$('#manageposts').hide();
	$('#displayall').DataTable({
		destroy: true,
		processing: true,
		serverSide: true,
		order: [[ 0, "desc" ]],
		ajax: {
			
			url: "/recruitment/managead" +'/' + rno +'/all'
		},
		columns: cols
	});
	});
	
	$("#qauls").click(function(){
	$('.appli').attr('id','displayqual')
	$('#displayalls').show();
	$('#displayqual').show();
	
	$('#manageposts').hide();
	
	$('#displayqual').DataTable({
		destroy: true,
		processing: true,
		serverSide: true,
		order: [[ 0, "desc" ]],
		ajax: {
			
			url: "/recruitment/managead" +'/' + rno +'/qual'
		},
		columns: cols
	});
	
	});
	
	$("#star").click(function(){
	$('.appli').attr('id','displaystar')
	$('#displayalls').show();
	$('#displaystar').show();
	
	$('#manageposts').hide();
	
	$('#displaystar').DataTable({
		destroy: true,
		processing: true,
		serverSide: true,
		order: [[ 0, "desc" ]],
		ajax: {
			
			url: "/recruitment/managead" +'/' + rno +'/star'
		},
		columns: cols
	});
	
	});
	
	$("#invite").click(function(){
	$('.appli').attr('id','displayinvite')
	$('#displayalls').show();
	$('#displayinvite').show();
	
	$('#manageposts').hide();
	
	$('#displayinvite').DataTable({
		destroy: true,
		processing: true,
		serverSide: true,
		order: [[ 0, "desc" ]],
		ajax: {
			
			url: "/recruitment/managead" +'/' + rno +'/invite'
		},
		columns: cols
	});
	
	});
	
	
	
	 $('body').on('click', '#del', function () {
	   var ok =confirm("Are you sure want to delete !");
        if(ok == true){
        $.ajax({
            type: "POST",
            url:  "/recruitment/managead" +'/' + rno +'/del',
            success: function (data) {
                
				window.location.href = '/recruitment/managead';
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
		}
	});
});
</script>



@endsection



