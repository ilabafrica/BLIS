@section ("reportHeader")
    <table width="100%" style="font-size:12px;">
        <thead>
            <tr>
                <td>{{ HTML::image(Config::get('blis.organization-logo'),  Config::get('blis.country') . trans('messages.court-of-arms'), array('width' => '90px')) }}</td>
                <td colspan="3" style="text-align:center;">
                    <strong><p> {{ strtoupper(Config::get('blis.organization')) }}<br>
                    {{ strtoupper(Config::get('blis.address-info')) }}</p>
                    <p>{{ trans('messages.laboratory-report')}}<br>
                </td>
                <td>
                @if($accredited)
                    {{ HTML::image(count($accredited) == count($tests) ? Config::get('blis.kenas-logo') : Config::get('blis.organization-logo'),  Config::get('blis.country') . trans('messages.court-of-arms'), array('width' => '90px')) }}
                @else
                    {{ HTML::image(Config::get('blis.organization-logo'),  Config::get('blis.country') . trans('messages.court-of-arms'), array('width' => '90px')) }}
                @endif
                </td>
            </tr>
        </thead>
    </table>
@show