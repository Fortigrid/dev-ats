@extends('layouts.master')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" style="margin-top:20px;">
                <div class="card-header"><b>Recruitment</b></div>
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
				 <ul>
				 <li><b><a href="/recruitment/adpost">{{ __('Post Ad') }}</b></a> </li>
				 <li><a href="/recruitment/managead"><b>{{ __('Manage Ad') }}</b></a> </li>
				 <li><a href="/recruitment/adpost"> <b>{{ __('Manage Applicant') }}</b></a></li>
				 </ul>
				 </div>
              </div>
           </div>
        </div>
    </div>
</div><br>



@endsection



