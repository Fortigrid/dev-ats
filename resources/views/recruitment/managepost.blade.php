@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card recruitment">
                <div class="card-header">{{ __('Manage Ads') }}</div>
				<div class="btn-group nav nav-pills">
					<button type="button" data-toggle="pill" class="btn btn-info nav-link active" id="lads">Live Ads</button>
					<button type="button" data-toggle="pill" class="nav-link btn btn-info"id="eads">Expired Ads</button>
				</div>
				
					<!--<div class="table-responsive"> 
						<table class="cell-border stripe hover row-border">
							<thead>
							<tr>
								<th><a id="lads">Live Ads </a> &nbsp;&nbsp;&nbsp;</th>
								<th><a  id="eads">Expired Ads </a> &nbsp;&nbsp;&nbsp;</th>
								
							</tr>
							</thead>
						</table>
					</div>-->

                <div class="card-body">
					<div style="float:right" class="mt-3 mb-3">
					<button class="mdelete btn btn-danger dlt"><i class="fa fa-trash"></i></button>
					</div>
					<div class="table-responsive"> 
					  <div class="error"></div>
						<table id="" class="cell-border stripe hover row-border appli">
							<thead>
							<tr>
							    <th><input type="checkbox" id="ckbCheckAll" /></th>
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
                <h4 class="modal-title" id="modelHeading">Status</h4>
				 <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
			
                
				<div class="alert alert-danger print-error-msg" style="display:none">
        <ul></ul>
    </div>
                   
				   <input type="hidden" name="val" id="val">
					
					<div class="error1"></div>
					<div class="form-group ">
					<!--<label class="col-sm-8 control-label">Status</label>-->
					<p class="field switch" style="padding-left:8px;">
					<!--<div class="row">
						<div class="col-md-2">
							<b>Name</b>
						</div>
						<div class="col-md-4">
							<b>Response</b>
							<div class="drow" style="float:left;width:100%"></div>
						</div>
					</div>-->
					
					<ul><li style='float:left;list-style:none;width:20px;'>&nbsp;</li>
					<li style='float:left;list-style:none;width:50px;'><b>Name</b></li>
					<li style='float:left;list-style:none;margin-left:30px;'><b>Response</b></li>
					<li style='float:left;list-style:none;margin-left:30px;'><b>Expiry Date</b></li>
					</ul>
					<div class="drow" style="float:left;width:100%;">
					
					</div>
					<input type="submit" name="delete" id="deletes" value="Delete">
					</p></div>  

                    
                
				
			
            </div>
        </div>
    </div>
</div>
<style>

</style>
<script type="text/javascript">
$(document).ready(function(){
	
	$.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
	
	$("#ckbCheckAll").click(function () {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    });
    
    $(".checkBoxClass").change(function(){
        if (!$(this).prop("checked")){
            $("#ckbCheckAll").prop("checked",false);
        }
    });
	
	var cols=[];
	
	cols= [
			{
				data: 'id',
				render: function (dataField) { return ''; },
				fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
					var id = "{{ Auth::user()->id }}";
					var role = "{{ Auth::user()->role }}";
					if( role==='admin')
					$(nTd).html("<input type='checkbox' class='checkBoxClass' name='jobs[]' value='"+oData.id+"'>");
					else if((role==='consult' || role==='state'))
					$(nTd).html("<input type='checkbox' class='checkBoxClass' name='jobs[]' value='"+oData.id+"'>");
				    else
					$(nTd).html("");
					
				},
				orderable: false
			},
			{
				data: 'response',
				name: 'response',
			},
			{
				data: 'post_date',
				name: 'post_date',
			},
			{
				data: 'job_title',
				name: 'job_title',
				fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
				/*var id = "{{ Auth::user()->id }}";
				var role = "{{ Auth::user()->role }}";
				    if( role==="admin")
					$(nTd).html("<a href='/recruitment/managead/"+oData.id+"'>"+oData.job_title+"</a>");
					else if(id===oData.created_by && role==="consult")
					$(nTd).html("<a href='/recruitment/managead/"+oData.id+"'>"+oData.job_title+"</a>");
					else
					$(nTd).html("<a style='text-decoration:none'>"+oData.job_title+"</a>");*/
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
		
		$('.mdelete').show();
		$('#liveads tbody .checkBoxClass').show();
		
		$('.mdelete').click(function(){
			
			if($('.checkBoxClass').is(':checked')){
			
			var checkbox_value=[];
			
			var myTable = $('#liveads').dataTable();

			
			var rowcollection = myTable.$(".checkBoxClass:checked", {"page": "all"});
			rowcollection.each(function(index,elem){
    
			checkbox_value += $(elem).val()+',';
    
			});
			//alert(checkbox_value);
			var ok =confirm("Are you sure want to delete !");
        if(ok == true){
			$.ajax({
			type: "POST",
			data:{deleids:checkbox_value},
			url: "/recruitment/managead",
			dataType: 'json',
				success: function (data) {
					$('#liveads').DataTable().draw();
				},
				error: function (data) {
               console.log(JSON.stringify(data));
				}
			});
		}
			}
			else{
				alert('Please select a checkbox to delete');
			}
			});
		
		
	/*$('#managepost').DataTable({
		processing: true,
		serverSide: true,
		order: [[ 0, "desc" ]],
		ajax: {
			url: "{{ route('mpost') }}"
		},
		columns: cols
	});*/
	
	
	$('#deletes').click(function(){
			var selected=[];
			var seleboard=[];
			if($('.boardss').is(':checked')){
			
			 $("input:checkbox[name=boardss]:checked").each(function() {
			selected.push($(this).val());
			seleboard.push($(this).prop('id'));
			});
			var jobid=$('#val').val();
			
			
			var ok =confirm("Are you sure want to delete !");
        if(ok == true){
			$.ajax({
			type: "POST",
			data:{deleboards:selected, jobid:jobid, deleboname:seleboard},
			url: "/recruitment/managead",
			dataType: 'json',
				success: function (data) {
					$(".drow").html("");
					$.ajax({
							type: "POST",
							data:{adid:jobid},
							url: "/recruitment/managead",
							dataType: 'json',
							success: function (data) {
							var now = new Date();
							$.each(data, function(key, value) {
				
							//expiry date validation
							var expiry = new Date(value['expiry_date']);
							var startValidAppDate = new Date(value['expiry_date']);
						startValidAppDate.setTime(expiry.getTime() - (7 * 1 * 24 * 60 * 60 * 1000)); // 1 week
						if(value["response"]=="") value["response"]='0';
			
						if(now <= expiry && now > startValidAppDate){
						$(".drow").append("<ul class='boar' style='float:left;width:100%;background-color:yellow'><li style='float:left;list-style:none;width:20px;'><input type='checkbox' value="+value["id"]+" class='boardss' name='boardss' id="+value["board_name"]+"></li> <li style='float:left;list-style:none;width:50px;' value="+value["board_name"]+">"+value["board_name"]+"</li><li style='float:left;list-style:none;margin-left:30px'>"+value["response"]+"</li><li style='float:left;list-style:none;margin-left:30px'>"+value["expiry_date"]+"</li></ul>");
						}
						else if(now > expiry){
						$(".drow").append("<ul class='boar' style='float:left;width:100%;background-color:red'><li style='float:left;list-style:none;width:20px;'><input type='checkbox' value="+value["id"]+" class='boardss' name='boardss' id="+value["board_name"]+"></li> <li style='float:left;list-style:none;width:10px;'></li> <li style='float:left;list-style:none;width:50px;' value="+value["board_name"]+">"+value["board_name"]+"</li><li style='float:left;list-style:none;margin-left:30px'>"+value["response"]+"</li><li style='float:left;list-style:none;margin-left:30px'>"+value["expiry_date"]+"</li></ul>");

						}
						else {
						$(".drow").append("<ul class='boar' style='float:left;width:100%;'><li style='float:left;list-style:none;width:20px;'><input type='checkbox' value="+value["id"]+" class='boardss' name='boardss' id="+value["board_name"]+"></li> <li style='float:left;list-style:none;width:10px;'></li> <li style='float:left;list-style:none;width:50px;' value="+value["board_name"]+">"+value["board_name"]+"</li><li style='float:left;list-style:none;margin-left:30px'>"+value["response"]+"</li><li style='float:left;list-style:none;margin-left:30px'>"+value["expiry_date"]+"</li></ul>");

						}
						});
							}
						});
					if(data == 'board deleted'){
						$('.error').show();
						$('.error').text(data);
						$('.error1').show();
						$('.error1').text(data);
						setTimeout(function(){
                           $('.error').hide();
						   $('.error1').hide();
                        }, 5000);
						
					}
					if(data == 'job deleted'){
						$('.error').show();
						$('.error').text(data);
						$('.error1').show();
						$('.error1').text(data);
						setTimeout(function(){
                           $('.error').hide();
						   $('.error1').hide();
                        }, 5000);
						$('#ajaxModel1').modal('hide');
					}
					$('#liveads').DataTable().draw();
				},
				error: function (data) {
					alert(JSON.stringify(data));
               console.log(JSON.stringify(data));
				}
			});
		}
			}
			else{
				alert('Please select a checkbox to delete');
			}
			});
	
	
	
	
	$('.appli').attr('id','liveads')
	
	
	$('#liveads').show();
	
	var bb= $('.appli').attr('id');
	//alert(bb);
	//$('#liveads tbody').on('click', 'a[class="edits"]' , function () {
		$('body').on('click', '.edits', function () {
			$(".drow").html("");
		//alert('test');
		var id=$(this).attr('id');
		$('#val').val(id);
		//alert(id);
		$('#ajaxModel1').modal('show');
		$.ajax({
            type: "POST",
			data:{adid:id},
            url: "/recruitment/managead",
			dataType: 'json',
            success: function (data) {
			var now = new Date();
			$.each(data, function(key, value) {
				
			 //expiry date validation
             var expiry = new Date(value['expiry_date']);
			 var startValidAppDate = new Date(value['expiry_date']);
			 startValidAppDate.setTime(expiry.getTime() - (7 * 1 * 24 * 60 * 60 * 1000)); //1 week
			 console.log(now);
			 console.log(expiry);
			console.log(startValidAppDate);
			if(value["response"]=="") value["response"]='0';
			if(now <= expiry && now > startValidAppDate){
			$(".drow").append("<ul class='boar' style='float:left;width:100%;background-color:yellow'><li style='float:left;list-style:none;width:20px;'><input type='checkbox' value="+value["id"]+" class='boardss' name='boardss' id="+value["board_name"]+"></li> <li class='boname' style='float:left;list-style:none;width:50px;' value="+value["board_name"]+">"+value["board_name"]+"</li><li style='float:left;list-style:none;margin-left:30px'>"+value["response"]+"</li><li style='float:left;list-style:none;margin-left:30px'>"+value["expiry_date"]+"</li></ul>");
		    }
			else if(now > expiry){
				$(".drow").append("<ul class='boar' style='float:left;width:100%;background-color:red'><li style='float:left;list-style:none;width:20px;'><input type='checkbox' value="+value["id"]+" class='boardss' name='boardss' id="+value["board_name"]+"></li> <li class='boname' style='float:left;list-style:none;width:10px;'></li> <li style='float:left;list-style:none;width:50px;' value="+value["board_name"]+">"+value["board_name"]+"</li><li style='float:left;list-style:none;margin-left:30px'>"+value["response"]+"</li><li style='float:left;list-style:none;margin-left:30px'>"+value["expiry_date"]+"</li></ul>");

			}
			else {
				$(".drow").append("<ul class='boar' style='float:left;width:100%;'><li style='float:left;list-style:none;width:20px;'><input type='checkbox' value="+value["id"]+" class='boardss' name='boardss' id="+value["board_name"]+"></li> <li class='boname' style='float:left;list-style:none;width:10px;'></li> <li style='float:left;list-style:none;width:50px;' value="+value["board_name"]+">"+value["board_name"]+"</li><li style='float:left;list-style:none;margin-left:30px'>"+value["response"]+"</li><li style='float:left;list-style:none;margin-left:30px'>"+value["expiry_date"]+"</li></ul>");

			}
			});
				
               
            },
            error: function (data) {
               console.log(JSON.stringify(data));
            }
		});
	});
	
	
	
	
	$('#liveads').DataTable({
		destroy: true,
		processing: true,
		serverSide: true,
		order: [[ 2, "desc" ]],
		ajax: {
			data:{ids:'liveads'},
			url: "/recruitment/managead"
		},
		language: {
            'loadingRecords': '&nbsp;',
            'processing': '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
        },     
		columns: cols,
		createdRow: function( row, data, dataIndex){
			
                if( data['expiry'] ==  '1'){
                    $(row).find('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)').css('cssText','background-color:yellow !important');
                }
            }
	});
	
	
	$("#lads").click(function(){
	$('.appli').attr('id','liveads')
	
	
	$('#liveads').show();
	$('.mdelete').show();
	$('#liveads tbody .checkBoxClass').show();
	$('#liveads').DataTable({
		destroy: true,
		processing: true,
		serverSide: true,
		order: [[ 2, "desc" ]],
		ajax: {
			type: "POST",
			data:{ids:'liveads'},
			url: "/recruitment/managead"
		},
		language: {
            'loadingRecords': '&nbsp;',
            'processing': '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
        },     
		columns: cols,
		createdRow: function( row, data, dataIndex){
			
                if( data['expiry'] ==  '1'){
                    $(row).find('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)').css('cssText','background-color:yellow !important');
                }
            }
	});
	});
	
	
	$("#eads").click(function(){
	$('.appli').attr('id','expads')
	
	
	$('#expads').show();
	$('.mdelete').hide();
	$('#expads tbody tr td input.checkBoxClass').hide();
	$('#expads').DataTable({
		destroy: true,
		processing: true,
		serverSide: true,
		order: [[ 2, "desc" ]],
		ajax: {
			type: "POST",
			data:{ids:'expads'},
			url: "/recruitment/managead"
		},
		language: {
            'loadingRecords': '&nbsp;',
            'processing': '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
        },     
		columns: cols
	});
	});
	
	
	
});
</script>


@endsection



