@extends('layouts.master')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-top:20px;">
                <div class="card-header">{{ $disAd['job_title']}}</div>
				
				

                <div class="card-body" id="manageposts">
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
				 <div>
				   <b>Choose Job Boards</b>
				   <form method="POST">
				   @csrf
				   <div class="row">
				   <div class="col-md-6"><input type="checkbox" id="ckbCheckAll" /> Select All</div><div class="col-md-6"></div>
				   <div class="col-md-6"><input type="checkbox" class="checkBoxClass" name="job_board[]" value="Adjuna" @if(in_array('Adjuna',$bname)) checked @endif> Adjuna </div>
				   <div class="col-md-6"><input class="checkBoxClass" type="checkbox" name="job_board[]" value="Jora" @if(in_array('Jora',$bname)) checked @endif> Jora</div>
				   <div class="col-md-6"><input class="checkBoxClass" type="checkbox" name="job_board[]" value="Seek" @if(in_array('Seek',$bname)) checked @endif> Seek </div>
				   <div><br></div>
				   <input type="submit" value="next">
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
});
</script>
@endsection







