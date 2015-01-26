@section("edit")
@foreach($testtype->measures as $measure)
<div class="row measure-section">
<div class="col-md-11 measure">
	<div class="col-md-3">
		<div class="form-group">
			{{ Form::label('measures[name]['.$measure->id.']', Lang::choice('messages.name',1)) }}
           <input class="form-control" name="measures[name][{{$measure->id}}]" value="{{$measure->name}}" type="text">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('measures[measure_type_id]['.$measure->id.']', trans('messages.measure-type')) }}
                <select class="form-control measuretype-input-trigger {{$measure->id}}" 
                    data-measure-id="{{$measure->id}}" 
                    name="measures[measure_type_id][{{$measure->id}}]" 
                    id="measure_type_id">
                    <option value="0"></option>
                    @foreach ($measuretype as $type)
                        <option value="{{$type->id}}"
                        {{($type->id == $measure->measure_type_id) ? 'selected="selected"' : '' }}>{{$type->name}}</option>
                    @endforeach
                </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('measures[unit]['.$measure->id.']', trans('messages.unit')) }}
            <input class="form-control" name="measures[unit][{{$measure->id}}]" value="{{$measure->unit}}" type="text">
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
            {{ Form::label('measures[description]['.$measure->id.']', trans('messages.description')) }}
            <textarea class="form-control" value="{{$measure->description}}" rows="2" name="measures[description][{{$measure->id}}]"></textarea>
		</div>
	</div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="measurerange">{{trans('messages.measure-range-values')}}</label>
            <div class="form-pane panel panel-default">
                <div class="panel-body">
                <div>
                    <div 
                    class="{{($measure->measure_type_id == 1) ? 'col-md-12' : 'col-md-6' }} measurevalue {{$measure->id}}">
                    
                    @if ($measure->measure_type_id == 1)
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <span class="col-md-6 range-title">{{trans('messages.measure-age-range')}}</span>
                                <span class="col-md-6 range-title">{{trans('messages.gender')}}</span>
                            </div>
                            <div class="col-md-3">
                                <span class="col-md-12 range-title">{{trans('messages.measure-range')}}</span>
                            </div>
                            <div class="col-md-2">
                                <span class="col-md-12 interpretation-title">{{trans('messages.interpretation')}}
                                </span>
                            </div>
                        </div>     
                        @foreach($measure->measureRanges as $key=>$value)
                        <div class="col-md-12 measure-input">
                            <div class="col-md-4">
                                <input class="col-md-2" name="measures[agemin][{{$measure->id}}][]" type="text" value="{{ $value->age_min }}"
                                    title="{{trans('messages.lower-age-limit')}}">
                                <span class="col-md-1">:</span>
                                <input class="col-md-2" name="measures[agemax][{{$measure->id}}][]" type="text" value="{{ $value->age_max }}"
                                    title="{{trans('messages.upper-age-limit')}}">
                                    <?php $selection = array("","","");?>
                                    <?php $selection[$value->gender] = "selected='selected'"; ?>
                                <span class="col-md-1"></span>
                                <select class="col-md-4" name="measures[gender][{{$measure->id}}][]">
                                    <option value="0" {{ $selection[0] }}>{{trans('messages.male')}}</option>
                                    <option value="1" {{ $selection[1] }}>{{trans('messages.female')}}</option>
                                    <option value="2" {{ $selection[2] }}>{{trans('messages.both')}}</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input class="col-md-4" name="measures[rangemin][{{$measure->id}}][]" type="text"
                                    value="{{ $value->range_lower }}" 
                                    title="{{trans('messages.lower-range')}}">
                                <span class="col-md-2">:</span>
                                <input class="col-md-4" name="measures[rangemax][{{$measure->id}}][]" type="text"
                                    value="{{ $value->range_upper }}"
                                    title="{{trans('messages.upper-range')}}">
                            </div>
                            <div class="col-md-2">
                                <input class="col-md-10" name="measures[interpretation][{{$measure->id}}][]" type="text" 
                                    value="{{ $value->interpretation }}">
                                <button class="col-md-2 close" aria-hidden="true" type="button" 
                                title="{{trans('messages.delete')}}">×</button>
                                <input value="{{ $value->id }}" name="measures[measurerangeid][{{$measure->id}}][]" type="hidden">
                            </div>
                        </div>
                        @endforeach

                    @elseif ($measure->measure_type_id == 2 || $measure->measure_type_id == 3)
                        <div class="col-md-12">
                            <span class="col-md-5 interpretation-title">{{trans('messages.range')}}</span>
                            <span class="col-md-5 interpretation-title">{{trans('messages.interpretation')}}</span>
                        </div>
                        @foreach($measure->measureRanges as $key=>$value)
                        <div class="col-md-12 measure-input">
                            <div class="col-md-5">
                                <input class="col-md-10 interpretation" value="{{ $value->alphanumeric }}"
                                name="measures[val][{{$measure->id}}][]" type="text">
                            </div>
                            <div class="col-md-5">
                                <input class="col-md-10 interpretation" value="{{ $value->interpretation }}"
                                name="measures[interpretation][{{$measure->id}}][]" type="text">
                                <button class="col-md-2 close" aria-hidden="true" type="button" 
                                    title="{{trans('messages.delete')}}">×</button>
                                <input value="{{ $value->id }}" name="measures[measurerangeid][{{$measure->id}}][]" type="hidden">
                            </div>
                        </div>  
                        @endforeach
                    @endif
                </div>
                <div class="col-md-12 actions-row">
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