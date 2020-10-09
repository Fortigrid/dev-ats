@extends('layouts.master')
@section('content')
<div class="container job_board">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Post Ad') }}</div>
                <div class="card-body">
                  @if($errors->any())
					 <div class="alert alert-warning alert-dismissible fade show">
							<button type="button" class="close remove" data-dismiss="alert">&times;</button>
					<strong>Opps Something went wrong!</strong>
					<hr>
						<ul>
						@foreach ($errors->all() as $error)
							<li> {{ $error }} </li>
						@endforeach
						</ul>
					</div>
					<!--<div class="alert alert-danger">
						<p><strong>Opps Something went wrong</strong></p>
						<ul>
						@foreach ($errors->all() as $error)
							<li> {{ $error }}</li>
						@endforeach
						</ul>
					</div>-->
				 @endif
				 <div>
				   <h3>Choose Job Boards</h3>
				   
				   <form method="POST">
				   @csrf
				  <div class="pl-3">
				   <div><input type="checkbox" id="ckbCheckAll" /> Select All</div>
				   <div><input type="checkbox" class="checkBoxClass" name="job_board[]" value="Adjuna"  {{ !empty(old('job_board')) && (in_array('Adjuna', old('job_board'))) ? 'checked' : '' }}> Adjuna </div>
				   <div><input class="checkBoxClass" type="checkbox" name="job_board[]" value="Jora"  {{ !empty(old('job_board')) && (in_array('Jora', old('job_board'))) ? 'checked' : '' }}> Jora</div>
				   <div><input class="checkBoxClass" type="checkbox" name="job_board[]" value="Seek"  {{ !empty(old('job_board')) && (in_array('Seek', old('job_board'))) ? 'checked' : '' }}> Seek </div>
				  </div>
				 <!-- <div> <input type="submit" value="Next" class="submit"> </div>-->
				<div style="float:right;"> <button class="button-2" type="submit"><span>Next</span></button></div>


				   </div>
				   </form>
				 </div>
              </div>
           </div>
        </div>
    </div>
</div><br>
<script type="text/javascript">
$(document).ready(function () {
    $("#ckbCheckAll").click(function () {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    });
    
    $(".checkBoxClass").change(function(){
        if (!$(this).prop("checked")){
            $("#ckbCheckAll").prop("checked",false);
        }
    });
	
	$(".button-2").click(function(){
		var selected=[];
		if($('.checkBoxClass').is(':checked')){
			
			 $(".checkBoxClass:checked").each(function() {
			selected.push($(this).val());
			
			});
			
			$.ajax({

									type: "POST",
									url: "/recruitment/draftAdd",
									data: {boards:selected},
									dataType: 'json',
									
									success: function(response) {
									}
								});
		}
	});
});
</script>
@endsection



