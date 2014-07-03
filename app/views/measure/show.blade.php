	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">Home</a></li>
		  <li><a href="javascript:void(0);" onclick="pageloader('{{ URL::to('measure') }}')">Measure</a></li>
		  <li class="active">Measure Details</li>
		</ol>
	</div>
	<div class="panel panel-primary patient-create">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			Measure Details
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="javascript:void(0);" onclick="pageloader('{{ URL::to('measure/'. $measure->id .'/edit') }}')">
					<span class="glyphicon glyphicon-edit"></span>
					Edit
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="row showmeasure">
					<div class="col-md-6">
					<div class="view">
						<div class="col-md-6"><strong>Name</strong></div>
						<div class="col-md-6">{{ $measure->name }}</div>
					</div>
					<div class="view-striped">
						<div class="col-md-6"><strong>Description</strong></div>
						<div class="col-md-6">{{ $measure->description }}</div>
					</div>
					<div class="view">
						<div class="col-md-6"><strong>Measure Type</strong></div>
						<div class="col-md-6">{{ $measure->measureType->name }}</div>
					</div>
					<?php if ($measure->measureType->id == 2) { ?>
					<div class="view-striped">
						<div class="col-md-6"><strong>Measure Range</strong></div>
						<div class="col-md-6">{{ $measure->measure_range }}</div>
					</div>
					<?php } ?>				
				</div>
				<div class="col-md-6">
				</div>
				<?php if ($measure->measureType->id == 1) { ?>

				<div class="col-md-12">
				<br>
					<?php $gender = ['Male', 'Female', 'Both']; ?>
					<div class="view">
						<div class="col-md-4"><strong>Age Range</strong></div>
						<div class="col-md-4"><strong>Gender</strong></div>
						<div class="col-md-4"><strong>Measure Range</strong></div>
					</div>
					<div class="view-striped">
						<div class="col-md-2">Min</div><div class="col-md-2">Max</div>
						<div class="col-md-4">Gender</div>
						<div class="col-md-2">Lower Limit</div><div class="col-md-2">Upper Limit</div>
					</div>
					<?php $cnt = 0;?>
					@foreach($measure->measureRanges as $range)
					<div class='{{ ($cnt==0)?"view":"view-striped"}}'>
						<div class="col-md-2">{{ $range->age_min }}</div>
						<div class="col-md-2">{{ $range->age_max }}</div>
						<div class="col-md-4">{{ $gender[$range->sex - 1] }}</div>
						<div class="col-md-2">{{ $range->range_lower }}</div>
						<div class="col-md-2">{{ $range->range_upper }}</div>
					</div>
					<?php $cnt == 0? $cnt++ : $cnt--;?>
					@endforeach
				</div>
				<?php } ?>
			</div>			
		</div>
	</div>