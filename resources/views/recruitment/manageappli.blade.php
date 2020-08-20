@extends('layouts.master')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card recruitment">
                <div class="card-header">{{ __('Manage Applicants') }}</div>

                <div class="card-body">
                    @if (session('status'))
					<!--<div class="alert alert-warning alert-dismissible fade show">
							<button type="button" class="close remove" data-dismiss="alert">&times;</button>
							 {{ session('status') }}
					</div>-->
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
					<div class="table-responsive"> 
						<table id="manageappli">
							<thead>
							<tr>
								<th>Date</th>
								<th>Name</th>
								<th>Applied For</th>
								<th>Source</th>
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
	
	$('#manageappli').DataTable({
		processing: true,
		serverSide: true,
		ajax: {
			url: "{{ route('appall') }}"
		},
		columns: [
			{
				data: 'applied_date',
				name: 'applied_date',
			},
			{
				data: 'applicant_name',
				name: 'applicant_name',
			},
			{
				data: 'applicant_for',
				name: 'applicant_for',
			},
			{
				data: 'applicant_source',
				name: 'applicant_source',
			},
			{
				data: 'action',
				name: 'action',
				orderable: false
			}
		]
	});
	
	
});




</script>
@endsection
