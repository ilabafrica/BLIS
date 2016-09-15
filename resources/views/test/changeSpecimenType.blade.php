<div class="display-details">
    {{ Form::hidden('specimen_id', $test->specimen_id) }}
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <strong>{{ trans_choice('messages.test-type',1) }}</strong>
            </div>
            <div class="col-md-8">
                {{$test->testType->name}}
            </div>
        </div><br />
        <div class="row">
            <div class="col-md-4">
                <strong>{{trans('messages.specimen-number')}}</strong>
            </div>
            <div class="col-md-8">
                {{$test->specimen_id}}
            </div>
        </div><br />
        <div class="row">
            <div class="col-md-4">
                <strong>{{trans('messages.specimen-status')}}</strong>
            </div>
            <div class="col-md-8">
                {{trans('messages.'.$test->specimen->specimenStatus->name)}}
            </div>
        </div><br />
        <div class="row">
            <div class="col-md-4">
                <strong>{{ trans_choice('messages.specimen-type',2) }}</strong>
            </div>
            <div class="col-md-8">
                {{ Form::select('specimen_type', $test->testType->specimenTypes->lists('name','id'),
                    array($test->specimen->specimen_type_id), array('class' => 'form-control')) }}</p>
            </div>
        </div>
    </div>
</div>