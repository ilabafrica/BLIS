@section("sidebar")
<?php
	$active = array("","","","","","","");
	$key = explode("?",str_replace("/", "?", $_SERVER["REQUEST_URI"]));
	switch ($key[1]) {
		case 'home': $active[0] = "active"; break;
		case 'patient': $active[1] = "active"; break;
		case 'test': $active[2] = "active"; break;
		case 'user': $active[3] = "active"; break;
		case 'testcategory': 
		case 'testtype': 
		case 'measure': 
		case 'specimentype': 
			$active[4] = "active"; break;
		case 'report': $active[5] = "active"; break;
		case 'inventory': $active[6] = "active"; break;
	}
?>
	<ul class="nav nav-sidebar">
		<li>
			<div class="main-menu {{$active[0]}}">
				<a href="{{ URL::route('user.home')}}" title="Home">
					<span class="glyphicon glyphicon-home"></span> Home</a>
			</div>
		</li>
		<li>
			<div class="main-menu {{$active[1]}}">
				<a href="{{ URL::route('patient.index')}}">
					<span class="glyphicon glyphicon-download-alt"></span> Reception</a>
			</div>
		</li>
		<li>
			<div class="main-menu {{$active[2]}}">
				<a href="{{ URL::route('test.index')}}">
				<!-- <a href="javascript:void(0);"> -->
					<span class="glyphicon glyphicon-filter"></span> Tests</a>
			</div>
		</li>
		<li>
			<div class="main-menu {{$active[3]}}">
				<a href="{{ URL::route("user.index")}}">
					<span class="glyphicon glyphicon-wrench"></span> Lab Configuration</a>
			</div>
			<div class="sub-menu {{$active[3]}}">
				<ul class="sub-menu-items">
					<li>
						<div>
							<a href="{{ URL::route("user.index")}}">
								<span class="glyphicon glyphicon-tag"></span> User Accounts</a>
						</div>
					</li>
					<li>
						<div>
							<span class="glyphicon glyphicon-tag"></span>
							Reports
						</div>
					</li>
				</ul>
			</div>
		</li>
		<li>
			<div class="main-menu {{$active[4]}}">
				<a href="{{ URL::route("testcategory.index")}}">
					<span class="glyphicon glyphicon-cog"></span> Test Catalog</a>
			</div>
			<div class="sub-menu {{$active[4]}}">
				<ul class="sub-menu-items">
					<li>
						<div>
							<a href="{{ URL::route("testcategory.index")}}">
								<span class="glyphicon glyphicon-tag"></span> Lab Sections</a>
						</div>
					</li>
					<li>
						<div>
							<a href="{{ URL::route("specimentype.index")}}">
								<span class="glyphicon glyphicon-tag"></span> Specimen Types</a>
						</div>
					</li>
					<li>
						<div>
							<a href="{{ URL::route("testtype.index")}}">
								<span class="glyphicon glyphicon-tag"></span> Test Types</a>
						</div>
					</li>
					<li>
						<div>
							<a href="{{ URL::route("measure.index")}}" >
								<span class="glyphicon glyphicon-tag"></span> Measures</a>
						</div>
					</li>
				</ul>
			</div>
		</li>
		<li>
			<div class="main-menu {{$active[5]}}">
				<a href="javascript:void(0);">
					<span class="glyphicon glyphicon-stats"></span> Reports</a>
			</div>
			<div class="sub-menu {{$active[5]}}">
				<div class="sub-menu-title">Daily Reports</div>
				<ul class="sub-menu-items">
					<li>
						<div>
						<a href="{{ URL::route("reports.patient.index")}}" >
							<span class="glyphicon glyphicon-tag"></span>
							Patient Report</a>
						</div>
					</li>
					<li>
						<div>
						<a href="{{ URL::route("reports.daily.index")}}" >
							<span class="glyphicon glyphicon-tag"></span>
							Daily Log</a>
						</div>
					</li>
				</ul>
				<div class="sub-menu-title">Aggregate Reports</div>
				<ul class="sub-menu-items">
					<li>
						<div>
						<a href="{{ URL::route("reports.prevalence.index")}}" >
							<span class="glyphicon glyphicon-tag"></span>
							Prevalence Rates</a>
						</div>
					</li>
					<li>
						<div>
						<a href="{{ URL::route("reports.counts.index")}}" >
							<span class="glyphicon glyphicon-tag"></span>
							Counts</a>
						</div>
					</li>
					<li>
						<div>
						<a href="{{ URL::route("reports.tat.index")}}" >
							<span class="glyphicon glyphicon-tag"></span>
							Turnaround Time</a>
						</div>
					</li>
					<li>
						<div>
						<a href="{{ URL::route("reports.infection.index")}}" >
							<span class="glyphicon glyphicon-tag"></span>
							Infection Report</a>
						</div>
					</li>
				</ul>
			</div>
		</li>
		<li>
			<div class="main-menu {{$active[6]}}">
				<a href="javascript:void(0);">
					<span class="glyphicon glyphicon-briefcase"></span> Inventory</a>
			</div>
		</li>
	</ul>
@show
