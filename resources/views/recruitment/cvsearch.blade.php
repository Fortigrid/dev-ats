@extends('layouts.master')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('CV Search') }}</div>

                <div class="card-body">
                    @if (session('status'))
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
								<th></th>
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
				data: 'cv',
				name: 'cv',
			},
			{
				data: 'action',
				name: 'action',
				orderable: false
			}
		]
	});
	
	
// For hiding column
if ( $.fn.dataTable.isDataTable( '#manageappli' ) ) {
    table = $('#manageappli').DataTable();
	table.column(4).visible(false);
}
else {
    table = $('#example').DataTable( {
        paging: false
    } );
	}
	
	
});




</script>
@endsection
