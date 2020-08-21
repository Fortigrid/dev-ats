@extends('layouts.master')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('CV Search') }}</div>

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
								<th>Email</th>
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

<div class="modal fade" id="ajaxModel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading">Preview CV</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
			
                
				<iframe class="previewhead" src="" width="750" height="298" seamless=""></iframe>
				
			
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
				data: 'applicant_email',
				name: 'applicant_email',
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
	
	
	$('#manageappli tbody').on('click', 'a[class="preview"]' , function () {
			var ids=$(this).prop('id');
			$('#ajaxModel2').modal('show');
			$('.previewhead').attr("src", "https://view.officeapps.live.com/op/embed.aspx?src=https://ats.dev.apptra.com.au/downloads/"+ids);
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
