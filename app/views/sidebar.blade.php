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
		case 'counts':
		case 'tat':
		case 'infection':
		case 'userstatistics':
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
				<a href="{{ URL::route('user.home')}}" title="{{trans('messages.home')}}" class="loader-gif">
					<span class="glyphicon glyphicon-home"></span> {{trans('messages.home')}}</a>
			</div>
		</li>
		<li>
			<div class="main-menu {{$active[1]}}">
				<a href="{{ URL::route('patient.index')}}" class="loader-gif">
					<span class="glyphicon glyphicon-download-alt"></span> {{ Lang::choice('messages.patient', 2)}}</a>
			</div>
		</li>
		<li>
			<div class="main-menu {{$active[2]}}">
				<a href="{{ URL::route('test.index')}}" class="loader-gif">
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
							{{ Lang::choice('messages.report', 2)}}
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
								<span class="glyphicon glyphicon-tag"></span> {{ Lang::choice('messages.test-category', 2)}}</a>
						</div>
					</li>
					<li>
						<div>
							<a href="{{ URL::route("specimentype.index")}}">
								<span class="glyphicon glyphicon-tag"></span> {{ Lang::choice('messages.specimen-type', 2)}}</a>
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
								<span class="glyphicon glyphicon-tag"></span> {{ Lang::choice('messages.test-type', 2)}}</a>
						</div>
					</li>
				</ul>
			</div>
		</li>
		@endif
		@if(Entrust::can('view_reports'))
		<li>
			<div class="main-menu {{$active[5]}}">
				<a href="{{ URL::route('reports.patient.index')}}" class="loader-gif">
					<span class="glyphicon glyphicon-stats"></span> {{ Lang::choice('messages.report', 2)}}</a>
			</div>
			<div class="sub-menu {{$active[5]}}">
				<div class="sub-menu-title">{{trans('messages.daily-reports')}}</div>
				<ul class="sub-menu-items">
					<li>
						<div>
							<a href="{{ URL::route('reports.patient.index')}}" class="loader-gif">
								<span class="glyphicon glyphicon-tag"></span>
								{{trans('messages.patient-report')}}</a>
						</div>
					</li>
					<li>
						<div><a href="{{ URL::route('reports.daily.log')}}" class="loader-gif">
							<span class="glyphicon glyphicon-tag"></span>
							{{trans('messages.daily-log')}}</a>
						</div>
					</li>
				</ul>
				<div class="sub-menu-title">{{trans('messages.aggregate-reports')}}</div>
				<ul class="sub-menu-items">
					<li>
						<div><a href="{{ URL::route('reports.aggregate.prevalence')}}" class="loader-gif">
							<span class="glyphicon glyphicon-tag"></span>
							{{trans('messages.prevalence-rates')}}</a>
						</div>
					</li>
					<li>
						<div><a href="{{ URL::route('reports.aggregate.counts')}}" class="loader-gif">
							<span class="glyphicon glyphicon-tag"></span>
							{{trans('messages.counts')}}</a>
						</div>
					</li>
					<li>
						<div><a href="{{ URL::route('reports.aggregate.tat')}}" class="loader-gif">
							<span class="glyphicon glyphicon-tag"></span>
							{{trans('messages.turnaround-time')}}</a>
						</div>
					</li>
					<li>
						<div><a href="{{ URL::route('reports.aggregate.infection')}}" class="loader-gif">
							<span class="glyphicon glyphicon-tag"></span>
							{{trans('messages.infection-report')}}</a>
						</div>
					</li>
					<li>
						<div><a href="{{ URL::route('reports.aggregate.userStatistics')}}" class="loader-gif">
							<span class="glyphicon glyphicon-tag"></span>
							{{trans('messages.user-statistics-report')}}</a>
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
								<span class="glyphicon glyphicon-tag"></span> {{ Lang::choice('messages.permission', 2)}}</a>
						</div>
					</li>
					<li>
						<div>
							<a href="{{ URL::route("role.index")}}">
								<span class="glyphicon glyphicon-tag"></span> {{ Lang::choice('messages.role', 2)}}</a>
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
