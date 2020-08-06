@extends('layouts.app')

@section('content')
<div id="bg">
<div class="container log_box">
	<div class="row clearfix">
		<div class="col-md-5 acc_log">
			<h3>Login To Your Account</h3>
				<div class="pic">
					<img src="{{ asset('css/img/reg.jpg') }}" />
				</div>
			<p>Not yet an account? <a href="{{ route('register') }}">Register</a></p>
		</div>
		<div class="col-md-7 pwd">
			 <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                          <div class="col-md-12 add"> 
							
							<label for="email" class="col-md-4 col-form-label text-md-left" ><img src="{{ asset('css/img/emailid.png') }}" />{{ __('E-Mail Address') }}</label>
						</div>

                            <div class="col-md-12 space">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
							
                        </div>
						
                        <div class="form-group row">
							<div class="col-md-12 add">
								<label for="password" class="col-md-4 col-form-label text-md-left" style="font-size:15px;"><img src="{{ asset('css/img/pasd.png') }}" />{{ __('Password') }}</label>
							</div>

                            <div class="col-md-12 space">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!--<div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>-->

                       <div class="form-group row mb-0">
                            <div class="text-center col-md-12">
                                <button type="submit" class="btn btn-light">
                                    {{ __('Signin') }}
                                </button> <br>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
		</div>
	</div>
</div>
<!--
<div class="container">
    <div class="row justify-content-center" >
        <div class="col-md-8" >
            <div class="card" id="login-box">
                <div class="card-header" style="text-align:center;border:0px"><h2>Admin Login<h2></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right" style="font-size:15px;">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
							
                        </div>
						<div class="form-group row">
							<input type="text" class="write"></input>
      <label class="hello col-form-label text-md-left ">Username</label>
    <span class="enter"></span>
						</div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right" style="font-size:15px;">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!--<div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>-->

                    <!--   <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary col-md-8">
                                    {{ __('Sign In') }}
                                </button> <br>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>-->
</div>
@endsection
