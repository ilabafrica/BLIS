@section("sidebar")
<?php
	$active = array("","","","","","","","","");
	$key = explode("?",str_replace("/", "?", Request::path()));
	switch ($key[0]) {
		case 'home': $active[0] = "active"; break;
		case 'patient': $active[1] = "active"; break;
		case 'test': $active[2] = "active"; break;
		case 'labconfig': 
		case 'instrument':
		case 'reportconfig':
		case 'facility': 
			$active[3] = "active"; break;
		case 'testcategory': 
		case 'testtype': 
		case 'measure': 
		case 'specimentype': 
		case 'specimenrejection': 
		case 'drug':
		case 'organism':
			$active[4] = "active"; break;
		case 'patientreport': 
		case 'dailylog': 
		case 'prevalence':
		case 'surveillance':
		case 'counts':
		case 'tat':
		case 'infection':
		case 'userstatistics':
		case 'qualitycontrol':
			$active[5] = "active"; break;
		case 'permission': 
		case 'assign':
		case 'user': 
		case 'role': 
			$active[6] = "active"; break;
		case 'issue': 
		case 'receipt': 
		case 'topup': 
		case 'metric':
		case 'supplier':
		case 'commodity':
			$active[7] = "active"; break;
		case 'controlresults':
		case 'control':
		case 'lot': $active[8] = "active"; break;
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
					<span class="glyphicon glyphicon-download-alt"></span> {{ Lang::choice('messages.patient', 2)}}</a>
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
							<a href="{{ URL::route("testtype.chooseTestType") }}">
								<span class="glyphicon glyphicon-tag"></span>
									{{Lang::choice('messages.testtype',2)}}
							</a>
						</div>
					</li>
				</ul>
				<ul class="sub-menu-items">
					<li>
						<div>
							<a href="{{ URL::route('instrument.index')}}">
								<span class="glyphicon glyphicon-tag"></span>
								{{Lang::choice('messages.instrument', 2)}}</a>
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
				<ul class="sub-menu-items">
					<li>
						<div><a href="{{ URL::route("reportconfig.surveillance") }}">
							<span class="glyphicon glyphicon-tag"></span>
							{{ trans('messages.surveillance')}}</a>
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
					<li>
						<div>
							<a href="{{ URL::route("drug.index")}}">
								<span class="glyphicon glyphicon-tag"></span> {{ Lang::choice('messages.drug', 2)}}</a>
						</div>
					</li>
					<li>
						<div>
							<a href="{{ URL::route("organism.index")}}">
								<span class="glyphicon glyphicon-tag"></span> {{ Lang::choice('messages.organism', 2)}}</a>
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
					<span class="glyphicon glyphicon-stats"></span> {{ Lang::choice('messages.report', 2)}}</a>
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
						<div><a href="{{ URL::route('reports.aggregate.surveillance')}}">
							<span class="glyphicon glyphicon-tag"></span>
							{{trans('messages.surveillance')}}</a>
						</div>
					</li>
					<li>
						<div><a href="{{ URL::route('reports.aggregate.counts')}}">
							<span class="glyphicon glyphicon-tag"></span>
							{{trans('messages.counts')}}</a>
						</div>
					</li>
					<li>
						<div><a href="{{ URL::route('reports.aggregate.tat')}}">
							<span class="glyphicon glyphicon-tag"></span>
							{{trans('messages.turnaround-time')}}</a>
						</div>
					</li>
					<li>
						<div><a href="{{ URL::route('reports.aggregate.infection')}}">
							<span class="glyphicon glyphicon-tag"></span>
							{{trans('messages.infection-report')}}</a>
						</div>
					</li>
					<li>
						<div><a href="{{ URL::route('reports.aggregate.userStatistics')}}">
							<span class="glyphicon glyphicon-tag"></span>
							{{trans('messages.user-statistics-report')}}</a>
						</div>
					</li>
					<li>
						<div><a href="{{ URL::route('reports.qualityControl')}}">
							<span class="glyphicon glyphicon-tag"></span>
							{{Lang::choice('messages.quality-control', 2)}}</a>
						</div>
					</li>
				</ul>
				<div class="sub-menu-title">{{trans('messages.inventory-reports')}}</div>
				<ul class="sub-menu-items">
					<li>
						<div><a href="{{ URL::route('reports.inventory')}}">
							<span class="glyphicon glyphicon-tag"></span>
							{{trans('messages.stock-levels')}}</a>
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
		@if(Entrust::can('manage_inventory') || Entrust::can('request_topup'))
		<li>
			<div class="main-menu {{$active[7]}}">
				<a href="#">
					<span class="glyphicon glyphicon-download-alt"></span> {{ Lang::choice('messages.inventory', 2)}}</a>
			</div>
			<div class="sub-menu {{$active[7]}}">
				<ul class="sub-menu-items">
					@if(Entrust::can('request_topup'))
					<li>
						<div>
							<a href="{{ URL::route("topup.index")}}">
								<span class="glyphicon glyphicon-tag"></span> {{ Lang::choice('messages.topup', 2)}}</a>
						</div>
					</li>
					@endif
					@if(Entrust::can('manage_inventory'))
					<li>
						<div>
							<a href="{{ URL::route("receipt.index")}}">
								<span class="glyphicon glyphicon-tag"></span> {{ Lang::choice('messages.receipt', 2)}}</a>
						</div>
					</li>
					<li>
						<div>
							<a href="{{ URL::route("issue.index")}}">
								<span class="glyphicon glyphicon-tag"></span> {{ Lang::choice('messages.issue', 2)}}</a>
						</div>
					</li>
					<li>
						<div>
							<a href="{{ URL::route("commodity.index")}}">
								<span class="glyphicon glyphicon-tag"></span> {{trans('messages.commodities')}}</a>
						</div>
					</li>
					<li>
						<div>
							<a href="{{ URL::route("supplier.index")}}">
								<span class="glyphicon glyphicon-tag"></span> {{Lang::choice('messages.suppliers',2)}}</a>
						</div>
					</li>
					<li>
						<div>
							<a href="{{ URL::route("metric.index")}}">
								<span class="glyphicon glyphicon-tag"></span> {{trans('messages.metrics')}}</a>
						</div>
					</li>
					@endif
				</ul>
			</div>
		</li> 
		@endif
		@if(Entrust::can('manage_qc'))
		<li>
			<div class="main-menu {{$active[8]}}">
				<a href="{{ URL::route('control.index') }}" title="{{Lang::choice('messages.quality-control', 2)}}">
					<span class="glyphicon glyphicon-eye-open"></span> {{ Lang::choice('messages.quality-control', 2)}}</a>
			</div>
			<div class="sub-menu {{$active[8]}}">
				<ul class="sub-menu-items">
						<li>
							<div>
								<a href="{{ URL::route('control.resultsIndex') }}">
									<span class="glyphicon glyphicon-tag"></span> {{ Lang::choice('messages.controlresults', 2)}}</a>
							</div>
						</li>
						<li>
							<div>
								<a href="{{ URL::route('control.index') }}">
									<span class="glyphicon glyphicon-tag"></span> {{ Lang::choice('messages.control', 2)}}</a>
							</div>
						</li>
						<li>
							<div>
								<a href="{{ URL::route('lot.index')}}">
									<span class="glyphicon glyphicon-tag"></span> {{ Lang::choice('messages.lot', 2)}}</a>
							</div>
						</li>
				</ul>
			</div>
		</li>
		@endif
	</ul>
@show
