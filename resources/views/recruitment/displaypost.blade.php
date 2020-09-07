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
        <div class="col-md-12">@if($disAd['cost']!='') <a href="/recruitment/managead/{{$disAd['cost']}}">Old Post Link</a> @endif <br>
		@foreach($childPost as $child)
		<a href="/recruitment/managead/{{$child['id']}}">New Post Link</a>
		@endforeach
		</div>
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
	<div class="form-group row pl-2">
		<div class="col-md-2">
        <label for="inputPassword"  class="col-form-label" style="font-weight:bold;color:red"><u>Applied Boards</u></label>
		</div>
		<div class="col-md-4">
		<ul>
		@foreach($disAd['boards'] as $board)
		<li>{{$board['board_name']}}</li>
		@endforeach
		</ul>
        </div>
    </div>
	 <div class="send_details">
		<ul>
			<li> <a class="ad_btn" href="/recruitment/managead/{{$disAd['id']}}/repost">Re-Post</a></li>
			<li> <a class="ad_btn" href="/recruitment/managead/{{$disAd['id']}}/resend">Clone</a></li>
			<li class="float-md-right"><a class="btn btn-primary"href="/recruitment/managead/{{$disAd['id']}}/edit">Edit</a> 
				@if($act=='1')<a id="del" href="#" class="btn btn-danger">Delete</a>@endif</li>
		</ul>

	</div>
	
					</div>
                </div>
				
				
				<div class="card-body" id="displayalls" >
                   
					
					<div class="error" style="font-weight:bold;color:red"></div>
					<div class="table-responsive"> 
					
						<!--<table id="displaypotis" class="cell-border stripe hover row-border appli1" style="display:none">
							<thead>
							<tr>
								<th>Status</th>
								<th>Applicant</th>
								<th>Applicant email</th>
								<th>Source</th>
								<th>Date</th>
								<th>Tags</th>
								<th>CV</th>
							</tr>
							</thead>
						</table>-->
						
						<table id="displayall" class="cell-border stripe hover row-border appli">
							<thead>
							<tr>
								<th>Status</th>
								<th>Applicant</th>
								<th>Applicant email</th>
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
                <h4 class="modal-title" id="modelHeading1">Interview Schedule</h4>
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
					<div><input type="radio" class="mode" id="radio2" name="status" value="call"/> Call</div>
					<!--<div><input type="radio" class="mode" id="radio2" name="status" value="msg"/> Msg</div>-->
					</p></div>  

                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="button-3 edit" id="saveBtn2" value="create">Save changes
                     </button>
                    </div>
                
				
			
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="ajaxModel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading2">Preview CV</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
			
                
				<iframe class="previewhead" src="" width="750" height="298" seamless=""></iframe>
				
			
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="ajaxModel3" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading3"></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				
            </div>
            <div class="modal-body">
			<form id="InForm" name="InForm">
			   <input type="hidden" name="invite_id" id="invite_id">
				 <input type="hidden" name="ids" id="ids">
				   <input type="hidden" name="vals" id="vals">
					<div class="form-group row">
					<label class="col-md-3 mode"> First Name *</label>
					<div class="col-sm-7">
					<input type="text" class="form-control" name="fname" id="fname" value="" readonly>
					</div>
					</div> 
					<div class="form-group row">
					<label class="col-md-3 mode"> Middle Name </label>
					<div class="col-sm-7">
					<input type="text" class="form-control" name="mname" id="mname" value="">
					</div>
					</div> 
					<div class="form-group row">
					<label class="col-md-3 mode"> Last Name *</label>
					<div class="col-sm-7">
					<input type="text" class="form-control" name="lname" id="lname" value="" readonly>
					</div>
					</div> 
					<div class="form-group row">
					<label class="col-md-3 mode"> Preferred Name </label>
					<div class="col-sm-7">
					<input type="text" class="form-control" name="pname" id="pname" value="">
					</div>
					</div> 
					
					<div class="form-group row">
					<label class="col-md-3 mode"> Registration Office *</label>
					<div class="col-sm-7"> 
					<select name="location" class="loca" id="locations">
					<option value="">Select a location</option>
					@foreach($locations as $location)
					<option value="{{$location['id']}}">{{$location['location']}}</option>
					@endforeach
					</select>
					</div>
					</div> 
					<div class="form-group row">
					<label class="col-md-3 mode" > Consultant *</label>
					<div class="col-sm-7">
					<select name="consultant" class="consul" id="consult">
					<option value="">Select a consultant</option>
					
					</select>
					</div>
					</div> 
					<div class="form-group row">
					<label class="col-md-3 mode"> Company *</label>
					<div class="col-sm-7">
					<select name="company" id="company" data-fv-field="company">
									<option value="">--Select--</option>
									<option value="1">Action Workforce</option>
									<option value="4">Concept Engineering</option>
									<option value="5">Action Merchandising</option>
									<option value="6">Rail Safety Worker Australia</option>	
								</select>
					</div>
					</div> 
					
					<div class="form-group row">
					<label class="col-md-3 mode"> Complete Application at</label>
					<div class="col-sm-7">
					<input type="text" class="form-control" name="cname" id="cname" value="">
					</div>
					</div> 
					<div class="form-group row">
					<label class="col-md-3 mode"> Email *</label>
					<div class="col-sm-7">
					<input type="text" class="form-control" name="email" id="email" value="" readonly>
					</div>
					</div> 
					<div class="form-group row">
					<label class="col-md-3 mode"> Mobile Number *</label>
					<div class="col-sm-7">
					<input type="text" class="form-control" name="mobile" id="mobile" value="" >
					</div>
					</div> 
					<div class="form-group row">
					<label class="col-md-3 mode"> Appointment Date *</label>
					<div class="col-sm-7">
					<input type="text" class="form-control" name="adate" id="adate" value="" readonly>
					</div>
					</div> 
					<div class="form-group row">
					<label class="col-md-3 mode"> Appointment Time *</label>
					<div class="col-sm-7">
					<input type="text" class="form-control" name="atime" id="atime" value="" readonly>
					</div>
					</div> 

                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="button-3 edit" id="saveBtn3" value="create">Save changes
                     </button>
                    </div>
				
			 </form>
            </div>
        </div>
    </div>
</div>

<style>
span:hover {
    position: relative;
	 
}

span[aria-label]:hover:after {
     content: attr(aria-label);
     padding: 4px 8px;
    position: absolute;
     left: 0;
     top: 100%;
     white-space: nowrap;
     z-index: 0;
     background:red;
}
</style>
<script type="text/javascript">

$(document).ready(function(){
	
	//$('#imghead').attr("src", "storage/uploads/"+data.header_image);
	
	var rno={{session('rno')}}
	var cols=[];
	cols= [
			{
				data: 'status',
				render: function (dataField) { return ''; },
				fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
				if(!oData.active_candidate || oData.active_candidate=='No'){
				if(oData.status==''){
            $(nTd).append("<a class='stat' title='potential applicant' id='poten' rel='"+oData.id+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;' >P</a><span class='dbl_arw'> ></span>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' title='qualify applicant' id='qual' rel='"+oData.id+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;' >Q</a><span class='dbl_arw'> ></span>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' title='star applicant' id='stars' rel='"+oData.id+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;' >S</a><span class='dbl_arw'> ></span>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' title='schedule interview for applicant' id='insc' rel='"+oData.id+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>IS</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' title='invite applicant' id='invites' rel='"+oData.id+"' rev='"+oData.email_address+"' coords='"+oData.applicant_name+"-"+oData.applicant_email+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;' >I</a>");
				}
				if( oData.status=='1'){
            $(nTd).append("<a class='stat' title='potential applicant' rel='"+oData.id+"' style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>P</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' title='qualify applicant' id='qual' rel='"+oData.id+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>Q</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a title='star applicant' class='stat' id='stars' rel='"+oData.id+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>S</a><span class='dbl_arw'> ></span>&nbsp;&nbsp;");
			$(nTd).append("<a title='schedule interview for applicant' class='stat' id='insc' rel='"+oData.id+"'style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>IS</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a title='invite applicant' class='stat' id='invites' rel='"+oData.id+"' rev='"+oData.email_address+"' coords='"+oData.applicant_name+"-"+oData.applicant_email+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>I</a>&nbsp;&nbsp;");
				}
				if(oData.status=='2'){
   		    $(nTd).append("<a title='potential applicant' class='stat'  rel='"+oData.id+"' style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>P</a><span class='dbl_arw'> ></span>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' title='qualified applicant' rel='"+oData.id+"' style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>Q</a><span class='dbl_arw'> ></span>&nbsp;&nbsp;");
			$(nTd).append("<a title='star applicant' class='stat' id='stars' rel='"+oData.id+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>S</a><span class='dbl_arw'> ></span>&nbsp;&nbsp;");
			$(nTd).append("<a title='schedule interview for applicant' class='stat' id='insc' rel='"+oData.id+"'style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>IS</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a title='invite applicant' class='stat' id='invites' rel='"+oData.id+"' rev='"+oData.email_address+"' coords='"+oData.applicant_name+"-"+oData.applicant_email+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>I</a>&nbsp;&nbsp;");
				}
				if(oData.status=='3'){
            $(nTd).append("<a class='stat' title='potential applicant' rel='"+oData.id+"' style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>P</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' title='qualified applicant' rel='"+oData.id+"' style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>Q</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' title='starred applicant' rel='"+oData.id+"' style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>S</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a title='schedule interview for applicant' class='stat' id='insc' rel='"+oData.id+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>IS</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a title='invite applicant' class='stat' id='invites' rel='"+oData.id+"' rev='"+oData.email_address+"' coords='"+oData.applicant_name+"-"+oData.applicant_email+"' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>I</a>&nbsp;&nbsp;");
				}
				if(oData.status=='4'){
            $(nTd).append("<a title='potential applicant' style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>P</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a title='qualified applicant' style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>Q</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a  title='starred applicant' style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>S</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a class='stat' title='interview scheduled for applicant' rel='"+oData.id+"' style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>IS</a><span class='dbl_arw'> ></span>&nbsp;&nbsp;");
			$(nTd).append("<a title='invite applicant' class='stat' id='invites' rel='"+oData.id+"' rev='"+oData.email_address+"' coords='' style='background:#aaa;color:#fff;padding:4px;font-size:12px;border-radius:12px;cursor:pointer;'>I</a>&nbsp;&nbsp;");
				}
				if(oData.status=='5'){
            $(nTd).append("<a title='potential applicant' style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>P</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a title='qualified applicant' style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>Q</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a title='starred applicant' style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>S</a><span class='dbl_arw'>></span>&nbsp;&nbsp;");
			$(nTd).append("<a title='interview scheduled for applicant' style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>IS</a><span class='dbl_arw'> ></span>&nbsp;&nbsp;");
			$(nTd).append("<a title='invited applicant' style='background:#54bce7;color:#fff;padding:4px;font-size:12px;border-radius:12px;'>I</a>&nbsp;&nbsp;");
				}
				
				}
			}
				
			},
			{
				data: 'applicant_name',
				name: 'applicant_name',
			},
			{
				data: 'applicant_email',
				name: 'applicant_email',
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
				data: 'email_address',
				render: function (dataField) { return ''; },
				fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
					if(oData.email_address)
					$(nTd).append('<span id="'+oData.applicant_email+'" aria-label="please wait.." class="tools">Existing Candidate</a> ');
					
				    else
					$(nTd).append('<span id="'+oData.applicant_email+'" aria-label="please wait.." class="tools">New Applicant</a> ');
				}
			},
			{
				data: 'download',
				render: function (dataField) { return ''; },
				fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
				
					$(nTd).append('<a href="#" id="'+oData.download+'" data-rel="popup" data-position-to="window" class="preview">Preview</a> &nbsp; <a href="/downloads/'+oData.download+'" class="edit btn btn-primary btn-sm">CV Download</a>');
				}
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
	
	//get consultant based on location
	    $('.loca').change(function(){
			var vv= $(this).val();
			//alert(vv);
			$('.consul').html("<option value=''>Select a company</option>");
			$.ajax({
            type: "POST",
			data:{loca:vv},
            url: "/recruitment/managead" +'/' + rno +'/loccon',
			
            success: function (data) {
				 console.log(data);
				 $('.consul').html("<option value=''>Select a company</option>");
				 $.each(data, function(key, value) {
                 //console.log(value);					 
				$('.consul')
				.append($("<option></option>")
                    .attr("value", value['id'])
                    .text(value['first_name'])); 
				});
				
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
	    });
		
		var table = $('#displayall').DataTable();
		var table1 = $('#displayqual').DataTable();
		
		// tooltip for appointment date and no.of jobs
		//$('#displayall tbody').on('mouseover', 'span[class="tools"]' , function () {
		$('body').on('mouseover', 'span.tools', function () {	
		var email=$(this).prop('id');
		$('.tools').attr('aria-label','please wait..');
		 $.ajax({
            type: "POST",
			data:{emails:email},
            url: "/recruitment/managead" +'/' + rno +'/tooltip',
			
            success: function (data) {
				 console.log(data);
				if(data.appointment_date)
					$('.tools').attr('aria-label','Appointment date:'+data.appointment_date+', No of job applied:'+data.jobsappli);
			    else
					$('.tools').attr('aria-label','No of job applied:'+data.jobsappli);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
		});
		
		// preview for cv in popup
		//$('#displayall tbody').on('click', 'a[class="preview"]' , function () {
		$('body').on('click', 'a.preview', function () {
			var ids=$(this).prop('id');
			$('#ajaxModel2').modal('show');
			$('.previewhead').attr("src", "https://view.officeapps.live.com/op/embed.aspx?src=https://ats.dev.apptra.com.au/downloads/"+ids);
		});
		
		
		//------------------------------change status------------------------------------------
		var id='';
		var val='';
		 $('body').on('click', 'a.stat', function () {
		//$('#displayall tbody').on('click', 'a[class="stat"]' , function () {
		var id='';
		var val='';
		var id=$(this).prop('id');
		var exist=$(this).prop('rev');
		//alert(id);
		var val=$(this).prop('rel');
		if(id!==''){
		if(id!=='insc' && id!=='invites'){
		 $.ajax({
            type: "POST",
			data:{valUrl:id, id:val, title:''},
            url: "/recruitment/managead" +'/' + rno +'/statChange',
			dataType: 'json',
            success: function (data) {
				//alert('test');
                $('#displayall').DataTable().draw();
				 $('#displayqual').DataTable().draw();
				 $('#displaystar').DataTable().draw();
				 $('#displayinvite').DataTable().draw();
				 //console.log(data.success);
				 $('.error').show();
				$('.error').text(data.success);
				setTimeout(function(){
                           $('.error').hide();
                        }, 3000);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
		}
		else if(id =='insc'){
			$('#ajaxModel1').modal('show');
			$('#id').val(id);
			$('#val').val(val);
			
		}
		else if(id =='invites'){
			
			
			if(exist=='null'){
				$('#locations').prop('selectedIndex',0);
				$('#company').prop('selectedIndex',0);
				$('#modelHeading3').html("Invite Candidate");
				$('#saveBtn3').val("Invite");
				$('.consul').html("<option value=''>Select a company</option>");
				$('#ajaxModel3').modal('show');
				$('#ids').val(id);
				$('#vals').val(val);
				var getData=$(this).prop('coords');
				$('#invite_id').val('invite');
				if(getData !=''){
				var nameArr = getData.split('-');
				$('#fname').val(nameArr[0]);
				$('#lname').val(nameArr[0]);
				$('#email').val(nameArr[1]);
				}
			}
		    else {
				$('#locations').prop('selectedIndex',0);
				$('#company').prop('selectedIndex',0);
				$('#modelHeading3').html("Re-Invite Candidate");
				$('#saveBtn3').val("Re-Invite");
				$('.consul').html("<option value=''>Select a company</option>");
				$('#ajaxModel3').modal('show');
				$('#ids').val(id);
				$('#vals').val(val);
				var getData=$(this).prop('coords');
				$('#invite_id').val('re-invite');
				if(getData !=''){
				var nameArr = getData.split('-');
				$('#fname').val(nameArr[0]);
				$('#lname').val(nameArr[0]);
				$('#email').val(nameArr[1]);
				}
			}
			
			
		}
		}
		else{
		// Reverse status change	
		var title='';
		title=$(this).prop('title');
		if(title!=='interview scheduled for applicant' && title!=='invited applicant'){
        var ok =confirm("Are you sure want to remove the "+title);
        if(ok == true){		
		$.ajax({
            type: "POST",
			data:{title:title, id:val},
            url: "/recruitment/managead" +'/' + rno +'/statChange',
			dataType: 'json',
            success: function (data) {
				//alert('test');
                $('#displayall').DataTable().draw();
				 $('#displayqual').DataTable().draw();
				 $('#displaystar').DataTable().draw();
				 $('#displayinvite').DataTable().draw();
				 //console.log(data.success);
				  $('.error').show();
				$('.error').text(data.success);
				setTimeout(function(){
                           $('.error').hide();
                        }, 3000);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
		}
		}
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
				  $('.error').show();
				$('.error').text(data.success);
				setTimeout(function(){
                           $('.error').hide();
                        }, 3000);
            },
            error: function (data) {
				$('#ajaxModel1').modal('show');
                console.log('Error:', data);
            }
        });
			}
			else {  alert('select a option'); $('#ajaxModel1').modal('show'); }
	});
	
	
	//--------------------------------status for invite----------------------------------
       //$('body').on('click', '#saveBtn3', function (e) {
	    $('#InForm').on('submit',(function(e) {
		 //alert('test');
		
		
		$.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
             
            e.preventDefault();
            var formData = new FormData(this);
		
		var exist=$('a.stat').prop('rev');
		
		//alert(getData);
			$.ajax({
            type: "POST",
            url: "/recruitment/managead" +'/' + rno +'/statChange',
			data:formData,
			cache:false,
               contentType: false,
               processData: false,
			dataType: 'json',
            success: function (data) {
				//alert('test');
				$('#ajaxModel3').modal('hide');
                $('#displayall').DataTable().draw();
				 $('#displayqual').DataTable().draw();
				 $('#displaystar').DataTable().draw();
				 $('#displayinvite').DataTable().draw();
				  $('.error').show();
				$('.error').text(data.success);
				setTimeout(function(){
                           $('.error').hide();
                        }, 3000);
            },
            error: function (data) {
				$('#ajaxModel3').modal('show');
                console.log('Error:', data);
            }
        });
			
	}));
		

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
		order: [[ 4, "desc" ]],
		
		ajax: {
			
			url: "/recruitment/managead" +'/' + rno +'/all'
		},
		language: {
            'loadingRecords': '&nbsp;',
            'processing': '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
        },                
		columns: cols
	});
	});
	
	$("#qauls").click(function(){
		
	//potenential user table
   /* $('.appli1').show();	
	$('.appli1').attr('id','displaypoten')
	$('#displayalls').show();
	$('#displaypoten').show();
	
	$('#manageposts').hide();
	
	$('#displaypoten').DataTable({
		destroy: true,
		processing: true,
		serverSide: true,
		order: [[ 4, "desc" ]],
		ajax: {
			
			url: "/recruitment/managead" +'/' + rno +'/poten'
		},
		language: {
            'loadingRecords': '&nbsp;',
            'processing': '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
        },     
		columns: cols
	});*/
	
	//qualified user table	
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
		language: {
            'loadingRecords': '&nbsp;',
            'processing': '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
        },     
		columns: cols
	});
	
	});
	
	$("#star").click(function(){
	$('.appli').attr('id','displaystar')
	$('#displayalls').show();
	$('#displaystar').show();
	
	$('#manageposts').hide();
	
	//Interview scheduled user table
    /*$('.appli1').show();	
	$('.appli1').attr('id','displayisc')
	$('#displayalls').show();
	$('#displayisc').show();
	
	$('#manageposts').hide();
	
	$('#displayisc').DataTable({
		destroy: true,
		processing: true,
		serverSide: true,
		order: [[ 4, "desc" ]],
		ajax: {
			
			url: "/recruitment/managead" +'/' + rno +'/isc'
		},
		language: {
            'loadingRecords': '&nbsp;',
            'processing': '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
        },     
		columns: cols
	});*/
	
	//starred user table	
	
	$('#displaystar').DataTable({
		destroy: true,
		processing: true,
		serverSide: true,
		order: [[ 0, "desc" ]],
		ajax: {
			
			url: "/recruitment/managead" +'/' + rno +'/star'
		},
		language: {
            'loadingRecords': '&nbsp;',
            'processing': '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
        },     
		columns: cols
	});
	
	});
	
	$("#invite").click(function(){
	$('.appli').attr('id','displayinvite')
	$('#displayalls').show();
	$('#displayinvite').show();
	$('#displayisc').hide();
	$('#displayisc_wrapper').hide();
	
	$('#manageposts').hide();
	
	$('#displayinvite').DataTable({
		destroy: true,
		processing: true,
		serverSide: true,
		order: [[ 0, "desc" ]],
		ajax: {
			
			url: "/recruitment/managead" +'/' + rno +'/invite'
		},
		language: {
            'loadingRecords': '&nbsp;',
            'processing': '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
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

<link href= 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'> 
<link href= 'https://trentrichardson.com/examples/timepicker/jquery-ui-timepicker-addon.css' rel='stylesheet'> 
 <script src= "https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" > </script> 
 <script src= "https://trentrichardson.com/examples/timepicker/jquery-ui-timepicker-addon.js" > </script> 
        <script>
		 $( function() {
    $( "#adate" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  
    $("#atime").timepicker();

</script>

@endsection



