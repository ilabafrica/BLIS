@section ("measureinput")
    <!-- OTHER UI COMPONENTS -->
    <div class="numericInputLoader">
        <div class="hidden numeric-range-measure">
            <input name="measurerangeid[]" type="hidden" value="0">
            <button class="close" aria-hidden="true" type="button" title="Delete">×</button>
            <div>
                <span class="range-title">{{trans('messages.measure-age-range')}}:</span>
                <input name="agemin[]" type="text">
                <span>:</span>
                <input name="agemax[]" type="text">
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
                <input name="rangemin[]" type="text">
                <span>:</span>
                <input name="rangemax[]" type="text">
            </div>
        </div><!-- numericInput -->
    </div>

    <div class="alphanumericInputLoader">
        <div class="hidden alphanumericInput">
            <input name="val[]" type="text">
            <span class="alphanumericSlash">/</span>
        </div><!-- alphanumericInput -->
    </div>

    <div class="autocompleteInputLoader">
        <div class="hidden autocompleteInput">
            <input name="val[]" type="text">
        </div><!-- autocompleteInput -->
    </div>

    <div class="freetextInputLoader">
        <p class="hidden freetextInput" >{{trans('messages.freetext-measure-config-input-message')}}</p>
    </div><!-- freetextInput -->
@show