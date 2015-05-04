@section("edit")
@foreach($control->controlMeasures as $measure)
<div class="row measure-section">
<div class="col-md-11 measure">
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('measures[name]['.$measure->id.']', Lang::choice('messages.name',1)) }}
           <input class="form-control" name="measures[{{$measure->id}}][name]" value="{{$measure->name}}" type="text">
           <input type="hidden" name="measures[{{$measure->id}}][id]" value="{{$measure->id}}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('measures[measure_type_id]['.$measure->id.']', trans('messages.measure-type')) }}
                <select class="form-control measuretype-input-trigger {{$measure->id}}" 
                    data-measure-id="{{$measure->id}}" 
                    name="measures[{{$measure->id}}][measure_type_id]" 
                    id="measure_type_id">
                    <option value="0"></option>
                    @foreach ($measureTypes as $measureType)
                        <option value="{{$measureType->id}}"
                        {{($measureType->id == $measure->control_measure_type_id) ? 'selected="selected"' : '' }}>{{$measureType->name}}</option>
                    @endforeach
                </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('measures[unit]['.$measure->id.']', trans('messages.unit')) }}
            <input class="form-control" name="measures[{{$measure->id}}][unit]" value="{{$measure->unit}}" type="text">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="measurerange">{{trans('messages.measure-range-values')}}</label>
            <div class="form-pane panel panel-default">
                <div class="panel-body">
                <div>
                    <div 
                    class="{{($measure->control_measure_type_id == 1) ? 'col-md-12' : 'col-md-6' }} measurevalue {{$measure->id}}">
                    
                    @if ($measure->control_measure_type_id == 1)
                        <div class="col-md-12">
                            <div class="col-md-3">
                                <span class="col-md-12 range-title">{{trans('messages.measure-range')}}</span>
                            </div>
                        </div>
                        @foreach($measure->controlMeasureRanges as $key=>$controlMeasureRange)
                        <div class="col-md-12 measure-input">
                            <div class="col-md-3">
                                <input class="col-md-4" name="measures[{{$measure->id}}][rangemin][]" type="text"
                                    value="{{ $controlMeasureRange->lower_range }}" 
                                    title="{{trans('messages.lower-range')}}">
                                <span class="col-md-2">:</span>
                                <input class="col-md-4" name="measures[{{$measure->id}}][rangemax][]" type="text"
                                    value="{{ $controlMeasureRange->upper_range }}"
                                    title="{{trans('messages.upper-range')}}">
                                <button class="col-md-2 close" aria-hidden="true" type="button" 
                                title="{{trans('messages.delete')}}">×</button>
                                <input value="{{ $controlMeasureRange->id }}" name="measures[{{$measure->id}}][measurerangeid][]" type="hidden">
                            </div>
                        </div>
                        @endforeach

                    @elseif ($measure->control_measure_type_id == 2 || $measure->control_measure_type_id == 3)
                        <div class="col-md-12">
                            <span class="col-md-5 val-title">{{trans('messages.range')}}</span>
                        </div>
                        @foreach($measure->controlMeasureRanges as $key=>$controlMeasureRange)
                        <div class="col-md-12 measure-input">
                            <div class="col-md-5">
                                <input class="col-md-10 val" value="{{ $controlMeasureRange->alphanumeric }}"
                                name="measures[{{$measure->id}}][val][]" type="text">
                                <button class="col-md-2 close" aria-hidden="true" type="button" 
                                    title="{{trans('messages.delete')}}">×</button>
                                <input value="{{ $controlMeasureRange->id }}" name="measures[{{$measure->id}}][measurerangeid][]" type="hidden">
                            </div>
                        </div>  
                        @endforeach
                    @else
                        <div class="freetextInputLoader">
                            <p class="freetextInput" >{{trans('messages.freetext-measure-config-input-message')}}</p>
                        </div>
                    @endif
                </div>
                <div class="col-md-12 actions-row {{($measure->control_measure_type_id == 4)? 'hidden':''}}">
                    <a class="btn btn-default add-another-range" href="javascript:void(0);" 
                        data-measure-id="{{$measure->id}}">
                    <span class="glyphicon glyphicon-plus-sign"></span>{{trans('messages.add-new-measure-range')}}</a>
                </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-1">
    <button class="col-md-12 close" aria-hidden="true" type="button" 
        title="{{trans('messages.delete')}}">×</button>
</div>
</div>
@endforeach
@show