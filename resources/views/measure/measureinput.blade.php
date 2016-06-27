@section("measureinput")

<div class="col-md-12 measure-section">
    <div class="col-md-12 measure">
        <div class="hidden measureGenericLoader">
            <div class=" col-md-12 card card-block">
                <div class="col-md-3">
                    <div class="form-group row">
                        {!! Form::label('new_measures[][name]', trans_choice('general-terms.name', 1).':', array('class' => 'col-sm-3 form-control-label')) !!}
                        <div class="col-sm-9">
                            <input class="form-control name" name="" value="" type="text">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group row">
                        {!! Form::label('new_measures[][measure_type_id]', trans('general-terms.type').':', array('class' => 'col-sm-2 form-control-label')) !!}
                        <div class="col-sm-10">
                            <select class="form-control c-select measuretype-input-trigger measure_type_id" 
                                data-measure-id="0" 
                                data-new-measure-id="" 
                                name="" 
                                id="measure_type_id">
                                <option value="0"></option>
                                @foreach ($measuretype as $type)
                                    <option value="{!!$type->id!!}">{!!$type->name!!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group row">
                        {!! Form::label('new_measures[][unit]', trans('general-terms.unit').':', array('class' => 'col-sm-3 form-control-label')) !!}
                        <div class="col-sm-9">
                            <input class="form-control unit" name="" value="" type="text">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row">
                        {!! Form::label('new_measures[][description]', trans('general-terms.info').':', array('class' => 'col-sm-2 form-control-label')) !!}
                        <div class="col-sm-8">
                            <textarea class="form-control description" value="" rows="2" name=""></textarea>
                        </div>
                        <div class="col-sm-1">
                            <button class="col-md-12 close" aria-hidden="true" type="button" 
                                title="{!!trans('messages.delete')!!}"><span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="measurerange" 'class'='form-group row col-sm-offset-2 form-control-label'>{!! trans('general-terms.range-values') !!}</label>
                </div>
                <div class="col-md-12 actions-row" style="padding-bottom:5px;">
                    <a class="btn btn-sm btn-wisteria add-another-range" href="javascript:void(0);" 
                        data-measure-id="">
                    <i class="fa fa-plus-circle"></i> {!! trans('action.new').' '.trans_choice('general-terms.range', 1) !!}</a>
                </div>
            </div>
        </div>
        <div class="col-md-12 card card-block">
            <!-- measureGeneric -->
            <div class="col-md-12 card card-block hidden numericHeaderLoader">
                <div class="col-md-5">
                    <span class="col-md-8 range-title">{!! trans('general-terms.age-range') !!}</span>
                    <span class="col-md-4 range-title">{!! trans('general-terms.gender') !!}</span>
                </div>
                <div class="col-md-4">
                    <span class="col-md-12 range-title">{!! trans('specific-terms.measure-range') !!}</span>
                </div>
                <div class="col-md-2">
                    <span class="col-md-12 interpretation-title">{!! trans('specific-terms.interpretation') !!}
                    </span>
                </div>
            </div>
            <!-- numericHeader -->
            <div class="col-md-12 card card-block hidden numericInputLoader" style="padding-bottom:4px;">                
                <div class="col-md-5">
                    <div class="col-sm-8">
                        <div class="col-sm-6">
                            <input class="form-control agemin" name="" type="text" value="" title="{!!trans('messages.lower-age-limit')!!}">
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control agemax" name="" type="text" value="" title="{!!trans('messages.upper-age-limit')!!}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <select class="col-md-4 c-select form-control gender" name="">
                            <option value="0">{!! trans_choice('specific-terms.sex', 1) !!}</option>
                            <option value="1">{!! trans_choice('specific-terms.sex', 2) !!}</option>
                            <option value="2">{!! trans('specific-terms.both') !!}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-sm-6">
                        <input class="form-control rangemin" name="" type="text" value="" title="{!!trans('messages.lower-range')!!}">
                    </div>
                    <div class="col-sm-6">
                        <input class="form-control rangemin" name="" type="text" value="" title="{!!trans('messages.upper-range')!!}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="col-sm-12">
                        <input class="form-control interpretation" name="" type="text" value="">
                    </div>
                </div>
                <div class="col-md-1">
                    <button class="col-md-2 close" aria-hidden="true" type="button" 
                        title="{!!trans('messages.delete')!!}"><span aria-hidden="true">&times;</span>
                    </button>
                    <input class="measurerangeid" name="" type="hidden">
                </div>
            </div>
            <!-- alphanumericHeader -->
            <div class="col-md-12 card card-block hidden alphanumericHeaderLoader">
                <span class="col-md-5 val-title">{!! trans('specific-terms.value') !!}</span>
                <span class="col-md-5 interpretation-title">{!! trans('specific-terms.interpretation') !!}</span>
            </div>
            <!-- numericHeader -->
            <div class="col-md-12 hidden card card-block alphanumericInputLoader">                
                <div class="col-md-5">
                    <input class="col-md-10 val form-control" value="" name="" type="text">
                </div>
                <div class="col-md-6">
                    <input class="col-md-10 interpretation form-control" value="" name="" type="text">
                </div>
                <div class="col-md-1">                    
                    <button class="close" aria-hidden="true" type="button" 
                        title="{!!trans('messages.delete')!!}">&times;</button>
                    <input class="measurerangeid" name="" type="hidden">
                </div>
            </div>
            <div class="col-md-12 hidden freetextInputLoader">
                <p class="freetextInput" >{!! trans('specific-terms.freetext-measure-config-input-message') !!}</p>
            </div>
        </div>
    </div>
</div>
@show