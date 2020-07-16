@extends('layouts.master')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$.noConflict();
	$('#user').DataTable({
		processing: true,
		serverSide: true,
		ajax: {
			url: "{{ route('home') }}"
		},
		columns: [
			{
				data: 'id',
				name: 'id',
			},
			{
				data: 'name',
				name: 'name',
			},
			{
				data: 'email',
				name: 'email',
			},
			{
				data: 'user_role',
				name: 'user_role',
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
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
					<div class="table-responsive"> 
						<table id="user">
							<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Role</th>
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
@endsection
