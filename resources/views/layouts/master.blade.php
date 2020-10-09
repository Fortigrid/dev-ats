
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ApplyTracker</title>


  <!-- Google Font: Source Sans Pro -->

  <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
  <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  
  <link href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/css/adminlte.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/multiselect.css') }}">
  <link rel="stylesheet" href="{{ asset('css/full.css') }}">
  

  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/js/adminlte.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.0.4/popper.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <script src="{{ asset('js/multiselect.js') }}"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
  
   <script src="{{ asset('js/main.js') }}"></script>



	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	
</head>
<body class="hold-transition sidebar-mini" >
<div class="wrapper" >

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fa fa-bars"></i></a>
      </li>
      <!--<li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>-->
    </ul>

    <!-- SEARCH FORM 
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>-->
	
	
     <div>&nbsp;&nbsp;<button onclick="window.history.back()"><< Go Back</button> &nbsp;&nbsp; <button onclick="window.history.forward()">Go Forward >> </button></div>
	 
	 <div><form><select id="multiselectss" name="location[]" multiple="multiple" >
							@foreach($locas as $loca)
								<option value="{{$loca['id']}}"> {{$loca['location']}}</option>
							 @endforeach
							     
							</select> </form> 
							
							<script>

							$(document).ready(function(){
								
							var searchedLocation = sessionStorage.getItem("locat");
							
							if(!searchedLocation){
							$('#multiselectss option').each(function(){
							this.selected=true;
							});
							$('#multiselectss').multiselect("refresh");
							}
								
								
							
							if(searchedLocation!=null && searchedLocation.indexOf(',') > -1) var aFirst = searchedLocation.split(','); else var aFirst= sessionStorage.getItem("locat");
							$('#multiselectss').multiselect('select', aFirst);
								
								
								 $.ajaxSetup({
								headers: {
									'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								}
								});
								$.ajax({

									type: "POST",
									url: "/recruitment/locasession",
									data: {searchedLocation:searchedLocation},
									dataType: 'json',
									cache: false,
									success: function(response) {
									}
								});
							});

							$('#multiselectss').change(function () {
							
							sessionStorage.setItem("locat", $("#multiselectss").val());
							
							location.reload();
							
							
							});
							</script>
							
							
							
							</div>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="fa fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
            class="fas fa-th-large"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="" alt="" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light text-center">ApplyTracker</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
         <!-- <img src="" class="img-circle elevation-2" alt="">	-->
        </div>
        <div class="info">
          <a href="#" class="d-block"><i class="fa fa-user-circle"></i>	@auth {{ Auth::user()->first_name }} ({{ Auth::user()->role }}) @endauth</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
			    <!--<li class="nav-item">
                 <a href="#" class="nav-link">
                  <i class="fa fa-th nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>-->
			   <li class="nav-item has-treeview">
                 <a href="#" class="nav-link ">
                  <i class="fa fa-search nav-icon"></i>
                  <p>Recruitment <i class="right fa fa-angle-right"></i></p>
                </a>
				 <ul class="nav nav-treeview">
				   <li class="nav-item" style="padding-left:20px;">
                <a href="{{ url('/recruitment/adpost') }}" class="nav-link ">
                  <i class="fa fa-address-card nav-icon"></i>
                  <p>Post Ad</p>
                </a>
              </li>
			  
              <li class="nav-item" style="padding-left:20px;">
                <a href="{{ url('/recruitment/managead') }}" class="nav-link">
                  <i class="fa fa-list nav-icon"></i>
                  <p>Manage Ad</p>
                </a>
              </li>
			  
			  <li class="nav-item" style="padding-left:20px;">
                <a href="{{ url('/recruitment/drafts') }}" class="nav-link">
                  <i class="fa fa-list nav-icon"></i>
                  <p>Draft Ad</p>
                </a>
              </li>
			  
			  <li class="nav-item" style="padding-left:20px;">
                <a href="{{ url('/recruitment/manageappli') }}" class="nav-link">
                  <i class="fa fa-users nav-icon"></i>
                  <p>Manage Applicants</p>
                </a>
              </li>
			  <li class="nav-item" style="padding-left:20px;">
                <a href="{{ url('/recruitment/cvsearch') }}" class="nav-link">
                  <i class="fa fa-search nav-icon"></i>
                  <p>CV Search</p>
                </a>
              </li>
			  <li class="nav-item" style="padding-left:20px;">
                <a href="{{ url('/recruitment/scheduler') }}" class="nav-link">
                  <i class="fa fa-search nav-icon"></i>
                  <p>Interview Scheduler</p>
                </a>
              </li>
				 </ul>
              </li>
			  <!--<li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>OnBoarding</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>CMS</p>
                </a>
              </li>
			  <li class="nav-item">
                 <a href="#" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>CRM</p>
                </a>
              </li>
			  <li class="nav-item">
                 <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rostering</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="#" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reporting</p>
                </a>
              </li>-->
			  @can('view-user')
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-gears"></i>
              <p>
                Configuration
                <i class="right fa fa-angle-right"></i>
              </p>
            </a>
			
            <ul class="nav nav-treeview">
			
              <!--<li class="nav-item" style="padding-left:20px;">
                <a href="{{ url('/business') }}" class="nav-link ">
                  <i class="fa fa-address-card nav-icon"></i>
                  <p>Business Unit</p>
                </a>
              </li>
			  
              <li class="nav-item" style="padding-left:20px;">
                <a href="{{ url('/location') }}" class="nav-link">
                  <i class="fa fa-map-marker nav-icon"></i>
                  <p>Location</p>
                </a>
              </li>
			  
			  <li class="nav-item" style="padding-left:20px;">
                <a href="{{ url('/client') }}" class="nav-link">
                  <i class="fa fa-users nav-icon"></i>
                  <p>Clients</p>
                </a>
              </li>
			  <li class="nav-item" style="padding-left:20px;">
                <a href="{{ url('/site') }}" class="nav-link">
                  <i class="fa fa-globe nav-icon"></i>
                  <p>Sites</p>
                </a>
              </li>
			  <li class="nav-item" style="padding-left:20px;">
                <a href="{{ url('/agency') }}" class="nav-link">
                  <i class="fa fa-building nav-icon"></i>
                  <p>Agency</p>
                </a>
              </li>
			   <li class="nav-item" style="padding-left:20px;">
                <a href="{{ url('/role') }}" class="nav-link">
                  <i class="fa fa-clipboard nav-icon"></i>
                  <p>Roles</p>
                </a>
              </li>-->
			  <li class="nav-item" style="padding-left:20px;">
                <a href="{{ url('/job-template') }}" class="nav-link">
                  <i class="fa fa-graduation-cap	 nav-icon"></i>
                  <p>Job Template</p>
                </a>
              </li>
			  <li class="nav-item" style="padding-left:20px;">
                <a href="{{ url('/brules') }}" class="nav-link">
                  <i class="fa fa-graduation-cap	 nav-icon"></i>
                  <p>Business Rules</p>
                </a>
              </li>
            </ul>
          </li>
		  @endcan
		   <li class="nav-item">
		    <a href="{{ url('/edit-profile') }}" class="nav-link">
			 <i class="fa fa-address-card nav-icon"></i>
			<p>Update Profile</p></a>
		   </li>

          <li class="nav-item pl-2">

            <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="nav-link">
              <i class="fa fa-power-off"></i>
              <p>
                Logout
               
              </p>
            </a>
			 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!--<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Starter Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
	   
      <!--<router-view></router-view>-->
	   @yield('content')
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
     
    </div>
    <!-- Default to the left -->
    <strong></strong> 
  </footer>
</div>
<!-- ./wrapper -->
<!--<script src="{{ asset('js/app.js') }}" defer></script>-->

<!-- REQUIRED SCRIPTS -->
<script>
	$('#multiselectss').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
			enableHTML: false,
            filterPlaceholder: 'Select location..',
			maxHeight: 300
        }); 
	</script>

</body>
</html>
