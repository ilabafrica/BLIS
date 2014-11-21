@section("measureinput")
<!-- OTHER UI COMPONENTS -->
    <div class="hidden numericInputLoader">
        <div class="measure-input">
            <button class="close" aria-hidden="true" type="button" title="{{trans('messages.delete')}}">×</button>
            <input  name="measurerangeid[]" type="hidden">
            <div>
                <span class="range-title">{{trans('messages.measure-age-range')}}:</span>
                <input name="agemin[]" type="text" title="{{trans('messages.lower-age-limit')}}">

                <span>:</span>
                <input name="agemax[]" type="text" title="{{trans('messages.upper-age-limit')}}">
            </div>
            <div>
                <span class="range-title">{{trans('messages.gender')}}:</span>
                <select name="gender[]">
                    <option value="0">{{trans('messages.male')}}</option>
                    <option value="1">{{trans('messages.female')}}</option>
                    <option value="2">{{trans('messages.both')}}</option>
                </select>
            </div>
            <div>
                <span class="range-title">{{trans('messages.measure-range')}}:</span>
                <input name="rangemin[]" type="text" title="{{trans('messages.lower-range')}}">
                <span>:</span>
                <input name="rangemax[]" type="text" title="{{trans('messages.upper-range')}}">
            </div>
            <div>
                <span class="interpretation-title">{{trans('messages.interpretation')}}:</span>
                <input class="interpretation" name="interpretation[]" type="text" 
                    >
            </div>
        </div>
    </div><!-- numericInput -->
    <div class="hidden alphanumericInputLoader">
        <div class="measure-input">
            <button class="close" aria-hidden="true" type="button" title="{{trans('messages.delete')}}">×</button>
            <input  name="measurerangeid[]" type="hidden">
            <div>
                <span class="interpretation-title">{{trans('messages.range')}}:</span>
                <input class="interpretation" name="val[]" type="text">
            </div>
            <div>
                <span class="interpretation-title">{{trans('messages.interpretation')}}:</span>
                <input class="interpretation" name="interpretation[]" type="text">
            </div>
        </div>  
    </div><!-- alphanumericInput -->
    <div class="hidden autocompleteInputLoader">
        <div class="measure-input">
            <button class="close" aria-hidden="true" type="button" title="{{trans('messages.delete')}}">×</button>
            <input  name="measurerangeid[]" type="hidden">
            <div>
                <span class="interpretation-title">{{trans('messages.range')}}:</span>
                <input class="interpretation" name="val[]" type="text">
            </div>
            <div>
                <span class="interpretation-title">{{trans('messages.interpretation')}}:</span>
                <input class="interpretation"  name="interpretation[]" type="text">
            </div>
        </div><!-- autocompleteInput -->
    </div>
    <div class="hidden freetextInputLoader">
        <p class="freetextInput" >{{trans('messages.freetext-measure-config-input-message')}}</p>
    </div><!-- freetextInput -->
@show