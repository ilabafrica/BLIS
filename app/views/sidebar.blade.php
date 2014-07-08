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
				<span class="glyphicon glyphicon-home"></span>
				<a href="{{ URL::route('user.home')}}" title="Home">Home</a>
			</div>
		</li>
		<li>
			<div class="main-menu {{$active[1]}}">
				<span class="glyphicon glyphicon-download-alt"></span>
				<a href="{{ URL::route('patient.index')}}">Reception</a>
				<!-- <a href="javascript:void(0);" onclick="pageloader('{{ URL::route("patient.index")}}')">Reception</a> -->
			</div>
		</li>
		<li>
			<div class="main-menu {{$active[2]}}">
				<span class="glyphicon glyphicon-filter"></span>
				Tests
			</div>
		</li>
		<li>
			<div class="main-menu {{$active[3]}}">
				<span class="glyphicon glyphicon-wrench"></span>
				Lab Configuration
			</div>
			<div class="sub-menu {{$active[3]}}">
				<ul class="sub-menu-items">
					<li>
						<div>
							<span class="glyphicon glyphicon-tag"></span>
							<a href="{{ URL::route("user.index")}}">User Accounts</a>
							<!-- <a href="javascript:void(0);" onclick="pageloader('{{ URL::route("user.index")}}')">User Accounts</a> -->
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
				<span class="glyphicon glyphicon-cog"></span>
				Test Catalog
			</div>
			<div class="sub-menu {{$active[4]}}">
				<ul class="sub-menu-items">
					<li>
						<div>
							<span class="glyphicon glyphicon-tag"></span>
							<a href="{{ URL::route("testcategory.index")}}">Lab Sections</a>
							<!-- <a href="javascript:void(0);" onclick="pageloader('{{ URL::route("testcategory.index")}}')">Lab Sections</a> -->
						</div>
					</li>
					<li>
						<div>
							<span class="glyphicon glyphicon-tag"></span>
							<a href="{{ URL::route("testtype.index")}}">Test Types</a>
							<!-- <a href="javascript:void(0);" onclick="pageloader('{{ URL::route("testtype.index")}}')">Test Types</a> -->
						</div>
					</li>
					<li>
						<div>
							<span class="glyphicon glyphicon-tag"></span>
							<a href="{{ URL::route("measure.index")}}" >Measures</a>
							<!-- <a href="javascript:void(0);" onclick="pageloader('{{ URL::route("measure.index")}}')">Measures</a> -->
						</div>
					</li>
					<li>
						<div>
							<span class="glyphicon glyphicon-tag"></span>
							<a href="{{ URL::route("specimentype.index")}}">Specimen Types</a>
							<!-- <a href="javascript:void(0);" onclick="pageloader('{{ URL::route("specimentype.index")}}')">Specimen Types</a> -->
						</div>
					</li>
				</ul>
			</div>
		</li>
		<li>
			<div class="main-menu {{$active[5]}}">
				<span class="glyphicon glyphicon-stats"></span>
				Reports
			</div>
			<div class="sub-menu {{$active[5]}}">
				<div class="sub-menu-title">Daily Reports</div>
				<ul class="sub-menu-items">
					<li>
						<div>
							<span class="glyphicon glyphicon-tag"></span>
							Patient Report
						</div>
					</li>
					<li>
						<div>
							<span class="glyphicon glyphicon-tag"></span>
							Daily Log
						</div>
					</li>
				</ul>
				<div class="sub-menu-title">Aggregate Reports</div>
				<ul class="sub-menu-items">
					<li>
						<div>
							<span class="glyphicon glyphicon-tag"></span>
							Prevalence Rates
						</div>
					</li>
					<li>
						<div>
							<span class="glyphicon glyphicon-tag"></span>
							Counts
						</div>
					</li>
					<li>
						<div>
							<span class="glyphicon glyphicon-tag"></span>
							Turnaround Time
						</div>
					</li>
					<li>
						<div>
							<span class="glyphicon glyphicon-tag"></span>
							Infection Report
						</div>
					</li>
				</ul>
			</div>
		</li>
		<li>
			<div class="main-menu {{$active[6]}}">
				<span class="glyphicon glyphicon-briefcase"></span>
				Inventory
			</div>
		</li>
	</ul>
@show
