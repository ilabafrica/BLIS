@section ("reportHeader")
    <table width="100%" style="font-size:12px;">
        <thead>
            <tr>
                <td>{{ HTML::image(Config::get('kblis.organization-logo'),  Config::get('kblis.country') . trans('messages.court-of-arms'), array('width' => '90px')) }}</td>
                <td colspan="3" style="text-align:center;">
                    <strong><p> {{ strtoupper(Config::get('kblis.organization')) }}<br>
                    {{ strtoupper(Config::get('kblis.address-info')) }}</p>
                    <p>{{ trans('messages.laboratory-report')}}<br>
                </td>
                <td>{{ HTML::image(Config::get('kblis.organization-logo'),  Config::get('kblis.country') . trans('messages.court-of-arms'), array('width' => '90px')) }}</td>
            </tr>
        </thead>
    </table>
@show