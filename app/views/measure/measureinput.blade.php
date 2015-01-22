@section("measureinput")
<!-- OTHER UI COMPONENTS -->
    <div class="hidden measureGenericLoader">
        <div class="row new-measure-section">
            <div class="col-md-11 measure">
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('name', Lang::choice('messages.name',1)) }}
                        {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('measure_type_id', trans('messages.measure-type')) }}
                        {{ Form::select('measure_type_id', array(0 => '')+$measuretype->lists('name', 'id'),
                        Input::old('measure_type_id'), array('class' => 'form-control measuretype-input-trigger',
                        'data-measure-id'=>'0', 'data-new-measure-id' => '')) 
                        }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('unit', trans('messages.unit')) }}
                        {{ Form::text('unit', Input::old('unit'), array('class' => 'form-control')) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('description', trans('messages.description')) }}
                        {{ Form::textarea('description', Input::old('description'), array('class' => 'form-control',
                            'rows'=>'2')) }}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="measurerange">{{trans('messages.measure-range-values')}}</label>
                        <div class="form-pane panel panel-default">
                            <div class="panel-body">
                            <div>
                                <div class="measurevalue"></div>
                                <div class="col-md-12 actions-row">
                                    <a class="btn btn-default add-another-range" href="javascript:void(0);" 
                                        data-measure-id="0"
                                        data-new-measure-id="">
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
    </div><!-- measureGeneric -->
    <div class="hidden numericHeaderLoader">
        <div class="col-md-12">
            <div class="col-md-4">
                <span class="col-md-6 range-title">{{trans('messages.measure-age-range')}}</span>
                <span class="col-md-6 range-title">{{trans('messages.gender')}}</span>
            </div>
            <div class="col-md-3">
                <span class="col-md-12 range-title">{{trans('messages.measure-range')}}</span>
            </div>
            <div class="col-md-2">
                <span class="col-md-12 interpretation-title">{{trans('messages.interpretation')}}</span>
            </div>
        </div>     
    </div><!-- numericHeader -->
    <div class="hidden alphanumericHeaderLoader">
        <div class="col-md-12">
            <span class="col-md-5 interpretation-title">{{trans('messages.value')}}</span>
            <span class="col-md-5 interpretation-title">{{trans('messages.interpretation')}}</span>
        </div>
    </div><!-- alphanumericHeader -->
    <div class="hidden numericInputLoader">
        <div class="col-md-12 measure-input">
            <div class="col-md-4">
                <input class="col-md-2" name="agemin[]" type="text" title="{{trans('messages.lower-age-limit')}}">
                <span class="col-md-1">:</span>
                <input class="col-md-2" name="agemax[]" type="text" title="{{trans('messages.upper-age-limit')}}">
                <span class="col-md-1"></span>
                <select class="col-md-4" name="gender[]">
                    <option value="0">{{trans('messages.male')}}</option>
                    <option value="1">{{trans('messages.female')}}</option>
                    <option value="2">{{trans('messages.both')}}</option>
                </select>
            </div>
            <div class="col-md-3">
                <input class="col-md-4" name="rangemin[]" type="text" title="{{trans('messages.lower-range')}}">
                <span class="col-md-2">:</span>
                <input class="col-md-4" name="rangemax[]" type="text" title="{{trans('messages.upper-range')}}">
            </div>
            <div class="col-md-2">
                <input class="col-md-10" name="interpretation[]" type="text">
                <button class="col-md-2 close" aria-hidden="true" type="button" title="{{trans('messages.delete')}}">×</button>
                <input name="measurerangeid[]" type="hidden">
            </div>
        </div>
    </div><!-- numericInput -->
    <div class="hidden alphanumericInputLoader">
        <div class="col-md-12 measure-input">
            <div class="col-md-5">
                <input class="col-md-10 interpretation" name="val[]" type="text">
            </div>
            <div class="col-md-5">
                <input class="col-md-10 interpretation" name="interpretation[]" type="text">
                <button class="col-md-2 close" aria-hidden="true" type="button" title="{{trans('messages.delete')}}">×</button>
                <input name="measurerangeid[]" type="hidden">
            </div>
        </div>
    </div><!-- alphanumericInput -->
    <div class="hidden freetextInputLoader">
        <p class="freetextInput" >{{trans('messages.freetext-measure-config-input-message')}}</p>
    </div><!-- freetextInput -->
@show