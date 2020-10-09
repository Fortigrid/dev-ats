@extends('layouts.master')
@section('content')
<div class="container job_board">
    <div class="row justify-content-center">
        <div class="col-md-12">
			<h3>Edit Profile</h3>
				
			 <form method="POST" action="{{ route('editProfile') }}">
                        @csrf
						{{session('message')}}
						@if(count( $errors ) > 0)
    @foreach ($errors->all() as $error)
       <h1>{{ $error }}</h1>
    @endforeach
@endif

                    <div class="form-group row">
						<div class="col-md-4">
                            <label for="fname" class="col-form-label text-md-left">{{ __('First Name') }}</label>
						</div>
                            <div class="col-md-8">
                                <input id="fname" type="text" class="form-control" value="{{$userDet[0]['first_name']}}" readonly">

                               
                            </div>
                        </div>
						
						<div class="form-group row">
						<div class="col-md-4">
                            <label for="lname" class="col-form-label text-md-left">{{ __('Last Name') }}</label>
						</div>
                            <div class="col-md-8">
                                <input id="lname" type="text" class="form-control" value="{{$userDet[0]['last_name']}}" readonly">

                               
                            </div>
                        </div>
						
						<div class="form-group row">
						<div class="col-md-4">
                            <label for="email" class="col-form-label text-md-left">{{ __('Email') }}</label>
						</div>
                            <div class="col-md-8">
                                <input id="email" type="text" class="form-control" value="{{$userDet[0]['email']}}" readonly">

                               
                            </div>
                        </div>
                        

                        <div class="form-group row">
						<div class="col-md-4">
                            <label for="password" class="col-form-label text-md-left">{{ __('New Password') }}</label>
						</div>
                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
						<div class="col-md-4">
                            <label for="password-confirm" class="col-form-label text-md-left">{{ __('Confirm Password') }}</label>
						</div>
                            <div class="col-md-8">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-light">
                                    {{ __('Change Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
		</div>
	</div>
</div>
@endsection
