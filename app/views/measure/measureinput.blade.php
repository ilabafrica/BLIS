@section("measureinput")
<!-- OTHER UI COMPONENTS -->
    <div class="hidden numericInputLoader">
        <div class="measure-input">
            <button class="close" aria-hidden="true" type="button" title="{{trans('messages.delete')}}">×</button>
            <input  name="measurerangeid[]" type="hidden">
            <div class="col-md-2">
                <input class="col-md-4" name="agemin[]" type="text" title="{{trans('messages.lower-age-limit')}}">
                <span class="col-md-2">:</span>
                <input class="col-md-4" name="agemax[]" type="text" title="{{trans('messages.upper-age-limit')}}">
            </div>
            <div class="col-md-2">
                <select name="gender[]">
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
                <input class="interpretation" name="interpretation[]" type="text" 
                    >
            </div>
        </div>
    </div><!-- numericInput -->
    <div class="hidden alphanumericInputLoader">
        <div class="measure-input">
            <button class="close" aria-hidden="true" type="button" title="{{trans('messages.delete')}}">×</button>
            <input  name="measurerangeid[]" type="hidden">
            <div class="col-md-2">
                <input class="col-md-8" name="val[]" type="text">
            </div>
            <div class="col-md-2">
                <input class="col-md-8" name="interpretation[]" type="text">
            </div>
        </div>  
    </div><!-- alphanumericInput -->
    <div class="hidden autocompleteInputLoader">
        <div class="measure-input">
            <button class="close" aria-hidden="true" type="button" title="{{trans('messages.delete')}}">×</button>
            <input  name="measurerangeid[]" type="hidden">
            <div>
                <input class="interpretation" name="val[]" type="text">
            </div>
            <div>
                <input class="interpretation"  name="interpretation[]" type="text">
            </div>
        </div><!-- autocompleteInput -->
    </div>
    <div class="hidden freetextInputLoader">
        <p class="freetextInput" >{{trans('messages.freetext-measure-config-input-message')}}</p>
    </div><!-- freetextInput -->
@show