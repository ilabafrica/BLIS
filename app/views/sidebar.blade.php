@section("sidebar")
	<ul class="nav nav-sidebar">
		<li>
			<div class="main-menu active">
				<span class="glyphicon glyphicon-home"></span>
				<a href="{{ URL::route('user.home')}}" title="Home">Home</a>
			</div>
		</li>
		<li>
			<div class="main-menu">
				<span class="glyphicon glyphicon-download-alt"></span>
				<a href="javascript:void(0);" onclick="pageloader('{{ URL::route("patient.index")}}')">Reception</a>
			</div>
		</li>
		<li>
			<div class="main-menu">
				<span class="glyphicon glyphicon-filter"></span>
				Tests
			</div>
		</li>
		<li>
			<div class="main-menu">
				<span class="glyphicon glyphicon-wrench"></span>
				Lab Configuration
			</div>
			<div class="sub-menu">
				<ul class="sub-menu-items">
					<li>
						<div>
							<span class="glyphicon glyphicon-tag"></span>
							<a href="javascript:void(0);" onclick="pageloader('{{ URL::route("user.index")}}')">User Accounts</a>
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
			<div class="main-menu">
				<span class="glyphicon glyphicon-cog"></span>
				Test Catalog
			</div>
			<div class="sub-menu">
				<ul class="sub-menu-items">
					<li>
						<div>
							<span class="glyphicon glyphicon-tag"></span>
							<a href="javascript:void(0);" onclick="pageloader('{{ URL::route("testcategory.index")}}')">Lab Sections</a>
						</div>
					</li>
					<li>
						<div>
							<span class="glyphicon glyphicon-tag"></span>
							<a href="javascript:void(0);" onclick="pageloader('{{ URL::route("testtype.index")}}')">Test Types</a>
						</div>
					</li>
					<li>
						<div>
							<span class="glyphicon glyphicon-tag"></span>
							<a href="javascript:void(0);" onclick="pageloader('{{ URL::route("specimentype.index")}}')">Specimen Types</a>
						</div>
					</li>
				</ul>
			</div>
		</li>
		<li>
			<div class="main-menu">
				<span class="glyphicon glyphicon-stats"></span>
				Reports
			</div>
			<div class="sub-menu">
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
			<div class="main-menu">
				<span class="glyphicon glyphicon-briefcase"></span>
				Inventory
			</div>
		</li>
	</ul>
@show
