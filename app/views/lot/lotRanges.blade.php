@section("controlEdit")
@foreach($controlMeasures as $key => $controlMeasure)
<div class="row measure-section">
<div class="col-md-11 measure">
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('measures[name]['.$controlMeasure->id.']', Lang::choice('messages.name',1)) }}
           <input class="form-control" name="measures[{{$controlMeasure->id}}][name]" value="{{$controlMeasure->name}}" type="text">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('measures[control_measure_type_id]['.$controlMeasure->id.']', trans('messages.measure-type')) }}
                <select class="form-control measuretype-input-trigger {{$controlMeasure->id}}" 
                    data-measure-id="{{$controlMeasure->id}}" 
                    name="measures[{{$controlMeasure->id}}][control_measure_type_id]" 
                    id="measure_type_id">
                    <option value="0"></option>
                    @foreach ($measureTypes as $measureType)
                        <option value="{{$measureType->id}}"
                        {{($measureType->id == $controlMeasure->control_measure_type_id) ? 'selected="selected"' : '' }}>{{$measureType->name}}</option>
                    @endforeach
                </select>
        </div>
    </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('new-measures[][expected]', trans('messages.expected-value')) }}
                        <input class="form-control" name="measures[{{$controlMeasure->id}}][expected]" value="{{$controlMeasure->expected_result}}" type="text">
                    </div>
                </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('measures[unit]['.$controlMeasure->id.']', trans('messages.unit')) }}
            <input class="form-control" name="measures[{{$controlMeasure->id}}][unit]" value="{{$controlMeasure->unit}}" type="text">
        </div>
        <input type="hidden" name="measures[{{$controlMeasure->id}}][control-measure-id]" value="{{$controlMeasure->id}}">
    </div>
    <div class="col-md-12">
        <div class="form-group control-measure-container">
            <label for="measurerange">{{trans('messages.measure-range-values')}}</label>
            <div class="form-pane panel panel-default">
                <div class="panel-body">
                    @if ($controlMeasure->control_measure_type_id == 1)
                    <div class="numericInputLoader">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{trans('messages.lower-range')}} </label>
                            <input class="form-control" name="measures[{{$controlMeasure->id}}][rangemin]" type="text">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> {{trans('messages.upper-range')}} </label>
                            <input class="form-control" name="measures[{{$controlMeasure->id}}][rangemax]" type="text">
                        </div>
                    </div>
                    </div><!-- numericInput -->
                    @elseif ($controlMeasure->control_measure_type_id == 2)
                    <div class="col-md-3">
                        <div class="form-group alphanumericInputLoader" data-new-measure='1'>
                            <div class="form-group">
                            <label> {{trans('messages.value')}} </label>
                            <input class="form-control" name="measures[1][val]" type="text">
                            </div>
                        </div>
                        <div class="measurevalue"></div>
                        <div class="col-md-12 actions-row">
                            <a class="btn btn-default add-another-control-range" href="javascript:void(0);"data-measure-id="0" data-new-measure-id="1">
                            <span class="glyphicon glyphicon-plus-sign"></span>{{trans('messages.add-new-measure-range')}}</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-1">
    <button class="col-md-12 close" aria-hidden="true" type="button" 
        title="{{trans('messages.delete')}}">X</button>
</div>
</div>
@endforeach
@show