@section("controlMeasures")
<!-- OTHER UI COMPONENTS -->
    <div class="hidden measureGenericLoader">
        <div class="row new-measure-section">
            <div class="col-md-11 measure">
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('new-measures[][name]', Lang::choice('messages.name',1)) }}
                       <input class="form-control name" name="new-measures[][name]" type="text">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('new-measures[][measure_type_id]', trans('messages.measure-type')) }}
                            <select class="form-control measure_type_id" 
                                data-measure-id="0" 
                                data-new-measure-id=""  
                                name="new-measures[][measure_type_id]" 
                                id="measure_type_id">
                                <option value="0"></option>
                                @foreach ($measureTypes as $measureType)
                                    <option value="{{$measureType->id}}">{{$measureType->name}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('new-measures[][expected]', trans('messages.expected-value')) }}
                        <input class="form-control expected " name="new-measures[][expected]" type="text">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('new-measures[][unit]', trans('messages.unit')) }}
                        <input class="form-control unit" name="new-measures[][unit]" type="text">
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <button class="col-md-12 close" aria-hidden="true" type="button" 
                    title="{{trans('messages.delete')}}">X</button>
            </div>
        </div>    
    </div><!-- measureGeneric -->
@show