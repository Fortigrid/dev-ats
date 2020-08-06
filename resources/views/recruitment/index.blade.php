@extends('layouts.master')


@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card recruitment">
                <div class="card-header text-center"><b>Recruitment</b></div>
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
					<div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-blue">
                    <div class="inner">
                        {{ __('Post Ad') }}
						<div class="view">
							<a href="{{ url('/recruitment/adpost') }}">View More <i class="arrow right"></i><i class="arrow right"></i></a>
						</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-green">
                    <div class="inner">
                        {{ __('Manage Ad') }}
							<div class="view">
							<a href="{{ url('/recruitment/managead') }}">View More <i class="arrow right"></i><i class="arrow right"></i></a>
							</div>
                    </div>
                   
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-orange">
                    <div class="inner">
                       {{ __('Manage Applicant') }}
					  <div class="view">
					  <a href="{{ url('/recruitment/manageappli') }}">View More <i class="arrow right"></i><i class="arrow right"></i></a>
					  </div>
                    </div>
                   
                   
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-red">
                    <div class="inner">
                        {{ __('CV Search') }}
						<div class="view">
						<a href="{{ url('/recruitment/cvsearch') }}">View More <i class="arrow right"></i><i class="arrow right"></i></a>
						</div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
				 <!--<ul>
				 <li><b><a href="{{ url('/recruitment/adpost') }}">{{ __('Post Ad') }}</b></a> </li>
				 <li><a href="{{ url('/recruitment/managead') }}"><b>{{ __('Manage Ad') }}</b></a> </li>
				 <li><a href="{{ url('/recruitment/manageappli') }}"> <b>{{ __('Manage Applicant') }}</b></a></li>
				 <li><a href="{{ url('/recruitment/cvsearch') }}"> <b>{{ __('CV Search') }}</b></a></li>
				 </ul>-->
				 </div>
              </div>
           </div>
        </div>
    </div>
</div><br>



@endsection



