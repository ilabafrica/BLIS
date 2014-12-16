	@section("sidebar")
<?php
	$active = array("","","","","","","");
	$key = explode("?",str_replace("/", "?", Request::path()));
	switch ($key[0]) {
		case 'home': $active[0] = "active"; break;
		case 'patient': $active[1] = "active"; break;
		case 'test': $active[2] = "active"; break;
		case 'labconfig': 
		case 'instrument':
		case 'facility': 
			$active[3] = "active"; break;
		case 'testcategory': 
		case 'testtype': 
		case 'measure': 
		case 'specimentype': 
		case 'specimenrejection': 
			$active[4] = "active"; break;
		case 'patientreport': 
		case 'dailylog': 
		case 'prevalence':
			$active[5] = "active"; break;
		case 'permission': 
		case 'assign':
		case 'user': 
		case 'role': $active[6] = "active"; break;
	}
?>
	<ul class="nav nav-sidebar">
		<li>
			<div class="main-menu {{$active[0]}}">
				<a href="{{ URL::route('user.home')}}" title="{{trans('messages.home')}}">
					<span class="glyphicon glyphicon-home"></span> {{trans('messages.home')}}</a>
			</div>
		</li>
		<li>
			<div class="main-menu {{$active[1]}}">
				<a href="{{ URL::route('patient.index')}}">
					<span class="glyphicon glyphicon-download-alt"></span> {{trans('messages.patients')}}</a>
			</div>
		</li>
		<li>
			<div class="main-menu {{$active[2]}}">
				<a href="{{ URL::route('test.index')}}">
					<span class="glyphicon glyphicon-filter"></span> {{Lang::choice('messages.test', 2)}}</a>
			</div>
		</li>
		@if(Entrust::can('manage_lab_configurations'))
		<li>
			<div class="main-menu {{$active[3]}}">
				<a href="{{ URL::route('instrument.index') }}">
					<span class="glyphicon glyphicon-wrench"></span> {{trans('messages.lab-configuration')}}</a>
			</div>
			<div class="sub-menu {{$active[3]}}">
				<ul class="sub-menu-items">
					<li>
						<div>
							<a href="{{ URL::route('instrument.index')}}">
								<span class="glyphicon glyphicon-tag"></span>
								{{Lang::choice('messages.instrument', 2)}}</a>
						</div>
					</li>
					<li>
						<div>
							<span class="glyphicon glyphicon-tag"></span>
							{{trans('messages.reports')}}
						</div>
					</li>
				</ul>
				<ul class="sub-menu-items">
					<li>
						<div>
							<a href="{{ URL::route("facility.index") }}">
								<span class="glyphicon glyphicon-tag"></span>
									{{Lang::choice('messages.facility',2)}}
							</a>
						</div>
					</li>
				</ul>
			</div>
			

		</li>
		@endif
		@if(Entrust::can('manage_test_catalog'))
		<li>
			<div class="main-menu {{$active[4]}}">
				<a href="{{ URL::route("testcategory.index")}}">
					<span class="glyphicon glyphicon-cog"></span> {{trans('messages.test-catalog')}}</a>
			</div>
			<div class="sub-menu {{$active[4]}}">
				<ul class="sub-menu-items">
					<li>
						<div>
							<a href="{{ URL::route("testcategory.index")}}">
								<span class="glyphicon glyphicon-tag"></span> {{trans('messages.test-categories')}}</a>
						</div>
					</li>
					<li>
						<div>
							<a href="{{ URL::route("specimentype.index")}}">
								<span class="glyphicon glyphicon-tag"></span> {{trans('messages.specimen-types')}}</a>
						</div>
					</li>
					<li>
						<div>
							<a href="{{ URL::route("specimenrejection.index")}}">
								<span class="glyphicon glyphicon-tag"></span> {{trans('messages.specimen-rejection')}}</a>
						</div>
					</li>					
					<li>
						<div>
							<a href="{{ URL::route("testtype.index")}}">
								<span class="glyphicon glyphicon-tag"></span> {{trans('messages.test-types')}}</a>
						</div>
					</li>
					<li>
						<div>
							<a href="{{ URL::route("measure.index")}}" >
								<span class="glyphicon glyphicon-tag"></span> {{trans('messages.measures')}}</a>
						</div>
					</li>
				</ul>
			</div>
		</li>
		@endif
		@if(Entrust::can('view_reports'))
		<li>
			<div class="main-menu {{$active[5]}}">
				<a href="{{ URL::route('reports.patient.index')}}">
					<span class="glyphicon glyphicon-stats"></span> {{trans('messages.reports')}}</a>
			</div>
			<div class="sub-menu {{$active[5]}}">
				<div class="sub-menu-title">{{trans('messages.daily-reports')}}</div>
				<ul class="sub-menu-items">
					<li>
						<div>
							<a href="{{ URL::route('reports.patient.index')}}">
								<span class="glyphicon glyphicon-tag"></span>
								{{trans('messages.patient-report')}}</a>
						</div>
					</li>
					<li>
						<div><a href="{{ URL::route('reports.daily.log')}}">
							<span class="glyphicon glyphicon-tag"></span>
							{{trans('messages.daily-log')}}</a>
						</div>
					</li>
				</ul>
				<div class="sub-menu-title">{{trans('messages.aggregate-reports')}}</div>
				<ul class="sub-menu-items">
					<li>
						<div><a href="{{ URL::route('reports.aggregate.prevalence')}}">
							<span class="glyphicon glyphicon-tag"></span>
							{{trans('messages.prevalence-rates')}}</a>
						</div>
					</li>
					<li>
						<div>
							<span class="glyphicon glyphicon-tag"></span>
							{{trans('messages.counts')}}
						</div>
					</li>
					<li>
						<div>
							<span class="glyphicon glyphicon-tag"></span>
							{{trans('messages.turnaround-time')}}
						</div>
					</li>
					<li>
						<div>
							<span class="glyphicon glyphicon-tag"></span>
							{{trans('messages.infection-report')}}
						</div>
					</li>
				</ul>
			</div>
		</li>
		@endif
		<li>
			<div class="main-menu {{$active[6]}}">
				<a href="{{ (Entrust::can('manage_users')) ? URL::route('user.index') : URL::to('user/'.Auth::user()->id.'/edit') }}">
					<span class="glyphicon glyphicon-cog"></span> {{trans('messages.access-controls')}}</a>
			</div>
			<div class="sub-menu {{$active[6]}}">
				<ul class="sub-menu-items">
					<li>
						<div>
							<a href="{{ (Entrust::can('manage_users')) ? URL::route('user.index') : URL::to('user/'.Auth::user()->id.'/edit') }}">
								<span class="glyphicon glyphicon-tag"></span> {{trans('messages.user-accounts')}}</a>
						</div>
					</li>
					@if(Entrust::hasRole(Role::getAdminRole()->name))
					<li>
						<div>
							<a href="{{ URL::route("permission.index")}}">
								<span class="glyphicon glyphicon-tag"></span> {{trans('messages.permissions')}}</a>
						</div>
					</li>
					<li>
						<div>
							<a href="{{ URL::route("role.index")}}">
								<span class="glyphicon glyphicon-tag"></span> {{trans('messages.roles')}}</a>
						</div>
					</li>
					<li>
						<div>
							<a href="{{ URL::route("role.assign")}}">
								<span class="glyphicon glyphicon-tag"></span> {{trans('messages.assign-roles')}}</a>
						</div>
					</li>
					@endif
				</ul>
			</div>
		</li>
	</ul>
@show
