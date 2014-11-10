<div class="display-details">
    {{ Form::hidden('specimen_id', $test->specimen_id) }}
    <h3><strong>{{trans('messages.test-type')}}</strong>
        {{$test->testType->name}}</h3>
    <p class="view">
        <strong>{{trans('messages.specimen-number')}}</strong>
        {{$test->specimen_id}}
    </p>
    <p class="view-striped">
        <strong>{{trans('messages.specimen-status')}}</strong>
        {{trans('messages.'.$test->specimen->specimenStatus->name)}}
    </p>
    <p class="view-striped">
        <strong>{{trans('messages.specimen-types')}}</strong>
        {{ Form::select('specimen_type', $test->testType->specimenTypes->lists('name','id'),
            array($test->specimen->specimen_type_id), array('class' => 'form-control')) }}</p>
</div>