@extends('layouts.master')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" style="margin-top:20px;">
                <div class="card-header"><b>{{ __('Post Ad') }}</b></div>
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
				 <div>
				   <b>Choose Job Boards</b>
				   <form method="POST">
				   @csrf
				   <div class="row">
				   <div class="col-md-6"><input type="checkbox" id="ckbCheckAll" /> Select All</div><div class="col-md-6"></div>
				   <div class="col-md-6"><input type="checkbox" class="checkBoxClass" name="job_board[]" value="Adjuna"> Adjuna </div>
				   <div class="col-md-6"><input class="checkBoxClass" type="checkbox" name="job_board[]" value="Jora"> Jora</div>
				   <div class="col-md-6"><input class="checkBoxClass" type="checkbox" name="job_board[]" value="Seek"> Seek </div>
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



