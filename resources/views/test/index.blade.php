@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li class="active"><i class="fa fa-user-md"></i> {!! trans_choice('menu.test', 2) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
				    <i class="fa fa-book"></i> {!! trans_choice('menu.test', 2) !!} 
				    <span>
					    <a class="btn btn-sm btn-belize-hole" href="javascript:void(0)"
                                data-toggle="modal" data-target="#new-test-modal">
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
					@if($errors->all())
		            <div class="alert alert-danger alert-dismissible" role="alert">
		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
		            </div>
		            @endif
					<div class='col-md-12' style="padding-bottom:5px;">
				        {!! Form::open(array('route' => array('test.index'))) !!}
				            <div class='row'>
					            <div class='col-md-12'>
					                <div class='col-md-3'>
					                    {!! Form::label('date_from', trans('general-terms.from').':', array('class' => 'col-sm-3 form-control-label')) !!}
					                    <div class='col-md-9 input-group date datepicker'>
					                        {!! Form::text('date_from', Input::get('date_from'), array('class' => 'form-control')) !!}
					                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					                    </div>
					                </div>
					                <div class='col-md-3'>
					                    {!! Form::label('date_to', trans('general-terms.to').':', array('class' => 'col-sm-2 form-control-label')) !!}
					                    <div class='col-md-10 input-group date datepicker'>
					                        {!! Form::text('date_to', Input::get('date_to'), array('class' => 'form-control')) !!}
					                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					                    </div>
					                </div>
					                <div class='col-md-3'>
					                    {!! Form::label('test_status', trans('specific-terms.test-status').':', array('class' => 'col-sm-3 form-control-label')) !!}
					                    <div class='col-md-9'>
					                        {!! Form::select('test_status', $statuses, Input::get('test_status'), array('class' => 'form-control')) !!}
					                    </div>
					                </div>
					                <div class='col-md-2'>
				                        {!! Form::text('search', Input::get('search'), array('class' => 'form-control', 'placeholder' => 'Keyword')) !!}
					                </div>
					                <div class='col-md-1'>
										{!! Form::button("<i class='fa fa-search'></i> ".trans('general-terms.search'), array('class' => 'btn btn-sm btn-primary', 'type' => 'submit')) !!}									
					                </div>
				                </div>
				            </div>
				        {!! Form::close() !!}
				    </div>
				 	<table class="table table-bordered table-sm search-table">
						<thead>
							<tr>
								<th>{!! trans('specific-terms.date-ordered') !!}</th>
		                        <th>{!! trans('specific-terms.test-id') !!}</th>
		                        <th>{!! trans('specific-terms.visit-no') !!}</th>
		                        <th class="col-md-2">{!! trans('general-terms.name') !!}</th>
		                        <th class="col-md-1">{!! trans('specific-terms.specimen-id') !!}</th>
		                        <th>{!! trans_choice('menu.test', 1) !!}</th>
		                        <th>{!! trans('specific-terms.visit-type') !!}</th>
		                        <th>{!! trans('specific-terms.test-status') !!}</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						@foreach($tests as $test)
							<tr @if(session()->has('active_test'))
				                    {!! (session('active_test') == $value->id)?"class='warning'":"" !!}
				                @endif
				                >
								<td>{!! Carbon::parse($test->time_created)->toDateTimeString() !!}</td>  <!--Date Ordered-->
		                        <td>{!! empty($test->visit->patient->external_patient_number)?$test->visit->patient->patient_number:$test->visit->patient->external_patient_number !!}</td> <!--Patient Number -->
		                        <td>{!! empty($test->visit->visit_number)?$test->visit->id:$test->visit->visit_number !!}</td> <!--Visit Number -->
		                        <td>{!! $test->visit->patient->name.' ('.($test->visit->patient->getGender(true)).', '.Carbon::parse($test->visit->patient->dob)->age. ')' !!}</td> <!--Patient Name -->
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
		                                                <span class='label label-silver'>
		                                                    {!! trans('specific-terms.not-paid') !!}</span>
		                                            @else
		                                            <span class='label label-asbestos'>
		                                                {!! trans('specific-terms.not-received') !!}</span>
		                                            @endif
		                                        @elseif($test->isPending())
		                                            <span class='label label-pumpkin'>
		                                                {!! trans('specific-terms.pending') !!}</span>
		                                        @elseif($test->isStarted())
		                                            <span class='label label-sub-flower'>
		                                                {!! trans('specific-terms.started') !!}</span>
		                                        @elseif($test->isCompleted())
		                                            <span class='label label-nephritis'>
		                                                {!! trans('specific-terms.completed') !!}</span>
		                                        @elseif($test->isVerified())
		                                            <span class='label label-wet-asphalt'>
		                                                {!! trans('specific-terms.verified') !!}</span>
		                                        @endif
		                                    </div>
		    
		                                    </div>
		                                <div class="row">
		                                    <div class="col-md-12">
		                                        <!-- Specimen statuses -->
		                                        @if($test->specimen->isNotCollected())
		                                         @if(($test->isPaid()))
		                                            <span class='label label-silver'>
		                                                {!! trans('specific-terms.specimen-not-collected') !!}</span>
		                                            @endif
		                                        @elseif($test->specimen->isReferred())
		                                            <span class='label label-asbestos'>
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
		                                <a class="btn btn-sm btn-green-sea receive-test" href="javascript:void(0)"
		                                    data-test-id="{!!$test->id!!}" data-specimen-id="{!!$test->specimen->id!!}"
		                                    title="{!!trans('action.receive-test')!!}">
		                                    <i class="fa fa-cloud-download"></i>
		                                    {!! trans('action.receive-test') !!}
		                                </a>
		                            @endif
		                        @elseif ($test->specimen->isNotCollected())
		                            @if(Auth::user()->can('accept_test_specimen'))
		                                <a class="btn btn-sm btn-wisteria accept-specimen" href="javascript:void(0)"
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
		                                <a class="btn btn-sm btn-pumpkin change-specimen" href="#change-specimen-modal"
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
		                                <a class="btn btn-sm btn-alizarin" id="reject-{!!$test->id!!}-link"
		                                    href="{!!route('test.reject', array($test->specimen_id))!!}"
		                                    title="{!!trans('action.reject')!!}">
		                                    <i class="fa fa-stop-circle"></i>
		                                    {!! trans('action.reject') !!}
		                                </a>
		                            @endif
		                            @if ($test->isPending())
		                                @if(Auth::user()->can('start_test'))
		                                    <a class="btn btn-sm btn-sub-flower start-test" href="javascript:void(0)"
		                                        data-test-id="{!!$test->id!!}" data-url="{!! route('test.start') !!}"
		                                        title="{!!trans('action.start-test')!!}">
		                                        <i class="fa fa-play-circle"></i>
		                                        {!! trans('action.start-test') !!}
		                                    </a>
		                                @endif
		                                @if(Auth::user()->can('refer_specimens') && !($test->isExternal()) && !($test->specimen->isReferred()))
		                                    <a class="btn btn-sm btn-silver" href="{!! route('test.refer', array($test->specimen_id)) !!}">
		                                        <i class="fa fa-send"></i>
		                                        {!! trans('action.refer-sample') !!}
		                                    </a>
		                                @endif
		                            @elseif ($test->isStarted())
		                                @if(Auth::user()->can('enter_test_results'))
		                                    <a class="btn btn-sm btn-peter-river" id="enter-results-{!!$test->id!!}-link"
		                                        href="{!! route('test.enterResults', array($test->id)) !!}"
		                                        title="{!!trans('action.enter-results')!!}">
		                                        <i class="fa fa-pencil-square"></i>
		                                        {!! trans('action.enter-results') !!}
		                                    </a>
		                                @endif
		                            @elseif ($test->isCompleted())
		                                @if(Auth::user()->can('edit_test_results'))
		                                    <a class="btn btn-sm btn-peter-river" id="edit-{!!$test->id!!}-link"
		                                        href="{!! route('test.edit', array($test->id)) !!}"
		                                        title="{!!trans('action.edit-results')!!}">
		                                        <i class="fa fa-file-text"></i>
		                                        {!! trans('action.edit-results') !!}
		                                    </a>
		                                @endif
		                                @if(Auth::user()->can('verify_test_results') && Auth::user()->id != $test->tested_by)
		                                    <a class="btn btn-sm btn-midnight-blue" id="verify-{!!$test->id!!}-link"
		                                        href="{!! route('test.viewDetails', array($test->id)) !!}"
		                                        title="{!!trans('action.verify')!!}">
		                                        <i class="fa fa-check-square"></i>
		                                        {!! trans('action.verify') !!}
		                                    </a>
		                                @endif

		                                <div class="">
		                                    <a class="btn btn-sm btn-asbestos barcode-button" href="{!! url("specimen/" . $test->getSpecimenId() . "/barcode") !!}">
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
	{!! session(['SOURCE_URL' => URL::full()]) !!}
</div>

<!-- MODALS -->
<div class="modal fade" id="new-test-modal">
  <div class="modal-dialog">
    <div class="modal-content">
    {!! Form::open(array('route' => 'test.create')) !!}
      <input type="hidden" id="patient_id" name="patient_id" value="0" />
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">{!!trans('messages.close')!!}</span>
        </button>
        <h4 class="modal-title">{!! trans('action.new').' '.trans_choice('menu.test', 1) !!}</h4>
      </div>
      <div class="modal-body">
        <p>{!! trans('specific-terms.select-patient') !!}</p>
        <div class="row">
          <div class="col-lg-12">
            <div class="input-group">
              <input type="text" class="form-control search-text" 
                placeholder="{!! trans('general-terms.keyword') !!}">
	              	<span class="input-group-btn">
	                	<button class="btn btn-sm btn-wet-asphalt search-patient" type="button">{!! trans('action.find') !!}</button>
	              	</span>
            </div><!-- /input-group -->
            <div class="patient-search-result form-group">
                <table class="table table-condensed table-striped table-bordered table-hover hide">
                  <thead>
                    <th> </th>
                    <th>{!! trans('action.patient-id') !!}</th>
                    <th>{!! trans('general-terms.name') !!}</th>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
            </div>
          </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->          </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-silver" data-dismiss="modal">
            <i class="fa fa-times-circle"></i> {!! trans('action.close') !!}
        </button>
        <button type="button" class="btn btn-sm btn-peter-river next" onclick="submit();" disabled>
            <i class="fa fa-chevron-circle-right"></i> {!! trans('action.next') !!}
        </button>
      </div>
    {!! Form::close() !!}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="change-specimen-modal">
  <div class="modal-dialog">
    <div class="modal-content">
    {!! Form::open(array('route' => 'test.updateSpecimenType')) !!}
    	<!-- CSRF Token -->
        <input type="hidden" name="_token" value="{!! csrf_token() !!}}" />
        <!-- ./ csrf token -->
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal">
            	<span aria-hidden="true">&times;</span>
            	<span class="sr-only">{!!trans('messages.close')!!}</span>
        	</button>
        	<h4 class="modal-title">
            <span class="glyphicon glyphicon-transfer"></span>
            {!!trans('messages.change-specimen-title')!!}</h4>
      	</div>
      	<div class="modal-body">
      	</div>
      	<div class="modal-footer">
        	{!! Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'),
            array('class' => 'btn btn-primary', 'data-dismiss' => 'modal', 'onclick' => 'submit()')) !!}
        	<button type="button" class="btn btn-default" data-dismiss="modal">
            	{!!trans('messages.close')!!}</button>
      	</div>
    	{!! Form::close() !!}
    	</div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal /#change-specimen-modal-->

<!-- OTHER UI COMPONENTS -->
<div class="hidden pending-test-not-collected-specimen">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <span class='label label-info'>
                    {!!trans('messages.pending')!!}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <span class='label label-default'>
                    {!!trans('messages.specimen-not-collected-label')!!}</span>                
            </div>
        </div>
    </div>
</div> <!-- /. pending-test-not-collected-specimen -->

<div class="hidden pending-test-accepted-specimen">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <span class='label label-info'>
                    {!!trans('messages.pending')!!}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <span class='label label-success'>
                    {!!trans('messages.specimen-accepted-label')!!}</span>
            </div>
        </div>
    </div>
</div> <!-- /. pending-test-accepted-specimen -->

<div class="hidden started-test-accepted-specimen">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <span class='label label-warning'>
                    {!!trans('messages.started')!!}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <span class='label label-success'>
                    {!!trans('messages.specimen-accepted-label')!!}</span>
            </div>
        </div>
    </div>
</div> <!-- /. started-test-accepted-specimen -->

<div class="hidden accept-button">
    <a class="btn btn-sm btn-info accept-specimen" href="javascript:void(0)"
        title="{!!trans('messages.accept-specimen-title')!!}"
        data-url="{!! route('test.acceptSpecimen') !!}">
        <span class="glyphicon glyphicon-thumbs-up"></span>
        {!!trans('messages.accept-specimen')!!}
    </a>
</div> <!-- /. accept-button -->

<div class="hidden reject-start-buttons">
    <a class="btn btn-sm btn-danger reject-specimen" href="#" title="{!!trans('messages.reject-title')!!}">
        <span class="glyphicon glyphicon-thumbs-down"></span>
        {!!trans('messages.reject')!!}</a>
    <a class="btn btn-sm btn-warning start-test" href="javascript:void(0)"
        data-url="{!! route('test.start') !!}" title="{!!trans('messages.start-test-title')!!}">
        <span class="glyphicon glyphicon-play"></span>
        {!!trans('messages.start-test')!!}</a>
</div> <!-- /. reject-start-buttons -->

<div class="hidden enter-result-buttons">
    <a class="btn btn-sm btn-info enter-result">
        <span class="glyphicon glyphicon-pencil"></span>
        {!!trans('messages.enter-results')!!}</a>
</div> <!-- /. enter-result-buttons -->

<div class="hidden start-refer-button">
    <a class="btn btn-sm btn-info refer-button" href="#">
        <span class="glyphicon glyphicon-edit"></span>
        {!!trans('messages.refer-sample')!!}
    </a>
</div> <!-- /. referral-button -->

@endsection