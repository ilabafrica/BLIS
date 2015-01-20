@section("measureinput")
<!-- OTHER UI COMPONENTS -->
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