@section("measureinput")
<!-- OTHER UI COMPONENTS -->
    <div class="hidden measureGenericLoader">
        <div class="row new-measure-section">
            <div class="col-md-11 measure">
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('new-measures[][name]', Lang::choice('messages.name',1)) }}
                       <input class="form-control name" name="" type="text">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('new-measures[][measure_type_id]', trans('messages.measure-type')) }}
                            <select class="form-control measuretype-input-trigger measure_type_id" 
                                data-measure-id="0" 
                                data-new-measure-id="" 
                                name="" 
                                id="measure_type_id">
                                <option value="0"></option>
                                @foreach ($measuretype as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('new-measures[][unit]', trans('messages.unit')) }}
                        <input class="form-control unit" name="" type="text">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('new-measures[][description]', trans('messages.description')) }}
                        <textarea class="form-control description" rows="2" name=""></textarea>
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
    </div><!-- alphanumericHeader -->
    <div class="hidden alphanumericHeaderLoader">
        <div class="col-md-12">
            <span class="col-md-5 interpretation-title">{{trans('messages.value')}}</span>
            <span class="col-md-5 interpretation-title">{{trans('messages.interpretation')}}</span>
        </div>
    </div><!-- numericHeader -->
    <div class="hidden numericInputLoader">
        <div class="col-md-12 measure-input">
            <div class="col-md-6">
                <?php $selection_interval = array("","");?>
                <?php $selection_interval[$value->interval] = "selected='selected'"; ?>
                <select class="col-md-3" name="measures[{{$measure->id}}][interval][]">
                    <option value="0" {{ $selection_interval[0] }}>Months</option>
                    <option value="1" {{ $selection_interval[1] }}>Years</option>
                </select>
                <span class="col-md-1">:</span>
                <input class="col-md-2 agemin" name="" type="text" min="1" title="{{trans('messages.lower-age-limit')}}">
                <span class="col-md-1">:</span>
                <input class="col-md-2 agemax" name="" type="text" min="1" title="{{trans('messages.upper-age-limit')}}">
                <span class="col-md-1"></span>
                <select class="col-md-3 gender" name="">
                    <option value="0">{{trans('messages.male')}}</option>
                    <option value="1">{{trans('messages.female')}}</option>
                    <option value="2">{{trans('messages.both')}}</option>
                </select>
            </div>
            <div class="col-md-3">
                <input class="col-md-4 rangemin" name="" type="text" title="{{trans('messages.lower-range')}}">
                <span class="col-md-2">:</span>
                <input class="col-md-4 rangemax" name="" type="text" title="{{trans('messages.upper-range')}}">
            </div>
            <div class="col-md-2">
                <input class="col-md-10 interpretation" name="" type="text">
                <button class="col-md-2 close" aria-hidden="true" type="button" title="{{trans('messages.delete')}}">×</button>
                <input class="measurerangeid" name="" type="hidden">
            </div>
        </div>
    </div><!-- numericInput -->
    <div class="hidden alphanumericInputLoader">
        <div class="col-md-12 measure-input">
            <div class="col-md-5">
                <input class="col-md-10 val" name="" type="text">
            </div>
            <div class="col-md-5">
                <input class="col-md-10 interpretation" name="" type="text">
                <button class="col-md-2 close" aria-hidden="true" type="button" title="{{trans('messages.delete')}}">×</button>
                <input class="measurerangeid" name="" type="hidden">
            </div>
        </div>
    </div><!-- alphanumericInput -->
    <div class="hidden freetextInputLoader">
        <p class="freetextInput" >{{trans('messages.freetext-measure-config-input-message')}}</p>
    </div><!-- freetextInput -->
@show