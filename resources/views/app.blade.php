<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
	<title>{!! Config::get('blis.organization') !!}</title>
	<link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('css/font.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap.css') }}" />
	<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
	<!-- Datepicker -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/datepicker.css') }}" />
</head>
<body class="page-header-fixed page-quick-sidebar-over-content ">
	<div id="app-container">
		<nav class="navbar navbar-inverse navbar-fixed-top striped-bg" id="top-navbar">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="sidenav-toggle" href="#"><span class="brandbar"><i class="fa fa-bars hidd"></i></a></span>
					<a class="navbar-brand" href="http://dashy.strapui.com/laravel"><i class="fa fa-paper-plane"></i>&nbsp;{!! Config::get('blis.name') !!}</a> <div class="solution">&nbsp;{!! Config::get('blis.version') !!}</div>
				</div>
				<div class="right-admin">
					<ul>
						<li class="dropdown hidd">
							<a href="#" class="dropdown-toggle admin-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								<img class="img-circle admin-img" src="img/profile1.jpg" alt="">
							</a>
							<ul class="dropdown-menu admin" role="menu">
								<li role="presentation" class="dropdown-header">Admin name</li>
								<li><a href="profile.html"><i class="fa fa-info"></i> {!! trans('menu.profile') !!}</a></li>
								<li><a href="auth/login.html"><i class="fa fa-power-off"></i> {!! trans('menu.logout') !!}</a></li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right top-nav">
						<li style="border:none;">
							<a href="" class="btn btn-rounded btn-sun-flower" style="padding: 6px 15px; color: #fff; margin-top: 16px; border: none; margin-right: 15px;"><i class="fa fa-clock-o"></i>{!! '  '.date('H:i:s d-m-Y') !!}</a>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle admin-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								<img class="img-circle admin-img" src="img/profile1.jpg" alt="">&nbsp;&nbsp;&nbsp;<span class="add">Admin&nbsp;
								</span>
							</a>
							<ul class="dropdown-menu admin" role="menu">
								<li role="presentation" class="dropdown-header">Admin name</li>
								<li><a href="profile.html"><i class="fa fa-info"></i> {!! trans('menu.profile') !!}</a></li>
								<li><a href="auth/login.html"><i class="fa fa-power-off"></i> {!! trans('menu.logout') !!}</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="striped-bg" id="sidenav">
			<div role="tabpanel" id="navTabs">
				<div class="sidebar-controllers">
				<ul class="nav nav-tabs nav-justified sidebar-top-nav" role="tablist">
				<li role="presentation" class="active"><a href="#menu"><i class="fa fa-bars"></i></a></li>
				<li role="presentation"><a href="#comments"><i class="fa fa-user"></i></a></li>
				<li role="presentation"><a href="#charts"><i class="fa fa-lock"></i></a></li>
				<li role="presentation"><a href="#calendar"><i class="fa fa-sign-out"></i></a></li>
				</ul>
					<div class="">
						<div class="tab-content-scroller tab-content sidebar-section-wrap">
							<div role="tabpanel" class="tab-pane active" id="menu">
								<div class="section-heading">{!! trans('menu.menu') !!}</div>
								<ul class="nav sidebar-nav ">
									<li class="{!! Request::segment(1)==strtolower(trans('menu.home'))?strtolower(trans('general-terms.active')):'' !!}"><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
									<li class="{!! Request::segment(1)==strtolower(trans_choice('menu.patient', 1))?strtolower(trans('general-terms.active')):'' !!}"><a href="{!! url('patient') !!}"><i class="fa fa-street-view"></i> {!! trans('menu.patient-register') !!}</a></li>
									<li><a href="#"><i class="fa fa-user-md"></i> {!! trans_choice('menu.test', 2) !!}</a></li>
									<li class="sidenav-dropdown ">
										<a class="subnav-toggle" href="javascript:;"><i class="fa fa-toggle-off"></i> {!! trans('menu.lab-config') !!} <i class="fa fa-angle-down  pull-right"></i></a>
										<ul class="nav sidenav-sub-menu">
											<li class="sidenav-dropdown ">
												<a class="subnav-toggle" href="#"><i class="fa fa-bar-chart"></i> {!! trans_choice('menu.report', 2) !!}<i class="fa fa-angle-down  pull-right"></i></a>
												<ul class="nav sidenav-sub-menu">
													<li><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-tag"></i> {!! trans('menu.infection-report') !!}</a></li>
													<li><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-tag"></i> {!! trans('menu.test-specimen-grouped') !!}</a></li>
													<li><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-tag"></i> {!! trans('menu.daily-report') !!}</a></li>
													<li><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-tag"></i> {!! trans('menu.worksheet') !!}</a></li>
													<li><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-tag"></i> {!! trans('menu.order-patient-fields') !!}</a></li>
												</ul>
											</li>
											<li><a href="#"><i class="fa fa-tag"></i> {!! trans('menu.referral-facilities') !!}</a></li>
											<li><a href="#"><i class="fa fa-tag"></i> {!! trans('menu.barcode-settings') !!}</a></li>
											<li><a href="#"><i class="fa fa-tag"></i> {!! trans('menu.registration-fields') !!}</a></li>
											<li><a href="#"><i class="fa fa-tag"></i> {!! trans('menu.setup-network') !!}</a></li>
											<li class="sidenav-dropdown ">
												<a class="subnav-toggle" href="#"><i class="fa fa-external-link"></i> {!! trans('menu.external-interface') !!}<i class="fa fa-angle-down  pull-right"></i></a>
												<ul class="nav sidenav-sub-menu">
													<li><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-tag"></i> {!! trans('menu.hmis') !!}</a></li>
													<li><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-tag"></i> {!! trans('menu.interfaced-equipment') !!}</a></li>
												</ul>
											</li>
										</ul>
									</li>
									<li class="sidenav-dropdown{!! in_array(Request::segment(1), ['testcategory', 'specimentype', 'testtype', strtolower(trans_choice('menu.drug', 1)), strtolower(trans_choice('menu.organism', 1)), 'rejection'])?' show-subnav':'' !!}">
										<a class="subnav-toggle" href="#"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!} <i class="fa fa-angle-down fa-angle-down  pull-right"></i></a>
										<ul class="nav sidenav-sub-menu">
											<li class="{!! Request::segment(1)=='testcategory'?strtolower(trans('general-terms.active')):'' !!}"><a href="{!! url('testcategory') !!}"><i class="fa fa-tag"></i> {!! trans_choice('menu.lab-section', 2) !!}</a></li>
											<li class="{!! Request::segment(1)=='specimentype'?strtolower(trans('general-terms.active')):'' !!}"><a href="{!! url('specimentype') !!}"><i class="fa fa-tag"></i> {!! trans_choice('menu.specimen-type', 2) !!}</a></li>
											<li class="{!! Request::segment(1)=='testtype'?strtolower(trans('general-terms.active')):'' !!}"><a href="{!! url('testtype') !!}"><i class="fa fa-tag"></i> {!! trans_choice('menu.test-type', 2) !!}</a></li>
											<li class="{!! Request::segment(1)==strtolower(trans_choice('menu.drug', 1))?strtolower(trans('general-terms.active')):'' !!}"><a href="{!! url('drug') !!}"><i class="fa fa-tag"></i> {!! trans_choice('menu.drug', 2) !!}</a></li>
											<li class="{!! Request::segment(1)==strtolower(trans_choice('menu.organism', 1))?strtolower(trans('general-terms.active')):'' !!}"><a href="{!! url('organism') !!}"><i class="fa fa-tag"></i> {!! trans_choice('menu.organism', 2) !!}</a></li>
											<li class="{!! Request::segment(1)=='rejection'?strtolower(trans('general-terms.active')):'' !!}"><a href="{!! url('rejection') !!}"><i class="fa fa-tag"></i> {!! trans('menu.specimen-rejection') !!}</a></li>
										</ul>
									</li>
									<li class="sidenav-dropdown ">
										<a class="subnav-toggle" href="#"><i class="fa fa-bar-chart"></i> {!! trans_choice('menu.report', 2) !!} <i class="fa fa-angle-down fa-angle-down  pull-right"></i></a>
										<ul class="nav sidenav-sub-menu">
											<li class="sidenav-dropdown ">
												<a class="subnav-toggle" href="#"><i class="fa fa-clock-o"></i> {!! trans('menu.daily-reports') !!}<i class="fa fa-angle-down  pull-right"></i></a>
												<ul class="nav sidenav-sub-menu">
													<li><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-tag"></i> {!! trans('menu.patient-report') !!}</a></li>
													<li><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-tag"></i> {!! trans('menu.daily-log') !!}</a></li>
												</ul>
											</li>
											<li class="sidenav-dropdown ">
												<a class="subnav-toggle" href="#"><i class="fa fa-file-archive-o"></i> {!! trans('menu.aggregate-reports') !!}<i class="fa fa-angle-down  pull-right"></i></a>
												<ul class="nav sidenav-sub-menu">
													<li><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-tag"></i> {!! trans('menu.prevalence-rates') !!}</a></li>
													<li><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-tag"></i> {!! trans('menu.surveillance') !!}</a></li>
													<li><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-tag"></i> {!! trans('menu.test-specimen-counts') !!}</a></li>
													<li><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-tag"></i> {!! trans('menu.turn-around-time') !!}</a></li>
													<li><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-tag"></i> {!! trans('menu.infection-report') !!}</a></li>
												</ul>
											</li>
											<li class="sidenav-dropdown ">
												<a class="subnav-toggle" href="#"><i class="fa fa-book"></i> {!! trans('menu.inventory-reports') !!}<i class="fa fa-angle-down  pull-right"></i></a>
												<ul class="nav sidenav-sub-menu">
													<li><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-tag"></i> {!! trans('menu.stock-levels') !!}</a></li>
												</ul>
											</li>
											<li class="sidenav-dropdown ">
												<a class="subnav-toggle" href="#"><i class="fa fa-eyedropper"></i> QC Reports<i class="fa fa-angle-down  pull-right"></i></a>
												<ul class="nav sidenav-sub-menu">
													<li><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-tag"></i> QC Report</a></li>
												</ul>
											</li>
											<li><a href="#"><i class="fa fa-folder-open"></i> {!! trans('menu.user-statistics') !!}</a></li>
										</ul>
									</li>
									<li class="sidenav-dropdown{!! in_array(Request::segment(1), [strtolower(trans_choice('menu.user', 1)), strtolower(trans_choice('menu.permission', 1)), strtolower(trans_choice('menu.role', 1)), strtolower(trans('menu.authorize'))])?' show-subnav':'' !!}">
										<a class="subnav-toggle" href="#"><i class="fa fa-users"></i> {!! trans('menu.access-control') !!} <i class="fa fa-angle-down fa-angle-down  pull-right"></i></a>
										<ul class="nav sidenav-sub-menu">
											<li class="{!! Request::segment(1)==strtolower(trans_choice('menu.user', 1))?strtolower(trans('general-terms.active')):'' !!}"><a href="{!! url('user') !!}"><i class="fa fa-tag"></i> {!! trans('menu.user-accounts') !!}</a></li>
											<li class="{!! Request::segment(1)==strtolower(trans_choice('menu.permission', 1))?strtolower(trans('general-terms.active')):'' !!}"><a href="{!! url('permission') !!}"><i class="fa fa-tag"></i> {!! trans_choice('menu.permission', 2) !!}</a></li>
											<li class="{!! Request::segment(1)==strtolower(trans_choice('menu.role', 1))?strtolower(trans('general-terms.active')):'' !!}"><a href="{!! url('role') !!}"><i class="fa fa-tag"></i> {!! trans_choice('menu.role', 2) !!}</a></li>
											<li class="{!! Request::segment(1)==strtolower(trans('menu.authorize'))?strtolower(trans('general-terms.active')):'' !!}"><a href="{!! url('authorize') !!}"><i class="fa fa-tag"></i> {!! trans('menu.assign-roles') !!}</a></li>
										</ul>
									</li>
									<li><a href="#"><i class="fa fa-cubes"></i> {!! trans('menu.inventory') !!}</a></li>
									<li class="{!! Request::segment(1)==strtolower(trans('menu.quality-control'))?strtolower(trans('general-terms.active')):'' !!}"><a href="#"><i class="fa fa-bookmark-o"></i> {!! trans('menu.quality-control') !!}</a></li>
									<li><a href="#"><i class="fa fa-hdd-o"></i> {!! trans('menu.data-backup') !!}</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="body-container">
			@yield('content')
			<div id="footer-wrap" class="footer">
				{!! trans('menu.compiled-by') !!} <a href="{{ Config::get('blis.ilab-url') }}">{!! Config::get('blis.ilab') !!}</a> | {!! date('Y') !!}
				<span class="pull-right">
					<a href="javascript:;"><i class="fa fa-facebook-square"></i></a>
					<a href="javascript:;">&nbsp;<i class="fa fa-twitter-square"></i></a>
				</span>
			</div>
		</div>
	</div>
    <!-- jQuery -->
    <script src="{{ asset('js/vendor.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.bootstrap.js') }}"></script>
	<!-- Datepicker -->
	<script src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
	<!-- Custom script -->
	<script type="text/javascript" src="{{ asset('js/script.js') }} "></script>
</body>
</html>