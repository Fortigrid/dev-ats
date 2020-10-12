@extends('layouts.master')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card recruitment">
                <div class="card-header">{{ __('Manage Draft') }}</div>
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
				  <div >
					<div class="error2" style="color:red;font-weight:bold"></div>
					
				 </div>
				 <div class="table-responsive new"> 
					<table id="draft" class="cell-border stripe hover row-border">
						<thead>
							<tr>
								<th>ID</th>
								<th>Job Title</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
              </div>
           </div>
        </div>
    </div>
</div><br>


<script type="text/javascript">
$(document).ready(function(){
	
	$('#draft').DataTable({
		processing: true,
		serverSide: true,
		order: [[ 0, "desc" ]],
		ajax: {
			url: "{{ route('draft') }}"
		},
		columns: [
			{
				data: 'id',
				name: 'id',
			},
			{
				data: 'job_title',
				name: 'job_title',
			},
			{
				data: 'action',
				name: 'action',
				orderable: false
			}
		]
	});
	
	$('body').on('click', '.delete', function (e) {
		e.preventDefault();
        var Draft_id = $(this).attr('id');
        var ok =confirm("Are You sure want to delete !");
        if(ok == true){
        $.ajax({
            type: "POST",
            url: "/recruitment/managead" +'/' + Draft_id +'/draft/del',
            success: function (data) {
                 $('#draft').DataTable().draw();
				$('.error2').text('Record Deleted');
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



