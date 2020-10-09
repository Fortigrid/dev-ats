@extends('layouts.master')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><b>{{ __('Preview and Publish Ad') }}</b></div>
                <div class="card-body">
				<form method="post">@csrf
				
				<div class="form-group row">
					<div class="col-md-8 letter">
					    @foreach(session('job') as $job)

						<h1>{{$job}}</h1>
						<div class="col-md-12 new_card">
							<div class="col-md-12">
								<img style="width:100%;height:200px;" src="/storage/uploads/{{$tempDetail['header_image']}}">
							</div>
							<div class="col-md-12">
								<h2>{{session('details.jobtitle')}}</h2>
							</div>
							<div class="col-md-12">
								<h4>{{strip_tags(session('details.jsum'))}}</h4>
							</div>
							<div class="col-md-12">
								<img style="width:100%;height:200px;" src="/storage/uploads/{{$tempDetail['footer_image']}}">
							</div>

						</div>
						<p>&nbsp;</p>
						@endforeach
						<!--<h7>Jora</h7>
						<div style="border:1px solid black">
						<img style="width:100px;height:100px" src="/storage/uploads/{{$tempDetail['header_image']}}">
						<span style="width:100%">{{session('details.jobtitle')}}</span>
						<span style="width:100%">{{session('details.jsum')}}</span>
						<img style="width:100px;height:100px" src="/storage/uploads/{{$tempDetail['footer_image']}}">
						</div>
						<p>&nbsp;</p>
						<h7>Seek</h7>
						<div style="border:1px solid black">
						<img style="width:100px;height:100px" src="/storage/uploads/{{$tempDetail['header_image']}}">
						<span style="width:100%">{{session('details.jobtitle')}}</span>
						<span style="width:100%">{{session('details.jsum')}}</span>
						<img style="width:100px;height:100px" src="/storage/uploads/{{$tempDetail['footer_image']}}">
						</div>-->
					</div>
					</div>
					
                 <div class="form-group row">
					<div class="col-sm-12 text-center">
					    <button type="submit" class="button-1" name="back" value="back"><span>Prev</span></button>
						<button type="submit" class="btn btn-primary">Post Ad</button> 
					</div>
					</div>
				</form>
              </div>
           </div>
        </div>
    </div>
</div><br>



@endsection



