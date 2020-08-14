@extends('layouts.master')
@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card recruitment">
                <div class="card-header">Recruitment</div>
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
							<li>{{ $error }}</li>
						@endforeach
						</ul>
					</div>-->
				 @endif
				 <div class="row">
            <div class="col-lg-3 col-sm-6">
                <a href="{{ url('/recruitment/adpost') }}"><div class="card-box">
                    <div class="inner">
                        <h3>{{ __('Post Ad') }}</h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-file-text"></i>
                    </div>
					
                </div></a>
            </div>

            <div class="col-lg-3 col-sm-6">
                  <a href="{{ url('/recruitment/managead') }}"><div class="card-box">
                    <div class="inner">
                        <h3>{{ __('Manage Ad') }}</h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-edit" aria-hidden="true"></i>
                    </div>
                
                </div> </a>
            </div>
            <div class="col-lg-3 col-sm-6">
                <a  href="{{ url('/recruitment/manageappli') }}">
				<div class="card-box">
                    <div class="inner">
                        <h3>{{ __('Manage Applicant') }}</h3>
                      
                    </div>
                    <div class="icon">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </div>
                    
                </div></a>
            </div>
            <div class="col-lg-3 col-sm-6">
				<a  href="{{ url('/recruitment/cvsearch') }}">
                <div class="card-box">
                    <div class="inner">
                        <h3> {{ __('CV Search') }} </h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-search"></i>
                    </div>
                   
                </div> </a>
            </div>
        </div>
				 
				<!--<div class="ad_list">
					 <ul>
						 <li><a href="{{ url('/recruitment/adpost') }}">{{ __('Post Ad') }}</a> <span class="go"><img src="{{ asset('css/img/rct.png') }}" /></span></li>
						 <li><a href="{{ url('/recruitment/managead') }}">{{ __('Manage Ad') }}</a><span class="go"><img src="{{ asset('css/img/rct.png') }}" /></span> </li>
						 <li><a href="{{ url('/recruitment/manageappli') }}">{{ __('Manage Applicant') }}</a><span class="go"><img src="{{ asset('css/img/rct.png') }}" /></span></li>
						 <li><a href="{{ url('/recruitment/cvsearch') }}">{{ __('CV Search') }}</a><span class="go"><img src="{{ asset('css/img/rct.png') }}" /></span></li>
					</ul>
				 </div>-->
              </div>
           </div>
        </div>
		
    </div>
	
	
</div><br>


 

@endsection



