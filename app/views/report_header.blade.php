@section ("report_header")
{{ Form::open(array('route' => 'patientreport.filter', 'id' => 'form-patientreport-filter')) }}
{{ Form::hidden('patient', $patient->id, array('id' => 'patient')) }}
<div class="table-responsive">
  <table class="table">
    <thead>
    <tr>
        <td>{{ Form::label('name', trans("messages.from")) }}</td>
        <td>{{ Form::text('from', Input::old('from'), array('class' => 'form-control', 'id' => 'from')) }}</td>
        <td>{{ Form::label('name', trans("messages.to")) }}</td>
         <td>{{ Form::text('to', Input::old('to'), array('class' => 'form-control', 'id' => 'to')) }}</td>
        <td>{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
                        array('class' => 'btn btn-primary', 'style' => 'width:125px', 'id' => 'filter', 'type' => 'submit')) }}</td>
    </tr>
    <tr>
        <td><label class="radio-inline">
			  {{ Form::radio('layout', '1', true, array('data-toggle' => 'radio', 'id' => 'layout')) }} Portrait
			</label>
		 </td>
         <td>
         	<label class="radio-inline">
			  {{ Form::radio('layout', '2', false, array('data-toggle' => 'radio', 'id' => 'layout')) }} Landscape
			</label>
         </td>
         <td>{{ Form::button("<span class='glyphicon glyphicon-zoom-in'></span> ".trans('messages.increase-font'), 
                        array('class' => 'btn btn-default', 'id' => 'increaseFont')) }}</td>
         <td>{{ Form::button("<span class='glyphicon glyphicon-zoom-out'></span> ".trans('messages.reset-font'), 
                        array('class' => 'btn btn-default', 'id' => 'resetFont')) }}</td>
         <td>{{ Form::button("<span class='glyphicon glyphicon-send'></span> ".trans('messages.print'), 
                        array('class' => 'btn btn-warning', 'style' => 'width:125px', 'id' => 'print')) }}</td>
     </tr>
     <tr>
        <td>
        	<label class="checkbox-inline">
              <!-- {{ Form::hidden('pending', false) }} -->
			  {{ Form::checkbox('pending', 1, null, array('id' => 'pending')) }} {{trans('messages.include-pending-tests')}}
			</label>
        </td>
        <td>
        	<label class="checkbox-inline">
			  {{ Form::checkbox('range', 'yes', false, array('id' => 'range')) }} {{trans('messages.include-range-visualization')}}
			</label>
        </td>
        <td>{{ Form::button("<span class='glyphicon glyphicon-file'></span> ".trans('messages.export-to-word'), 
                        array('class' => 'btn btn-success', 'style' => 'width:160px', 'id' => 'word')) }}</td>
        <td>{{ Form::button("<span class='glyphicon glyphicon-bookmark'></span> ".trans('messages.export-to-pdf'), 
                        array('class' => 'btn btn-info', 'style' => 'width:160px', 'id' => 'pdf')) }}</td>
        <td>{{ Form::button("<span class='glyphicon glyphicon-remove'></span> ".trans('messages.close'), 
                        array('class' => 'btn btn-danger', 'style' => 'width:125px', 'id' => 'close')) }}</td>
     </tr>
</thead>
<tbody>
	<tr>
		<td><img src="{{ Config::get('kblis.organization-logo') }}" alt="" height="90" width="90"></td>
		<td colspan="3" style="text-align:center;">
			<strong><p>BUNGOMA DISTRICT HOSPITAL LABORATORY<br>
			BUNGOMA TOWN, HOSPITAL ROAD<br>
			OPPOSITE POLICE LINE/DISTRICT HEADQUARTERS<br>
			P.O. BOX 14,<br>
			BUNGOMA TOWN.<br>
			Phone: +254 055-30401 Ext 203/208</p>

			<p>LABORATORY REPORT<br>
			Patient Report for {{date('d-m-Y')}}</p></strong>			
		</td>
		<td><img src="{{ Config::get('kblis.organization-logo') }}" alt="" height="90" width="90" style="float:right;"></td>
	</tr>
</tbody>
  </table>
  {{ Form::close() }}
</div>
@show