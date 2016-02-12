@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="card">
  		<div class="card-header">
    		{!! trans('general-terms.daily-tests') !!}
  		</div>
  		<div class="card-block">
    		<div id="chart" style="height: 300px"></div>
  		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
				    <i class="fa fa-book"></i> {!! trans('general-terms.latest-tests') !!} 
				    <span>
					    <a class="btn btn-sm btn-belize-hole" href="{!! url("drug/create") !!}" >
							<i class="fa fa-plus-circle"></i>
							{!! trans('action.new').' '.trans_choice('menu.test', 1) !!}
						</a>
						<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
							<i class="fa fa-step-backward"></i>
							{!! trans('action.back') !!}
						</a>				
					</span>
				</div>
			  	<div class="card-block">	  		
					@if (Session::has('message'))
						<div class="alert alert-info">{!! Session::get('message') !!}</div>
					@endif
				 	<table class="table table-bordered table-sm search-table" style="font-size:13px;">
						<thead>
		                    <tr>
		                        <th>{!! trans('specific-terms.date-ordered') !!}</th>
		                        <th>{!! trans('specific-terms.patient-no') !!}</th>
		                        <th>{!! trans('specific-terms.visit-no') !!}</th>
		                        <th class="col-md-2">{!! trans('specific-terms.patient-name') !!}</th>
		                        <th class="col-md-1">{!! trans('specific-terms.specimen-id') !!}</th>
		                        <th>{!! trans_choice('menu.test',1) !!}</th>
		                        <th>{!! trans('specific-terms.visit-type') !!}</th>
		                        <th>{!! trans('specific-terms.test-status') !!}</th>
		                        <th class="col-md-3">{!! trans('specific-terms.test-status') !!}</th>
		                    </tr>
		                </thead>
		                <tbody>
		                @foreach($tests as $key => $test)
		                    <tr @if(session()->has('active_test'))
		                        {!! (session('active_test') == $test->id)?"class='warning'":"" !!}
		                    @endif
		                    >
		                        <td>{!! date('d-m-Y H:i', strtotime($test->time_created));!!}</td>  <!--Date Ordered-->
		                        <td>{!! empty($test->visit->patient->external_patient_number)?
		                                $test->visit->patient->patient_number:
		                                $test->visit->patient->external_patient_number
		                            !!}</td> <!--Patient Number -->
		                        <td>{!! empty($test->visit->visit_number)?
		                                $test->visit->id:
		                                $test->visit->visit_number
		                            !!}</td> <!--Visit Number -->
		                        <td>{!! $test->visit->patient->name.' ('.($test->visit->patient->getGender(true)).',
		                            '.$test->visit->patient->getAge('Y'). ')'!!}</td> <!--Patient Name -->
		                        <td>{!! $test->getSpecimenId() !!}</td> <!--Specimen ID -->
		                        <td>{!! $test->testType->name !!}</td> <!--Test-->
		                        <td>{!! $test->visit->visit_type !!}</td> <!--Visit Type -->
		                        <td id="test-status-{!!$test->id!!}" class='test-status'>
		                            <!-- Test Statuses -->
		                            <div class="container-fluid">
		                            
		                                <div class="row">

		                                    <div class="col-md-12">
		                                        @if($test->isNotReceived())
		                                            @if(!$test->isPaid())
		                                                <span class='label label-default'>
		                                                    {!! trans('specific-terms.test-not-paid') !!}</span>
		                                            @else
		                                            <span class='label label-default'>
		                                                {!! trans('specific-terms.test-not-received') !!}</span>
		                                            @endif
		                                        @elseif($test->isPending())
		                                            <span class='label label-info'>
		                                                {!! trans('specific-terms.test-pending') !!}</span>
		                                        @elseif($test->isStarted())
		                                            <span class='label label-warning'>
		                                                {!! trans('specific-terms.test-started') !!}</span>
		                                        @elseif($test->isCompleted())
		                                            <span class='label label-primary'>
		                                                {!! trans('specific-terms.test-completed') !!}</span>
		                                        @elseif($test->isVerified())
		                                            <span class='label label-success'>
		                                                {!! trans('specific-terms.test-verified') !!}</span>
		                                        @endif
		                                    </div>
		    
		                                    </div>
		                                <div class="row">
		                                    <div class="col-md-12">
		                                        <!-- Specimen statuses -->
		                                        @if($test->specimen->isNotCollected())
		                                         @if(($test->isPaid()))
		                                            <span class='label label-default'>
		                                                {!! trans('specific-terms.specimen-not-collected') !!}</span>
		                                            @endif
		                                        @elseif($test->specimen->isReferred())
		                                            <span class='label label-primary'>
		                                                {!! trans('messages.specimen-referred-label') !!}
		                                                @if($test->specimen->referral->status == App\Models\Referral::REFERRED_IN)
		                                                    {!! trans("messages.in") !!}
		                                                @elseif($test->specimen->referral->status == App\Models\Referral::REFERRED_OUT)
		                                                    {!! trans("messages.out") !!}
		                                                @endif
		                                            </span>
		                                        @elseif($test->specimen->isAccepted())
		                                            <span class='label label-success'>
		                                                {!! trans('specific-terms.specimen-accepted') !!}</span>
		                                        @elseif($test->specimen->isRejected())
		                                            <span class='label label-danger'>
		                                                {!! trans('specific-terms.specimen-rejected') !!}</span>
		                                        @endif
		                                    </div>
		                                </div>
		                            </div>
		                        </td>
		                        <!-- ACTION BUTTONS -->
		                        <td>
		                            <a class="btn btn-sm btn-success"
		                                href="{!! route('test.viewDetails', $test->id) !!}"
		                                id="view-details-{!!$test->id!!}-link" 
		                                title="{!!trans('action.view')!!}">
		                                <i class="fa fa-folder-open"></i>
		                                {!! trans('action.view') !!}
		                            </a>
		                            
		                        @if ($test->isNotReceived()) 
		                            @if(Auth::user()->can('receive_external_test') && $test->isPaid())
		                                <a class="btn btn-sm btn-default receive-test" href="javascript:void(0)"
		                                    data-test-id="{!!$test->id!!}" data-specimen-id="{!!$test->specimen->id!!}"
		                                    title="{!!trans('action.receive-test')!!}">
		                                    <i class="fa fa-cloud-download"></i>
		                                    {!! trans('action.receive-test') !!}
		                                </a>
		                            @endif
		                        @elseif ($test->specimen->isNotCollected())
		                            @if(Auth::user()->can('accept_test_specimen'))
		                                <a class="btn btn-sm btn-info accept-specimen" href="javascript:void(0)"
		                                    data-test-id="{!!$test->id!!}" data-specimen-id="{!!$test->specimen->id!!}"
		                                    title="{!!trans('action.accept-specimen')!!}"
		                                    data-url="{!! route('test.acceptSpecimen') !!}">
		                                    <i class="fa fa-check-circle"></i>
		                                    {!! trans('action.accept-specimen') !!}
		                                </a>
		                            @endif
		                            @if(count($test->testType->specimenTypes) > 1 && Auth::user()->can('change_test_specimen'))
		                                <!-- 
		                                    If this test can be done using more than 1 specimen type,
		                                    allow the user to change to any of the other eligible ones.
		                                -->
		                                <a class="btn btn-sm btn-danger change-specimen" href="#change-specimen-modal"
		                                    data-toggle="modal" data-url="{!! route('test.changeSpecimenType') !!}"
		                                    data-test-id="{!!$test->id!!}" data-target="#change-specimen-modal"
		                                    title="{!!trans('action.change-specimen')!!}">
		                                    <i class="fa fa-refresh"></i>
		                                    {!! trans('action.change-specimen') !!}
		                                </a>
		                            @endif
		                        @endif
		                        @if ($test->specimen->isAccepted() && !($test->isVerified()))
		                            @if(Auth::user()->can('reject_test_specimen') && !($test->specimen->isReferred()))
		                                <a class="btn btn-sm btn-danger" id="reject-{!!$test->id!!}-link"
		                                    href="{!!route('test.reject', array($test->specimen_id))!!}"
		                                    title="{!!trans('action.reject')!!}">
		                                    <i class="fa fa-stop-circle"></i>
		                                    {!! trans('action.reject') !!}
		                                </a>
		                            @endif
		                            @if ($test->isPending())
		                                @if(Auth::user()->can('start_test'))
		                                    <a class="btn btn-sm btn-warning start-test" href="javascript:void(0)"
		                                        data-test-id="{!!$test->id!!}" data-url="{!! route('test.start') !!}"
		                                        title="{!!trans('action.start-test')!!}">
		                                        <i class="fa fa-play-circle"></i>
		                                        {!! trans('action.start-test') !!}
		                                    </a>
		                                @endif
		                                @if(Auth::user()->can('refer_specimens') && !($test->isExternal()) && !($test->specimen->isReferred()))
		                                    <a class="btn btn-sm btn-info" href="{!! route('test.refer', array($test->specimen_id)) !!}">
		                                        <i class="fa fa-send"></i>
		                                        {!! trans('action.refer-sample') !!}
		                                    </a>
		                                @endif
		                            @elseif ($test->isStarted())
		                                @if(Auth::user()->can('enter_test_results'))
		                                    <a class="btn btn-sm btn-info" id="enter-results-{!!$test->id!!}-link"
		                                        href="{!! route('test.enterResults', array($test->id)) !!}"
		                                        title="{!!trans('action.enter-results')!!}">
		                                        <i class="fa fa-pencil-square"></i>
		                                        {!! trans('action.enter-results') !!}
		                                    </a>
		                                @endif
		                            @elseif ($test->isCompleted())
		                                @if(Auth::user()->can('edit_test_results'))
		                                    <a class="btn btn-sm btn-info" id="edit-{!!$test->id!!}-link"
		                                        href="{!! route('test.edit', array($test->id)) !!}"
		                                        title="{!!trans('action.edit-results')!!}">
		                                        <i class="fa fa-file-text"></i>
		                                        {!! trans('action.edit-results') !!}
		                                    </a>
		                                @endif
		                                @if(Auth::user()->can('verify_test_results') && Auth::user()->id != $test->tested_by)
		                                    <a class="btn btn-sm btn-success" id="verify-{!!$test->id!!}-link"
		                                        href="{!! route('test.viewDetails', array($test->id)) !!}"
		                                        title="{!!trans('action.verify')!!}">
		                                        <i class="fa fa-check-square"></i>
		                                        {!! trans('action.verify') !!}
		                                    </a>
		                                @endif

		                                <div class="">
		                                    <a class="btn btn-sm btn-primary barcode-button" href="{!! url("specimen/" . $test->getSpecimenId() . "/barcode") !!}">
		                                        <i class="fa fa-barcode"></i>
		                                        {!! trans('general-terms.barcode') !!}
		                                    </a>
		                                </div> <!-- /. barcode-button -->
		                            @endif
		                        @endif
		                        </td>
		                    </tr>
		                @endforeach
		                </tbody>
					</table>
				</div>
			</div>
	  	</div>
	</div>
</div>
<!-- Highcharts scripts --><script src="{{ asset('js/jquery.min.js') }}"></script>
	
<script src="{!! asset('js/highcharts.js') !!}"></script>
<script src="{!! asset('js/exporting.js') !!}"></script>
<script src="{!! asset('js/drilldown.js') !!}"></script>
<script type="text/javascript">
    $(function () {
        var chart = new Highcharts.Chart(<?php echo $chart ?>);
    });
</script>
@endsection