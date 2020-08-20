@extends('layouts.master')


@section('content')
<div class="container details">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $disAd['job_title']}}</div>
						<div class="btn-group btn-group-justified nav nav-pills" id="managepost">
					<button type="button" id="detail"  data-toggle="pill"  class="btn btn-info nav-link active">Ad Details</a>
					<button type="button"  id="all" data-toggle="pill"class="nav-link btn btn-info">All Applicants</a>
					<button type="button"  id="qauls"data-toggle="pill"class="nav-link btn btn-info">Qualified Applicants</a>
					<button type="button" id="star" data-toggle="pill" class="btn btn-info nav-link">Starred Applicants </a> 
					<button type="button"  id="invite"data-toggle="pill" class="btn btn-info nav-link">Invited Applicants</a> 

				</div>
				<!--<a id="detail"  data-toggle="pill"  class="btn btn-light">Ad Details</a> 
					<a  id="all" data-toggle="pill" href="#menu2" class="btn btn-light">All Applicants</a> 
					<a  id="qauls"data-toggle="pill" href="#menu3" class="btn btn-light">Qualified Applicants</a> 
					<a id="star" data-toggle="pill" href="#menu4"class="btn btn-light">Starred Applicants </a> 
					<a  id="invite"data-toggle="pill" href="#menu5"class="btn btn-light">Invited Applicants</a> 
				</div>
				<!--<div class="table-responsive"> 
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
					</div>-->

                <div class="card-body" id="manageposts">
                   
					
					
					<div >
	<div class="form-group row">
	 <hr class="col-md-12">
	 <div class="col-md-12 setting">
		
		<div class="btn-group user_edit btn-group-sm">
			<button type="button" class="btn btn-light"><img src="{{ asset('css/img/edit_user.png') }}" /></button>
			<!--<button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
			<span class="caret"></span>
			</button>-->
		<!--<div class="dropdown-menu">
			<a class="dropdown-item pen" href="/recruitment/managead/{{$disAd['id']}}/edit"><img src="{{ asset('css/img/write.png') }}" /> Edit </a>
			<a class="dropdown-item pen" id="del" href="#"><img src="{{ asset('css/img/erase-icon.png') }}" /> Delete</a>
		</div>-->
	  <!--<div style="width:100%;text-align:right;"><a href="/recruitment/managead/{{$disAd['id']}}/edit" style="text-decoration:underline">Edit</a> <a id="del" href="#" style="text-decoration:underline">Delete</a> <a href="/recruitment/managead/{{$disAd['id']}}/resend" style="text-decoration:underline">Resend</a></div>-->
	  </div><h5>Details</h5>
	 </div>
	 </div>
	 <div class="form-group row pl-2">
        <div class="col-md-12">@if($disAd['cost']!='') <a target="blank" href="/recruitment/managead/{{$disAd['cost']}}">Parent job details</a> @endif</div>
		<div class="col-md-2">
			<label for="inputPassword"  class="col-form-label">Consultant:</label>
		</div>
		<div class="col-md-4">
		{{ $disAd['created_by']}}
        </div>
		
    </div>
    <div class="form-group row pl-2">
		<div class="col-md-2">
        <label for="inputPassword"  class="col-form-label">Job Ref:</label>
		</div>
		<div class="col-md-4">
		{{ $disAd['reference_no']}}
        </div>
    </div>
	<div class="form-group row pl-2">
		<div class="col-md-2">
        <label for="inputPassword"  class="col-form-label">Job Title:</label>
		</div>
		<div class="col-md-4">
		{{ $disAd['job_title']}}
        </div>
    </div>
	<div class="form-group row pl-2">
		<div class="col-md-2">
        <label for="inputPassword"  class="col-form-label">Job Type:</label>
		</div>
		<div class="col-md-4">
		{{ $disAd['job_type']}}
        </div>
    </div>
	<div class="form-group row pl-2">
		<div class="col-md-2">
			<label for="inputPassword"  class="col-form-label">Employment Start date:</label>
		</div>
		<div class="col-md-4">
		{{ $disAd['sdate']}}
        </div>
    </div>
	<div class="form-group row pl-2">
		<div class="col-md-2">
        <label for="inputPassword"  class="col-form-label">Job Classification:</label>
		</div>
		<div class="col-md-4">
		{{ $disAd['boards'][0]['job_class']}}
        </div>
    </div>
	<div class="form-group row pl-2">
		<div class="col-md-2">
        <label for="inputPassword"  class="col-form-label">Location:</label>
		</div>
		<div class="col-md-4">
		{{ $disAd['location']}}
        </div>
    </div>
	<div class="form-group row pl-2">
		<div class="col-md-12">
        <label for="inputPassword"  class="col-form-label">Salary:</label>
		{{ $disAd['currency']}} {{ $disAd['min']}} {{ $disAd['max']}} {{ $disAd['salary_per']}} {{ $disAd['salary_desc']}}
        </div>
    </div>
	 <div class="send_details">
		<ul>
			<li> <a class="ad_btn" href="/recruitment/managead/{{$disAd['id']}}/repost">Re-Post</a></li>
			<li> <a class="ad_btn" href="/recruitment/managead/{{$disAd['id']}}/resend">Clone</a></li>
			<li class="float-md-right"><a class="btn btn-primary"href="/recruitment/managead/{{$disAd['id']}}/edit">Edit</a> 
		<a id="del" href="#" class="btn btn-danger">Delete</a></li>
		</ul>

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
                <h4 class="modal-title" id="modelHeading">Interview Schedule</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
			
                
				<div class="alert alert-danger print-error-msg" style="display:none">
        <ul></ul>
    </div>
                   <input type="hidden" name="id" id="id">
				   <input type="hidden" name="val" id="val">
					
					
					<div class="form-group ">
					<label class="col-md-12 control-label mode">Mode</label>
					<p class="field switch" style="padding-left:8px;">
					<div><input type="radio" class="mode" id="radio1" name="status" value="email" /> Email</div>
					<div><input type="radio" class="mode" id="radio2" name="status" value="text"/> Text</div>
					<div><input type="radio" class="mode" id="radio2" name="status" value="msg"/> Msg</div>
					</p></div>  

                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="button-3 edit" id="saveBtn2" value="create">Save changes
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
            $(nTd).append("<a class='stat' id='qual' rel='"+oData.id+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;' >Q</a><span class='dbl_arw'> ></span>&nbsp;&nbsp;");
		    $(nTd).append("<a class='stat' id='poten' rel='"+oData.id+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;' >P</a><span class='dbl_arw'> ></span>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='stars' rel='"+oData.id+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;' >S</a><span class='dbl_arw'> ></span>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='insc' rel='"+oData.id+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>IS</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='invites' rel='"+oData.id+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;' >I</a>");
				}
				if(oData.status=='qualify'){
            $(nTd).append("<a  style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>Q</a><span class='dbl_arw'> ></span>&nbsp;&nbsp;");
		    $(nTd).append("<a class='stat' id='poten' rel='"+oData.id+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>P</a><span class='dbl_arw'> ></span>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='stars' rel='"+oData.id+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>S</a><span class='dbl_arw'> ></span>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='insc' rel='"+oData.id+"'style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>IS</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='invites' rel='"+oData.id+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>I</a>&nbsp;&nbsp;");
				}
				if( oData.status=='potential'){
            $(nTd).append("<a style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>Q</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
		    $(nTd).append("<a style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>P</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='stars' rel='"+oData.id+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>S</a><span class='dbl_arw'> ></span>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='insc' rel='"+oData.id+"'style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>IS</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='invites' rel='"+oData.id+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>I</a>&nbsp;&nbsp;");
				}
				if(oData.status=='starr'){
            $(nTd).append("<a style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>Q</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
		    $(nTd).append("<a style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>P</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>S</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='insc' rel='"+oData.id+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>IS</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='invites' rel='"+oData.id+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>I</a>&nbsp;&nbsp;");
				}
				if(oData.status=='inteviewschedule'){
            $(nTd).append("<a style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>Q</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
		    $(nTd).append("<a style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>P</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>S</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>IS</a><span class='dbl_arw'> ></span>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' id='invites' rel='"+oData.id+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>I</a>&nbsp;&nbsp;");
				}
				if(oData.status=='invited'){
            $(nTd).append("<a style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>Q</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
		    $(nTd).append("<a style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>P</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>S</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>IS</a><span class='dbl_arw'> ></span>&nbsp;&nbsp;");
			$(nTd).append("<a style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>I</a>&nbsp;&nbsp;");
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
				render: function (dataField) { return '<a href="/downloads/cv.docx" class="edit btn btn-primary btn-sm">CV Download</a>'; },
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
			var modes=$('input[class="mode"]:checked').val();
			//alert(modes);
			$.ajax({
            type: "POST",
			data:{valUrl:id, id:val, mode:modes},
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
		order: [[ 3, "desc" ]],
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
		order: [[ 3, "desc" ]],
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
		order: [[ 3, "desc" ]],
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
		order: [[ 3, "desc" ]],
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



