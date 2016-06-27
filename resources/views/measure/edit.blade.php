@section("edit")
@foreach($testtype->measures as $measure)
<div class="col-md-12 measure-section card card-block">
    <div class="col-md-12 measure">
        <div class="col-md-3">
            <div class="form-group row">
                {!! Form::label('measures[name]['.$measure->id.']', trans_choice('terms.name', 1).':', array('class' => 'col-sm-3 form-control-label')) !!}
                <div class="col-sm-9">
                    <input class="form-control" name="measures[{!!$measure->id!!}][name]" value="{!!$measure->name!!}" type="text">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group row">
                {!! Form::label('measures[measure_type_id]['.$measure->id.']', trans('terms.type').':', array('class' => 'col-sm-2 form-control-label')) !!}
                <div class="col-sm-10">
                    <select class="form-control c-select measuretype-input-trigger {!!$measure->id!!}" 
                        data-measure-id="{!!$measure->id!!}" 
                        name="measures[{!!$measure->id!!}][measure_type_id]" 
                        id="measure_type_id">
                        <option value="0"></option>
                        @foreach ($measuretype as $type)
                            <option value="{!!$type->id!!}"
                            {!!($type->id == $measure->measure_type_id) ? 'selected="selected"' : '' !!}>{!!$type->name!!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group row">
                {!! Form::label('measures[unit]['.$measure->id.']', trans('terms.unit').':', array('class' => 'col-sm-3 form-control-label')) !!}
                <div class="col-sm-9">
                    <input class="form-control" name="measures[{!!$measure->id!!}][unit]" value="{!!$measure->unit!!}" type="text">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group row">
                {!! Form::label('measures[description]['.$measure->id.']', trans('terms.info').':', array('class' => 'col-sm-2 form-control-label')) !!}
                <div class="col-sm-8">
                    <textarea class="form-control" value="{!!$measure->description!!}" rows="2" name="measures[{!!$measure->id!!}][description]"></textarea>
                </div>
                <div class="col-sm-1">
                    <button class="col-md-12 close" aria-hidden="true" type="button" 
                        title="{!!trans('messages.delete')!!}"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <label for="measurerange" 'class'='form-group row col-sm-offset-2 form-control-label'>{!! trans('terms.range-values') !!}</label>
        </div>
        <div class="col-md-12 card card-block">
            <div class="measurevalue {!!$measure->id!!}">                        
                @if ($measure->measure_type_id == 1)
                    <div class="col-md-12">
                        <div class="col-md-5">
                            <span class="col-md-8 range-title">{!! trans('terms.age-range') !!}</span>
                            <span class="col-md-4 range-title">{!! trans('terms.gender') !!}</span>
                        </div>
                        <div class="col-md-4">
                            <span class="col-md-12 range-title">{!! trans('terms.measure-range') !!}</span>
                        </div>
                        <div class="col-md-2">
                            <span class="col-md-12 interpretation-title">{!! trans('terms.interpretation') !!}
                            </span>
                        </div>
                    </div>     
                    @foreach($measure->measureRanges as $key=>$value)
                    <div class="col-md-12 measure-input" style="padding-bottom:4px;">
                        <div class="col-md-5">
                            <div class="col-sm-8">
                                <div class="col-sm-6">
                                    <input class="form-control" name="measures[{!!$measure->id!!}][agemin][]" type="text" value="{!! $value->age_min !!}"
                                        title="{!!trans('messages.lower-age-limit')!!}">
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" name="measures[{!!$measure->id!!}][agemax][]" type="text" value="{!! $value->age_max !!}"
                                        title="{!!trans('messages.upper-age-limit')!!}">
                                </div>
                            </div>
                                    <?php $selection = array("","","");?>
                                    <?php $selection[$value->gender] = "selected='selected'"; ?>
                            <div class="col-sm-4">
                                <select class="col-md-4 c-select form-control" name="measures[{!!$measure->id!!}][gender][]">
                                    <option value="0" {!! $selection[0] !!}>{!! trans_choice('terms.sex', 1) !!}</option>
                                    <option value="1" {!! $selection[1] !!}>{!! trans_choice('terms.sex', 2) !!}</option>
                                    <option value="2" {!! $selection[2] !!}>{!! trans('terms.both') !!}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-sm-6">
                                <input class="form-control" name="measures[{!!$measure->id!!}][rangemin][]" type="text"
                                    value="{!! $value->range_lower !!}" 
                                    title="{!!trans('messages.lower-range')!!}">
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control" name="measures[{!!$measure->id!!}][rangemax][]" type="text"
                                    value="{!! $value->range_upper !!}"
                                    title="{!!trans('messages.upper-range')!!}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="col-sm-12">
                                <input class="form-control" name="measures[{!!$measure->id!!}][interpretation][]" type="text" 
                                    value="{!! $value->interpretation !!}">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button class="col-md-2 close" aria-hidden="true" type="button" 
                                title="{!!trans('messages.delete')!!}"><span aria-hidden="true">&times;</span>
                            </button>
                            <input value="{!! $value->id !!}" name="measures[{!!$measure->id!!}][measurerangeid][]" type="hidden">
                        </div>
                    </div>
                    @endforeach
                @elseif ($measure->measure_type_id == 2 || $measure->measure_type_id == 3)
                    <div class="col-md-12">
                        <span class="col-md-5 val-title">{!! trans('terms.range') !!}</span>
                        <span class="col-md-5 interpretation-title">{!! trans('terms.interpretation') !!}</span>
                    </div>
                    @foreach($measure->measureRanges as $key=>$value)
                    <div class="col-md-12 measure-input">
                        <div class="col-md-5">
                            <input class="col-md-10 val form-control" value="{!! $value->alphanumeric !!}"
                            name="measures[{!!$measure->id!!}][val][]" type="text">
                        </div>
                        <div class="col-md-5">
                            <input class="col-md-10 interpretation form-control" value="{!! $value->interpretation !!}"
                            name="measures[{!!$measure->id!!}][interpretation][]" type="text">
                            <button class="col-md-2 close" aria-hidden="true" type="button" 
                                title="{!!trans('messages.delete')!!}">&times;</button>
                            <input value="{!! $value->id !!}" name="measures[{!!$measure->id!!}][measurerangeid][]" type="hidden">
                        </div>
                    </div>  
                    @endforeach
                @else
                    <div class="freetextInputLoader">
                        <p class="freetextInput" >{!! trans('terms.freetext-measure-config-input-message') !!}</p>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-12 actions-row {!!($measure->measure_type_id == 4)? 'hidden':''!!}">
            <a class="btn btn-sm btn-wisteria add-another-range" href="javascript:void(0);" 
                data-measure-id="{!!$measure->id!!}">
            <i class="fa fa-plus-circle"></i> {!! trans('action.new').' '.trans_choice('terms.range', 1) !!}</a>
        </div>
    </div>
</div>
@endforeach
@show