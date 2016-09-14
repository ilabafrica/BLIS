<?


Lang::trans_choice('messages.control',2)
trans_choice('menu.control',2)

messages.home
menu.home


messages.add-control
terms.add-control

@extends("app")
@extends("layout")



 			

-				{!! Form::label('name', trans_choice('terms.name',1)) !!}
-                {!! Form::text('name', '', array('class' => 'form-control')) !!}
+				{{ Form::label('name', Lang::choice('messages.name',1)) }}
+                {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}


-				{!! Form::label('description', trans('terms.description')) !!}
-				{!! Form::textarea('description', '', array('class' => 'form-control', 'rows' => '3' )) !!}
+				{{ Form::label('description', trans('messages.description')) }}
+				{{ Form::textarea('description', Input::old('description'), 
+					array('class' => 'form-control', 'rows' => '3' )) }}


-				{!! Form::label('lot', trans_choice('terms.lot', 1)) !!}
-				{!! Form::select('lot', $lots, array('class' => 'form-control')) !!}
+				{{ Form::label('instruments', Lang::choice('messages.instrument', 2)) }}
+				{{ Form::select('instrument_id', array('') + $instruments, Input::old('instrument'), 
+					array('class' => 'form-control')) }}


-				{!! Form::label('measures', trans_choice('terms.measure',2)) !!}
+				{{ Form::label('measures', Lang::choice('messages.measure',2)) }}
 				
 					
 					</div>
 					<a class="btn btn-default add-another-measure" href="javascript:void(0);" data-new-measure="1">
-					<span class="glyphicon glyphicon-plus-sign"></span>{!!trans('terms.add-new-measure')!!}</a>
+					<span class="glyphicon glyphicon-plus-sign"></span>{{trans('messages.add-new-measure')}}</a>
 				</div>

 		</div>
 		<div class="panel-footer">
 			<div class="form-group actions-row">
-				{!! Form::button(
-					'<span class="glyphicon glyphicon-save"></span> '.trans('action.save'),
+				{{ Form::button(
+					'<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'),
 					[
 						'class' => 'btn btn-primary', 
 						'onclick' => 'submit()'
 					] 
-				) !!}
+				) }}

 		</div>
-	{!! Form::close() !!}
+	{{ Form::close() }}
 </div>
 @include("control.measureCreate")
 @stop
\ No newline at end of file
diff --git a/resources/views/control/edit.blade.php b/resources/views/control/edit.blade.php
index 2842720..a5ffa4b 100755
--- a/resources/views/control/edit.blade.php
+++ b/resources/views/control/edit.blade.php
@@ -1,68 +1,68 @@
-@extends("app")
+@extends("layout")
 @section("content")
 <div>
 	<ol class="breadcrumb">
-	  <li><a href="{!! URL::route('user.home')!!}">{!!trans('menu.home')!!}</a></li>
-	  <li><a href="{!! URL::route('control.index') !!}">{!! trans_choice('menu.control',1) !!}</a></li>
-	  <li class="active">{!!trans('terms.edit-control')!!}</li>
+	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+	  <li><a href="{{ URL::route('control.index') }}">{{ Lang::choice('messages.control',1) }}</a></li>
+	  <li class="active">{{trans('messages.edit-control')}}</li>
 	</ol>
 </div>
 @if (Session::has('message'))
-	<div class="alert alert-info">{!! Session::get('message') !!}</div>
+	<div class="alert alert-info">{{ Session::get('message') }}</div>
 
 <div class="panel panel-primary">
 	<div class="panel-heading ">
 		<span class="glyphicon glyphicon-edit"></span>
-		{!!trans('terms.edit-control')!!}
+		{{trans('messages.edit-control')}}
 	</div>
-	{!! Form::model($control, array(
+	{{ Form::model($control, array(
 			'route' => array('control.update', $control->id), 'method' => 'PUT',
 			'id' => 'form-edit-control'
-		)) !!}
+		)) }}
 		<div class="panel-body">
 			@if($errors->all())
 				<div class="alert alert-danger">
-					{!! HTML::ul($errors->all()) !!}
+					{{ HTML::ul($errors->all()) }}
 				</div>
 			
 

-				{!! Form::label('name', trans_choice('terms.name',1)) !!}
-				{!! Form::text('name', Input::old('name'), array('class' => 'form-control')) !!}
+				{{ Form::label('name', Lang::choice('messages.name',1)) }}
+				{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}


-				{!! Form::label('description', trans('terms.description')) !!}
-				{!! Form::textarea('description', Input::old('description'), 
-					array('class' => 'form-control', 'rows' => '2' )) !!}
+				{{ Form::label('description', trans('messages.description')) }}
+				{{ Form::textarea('description', Input::old('description'), 
+					array('class' => 'form-control', 'rows' => '2' )) }}


-					{!! Form::label('lot', trans_choice('terms.lot', 1)) !!}
-					{!! Form::select('lot', $lots, Input::old('lot'), 
-					array('class' => 'form-control')) !!}
+				{{ Form::label('instruments', Lang::choice('messages.instrument', 1)) }}
+				{{ Form::select('instrument_id', $instruments, Input::old('instrument')?Input::old('instrument'):$instrument, 
+				array('class' => 'form-control')) }}


-				{!! Form::label('measures', trans_choice('terms.measure',2)) !!}
+				{{ Form::label('measures', Lang::choice('messages.measure',2)) }}
 				
 					
 						@include("control.measureEdit")
 					</div>
 			        <a class="btn btn-default add-another-measure" href="javascript:void(0);" data-new-measure="1">
-			        	<span class="glyphicon glyphicon-plus-sign"></span>{!!trans('terms.add-new-measure')!!}</a>
+			        	<span class="glyphicon glyphicon-plus-sign"></span>{{trans('messages.add-new-measure')}}</a>
 				</div>

 		</div>
 		<div class="panel-footer">
 			<div class="form-group actions-row">
-				{!! Form::button(
-					'<span class="glyphicon glyphicon-save"></span> '.trans('action.save'), 
+				{{ Form::button(
+					'<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'), 
 					['class' => 'btn btn-primary', 'onclick' => 'submit()']
-				) !!}
-				{!! Form::button(trans('action.cancel'), 
+				) }}
+				{{ Form::button(trans('messages.cancel'), 
 					['class' => 'btn btn-default', 'onclick' => 'javascript:history.go(-1)']
-				) !!}
+				) }}

 		</div>
-	{!! Form::close() !!}
+	{{ Form::close() }}
 </div>
 @include("control.measureCreate")
 @stop
\ No newline at end of file
diff --git a/resources/views/control/index.blade.php b/resources/views/control/index.blade.php
index 50d54c6..9a24ba8 100755
--- a/resources/views/control/index.blade.php
+++ b/resources/views/control/index.blade.php
@@ -1,22 +1,22 @@
-@extends("app")
+@extends("layout")
 @section("content")
 <div>
 	<ol class="breadcrumb">
-	  <li><a href="{!! URL::route('user.home')!!}">{!! trans('menu.home') !!}</a></li>
-	  <li class="active">{!!trans_choice('menu.control',2)!!}</li>
+	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+	  <li class="active">{{Lang::choice('messages.control',2)}}</li>
 	</ol>
 </div>
 @if (Session::has('message'))
-	<div class="alert alert-info">{!! Session::get('message') !!}</div>
+	<div class="alert alert-info">{{ Session::get('message') }}</div>
 
 <div class="panel panel-primary">
 	<div class="panel-heading ">
 		<span class="glyphicon glyphicon-adjust"></span>
-		{!! trans('terms.list-controls') !!}
+		{{ trans('messages.list-controls') }}
 		<div class="panel-btn">
-			<a class="btn btn-sm btn-info" href="{!! URL::to("control/create") !!}" >
+			<a class="btn btn-sm btn-info" href="{{ URL::to("control/create") }}" >
 				<span class="glyphicon glyphicon-plus-sign"></span>
-				{!! trans('terms.add-control') !!}
+				{{ trans('messages.add-control') }}
 			</a>
 		</div>
 	</div>
@@ -24,32 +24,32 @@
 		<table class="table table-striped table-hover table-condensed search-table">
 			<thead>
 				<tr>
-					<th>{!! trans_choice('terms.name', 1) !!}</th>
-					<th>{!! trans_choice('terms.lot', 1) !!}</th>
+					<th>{{ Lang::choice('messages.name', 1) }}</th>
+					<th>{{ Lang::choice('messages.instrument', 1) }}</th>
 					<th></th>
 				</tr>
 			</thead>
 			<tbody>
 			@foreach($controls as $control)
-					<td>{!! $control->name !!}</td>
-					<td>{!! $control->lot->number !!}</td>
+					<td>{{ $control->name }}</td>
+					<td>{{ $control->instrument->name }}</td>
 					<td>
-						<a class="btn btn-sm btn-info" href="{!! URL::to("control/" . $control->id . "/edit") !!}" >
+						<a class="btn btn-sm btn-info" href="{{ URL::to("control/" . $control->id . "/edit") }}" >
 							<span class="glyphicon glyphicon-edit"></span>
-							{!! trans('action.edit') !!}
+							{{ trans('messages.edit') }}
 						</a>
 						<button class="btn btn-sm btn-danger delete-item-link"
 							data-toggle="modal" data-target=".confirm-delete-modal"
-							data-id='{!! URL::to("control/" . $control->id . "/delete") !!}'>
+							data-id='{{ URL::to("control/" . $control->id . "/delete") }}'>
 							<span class="glyphicon glyphicon-trash"></span>
-							{!! trans('action.delete') !!}
+							{{ trans('messages.delete') }}
 						</button>
 					</td>
 				</tr>
 			@endforeach
 			</tbody>
 		</table>
-		{!! Session::put('SOURCE_URL', URL::full()) !!}
+		{{ Session::put('SOURCE_URL', URL::full()) }}
 	</div>
 </div>
 @stop
\ No newline at end of file
diff --git a/resources/views/control/measureCreate.blade.php b/resources/views/control/measureCreate.blade.php
index 6f5475f..b549eda 100755
--- a/resources/views/control/measureCreate.blade.php
+++ b/resources/views/control/measureCreate.blade.php
@@ -5,34 +5,34 @@
             <div class="col-md-11 measure">
                 <div class="col-md-3">

-                        {!! Form::label('new_measures[][name]', trans_choice('terms.name',1)) !!}
-                       <input class="form-control name" name="new_measures[][name]" type="text">
+                        {{ Form::label('new-measures[][name]', Lang::choice('messages.name',1)) }}
+                       <input class="form-control name" name="new-measures[][name]" type="text">
                     </div>
                 </div>
                 <div class="col-md-3">

-                        {!! Form::label('new_measures[][measure_type_id]', trans('terms.measure-type')) !!}
+                        {{ Form::label('new-measures[][measure_type_id]', trans('messages.measure-type')) }}
                             <select class="form-control measuretype-input-trigger measure_type_id" 
                                 data-measure-id="0" 
                                 data-new-measure-id="" 
-                                name="new_measures[][measure_type_id]" 
+                                name="new-measures[][measure_type_id]" 
                                 id="measure_type_id">
                                 <option value="0"></option>
                                 @foreach ($measureTypes as $measureType)
-                                    <option value="{!!$measureType->id!!}">{!!$measureType->name!!}</option>
+                                    <option value="{{$measureType->id}}">{{$measureType->name}}</option>
                                 @endforeach
                             </select>
                     </div>
                 </div>
                 <div class="col-md-3">

-                        {!! Form::label('new_measures[][unit]', trans('terms.unit')) !!}
-                        <input class="form-control unit" name="new_measures[][unit]" type="text">
+                        {{ Form::label('new-measures[][unit]', trans('messages.unit')) }}
+                        <input class="form-control unit" name="new-measures[][unit]" type="text">
                     </div>
                 </div>
                 <div class="col-md-12">

-                        <label for="measurerange">{!!trans('terms.measure-range-values')!!}</label>
+                        <label for="measurerange">{{trans('messages.measure-range-values')}}</label>
                         
                             <div class="panel-body">
                             <div>
@@ -41,7 +41,7 @@
                                     <a class="btn btn-default add-another-range" href="javascript:void(0);" 
                                         data-measure-id="0"
                                         data-new-measure-id="">
-                                    <span class="glyphicon glyphicon-plus-sign"></span>{!!trans('terms.add-new-measure-range')!!}</a>
+                                    <span class="glyphicon glyphicon-plus-sign"></span>{{trans('messages.add-new-measure-range')}}</a>
                                 </div>
                             </div>
                             </div>
@@ -51,41 +51,41 @@
             </div>
             <div class="col-md-1">
                 <button class="col-md-12 close" aria-hidden="true" type="button" 
-                    title="{!!trans('action.delete')!!}">×</button>
+                    title="{{trans('messages.delete')}}">×</button>
             </div>
         </div>    
     </div><!-- measureGeneric -->
     <div class="hidden numericHeaderLoader">
         <div class="col-md-12">
             <div class="col-md-3">
-                <span class="col-md-12 range-title">{!!trans('terms.measure-range')!!}</span>
+                <span class="col-md-12 range-title">{{trans('messages.measure-range')}}</span>
             </div>
         </div>
     </div><!-- alphanumericHeader -->
     <div class="hidden alphanumericHeaderLoader">
         <div class="col-md-12">
-            <span class="col-md-5 interpretation-title">{!!trans('terms.value')!!}</span>
+            <span class="col-md-5 interpretation-title">{{trans('messages.value')}}</span>
         </div>
     </div><!-- numericHeader -->
     <div class="hidden numericInputLoader">
         <div class="col-md-12 measure-input">
             <div class="col-md-3">
-                <input class="col-md-4 rangemin" name="new_measures[][rangemin][]" type="text" title="{!!trans('terms.lower-range')!!}">
+                <input class="col-md-4 rangemin" name="new-measures[][rangemin][]" type="text" title="{{trans('messages.lower-range')}}">
                 <span class="col-md-2">:</span>
-                <input class="col-md-4 rangemax" name="new_measures[][rangemax][]" type="text" title="{!!trans('terms.upper-range')!!}">
-                <button class="col-md-2 close" aria-hidden="true" type="button" title="{!!trans('terms.delete')!!}">×</button>
-                <input class="measurerangeid" name="new_measures[][measurerangeid][]" type="hidden">
+                <input class="col-md-4 rangemax" name="new-measures[][rangemax][]" type="text" title="{{trans('messages.upper-range')}}">
+                <button class="col-md-2 close" aria-hidden="true" type="button" title="{{trans('messages.delete')}}">×</button>
+                <input class="measurerangeid" name="new-measures[][measurerangeid][]" type="hidden">
             </div>
         </div>
     </div><!-- numericInput -->
     <div class="hidden alphanumericInputLoader">
         <div class="col-md-12 measure-input">
             <div class="col-md-5">
-                <input class="col-md-10 val" name="new_measures[][val][]" type="text">
+                <input class="col-md-10 val" name="new-measures[][val][]" type="text">
             </div>
         </div>
     </div><!-- alphanumericInput -->
     <div class="hidden freetextInputLoader">
-        <p class="freetextInput" >{!!trans('terms.freetext-measure-config-input-message')!!}</p>
+        <p class="freetextInput" >{{trans('messages.freetext-measure-config-input-message')}}</p>
     </div><!-- freetextInput -->
 @show
\ No newline at end of file
diff --git a/resources/views/control/measureEdit.blade.php b/resources/views/control/measureEdit.blade.php
index f4dbe6c..a1df666 100755
--- a/resources/views/control/measureEdit.blade.php
+++ b/resources/views/control/measureEdit.blade.php
@@ -4,89 +4,89 @@
 <div class="col-md-11 measure">
     <div class="col-md-3">

-            {!! Form::label('measures[name]['.$measure->id.']', trans_choice('terms.name',1)) !!}
-           <input class="form-control" name="measures[{!!$measure->id!!}][name]" value="{!!$measure->name!!}" type="text">
-           <input type="hidden" name="measures[{!!$measure->id!!}][id]" value="{!!$measure->id!!}">
+            {{ Form::label('measures[name]['.$measure->id.']', Lang::choice('messages.name',1)) }}
+           <input class="form-control" name="measures[{{$measure->id}}][name]" value="{{$measure->name}}" type="text">
+           <input type="hidden" name="measures[{{$measure->id}}][id]" value="{{$measure->id}}">
         </div>
     </div>
     <div class="col-md-3">

-            {!! Form::label('measures[measure_type_id]['.$measure->id.']', trans('terms.measure-type')) !!}
-                <select class="form-control measuretype-input-trigger {!!$measure->id!!}" 
-                    data-measure-id="{!!$measure->id!!}" 
-                    name="measures[{!!$measure->id!!}][measure_type_id]" 
+            {{ Form::label('measures[measure_type_id]['.$measure->id.']', trans('messages.measure-type')) }}
+                <select class="form-control measuretype-input-trigger {{$measure->id}}" 
+                    data-measure-id="{{$measure->id}}" 
+                    name="measures[{{$measure->id}}][measure_type_id]" 
                     id="measure_type_id">
                     <option value="0"></option>
                     @foreach ($measureTypes as $measureType)
-                        <option value="{!!$measureType->id!!}"
-                        {!!($measureType->id == $measure->control_measure_type_id) ? 'selected="selected"' : '' !!}>{!!$measureType->name!!}</option>
+                        <option value="{{$measureType->id}}"
+                        {{($measureType->id == $measure->control_measure_type_id) ? 'selected="selected"' : '' }}>{{$measureType->name}}</option>
                     @endforeach
                 </select>
         </div>
     </div>
     <div class="col-md-3">

-            {!! Form::label('measures[unit]['.$measure->id.']', trans('terms.unit')) !!}
-            <input class="form-control" name="measures[{!!$measure->id!!}][unit]" value="{!!$measure->unit!!}" type="text">
+            {{ Form::label('measures[unit]['.$measure->id.']', trans('messages.unit')) }}
+            <input class="form-control" name="measures[{{$measure->id}}][unit]" value="{{$measure->unit}}" type="text">
         </div>
     </div>
     <div class="col-md-12">

-            <label for="measurerange">{!!trans('terms.measure-range-values')!!}</label>
+            <label for="measurerange">{{trans('messages.measure-range-values')}}</label>
             
                 <div class="panel-body">
                 <div>
                     <div 
-                    class="{!!($measure->control_measure_type_id == 1) ? 'col-md-12' : 'col-md-6' !!} measurevalue {!!$measure->id!!}">
+                    class="{{($measure->control_measure_type_id == 1) ? 'col-md-12' : 'col-md-6' }} measurevalue {{$measure->id}}">
                     
                     @if ($measure->control_measure_type_id == 1)
                         <div class="col-md-12">
                             <div class="col-md-3">
-                                <span class="col-md-12 range-title">{!!trans('terms.measure-range')!!}</span>
+                                <span class="col-md-12 range-title">{{trans('messages.measure-range')}}</span>
                             </div>
                         </div>
                         @foreach($measure->controlMeasureRanges as $key=>$controlMeasureRange)
                         <div class="col-md-12 measure-input">
                             <div class="col-md-3">
-                                <input class="col-md-4" name="measures[{!!$measure->id!!}][rangemin][]" type="text"
-                                    value="{!! $controlMeasureRange->lower_range !!}" 
-                                    title="{!!trans('terms.lower-range')!!}">
+                                <input class="col-md-4" name="measures[{{$measure->id}}][rangemin][]" type="text"
+                                    value="{{ $controlMeasureRange->lower_range }}" 
+                                    title="{{trans('messages.lower-range')}}">
                                 <span class="col-md-2">:</span>
-                                <input class="col-md-4" name="measures[{!!$measure->id!!}][rangemax][]" type="text"
-                                    value="{!! $controlMeasureRange->upper_range !!}"
-                                    title="{!!trans('terms.upper-range')!!}">
+                                <input class="col-md-4" name="measures[{{$measure->id}}][rangemax][]" type="text"
+                                    value="{{ $controlMeasureRange->upper_range }}"
+                                    title="{{trans('messages.upper-range')}}">
                                 <button class="col-md-2 close" aria-hidden="true" type="button" 
-                                title="{!!trans('action.delete')!!}">×</button>
-                                <input value="{!! $controlMeasureRange->id !!}" name="measures[{!!$measure->id!!}][measurerangeid][]" type="hidden">
+                                title="{{trans('messages.delete')}}">×</button>
+                                <input value="{{ $controlMeasureRange->id }}" name="measures[{{$measure->id}}][measurerangeid][]" type="hidden">
                             </div>
                         </div>
                         @endforeach
 
                     @elseif ($measure->control_measure_type_id == 2 || $measure->control_measure_type_id == 3)
                         <div class="col-md-12">
-                            <span class="col-md-5 val-title">{!!trans('terms.range')!!}</span>
+                            <span class="col-md-5 val-title">{{trans('messages.range')}}</span>
                         </div>
                         @foreach($measure->controlMeasureRanges as $key=>$controlMeasureRange)
                         <div class="col-md-12 measure-input">
                             <div class="col-md-5">
-                                <input class="col-md-10 val" value="{!! $controlMeasureRange->alphanumeric !!}"
-                                name="measures[{!!$measure->id!!}][val][]" type="text">
+                                <input class="col-md-10 val" value="{{ $controlMeasureRange->alphanumeric }}"
+                                name="measures[{{$measure->id}}][val][]" type="text">
                                 <button class="col-md-2 close" aria-hidden="true" type="button" 
-                                    title="{!!trans('action.delete')!!}">×</button>
-                                <input value="{!! $controlMeasureRange->id !!}" name="measures[{!!$measure->id!!}][measurerangeid][]" type="hidden">
+                                    title="{{trans('messages.delete')}}">×</button>
+                                <input value="{{ $controlMeasureRange->id }}" name="measures[{{$measure->id}}][measurerangeid][]" type="hidden">
                             </div>
                         </div>  
                         @endforeach
                     @else
                         <div class="freetextInputLoader">
-                            <p class="freetextInput" >{!!trans('terms.freetext-measure-config-input-message')!!}</p>
+                            <p class="freetextInput" >{{trans('messages.freetext-measure-config-input-message')}}</p>
                         </div>
                     
                 </div>
-                <div class="col-md-12 actions-row {!!($measure->control_measure_type_id == 4)? 'hidden':''!!}">
+                <div class="col-md-12 actions-row {{($measure->control_measure_type_id == 4)? 'hidden':''}}">
                     <a class="btn btn-default add-another-range" href="javascript:void(0);" 
-                        data-measure-id="{!!$measure->id!!}">
-                    <span class="glyphicon glyphicon-plus-sign"></span>{!!trans('terms.add-new-measure-range')!!}</a>
+                        data-measure-id="{{$measure->id}}">
+                    <span class="glyphicon glyphicon-plus-sign"></span>{{trans('messages.add-new-measure-range')}}</a>
                 </div>
                 </div>
                 </div>
@@ -96,7 +96,7 @@
 </div>
 <div class="col-md-1">
     <button class="col-md-12 close" aria-hidden="true" type="button" 
-        title="{!!trans('action.delete')!!}">×</button>
+        title="{{trans('messages.delete')}}">×</button>
 </div>
 </div>
 @endforeach
diff --git a/resources/views/control/resultsEdit.blade.php b/resources/views/control/resultsEdit.blade.php
index d60cda6..f06e76e 100755
--- a/resources/views/control/resultsEdit.blade.php
+++ b/resources/views/control/resultsEdit.blade.php
@@ -1,32 +1,40 @@
-@extends("app")
+@extends("layout")
 @section("content")
 
 	<div>
 		<ol class="breadcrumb">
-		<li><a href="{!! URL::route('user.home')!!}">{!! trans('menu.home') !!}</a></li>
-		 <li><a href="{!! URL::route('control.resultsIndex') !!}">{!! trans_choice('menu.controlresults',2) !!}</a></li>
-		<li class="active">{!!trans('terms.control-results-edit')!!}</li>
+		<li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+		 <li><a href="{{ URL::route('control.resultsIndex') }}">{{ Lang::choice('messages.controlresults',2) }}</a></li>
+		<li class="active">{{trans('messages.control-results-edit')}}</li>
 		</ol>
 	</div>
 	@if (Session::has('message'))
-		<div class="alert alert-info">{!! trans(Session::get('message')) !!}</div>
+		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
 	
 	<div class="panel panel-primary">
 		<div class="panel-heading ">
 			<span class="glyphicon glyphicon-edit"></span>
-			{!! trans('terms.edit-results') !!}
+			{{ trans('messages.edit-results') }}
 		</div>
 		<div class="panel-body">
 			@if($errors->all())
 				<div class="alert alert-danger">
-					{!! HTML::ul($errors->all()) !!}
+					{{ HTML::ul($errors->all()) }}
 				</div>
 			
 			
 				<div class="container-fluid">
                 <div class="row">
                     <div class="col-md-7">
-                    {!! Form::open(array('route' => array('controlresult.update', $controlTest->id), 'method' => 'POST', 'id' => 'form-edit-control')) !!}
+                    {{ Form::open(array('route' => array('controlresult.update', $controlTest->id), 'method' => 'POST', 'id' => 'form-edit-control')) }}
+                        
+                            {{ Form::label('performed-by', trans('messages.performed-by')) }}
+                            {{ Form::text('performed_by', $controlTest->performed_by, array('class' => 'form-control')) }}
+                        </div>
+                        
+                            {{ Form::label('lots', trans('messages.lot-number')) }}
+                            {{ Form::select('lot_id', array(''=>'')+$lots, Input::old('lot')?Input::old('lot'):$lot, array('class' => 'form-control')) }}
+                        </div>
                         @foreach($controlTest->control->controlMeasures as $key => $controlMeasure)

                                 <?php
@@ -38,50 +46,46 @@
                                     }
                                 ?>
                                 @if ( $controlMeasure->isNumeric() ) 
-                                    {!! Form::label("m_".$controlMeasure->id , $controlMeasure->name) !!}
-                                    {!! Form::text("m_".$controlMeasure->id, $ans, array(
+                                    {{ Form::label("m_".$controlMeasure->id , $controlMeasure->name) }}
+                                    {{ Form::text("m_".$controlMeasure->id, $ans, array(
                                         'class' => 'form-control result-interpretation-trigger'))
-                                    !!}
+                                    }}
                                     <span class='units'>
-                                        {!!$controlMeasure->controlMeasureRanges->first()->getRangeUnit()!!}
+                                        {{$controlMeasure->controlMeasureRanges->first()->getRangeUnit()}}
                                     </span>
                                 @else ( $controlMeasure->isAlphanumeric() ) 
-                                    {!! Form::label("m_".$controlMeasure->id , $controlMeasure->name) !!}
-                                    {!! Form::select("m_".$controlMeasure->id, array(null => '') +$controlMeasure->controlMeasureRanges->lists('alphanumeric', 'alphanumeric'), $ans,
+                                    {{ Form::label("m_".$controlMeasure->id , $controlMeasure->name) }}
+                                    {{ Form::select("m_".$controlMeasure->id, array(null => '') +$controlMeasure->controlMeasureRanges->lists('alphanumeric', 'alphanumeric'), $ans,
                                         array('class' => 'form-control result-interpretation-trigger',
                                         'data-url' => URL::route('test.resultinterpretation'),
                                         'data-measureid' => $controlMeasure->id
                                         )) 
-                                    !!}
+                                    }}
                                 
                             </div>
                         @endforeach
                         <div class="form-group actions-row">
-                            {!! Form::button('<span class="glyphicon glyphicon-save">
-                                </span> '.trans('action.save-test-results'),
-                                array('class' => 'btn btn-default', 'onclick' => 'submit()')) !!}
+                            {{ Form::button('<span class="glyphicon glyphicon-save">
+                                </span> '.trans('messages.save-test-results'),
+                                array('class' => 'btn btn-default', 'onclick' => 'submit()')) }}
                         </div>
-                    {!! Form::close() !!}
+                    {{ Form::close() }}
                     </div>
                     <div class="col-md-5">
                         <div class="panel panel-info">  <!-- Patient Details -->
                             <div class="panel-heading">
-                                <h3 class="panel-title">{!!trans("terms.control-details")!!}</h3>
+                                <h3 class="panel-title">{{trans("messages.control-details")}}</h3>
                             </div>
                             <div class="panel-body">
                                 <div class="container-fluid">
                                     <div class="row">
                                         <div class="col-md-3">
-                                            <p><strong>{!!trans("terms.lot-number")!!}</strong></p></div>
-                                        <div class="col-md-9">{!! $controlTest->control->lot->number !!}</div></div>
-                                    <div class="row">
-                                        <div class="col-md-3">
-                                            <p><strong>{!! trans_choice('terms.control-name',1) !!}</strong></p></div>
-                                        <div class="col-md-9">{!! $controlTest->control->name !!}</div></div>
+                                            <p><strong>{{ Lang::choice('messages.control-name',1) }}</strong></p></div>
+                                        <div class="col-md-9">{{ $controlTest->control->name }}</div></div>
                                     <div class="row">
                                         <div class="col-md-3">
-                                            <p><strong>{!!trans_choice("terms.instrument",1)!!}</strong></p></div>
-                                        <div class="col-md-9">{!! $controlTest->control->lot->instrument->name !!}</div>
+                                            <p><strong>{{Lang::choice("messages.instrument",1)}}</strong></p></div>
+                                        <div class="col-md-9">{{ $controlTest->control->instrument->name }}</div>
                                     </div>
                                 </div>
                             </div> <!-- ./ panel-body -->
diff --git a/resources/views/control/resultsEntry.blade.php b/resources/views/control/resultsEntry.blade.php
index c6daff1..8411a31 100755
--- a/resources/views/control/resultsEntry.blade.php
+++ b/resources/views/control/resultsEntry.blade.php
@@ -1,10 +1,10 @@
-@extends("app")
+@extends("layout")
 @section("content")
     <div>
         <ol class="breadcrumb">
-          <li><a href="{!! URL::route('user.home')!!}">{!! trans('menu.home') !!}</a></li>
-          <li><a href="{!! URL::route('control.resultsIndex') !!}">{!! trans_choice('menu.controlresults',2) !!}</a></li>
-          <li class="active">{!! trans('terms.enter-control-results') !!}</li>
+          <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+          <li><a href="{{ URL::route('control.resultsIndex') }}">{{ Lang::choice('messages.controlresults',2) }}</a></li>
+          <li class="active">{{ trans('messages.enter-control-results') }}</li>
         </ol>
     </div>
     <div class="panel panel-primary">
@@ -12,11 +12,22 @@
             <div class="container-fluid">
                 <div class="row less-gutter">
                     <div class="col-md-11">
-                        <span class="glyphicon glyphicon-user"></span> {!! trans('terms.controlresults') !!}
+                        <span class="glyphicon glyphicon-user"></span> {{ trans('messages.controlresults') }}
+                        @if($control->name == "Full Haemogram")
+                        <div class="panel-btn">
+                            <a class="btn btn-sm btn-info fetch-test-data" href="javascript:void(0)"
+                                data-control-id="{{$control->id}}"
+                                title="{{trans('messages.fetch-test-data-title')}}"
+                                data-url="{{URL::route('instrument.getControlResult')}}">
+                                <span class="glyphicon glyphicon-plus-sign"></span>
+                                {{trans('messages.fetch-test-data')}}
+                            </a>
+                        </div>
+                        
                     </div>
                     <div class="col-md-1">
                         <a class="btn btn-sm btn-primary pull-right"  href="#" onclick="window.history.back();return false;"
-                            alt="{!!trans('terms.back')!!}" title="{!!trans('terms.back')!!}">
+                            alt="{{trans('messages.back')}}" title="{{trans('messages.back')}}">
                             <span class="glyphicon glyphicon-backward"></span></a>
                     </div>
                 </div>
@@ -27,67 +38,70 @@
             
             @if($errors->all())
                 <div class="alert alert-danger">
-                    {!! HTML::ul($errors->all()) !!}
+                    {{ HTML::ul($errors->all()) }}
                 </div>
             
             <div class="container-fluid">
                 <div class="row">
                     <div class="col-md-6">
-                    {!! Form::open(array('route' => array('control.saveResults',$control->id), 'method' => 'POST',
-                        'id' => 'form-enter-results')) !!}
+                    {{ Form::open(array('route' => array('control.saveResults',$control->id), 'method' => 'POST',
+                        'id' => 'form-enter-results')) }}
+                        
+                            {{ Form::label('performed-by', trans('messages.performed-by')) }}
+                            {{ Form::text('performed_by', Input::old('performed_by'), array('class' => 'form-control')) }}
+                        </div>
+                        
+                            {{ Form::label('lots', trans('messages.lot-number')) }}
+                            {{ Form::select('lot_id', array('') + $lots, '', array('class' => 'form-control')) }}
+                        </div>
                         @foreach($control->controlMeasures as $key => $controlMeasure)

                                 @if ( $controlMeasure->isNumeric() ) 
-                                    {!! Form::label("m_".$controlMeasure->id , $controlMeasure->name) !!}
-                                    {!! Form::text("m_".$controlMeasure->id, Input::old("m_".$controlMeasure->id), array(
+                                    {{ Form::label("m_".$controlMeasure->id , $controlMeasure->name) }}
+                                    {{ Form::text("m_".$controlMeasure->id, Input::old("m_".$controlMeasure->id), array(
                                         'class' => 'form-control result-interpretation-trigger'))
-                                    !!}
+                                    }}
                                     <span class='units'>
-                                        {!!$controlMeasure->controlMeasureRanges->first()->getRangeUnit()!!}
+                                        {{$controlMeasure->controlMeasureRanges->first()->getRangeUnit()}}
                                     </span>
                                 @elseif ( $controlMeasure->isAlphanumeric() ) 
-                                    {!! Form::label("m_".$controlMeasure->id , $controlMeasure->name) !!}
-                                    {!! Form::select("m_".$controlMeasure->id, array(null => '') +$controlMeasure->controlMeasureRanges->lists('alphanumeric', 'alphanumeric'),
+                                    {{ Form::label("m_".$controlMeasure->id , $controlMeasure->name) }}
+                                    {{ Form::select("m_".$controlMeasure->id, array(null => '') +$controlMeasure->controlMeasureRanges->lists('alphanumeric', 'alphanumeric'),
                                     Input::old('instrument'),
                                         array('class' => 'form-control result-interpretation-trigger',
                                         'data-url' => URL::route('test.resultinterpretation'),
                                         'data-measureid' => $controlMeasure->id
                                         )) 
-                                    !!}
+                                    }}
                                 @else 
-                                    {!! Form::label("m_".$controlMeasure->id, $controlMeasure->name) !!}
-                                    {!!Form::text("m_".$controlMeasure->id, $ans, array('class' => 'form-control'))!!}
+                                    {{ Form::label("m_".$controlMeasure->id, $controlMeasure->name) }}
+                                    {{Form::text("m_".$controlMeasure->id, $ans, array('class' => 'form-control'))}}
                                 
                             </div>
                         @endforeach
                         <div class="form-group actions-row">
-                            {!! Form::button('<span class="glyphicon glyphicon-save">
-                                </span> '.trans('terms.save-test-results'),
-                                array('class' => 'btn btn-default', 'onclick' => 'submit()')) !!}
+                            {{ Form::button('<span class="glyphicon glyphicon-save">
+                                </span> '.trans('messages.save-test-results'),
+                                array('class' => 'btn btn-default', 'onclick' => 'submit()')) }}
                         </div>
-                    {!! Form::close() !!}
+                    {{ Form::close() }}
                     </div>
                     <div class="col-md-6">
                         <div class="panel panel-info">  <!-- Patient Details -->
                             <div class="panel-heading">
-                                <h3 class="panel-title">{!!trans("terms.control-details")!!}</h3>
+                                <h3 class="panel-title">{{trans("messages.control-details")}}</h3>
                             </div>
                             <div class="panel-body">
                                 <div class="container-fluid">
                                     <div class="row">
                                         <div class="col-md-3">
-                                            <p><strong>{!!trans("terms.lot-number")!!}</strong></p></div>
-                                        <div class="col-md-9">
-                                            {!! $control->lot->number !!}</div></div>
-                                    <div class="row">
-                                        <div class="col-md-3">
-                                            <p><strong>{!! trans_choice('terms.control-name',1) !!}</strong></p></div>
+                                            <p><strong>{{ Lang::choice('messages.control-name',1) }}</strong></p></div>
                                         <div class="col-md-9">
-                                            {!! $control->name !!}</div></div>
+                                            {{ $control->name }}</div></div>
                                     <div class="row">
                                         <div class="col-md-3">
-                                            <p><strong>{!!trans_choice("terms.instrument",1)!!}</strong></p></div>
-                                        <div class="col-md-9"> {!! $control->lot->instrument->name !!}</div>
+                                            <p><strong>{{Lang::choice("messages.instrument",1)}}</strong></p></div>
+                                        <div class="col-md-9"> {{ $control->instrument->name }}</div>
                                     </div>
                                 </div>
                             </div> <!-- ./ panel-body -->
diff --git a/resources/views/control/resultsIndex.blade.php b/resources/views/control/resultsIndex.blade.php
index 02dd4bc..5bc5ddc 100755
--- a/resources/views/control/resultsIndex.blade.php
+++ b/resources/views/control/resultsIndex.blade.php
@@ -1,45 +1,45 @@
-@extends("app")
+@extends("layout")
 @section("content")
 <div>
 	<ol class="breadcrumb">
-	  <li><a href="{!! URL::route('user.home')!!}">{!! trans('menu.home') !!}</a></li>
-	  <li class="active">{!!trans('menu.controlresults')!!}</li>
+	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+	  <li class="active">{{trans('messages.controlresults')}}</li>
 	</ol>
 </div>
 @if (Session::has('message'))
-	<div class="alert alert-info">{!! Session::get('message') !!}</div>
+	<div class="alert alert-info">{{ Session::get('message') }}</div>
 
 <div class="panel panel-primary">
 	<div class="panel-heading ">
 		<span class="glyphicon glyphicon-adjust"></span>
-		{!! trans('terms.list-controls') !!}
+		{{ trans('messages.list-controls') }}
 	</div>
 	<div class="panel-body">
 		<table class="table table-striped table-hover table-condensed search-table">
 			<thead>
 				<tr>
-					<th>{!! trans_choice('terms.name', 1) !!}</th>
+					<th>{{ Lang::choice('messages.name', 1) }}</th>
 					<th></th>
 				</tr>
 			</thead>
 			<tbody>
 			@foreach($controls as $control)
-					<td>{!! $control->name !!}</td>
+					<td>{{ $control->name }}</td>
 					<td>
-						<a class="btn btn-sm btn-info" href="{!! URL::to("controlresults/" . $control->id . "/resultsEntry") !!}" >
+						<a class="btn btn-sm btn-info" href="{{ URL::to("controlresults/" . $control->id . "/resultsEntry") }}" >
 							<span class="glyphicon glyphicon-edit"></span>
-							{!! trans('action.enter-results') !!}
+							{{ trans('messages.enter-results') }}
 						</a>
-						<a class="btn btn-sm btn-success" href="{!! URL::to("controlresults/" . $control->id . "/resultsList") !!}">
+						<a class="btn btn-sm btn-success" href="{{ URL::to("controlresults/" . $control->id . "/resultsList") }}">
 							<span class="glyphicon glyphicon-eye-open"></span>
-							{!!trans('action.view')!!}
+							{{trans('messages.view')}}
 						</a>
 					</td>
 				</tr>
 			@endforeach
 			</tbody>
 		</table>
-		{!! Session::put('SOURCE_URL', URL::full()) !!}
+		{{ Session::put('SOURCE_URL', URL::full()) }}
 	</div>
 </div>
 @stop
\ No newline at end of file
diff --git a/resources/views/control/resultsList.blade.php b/resources/views/control/resultsList.blade.php
index f0e91fa..81c31d0 100755
--- a/resources/views/control/resultsList.blade.php
+++ b/resources/views/control/resultsList.blade.php
@@ -1,45 +1,51 @@
-@extends("app")
+@extends("layout")
 @section("content")
 <div>
     <ol class="breadcrumb">
-      <li><a href="{!! URL::route('user.home')!!}">{!! trans('menu.home') !!}</a></li>
-      <li><a href="{!! URL::route('control.resultsIndex') !!}">{!! trans_choice('terms.controlresults',2) !!}</a></li>
-      <li class="active">{!!trans('terms.show-results')!!}</li>
+      <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+      <li><a href="{{ URL::route('control.resultsIndex') }}">{{ Lang::choice('messages.controlresults',2) }}</a></li>
+      <li class="active">{{trans('messages.show-results')}}</li>
     </ol>
 </div>
 @if (Session::has('message'))
-    <div class="alert alert-info">{!! Session::get('message') !!}</div>
+    <div class="alert alert-info">{{ Session::get('message') }}</div>
 
 <div class="panel panel-primary">
     <div class="panel-heading ">
         <span class="glyphicon glyphicon-adjust"></span>
-        {!! trans('terms.list-results') .'  '. $control->name  !!}
+        {{ trans('messages.list-results') .'  '. $control->name  }}
     </div>
     <div class="panel-body">
         <table class="table table-striped table-hover table-condensed search-table">
             <thead>
                 <tr>
-                    <th> {!! trans_choice('terms.test-id', 1) !!} </th>
-                    <th>{!! trans_choice('terms.created-at', 1) !!}</th>
+                    <th> {{ trans('messages.lot-number') }} </th>
+                    <th> {{ Lang::choice('messages.control', 1) }} </th>
+                    <th> {{ trans('messages.test-results') }} </th>
+                    <th> {{ trans('messages.performed-by') }} </th>
+                    <th>{{ Lang::choice('messages.created-at', 1) }}</th>
                     <th></th>
                 </tr>
             </thead>
             <tbody>
             @foreach($control->controlTests as $controlResult)
                 <tr>
-                    <td>{!!$controlResult->id!!}</td>
-                    <td>{!!$controlResult->created_at!!}</td>
+                    <td>{{$controlResult->lot->lot_no}}</td>
+                    <td>{{$controlResult->control->name}}</td>
+                    <td>{{implode(', ', $controlResult->controlResults->lists('results'))}}</td>
+                    <td>{{$controlResult->performed_by}}</td>
+                    <td>{{$controlResult->created_at}}</td>
                     <td>
-                        <a class="btn btn-sm btn-info" href="{!! URL::to("controlresults/" . $controlResult->id . "/resultsEdit") !!}" >
+                        <a class="btn btn-sm btn-info" href="{{ URL::to("controlresults/" . $controlResult->id . "/resultsEdit") }}" >
                             <span class="glyphicon glyphicon-edit"></span>
-                            {!! trans('action.edit') !!}
+                            {{ trans('messages.edit') }}
                         </a>
                     </td>
                 </tr>
                 @endforeach
             </tbody>
         </table>
-        {!! Session::put('SOURCE_URL', URL::full()) !!}
+        {{ Session::put('SOURCE_URL', URL::full()) }}
     </div>
 </div>
 @stop
\ No newline at end of file
diff --git a/resources/views/dashboard.blade.php b/resources/views/dashboard.blade.php
deleted file mode 100755
index 0416521..0000000
--- a/resources/views/dashboard.blade.php
+++ /dev/null
@@ -1,239 +0,0 @@
-@extends("app")
-
-@section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-  		<div class="card-header">
-    		{!! trans('terms.daily-tests') !!}
-  		</div>
-  		<div class="card-block">
-    		<div id="chart" style="height: 300px"></div>
-  		</div>
-	</div>
-
-	<div class="row">
-		<div class="col-sm-12">
-			<div class="card">
-				<div class="card-header">
-				    <i class="fa fa-book"></i> {!! trans('terms.latest-tests') !!}			    
-				</div>
-			  	<div class="card-block">	  		
-					@if (Session::has('message'))
-						<div class="alert alert-info">{!! Session::get('message') !!}</div>
-					
-				 	<table class="table table-bordered table-sm search-table" style="font-size:13px;">
-						<thead>
-		                    <tr>
-		                        <th>{!! trans('terms.date-ordered') !!}</th>
-		                        <th>{!! trans('terms.patient-no') !!}</th>
-		                        <th>{!! trans('terms.visit-no') !!}</th>
-		                        <th class="col-md-2">{!! trans('terms.patient-name') !!}</th>
-		                        <th class="col-md-1">{!! trans('terms.specimen-id') !!}</th>
-		                        <th>{!! trans_choice('menu.test',1) !!}</th>
-		                        <th>{!! trans('terms.visit-type') !!}</th>
-		                        <th>{!! trans('terms.test-status') !!}</th>
-		                        <th></th>
-		                    </tr>
-		                </thead>
-		                <tbody>
-		                @foreach($tests as $key => $test)
-		                    <tr @if(session()->has('active_test'))
-		                        {!! (session('active_test') == $test->id)?"class='warning'":"" !!}
-		                    
-		                    >
-		                        <td>{!! Carbon::parse($test->time_created)->toDateTimeString() !!}</td>  <!--Date Ordered-->
-		                        <td>{!! empty($test->visit->patient->external_patient_number)?$test->visit->patient->patient_number:$test->visit->patient->external_patient_number !!}</td> <!--Patient Number -->
-		                        <td>{!! empty($test->visit->visit_number)?$test->visit->id:$test->visit->visit_number !!}</td> <!--Visit Number -->
-		                        <td>{!! $test->visit->patient->name.' ('.($test->visit->patient->getGender(true)).', '.Carbon::parse($test->visit->patient->dob)->age. ')' !!}</td> <!--Patient Name -->
-		                        <td>{!! $test->getSpecimenId() !!}</td> <!--Specimen ID -->
-		                        <td>{!! $test->testType->name !!}</td> <!--Test-->
-		                        <td>{!! $test->visit->visit_type !!}</td> <!--Visit Type -->
-		                        <td id="test-status-{!!$test->id!!}" class='test-status'>
-		                            <!-- Test Statuses -->
-		                            <div class="container-fluid">
-		                            
-		                                <div class="row">
-
-		                                    <div class="col-md-12">
-		                                        @if($test->isNotReceived())
-		                                            @if(!$test->isPaid())
-		                                                <span class='label label-silver'>
-		                                                    {!! trans('terms.test-not-paid') !!}</span>
-		                                            @else
-		                                            <span class='label label-asbestos'>
-		                                                {!! trans('terms.test-not-received') !!}</span>
-		                                            
-		                                        @elseif($test->isPending())
-		                                            <span class='label label-pumpkin'>
-		                                                {!! trans('terms.test-pending') !!}</span>
-		                                        @elseif($test->isStarted())
-		                                            <span class='label label-sub-flower'>
-		                                                {!! trans('terms.test-started') !!}</span>
-		                                        @elseif($test->isCompleted())
-		                                            <span class='label label-nephritis'>
-		                                                {!! trans('terms.test-completed') !!}</span>
-		                                        @elseif($test->isVerified())
-		                                            <span class='label label-wet-asphalt'>
-		                                                {!! trans('terms.test-verified') !!}</span>
-		                                        
-		                                    </div>
-		    
-		                                    </div>
-		                                <div class="row">
-		                                    <div class="col-md-12">
-		                                        <!-- Specimen statuses -->
-		                                        @if($test->specimen->isNotCollected())
-		                                         @if(($test->isPaid()))
-		                                            <span class='label label-silver'>
-		                                                {!! trans('terms.specimen-not-collected') !!}</span>
-		                                            
-		                                        @elseif($test->specimen->isReferred())
-		                                            <span class='label label-asbestos'>
-		                                                {!! trans('messages.specimen-referred-label') !!}
-		                                                @if($test->specimen->referral->status == App\Models\Referral::REFERRED_IN)
-		                                                    {!! trans("messages.in") !!}
-		                                                @elseif($test->specimen->referral->status == App\Models\Referral::REFERRED_OUT)
-		                                                    {!! trans("messages.out") !!}
-		                                                
-		                                            </span>
-		                                        @elseif($test->specimen->isAccepted())
-		                                            <span class='label label-success'>
-		                                                {!! trans('terms.specimen-accepted') !!}</span>
-		                                        @elseif($test->specimen->isRejected())
-		                                            <span class='label label-danger'>
-		                                                {!! trans('terms.specimen-rejected') !!}</span>
-		                                        
-		                                    </div>
-		                                </div>
-		                            </div>
-		                        </td>
-		                        <!-- ACTION BUTTONS -->
-		                        <td>
-		                            <a class="btn btn-sm btn-success"
-		                                href="{!! route('test.viewDetails', $test->id) !!}"
-		                                id="view-details-{!!$test->id!!}-link" 
-		                                title="{!!trans('action.view')!!}">
-		                                <i class="fa fa-folder-open"></i>
-		                                {!! trans('action.view') !!}
-		                            </a>
-		                            
-		                        @if ($test->isNotReceived()) 
-		                            @if(Auth::user()->can('receive_external_test') && $test->isPaid())
-		                                <a class="btn btn-sm btn-green-sea receive-test" href="javascript:void(0)"
-		                                    data-test-id="{!!$test->id!!}" data-specimen-id="{!!$test->specimen->id!!}"
-		                                    title="{!!trans('action.receive-test')!!}">
-		                                    <i class="fa fa-cloud-download"></i>
-		                                    {!! trans('action.receive-test') !!}
-		                                </a>
-		                            
-		                        @elseif ($test->specimen->isNotCollected())
-		                            @if(Auth::user()->can('accept_test_specimen'))
-		                                <a class="btn btn-sm btn-wisteria accept-specimen" href="javascript:void(0)"
-		                                    data-test-id="{!!$test->id!!}" data-specimen-id="{!!$test->specimen->id!!}"
-		                                    title="{!!trans('action.accept-specimen')!!}"
-		                                    data-url="{!! route('test.acceptSpecimen') !!}">
-		                                    <i class="fa fa-check-circle"></i>
-		                                    {!! trans('action.accept-specimen') !!}
-		                                </a>
-		                            
-		                            @if(count($test->testType->specimenTypes) > 1 && Auth::user()->can('change_test_specimen'))
-		                                <!-- 
-		                                    If this test can be done using more than 1 specimen type,
-		                                    allow the user to change to any of the other eligible ones.
-		                                -->
-		                                <a class="btn btn-sm btn-pumpkin change-specimen" href="#change-specimen-modal"
-		                                    data-toggle="modal" data-url="{!! route('test.changeSpecimenType') !!}"
-		                                    data-test-id="{!!$test->id!!}" data-target="#change-specimen-modal"
-		                                    title="{!!trans('action.change-specimen')!!}">
-		                                    <i class="fa fa-refresh"></i>
-		                                    {!! trans('action.change-specimen') !!}
-		                                </a>
-		                            
-		                        
-		                        @if ($test->specimen->isAccepted() && !($test->isVerified()))
-		                            @if(Auth::user()->can('reject_test_specimen') && !($test->specimen->isReferred()))
-		                                <a class="btn btn-sm btn-alizarin" id="reject-{!!$test->id!!}-link"
-		                                    href="{!!route('test.reject', array($test->specimen_id))!!}"
-		                                    title="{!!trans('action.reject')!!}">
-		                                    <i class="fa fa-stop-circle"></i>
-		                                    {!! trans('action.reject') !!}
-		                                </a>
-		                            
-		                            @if ($test->isPending())
-		                                @if(Auth::user()->can('start_test'))
-		                                    <a class="btn btn-sm btn-sub-flower start-test" href="javascript:void(0)"
-		                                        data-test-id="{!!$test->id!!}" data-url="{!! route('test.start') !!}"
-		                                        title="{!!trans('action.start-test')!!}">
-		                                        <i class="fa fa-play-circle"></i>
-		                                        {!! trans('action.start-test') !!}
-		                                    </a>
-		                                
-		                                @if(Auth::user()->can('refer_specimens') && !($test->isExternal()) && !($test->specimen->isReferred()))
-		                                    <a class="btn btn-sm btn-silver" href="{!! route('test.refer', array($test->specimen_id)) !!}">
-		                                        <i class="fa fa-send"></i>
-		                                        {!! trans('action.refer-sample') !!}
-		                                    </a>
-		                                
-		                            @elseif ($test->isStarted())
-		                                @if(Auth::user()->can('enter_test_results'))
-		                                    <a class="btn btn-sm btn-peter-river" id="enter-results-{!!$test->id!!}-link"
-		                                        href="{!! route('test.enterResults', array($test->id)) !!}"
-		                                        title="{!!trans('action.enter-results')!!}">
-		                                        <i class="fa fa-pencil-square"></i>
-		                                        {!! trans('action.enter-results') !!}
-		                                    </a>
-		                                
-		                            @elseif ($test->isCompleted())
-		                                @if(Auth::user()->can('edit_test_results'))
-		                                    <a class="btn btn-sm btn-peter-river" id="edit-{!!$test->id!!}-link"
-		                                        href="{!! route('test.edit', array($test->id)) !!}"
-		                                        title="{!!trans('action.edit-results')!!}">
-		                                        <i class="fa fa-file-text"></i>
-		                                        {!! trans('action.edit-results') !!}
-		                                    </a>
-		                                
-		                                @if(Auth::user()->can('verify_test_results') && Auth::user()->id != $test->tested_by)
-		                                    <a class="btn btn-sm btn-midnight-blue" id="verify-{!!$test->id!!}-link"
-		                                        href="{!! route('test.viewDetails', array($test->id)) !!}"
-		                                        title="{!!trans('action.verify')!!}">
-		                                        <i class="fa fa-check-square"></i>
-		                                        {!! trans('action.verify') !!}
-		                                    </a>
-		                                
-
-		                                <div class="">
-		                                    <a class="btn btn-sm btn-asbestos barcode-button" href="{!! url("specimen/" . $test->getSpecimenId() . "/barcode") !!}">
-		                                        <i class="fa fa-barcode"></i>
-		                                        {!! trans('terms.barcode') !!}
-		                                    </a>
-		                                </div> <!-- /. barcode-button -->
-		                            
-		                        
-		                        </td>
-		                    </tr>
-		                @endforeach
-		                </tbody>
-					</table>
-				</div>
-			</div>
-	  	</div>
-	</div>
-</div>
-<!-- Highcharts scripts --><script src="{!! asset('js/jquery.min.js') !!}"></script>
-	
-<script src="{!! asset('js/highcharts.js') !!}"></script>
-<script src="{!! asset('js/exporting.js') !!}"></script>
-<script src="{!! asset('js/drilldown.js') !!}"></script>
-<script type="text/javascript">
-    $(function () {
-        var chart = new Highcharts.Chart(<?php echo $chart ?>);
-    });
-</script>
-@endsection
\ No newline at end of file
diff --git a/resources/views/drug/create.blade.php b/resources/views/drug/create.blade.php
index 7f06dac..60641fc 100755
--- a/resources/views/drug/create.blade.php
+++ b/resources/views/drug/create.blade.php
@@ -1,60 +1,45 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li><a href="{!! route('drug.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.drug', 2) !!}</a></li>
-            <li class="active">{!! trans('action.new').' '.trans_choice('menu.drug', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-pencil"></i> {!! trans('action.new').' '.trans_choice('menu.drug', 1) !!} 
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
+
+	<div>
+		<ol class="breadcrumb">
+		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+		  <li>
+		  	<a href="{{ URL::route('drug.index') }}">{{ Lang::choice('messages.drug',1) }}</a>
+		  </li>
+		  <li class="active">{{trans('messages.create-drug')}}</li>
+		</ol>
+	</div>
+	<div class="panel panel-primary">
+		<div class="panel-heading ">
+			<span class="glyphicon glyphicon-adjust"></span>
+			{{trans('messages.create-drug')}}
 		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
+		<div class="panel-body">
+		<!-- if there are creation errors, they will show here -->
 			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
+				<div class="alert alert-danger">
+					{{ HTML::ul($errors->all()) }}
+				</div>
+			
+
+			{{ Form::open(array('route' => 'drug.store', 'id' => 'form-create-drug')) }}
 
-			{!! Form::open(array('route' => 'drug.store', 'id' => 'form-create-drug')) !!}
-				<!-- CSRF Token -->
-                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-                <!-- ./ csrf token -->
-				<div class="form-group row">
-					{!! Form::label('name', trans_choice('terms.name',1), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
-					</div>
+				
+					{{ Form::label('name', Lang::choice('messages.name',1)) }}
+					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
 				</div>
-				<div class="form-group row">
-					{!! Form::label('description', trans("terms.description"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
-					<div class="col-sm-6">
-						{!! Form::textarea('description', old('description'), array('class' => 'form-control', 'rows' => '2')) !!}
-					</div>
+				
+					{{ Form::label('description', trans("messages.description")) }}</label>
+					{{ Form::textarea('description', Input::old('description'), 
+						array('class' => 'form-control', 'rows' => '2')) }}
 				</div>
-				<div class="form-group row col-sm-offset-2">
-					{!! Form::button("<i class='fa fa-plus-circle'></i> ".trans('action.save'), 
-						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
+				<div class="form-group actions-row">
+					{{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
+						array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
 				</div>
 
-			{!! Form::close() !!}
-	  	</div>
+			{{ Form::close() }}
+		</div>
 	</div>
-</div>
-@endsection	
\ No newline at end of file
+@stop	
\ No newline at end of file
diff --git a/resources/views/drug/edit.blade.php b/resources/views/drug/edit.blade.php
index 597ed1f..262bf20 100755
--- a/resources/views/drug/edit.blade.php
+++ b/resources/views/drug/edit.blade.php
@@ -1,61 +1,46 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li><a href="{!! route('drug.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.drug', 2) !!}</a></li>
-            <li class="active">{!! trans('action.edit').' '.trans_choice('menu.drug', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-edit"></i> {!! trans('action.edit').' '.trans_choice('menu.drug', 1) !!} 
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
+
+	@if (Session::has('message'))
+		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
+	
+	<div>
+		<ol class="breadcrumb">
+		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+		  <li>
+		  	<a href="{{ URL::route('drug.index') }}">{{ Lang::choice('messages.drug',1) }}</a>
+		  </li>
+		  <li class="active">{{ trans('messages.edit-drug') }}</li>
+		</ol>
+	</div>
+	<div class="panel panel-primary">
+		<div class="panel-heading ">
+			<span class="glyphicon glyphicon-edit"></span>
+			{{ trans('messages.edit-drug') }}
 		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
+		<div class="panel-body">
 			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
-
-			{!! Form::model($drug, array('route' => array('drug.update', $drug->id), 
-				'method' => 'PUT', 'id' => 'form-edit-drug')) !!}
-				<!-- CSRF Token -->
-                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-                <!-- ./ csrf token -->
-				<div class="form-group row">
-					{!! Form::label('name', trans_choice('terms.name',1), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
-					</div>
+				<div class="alert alert-danger">
+					{{ HTML::ul($errors->all()) }}
+				</div>
+			
+			{{ Form::model($drug, array('route' => array('drug.update', $drug->id), 
+				'method' => 'PUT', 'id' => 'form-edit-drug')) }}
+				
+					{{ Form::label('name', Lang::choice('messages.name',1)) }}
+					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
 				</div>
-				<div class="form-group row">
-					{!! Form::label('description', trans("terms.description"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
-					<div class="col-sm-6">
-						{!! Form::textarea('description', old('description'), array('class' => 'form-control', 'rows' => '2')) !!}
-					</div>
+				
+					{{ Form::label('description', trans('messages.description')) }}
+					{{ Form::textarea('description', Input::old('description'), 
+						array('class' => 'form-control', 'rows' => '2')) }}
 				</div>
-				<div class="form-group row col-sm-offset-2">
-					{!! Form::button("<i class='fa fa-check-circle'></i> ".trans('action.update'), 
-						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
+				<div class="form-group actions-row">
+					{{ Form::button('<span class="glyphicon glyphicon-save"></span> '. trans('messages.save'), 
+						['class' => 'btn btn-primary', 'onclick' => 'submit()']) }}
 				</div>
 
-			{!! Form::close() !!}
-	  	</div>
+			{{ Form::close() }}
+		</div>
 	</div>
-</div>
-@endsection
\ No newline at end of file
+@stop	
\ No newline at end of file
diff --git a/resources/views/drug/index.blade.php b/resources/views/drug/index.blade.php
index 557f350..b287cc4 100755
--- a/resources/views/drug/index.blade.php
+++ b/resources/views/drug/index.blade.php
@@ -1,89 +1,71 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li class="active"><i class="fa fa-cube"></i> {!! trans_choice('menu.drug', 2) !!}</li>
-        </ul>
-    </div>
+<div>
+	<ol class="breadcrumb">
+	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+	  <li class="active">{{ Lang::choice('messages.drug',1) }}</li>
+	</ol>
 </div>
-<div class="conter-wrapper">
-	<div class="row">
-		<div class="col-sm-12">
-			<div class="card">
-				<div class="card-header">
-				    <i class="fa fa-book"></i> {!! trans_choice('menu.drug', 2) !!} 
-				    <span>
-					    <a class="btn btn-sm btn-belize-hole" href="{!! url("drug/create") !!}" >
-							<i class="fa fa-plus-circle"></i>
-							{!! trans('action.new').' '.trans_choice('menu.drug', 1) !!}
-						</a>
-						<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-							<i class="fa fa-step-backward"></i>
-							{!! trans('action.back') !!}
-						</a>				
-					</span>
-				</div>
-			  	<div class="card-block">	  		
-					@if (Session::has('message'))
-						<div class="alert alert-info">{!! Session::get('message') !!}</div>
-					
-					@if($errors->all())
-		            <div class="alert alert-danger alert-dismissible" role="alert">
-		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-		            </div>
-		            
-				 	<table class="table table-bordered table-sm search-table">
-						<thead>
-							<tr>
-								<th>{!! trans('terms.name') !!}</th>
-								<th>{!! trans('terms.description') !!}</th>
-								<th></th>
-							</tr>
-						</thead>
-						<tbody>
-						@foreach($drugs as $key => $value)
-							<tr @if(session()->has('active_drug'))
-				                    {!! (session('active_drug') == $value->id)?"class='warning'":"" !!}
-				                
-				                >
-								<td>{!! $value->name !!}</td>
-								<td>{!! $value->description !!}</td>
-								
-								<td>
+@if (Session::has('message'))
+	<div class="alert alert-info">{{ Session::get('message') }}</div>
+
+<div class="panel panel-primary">
+	<div class="panel-heading ">
+		<span class="glyphicon glyphicon-adjust"></span>
+		{{ Lang::choice('messages.drug',1) }}
+		<div class="panel-btn">
+			<a class="btn btn-sm btn-info" href="{{ URL::to("drug/create") }}" >
+				<span class="glyphicon glyphicon-plus-sign"></span>
+				{{ trans('messages.create-drug') }}
+			</a>
+		</div>
+	</div>
+	<div class="panel-body">
+		<table class="table table-striped table-hover table-condensed search-table">
+			<thead>
+				<tr>
+					<th>{{ Lang::choice('messages.name',1) }}</th>
+					<th>{{ trans('messages.description') }}</th>
+					<th></th>
+				</tr>
+			</thead>
+			<tbody>
+			@foreach($drugs as $key => $value)
+				<tr @if(Session::has('activedrug'))
+                            {{(Session::get('activedrug') == $value->id)?"class='info'":""}}
+                        
+                        >
 
-								<!-- show the test category (uses the show method found at GET /drug/{id} -->
-									<a class="btn btn-sm btn-success" href="{!! url("drug/" . $value->id) !!}" >
-										<i class="fa fa-folder-open-o"></i>
-										{!! trans('action.view') !!}
-									</a>
+					<td>{{ $value->name }}</td>
+					<td>{{ $value->description }}</td>
+					
+					<td>
 
-								<!-- edit this test category (uses edit method found at GET /drug/{id}/edit -->
-									<a class="btn btn-sm btn-info" href="{!! url("drug/" . $value->id . "/edit") !!}" >
-										<i class="fa fa-edit"></i>
-										{!! trans('action.edit') !!}
-									</a>
-									
-								<!-- delete this test category (uses delete method found at GET /drug/{id}/delete -->
-									<button class="btn btn-sm btn-danger delete-item-link"
-										data-toggle="modal" data-target=".confirm-delete-modal"	
-										data-id='{!! url("drug/" . $value->id . "/delete") !!}'>
-										<i class="fa fa-trash-o"></i>
-										{!! trans('action.delete') !!}
-									</button>
-								</td>
-							</tr>
-						@endforeach
-						</tbody>
-					</table>
-			  	</div>
-			</div>
-		</div>
+					<!-- show the drug (uses the show method found at GET /drug/{id} -->
+						<a class="btn btn-sm btn-success" href="{{ URL::to("drug/" . $value->id) }}" >
+							<span class="glyphicon glyphicon-eye-open"></span>
+							{{ trans('messages.view') }}
+						</a>
+
+					<!-- edit this drug (uses edit method found at GET /drug/{id}/edit -->
+						<a class="btn btn-sm btn-info" href="{{ URL::to("drug/" . $value->id . "/edit") }}" >
+							<span class="glyphicon glyphicon-edit"></span>
+							{{ trans('messages.edit') }}
+						</a>
+						
+					<!-- delete this drug (uses delete method found at GET /drug/{id}/delete -->
+						<button class="btn btn-sm btn-danger delete-item-link"
+							data-toggle="modal" data-target=".confirm-delete-modal"	
+							data-id='{{ URL::to("drug/" . $value->id . "/delete") }}'>
+							<span class="glyphicon glyphicon-trash"></span>
+							{{ trans('messages.delete') }}
+						</button>
+					</td>
+				</tr>
+			@endforeach
+			</tbody>
+		</table>
+		{{ Session::put('SOURCE_URL', URL::full()) }}
 	</div>
-	{!! session(['SOURCE_URL' => URL::full()]) !!}
 </div>
-@endsection
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/drug/show.blade.php b/resources/views/drug/show.blade.php
index 30fa535..1d5e870 100755
--- a/resources/views/drug/show.blade.php
+++ b/resources/views/drug/show.blade.php
@@ -1,46 +1,35 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li><a href="{!! route('drug.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.drug', 2) !!}</a></li>
-            <li class="active">{!! trans('action.view').' '.trans_choice('menu.drug', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-file-text"></i> <strong>{!! trans('terms.details-for').': '.$drug->name !!}</strong>
-		    <span>
-		    	<a class="btn btn-sm btn-belize-hole" href="{!! url("drug/create") !!}" >
-					<i class="fa fa-plus-circle"></i>
-					{!! trans('action.new').' '.trans_choice('menu.drug', 1) !!}
-				</a>
-				<a class="btn btn-sm btn-info" href="{!! url("drug/" . $drug->id . "/edit") !!}" >
-					<i class="fa fa-edit"></i>
-					{!! trans('action.edit') !!}
+
+@if (Session::has('message'))
+	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
+
+
+	<div>
+		<ol class="breadcrumb">
+		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+		  <li><a href="{{ URL::route('drug.index') }}">{{ Lang::choice('messages.drug',1) }}</a></li>
+		  <li class="active">{{ trans('messages.drug-details') }}</li>
+		</ol>
+	</div>
+	<div class="panel panel-primary ">
+		<div class="panel-heading ">
+			<span class="glyphicon glyphicon-adjust"></span>
+			{{ trans('messages.drug-details') }}
+			<div class="panel-btn">
+				<a class="btn btn-sm btn-info" href="{{ URL::route('drug.edit', array($drug->id)) }}">
+					<span class="glyphicon glyphicon-edit"></span>
+					{{ trans('messages.edit') }}
 				</a>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>	  		
-		<!-- if there are creation errors, they will show here -->
-		@if($errors->all())
-			<div class="alert alert-danger">
-				{!! HTML::ul($errors->all()) !!}

-		
-
-		<ul class="list-group list-group-flush">
-		    <li class="list-group-item"><h4>{!! trans('terms.name').': ' !!}<small>{!! $drug->name !!}</small></h4></li>
-		    <li class="list-group-item"><h5>{!! trans('terms.description').': ' !!}<small>{!! $drug->description !!}</small></h5></li>
-	  	</ul>
+		</div>
+		<div class="panel-body">
+			<div class="display-details">
+				<h3 class="view"><strong>{{ Lang::choice('messages.name',1) }}:</strong>{{ $drug->name }} </h3>
+				<p class="view-striped"><strong>{{ trans('messages.description') }}:</strong>
+					{{ $drug->description }}</p>
+				
+			</div>
+		</div>
 	</div>
-</div>
-@endsection	
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/facility/create.blade.php b/resources/views/facility/create.blade.php
index 15cb1e2..b22c5a4 100755
--- a/resources/views/facility/create.blade.php
+++ b/resources/views/facility/create.blade.php
@@ -1,60 +1,38 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-toggle-off"></i> {!! trans('menu.lab-config') !!}</li>
-            <li><a href="{!! route('facility.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.facility', 2) !!}</a></li>
-            <li class="active">{!! trans('action.new').' '.trans_choice('menu.facility', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-pencil"></i> {!! trans('action.new').' '.trans_choice('menu.facility', 1) !!} 
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
+
+	<div>
+		<ol class="breadcrumb">
+		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+		  <li class="active"><a href="{{ URL::route('facility.index') }}">{{Lang::choice('messages.facility',2)}}</a></li>
+		  <li class="active">{{trans('messages.add-facility')}}</li>
+		</ol>
+	</div>
+	<div class="panel panel-primary">
+		<div class="panel-heading ">
+			<span class="glyphicon glyphicon-adjust"></span>
+			{{trans('messages.add-facility')}}
 		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
+		<div class="panel-body">
+		<!-- if there are creation errors, they will show here -->
 			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
-
-			{!! Form::open(array('route' => 'facility.store', 'id' => 'form-create-facility')) !!}
-				<!-- CSRF Token -->
-                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-                <!-- ./ csrf token -->
-				<div class="form-group row">
-					{!! Form::label('name', trans_choice('terms.name',1), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
-					</div>
+				<div class="alert alert-danger">
+					{{ HTML::ul($errors->all()) }}
 				</div>
-				<div class="form-group row">
-					{!! Form::label('contacts', trans("terms.contacts"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
-					<div class="col-sm-6">
-						{!! Form::textarea('contacts', old('contacts'), array('class' => 'form-control', 'rows' => '2')) !!}
-					</div>
+			
+
+			{{ Form::open(array('route' => 'facility.store', 'id' => 'form-add-facility')) }}
+
+				
+					{{ Form::label('name', Lang::choice('messages.name',2)) }}
+					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
 				</div>
-				<div class="form-group row col-sm-offset-2">
-					{!! Form::button("<i class='fa fa-plus-circle'></i> ".trans('action.save'), 
-						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
+				<div class="form-group actions-row">
+					{{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
+						array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
 				</div>
 
-			{!! Form::close() !!}
-	  	</div>
+			{{ Form::close() }}
+		</div>
 	</div>
-</div>
-@endsection	
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/facility/edit.blade.php b/resources/views/facility/edit.blade.php
index 173d86c..6aceeb6 100755
--- a/resources/views/facility/edit.blade.php
+++ b/resources/views/facility/edit.blade.php
@@ -1,61 +1,37 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-toggle-off"></i> {!! trans('menu.lab-config') !!}</li>
-            <li><a href="{!! route('facility.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.facility', 2) !!}</a></li>
-            <li class="active">{!! trans('action.edit').' '.trans_choice('menu.facility', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-edit"></i> {!! trans('action.edit').' '.trans_choice('menu.facility', 1) !!} 
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
+
+	<div>
+		<ol class="breadcrumb">
+		<li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+		<li class="active">{{Lang::choice('messages.facility',2)}}</li>
+		</ol>
+	</div>
+	@if (Session::has('message'))
+		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
+	
+	<div class="panel panel-primary">
+		<div class="panel-heading ">
+			<span class="glyphicon glyphicon-edit"></span>
+			{{ trans('messages.edit-facility') }}
 		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
+		<div class="panel-body">
 			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
-
-			{!! Form::model($facility, array('route' => array('facility.update', $facility->id), 
-				'method' => 'PUT', 'id' => 'form-edit-facility')) !!}
-				<!-- CSRF Token -->
-                <input type="hidden" name="_token" value="{!!{ csrf_token() !!}" />
-                <!-- ./ csrf token -->
-				<div class="form-group row">
-					{!! Form::label('name', trans_choice('terms.name',1), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
-					</div>
+				<div class="alert alert-danger">
+					{{ HTML::ul($errors->all()) }}
 				</div>
-				<div class="form-group row">
-					{!! Form::label('contacts', trans("terms.contacts"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
-					<div class="col-sm-6">
-						{!! Form::textarea('contacts', old('contacts'), array('class' => 'form-control', 'rows' => '2')) !!}
-					</div>
+			
+			{{ Form::model($facility, array('route' => array('facility.update', $facility->id),
+				'method' => 'PUT', 'id' => 'form-edit-facility')) }}
+				
+					{{ Form::label('name', trans('messages.name')) }}
+					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
 				</div>
-				<div class="form-group row col-sm-offset-2">
-					{!! Form::button("<i class='fa fa-check-circle'></i> ".trans('action.update'), 
-						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
+				<div class="form-group actions-row">
+					{{ Form::button('<span class="glyphicon glyphicon-save"></span> '. trans('messages.save'),
+						['class' => 'btn btn-primary', 'onclick' => 'submit()']) }}
 				</div>
-
-			{!! Form::close() !!}
-	  	</div>
+			{{ Form::close() }}
+		</div>
 	</div>
-</div>
-@endsection
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/facility/index.blade.php b/resources/views/facility/index.blade.php
index bca3636..4426c0d 100755
--- a/resources/views/facility/index.blade.php
+++ b/resources/views/facility/index.blade.php
@@ -1,89 +1,59 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-toggle-off"></i> {!! trans('menu.lab-config') !!}</li>
-            <li class="active"><i class="fa fa-cube"></i> {!! trans_choice('menu.facility', 2) !!}</li>
-        </ul>
-    </div>
+<div>
+	<ol class="breadcrumb">
+	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+	  <li class="active">{{Lang::choice('messages.facility',2)}}</li>
+	</ol>
 </div>
-<div class="conter-wrapper">
-	<div class="row">
-		<div class="col-sm-12">
-			<div class="card">
-				<div class="card-header">
-				    <i class="fa fa-book"></i> {!! trans_choice('menu.facility', 2) !!} 
-				    <span>
-					    <a class="btn btn-sm btn-belize-hole" href="{!! url("facility/create") !!}" >
-							<i class="fa fa-plus-circle"></i>
-							{!! trans('action.new').' '.trans_choice('menu.facility', 1) !!}
-						</a>
-						<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-							<i class="fa fa-step-backward"></i>
-							{!! trans('action.back') !!}
-						</a>				
-					</span>
-				</div>
-			  	<div class="card-block">	  		
-					@if (Session::has('message'))
-						<div class="alert alert-info">{!! Session::get('message') !!}</div>
-					
-					@if($errors->all())
-		            <div class="alert alert-danger alert-dismissible" role="alert">
-		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-		            </div>
-		            
-				 	<table class="table table-bordered table-sm search-table">
-						<thead>
-							<tr>
-								<th>{!! trans('terms.name') !!}</th>
-								<th>{!! trans('terms.contacts') !!}</th>
-								<th></th>
-							</tr>
-						</thead>
-						<tbody>
-						@foreach($facilities as $key => $value)
-							<tr @if(session()->has('active_facility'))
-				                    {!! (session('active_facility') == $value->id)?"class='warning'":"" !!}
-				                
-				                >
-								<td>{!! $value->name !!}</td>
-								<td>{!! $value->contacts !!}</td>
-								
-								<td>
-
-								<!-- show the test category (uses the show method found at GET /facility/{id} -->
-									<a class="btn btn-sm btn-success" href="{!! url("facility/" . $value->id) !!}" >
-										<i class="fa fa-folder-open-o"></i>
-										{!! trans('action.view') !!}
-									</a>
-
-								<!-- edit this test category (uses edit method found at GET /facility/{id}/edit -->
-									<a class="btn btn-sm btn-info" href="{!! url("facility/" . $value->id . "/edit") !!}" >
-										<i class="fa fa-edit"></i>
-										{!! trans('action.edit') !!}
-									</a>
-									
-								<!-- delete this test category (uses delete method found at GET /facility/{id}/delete -->
-									<button class="btn btn-sm btn-danger delete-item-link"
-										data-toggle="modal" data-target=".confirm-delete-modal"	
-										data-id='{!! url("facility/" . $value->id . "/delete") !!}'>
-										<i class="fa fa-trash-o"></i>
-										{!! trans('action.delete') !!}
-									</button>
-								</td>
-							</tr>
-						@endforeach
-						</tbody>
-					</table>
-			  	</div>
-			</div>
+@if (Session::has('message'))
+	<div class="alert alert-info">{{ Session::get('message') }}</div>
+
+<div class="panel panel-primary">
+	<div class="panel-heading ">
+		<span class="glyphicon glyphicon-adjust"></span>
+		{{ trans('messages.list-facilities') }}
+		<div class="panel-btn">
+			<a class="btn btn-sm btn-info" href="{{ URL::to("facility/create") }}" >
+				<span class="glyphicon glyphicon-plus-sign"></span>
+				{{ trans('messages.add-facility') }}
+			</a>
 		</div>
 	</div>
-	{!! session(['SOURCE_URL' => URL::full()]) !!}
+	<div class="panel-body">
+		<table class="table table-striped table-hover table-condensed search-table">
+			<thead>
+				<tr>
+					<th>{{ Lang::choice('messages.name', 1) }}</th>
+					<th></th>
+				</tr>
+			</thead>
+			<tbody>
+			@foreach($facilities as $facility)
+				<tr @if(Session::has('activefacility'))
+                            {{(Session::get('activefacility') == $facility->id)?"class='info'":""}}
+                        
+                    >
+					<td>{{ $facility->name }}</td>
+					<td>
+					<!-- edit this facility (uses edit method found at GET /facility/{id}/edit -->
+						<a class="btn btn-sm btn-info" href="{{ URL::to("facility/" . $facility->id . "/edit") }}" >
+							<span class="glyphicon glyphicon-edit"></span>
+							{{ trans('messages.edit') }}
+						</a>
+					<!-- delete this facility (uses delete method found at GET /facility/{id}/delete -->
+						<button class="btn btn-sm btn-danger delete-item-link"
+							data-toggle="modal" data-target=".confirm-delete-modal"
+							data-id='{{ URL::to("facility/" . $facility->id . "/delete") }}'>
+							<span class="glyphicon glyphicon-trash"></span>
+							{{ trans('messages.delete') }}
+						</button>
+					</td>
+				</tr>
+			@endforeach
+			</tbody>
+		</table>
+		{{ Session::put('SOURCE_URL', URL::full()) }}
+	</div>
 </div>
-@endsection
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/facility/show.blade.php b/resources/views/facility/show.blade.php
deleted file mode 100755
index 123a389..0000000
--- a/resources/views/facility/show.blade.php
+++ /dev/null
@@ -1,46 +0,0 @@
-@extends("app")
-
-@section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-toggle-off"></i> {!! trans('menu.lab-config') !!}</li>
-            <li><a href="{!! route('facility.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.facility', 2) !!}</a></li>
-            <li class="active">{!! trans('action.view').' '.trans_choice('menu.facility', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-file-text"></i> <strong>{!! trans('terms.details-for').': '.$facility->name !!}</strong>
-		    <span>
-		    	<a class="btn btn-sm btn-belize-hole" href="{!! url("facility/create") !!}" >
-					<i class="fa fa-plus-circle"></i>
-					{!! trans('action.new').' '.trans_choice('menu.facility', 1) !!}
-				</a>
-				<a class="btn btn-sm btn-info" href="{!! url("facility/" . $facility->id . "/edit") !!}" >
-					<i class="fa fa-edit"></i>
-					{!! trans('action.edit') !!}
-				</a>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>	  		
-		<!-- if there are creation errors, they will show here -->
-		@if($errors->all())
-			<div class="alert alert-danger">
-				{!! HTML::ul($errors->all()) !!}
-			</div>
-		
-
-		<ul class="list-group list-group-flush">
-		    <li class="list-group-item"><h4>{!! trans('terms.name').': ' !!}<small>{!! $facility->name !!}</small></h4></li>
-		    <li class="list-group-item"><h5>{!! trans('terms.contacts').': ' !!}<small>{!! $facility->contacts !!}</small></h5></li>
-	  	</ul>
-	</div>
-</div>
-@endsection	
\ No newline at end of file
diff --git a/resources/views/home.blade.php b/resources/views/home.blade.php
deleted file mode 100755
index 63320ac..0000000
--- a/resources/views/home.blade.php
+++ /dev/null
@@ -1,322 +0,0 @@
-@extends('app')
-
-@section('content')
-<div class="page-title clearfix">
-<ol class="breadcrumb">
-<li class="active">Blank</li>
-<li><a href="http://dashy.strapui.com/laravel"><i class="fa fa-tachometer"></i></a></li>
-</ol>
-</div>
-<div class="conter-wrapper">
-<div class="row">
-<div class="col-md-6">
-<div class="panel panel-primary">
-<div class="panel-heading">
-<h3 class="panel-title">Regular Table
-<div class="panel-control pull-right hidden">
-<a class="panelButton"><i class="fa fa-refresh"></i></a>
-<a class="panelButton"><i class="fa fa-minus"></i></a>
-<a class="panelButton"><i class="fa fa-remove"></i></a>
-</div>
-</h3>
-</div>
-<div class="panel-body">
-<table class="table ">
-<thead>
-<tr>
-<th>Name</th>
-<th>Email</th>
-<th>Address</th>
-</tr>
-</thead>
-<tbody>
-<tr>
-<td>John</td>
-<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="6a000502042a0d070b030644090507">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
-/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
-<td>London, UK</td>
-</tr>
-<tr>
-<td>Andy</td>
-<td>andygmail.com</td>
-<td>Merseyside, UK</td>
-</tr>
-<tr>
-<td>Frank</td>
-<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="97f1e5f6f9fcd7f0faf6fefbb9f4f8fa">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
-/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
-<td>Southampton, UK</td>
-</tr>
-</tbody>
-</table> </div>
-</div>
-</div>
-<div class="col-md-6">
-<div class="panel panel-default">
-<div class="panel-heading">
-<h3 class="panel-title">Bordered Table
-<div class="panel-control pull-right hidden">
-<a class="panelButton"><i class="fa fa-refresh"></i></a>
-<a class="panelButton"><i class="fa fa-minus"></i></a>
-<a class="panelButton"><i class="fa fa-remove"></i></a>
-</div>
-</h3>
-</div>
-<div class="panel-body">
-<table class="table table-bordered">
-<thead>
-<tr>
-<th>Name</th>
-<th>Email</th>
-<th>Address</th>
-</tr>
-</thead>
-<tbody>
-<tr>
-<td>John</td>
-<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="fd97929593bd9a909c9491d39e9290">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
-/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
-<td>London, UK</td>
-</tr>
-<tr>
-<td>Andy</td>
-<td>andygmail.com</td>
-<td>Merseyside, UK</td>
-</tr>
-<tr>
-<td>Frank</td>
-<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="294f5b484742694e44484045074a4644">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
-/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
-<td>Southampton, UK</td>
-</tr>
-</tbody>
-</table> </div>
-</div>
-</div>
-</div>
-<div class="row">
-<div class="col-md-6">
-<div class="panel panel-info">
-<div class="panel-heading">
-<h3 class="panel-title">Striped Table
-<div class="panel-control pull-right hidden">
-<a class="panelButton"><i class="fa fa-refresh"></i></a>
-<a class="panelButton"><i class="fa fa-minus"></i></a>
-<a class="panelButton"><i class="fa fa-remove"></i></a>
-</div>
-</h3>
-</div>
-<div class="panel-body">
-<table class="table table-striped">
-<thead>
-<tr>
-<th>Name</th>
-<th>Email</th>
-<th>Address</th>
-</tr>
-</thead>
-<tbody>
-<tr>
-<td>John</td>
-<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="d7bdb8bfb997b0bab6bebbf9b4b8ba">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
-/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
-<td>London, UK</td>
-</tr>
-<tr>
-<td>Andy</td>
-<td>andygmail.com</td>
-<td>Merseyside, UK</td>
-</tr>
-<tr>
-<td>Frank</td>
-<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="92f4e0f3fcf9d2f5fff3fbfebcf1fdff">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
-/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
-<td>Southampton, UK</td>
-</tr>
-</tbody>
-</table> </div>
-</div>
-</div>
-<div class="col-md-6">
-<div class="panel panel-success">
-<div class="panel-heading">
-<h3 class="panel-title">Hover Table
-<div class="panel-control pull-right hidden">
-<a class="panelButton"><i class="fa fa-refresh"></i></a>
-<a class="panelButton"><i class="fa fa-minus"></i></a>
-<a class="panelButton"><i class="fa fa-remove"></i></a>
-</div>
-</h3>
-</div>
-<div class="panel-body">
-<table class="table table-hover">
-<thead>
-<tr>
-<th>Name</th>
-<th>Email</th>
-<th>Address</th>
-</tr>
-</thead>
-<tbody>
-<tr>
-<td>John</td>
-<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="8de7e2e5e3cdeae0ece4e1a3eee2e0">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
-/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
-<td>London, UK</td>
-</tr>
-<tr>
-<td>Andy</td>
-<td>andygmail.com</td>
-<td>Merseyside, UK</td>
-</tr>
-<tr>
-<td>Frank</td>
-<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="791f0b181712391e14181015571a1614">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
-/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
-<td>Southampton, UK</td>
-</tr>
-</tbody>
-</table> </div>
-</div>
-</div>
-</div>
-<div class="row">
-<div class="col-md-6">
-<div class="panel panel-danger">
-<div class="panel-heading">
-<h3 class="panel-title">Condensed Table
-<div class="panel-control pull-right hidden">
-<a class="panelButton"><i class="fa fa-refresh"></i></a>
-<a class="panelButton"><i class="fa fa-minus"></i></a>
-<a class="panelButton"><i class="fa fa-remove"></i></a>
-</div>
-</h3>
-</div>
-<div class="panel-body">
-<table class="table table-condensed">
-<thead>
-<tr>
-<th>Name</th>
-<th>Email</th>
-<th>Address</th>
-</tr>
-</thead>
-<tbody>
-<tr>
-<td>John</td>
-<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="fa90959294ba9d979b9396d4999597">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
-/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
-<td>London, UK</td>
-</tr>
-<tr>
-<td>Andy</td>
-<td>andygmail.com</td>
-<td>Merseyside, UK</td>
-</tr>
-<tr>
-<td>Frank</td>
-<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="cbadb9aaa5a08baca6aaa2a7e5a8a4a6">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
-/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
-<td>Southampton, UK</td>
-</tr>
-</tbody>
-</table> </div>
-</div>
-</div>
-<div class="col-md-6">
-<div class="panel panel-warning">
-<div class="panel-heading">
-<h3 class="panel-title">Condensed, Bordered, Striped Table
-<div class="panel-control pull-right hidden">
-<a class="panelButton"><i class="fa fa-refresh"></i></a>
-<a class="panelButton"><i class="fa fa-minus"></i></a>
-<a class="panelButton"><i class="fa fa-remove"></i></a>
-</div>
-</h3>
-</div>
-<div class="panel-body">
-<table class="table table-condensed table-bordered table-striped">
-<thead>
-<tr>
-<th>Name</th>
-<th>Email</th>
-<th>Address</th>
-</tr>
-</thead>
-<tbody>
-<tr>
-<td>John</td>
-<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="6903060107290e04080005470a0604">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
-/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
-<td>London, UK</td>
-</tr>
-<tr>
-<td>Andy</td>
-<td>andygmail.com</td>
-<td>Merseyside, UK</td>
-</tr>
-<tr>
-<td>Frank</td>
-<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="f89e8a999693b89f95999194d69b9795">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
-/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
-<td>Southampton, UK</td>
-</tr>
-</tbody>
-</table> </div>
-</div>
-</div>
-</div>
-<div class="row">
-<div class="col-sm-12">
-<div class="panel panel-default">
-<div class="panel-heading">
-<h3 class="panel-title">Coloured Table
-<div class="panel-control pull-right hidden">
-<a class="panelButton"><i class="fa fa-refresh"></i></a>
-<a class="panelButton"><i class="fa fa-minus"></i></a>
-<a class="panelButton"><i class="fa fa-remove"></i></a>
-</div>
-</h3>
-</div>
-<div class="panel-body">
-<table class="table table-bordered white">
-<thead>
-<tr>
-<th>Name</th>
-<th>Email</th>
-<th>Address</th>
-</tr>
-</thead>
-<tbody>
-<tr class="success">
-<td>John</td>
-<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="650f0a0d0b250208040c094b060a08">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
-/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
-<td>London, UK</td>
-</tr>
-<tr class="info">
-<td>Andy</td>
-<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="f69798928fb6919b979f9ad895999b">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
-/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
-<td>Merseyside, UK</td>
-</tr>
-<tr class="warning">
-<td>Frank</td>
-<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="d0b6a2b1bebb90b7bdb1b9bcfeb3bfbd">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
-/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
-<td>Southampton, UK</td>
-</tr>
-<tr class="danger">
-<td>Rickie</td>
-<td><a class="__cf_email__" href="http://dashy.strapui.com/cdn-cgi/l/email-protection" data-cfemail="6d1f040e0604082d0a000c0401430e0200">[email&#160;protected]</a><script data-cfhash='f9e31' type="text/javascript">
-/* <![CDATA[ */!function(){try{var t="currentScript"in document?document.currentScript:function(){for(var t=document.getElementsByTagName("script"),e=t.length;e--;)if(t[e].getAttribute("data-cfhash"))return t[e]}();if(t&&t.previousSibling){var e,r,n,i,c=t.previousSibling,a=c.getAttribute("data-cfemail");if(a){for(e="",r=parseInt(a.substr(0,2),16),n=2;a.length-n;n+=2)i=parseInt(a.substr(n,2),16)^r,e+=String.fromCharCode(i);e=document.createTextNode(e),c.parentNode.replaceChild(e,c)}t.parentNode.removeChild(t);}}catch(u){}}()/* ]]> */</script></td>
-<td>Burnley, UK</td>
-</tr>
-</tbody>
-</table>
-</div>
-</div>
-</div>
-</div>
-</div>
-@endsection
diff --git a/resources/views/instrument/create.blade.php b/resources/views/instrument/create.blade.php
index 7723bd9..6c45e11 100755
--- a/resources/views/instrument/create.blade.php
+++ b/resources/views/instrument/create.blade.php
@@ -1,47 +1,47 @@
-@extends("app")
+@extends("layout")
 @section("content")
 <div>
 	<ol class="breadcrumb">
-	  <li><a href="{!! URL::route('user.home')!!}">{!!trans('messages.home')!!}</a></li>
-	  <li><a href="{!! URL::route('instrument.index') !!}">{!!trans_choice('messages.instrument',2)!!}</a></li>
-	  <li class="active">{!!trans('messages.add-instrument')!!}</li>
+	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+	  <li><a href="{{ URL::route('instrument.index') }}">{{Lang::choice('messages.instrument',2)}}</a></li>
+	  <li class="active">{{trans('messages.add-instrument')}}</li>
 	</ol>
 </div>
 <div class="panel panel-primary">
 	<div class="panel-heading ">
 		<span class="glyphicon glyphicon-cog"></span>
-		{!!trans('messages.add-instrument')!!}
+		{{trans('messages.add-instrument')}}
 	</div>
-	{!! Form::open(array('route' => array('instrument.index'), 'id' => 'form-add-instrument')) !!}
+	{{ Form::open(array('route' => array('instrument.index'), 'id' => 'form-add-instrument')) }}
 		<div class="panel-body">
 		<!-- if there are creation errors, they will show here -->
 			
 			@if($errors->all())
 				<div class="alert alert-danger">
-					{!! HTML::ul($errors->all()) !!}
+					{{ HTML::ul($errors->all()) }}
 				</div>
 			

-				{!! Form::label('name', trans_choice('messages.name',1)) !!}
-                {!! Form::text('name', Input::old('name'), array('class' => 'form-control')) !!}
+				{{ Form::label('name', Lang::choice('messages.name',1)) }}
+                {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}


-				{!! Form::label('description', trans('messages.description')) !!}
-				{!! Form::textarea('description', Input::old('description'), 
-					array('class' => 'form-control', 'rows' => '3' )) !!}
+				{{ Form::label('description', trans('messages.description')) }}
+				{{ Form::textarea('description', Input::old('description'), 
+					array('class' => 'form-control', 'rows' => '3' )) }}

 		</div>
 		<div class="panel-footer">
 			<div class="form-group actions-row">
-				{!! Form::button(
+				{{ Form::button(
 					'<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'),
 					[
 						'class' => 'btn btn-primary', 
 						'onclick' => 'submit()'
 					] 
-				) !!}
+				) }}

 		</div>
-	{!! Form::close() !!}
+	{{ Form::close() }}
 </div>
 @stop
\ No newline at end of file
diff --git a/resources/views/instrument/edit.blade.php b/resources/views/instrument/edit.blade.php
index b323140..890ebea 100755
--- a/resources/views/instrument/edit.blade.php
+++ b/resources/views/instrument/edit.blade.php
@@ -1,61 +1,61 @@
-@extends("app")
+@extends("layout")
 @section("content")
 <div>
 	<ol class="breadcrumb">
-	  <li><a href="{!! URL::route('user.home')!!}">{!!trans('messages.home')!!}</a></li>
-	  <li><a href="{!! URL::route('instrument.index') !!}">{!!trans_choice('messages.instrument',2)!!}</a></li>
-	  <li class="active">{!!trans('messages.edit-instrument')!!}</li>
+	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+	  <li><a href="{{ URL::route('instrument.index') }}">{{Lang::choice('messages.instrument',2)}}</a></li>
+	  <li class="active">{{trans('messages.edit-instrument')}}</li>
 	</ol>
 </div>
 <div class="panel panel-primary">
 	<div class="panel-heading ">
 		<span class="glyphicon glyphicon-edit"></span>
-		{!!trans('messages.edit-instrument')!!}
+		{{trans('messages.edit-instrument')}}
 	</div>
-	{!! Form::model($instrument, array(
+	{{ Form::model($instrument, array(
 			'route' => array('instrument.update', $instrument->id), 'method' => 'PUT',
 			'id' => 'form-edit-instrument'
-		)) !!}
+		)) }}
 		<div class="panel-body">
 			@if($errors->all())
 				<div class="alert alert-danger">
-					{!! HTML::ul($errors->all()) !!}
+					{{ HTML::ul($errors->all()) }}
 				</div>
 			
 

-				{!! Form::label('name', trans_choice('messages.name',1)) !!}
-				{!! Form::text('name', Input::old('name'), array('class' => 'form-control')) !!}
+				{{ Form::label('name', Lang::choice('messages.name',1)) }}
+				{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}


-				{!! Form::label('description', trans('messages.description')) !!}
-				{!! Form::textarea('description', Input::old('description'), 
-					array('class' => 'form-control', 'rows' => '2' )) !!}
+				{{ Form::label('description', trans('messages.description')) }}
+				{{ Form::textarea('description', Input::old('description'), 
+					array('class' => 'form-control', 'rows' => '2' )) }}


-				{!! Form::label('ip', trans('messages.ip')) !!}
-				{!! Form::text('ip', Input::old('ip'), array('class' => 'form-control')) !!}
+				{{ Form::label('ip', trans('messages.ip')) }}
+				{{ Form::text('ip', Input::old('ip'), array('class' => 'form-control')) }}


-				{!! Form::label('hostname', trans('messages.host-name')) !!}
-				{!! Form::text('hostname', Input::old('hostname'), array('class' => 'form-control')) !!}
+				{{ Form::label('hostname', trans('messages.host-name')) }}
+				{{ Form::text('hostname', Input::old('hostname'), array('class' => 'form-control')) }}


-				{!! Form::label('test_types', trans('messages.supported-test-types')) !!}
-				{!! Form::text('test_types', implode(",", $instrument->testTypes()->lists('name')),
-					 array('class' => 'form-control', 'readonly')) !!}
+				{{ Form::label('test_types', trans('messages.supported-test-types')) }}
+				{{ Form::text('test_types', implode(",", $instrument->testTypes()->lists('name')),
+					 array('class' => 'form-control', 'readonly')) }}

 		</div>
 		<div class="panel-footer">
 			<div class="form-group actions-row">
-				{!! Form::button('<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'), 
+				{{ Form::button('<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'), 
 					['class' => 'btn btn-primary', 'onclick' => 'submit()']
-				) !!}
-				{!! Form::button(trans('messages.cancel'), 
+				) }}
+				{{ Form::button(trans('messages.cancel'), 
 					['class' => 'btn btn-default', 'onclick' => 'javascript:history.go(-1)']
-				) !!}
+				) }}

 		</div>
-	{!! Form::close() !!}
+	{{ Form::close() }}
 </div>
 @stop
\ No newline at end of file
diff --git a/resources/views/instrument/index.blade.php b/resources/views/instrument/index.blade.php
index d4ac8f0..eafacdc 100755
--- a/resources/views/instrument/index.blade.php
+++ b/resources/views/instrument/index.blade.php
@@ -1,31 +1,31 @@
-@extends("app")
+@extends("layout")
 @section("content")
 <div>
 	<ol class="breadcrumb">
-	  <li><a href="{!! URL::route('user.home')!!}">{!!trans('messages.home')!!}</a></li>
-	  <li class="active">{!!trans_choice('messages.instrument',2)!!}</li>
+	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+	  <li class="active">{{Lang::choice('messages.instrument',2)}}</li>
 	</ol>
 </div>
 @if (Session::has('message'))
-	<div class="alert alert-info">{!! trans(Session::get('message')) !!}</div>
+	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
 
 @if($errors->all())
 	<div class="alert alert-danger">
-		{!! HTML::ul($errors->all()) !!}
+		{{ HTML::ul($errors->all()) }}
 	</div>
 
 <div class="panel panel-primary">
 	<div class="panel-heading ">
 		<span class="glyphicon glyphicon-cog"></span>
-		{!!trans('messages.list-instruments')!!}
+		{{trans('messages.list-instruments')}}
 		<div class="panel-btn">
-			<a class="btn btn-sm btn-info" href="{!! URL::route('instrument.create') !!}" >
+			<a class="btn btn-sm btn-info" href="{{ URL::route('instrument.create') }}" >
 				<span class="glyphicon glyphicon-plus-sign"></span>
-				{!!trans('messages.new-instrument')!!}
+				{{trans('messages.new-instrument')}}
 			</a>
 			<a class="btn btn-sm btn-info" href="#import-driver-modal" data-toggle="modal">
 				<span class="glyphicon glyphicon-cog"></span>
-				{!!trans('messages.new-instrument-driver')!!}
+				{{trans('messages.new-instrument-driver')}}
 			</a>
 		</div>
 	</div>
@@ -33,38 +33,38 @@
 		<table class="table table-striped table-hover table-condensed search-table">
 			<thead>
 				<tr>
-					<th>{!!trans_choice('messages.name',1)!!}</th>
-					<th>{!!trans('messages.ip')!!}</th>
-					<th>{!!trans('messages.host-name')!!}</th>
-					<th>{!!trans('messages.actions')!!}</th>
+					<th>{{Lang::choice('messages.name',1)}}</th>
+					<th>{{trans('messages.ip')}}</th>
+					<th>{{trans('messages.host-name')}}</th>
+					<th>{{trans('messages.actions')}}</th>
 				</tr>
 			</thead>
 			<tbody>
 			@foreach($instruments as $key => $value)
 				<tr>
-					<td>{!! $value->name !!}</td>
-					<td>{!! $value->ip !!}</td>
-					<td>{!! $value->hostname !!}</td>
+					<td>{{ $value->name }}</td>
+					<td>{{ $value->ip }}</td>
+					<td>{{ $value->hostname }}</td>
 
 					<td>
 
 						<!-- show the instrument details -->
-						<a class="btn btn-sm btn-success" href="{!! URL::route('instrument.show', array($value->id)) !!}">
+						<a class="btn btn-sm btn-success" href="{{ URL::route('instrument.show', array($value->id)) }}">
 							<span class="glyphicon glyphicon-eye-open"></span>
-							{!!trans('messages.view')!!}
+							{{trans('messages.view')}}
 						</a>
 
 						<!-- edit this instrument  -->
-						<a class="btn btn-sm btn-info" href="{!! URL::route('instrument.edit', array($value->id)) !!}" >
+						<a class="btn btn-sm btn-info" href="{{ URL::route('instrument.edit', array($value->id)) }}" >
 							<span class="glyphicon glyphicon-edit"></span>
-							{!!trans('messages.edit')!!}
+							{{trans('messages.edit')}}
 						</a>
 						<!-- delete this instrument -->
 						<button class="btn btn-sm btn-danger delete-item-link"
 							data-toggle="modal" data-target=".confirm-delete-modal"	
-							data-id="{!! URL::route('instrument.delete', array($value->id)) !!}">
+							data-id="{{ URL::route('instrument.delete', array($value->id)) }}">
 							<span class="glyphicon glyphicon-trash"></span>
-							{!!trans('messages.delete')!!}
+							{{trans('messages.delete')}}
 						</button>
 
 					</td>
@@ -72,7 +72,7 @@
 			@endforeach
 			</tbody>
 		</table>
-		{!!$instruments->render()!!}
+		{{$instruments->links()}}
 	</div>
 </div>
 
@@ -80,34 +80,34 @@
     <div class="modal fade" id="import-driver-modal">
       <div class="modal-dialog">
         <div class="modal-content">
-        {!! Form::open(array('route' => 'instrument.importDriver', 'files' => true)) !!}
+        {{ Form::open(array('route' => 'instrument.importDriver', 'files' => true)) }}
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal">
                 <span aria-hidden="true">&times;</span>
-                <span class="sr-only">{!!trans('messages.close')!!}</span>
+                <span class="sr-only">{{trans('messages.close')}}</span>
             </button>
             <h4 class="modal-title">
                 <span class="glyphicon glyphicon-transfer"></span>
-                {!!trans('messages.import-instrument-driver-title')!!}</h4>
+                {{trans('messages.import-instrument-driver-title')}}</h4>
           </div>
           <div class="modal-body">
 				<div class="alert alert-danger" role="alert">
 				  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
-				  <span class="sr-only">{!!trans('messages.error')!!}:</span>
-				  {!!trans('messages.import-trusted-sources-only')!!}
+				  <span class="sr-only">{{trans('messages.error')}}:</span>
+				  {{trans('messages.import-trusted-sources-only')}}
 				</div>

-                	{!! Form::label('import_file', trans('messages.driver-file')) !!}
-                    {!! Form::file("import_file") !!}
+                	{{ Form::label('import_file', trans('messages.driver-file')) }}
+                    {{ Form::file("import_file") }}
                 </div>
           </div>
           <div class="modal-footer">
-            {!! Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'),
-                array('class' => 'btn btn-primary', 'data-dismiss' => 'modal', 'onclick' => 'submit()')) !!}
+            {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'),
+                array('class' => 'btn btn-primary', 'data-dismiss' => 'modal', 'onclick' => 'submit()')) }}
             <button type="button" class="btn btn-default" data-dismiss="modal">
-                {!!trans('messages.close')!!}</button>
+                {{trans('messages.close')}}</button>
           </div>
-        {!! Form::close() !!}
+        {{ Form::close() }}
         </div><!-- /.modal-content -->
       </div><!-- /.modal-dialog -->
     </div><!-- /.modal /#import-driver-modal-->
diff --git a/resources/views/instrument/show.blade.php b/resources/views/instrument/show.blade.php
index 881246d..aaa73a1 100755
--- a/resources/views/instrument/show.blade.php
+++ b/resources/views/instrument/show.blade.php
@@ -1,36 +1,36 @@
-@extends("app")
+@extends("layout")
 @section("content")
 	<div>
 		<ol class="breadcrumb">
-		  <li><a href="{!! URL::route('user.home')!!}">{!!trans('messages.home')!!}</a></li>
-		  <li><a href="{!! URL::route('instrument.index') !!}">{!!trans_choice('messages.instrument',2)!!}</a></li>
-		  <li class="active">{!!trans('messages.instrument-details')!!}</li>
+		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+		  <li><a href="{{ URL::route('instrument.index') }}">{{Lang::choice('messages.instrument',2)}}</a></li>
+		  <li class="active">{{trans('messages.instrument-details')}}</li>
 		</ol>
 	</div>
 	<div class="panel panel-primary">
 		<div class="panel-heading ">
 			<span class="glyphicon glyphicon-cog"></span>
-			{!!trans('messages.instrument-details')!!}
+			{{trans('messages.instrument-details')}}
 			<div class="panel-btn">
-				<a class="btn btn-sm btn-info" href="{!! URL::route('instrument.edit', array($instrument->id)) !!}">
+				<a class="btn btn-sm btn-info" href="{{ URL::route('instrument.edit', array($instrument->id)) }}">
 					<span class="glyphicon glyphicon-edit"></span>
-					{!!trans('messages.edit')!!}
+					{{trans('messages.edit')}}
 				</a>

 		</div>
 		<div class="panel-body">
 			<div class="display-details">
-				<h3 class="view"><strong>{!!trans_choice('messages.name',1)!!}</strong>{!! $instrument->name !!} </h3>
-				<p class="view-striped"><strong>{!!trans('messages.description')!!}</strong>
-					{!! $instrument->description !!}</p>
-				<p class="view"><strong>{!!trans('messages.ip')!!}</strong>
-					{!! $instrument->ip !!}</p>
-				<p class="view-striped"><strong>{!!trans('messages.host-name')!!}</strong>
-					{!! $instrument->hostname !!}</p>
-				<p class="view-striped"><strong>{!!trans('messages.compatible-test-types')!!}</strong>
-					{!! implode(", ", $instrument->testTypes->lists('name')) !!}</p>
-				<p class="view-striped"><strong>{!!trans('messages.date-created')!!}</strong>
-					{!! $instrument->created_at !!}</p>
+				<h3 class="view"><strong>{{Lang::choice('messages.name',1)}}</strong>{{ $instrument->name }} </h3>
+				<p class="view-striped"><strong>{{trans('messages.description')}}</strong>
+					{{ $instrument->description }}</p>
+				<p class="view"><strong>{{trans('messages.ip')}}</strong>
+					{{ $instrument->ip }}</p>
+				<p class="view-striped"><strong>{{trans('messages.host-name')}}</strong>
+					{{ $instrument->hostname }}</p>
+				<p class="view-striped"><strong>{{trans('messages.compatible-test-types')}}</strong>
+					{{ implode(", ", $instrument->testTypes->lists('name')) }}</p>
+				<p class="view-striped"><strong>{{trans('messages.date-created')}}</strong>
+					{{ $instrument->created_at }}</p>

 		</div>
 	</div>
diff --git a/resources/views/lot/create.blade.php b/resources/views/lot/create.blade.php
index 328faeb..80eaef3 100755
--- a/resources/views/lot/create.blade.php
+++ b/resources/views/lot/create.blade.php
@@ -1,59 +1,54 @@
-@extends("app")
+@extends("layout")
 @section("content")
 <div>
 	<ol class="breadcrumb">
-	  <li><a href="{!! URL::route('user.home')!!}">{!!trans('messages.home')!!}</a></li>
-	  <li><a href="{!! URL::route('instrument.index') !!}">{!!trans_choice('messages.lot',2)!!}</a></li>
-	  <li class="active">{!!trans('messages.add-lot')!!}</li>
+	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+	  <li><a href="{{ URL::route('instrument.index') }}">{{Lang::choice('messages.lot',2)}}</a></li>
+	  <li class="active">{{trans('messages.add-lot')}}</li>
 	</ol>
 </div>
 <div class="panel panel-primary">
 	<div class="panel-heading ">
 		<span class="glyphicon glyphicon-cog"></span>
-		{!!trans('messages.add-lot')!!}
+		{{trans('messages.add-lot')}}
 	</div>
-	{!! Form::open(array('route' => array('lot.index'), 'id' => 'form-add-lot')) !!}
+	{{ Form::open(array('route' => array('lot.index'), 'id' => 'form-add-lot')) }}
 		<div class="panel-body" id="lot-create">
 		<!-- if there are creation errors, they will show here -->
 			
 			@if($errors->all())
 				<div class="alert alert-danger">
-					{!! HTML::ul($errors->all()) !!}
+					{{ HTML::ul($errors->all()) }}
 				</div>
 			

-				{!! Form::label('number', trans_choice('messages.lot-number',1)) !!}
-                {!! Form::text('number', Input::old('number'), array('class' => 'form-control')) !!}
+				{{ Form::label('number', trans('messages.lot-number')) }}
+                {{ Form::text('lot_no', Input::old('lot_no'), array('class' => 'form-control')) }}


-				{!! Form::label('description', trans('messages.description')) !!}
-				{!! Form::textarea('description', Input::old('description'), 
-					array('class' => 'form-control', 'rows' => '3' )) !!}
+				{{ Form::label('description', trans('messages.description')) }}
+				{{ Form::textarea('description', Input::old('description'), 
+					array('class' => 'form-control', 'rows' => '3' )) }}


-				{!! Form::label('expiry', trans('messages.expiry-date')) !!}
-				{!! Form::text('expiry', Input::old('expiry'), 
-					array('class' => 'form-control standard-datepicker', 'rows' => '3' )) !!}
-			</div>
-			
-				{!! Form::label('instruments', trans_choice('messages.instrument', 2)) !!}
-				{!! Form::select('instrument', $instruments, Input::old('instrument'), 
-					array('class' => 'form-control')) !!}
+				{{ Form::label('expiry', trans('messages.expiry')) }}
+				{{ Form::text('expiry', Input::old('expiry'), 
+					array('class' => 'form-control standard-datepicker', 'rows' => '3' )) }}

 			<div class="form-group" id="edit-control-ranges">

 		</div>
 		<div class="panel-footer">
 			<div class="form-group actions-row">
-				{!! Form::button(
+				{{ Form::button(
 					'<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'),
 					[
 						'class' => 'btn btn-primary', 
 						'onclick' => 'submit()'
 					] 
-				) !!}
+				) }}

 		</div>
-	{!! Form::close() !!}
+	{{ Form::close() }}
 </div>
 @stop
\ No newline at end of file
diff --git a/resources/views/lot/edit.blade.php b/resources/views/lot/edit.blade.php
index db97e06..b2778ca 100755
--- a/resources/views/lot/edit.blade.php
+++ b/resources/views/lot/edit.blade.php
@@ -1,51 +1,46 @@
-@extends("app")
+@extends("layout")
 @section("content")
 
 	<div>
 		<ol class="breadcrumb">
-		<li><a href="{!! URL::route('user.home')!!}">{!! trans('messages.home') !!}</a></li>
-		<li><a href="{!! URL::route('lot.index')!!}">{!!trans_choice('messages.lot',2)!!}</a></li>
-		<li class="active">{!!trans('messages.edit-lot')!!}</li>
+		<li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+		<li><a href="{{{URL::route('lot.index')}}}">{{Lang::choice('messages.lot',2)}}</a></li>
+		<li class="active">{{trans('messages.edit-lot')}}</li>
 		</ol>
 	</div>
 	@if (Session::has('message'))
-		<div class="alert alert-info">{!! trans(Session::get('message')) !!}</div>
+		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
 	
 	<div class="panel panel-primary">
 		<div class="panel-heading ">
 			<span class="glyphicon glyphicon-edit"></span>
-			{!! trans('messages.edit-lot') !!}
+			{{ trans('messages.edit-lot') }}
 		</div>
 		<div class="panel-body">
 			@if($errors->all())
 				<div class="alert alert-danger">
-					{!! HTML::ul($errors->all()) !!}
+					{{ HTML::ul($errors->all()) }}
 				</div>
 			
-			{!! Form::model($lot, array('route' => array('lot.update', $lot->id), 'method' => 'PUT', 'id' => 'form-edit-lot')) !!}
+			{{ Form::model($lot, array('route' => array('lot.update', $lot->id), 'method' => 'PUT', 'id' => 'form-edit-lot')) }}
 				
-					{!! Form::label('number', trans('messages.lot-number')) !!}
-					{!! Form::text('number', Input::old('number'), array('class' => 'form-control')) !!}
+					{{ Form::label('number', trans('messages.lot-number')) }}
+					{{ Form::text('lot_no', Input::old('lot_no'), array('class' => 'form-control')) }}
 				</div>

-					{!! Form::label('description', trans('messages.description')) !!}
-					{!! Form::textarea('description', Input::old('description'), array('class' => 'form-control', 'rows' => '3' )) !!}
+					{{ Form::label('description', trans('messages.description')) }}
+					{{ Form::textarea('description', Input::old('description'), array('class' => 'form-control', 'rows' => '3' )) }}
 				</div>

-				{!! Form::label('expiry', trans('messages.expiry-date')) !!}
-				{!! Form::text('expiry', Input::old('expiry'), 
-					array('class' => 'form-control standard-datepicker', 'rows' => '3' )) !!}
-				</div>
-				
-					{!! Form::label('instruments', trans_choice('messages.instrument', 1)) !!}
-					{!! Form::select('instrument', $instruments, Input::old('instrument'), 
-					array('class' => 'form-control')) !!}
+				{{ Form::label('expiry', trans('messages.expiry')) }}
+				{{ Form::text('expiry', Input::old('expiry'), 
+					array('class' => 'form-control standard-datepicker', 'rows' => '3' )) }}
 				</div>
 				<div class="form-group actions-row">
-					{!! Form::button('<span class="glyphicon glyphicon-save"></span> '. trans('messages.save'),
-						['class' => 'btn btn-primary', 'onclick' => 'submit()']) !!}
+					{{ Form::button('<span class="glyphicon glyphicon-save"></span> '. trans('messages.save'),
+						['class' => 'btn btn-primary', 'onclick' => 'submit()']) }}
 				</div>
-			{!! Form::close() !!}
+			{{ Form::close() }}
 		</div>
 	</div>
 @stop
\ No newline at end of file
diff --git a/resources/views/lot/index.blade.php b/resources/views/lot/index.blade.php
index 7907a48..6326fee 100755
--- a/resources/views/lot/index.blade.php
+++ b/resources/views/lot/index.blade.php
@@ -1,22 +1,22 @@
-@extends("app")
+@extends("layout")
 @section("content")
 <div>
 	<ol class="breadcrumb">
-	  <li><a href="{!! URL::route('user.home')!!}">{!! trans('messages.home') !!}</a></li>
-	  <li class="active">{!!trans_choice('messages.lot',2)!!}</li>
+	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+	  <li class="active">{{Lang::choice('messages.lot',2)}}</li>
 	</ol>
 </div>
 @if (Session::has('message'))
-	<div class="alert alert-info">{!! Session::get('message') !!}</div>
+	<div class="alert alert-info">{{ Session::get('message') }}</div>
 
 <div class="panel panel-primary">
 	<div class="panel-heading ">
 		<span class="glyphicon glyphicon-adjust"></span>
-		{!! trans_choice('messages.lot',2) !!}
+		{{ Lang::choice('messages.lot',2) }}
 		<div class="panel-btn">
-			<a class="btn btn-sm btn-info" href="{!! URL::to("lot/create") !!}" >
+			<a class="btn btn-sm btn-info" href="{{ URL::to("lot/create") }}" >
 				<span class="glyphicon glyphicon-plus-sign"></span>
-				{!! trans('messages.add-lot') !!}
+				{{ trans('messages.add-lot') }}
 			</a>
 		</div>
 	</div>
@@ -24,41 +24,40 @@
 		<table class="table table-striped table-hover table-condensed search-table">
 			<thead>
 				<tr>
-					<th>{!! trans_choice('messages.name', 1) !!}</th>
-					<th>{!! trans_choice('messages.description', 1) !!}</th>
-					<th>{!! trans_choice('messages.expiry-date', 1) !!}</th>
-					<th>{!! trans_choice('messages.instrument', 1) !!}</th>
+					<th>{{ Lang::choice('messages.lot-number', 1) }}</th>
+					<th>{{ Lang::choice('messages.description', 1) }}</th>
+					<th>{{ Lang::choice('messages.expiry', 1) }}</th>
 					<th></th>
 				</tr>
 			</thead>
 			<tbody>
 			@foreach($lots as $lot)
-					<td>{!! $lot->number !!}</td>
-					<th>{!! $lot->description !!}</th>
-					<th>{!! $lot->expiry !!}</th>
-					<th>{!! $lot->instrument->name !!}</th>
+				<tr>
+					<td>{{ $lot->lot_no }}</td>
+					<td>{{ $lot->description }}</td>
+					<td>{{ $lot->expiry }}</td>
 					<td>
 						<!-- show the instrument details -->
-						<a class="btn btn-sm btn-success" href="{!! URL::route('lot.show', array($lot->id)) !!}">
+						<a class="btn btn-sm btn-success" href="{{ URL::route('lot.show', array($lot->id)) }}">
 							<span class="glyphicon glyphicon-eye-open"></span>
-							{!!trans('messages.view')!!}
+							{{trans('messages.view')}}
 						</a>
-						<a class="btn btn-sm btn-info" href="{!! URL::to("lot/" . $lot->id . "/edit") !!}" >
+						<a class="btn btn-sm btn-info" href="{{ URL::to("lot/" . $lot->id . "/edit") }}" >
 							<span class="glyphicon glyphicon-edit"></span>
-							{!! trans('messages.edit') !!}
+							{{ trans('messages.edit') }}
 						</a>
 						<button class="btn btn-sm btn-danger delete-item-link"
 							data-toggle="modal" data-target=".confirm-delete-modal"
-							data-id='{!! URL::to("lot/" . $lot->id . "/delete") !!}'>
+							data-id='{{ URL::to("lot/" . $lot->id . "/delete") }}'>
 							<span class="glyphicon glyphicon-trash"></span>
-							{!! trans('messages.delete') !!}
+							{{ trans('messages.delete') }}
 						</button>
 					</td>
 				</tr>
 			@endforeach
 			</tbody>
 		</table>
-		{!! Session::put('SOURCE_URL', URL::full()) !!}
+		{{ Session::put('SOURCE_URL', URL::full()) }}
 	</div>
 </div>
 @stop
\ No newline at end of file
diff --git a/resources/views/lot/show.blade.php b/resources/views/lot/show.blade.php
index e6c2b59..a444eaf 100755
--- a/resources/views/lot/show.blade.php
+++ b/resources/views/lot/show.blade.php
@@ -1,32 +1,30 @@
-@extends("app")
+@extends("layout")
 @section("content")
 	<div>
 		<ol class="breadcrumb">
-		  <li><a href="{!! URL::route('user.home')!!}">{!!trans('messages.home')!!}</a></li>
-		  <li><a href="{!! URL::route('lot.index') !!}">{!!trans_choice('messages.lot',2)!!}</a></li>
-		  <li class="active">{!!trans('messages.lot-details')!!}</li>
+		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+		  <li><a href="{{ URL::route('lot.index') }}">{{Lang::choice('messages.lot',2)}}</a></li>
+		  <li class="active">{{trans('messages.lot-details')}}</li>
 		</ol>
 	</div>
 	<div class="panel panel-primary">
 		<div class="panel-heading ">
 			<span class="glyphicon glyphicon-cog"></span>
-			{!!trans('messages.lot-details')!!}
+			{{trans('messages.lot-details')}}
 			<div class="panel-btn">
-				<a class="btn btn-sm btn-info" href="{!! URL::route('lot.edit', array($lot->id)) !!}">
+				<a class="btn btn-sm btn-info" href="{{ URL::route('lot.edit', array($lot->id)) }}">
 					<span class="glyphicon glyphicon-edit"></span>
-					{!!trans('messages.edit')!!}
+					{{trans('messages.edit')}}
 				</a>

 		</div>
 		<div class="panel-body">
 			<div class="display-details">
-				<h3 class="view"><strong>{!!trans_choice('messages.lot-number',1)!!}</strong>{!! $lot->number !!} </h3>
-				<p class="view-striped"><strong>{!!trans('messages.description')!!}</strong>
-					{!! $lot->description !!}</p>
-				<p class="view"><strong>{!!trans_choice('messages.instrument', 1)!!}</strong>
-					{!! $lot->instrument->name !!}</p>
-				<p class="view-striped"><strong>{!!trans('messages.date-created')!!}</strong>
-					{!! $lot->created_at !!}</p>
+				<h3 class="view"><strong>{{Lang::choice('messages.lot-number',1)}}</strong>{{ $lot->lot_no }} </h3>
+				<p class="view-striped"><strong>{{trans('messages.description')}}</strong>
+					{{ $lot->description }}</p>
+				<p class="view-striped"><strong>{{trans('messages.date-created')}}</strong>
+					{{ $lot->created_at }}</p>

 		</div>
 	</div>
diff --git a/resources/views/measure/edit.blade.php b/resources/views/measure/edit.blade.php
index 3cbc6df..1cea6e0 100755
--- a/resources/views/measure/edit.blade.php
+++ b/resources/views/measure/edit.blade.php
@@ -1,154 +1,140 @@
 @section("edit")
 @foreach($testtype->measures as $measure)
-<div class="col-md-12 measure-section card card-block">
-    <div class="col-md-12 measure">
-        <div class="col-md-3">
-            <div class="form-group row">
-                {!! Form::label('measures[name]['.$measure->id.']', trans_choice('terms.name', 1).':', array('class' => 'col-sm-3 form-control-label')) !!}
-                <div class="col-sm-9">
-                    <input class="form-control" name="measures[{!!$measure->id!!}][name]" value="{!!$measure->name!!}" type="text">
-                </div>
-            </div>
-        </div>
-        <div class="col-md-3">
-            <div class="form-group row">
-                {!! Form::label('measures[measure_type_id]['.$measure->id.']', trans('terms.type').':', array('class' => 'col-sm-2 form-control-label')) !!}
-                <div class="col-sm-10">
-                    <select class="form-control c-select measuretype-input-trigger {!!$measure->id!!}" 
-                        data-measure-id="{!!$measure->id!!}" 
-                        name="measures[{!!$measure->id!!}][measure_type_id]" 
-                        id="measure_type_id">
-                        <option value="0"></option>
-                        @foreach ($measuretype as $type)
-                            <option value="{!!$type->id!!}"
-                            {!!($type->id == $measure->measure_type_id) ? 'selected="selected"' : '' !!}>{!!$type->name!!}</option>
-                        @endforeach
-                    </select>
-                </div>
-            </div>
+<div class="row measure-section">
+<div class="col-md-11 measure">
+    <div class="col-md-3">
+        
+            {{ Form::label('measures[name]['.$measure->id.']', Lang::choice('messages.name',1)) }}
+           <input class="form-control" name="measures[{{$measure->id}}][name]" value="{{$measure->name}}" type="text">
         </div>
-        <div class="col-md-2">
-            <div class="form-group row">
-                {!! Form::label('measures[unit]['.$measure->id.']', trans('terms.unit').':', array('class' => 'col-sm-3 form-control-label')) !!}
-                <div class="col-sm-9">
-                    <input class="form-control" name="measures[{!!$measure->id!!}][unit]" value="{!!$measure->unit!!}" type="text">
-                </div>
-            </div>
+    </div>
+    <div class="col-md-3">
+        
+            {{ Form::label('measures[measure_type_id]['.$measure->id.']', trans('messages.measure-type')) }}
+                <select class="form-control measuretype-input-trigger {{$measure->id}}" 
+                    data-measure-id="{{$measure->id}}" 
+                    name="measures[{{$measure->id}}][measure_type_id]" 
+                    id="measure_type_id">
+                    <option value="0"></option>
+                    @foreach ($measuretype as $type)
+                        <option value="{{$type->id}}"
+                        {{($type->id == $measure->measure_type_id) ? 'selected="selected"' : '' }}>{{$type->name}}</option>
+                    @endforeach
+                </select>
         </div>
-        <div class="col-md-4">
-            <div class="form-group row">
-                {!! Form::label('measures[description]['.$measure->id.']', trans('terms.info').':', array('class' => 'col-sm-2 form-control-label')) !!}
-                <div class="col-sm-8">
-                    <textarea class="form-control" value="{!!$measure->description!!}" rows="2" name="measures[{!!$measure->id!!}][description]"></textarea>
-                </div>
-                <div class="col-sm-1">
-                    <button class="col-md-12 close" aria-hidden="true" type="button" 
-                        title="{!!trans('messages.delete')!!}"><span aria-hidden="true">&times;</span>
-                    </button>
-                </div>
-            </div>
+    </div>
+    <div class="col-md-3">
+        
+            {{ Form::label('measures[unit]['.$measure->id.']', trans('messages.unit')) }}
+            <input class="form-control" name="measures[{{$measure->id}}][unit]" value="{{$measure->unit}}" type="text">
         </div>
-        <div class="col-md-12">
-            <label for="measurerange" 'class'='form-group row col-sm-offset-2 form-control-label'>{!! trans('terms.range-values') !!}</label>
+    </div>
+    <div class="col-md-3">
+        
+            {{ Form::label('measures[description]['.$measure->id.']', trans('messages.description')) }}
+            <textarea class="form-control" value="{{$measure->description}}" rows="2" name="measures[{{$measure->id}}][description]"></textarea>
         </div>
-        <div class="col-md-12 card card-block">
-            <div class="measurevalue {!!$measure->id!!}">                        
-                @if ($measure->measure_type_id == 1)
-                    <div class="col-md-12">
-                        <div class="col-md-5">
-                            <span class="col-md-8 range-title">{!! trans('terms.age-range') !!}</span>
-                            <span class="col-md-4 range-title">{!! trans('terms.gender') !!}</span>
-                        </div>
-                        <div class="col-md-4">
-                            <span class="col-md-12 range-title">{!! trans('terms.measure-range') !!}</span>
-                        </div>
-                        <div class="col-md-2">
-                            <span class="col-md-12 interpretation-title">{!! trans('terms.interpretation') !!}
-                            </span>
-                        </div>
-                    </div>     
-                    @foreach($measure->measureRanges as $key=>$value)
-                    <div class="col-md-12 measure-input" style="padding-bottom:4px;">
-                        <div class="col-md-5">
-                            <div class="col-sm-8">
-                                <div class="col-sm-6">
-                                    <input class="form-control" name="measures[{!!$measure->id!!}][agemin][]" type="text" value="{!! $value->age_min !!}"
-                                        title="{!!trans('messages.lower-age-limit')!!}">
-                                </div>
-                                <div class="col-sm-6">
-                                    <input class="form-control" name="measures[{!!$measure->id!!}][agemax][]" type="text" value="{!! $value->age_max !!}"
-                                        title="{!!trans('messages.upper-age-limit')!!}">
-                                </div>
+    </div>
+    <div class="col-md-12">
+        
+            <label for="measurerange">{{trans('messages.measure-range-values')}}</label>
+            
+                <div class="panel-body">
+                <div>
+                    <div 
+                    class="{{($measure->measure_type_id == 1) ? 'col-md-12' : 'col-md-6' }} measurevalue {{$measure->id}}">
+                    
+                    @if ($measure->measure_type_id == 1)
+                        <div class="col-md-12">
+                            <div class="col-md-4">
+                                <span class="col-md-6 range-title">{{trans('messages.measure-age-range')}}</span>
+                                <span class="col-md-6 range-title">{{trans('messages.gender')}}</span>
                             </div>
+                            <div class="col-md-3">
+                                <span class="col-md-12 range-title">{{trans('messages.measure-range')}}</span>
+                            </div>
+                            <div class="col-md-2">
+                                <span class="col-md-12 interpretation-title">{{trans('messages.interpretation')}}
+                                </span>
+                            </div>
+                        </div>     
+                        @foreach($measure->measureRanges as $key=>$value)
+                        <div class="col-md-12 measure-input">
+                            <div class="col-md-4">
+                                <input class="col-md-2" name="measures[{{$measure->id}}][agemin][]" type="text" value="{{ $value->age_min }}"
+                                    title="{{trans('messages.lower-age-limit')}}">
+                                <span class="col-md-1">:</span>
+                                <input class="col-md-2" name="measures[{{$measure->id}}][agemax][]" type="text" value="{{ $value->age_max }}"
+                                    title="{{trans('messages.upper-age-limit')}}">
                                     <?php $selection = array("","","");?>
                                     <?php $selection[$value->gender] = "selected='selected'"; ?>
-                            <div class="col-sm-4">
-                                <select class="col-md-4 c-select form-control" name="measures[{!!$measure->id!!}][gender][]">
-                                    <option value="0" {!! $selection[0] !!}>{!! trans_choice('terms.sex', 1) !!}</option>
-                                    <option value="1" {!! $selection[1] !!}>{!! trans_choice('terms.sex', 2) !!}</option>
-                                    <option value="2" {!! $selection[2] !!}>{!! trans('terms.both') !!}</option>
+                                <span class="col-md-1"></span>
+                                <select class="col-md-4" name="measures[{{$measure->id}}][gender][]">
+                                    <option value="0" {{ $selection[0] }}>{{trans('messages.male')}}</option>
+                                    <option value="1" {{ $selection[1] }}>{{trans('messages.female')}}</option>
+                                    <option value="2" {{ $selection[2] }}>{{trans('messages.both')}}</option>
                                 </select>
                             </div>
-                        </div>
-                        <div class="col-md-4">
-                            <div class="col-sm-6">
-                                <input class="form-control" name="measures[{!!$measure->id!!}][rangemin][]" type="text"
-                                    value="{!! $value->range_lower !!}" 
-                                    title="{!!trans('messages.lower-range')!!}">
+                            <div class="col-md-3">
+                                <input class="col-md-4" name="measures[{{$measure->id}}][rangemin][]" type="text"
+                                    value="{{ $value->range_lower }}" 
+                                    title="{{trans('messages.lower-range')}}">
+                                <span class="col-md-2">:</span>
+                                <input class="col-md-4" name="measures[{{$measure->id}}][rangemax][]" type="text"
+                                    value="{{ $value->range_upper }}"
+                                    title="{{trans('messages.upper-range')}}">
                             </div>
-                            <div class="col-sm-6">
-                                <input class="form-control" name="measures[{!!$measure->id!!}][rangemax][]" type="text"
-                                    value="{!! $value->range_upper !!}"
-                                    title="{!!trans('messages.upper-range')!!}">
-                            </div>
-                        </div>
-                        <div class="col-md-2">
-                            <div class="col-sm-12">
-                                <input class="form-control" name="measures[{!!$measure->id!!}][interpretation][]" type="text" 
-                                    value="{!! $value->interpretation !!}">
+                            <div class="col-md-2">
+                                <input class="col-md-10" name="measures[{{$measure->id}}][interpretation][]" type="text" 
+                                    value="{{ $value->interpretation }}">
+                                <button class="col-md-2 close" aria-hidden="true" type="button" 
+                                title="{{trans('messages.delete')}}">×</button>
+                                <input value="{{ $value->id }}" name="measures[{{$measure->id}}][measurerangeid][]" type="hidden">
                             </div>
                         </div>
-                        <div class="col-md-1">
-                            <button class="col-md-2 close" aria-hidden="true" type="button" 
-                                title="{!!trans('messages.delete')!!}"><span aria-hidden="true">&times;</span>
-                            </button>
-                            <input value="{!! $value->id !!}" name="measures[{!!$measure->id!!}][measurerangeid][]" type="hidden">
-                        </div>
-                    </div>
-                    @endforeach
-                @elseif ($measure->measure_type_id == 2 || $measure->measure_type_id == 3)
-                    <div class="col-md-12">
-                        <span class="col-md-5 val-title">{!! trans('terms.range') !!}</span>
-                        <span class="col-md-5 interpretation-title">{!! trans('terms.interpretation') !!}</span>
-                    </div>
-                    @foreach($measure->measureRanges as $key=>$value)
-                    <div class="col-md-12 measure-input">
-                        <div class="col-md-5">
-                            <input class="col-md-10 val form-control" value="{!! $value->alphanumeric !!}"
-                            name="measures[{!!$measure->id!!}][val][]" type="text">
+                        @endforeach
+
+                    @elseif ($measure->measure_type_id == 2 || $measure->measure_type_id == 3)
+                        <div class="col-md-12">
+                            <span class="col-md-5 val-title">{{trans('messages.range')}}</span>
+                            <span class="col-md-5 interpretation-title">{{trans('messages.interpretation')}}</span>
                         </div>
-                        <div class="col-md-5">
-                            <input class="col-md-10 interpretation form-control" value="{!! $value->interpretation !!}"
-                            name="measures[{!!$measure->id!!}][interpretation][]" type="text">
-                            <button class="col-md-2 close" aria-hidden="true" type="button" 
-                                title="{!!trans('messages.delete')!!}">&times;</button>
-                            <input value="{!! $value->id !!}" name="measures[{!!$measure->id!!}][measurerangeid][]" type="hidden">
+                        @foreach($measure->measureRanges as $key=>$value)
+                        <div class="col-md-12 measure-input">
+                            <div class="col-md-5">
+                                <input class="col-md-10 val" value="{{ $value->alphanumeric }}"
+                                name="measures[{{$measure->id}}][val][]" type="text">
+                            </div>
+                            <div class="col-md-5">
+                                <input class="col-md-10 interpretation" value="{{ $value->interpretation }}"
+                                name="measures[{{$measure->id}}][interpretation][]" type="text">
+                                <button class="col-md-2 close" aria-hidden="true" type="button" 
+                                    title="{{trans('messages.delete')}}">×</button>
+                                <input value="{{ $value->id }}" name="measures[{{$measure->id}}][measurerangeid][]" type="hidden">
+                            </div>
+                        </div>  
+                        @endforeach
+                    @else
+                        <div class="freetextInputLoader">
+                            <p class="freetextInput" >{{trans('messages.freetext-measure-config-input-message')}}</p>
                         </div>
-                    </div>  
-                    @endforeach
-                @else
-                    <div class="freetextInputLoader">
-                        <p class="freetextInput" >{!! trans('terms.freetext-measure-config-input-message') !!}</p>
-                    </div>
-                
+                    
+                </div>
+                <div class="col-md-12 actions-row {{($measure->measure_type_id == 4)? 'hidden':''}}">
+                    <a class="btn btn-default add-another-range" href="javascript:void(0);" 
+                        data-measure-id="{{$measure->id}}">
+                    <span class="glyphicon glyphicon-plus-sign"></span>{{trans('messages.add-new-measure-range')}}</a>
+                </div>
+                </div>
+                </div>
             </div>
         </div>
-        <div class="col-md-12 actions-row {!!($measure->measure_type_id == 4)? 'hidden':''!!}">
-            <a class="btn btn-sm btn-wisteria add-another-range" href="javascript:void(0);" 
-                data-measure-id="{!!$measure->id!!}">
-            <i class="fa fa-plus-circle"></i> {!! trans('action.new').' '.trans_choice('terms.range', 1) !!}</a>
-        </div>
     </div>
 </div>
+<div class="col-md-1">
+    <button class="col-md-12 close" aria-hidden="true" type="button" 
+        title="{{trans('messages.delete')}}">×</button>
+</div>
+</div>
 @endforeach
 @show
\ No newline at end of file
diff --git a/resources/views/measure/measureinput.blade.php b/resources/views/measure/measureinput.blade.php
index 6649d35..52c7128 100755
--- a/resources/views/measure/measureinput.blade.php
+++ b/resources/views/measure/measureinput.blade.php
@@ -1,142 +1,124 @@
 @section("measureinput")
-
-<div class="col-md-12 measure-section">
-    <div class="col-md-12 measure">
-        <div class="hidden measureGenericLoader">
-            <div class=" col-md-12 card card-block">
+<!-- OTHER UI COMPONENTS -->
+    <div class="hidden measureGenericLoader">
+        <div class="row new-measure-section">
+            <div class="col-md-11 measure">
                 <div class="col-md-3">
-                    <div class="form-group row">
-                        {!! Form::label('new_measures[][name]', trans_choice('terms.name', 1).':', array('class' => 'col-sm-3 form-control-label')) !!}
-                        <div class="col-sm-9">
-                            <input class="form-control name" name="" value="" type="text">
-                        </div>
+                    
+                        {{ Form::label('new-measures[][name]', Lang::choice('messages.name',1)) }}
+                       <input class="form-control name" name="" type="text">
                     </div>
                 </div>
                 <div class="col-md-3">
-                    <div class="form-group row">
-                        {!! Form::label('new_measures[][measure_type_id]', trans('terms.type').':', array('class' => 'col-sm-2 form-control-label')) !!}
-                        <div class="col-sm-10">
-                            <select class="form-control c-select measuretype-input-trigger measure_type_id" 
+                    
+                        {{ Form::label('new-measures[][measure_type_id]', trans('messages.measure-type')) }}
+                            <select class="form-control measuretype-input-trigger measure_type_id" 
                                 data-measure-id="0" 
                                 data-new-measure-id="" 
                                 name="" 
                                 id="measure_type_id">
                                 <option value="0"></option>
                                 @foreach ($measuretype as $type)
-                                    <option value="{!!$type->id!!}">{!!$type->name!!}</option>
+                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                 @endforeach
                             </select>
-                        </div>
                     </div>
                 </div>
-                <div class="col-md-2">
-                    <div class="form-group row">
-                        {!! Form::label('new_measures[][unit]', trans('terms.unit').':', array('class' => 'col-sm-3 form-control-label')) !!}
-                        <div class="col-sm-9">
-                            <input class="form-control unit" name="" value="" type="text">
-                        </div>
+                <div class="col-md-3">
+                    
+                        {{ Form::label('new-measures[][unit]', trans('messages.unit')) }}
+                        <input class="form-control unit" name="" type="text">
                     </div>
                 </div>
-                <div class="col-md-4">
-                    <div class="form-group row">
-                        {!! Form::label('new_measures[][description]', trans('terms.info').':', array('class' => 'col-sm-2 form-control-label')) !!}
-                        <div class="col-sm-8">
-                            <textarea class="form-control description" value="" rows="2" name=""></textarea>
-                        </div>
-                        <div class="col-sm-1">
-                            <button class="col-md-12 close" aria-hidden="true" type="button" 
-                                title="{!!trans('messages.delete')!!}"><span aria-hidden="true">&times;</span>
-                            </button>
-                        </div>
+                <div class="col-md-3">
+                    
+                        {{ Form::label('new-measures[][description]', trans('messages.description')) }}
+                        <textarea class="form-control description" rows="2" name=""></textarea>
                     </div>
                 </div>
                 <div class="col-md-12">
-                    <label for="measurerange" 'class'='form-group row col-sm-offset-2 form-control-label'>{!! trans('terms.range-values') !!}</label>
-                </div>
-                <div class="col-md-12 actions-row" style="padding-bottom:5px;">
-                    <a class="btn btn-sm btn-wisteria add-another-range" href="javascript:void(0);" 
-                        data-measure-id="">
-                    <i class="fa fa-plus-circle"></i> {!! trans('action.new').' '.trans_choice('terms.range', 1) !!}</a>
+                    
+                        <label for="measurerange">{{trans('messages.measure-range-values')}}</label>
+                        
+                            <div class="panel-body">
+                            <div>
+                                <div class="measurevalue"></div>
+                                <div class="col-md-12 actions-row">
+                                    <a class="btn btn-default add-another-range" href="javascript:void(0);" 
+                                        data-measure-id="0"
+                                        data-new-measure-id="">
+                                    <span class="glyphicon glyphicon-plus-sign"></span>{{trans('messages.add-new-measure-range')}}</a>
+                                </div>
+                            </div>
+                            </div>
+                        </div>
+                    </div>
                 </div>
             </div>
+            <div class="col-md-1">
+                <button class="col-md-12 close" aria-hidden="true" type="button" 
+                    title="{{trans('messages.delete')}}">×</button>
+            </div>
+        </div>    
+    </div><!-- measureGeneric -->
+    <div class="hidden numericHeaderLoader">
+        <div class="col-md-12">
+            <div class="col-md-4">
+                <span class="col-md-6 range-title">{{trans('messages.measure-age-range')}}</span>
+                <span class="col-md-6 range-title">{{trans('messages.gender')}}</span>
+            </div>
+            <div class="col-md-3">
+                <span class="col-md-12 range-title">{{trans('messages.measure-range')}}</span>
+            </div>
+            <div class="col-md-2">
+                <span class="col-md-12 interpretation-title">{{trans('messages.interpretation')}}</span>
+            </div>
+        </div>     
+    </div><!-- alphanumericHeader -->
+    <div class="hidden alphanumericHeaderLoader">
+        <div class="col-md-12">
+            <span class="col-md-5 interpretation-title">{{trans('messages.value')}}</span>
+            <span class="col-md-5 interpretation-title">{{trans('messages.interpretation')}}</span>
         </div>
-        <div class="col-md-12 card card-block">
-            <!-- measureGeneric -->
-            <div class="col-md-12 card card-block hidden numericHeaderLoader">
-                <div class="col-md-5">
-                    <span class="col-md-8 range-title">{!! trans('terms.age-range') !!}</span>
-                    <span class="col-md-4 range-title">{!! trans('terms.gender') !!}</span>
-                </div>
-                <div class="col-md-4">
-                    <span class="col-md-12 range-title">{!! trans('terms.measure-range') !!}</span>
-                </div>
-                <div class="col-md-2">
-                    <span class="col-md-12 interpretation-title">{!! trans('terms.interpretation') !!}
-                    </span>
-                </div>
+    </div><!-- numericHeader -->
+    <div class="hidden numericInputLoader">
+        <div class="col-md-12 measure-input">
+            <div class="col-md-4">
+                <input class="col-md-2 agemin" name="" type="text" title="{{trans('messages.lower-age-limit')}}">
+                <span class="col-md-1">:</span>
+                <input class="col-md-2 agemax" name="" type="text" title="{{trans('messages.upper-age-limit')}}">
+                <span class="col-md-1"></span>
+                <select class="col-md-4 gender" name="">
+                    <option value="0">{{trans('messages.male')}}</option>
+                    <option value="1">{{trans('messages.female')}}</option>
+                    <option value="2">{{trans('messages.both')}}</option>
+                </select>
             </div>
-            <!-- numericHeader -->
-            <div class="col-md-12 card card-block hidden numericInputLoader" style="padding-bottom:4px;">                
-                <div class="col-md-5">
-                    <div class="col-sm-8">
-                        <div class="col-sm-6">
-                            <input class="form-control agemin" name="" type="text" value="" title="{!!trans('messages.lower-age-limit')!!}">
-                        </div>
-                        <div class="col-sm-6">
-                            <input class="form-control agemax" name="" type="text" value="" title="{!!trans('messages.upper-age-limit')!!}">
-                        </div>
-                    </div>
-                    <div class="col-sm-4">
-                        <select class="col-md-4 c-select form-control gender" name="">
-                            <option value="0">{!! trans_choice('terms.sex', 1) !!}</option>
-                            <option value="1">{!! trans_choice('terms.sex', 2) !!}</option>
-                            <option value="2">{!! trans('terms.both') !!}</option>
-                        </select>
-                    </div>
-                </div>
-                <div class="col-md-4">
-                    <div class="col-sm-6">
-                        <input class="form-control rangemin" name="" type="text" value="" title="{!!trans('messages.lower-range')!!}">
-                    </div>
-                    <div class="col-sm-6">
-                        <input class="form-control rangemin" name="" type="text" value="" title="{!!trans('messages.upper-range')!!}">
-                    </div>
-                </div>
-                <div class="col-md-2">
-                    <div class="col-sm-12">
-                        <input class="form-control interpretation" name="" type="text" value="">
-                    </div>
-                </div>
-                <div class="col-md-1">
-                    <button class="col-md-2 close" aria-hidden="true" type="button" 
-                        title="{!!trans('messages.delete')!!}"><span aria-hidden="true">&times;</span>
-                    </button>
-                    <input class="measurerangeid" name="" type="hidden">
-                </div>
+            <div class="col-md-3">
+                <input class="col-md-4 rangemin" name="" type="text" title="{{trans('messages.lower-range')}}">
+                <span class="col-md-2">:</span>
+                <input class="col-md-4 rangemax" name="" type="text" title="{{trans('messages.upper-range')}}">
             </div>
-            <!-- alphanumericHeader -->
-            <div class="col-md-12 card card-block hidden alphanumericHeaderLoader">
-                <span class="col-md-5 val-title">{!! trans('terms.value') !!}</span>
-                <span class="col-md-5 interpretation-title">{!! trans('terms.interpretation') !!}</span>
+            <div class="col-md-2">
+                <input class="col-md-10 interpretation" name="" type="text">
+                <button class="col-md-2 close" aria-hidden="true" type="button" title="{{trans('messages.delete')}}">×</button>
+                <input class="measurerangeid" name="" type="hidden">
             </div>
-            <!-- numericHeader -->
-            <div class="col-md-12 hidden card card-block alphanumericInputLoader">                
-                <div class="col-md-5">
-                    <input class="col-md-10 val form-control" value="" name="" type="text">
-                </div>
-                <div class="col-md-6">
-                    <input class="col-md-10 interpretation form-control" value="" name="" type="text">
-                </div>
-                <div class="col-md-1">                    
-                    <button class="close" aria-hidden="true" type="button" 
-                        title="{!!trans('messages.delete')!!}">&times;</button>
-                    <input class="measurerangeid" name="" type="hidden">
-                </div>
+        </div>
+    </div><!-- numericInput -->
+    <div class="hidden alphanumericInputLoader">
+        <div class="col-md-12 measure-input">
+            <div class="col-md-5">
+                <input class="col-md-10 val" name="" type="text">
             </div>
-            <div class="col-md-12 hidden freetextInputLoader">
-                <p class="freetextInput" >{!! trans('terms.freetext-measure-config-input-message') !!}</p>
+            <div class="col-md-5">
+                <input class="col-md-10 interpretation" name="" type="text">
+                <button class="col-md-2 close" aria-hidden="true" type="button" title="{{trans('messages.delete')}}">×</button>
+                <input class="measurerangeid" name="" type="hidden">
             </div>
         </div>
-    </div>
-</div>
+    </div><!-- alphanumericInput -->
+    <div class="hidden freetextInputLoader">
+        <p class="freetextInput" >{{trans('messages.freetext-measure-config-input-message')}}</p>
+    </div><!-- freetextInput -->
 @show
\ No newline at end of file
diff --git a/resources/views/organism/create.blade.php b/resources/views/organism/create.blade.php
index f7262bb..9fc21fd 100755
--- a/resources/views/organism/create.blade.php
+++ b/resources/views/organism/create.blade.php
@@ -1,72 +1,69 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li><a href="{!! route('organism.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.organism', 2) !!}</a></li>
-            <li class="active">{!! trans('action.new').' '.trans_choice('menu.organism', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-pencil"></i> {!! trans('action.new').' '.trans_choice('menu.organism', 1) !!} 
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
+
+	<div>
+		<ol class="breadcrumb">
+		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+		  <li>
+		  	<a href="{{ URL::route('organism.index') }}">{{ Lang::choice('messages.organism',1) }}</a>
+		  </li>
+		  <li class="active">{{trans('messages.create-organism')}}</li>
+		</ol>
+	</div>
+	<div class="panel panel-primary">
+		<div class="panel-heading ">
+			<span class="glyphicon glyphicon-adjust"></span>
+			{{trans('messages.create-organism')}}
 		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
+		<div class="panel-body">
+		<!-- if there are creation errors, they will show here -->
 			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
+				<div class="alert alert-danger">
+					{{ HTML::ul($errors->all()) }}
+				</div>
+			
 
-			{!! Form::open(array('route' => 'organism.store', 'id' => 'form-create-organism')) !!}
-				<!-- CSRF Token -->
-                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-                <!-- ./ csrf token -->
-				<div class="form-group row">
-					{!! Form::label('name', trans_choice('terms.name',1), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
-					</div>
+			{{ Form::open(array('route' => 'organism.store', 'id' => 'form-create-organism')) }}
+
+				
+					{{ Form::label('name', Lang::choice('messages.name',1)) }}
+					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
 				</div>
-				<div class="form-group row">
-					{!! Form::label('description', trans("terms.description"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
-					<div class="col-sm-6">
-						{!! Form::textarea('description', old('description'), array('class' => 'form-control', 'rows' => '2')) !!}
-					</div>
+				
+					{{ Form::label('description', trans("messages.description")) }}</label>
+					{{ Form::textarea('description', Input::old('description'), 
+						array('class' => 'form-control', 'rows' => '2')) }}
 				</div>
-				<div class="form-group row">
-					{!! Form::label('drugs', trans_choice("menu.drug", 2),  array('class' => 'col-sm-2 form-control-label')) !!}
-				</div>					
-				<div class="col-sm-12 card card-block">	
-					@foreach($drugs as $key=>$value)
-						<div class="col-md-3">
-							<label  class="checkbox">
-								<input type="checkbox" name="drugs[]" value="{!! $value->id!!}" />{!!$value->name!!}
-							</label>
+				
+					{{ Form::label('drugs', trans("messages.compatible-drugs")) }}
+					
+						<div class="container-fluid">
+							<?php 
+								$cnt = 0;
+								$zebra = "";
+							?>
+						@foreach($drugs as $key=>$value)
+							{{ ($cnt%4==0)?"<div class='row $zebra'>":"" }}
+							<?php
+								$cnt++;
+								$zebra = (((int)$cnt/4)%2==1?"row-striped":"");
+							?>
+							<div class="col-md-3">
+								<label  class="checkbox">
+									<input type="checkbox" name="drugs[]" value="{{ $value->id}}" />{{$value->name}}
+								</label>
+							</div>
+							{{ ($cnt%4==0)?"</div>":"" }}
+						@endforeach
 						</div>
-					@endforeach
+					</div>
 				</div>
-				<div class="form-group row col-sm-offset-2">
-					{!! Form::button("<i class='fa fa-plus-circle'></i> ".trans('action.save'), 
-						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
+				<div class="form-group actions-row">
+					{{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
+						array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
 				</div>
 
-			{!! Form::close() !!}
-	  	</div>
+			{{ Form::close() }}
+		</div>
 	</div>
-</div>
-@endsection	
\ No newline at end of file
+@stop	
\ No newline at end of file
diff --git a/resources/views/organism/edit.blade.php b/resources/views/organism/edit.blade.php
index bae9e6e..274bf04 100755
--- a/resources/views/organism/edit.blade.php
+++ b/resources/views/organism/edit.blade.php
@@ -1,76 +1,79 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li><a href="{!! route('organism.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.organism', 2) !!}</a></li>
-            <li class="active">{!! trans('action.edit').' '.trans_choice('menu.organism', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-edit"></i> {!! trans('action.edit').' '.trans_choice('menu.organism', 1) !!} 
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
+
+	@if (Session::has('message'))
+		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
+	
+	<div>
+		<ol class="breadcrumb">
+		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+		  <li>
+		  	<a href="{{ URL::route('organism.index') }}">{{ Lang::choice('messages.organism',1) }}</a>
+		  </li>
+		  <li class="active">{{ trans('messages.edit-organism') }}</li>
+		</ol>
+	</div>
+	<div class="panel panel-primary">
+		<div class="panel-heading ">
+			<span class="glyphicon glyphicon-edit"></span>
+			{{ trans('messages.edit-organism') }}
 		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
-			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
+		<div class="panel-body">
+			{{ Form::model($organism, array(
+				'route' => array('organism.update', $organism->id), 'method' => 'PUT',
+				'id' => 'form-edit-organism'
+			)) }}
 
-			{!! Form::model($organism, array('route' => array('organism.update', $organism->id), 
-				'method' => 'PUT', 'id' => 'form-edit-organism')) !!}
-				<!-- CSRF Token -->
-                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-                <!-- ./ csrf token -->
-				<div class="form-group row">
-					{!! Form::label('name', trans_choice('terms.name',1), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
+				@if($errors->all())
+					<div class="alert alert-danger">
+						{{ HTML::ul($errors->all()) }}
 					</div>
+				
+				
+				
+					{{ Form::label('name', Lang::choice('messages.name',1)) }}
+					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
 				</div>
-				<div class="form-group row">
-					{!! Form::label('description', trans("terms.description"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
-					<div class="col-sm-6">
-						{!! Form::textarea('description', old('description'), array('class' => 'form-control', 'rows' => '2')) !!}
-					</div>
+				
+					{{ Form::label('description', trans('messages.description')) }}
+					{{ Form::textarea('description', Input::old('description'), 
+						array('class' => 'form-control', 'rows' => '2')) }}
 				</div>
-				<div class="form-group row">
-					{!! Form::label('drugs', trans_choice("menu.drug", 2),  array('class' => 'col-sm-2 form-control-label')) !!}
-				</div>				
-				<div class="col-sm-12 card card-block">	
-					@foreach($drugs as $key=>$value)
-						
-						<div class="col-md-3">
-							<label  class="checkbox">
-								<input type="checkbox" name="drugs[]" value="{!! $value->id!!}" 
-									{!! in_array($value->id, $organism->drugs->lists('id')->toArray())?"checked":"" !!} />
-									{!!$value->name !!}
-							</label>
+				
+					{{ Form::label('drugs', trans("messages.compatible-drugs")) }}
+					
+						<div class="container-fluid">
+							<?php 
+								$cnt = 0;
+								$zebra = "";
+							?>
+						@foreach($drugs as $key=>$value)
+							{{ ($cnt%4==0)?"<div class='row $zebra'>":"" }}
+							<?php
+								$cnt++;
+								$zebra = (((int)$cnt/4)%2==1?"row-striped":"");
+							?>
+							<div class="col-md-3">
+								<label  class="checkbox">
+									<input type="checkbox" name="drugs[]" value="{{ $value->id}}" 
+										{{ in_array($value->id, $organism->drugs->lists('id'))?"checked":"" }} />
+										{{$value->name }}
+								</label>
+							</div>
+							{{ ($cnt%4==0)?"</div>":"" }}
+						@endforeach
 						</div>
-					@endforeach
+					</div>
 				</div>
-				<div class="form-group row col-sm-offset-2">
-					{!! Form::button("<i class='fa fa-check-circle'></i> ".trans('action.update'), 
-						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
+				<div class="form-group actions-row">
+					{{ Form::button('<span class="glyphicon glyphicon-save"></span> '. trans('messages.save'), 
+						['class' => 'btn btn-primary', 'onclick' => 'submit()']) }}
+					{{ Form::button(trans('messages.cancel'), 
+						['class' => 'btn btn-default', 'onclick' => 'javascript:history.go(-1)']
+					) }}
 				</div>
 
-			{!! Form::close() !!}
-	  	</div>
+			{{ Form::close() }}
+		</div>
 	</div>
-</div>
-@endsection
\ No newline at end of file
+@stop	
\ No newline at end of file
diff --git a/resources/views/organism/index.blade.php b/resources/views/organism/index.blade.php
index ee68cf8..fc71c25 100755
--- a/resources/views/organism/index.blade.php
+++ b/resources/views/organism/index.blade.php
@@ -1,89 +1,71 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li class="active"><i class="fa fa-cube"></i> {!! trans_choice('menu.organism', 2) !!}</li>
-        </ul>
-    </div>
+<div>
+	<ol class="breadcrumb">
+	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+	  <li class="active">{{ Lang::choice('messages.organism',1) }}</li>
+	</ol>
 </div>
-<div class="conter-wrapper">
-	<div class="row">
-		<div class="col-sm-12">
-			<div class="card">
-				<div class="card-header">
-				    <i class="fa fa-book"></i> {!! trans_choice('menu.organism', 2) !!} 
-				    <span>
-					    <a class="btn btn-sm btn-belize-hole" href="{!! url("organism/create") !!}" >
-							<i class="fa fa-plus-circle"></i>
-							{!! trans('action.new').' '.trans_choice('menu.organism', 1) !!}
-						</a>
-						<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-							<i class="fa fa-step-backward"></i>
-							{!! trans('action.back') !!}
-						</a>				
-					</span>
-				</div>
-			  	<div class="card-block">	  		
-					@if (Session::has('message'))
-						<div class="alert alert-info">{!! Session::get('message') !!}</div>
-					
-					@if($errors->all())
-		            <div class="alert alert-danger alert-dismissible" role="alert">
-		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-		            </div>
-		            
-				 	<table class="table table-bordered table-sm search-table">
-						<thead>
-							<tr>
-								<th>{!! trans('terms.name') !!}</th>
-								<th>{!! trans('terms.description') !!}</th>
-								<th></th>
-							</tr>
-						</thead>
-						<tbody>
-						@foreach($organisms as $key => $value)
-							<tr @if(session()->has('active_organism'))
-				                    {!! (session('active_organism') == $value->id)?"class='warning'":"" !!}
-				                
-				                >
-								<td>{!! $value->name !!}</td>
-								<td>{!! $value->description !!}</td>
-								
-								<td>
+@if (Session::has('message'))
+	<div class="alert alert-info">{{ Session::get('message') }}</div>
+
+<div class="panel panel-primary">
+	<div class="panel-heading ">
+		<span class="glyphicon glyphicon-adjust"></span>
+		{{ Lang::choice('messages.organism',1) }}
+		<div class="panel-btn">
+			<a class="btn btn-sm btn-info" href="{{ URL::to("organism/create") }}" >
+				<span class="glyphicon glyphicon-plus-sign"></span>
+				{{ trans('messages.create-organism') }}
+			</a>
+		</div>
+	</div>
+	<div class="panel-body">
+		<table class="table table-striped table-hover table-condensed search-table">
+			<thead>
+				<tr>
+					<th>{{ Lang::choice('messages.name',1) }}</th>
+					<th>{{ trans('messages.description') }}</th>
+					<th></th>
+				</tr>
+			</thead>
+			<tbody>
+			@foreach($organisms as $key => $value)
+				<tr @if(Session::has('activeorganism'))
+                            {{(Session::get('activeorganism') == $value->id)?"class='info'":""}}
+                        
+                        >
 
-								<!-- show the test category (uses the show method found at GET /organism/{id} -->
-									<a class="btn btn-sm btn-success" href="{!! url("organism/" . $value->id) !!}" >
-										<i class="fa fa-folder-open-o"></i>
-										{!! trans('action.view') !!}
-									</a>
+					<td>{{ $value->name }}</td>
+					<td>{{ $value->description }}</td>
+					
+					<td>
 
-								<!-- edit this test category (uses edit method found at GET /organism/{id}/edit -->
-									<a class="btn btn-sm btn-info" href="{!! url("organism/" . $value->id . "/edit") !!}" >
-										<i class="fa fa-edit"></i>
-										{!! trans('action.edit') !!}
-									</a>
-									
-								<!-- delete this test category (uses delete method found at GET /organism/{id}/delete -->
-									<button class="btn btn-sm btn-danger delete-item-link"
-										data-toggle="modal" data-target=".confirm-delete-modal"	
-										data-id='{!! url("organism/" . $value->id . "/delete") !!}'>
-										<i class="fa fa-trash-o"></i>
-										{!! trans('action.delete') !!}
-									</button>
-								</td>
-							</tr>
-						@endforeach
-						</tbody>
-					</table>
-			  	</div>
-			</div>
-		</div>
+					<!-- show the organism (uses the show method found at GET /organism/{id} -->
+						<a class="btn btn-sm btn-success" href="{{ URL::to("organism/" . $value->id) }}" >
+							<span class="glyphicon glyphicon-eye-open"></span>
+							{{ trans('messages.view') }}
+						</a>
+
+					<!-- edit this organism (uses edit method found at GET /organism/{id}/edit -->
+						<a class="btn btn-sm btn-info" href="{{ URL::to("organism/" . $value->id . "/edit") }}" >
+							<span class="glyphicon glyphicon-edit"></span>
+							{{ trans('messages.edit') }}
+						</a>
+						
+					<!-- delete this organism (uses delete method found at GET /organism/{id}/delete -->
+						<button class="btn btn-sm btn-danger delete-item-link"
+							data-toggle="modal" data-target=".confirm-delete-modal"	
+							data-id='{{ URL::to("organism/" . $value->id . "/delete") }}'>
+							<span class="glyphicon glyphicon-trash"></span>
+							{{ trans('messages.delete') }}
+						</button>
+					</td>
+				</tr>
+			@endforeach
+			</tbody>
+		</table>
+		{{ Session::put('SOURCE_URL', URL::full()) }}
 	</div>
-	{!! session(['SOURCE_URL' => URL::full()]) !!}
 </div>
-@endsection
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/organism/show.blade.php b/resources/views/organism/show.blade.php
index 87adc9f..c8e24c9 100755
--- a/resources/views/organism/show.blade.php
+++ b/resources/views/organism/show.blade.php
@@ -1,47 +1,37 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li><a href="{!! route('organism.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.organism', 2) !!}</a></li>
-            <li class="active">{!! trans('action.view').' '.trans_choice('menu.organism', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-file-text"></i> <strong>{!! trans('terms.details-for').': '.$organism->name !!}</strong>
-		    <span>
-		    	<a class="btn btn-sm btn-belize-hole" href="{!! url("organism/create") !!}" >
-					<i class="fa fa-plus-circle"></i>
-					{!! trans('action.new').' '.trans_choice('menu.organism', 1) !!}
-				</a>
-				<a class="btn btn-sm btn-info" href="{!! url("organism/" . $organism->id . "/edit") !!}" >
-					<i class="fa fa-edit"></i>
-					{!! trans('action.edit') !!}
+
+@if (Session::has('message'))
+	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
+
+
+	<div>
+		<ol class="breadcrumb">
+		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+		  <li><a href="{{ URL::route('organism.index') }}">{{ Lang::choice('messages.organism',1) }}</a></li>
+		  <li class="active">{{ trans('messages.organism-details') }}</li>
+		</ol>
+	</div>
+	<div class="panel panel-primary ">
+		<div class="panel-heading ">
+			<span class="glyphicon glyphicon-adjust"></span>
+			{{ trans('messages.organism-details') }}
+			<div class="panel-btn">
+				<a class="btn btn-sm btn-info" href="{{ URL::route('organism.edit', array($organism->id)) }}">
+					<span class="glyphicon glyphicon-edit"></span>
+					{{ trans('messages.edit') }}
 				</a>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>	  		
-		<!-- if there are creation errors, they will show here -->
-		@if($errors->all())
-			<div class="alert alert-danger">
-				{!! HTML::ul($errors->all()) !!}

-		
-
-		<ul class="list-group list-group-flush">
-		    <li class="list-group-item"><h4>{!! trans('terms.name').': ' !!}<small>{!! $organism->name !!}</small></h4></li>
-		    <li class="list-group-item"><h5>{!! trans('terms.description').': ' !!}<small>{!! $organism->description !!}</small></h5></li>
-		    <li class="list-group-item"><h5>{!! trans_choice('menu.drug', 2).': ' !!}<small>{!! implode(", ", $organism->drugs->lists('name')->toArray()) !!}</small></h5></li>
-	  	</ul>
+		</div>
+		<div class="panel-body">
+			<div class="display-details">
+				<h3 class="view"><strong>{{ Lang::choice('messages.name',1) }}:</strong>{{ $organism->name }} </h3>
+				<p class="view-striped"><strong>{{ trans('messages.description') }}:</strong>
+					{{ $organism->description }}</p>
+				<p class="view-striped"><strong>{{ trans('messages.compatible-drugs') }}:</strong>
+					{{ implode(", ", $organism->drugs->lists('name')) }}
+				</p>
+			</div>
+		</div>
 	</div>
-</div>
-@endsection	
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/patient/create.blade.php b/resources/views/patient/create.blade.php
index f741182..624c30e 100755
--- a/resources/views/patient/create.blade.php
+++ b/resources/views/patient/create.blade.php
@@ -1,85 +1,66 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li><a href="{!! url('patient') !!}"><i class="fa fa-street-view"></i> {!! trans('menu.patient-register') !!}</a></li>
-            <li class="active">{!! trans('action.new').' '.trans_choice('menu.patient', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-pencil"></i> {!! trans('action.new').' '.trans_choice('menu.patient', 1) !!} 
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
+	<div>
+		<ol class="breadcrumb">
+		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+		  <li><a href="{{ URL::route('patient.index') }}">{{ Lang::choice('messages.patient',2) }}</a></li>
+		  <li class="active">{{trans('messages.create-patient')}}</li>
+		</ol>
+	</div>
+	<div class="panel panel-primary">
+		<div class="panel-heading ">
+			<span class="glyphicon glyphicon-user"></span>
+			{{trans('messages.create-patient')}}
 		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
+		<div class="panel-body">
+		<!-- if there are creation errors, they will show here -->
+			
 			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
+				<div class="alert alert-danger">
+					{{ HTML::ul($errors->all()) }}
+				</div>
+			
 
-			{!! Form::open(array('route' => 'patient.store', 'id' => 'form-create-patient')) !!}
-				<!-- CSRF Token -->
-                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-                <!-- ./ csrf token -->
-                <div class="form-group row">
-					{!! Form::label('patient_number', trans('terms.patient-no'), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('patient_number', $lastInsertId, array('class' => 'form-control')) !!}
-					</div>
+			{{ Form::open(array('url' => 'patient', 'id' => 'form-create-patient')) }}
+				
+					{{ Form::label('patient_number', trans('messages.patient-number')) }}
+					{{ Form::text('patient_number', $lastInsertId,
+						array('class' => 'form-control')) }}
+				</div>
+				
+					{{ Form::label('name', trans('messages.names')) }}
+					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
 				</div>
-				<div class="form-group row">
-					{!! Form::label('name', trans_choice('terms.name',1), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
-					</div>
+				
+					{{ Form::label('dob', trans('messages.date-of-birth')) }}
+					{{ Form::text('dob', Input::old('dob'), 
+						array('class' => 'form-control standard-datepicker')) }}
 				</div>
-                <div class="form-group row">
-                    {!! Form::label('dob', trans('terms.date-of-birth'), array('class' => 'col-sm-2 form-control-label')) !!}
-                    <div class="col-sm-6 input-group date datepicker"  style="padding-left:15px;">
-                        {!! Form::text('dob', old('dob'), array('class' => 'form-control')) !!}
-                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
-                    </div>
-                </div>
-                <div class="form-group row">
-                    {!! Form::label('gender', trans('terms.gender'), array('class' => 'col-sm-2 form-control-label')) !!}
-                    <div class="col-sm-6">
-                        <label class="radio-inline">{!! Form::radio('gender', App\Models\User::MALE, true) !!}{!! trans_choice('terms.sex', 1) !!}</label>
-                        <label class="radio-inline">{!! Form::radio("gender", App\Models\User::FEMALE, false) !!}{!! trans_choice('terms.sex', 2) !!}</label>
-                    </div>
-                </div>
-                <div class="form-group row">
-                    {!! Form::label('phone', trans('terms.phone'), array('class' => 'col-sm-2 form-control-label')) !!}
-                    <div class="col-sm-6">
-                        {!! Form::text('phone', old('phone'), array('class' => 'form-control')) !!}
-                    </div>
-                </div>
-				<div class="form-group row">
-					{!! Form::label('address', trans("terms.address"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
-					<div class="col-sm-6">
-						{!! Form::textarea('address', old('address'), array('class' => 'form-control', 'rows' => '2')) !!}
-					</div>
+				
+					{{ Form::label('gender', trans('messages.gender')) }}
+					<div>{{ Form::radio('gender', '0', true) }}
+					<span class="input-tag">{{trans('messages.male')}}</span></div>
+					<div>{{ Form::radio("gender", '1', false) }}
+					<span class="input-tag">{{trans('messages.female')}}</span></div>
 				</div>
-				<div class="form-group row col-sm-offset-2">
-					{!! Form::button("<i class='fa fa-plus-circle'></i> ".trans('action.save'), 
-						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
+				
+					{{ Form::label('address', trans('messages.physical-address')) }}
+					{{ Form::text('address', Input::old('address'), array('class' => 'form-control')) }}
+				</div>
+				
+					{{ Form::label('phone_number', trans('messages.phone-number')) }}
+					{{ Form::text('phone_number', Input::old('phone_number'), array('class' => 'form-control')) }}
+				</div>
+				
+					{{ Form::label('email', trans('messages.email-address')) }}
+					{{ Form::email('email', Input::old('email'), array('class' => 'form-control')) }}
+				</div>
+				<div class="form-group actions-row">
+					{{ Form::button('<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'), 
+						['class' => 'btn btn-primary', 'onclick' => 'submit()']) }}
 				</div>
 
-			{!! Form::close() !!}
-	  	</div>
+			{{ Form::close() }}
+		</div>
 	</div>
-</div>
-@endsection	
\ No newline at end of file
+@stop	
\ No newline at end of file
diff --git a/resources/views/patient/edit.blade.php b/resources/views/patient/edit.blade.php
index f4cf8a9..0d01741 100755
--- a/resources/views/patient/edit.blade.php
+++ b/resources/views/patient/edit.blade.php
@@ -1,90 +1,64 @@
-@extends("app")
-
+	@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li><a href="{!! url('patient') !!}"><i class="fa fa-street-view"></i> {!! trans('menu.patient-register') !!}</a></li>
-            <li class="active">{!! trans('action.edit').' '.trans_choice('menu.patient', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-edit"></i> {!! trans('action.edit').' '.trans_choice('menu.patient', 1) !!} 
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>
-				<a class="btn btn-sm btn-wet-asphalt" 
-					href="{!! route('test.create', array('patient_id' => $patient->id)) !!}">
-					<i class="fa fa-eyedropper"></i>
-					{!! trans('action.new').' '.trans_choice('menu.test', 1) !!}
-				</a>				
-			</span>
+	<div>
+		<ol class="breadcrumb">
+		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+		  <li><a href="{{ URL::route('patient.index') }}">{{ Lang::choice('messages.patient',2)}}</a></li>
+		  <li class="active">{{trans('messages.edit-patient')}}</li>
+		</ol>
+	</div>
+	<div class="panel panel-primary">
+		<div class="panel-heading ">
+			<span class="glyphicon glyphicon-edit"></span>
+			{{trans('messages.edit-patient-details')}}
 		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
+		<div class="panel-body">
 			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
+				<div class="alert alert-danger">
+					{{ HTML::ul($errors->all()) }}
+				</div>
+			
+			{{ Form::model($patient, array('route' => array('patient.update', $patient->id), 'method' => 'PUT',
+				'id' => 'form-edit-patient')) }}
 
-			{!! Form::model($patient, array('route' => array('patient.update', $patient->id), 'method' => 'PUT', 'id' => 'form-edit-patient')) !!}
-				<!-- CSRF Token -->
-                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-                <!-- ./ csrf token -->
-                <div class="form-group row">
-					{!! Form::label('patient_number', trans('terms.patient-no'), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('patient_number', old('patient_number'), array('class' => 'form-control')) !!}
-					</div>
+				
+					{{ Form::label('patient_number', trans('messages.patient-number')) }}
+					{{ Form::text('patient_number', Input::old('patient_number'), 
+						array('class' => 'form-control', 'readonly')) }}
 				</div>
-				<div class="form-group row">
-					{!! Form::label('name', trans_choice('terms.name',1), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
-					</div>
+				
+					{{ Form::label('name', Lang::choice('messages.name',1)) }}
+					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
 				</div>
-                <div class="form-group row">
-                    {!! Form::label('dob', trans('terms.date-of-birth'), array('class' => 'col-sm-2 form-control-label')) !!}
-                    <div class="col-sm-6 input-group date datepicker"  style="padding-left:15px;">
-                        {!! Form::text('dob', old('dob'), array('class' => 'form-control')) !!}
-                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
-                    </div>
-                </div>
-                <div class="form-group row">
-                    {!! Form::label('gender', trans('terms.gender'), array('class' => 'col-sm-2 form-control-label')) !!}
-                    <div class="col-sm-6">
-                        <label class="radio-inline">{!! Form::radio('gender', App\Models\User::MALE, true) !!}{!! trans_choice('terms.sex', 1) !!}</label>
-                        <label class="radio-inline">{!! Form::radio("gender", App\Models\User::FEMALE, false) !!}{!! trans_choice('terms.sex', 2) !!}</label>
-                    </div>
-                </div>
-                <div class="form-group row">
-                    {!! Form::label('phone', trans('terms.phone'), array('class' => 'col-sm-2 form-control-label')) !!}
-                    <div class="col-sm-6">
-                        {!! Form::text('phone', old('phone'), array('class' => 'form-control')) !!}
-                    </div>
+				
+					{{ Form::label('dob', trans('messages.date-of-birth')) }}
+					{{ Form::text('dob', Input::old('dob'), array('class' => 'form-control standard-datepicker')) }}
+				</div>
+                
+                    {{ Form::label('gender', trans('messages.gender')) }}
+                    <div>{{ Form::radio('gender', '0', true) }}
+                    	<span class="input-tag">{{trans('messages.male')}}</span></div>
+                    <div>{{ Form::radio("gender", '1', false) }}
+                    	<span class="input-tag">{{trans('messages.female')}}</span></div>
                 </div>
-				<div class="form-group row">
-					{!! Form::label('address', trans("terms.address"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
-					<div class="col-sm-6">
-						{!! Form::textarea('address', old('address'), array('class' => 'form-control', 'rows' => '2')) !!}
-					</div>
+				
+					{{ Form::label('address', trans('messages.physical-address')) }}
+					{{ Form::text('address', Input::old('address'), array('class' => 'form-control')) }}
+				</div>
+				
+					{{ Form::label('phone_number', trans('messages.phone-number')) }}
+					{{ Form::text('phone_number', Input::old('phone_number'), array('class' => 'form-control')) }}
 				</div>
-				<div class="form-group row col-sm-offset-2">
-					{!! Form::button("<i class='fa fa-plus-circle'></i> ".trans('action.update'), 
-						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
+				
+					{{ Form::label('email', trans('messages.email-address')) }}
+					{{ Form::email('email', Input::old('email'), array('class' => 'form-control')) }}
+				</div>
+				<div class="form-group actions-row">
+					{{ Form::button('<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'),
+						 array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
 				</div>
 
-			{!! Form::close() !!}
-	  	</div>
+			{{ Form::close() }}
+		</div>
 	</div>
-</div>
-@endsection	
\ No newline at end of file
+@stop	
\ No newline at end of file
diff --git a/resources/views/patient/index.blade.php b/resources/views/patient/index.blade.php
index 46a6461..65329e7 100755
--- a/resources/views/patient/index.blade.php
+++ b/resources/views/patient/index.blade.php
@@ -1,112 +1,96 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-street-view"></i> {!! trans('menu.patient-register') !!}</li>
-        </ul>
-    </div>
+<div>
+	<ol class="breadcrumb">
+	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+	  <li class="active">{{ Lang::choice('messages.patient',2) }}</li>
+	</ol>
 </div>
-<div class="conter-wrapper">
-	<div class="row">
-		<div class="col-sm-12">
-			<div class="card">
-				<div class="card-header">
-				    <i class="fa fa-book"></i> {!! trans('menu.patient-register') !!} 
-				    <span>
-					    <a class="btn btn-sm btn-belize-hole" href="{!! url("patient/create") !!}" >
-							<i class="fa fa-plus-circle"></i>
-							{!! trans('action.new').' '.trans_choice('menu.patient', 1) !!}
-						</a>
-						<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-							<i class="fa fa-step-backward"></i>
-							{!! trans('action.back') !!}
-						</a>				
-					</span>
+
+<div class='container-fluid'>
+	<div class='row'>
+		<div class='col-md-12'>
+			{{ Form::open(array('route' => array('patient.index'), 'class'=>'form-inline',
+				'role'=>'form', 'method'=>'GET')) }}
+				
+
+				    {{ Form::label('search', "search", array('class' => 'sr-only')) }}
+		            {{ Form::text('search', Input::get('search'), array('class' => 'form-control test-search')) }}
 				</div>
-			  	<div class="card-block">	  		
-					@if (Session::has('message'))
-						<div class="alert alert-info">{!! Session::get('message') !!}</div>
-					
-					@if($errors->all())
-		            <div class="alert alert-danger alert-dismissible" role="alert">
-		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-		            </div>
-		            
-		            <div class='col-md-12' style="padding-bottom:5px;">
-						{!! Form::open(array('route' => array('patient.index'), 'class'=>'form-inline',
-							'role'=>'form', 'method'=>'GET')) !!}
-							
+				
+					{{ Form::button("<span class='glyphicon glyphicon-search'></span> ".trans('messages.search'), 
+				        array('class' => 'btn btn-primary', 'type' => 'submit')) }}
+				</div>
+			{{ Form::close() }}
+		</div>
+	</div>
+</div>
 
-							    {!! Form::label('search', "search", array('class' => 'sr-only')) !!}
-					            {!! Form::text('search', Input::get('search'), array('class' => 'form-control test-search')) !!}
-							</div>
-							
-								{!! Form::button("<i class='fa fa-search'></i> ".trans('terms.search'), 
-							        array('class' => 'btn btn-sm btn-primary', 'type' => 'submit')) !!}
-							</div>
-						{!! Form::close() !!}
-					</div>
-				 	<table class="table table-bordered table-sm search-table">
-						<thead>
-							<tr>
-								<th>{!! trans('terms.patient-no') !!}</th>
-								<th>{!! trans('terms.name') !!}</th>
-								<th>{!! trans('terms.phone') !!}</th>
-								<th>{!! trans('terms.gender') !!}</th>
-								<th>{!! trans('terms.date-of-birth') !!}</th>
-								<th></th>
-							</tr>
-						</thead>
-						<tbody>
-						@foreach($patients as $patient)
-							<tr @if(session()->has('active_patient'))
-				                    {!! (session('active_patient') == $value->id)?"class='warning'":"" !!}
-				                
-				                >
-								<td>{!! $patient->patient_number !!}</td>
-								<td>{!! $patient->name !!}</td>
-								<td>{!! $patient->phone_number !!}</td>
-								<td>{!! ($patient->gender==0?trans_choice('terms.sex', 1):trans_choice('terms.sex', 2)) !!}</td>
-								<td>{!! $patient->dob !!}</td>
-								
-								<td>
-									<a class="btn btn-sm btn-wet-asphalt" 
-										href="{!! route('test.create', array('patient_id' => $patient->id)) !!}">
-										<i class="fa fa-eyedropper"></i>
-										{!! trans('action.new').' '.trans_choice('menu.test', 1) !!}
-									</a>
-								<!-- show the test category (uses the show method found at GET /patient/{id} -->
-									<a class="btn btn-sm btn-success" href="{!! url("patient/" . $patient->id) !!}" >
-										<i class="fa fa-folder-open-o"></i>
-										{!! trans('action.view') !!}
-									</a>
+	<br>
 
-								<!-- edit this test category (uses edit method found at GET /patient/{id}/edit -->
-									<a class="btn btn-sm btn-info" href="{!! url("patient/" . $patient->id . "/edit") !!}" >
-										<i class="fa fa-edit"></i>
-										{!! trans('action.edit') !!}
-									</a>
-									
-								<!-- delete this test category (uses delete method found at GET /patient/{id}/delete -->
-									<button class="btn btn-sm btn-danger delete-item-link"
-										data-toggle="modal" data-target=".confirm-delete-modal"	
-										data-id='{!! url("patient/" . $patient->id . "/delete") !!}'>
-										<i class="fa fa-trash-o"></i>
-										{!! trans('action.delete') !!}
-									</button>
-								</td>
-							</tr>
-						@endforeach
-						</tbody>
-					</table>
-			  	</div>
-			</div>
+@if (Session::has('message'))
+	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
+
+
+<div class="panel panel-primary">
+	<div class="panel-heading ">
+		<span class="glyphicon glyphicon-user"></span>
+		{{trans('messages.list-patients')}}
+		<div class="panel-btn">
+			<a class="btn btn-sm btn-info" href="{{ URL::route('patient.create') }}">
+				<span class="glyphicon glyphicon-plus-sign"></span>
+				{{trans('messages.new-patient')}}
+			</a>
 		</div>
 	</div>
-	{!! session(['SOURCE_URL' => URL::full()]) !!}
+	<div class="panel-body">
+		<table class="table table-striped table-hover table-condensed">
+			<thead>
+				<tr>
+					<th>{{trans('messages.patient-number')}}</th>
+					<th>{{Lang::choice('messages.name',1)}}</th>
+					<th>{{trans('messages.gender')}}</th>
+					<th>{{trans('messages.date-of-birth')}}</th>
+					<th>{{trans('messages.actions')}}</th>
+				</tr>
+			</thead>
+			<tbody>
+			@foreach($patients as $key => $patient)
+				<tr  @if(Session::has('activepatient'))
+						{{(Session::get('activepatient') == $patient->id)?"class='info'":""}}
+					
+				>
+					<td>{{ $patient->patient_number }}</td>
+					<td>{{ $patient->name }}</td>
+					<td>{{ ($patient->gender==0?trans('messages.male'):trans('messages.female')) }}</td>
+					<td>{{ $patient->dob }}</td>
+
+					<td>
+						@if(Auth::user()->can('request_test'))
+						<a class="btn btn-sm btn-info" 
+							href="{{ URL::route('test.create', array('patient_id' => $patient->id)) }}">
+							<span class="glyphicon glyphicon-edit"></span>
+							{{ trans('messages.new-test') }}
+						</a>
+						
+						<!-- show the patient (uses the show method found at GET /patient/{id} -->
+						<a class="btn btn-sm btn-success" href="{{ URL::route('patient.show', array($patient->id)) }}" >
+							<span class="glyphicon glyphicon-eye-open"></span>
+							{{trans('messages.view')}}
+						</a>
+
+						<!-- edit this patient (uses the edit method found at GET /patient/{id}/edit -->
+						<a class="btn btn-sm btn-info" href="{{ URL::route('patient.edit', array($patient->id)) }}" >
+							<span class="glyphicon glyphicon-edit"></span>
+							{{trans('messages.edit')}}
+						</a>
+					</td>
+				</tr>
+			@endforeach
+			</tbody>
+		</table>
+		<?php echo $patients->links(); 
+		Session::put('SOURCE_URL', URL::full());?>
+	</div>
 </div>
-@endsection
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/patient/show.blade.php b/resources/views/patient/show.blade.php
index 7e3afa6..ad1675d 100755
--- a/resources/views/patient/show.blade.php
+++ b/resources/views/patient/show.blade.php
@@ -1,55 +1,50 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li><a href="{!! url('patient') !!}"><i class="fa fa-street-view"></i> {!! trans('menu.patient-register') !!}</a></li>
-            <li class="active">{!! trans('action.view').' '.trans_choice('menu.patient', 1) !!}</li>
-        </ul>
+    <div>
+        <ol class="breadcrumb">
+          <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+          <li><a href="{{ URL::route('patient.index') }}">{{ Lang::choice('messages.patient',2) }}</a></li>
+          <li class="active">{{ trans('messages.patient-details') }}</li>
+        </ol>
     </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-file-text"></i> <strong>{!! trans('terms.details-for').': '.$patient->name !!}</strong>
-		    <span>
-		    	<a class="btn btn-sm btn-belize-hole" href="{!! url("patient/create") !!}" >
-					<i class="fa fa-plus-circle"></i>
-					{!! trans('action.new').' '.trans_choice('menu.patient', 1) !!}
-				</a>
-				<a class="btn btn-sm btn-info" href="{!! url("patient/" . $patient->id . "/edit") !!}" >
-					<i class="fa fa-edit"></i>
-					{!! trans('action.edit') !!}
-				</a>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>
-				<a class="btn btn-sm btn-wet-asphalt" 
-					href="{!! route('test.create', array('patient_id' => $patient->id)) !!}">
-					<i class="fa fa-eyedropper"></i>
-					{!! trans('action.new').' '.trans_choice('menu.test', 1) !!}
-				</a>				
-			</span>
-		</div>	  		
-		<!-- if there are creation errors, they will show here -->
-		@if($errors->all())
-			<div class="alert alert-danger">
-				{!! HTML::ul($errors->all()) !!}
-			</div>
-		
-
-		<ul class="list-group list-group-flush">
-		    <li class="list-group-item"><h4>{!! trans('terms.name').': ' !!}<small>{!! $patient->name !!}</small></h4></li>
-		    <li class="list-group-item"><h5>{!! trans('terms.patient-no').': ' !!}<small>{!! $patient->patient_number !!}</small></h5></li>
-		    <li class="list-group-item"><h6>{!! trans('terms.external-no').': ' !!}<small>{!! $patient->external_patient_number !!}</small></h6></li>
-		    <li class="list-group-item"><h6>{!! trans('terms.date-of-birth').': ' !!}<small>{!! $patient->dob !!}</small></h6></li>
-		    <li class="list-group-item"><h6>{!! trans('terms.gender').': ' !!}<small>{!! ($patient->gender==0?trans_choice('terms.sex', 1):trans_choice('terms.sex', 2)) !!}</small></h6></li>
-		    <li class="list-group-item"><h6>{!! trans('terms.phone').': ' !!}<small>{!! $patient->phone_number !!}</small></h6></li>
-		    <li class="list-group-item"><h6>{!! trans('terms.address').': ' !!}<small>{!! $patient->address !!}</small></h6></li>
-	  	</ul>
-	</div>
-</div>
-@endsection	
\ No newline at end of file
+    <div class="panel panel-primary">
+        <div class="panel-heading">
+            <span class="glyphicon glyphicon-user"></span>
+            {{ trans('messages.patient-details') }}
+            <div class="panel-btn">
+                <a class="btn btn-sm btn-info" href="{{ URL::route('patient.edit', array($patient->id)) }}">
+                    <span class="glyphicon glyphicon-edit"></span>
+                    {{ trans('messages.edit') }}
+                </a>
+                @if(Auth::user()->can('request_test'))
+                <a class="btn btn-sm btn-info" 
+                    href="{{ URL::route('test.create', array('patient_id' => $patient->id)) }}">
+                    <span class="glyphicon glyphicon-edit"></span>
+                    {{ trans('messages.new-test') }}
+                </a>
+                
+            </div>
+        </div>
+        <div class="panel-body">
+            <div class="display-details">
+                <h3 class="view"><strong>{{ Lang::choice('messages.name',1) }}</strong>{{ $patient->name }} </h3>
+                <p class="view-striped"><strong>{{ trans('messages.patient-number') }}</strong>
+                    {{ $patient->patient_number }}</p>
+                <p class="view"><strong>{{ trans('messages.external-patient-number') }}</strong>
+                    {{ $patient->external_patient_number }}</p>
+                <p class="view-striped"><strong>{{ trans('messages.date-of-birth') }}</strong>
+                    {{ $patient->dob }}</p>
+                <p class="view"><strong>{{ trans('messages.gender') }}</strong>
+                    {{ ($patient->gender==0?trans('messages.male'):trans('messages.female')) }}</p>
+                <p class="view-striped"><strong>{{ trans('messages.physical-address') }}</strong>
+                    {{ $patient->address }}</p>
+                <p class="view"><strong>{{ trans('messages.phone-number') }}</strong>
+                    {{ $patient->phone_number }}</p>
+                <p class="view-striped"><strong>{{ trans('messages.email-address') }}</strong>
+                    {{ $patient->email }}</p>
+                <p class="view"><strong>{{ trans('messages.date-created') }}</strong>
+                    {{ $patient->created_at }}</p>
+            </div>
+        </div>
+    </div>
+@stop
\ No newline at end of file
diff --git a/resources/views/rejection/create.blade.php b/resources/views/rejection/create.blade.php
deleted file mode 100755
index 795ef3e..0000000
--- a/resources/views/rejection/create.blade.php
+++ /dev/null
@@ -1,60 +0,0 @@
-@extends("app")
-
-@section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li><a href="{!! route('rejection.index') !!}"><i class="fa fa-cube"></i> {!! trans('menu.specimen-rejection') !!}</a></li>
-            <li class="active">{!! trans('action.new').' '.trans('terms.reject-reason') !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-pencil"></i> {!! trans('action.new').' '.trans('terms.reject-reason') !!} 
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
-			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
-
-			{!! Form::open(array('route' => 'rejection.store', 'id' => 'form-create-rejection')) !!}
-				<!-- CSRF Token -->
-                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-                <!-- ./ csrf token -->
-				<div class="form-group row">
-					{!! Form::label('name', trans_choice('terms.name',1), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
-					</div>
-				</div>
-				<div class="form-group row">
-					{!! Form::label('description', trans("terms.description"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
-					<div class="col-sm-6">
-						{!! Form::textarea('description', old('description'), array('class' => 'form-control', 'rows' => '2')) !!}
-					</div>
-				</div>
-				<div class="form-group row col-sm-offset-2">
-					{!! Form::button("<i class='fa fa-plus-circle'></i> ".trans('action.save'), 
-						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
-				</div>
-
-			{!! Form::close() !!}
-	  	</div>
-	</div>
-</div>
-@endsection	
\ No newline at end of file
diff --git a/resources/views/rejection/edit.blade.php b/resources/views/rejection/edit.blade.php
deleted file mode 100755
index 91fdca8..0000000
--- a/resources/views/rejection/edit.blade.php
+++ /dev/null
@@ -1,61 +0,0 @@
-@extends("app")
-
-@section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li><a href="{!! route('rejection.index') !!}"><i class="fa fa-cube"></i> {!! trans('menu.specimen-rejection') !!}</a></li>
-            <li class="active">{!! trans('action.edit').' '.trans('terms.reject-reason') !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-edit"></i> {!! trans('action.edit').' '.trans('terms.reject-reason') !!} 
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
-			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
-
-			{!! Form::model($rejection, array('route' => array('rejection.update', $rejection->id), 
-				'method' => 'PUT', 'id' => 'form-edit-rejection')) !!}
-				<!-- CSRF Token -->
-                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-                <!-- ./ csrf token -->
-				<div class="form-group row">
-					{!! Form::label('name', trans_choice('terms.name',1), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('name', old('reason'), array('class' => 'form-control')) !!}
-					</div>
-				</div>
-				<div class="form-group row">
-					{!! Form::label('description', trans("terms.description"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
-					<div class="col-sm-6">
-						{!! Form::textarea('description', old('description'), array('class' => 'form-control', 'rows' => '2')) !!}
-					</div>
-				</div>
-				<div class="form-group row col-sm-offset-2">
-					{!! Form::button("<i class='fa fa-check-circle'></i> ".trans('action.update'), 
-						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
-				</div>
-
-			{!! Form::close() !!}
-	  	</div>
-	</div>
-</div>
-@endsection
\ No newline at end of file
diff --git a/resources/views/rejection/index.blade.php b/resources/views/rejection/index.blade.php
deleted file mode 100755
index bb807d9..0000000
--- a/resources/views/rejection/index.blade.php
+++ /dev/null
@@ -1,89 +0,0 @@
-@extends("app")
-
-@section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li><a href="{!! route('role.index') !!}"><i class="fa fa-cube"></i> {!! trans('menu.specimen-rejection') !!}</a></li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="row">
-		<div class="col-sm-12">
-			<div class="card">
-				<div class="card-header">
-				    <i class="fa fa-book"></i> {!! trans('menu.specimen-rejection') !!} 
-				    <span>
-					    <a class="btn btn-sm btn-belize-hole" href="{!! url("rejection/create") !!}" >
-							<i class="fa fa-plus-circle"></i>
-							{!! trans('action.new').' '.trans('terms.reject-reason') !!}
-						</a>
-						<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-							<i class="fa fa-step-backward"></i>
-							{!! trans('action.back') !!}
-						</a>				
-					</span>
-				</div>
-			  	<div class="card-block">	  		
-					@if (Session::has('message'))
-						<div class="alert alert-info">{!! Session::get('message') !!}</div>
-					
-					@if($errors->all())
-		            <div class="alert alert-danger alert-dismissible" role="alert">
-		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-		            </div>
-		            
-				 	<table class="table table-bordered table-sm search-table">
-						<thead>
-							<tr>
-								<th>{!! trans('terms.name') !!}</th>
-								<th>{!! trans('terms.description') !!}</th>
-								<th></th>
-							</tr>
-						</thead>
-						<tbody>
-						@foreach($rejections as $key => $value)
-							<tr @if(session()->has('active_rejection'))
-				                    {!! (session('active_rejection') == $value->id)?"class='warning'":"" !!}
-				                
-				                >
-								<td>{!! $value->reason !!}</td>
-								<td>{!! $value->description !!}</td>
-								
-								<td>
-
-								<!-- show the test category (uses the show method found at GET /rejection/{id} -->
-									<a class="btn btn-sm btn-success" href="{!! url("rejection/" . $value->id) !!}" >
-										<i class="fa fa-folder-open-o"></i>
-										{!! trans('action.view') !!}
-									</a>
-
-								<!-- edit this test category (uses edit method found at GET /rejection/{id}/edit -->
-									<a class="btn btn-sm btn-info" href="{!! url("rejection/" . $value->id . "/edit") !!}" >
-										<i class="fa fa-edit"></i>
-										{!! trans('action.edit') !!}
-									</a>
-									
-								<!-- delete this test category (uses delete method found at GET /rejection/{id}/delete -->
-									<button class="btn btn-sm btn-danger delete-item-link"
-										data-toggle="modal" data-target=".confirm-delete-modal"	
-										data-id='{!! url("rejection/" . $value->id . "/delete") !!}'>
-										<i class="fa fa-trash-o"></i>
-										{!! trans('action.delete') !!}
-									</button>
-								</td>
-							</tr>
-						@endforeach
-						</tbody>
-					</table>
-			  	</div>
-			</div>
-		</div>
-	</div>
-	{!! session(['SOURCE_URL' => URL::full()]) !!}
-</div>
-@endsection
\ No newline at end of file
diff --git a/resources/views/rejection/show.blade.php b/resources/views/rejection/show.blade.php
deleted file mode 100755
index d1b6505..0000000
--- a/resources/views/rejection/show.blade.php
+++ /dev/null
@@ -1,46 +0,0 @@
-@extends("app")
-
-@section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li><a href="{!! route('rejection.index') !!}"><i class="fa fa-cube"></i> {!! trans('menu.specimen-rejection') !!}</a></li>
-            <li class="active">{!! trans('action.view').' '.trans('terms.reject-reason') !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-file-text"></i> <strong>{!! trans('terms.details-for').': '.$rejection->reason !!}</strong>
-		    <span>
-		    	<a class="btn btn-sm btn-belize-hole" href="{!! url("rejection/create") !!}" >
-					<i class="fa fa-plus-circle"></i>
-					{!! trans('action.new').' '.trans('terms.reject-reason') !!}
-				</a>
-				<a class="btn btn-sm btn-info" href="{!! url("rejection/" . $rejection->id . "/edit") !!}" >
-					<i class="fa fa-edit"></i>
-					{!! trans('action.edit') !!}
-				</a>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>	  		
-		<!-- if there are creation errors, they will show here -->
-		@if($errors->all())
-			<div class="alert alert-danger">
-				{!! HTML::ul($errors->all()) !!}
-			</div>
-		
-
-		<ul class="list-group list-group-flush">
-		    <li class="list-group-item"><h4>{!! trans('terms.name').': ' !!}<small>{!! $rejection->reason !!}</small></h4></li>
-		    <li class="list-group-item"><h5>{!! trans('terms.description').': ' !!}<small>{!! $rejection->description !!}</small></h5></li>
-	  	</ul>
-	</div>
-</div>
-@endsection	
\ No newline at end of file
diff --git a/resources/views/report/aggregate/count/groupedSpecimen.blade.php b/resources/views/report/aggregate/count/groupedSpecimen.blade.php
deleted file mode 100755
index c622357..0000000
--- a/resources/views/report/aggregate/count/groupedSpecimen.blade.php
+++ /dev/null
@@ -1,115 +0,0 @@
-@extends("app")
-
-@section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-chart"></i> {!! trans_choice('menu.report', 2) !!}</li>
-            <li class="active"><i class="fa fa-clock-o"></i> {!! trans('menu.aggregate-report') !!}</li>
-            <li class="active"> {!! trans('menu.grouped-specimen') !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="row">
-		<div class="col-sm-12">
-			<div class="card">
-				<div class="card-header">
-				    <i class="fa fa-book"></i> {!! trans('menu.grouped-specimen') !!} 
-				    <span>
-					    <a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-							<i class="fa fa-step-backward"></i>
-							{!! trans('action.back') !!}
-						</a>				
-					</span>
-				</div>
-			  	<div class="card-block">	  		
-					@if (Session::has('message'))
-						<div class="alert alert-info">{!! Session::get('message') !!}</div>
-					
-					@if($errors->all())
-		            <div class="alert alert-danger alert-dismissible" role="alert">
-		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-		            </div>
-		            
-			        {!! Form::open(array('route' => array('reports.aggregate.counts'), 'class' => 'form-inline', 'role' => 'form')) !!}
-			            <div class='col-md-12'>
-			            	<div class='col-md-4'>
-			                    {!! Form::label('date_from', trans('terms.from').':', array('class' => 'col-sm-3 form-control-label')) !!}
-			                    <div class='col-md-9 input-group date datepicker'>
-			                        {!! Form::text('from', old('from') ? old('from') : $from, array('class' => 'form-control')) !!}
-			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
-			                    </div>
-			                </div>
-			                <div class='col-md-4'>
-			                    {!! Form::label('date_to', trans('terms.to').':', array('class' => 'col-sm-2 form-control-label')) !!}
-			                    <div class='col-md-10 input-group date datepicker'>
-			                        {!! Form::text('to', old('to') ? old('to') : $to, array('class' => 'form-control')) !!}
-			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
-			                    </div>
-			                </div>
-			                <div class='col-md-4'>
-								{!! Form::button("<i class='fa fa-filter'></i> ".trans('action.filter'), array('class' => 'btn btn-sm btn-primary', 'type' => 'submit', 'id' => 'filter')) !!}
-								{!! Form::button("<i class='fa fa-file-word-o'></i> ".trans('action.export'), array('class' => 'btn btn-sm btn-midnight-blue', 'type' => 'submit', 'id' => 'word', 'value' => 'word', 'name' => 'word')) !!}
-			                </div>
-		                </div>
-		                <div class='col-md-12' style="padding-bottom:5px;">
-		                	<div id="radioBtn" class="btn-group">
-	                            <a class="btn btn-sm btn-asbestos btn {{($counts==trans('menu.ungrouped-test'))?'active':'notActive'}}" data-toggle="counts" data-title="{!! trans('menu.ungrouped-test') !!}" name="counts">{!! trans('menu.ungrouped-test') !!}</a>
-	                            <a class="btn btn-sm btn-asbestos btn {{($counts==trans('menu.grouped-test'))?'active':'notActive'}}" data-toggle="counts" data-title="{!! trans('menu.grouped-test') !!}" name="counts">{!! trans('menu.grouped-test') !!}</a>
-	                            <a class="btn btn-sm btn-asbestos btn {{($counts==trans('menu.ungrouped-specimen'))?'active':'notActive'}}" data-toggle="counts" data-title="{!! trans('menu.ungrouped-specimen') !!}" name="counts">{!! trans('menu.ungrouped-specimen') !!}</a>
-	                            <a class="btn btn-sm btn-asbestos btn {{($counts==trans('menu.grouped-specimen'))?'active':'notActive'}}" data-toggle="counts" data-title="{!! trans('menu.grouped-specimen') !!}" name="counts">{!! trans('menu.grouped-specimen') !!}</a>
-	                        </div>
-            				<input type="hidden" name="counts" id="counts">
-		                </div>
-			        {!! Form::close() !!}
-			        <table class="table table-bordered table-sm" style="font-size:13px;">
-						<thead>
-							<tr>
-								<th rowspan="2">{!! trans_choice('menu.specimen-type', 1) !!}</th>
-								<th rowspan="2">{!! trans('terms.gender') !!}</th>
-								<th colspan="{!! count($ageRanges) !!}">{!! trans('menu.age-range') !!}</th>
-								<th rowspan="2">{!! trans('menu.m-f').' '.trans('menu.total') !!}</th>
-								<th rowspan="2">{!! trans('menu.total') !!}</th>
-							</tr>
-							<tr>
-					  			@foreach($ageRanges as $ageRange)
-					  				<th>{!! $ageRange !!}</th>
-					  			@endforeach
-					  		</tr>
-						</thead>
-						<tbody>
-						@forelse($specimenTypes as $specimenType)
-				  		<tr>
-					  		<td>{!! $specimenType->name !!}</td>
-					  		<td>
-					  			@foreach($gender as $sex)
-					  				{!! $sex==App\Models\Patient::MALE?trans_choice("terms.sex", 1):trans_choice("terms.sex", 2) !!}<br />
-					  			@endforeach
-					  		</td>
-					  		@foreach($ageRanges as $ageRange)
-					  			<td>
-									{!! $perAgeRange[$specimenType->id][$ageRange]["male"] !!}<br />{!! $perAgeRange[$specimenType->id][$ageRange]["female"] !!}<br />
-								</td>
-							@endforeach
-							<td>
-								{!! $perSpecimenType[$specimenType->id]['countMale'] !!}<br />{!! $perSpecimenType[$specimenType->id]['countFemale'] !!}<br />
-					  		</td>
-					  		<td>{!! $perSpecimenType[$specimenType->id]['countAll'] !!}</td>
-					  	</tr>
-					  	@empty
-					  	<tr>
-					  		<td colspan="5">{!! trans('terms.no-records') !!}</td>
-					  	</tr>
-					  	@endforelse
-						</tbody>
-					</table>
-			  	</div>
-			</div>
-		</div>
-	</div>
-	{!! session(['SOURCE_URL' => URL::full()]) !!}
-</div>
-@endsection
\ No newline at end of file
diff --git a/resources/views/report/aggregate/count/groupedTest.blade.php b/resources/views/report/aggregate/count/groupedTest.blade.php
deleted file mode 100755
index 7ec83e1..0000000
--- a/resources/views/report/aggregate/count/groupedTest.blade.php
+++ /dev/null
@@ -1,126 +0,0 @@
-@extends("app")
-
-@section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-chart"></i> {!! trans_choice('menu.report', 2) !!}</li>
-            <li class="active"><i class="fa fa-clock-o"></i> {!! trans('menu.aggregate-report') !!}</li>
-            <li class="active"> {!! trans('menu.grouped-test') !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="row">
-		<div class="col-sm-12">
-			<div class="card">
-				<div class="card-header">
-				    <i class="fa fa-book"></i> {!! trans('menu.grouped-test') !!} 
-				    <span>
-					    <a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-							<i class="fa fa-step-backward"></i>
-							{!! trans('action.back') !!}
-						</a>				
-					</span>
-				</div>
-			  	<div class="card-block">	  		
-					@if (Session::has('message'))
-						<div class="alert alert-info">{!! Session::get('message') !!}</div>
-					
-					@if($errors->all())
-		            <div class="alert alert-danger alert-dismissible" role="alert">
-		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-		            </div>
-		            
-			        {!! Form::open(array('route' => array('reports.aggregate.counts'), 'class' => 'form-inline', 'role' => 'form')) !!}
-			            <div class='col-md-12'>
-			            	<div class='col-md-4'>
-			                    {!! Form::label('date_from', trans('terms.from').':', array('class' => 'col-sm-3 form-control-label')) !!}
-			                    <div class='col-md-9 input-group date datepicker'>
-			                        {!! Form::text('from', old('from') ? old('from') : $from, array('class' => 'form-control')) !!}
-			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
-			                    </div>
-			                </div>
-			                <div class='col-md-4'>
-			                    {!! Form::label('date_to', trans('terms.to').':', array('class' => 'col-sm-2 form-control-label')) !!}
-			                    <div class='col-md-10 input-group date datepicker'>
-			                        {!! Form::text('to', old('to') ? old('to') : $to, array('class' => 'form-control')) !!}
-			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
-			                    </div>
-			                </div>
-			                <div class='col-md-4'>
-								{!! Form::button("<i class='fa fa-filter'></i> ".trans('action.filter'), array('class' => 'btn btn-sm btn-primary', 'type' => 'submit', 'id' => 'filter')) !!}
-								{!! Form::button("<i class='fa fa-file-word-o'></i> ".trans('action.export'), array('class' => 'btn btn-sm btn-midnight-blue', 'type' => 'submit', 'id' => 'word', 'value' => 'word', 'name' => 'word')) !!}
-			                </div>
-		                </div>
-		                <div class='col-md-12' style="padding-bottom:5px;">
-		                	<div id="radioBtn" class="btn-group">
-	                            <a class="btn btn-sm btn-asbestos btn {{($counts==trans('menu.ungrouped-test'))?'active':'notActive'}}" data-toggle="counts" data-title="{!! trans('menu.ungrouped-test') !!}" name="counts">{!! trans('menu.ungrouped-test') !!}</a>
-	                            <a class="btn btn-sm btn-asbestos btn {{($counts==trans('menu.grouped-test'))?'active':'notActive'}}" data-toggle="counts" data-title="{!! trans('menu.grouped-test') !!}" name="counts">{!! trans('menu.grouped-test') !!}</a>
-	                            <a class="btn btn-sm btn-asbestos btn {{($counts==trans('menu.ungrouped-specimen'))?'active':'notActive'}}" data-toggle="counts" data-title="{!! trans('menu.ungrouped-specimen') !!}" name="counts">{!! trans('menu.ungrouped-specimen') !!}</a>
-	                            <a class="btn btn-sm btn-asbestos btn {{($counts==trans('menu.grouped-specimen'))?'active':'notActive'}}" data-toggle="counts" data-title="{!! trans('menu.grouped-specimen') !!}" name="counts">{!! trans('menu.grouped-specimen') !!}</a>
-	                        </div>
-            				<input type="hidden" name="counts" id="counts">
-		                </div>
-			        {!! Form::close() !!}
-			        @forelse($testCategories as $testCategory)
-		  			{!! $testCategory->name !!}
-		            <table class="table table-bordered table-sm" style="font-size:13px;">
-						<thead>
-							<tr>
-								<th rowspan="2">{!! trans_choice('menu.test-type', 1) !!}</th>
-								<th rowspan="2">{!! trans('terms.gender') !!}</th>
-								<th colspan="{!! count($ageRanges) !!}">{!! trans('menu.age-range') !!}</th>
-								<th rowspan="2">{!! trans('menu.m-f').' '.trans('menu.total') !!}</th>
-								<th rowspan="2">{!! trans('menu.total') !!}</th>
-							</tr>
-							<tr>
-					  			@foreach($ageRanges as $ageRange)
-					  				<th>{!! $ageRange !!}</th>
-					  			@endforeach
-					  		</tr>
-						</thead>
-						<tbody>
-						@forelse($testCategory->testTypes as $testType)
-				  		<tr>
-					  		<td>{!! $testType->name !!}</td>
-					  		<td>
-					  			@foreach($gender as $sex)
-					  				{!! $sex==App\Models\Patient::MALE?trans_choice("terms.sex", 1):trans_choice("terms.sex", 2) !!}<br />
-					  			@endforeach
-					  		</td>
-					  		@foreach($ageRanges as $ageRange)
-					  			<td>
-									{!! $perAgeRange[$testType->id][$ageRange]["male"] !!}<br />{!! $perAgeRange[$testType->id][$ageRange]["female"] !!}<br />
-								</td>
-							@endforeach
-							<td>
-								{!! $perTestType[$testType->id]['countMale'] !!}<br />{!! $perTestType[$testType->id]['countFemale'] !!}<br />
-					  		</td>
-					  		<td>{!! $perTestType[$testType->id]['countAll'] !!}</td>
-					  	</tr>
-					  	@empty
-					  	<tr>
-					  		<td colspan="5">{!! trans('messages.no-records-found') !!}</td>
-					  	</tr>
-					  	@endforelse
-						</tbody>
-					</table>
-					@empty
-				  	<table class="table table-striped table-bordered">
-				  		<tbody>
-				  			<tr>
-				  				<td colspan="5">{!! trans('terms.no-records') !!}</td>
-				  			</tr>
-				  		</tbody>
-				  	</table>
-				  	@endforelse
-			  	</div>
-			</div>
-		</div>
-	</div>
-	{!! session(['SOURCE_URL' => URL::full()]) !!}
-</div>
-@endsection
\ No newline at end of file
diff --git a/resources/views/report/aggregate/count/ungroupedSpecimen.blade.php b/resources/views/report/aggregate/count/ungroupedSpecimen.blade.php
deleted file mode 100755
index efe23a4..0000000
--- a/resources/views/report/aggregate/count/ungroupedSpecimen.blade.php
+++ /dev/null
@@ -1,96 +0,0 @@
-@extends("app")
-
-@section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-chart"></i> {!! trans_choice('menu.report', 2) !!}</li>
-            <li class="active"><i class="fa fa-clock-o"></i> {!! trans('menu.aggregate-report') !!}</li>
-            <li class="active"> {!! trans('menu.ungrouped-specimen') !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="row">
-		<div class="col-sm-12">
-			<div class="card">
-				<div class="card-header">
-				    <i class="fa fa-book"></i> {!! trans('menu.ungrouped-specimen') !!} 
-				    <span>
-					    <a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-							<i class="fa fa-step-backward"></i>
-							{!! trans('action.back') !!}
-						</a>				
-					</span>
-				</div>
-			  	<div class="card-block">	  		
-					@if (Session::has('message'))
-						<div class="alert alert-info">{!! Session::get('message') !!}</div>
-					
-					@if($errors->all())
-		            <div class="alert alert-danger alert-dismissible" role="alert">
-		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-		            </div>
-		            
-			        {!! Form::open(array('route' => array('reports.aggregate.counts'), 'class' => 'form-inline', 'role' => 'form')) !!}
-			            <div class='col-md-12'>
-			            	<div class='col-md-4'>
-			                    {!! Form::label('date_from', trans('terms.from').':', array('class' => 'col-sm-3 form-control-label')) !!}
-			                    <div class='col-md-9 input-group date datepicker'>
-			                        {!! Form::text('from', old('from') ? old('from') : $from, array('class' => 'form-control')) !!}
-			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
-			                    </div>
-			                </div>
-			                <div class='col-md-4'>
-			                    {!! Form::label('date_to', trans('terms.to').':', array('class' => 'col-sm-2 form-control-label')) !!}
-			                    <div class='col-md-10 input-group date datepicker'>
-			                        {!! Form::text('to', old('to') ? old('to') : $to, array('class' => 'form-control')) !!}
-			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
-			                    </div>
-			                </div>
-			                <div class='col-md-4'>
-								{!! Form::button("<i class='fa fa-filter'></i> ".trans('action.filter'), array('class' => 'btn btn-sm btn-primary', 'type' => 'submit', 'id' => 'filter')) !!}
-								{!! Form::button("<i class='fa fa-file-word-o'></i> ".trans('action.export'), array('class' => 'btn btn-sm btn-midnight-blue', 'type' => 'submit', 'id' => 'word', 'value' => 'word', 'name' => 'word')) !!}
-			                </div>
-		                </div>
-		                <div class='col-md-12' style="padding-bottom:5px;">
-		                	<div id="radioBtn" class="btn-group">
-	                            <a class="btn btn-sm btn-asbestos btn {{($counts==trans('menu.ungrouped-test'))?'active':'notActive'}}" data-toggle="counts" data-title="{!! trans('menu.ungrouped-test') !!}" name="counts">{!! trans('menu.ungrouped-test') !!}</a>
-	                            <a class="btn btn-sm btn-asbestos btn {{($counts==trans('menu.grouped-test'))?'active':'notActive'}}" data-toggle="counts" data-title="{!! trans('menu.grouped-test') !!}" name="counts">{!! trans('menu.grouped-test') !!}</a>
-	                            <a class="btn btn-sm btn-asbestos btn {{($counts==trans('menu.ungrouped-specimen'))?'active':'notActive'}}" data-toggle="counts" data-title="{!! trans('menu.ungrouped-specimen') !!}" name="counts">{!! trans('menu.ungrouped-specimen') !!}</a>
-	                            <a class="btn btn-sm btn-asbestos btn {{($counts==trans('menu.grouped-specimen'))?'active':'notActive'}}" data-toggle="counts" data-title="{!! trans('menu.grouped-specimen') !!}" name="counts">{!! trans('menu.grouped-specimen') !!}</a>
-	                        </div>
-            				<input type="hidden" name="counts" id="counts">
-		                </div>
-			        {!! Form::close() !!}
-		            <table class="table table-bordered table-sm" style="font-size:13px;">
-						<thead>
-							<tr>
-								<th>{!! trans_choice('menu.specimen-type', 1) !!}</th>
-								<th>{!! trans('menu.accepted') !!}</th>
-								<th>{!! trans('menu.rejected') !!}</th>
-								<th>{!! trans('menu.total') !!}</th>
-							</tr>
-						</thead>
-						<tbody>
-						@forelse($ungroupedSpecimen as $key => $value)
-							<tr>
-								<td>{!! App\Models\SpecimenType::find($key)->name !!}</td>
-						    	<td>{!! $value['accepted'] !!}</td>
-						    	<td>{!! $value['rejected'] !!}</td>
-						    	<td>{!! $value['total'] !!}</td>
-							</tr>
-						@empty
-						<tr><td colspan="4">{!! trans('terms.no-records') !!}</td></tr>
-						@endforelse
-						</tbody>
-					</table>
-			  	</div>
-			</div>
-		</div>
-	</div>
-	{!! session(['SOURCE_URL' => URL::full()]) !!}
-</div>
-@endsection
\ No newline at end of file
diff --git a/resources/views/report/aggregate/count/ungroupedTest.blade.php b/resources/views/report/aggregate/count/ungroupedTest.blade.php
deleted file mode 100755
index 182a161..0000000
--- a/resources/views/report/aggregate/count/ungroupedTest.blade.php
+++ /dev/null
@@ -1,94 +0,0 @@
-@extends("app")
-
-@section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-chart"></i> {!! trans_choice('menu.report', 2) !!}</li>
-            <li class="active"><i class="fa fa-clock-o"></i> {!! trans('menu.aggregate-report') !!}</li>
-            <li class="active"> {!! trans('menu.ungrouped-test') !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="row">
-		<div class="col-sm-12">
-			<div class="card">
-				<div class="card-header">
-				    <i class="fa fa-book"></i> {!! trans('menu.ungrouped-test') !!} 
-				    <span>
-					    <a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-							<i class="fa fa-step-backward"></i>
-							{!! trans('action.back') !!}
-						</a>				
-					</span>
-				</div>
-			  	<div class="card-block">	  		
-					@if (Session::has('message'))
-						<div class="alert alert-info">{!! Session::get('message') !!}</div>
-					
-					@if($errors->all())
-		            <div class="alert alert-danger alert-dismissible" role="alert">
-		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-		            </div>
-		            
-			        {!! Form::open(array('route' => array('reports.aggregate.counts'), 'class' => 'form-inline', 'role' => 'form')) !!}
-			            <div class='col-md-12'>
-			            	<div class='col-md-4'>
-			                    {!! Form::label('date_from', trans('terms.from').':', array('class' => 'col-sm-3 form-control-label')) !!}
-			                    <div class='col-md-9 input-group date datepicker'>
-			                        {!! Form::text('from', old('from') ? old('from') : $from, array('class' => 'form-control')) !!}
-			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
-			                    </div>
-			                </div>
-			                <div class='col-md-4'>
-			                    {!! Form::label('date_to', trans('terms.to').':', array('class' => 'col-sm-2 form-control-label')) !!}
-			                    <div class='col-md-10 input-group date datepicker'>
-			                        {!! Form::text('to', old('to') ? old('to') : $to, array('class' => 'form-control')) !!}
-			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
-			                    </div>
-			                </div>
-			                <div class='col-md-4'>
-								{!! Form::button("<i class='fa fa-filter'></i> ".trans('action.filter'), array('class' => 'btn btn-sm btn-primary', 'type' => 'submit', 'id' => 'filter')) !!}
-								{!! Form::button("<i class='fa fa-file-word-o'></i> ".trans('action.export'), array('class' => 'btn btn-sm btn-midnight-blue', 'type' => 'submit', 'id' => 'word', 'value' => 'word', 'name' => 'word')) !!}
-			                </div>
-		                </div>
-		                <div class='col-md-12' style="padding-bottom:5px;">
-		                	<div id="radioBtn" class="btn-group">
-	                            <a class="btn btn-sm btn-asbestos btn {{($counts==trans('menu.ungrouped-test'))?'active':'notActive'}}" data-toggle="counts" data-title="{!! trans('menu.ungrouped-test') !!}" name="counts">{!! trans('menu.ungrouped-test') !!}</a>
-	                            <a class="btn btn-sm btn-asbestos btn {{($counts==trans('menu.grouped-test'))?'active':'notActive'}}" data-toggle="counts" data-title="{!! trans('menu.grouped-test') !!}" name="counts">{!! trans('menu.grouped-test') !!}</a>
-	                            <a class="btn btn-sm btn-asbestos btn {{($counts==trans('menu.ungrouped-specimen'))?'active':'notActive'}}" data-toggle="counts" data-title="{!! trans('menu.ungrouped-specimen') !!}" name="counts">{!! trans('menu.ungrouped-specimen') !!}</a>
-	                            <a class="btn btn-sm btn-asbestos btn {{($counts==trans('menu.grouped-specimen'))?'active':'notActive'}}" data-toggle="counts" data-title="{!! trans('menu.grouped-specimen') !!}" name="counts">{!! trans('menu.grouped-specimen') !!}</a>
-	                        </div>
-            				<input type="hidden" name="counts" id="counts">
-		                </div>
-			        {!! Form::close() !!}
-		            <table class="table table-bordered table-sm" style="font-size:13px;">
-						<thead>
-							<tr>
-								<th>{!! trans_choice('menu.test-type', 1) !!}</th>
-								<th>{!! trans('menu.complete') !!}</th>
-								<th>{!! trans('menu.pending') !!}</th>
-							</tr>
-						</thead>
-						<tbody>
-						@forelse($ungroupedTests as $key => $value)
-							<tr>
-								<td>{!! App\Models\TestType::find($key)->name !!}</td>
-						    	<td>{!! $value['complete'] !!}</td>
-						    	<td>{!! $value['pending'] !!}</td>
-							</tr>
-						@empty
-						<tr><td colspan="3">{!! trans('terms.no-records') !!}</td></tr>
-						@endforelse
-						</tbody>
-					</table>
-			  	</div>
-			</div>
-		</div>
-	</div>
-	{!! session(['SOURCE_URL' => URL::full()]) !!}
-</div>
-@endsection
\ No newline at end of file
diff --git a/resources/views/report/daily/log/patient.blade.php b/resources/views/report/daily/log/patient.blade.php
deleted file mode 100755
index 8e6d283..0000000
--- a/resources/views/report/daily/log/patient.blade.php
+++ /dev/null
@@ -1,118 +0,0 @@
-@extends("app")
-
-@section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-chart"></i> {!! trans_choice('menu.report', 2) !!}</li>
-            <li class="active"><i class="fa fa-clock-o"></i> {!! trans('menu.daily-report') !!}</li>
-            <li class="active"> {!! trans_choice('menu.patient', 2) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="row">
-		<div class="col-sm-12">
-			<div class="card">
-				<div class="card-header">
-				    <i class="fa fa-book"></i> {!! trans_choice('menu.patient', 2) !!} 
-				    <span>
-					    <a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-							<i class="fa fa-step-backward"></i>
-							{!! trans('action.back') !!}
-						</a>				
-					</span>
-				</div>
-			  	<div class="card-block">	  		
-					@if (Session::has('message'))
-						<div class="alert alert-info">{!! Session::get('message') !!}</div>
-					
-					@if($errors->all())
-		            <div class="alert alert-danger alert-dismissible" role="alert">
-		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-		            </div>
-		            
-		            {!! Form::open(array('route' => array('reports.daily.log'))) !!}
-			            <div class='col-md-12'>
-			            	<div class='col-md-4'>
-			                    {!! Form::label('date_from', trans('terms.from').':', array('class' => 'col-sm-3 form-control-label')) !!}
-			                    <div class='col-md-9 input-group date datepicker'>
-			                        {!! Form::text('from', old('from') ? old('from') : $from, array('class' => 'form-control')) !!}
-			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
-			                    </div>
-			                </div>
-			                <div class='col-md-4'>
-			                    {!! Form::label('date_to', trans('terms.to').':', array('class' => 'col-sm-2 form-control-label')) !!}
-			                    <div class='col-md-10 input-group date datepicker'>
-			                        {!! Form::text('to', old('to') ? old('to') : $to, array('class' => 'form-control')) !!}
-			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
-			                    </div>
-			                </div>
-			                <div class='col-md-4'>
-								{!! Form::button("<i class='fa fa-filter'></i> ".trans('action.filter'), array('class' => 'btn btn-sm btn-primary', 'type' => 'submit', 'id' => 'filter')) !!}
-								{!! Form::button("<i class='fa fa-file-word-o'></i> ".trans('action.export'), array('class' => 'btn btn-sm btn-midnight-blue', 'type' => 'submit', 'id' => 'word', 'value' => 'word', 'name' => 'word')) !!}
-			                </div>
-		                </div>
-		                <div class='col-md-12' style="padding-bottom:5px;">
-		                	<div class='col-md-8'>
-		                		<div id="radioBtn" class="btn-group">
-		                            <a class="btn btn-sm btn-asbestos btn {{($records==trans('menu.test-records'))?'active':'notActive'}}" data-toggle="records" data-title="{!! trans('menu.test-records') !!}" name="records">{!! trans('menu.test-records') !!}</a>
-		                            <a class="btn btn-sm btn-asbestos btn {{($records==trans('menu.patient-records'))?'active':'notActive'}}" data-toggle="records" data-title="{!! trans('menu.patient-records') !!}" name="records">{!! trans('menu.patient-records') !!}</a>
-		                            <a class="btn btn-sm btn-asbestos btn {{($records==trans('menu.specimen-rej-rec'))?'active':'notActive'}}" data-toggle="records" data-title="{!! trans('menu.specimen-rej-rec') !!}" name="records">{!! trans('menu.specimen-rej-rec') !!}</a>
-		                        </div>
-                				<input type="hidden" name="records" id="records">
-							</div>
-							<div class='col-md-4'>
-								{!! Form::button("<i class='fa fa-toggle-on'></i> ".trans('action.show-hide'), array('class' => 'btn btn-sm btn-belize-hole', 'type' => 'submit', 'id' => 'filter')) !!}
-							</div>
-		                </div>
-			        {!! Form::close() !!}
-				 	<table class="table table-bordered table-sm search-table" style="font-size:13px;">
-						<thead>
-							<tr>
-								<th>{!! trans('terms.patient-id') !!}</th>
-								<th>{!! trans('terms.name') !!}</th>
-								<th>{!! trans('terms.age') !!}</th>
-								<th>{!! trans('terms.gender') !!}</th>
-								<th>{!! trans('terms.specimen-id') !!}</th>
-								<th>{!! trans('terms.type') !!}</th>
-								<th>{!! trans_choice('menu.test', 2) !!}</th>
-							</tr>
-						</thead>
-						<tbody>
-						@forelse($visits as $visit)
-							<tr>
-								<td>{!! $visit->patient->id !!}</td>
-								<td>{!! $visit->patient->name !!}</td>
-								<td>{!! $visit->patient->getAge() !!}</td>
-								<td>{!! $visit->patient->getGender() !!}</td>
-								<td>
-									@foreach($visit->tests as $test)
-										<p>{!! $test->specimen->id !!}</p>
-									@endforeach
-								</td>
-								<td>
-									@foreach($visit->tests as $test)
-										<p>{!! $test->specimen->specimenType->name !!}</p>
-									@endforeach
-								</td>
-								<td>
-									@foreach($visit->tests as $test)
-										<p>{!! $test->testType->name !!}</p>
-									@endforeach
-								</td>
-							</tr>
-						@empty
-						<tr><td colspan="7">{!! trans('terms.no-records') !!}</td></tr>
-						@endforelse
-						</tbody>
-					</table>
-			  	</div>
-			</div>
-		</div>
-	</div>
-	{!! session(['SOURCE_URL' => URL::full()]) !!}
-</div>
-@endsection
\ No newline at end of file
diff --git a/resources/views/report/daily/log/specimen.blade.php b/resources/views/report/daily/log/specimen.blade.php
deleted file mode 100755
index 176316e..0000000
--- a/resources/views/report/daily/log/specimen.blade.php
+++ /dev/null
@@ -1,108 +0,0 @@
-@extends("app")
-
-@section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-chart"></i> {!! trans_choice('menu.report', 2) !!}</li>
-            <li class="active"><i class="fa fa-clock-o"></i> {!! trans('menu.daily-report') !!}</li>
-            <li class="active"> {!! trans_choice('menu.patient', 2) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="row">
-		<div class="col-sm-12">
-			<div class="card">
-				<div class="card-header">
-				    <i class="fa fa-book"></i> {!! trans_choice('menu.patient', 2) !!} 
-				    <span>
-					    <a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-							<i class="fa fa-step-backward"></i>
-							{!! trans('action.back') !!}
-						</a>				
-					</span>
-				</div>
-			  	<div class="card-block">	  		
-					@if (Session::has('message'))
-						<div class="alert alert-info">{!! Session::get('message') !!}</div>
-					
-					@if($errors->all())
-		            <div class="alert alert-danger alert-dismissible" role="alert">
-		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-		            </div>
-		            
-		            {!! Form::open(array('route' => array('reports.daily.log'))) !!}
-			            <div class='col-md-12'>
-			            	<div class='col-md-4'>
-			                    {!! Form::label('date_from', trans('terms.from').':', array('class' => 'col-sm-3 form-control-label')) !!}
-			                    <div class='col-md-9 input-group date datepicker'>
-			                        {!! Form::text('from', old('from') ? old('from') : $from, array('class' => 'form-control')) !!}
-			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
-			                    </div>
-			                </div>
-			                <div class='col-md-4'>
-			                    {!! Form::label('date_to', trans('terms.to').':', array('class' => 'col-sm-2 form-control-label')) !!}
-			                    <div class='col-md-10 input-group date datepicker'>
-			                        {!! Form::text('to', old('to') ? old('to') : $to, array('class' => 'form-control')) !!}
-			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
-			                    </div>
-			                </div>
-			                <div class='col-md-4'>
-								{!! Form::button("<i class='fa fa-filter'></i> ".trans('action.filter'), array('class' => 'btn btn-sm btn-primary', 'type' => 'submit', 'id' => 'filter')) !!}
-								{!! Form::button("<i class='fa fa-file-word-o'></i> ".trans('action.export'), array('class' => 'btn btn-sm btn-midnight-blue', 'type' => 'submit', 'id' => 'word', 'value' => 'word', 'name' => 'word')) !!}
-			                </div>
-		                </div>
-		                <div class='col-md-12' style="padding-bottom:5px;">
-		                	<div class='col-md-8'>
-		                		<div id="radioBtn" class="btn-group">
-		                            <a class="btn btn-sm btn-asbestos btn {{($records==trans('menu.test-records'))?'active':'notActive'}}" data-toggle="records" data-title="{!! trans('menu.test-records') !!}" name="records">{!! trans('menu.test-records') !!}</a>
-		                            <a class="btn btn-sm btn-asbestos btn {{($records==trans('menu.patient-records'))?'active':'notActive'}}" data-toggle="records" data-title="{!! trans('menu.patient-records') !!}" name="records">{!! trans('menu.patient-records') !!}</a>
-		                            <a class="btn btn-sm btn-asbestos btn {{($records==trans('menu.specimen-rej-rec'))?'active':'notActive'}}" data-toggle="records" data-title="{!! trans('menu.specimen-rej-rec') !!}" name="records">{!! trans('menu.specimen-rej-rec') !!}</a>
-		                        </div>
-                				<input type="hidden" name="records" id="records">
-							</div>
-							<div class='col-md-4'>
-								{!! Form::button("<i class='fa fa-toggle-on'></i> ".trans('action.show-hide'), array('class' => 'btn btn-sm btn-belize-hole', 'type' => 'submit', 'id' => 'filter')) !!}
-							</div>
-		                </div>
-			        {!! Form::close() !!}
-				 	<table class="table table-bordered table-sm search-table" style="font-size:13px;">
-						<thead>
-							<tr>
-								<th>{!! trans('terms.specimen-id') !!}</th>
-								<th>{!! trans('terms.type') !!}</th>
-								<th>{!! trans('terms.date-received') !!}</th>
-								<th>{!! trans_choice('menu.test', 2) !!}</th>
-								<th>{!! trans_choice('menu.lab-section', 1) !!}</th>
-								<th>{!! trans('terms.reject-reason') !!}</th>
-								<th>{!! trans('terms.explained-to') !!}</th>
-								<th>{!! trans('terms.report-date') !!}</th>
-							</tr>
-						</thead>
-						<tbody>
-						@forelse($specimens as $specimen)
-							<tr>
-								<td>{!! $specimen->id !!}</td>
-								<td>{!! $specimen->specimenType->name !!}</td>
-								<td>{!! $specimen->test->time_created !!}</td>
-								<td>{!! $specimen->test->testType->name !!}</td>
-								<td>{!! $specimen->test->testType->testCategory->name !!}</td>
-								<td>{!! $specimen->rejectionReason->reason !!}</td>
-								<td>{!! $specimen->reject_explained_to !!}</td>
-								<td>{!! $specimen->time_rejected !!}</td>
-							</tr>
-						@empty
-						<tr><td colspan="8">{!! trans('terms.no-records') !!}</td></tr>
-						@endforelse
-						</tbody>
-					</table>
-			  	</div>
-			</div>
-		</div>
-	</div>
-	{!! session(['SOURCE_URL' => URL::full()]) !!}
-</div>
-@endsection
\ No newline at end of file
diff --git a/resources/views/report/daily/log/test.blade.php b/resources/views/report/daily/log/test.blade.php
deleted file mode 100755
index abadc56..0000000
--- a/resources/views/report/daily/log/test.blade.php
+++ /dev/null
@@ -1,137 +0,0 @@
-@extends("app")
-
-@section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-chart"></i> {!! trans_choice('menu.report', 2) !!}</li>
-            <li class="active"><i class="fa fa-clock-o"></i> {!! trans('menu.daily-report') !!}</li>
-            <li class="active"> {!! trans_choice('menu.test', 2) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="row">
-		<div class="col-sm-12">
-			<div class="card">
-				<div class="card-header">
-				    <i class="fa fa-book"></i> {!! trans_choice('menu.test', 2) !!} 
-				    <span>
-					    <a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-							<i class="fa fa-step-backward"></i>
-							{!! trans('action.back') !!}
-						</a>				
-					</span>
-				</div>
-			  	<div class="card-block">	  		
-					@if (Session::has('message'))
-						<div class="alert alert-info">{!! Session::get('message') !!}</div>
-					
-					@if($errors->all())
-		            <div class="alert alert-danger alert-dismissible" role="alert">
-		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-		            </div>
-		            
-			        {!! Form::open(array('route' => array('reports.daily.log'))) !!}
-			            <div class='col-md-12'>
-			            	<div class='col-md-4'>
-			                    {!! Form::label('date_from', trans('terms.from').':', array('class' => 'col-sm-3 form-control-label')) !!}
-			                    <div class='col-md-9 input-group date datepicker'>
-			                        {!! Form::text('from', old('from') ? old('from') : $from, array('class' => 'form-control')) !!}
-			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
-			                    </div>
-			                </div>
-			                <div class='col-md-4'>
-			                    {!! Form::label('date_to', trans('terms.to').':', array('class' => 'col-sm-2 form-control-label')) !!}
-			                    <div class='col-md-10 input-group date datepicker'>
-			                        {!! Form::text('to', old('to') ? old('to') : $to, array('class' => 'form-control')) !!}
-			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
-			                    </div>
-			                </div>
-			                <div class='col-md-4'>
-								{!! Form::button("<i class='fa fa-filter'></i> ".trans('action.filter'), array('class' => 'btn btn-sm btn-primary', 'type' => 'submit', 'id' => 'filter')) !!}
-								{!! Form::button("<i class='fa fa-file-word-o'></i> ".trans('action.export'), array('class' => 'btn btn-sm btn-midnight-blue', 'type' => 'submit', 'id' => 'word', 'value' => 'word', 'name' => 'word')) !!}
-			                </div>
-		                </div>
-		                <div class='col-md-12' style="padding-bottom:5px;">
-		                	<div class='col-md-8'>
-		                		<div id="radioBtn" class="btn-group">
-		                            <a class="btn btn-sm btn-asbestos btn {{($records==trans('menu.test-records'))?'active':'notActive'}}" data-toggle="records" data-title="{!! trans('menu.test-records') !!}" name="records">{!! trans('menu.test-records') !!}</a>
-		                            <a class="btn btn-sm btn-asbestos btn {{($records==trans('menu.patient-records'))?'active':'notActive'}}" data-toggle="records" data-title="{!! trans('menu.patient-records') !!}" name="records">{!! trans('menu.patient-records') !!}</a>
-		                            <a class="btn btn-sm btn-asbestos btn {{($records==trans('menu.specimen-rej-rec'))?'active':'notActive'}}" data-toggle="records" data-title="{!! trans('menu.specimen-rej-rec') !!}" name="records">{!! trans('menu.specimen-rej-rec') !!}</a>
-		                        </div>
-                				<input type="hidden" name="records" id="records">
-							</div>
-							<div class='col-md-4'>
-								{!! Form::button("<i class='fa fa-toggle-on'></i> ".trans('action.show-hide'), array('class' => 'btn btn-sm btn-belize-hole', 'type' => 'submit', 'id' => 'filter')) !!}
-							</div>
-		                </div>
-		                <div class='col-md-12' id="hideable">
-		                	<div class='col-md-5'>
-		                		{!! Form::label('lab-section', trans_choice('menu.lab-section', 1).':', array('class' => 'col-sm-4 form-control-label')) !!}
-			                    <div class='col-md-8'>
-			                        {!! Form::select('test_category_id', $labSections, '', array('class' => 'form-control c-select', 'id' => 'test_category_id', 'onchange' => "testTypes()")) !!}
-			                    </div>
-							</div>
-							<div class='col-md-4'>
-								{!! Form::label('test-type', trans_choice('menu.test', 1).':', array('class' => 'col-sm-2 form-control-label')) !!}
-			                    <div class='col-md-10'>
-			                        {!! Form::select('test_type_id', [], '', array('class' => 'form-control c-select', 'id' => 'test_type_id')) !!}
-			                    </div>
-							</div>
-							<div class='col-md-3'>
-								<div id="radioBtn" class="btn-group">
-		                            <a class="btn btn-sm btn-asbestos btn {{($completePending==trans('menu.all'))?'active':'notActive'}}" data-toggle="completePending" data-title="{!! trans('menu.all') !!}" name="completePending">{!! trans('menu.all') !!}</a>
-		                            <a class="btn btn-sm btn-asbestos btn {{($completePending==trans('menu.complete'))?'active':'notActive'}}" data-toggle="completePending" data-title="{!! trans('menu.complete') !!}" name="completePending">{!! trans('menu.complete') !!}</a>
-		                        </div>
-		                        <input type="hidden" name="completePending" id="completePending">
-							</div>
-		                </div>
-			        {!! Form::close() !!}
-		            <table class="table table-bordered table-sm search-table" style="font-size:13px;">
-						<thead>
-							<tr>
-								<th>{!! trans('terms.patient-id') !!}</th>
-								<th>{!! trans('terms.visit-no') !!}</th>
-								<th>{!! trans('terms.specimen-id') !!}</th>
-								<th>{!! trans_choice('menu.specimen-type', 1) !!}</th>
-								<th>{!! trans('terms.date-received') !!}</th>
-								<th>{!! trans_choice('menu.test-type', 1) !!}</th>
-								<th>{!! trans('terms.performed-by') !!}</th>
-								<th>{!! trans('terms.result') !!}</th>
-								<th>{!! trans('terms.report-date') !!}</th>
-								<th>{!! trans('terms.verified-by') !!}</th>
-							</tr>
-						</thead>
-						<tbody>
-						@forelse($tests as $test)
-							<tr>
-								<td>{!! $test->visit->patient->id !!}</td>
-								<td>{!! $test->visit->visit_number?$test->visit->visit_number:$test->visit->id !!}</td>
-								<td>{!! $test->getSpecimenId() !!}</td>
-								<td>{!! $test->specimen->specimentype->name !!}</td>
-								<td>{!! $test->specimen->time_accepted !!}</td>
-								<td>{!! $test->testType->name !!}</td>
-								<td>{!! $test->testedBy->name or trans('terms.test-pending') !!}</td>
-								<td>
-									@foreach($test->testResults as $result)
-										<p>{!! App\Models\Measure::find($result->measure_id)->name !!}: {!! $result->result !!}</p>
-									@endforeach
-								</td>
-								<td>{!! $test->time_completed or trans('messages.pending') !!}</td>
-								<td>{!! $test->verifiedBy->name or trans('terms.verification-pending') !!}</td>
-							</tr>
-						@empty
-						<tr><td colspan="11">{!! trans('terms.no-records') !!}</td></tr>
-						@endforelse
-						</tbody>
-					</table>
-			  	</div>
-			</div>
-		</div>
-	</div>
-	{!! session(['SOURCE_URL' => URL::full()]) !!}
-</div>
-@endsection
\ No newline at end of file
diff --git a/resources/views/report/daily/patient/export.blade.php b/resources/views/report/daily/patient/export.blade.php
deleted file mode 100755
index dd4055e..0000000
--- a/resources/views/report/daily/patient/export.blade.php
+++ /dev/null
@@ -1,140 +0,0 @@
-<html>
-<head>
-	<link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
-	<link href="{{ asset('css/font.css') }}" rel="stylesheet">
-	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
-</head>
-<body>
-	<div class="conter-wrapper">
-		<div class="card">
-			<div class="card-header">
-			    <i class="fa fa-file-text"></i> {!! trans('menu.patient-report') !!}
-			    <span>
-					<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-						<i class="fa fa-step-backward"></i>
-						{!! trans('action.back') !!}
-					</a>				
-				</span>
-			</div>
-		  	<div class="card-block">
-	            <div class="row">
-	            	<div class="col-sm-1"></div>
-	            	<div class="col-sm-3">
-	            		<img src="{{ Config::get('blis.organization-logo') }}" height="60px" align="center">
-	            	</div>
-	            	<div class="col-sm-4">
-	            		<h6 align="center"><small>
-		            		{!! strtoupper(Config::get('blis.organization')) !!}<br>
-		                    {!! strtoupper(Config::get('blis.address-info')) !!}<br>
-	                    </small></h6>
-	            	</div>
-	            	<div class="col-sm-3">
-	            		<img src="{{ Config::get('blis.organization-logo') }}" height="60px" align="center">
-	            	</div>
-	            	<div class="col-sm-1"></div>
-	            </div>
-	            <div class="row">
-	            	<div class="col-md-12">
-						<ul class="list-group" style="padding-bottom:5px;">
-						  	<li class="list-group-item"><strong>{!! $patient->name !!}</strong></li>
-						  	<li class="list-group-item">
-						  		<h6>
-						  			<span>{!! trans("terms.patient-id").':' !!}<small> {!! $patient->patient_number !!}</small></span>&nbsp;&nbsp;
-						  			<span>{!! trans("terms.lab-no").':' !!}<small> {!! $patient->external_patient_number !!}</small></span>&nbsp;&nbsp;
-						  			<span>{!! trans("terms.age").'/'.trans("terms.gender").'/'.trans("terms.dob").':' !!}<small> {!! $patient->getAge().'/'.($patient->gender==0?trans_choice('terms.sex', 1):trans_choice('terms.sex', 2)).'/'.Carbon::parse($patient->dob)->toDateString() !!}</small></span>
-						  		</h6>
-						  	</li>
-						</ul>
-					</div>
-				</div>
-				<div class="row">
-					@forelse($tests as $test)
-					<div class="col-md-12">
-						<ul class="list-group" style="padding-bottom:5px;">
-						  	<li class="list-group-item">
-						  		<h6>
-						  			<span>{!! trans("terms.lab-ref").':' !!}<small> {!! $patient->id !!}</small></span>&nbsp;&nbsp;
-						  			<span>{!! trans("terms.spec-id").':' !!}<small> {!! $test->specimen->id !!}</small></span>&nbsp;&nbsp;
-						  			<span>
-						  				{!! trans("terms.test-status").':' !!}
-						  				<small> 
-						  					@if($test->specimen->specimen_status_id == App\Models\Specimen::NOT_COLLECTED)
-						  						{!! trans('terms.specimen-not-collected') !!}
-						  					@elseif($test->specimen->specimen_status_id == App\Models\Specimen::ACCEPTED)
-						  						{!! trans('terms.specimen-accepted') !!}
-						  					@elseif($test->specimen->specimen_status_id == App\Models\Specimen::REJECTED)
-						  						{!! trans('terms.specimen-rejected') !!}
-						  					
-						  				</small>
-						  			</span>&nbsp;&nbsp;
-						  			@if($test->specimen->specimen_status_id == App\Models\Specimen::ACCEPTED)
-						  				<span>{!! trans("terms.collect-date").':' !!}<small> {!! $test->specimen->time_accepted !!}</small></span>&nbsp;&nbsp;
-							  			<span>{!! trans("terms.accepted-by").':' !!}<small> {!! $test->specimen->acceptedBy->name !!}</small></span>
-						  			@elseif($test->specimen->specimen_status_id == App\Models\Specimen::REJECTED)
-						  				<span>{!! trans("terms.reject-date").':' !!}<small> {!! $test->specimen->time_rejected !!}</small></span>&nbsp;&nbsp;
-							  			<span>{!! trans("terms.rejected-by").':' !!}<small> {!! $test->specimen->rejectedBy->name !!}</small></span>
-						  			
-						  		</h6>
-						  	</li>
-						  	<li class="list-group-item">
-						  		<h6>
-						  			<span>{!! trans("terms.requested").':' !!}<small> {!! $test->testType->name !!}</small></span>&nbsp;&nbsp;
-						  			<span>{!! trans("terms.performed-by").':' !!}<small> {!! $test->testedBy->name or trans('terms.pending') !!}</small></span>&nbsp;&nbsp;
-						  			<span>{!! trans("terms.report-date").':' !!}<small> {!! $test->testResults->last()->time_entered !!}</small></span>&nbsp;&nbsp;
-						  			<span>{!! trans("terms.verified-by").':' !!}<small> {!! $test->verifiedBy->name or trans('terms.verification-pending') !!}</small></span>&nbsp;&nbsp;
-						  			<span>{!! trans("terms.date-verified").':' !!}<small> {!! $test->time_verified or trans('terms.verification-pending') !!}</small></span>
-						  		</h6>
-						  	</li>
-						</ul>
-					</div>
-					@empty
-	        			<div class="col-sm-12">
-	            			{!! trans('terms.no-records-found') !!}
-	            		</div>
-	        		@endforelse
-	        	</div>
-				@forelse($tests as $test)
-				<div class="row">
-					<div class="col-md-12">
-						<div class="card card-block">
-							<div class="row">				
-								<strong>
-									<div class="col-md-12">
-										<div class="col-sm-4">{!! trans_choice('menu.test', 1) !!}</div>
-									  	<div class="col-sm-4">{!! trans('terms.result') !!}</div>
-									  	<div class="col-sm-4">{!! trans('terms.reference') !!}</div>
-								  	</div>
-								</strong>
-							  	<div class="col-sm-12">
-			            			<div class="col-sm-4">
-			            				{!! $test->testType->name !!}           				
-			           
-			            		</div>
-			            		<hr>
-			            		@foreach($test->testResults as $result)
-			            			<div class="col-sm-12">
-				            			<div class="col-sm-4">
-				            				{!! App\Models\Measure::find($result->measure_id)->name !!}           				
-				           
-				            			<div class="col-sm-4">
-				            				{!! $result->result !!}           				
-				           
-				            			<div class="col-sm-4">
-				            				{!! App\Models\Measure::getRange($test->visit->patient, $result->measure_id).' '.App\Models\Measure::find($result->measure_id)->unit !!}           				
-				           
-				            		</div>
-			            		@endforeach
-			            	</div>
-		            	</div>
-	            	</div>
-	    		@empty
-	    			<div class="col-sm-12">
-	        			{!! trans('terms.no-records-found') !!}
-	        		</div>
-				</div>
-	    		@endforelse
-		  	</div>
-		</div>
-	</div>
-</body>
-</html>
\ No newline at end of file
diff --git a/resources/views/report/daily/patient/index.blade.php b/resources/views/report/daily/patient/index.blade.php
deleted file mode 100755
index 4386d77..0000000
--- a/resources/views/report/daily/patient/index.blade.php
+++ /dev/null
@@ -1,90 +0,0 @@
-@extends("app")
-
-@section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-chart"></i> {!! trans_choice('menu.report', 2) !!}</li>
-            <li class="active"><i class="fa fa-clock-o"></i> {!! trans('menu.daily-report') !!}</li>
-            <li class="active"> {!! trans('menu.patient-report') !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="row">
-		<div class="col-sm-12">
-			<div class="card">
-				<div class="card-header">
-				    <i class="fa fa-book"></i> {!! trans('menu.patient-report') !!} 
-				    <span>
-					    <a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-							<i class="fa fa-step-backward"></i>
-							{!! trans('action.back') !!}
-						</a>				
-					</span>
-				</div>
-			  	<div class="card-block">	  		
-					@if (Session::has('message'))
-						<div class="alert alert-info">{!! Session::get('message') !!}</div>
-					
-					@if($errors->all())
-		            <div class="alert alert-danger alert-dismissible" role="alert">
-		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-		            </div>
-		            
-		            <div class='col-md-12' style="padding-bottom:5px;">
-						{!! Form::open(array('route' => array('patient.index'), 'class'=>'form-inline', 'role'=>'form', 'method'=>'GET')) !!}
-							
-
-							    {!! Form::label('search', "search", array('class' => 'sr-only')) !!}
-					            {!! Form::text('search', Input::get('search'), array('class' => 'form-control test-search')) !!}
-							</div>
-							
-								{!! Form::button("<i class='fa fa-search'></i> ".trans('terms.search'), 
-							        array('class' => 'btn btn-sm btn-primary', 'type' => 'submit')) !!}
-							</div>
-						{!! Form::close() !!}
-					</div>
-				 	<table class="table table-bordered table-sm search-table">
-						<thead>
-							<tr>
-								<th>{!! trans('terms.patient-no') !!}</th>
-								<th>{!! trans('terms.patient-id') !!}</th>
-								<th>{!! trans('terms.name') !!}</th>
-								<th>{!! trans('terms.gender') !!}</th>
-								<th>{!! trans('terms.age') !!}</th>
-								<th></th>
-							</tr>
-						</thead>
-						<tbody>
-						@foreach($patients as $patient)
-							<tr @if(session()->has('active_patient'))
-				                    {!! (session('active_patient') == $value->id)?"class='warning'":"" !!}
-				                
-				                >
-								<td>{!! $patient->patient_number !!}</td>
-								<td>{!! $patient->external_patient_number !!}</td>
-								<td>{!! $patient->name !!}</td>
-								<td>{!! ($patient->gender==0?trans_choice('terms.sex', 1):trans_choice('terms.sex', 2)) !!}</td>
-								<td>{!! $patient->getAge() !!}</td>
-								
-								<td>
-									<a class="btn btn-sm btn-wet-asphalt" 
-										href="{!! url('patientreport/' . $patient->id) !!}">
-										<i class="fa fa-file-text"></i>
-										{!! trans('action.view').' '.trans_choice('menu.report', 1) !!}
-									</a>
-								</td>
-							</tr>
-						@endforeach
-						</tbody>
-					</table>
-			  	</div>
-			</div>
-		</div>
-	</div>
-	{!! session(['SOURCE_URL' => URL::full()]) !!}
-</div>
-@endsection
\ No newline at end of file
diff --git a/resources/views/report/daily/patient/report.blade.php b/resources/views/report/daily/patient/report.blade.php
deleted file mode 100755
index 4d709b1..0000000
--- a/resources/views/report/daily/patient/report.blade.php
+++ /dev/null
@@ -1,188 +0,0 @@
-@extends("app")
-
-@section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-chart"></i> {!! trans_choice('menu.report', 2) !!}</li>
-            <li class="active"><i class="fa fa-clock-o"></i> {!! trans('menu.daily-report') !!}</li>
-            <li class="active"> {!! trans('menu.patient-report') !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-file-text"></i> {!! trans('menu.patient-report') !!}
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
-			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
-            <div class="row">            	
-				<div class='col-md-12' style="padding-bottom:5px;">
-			        {!! Form::open(array('url' => 'patientreport/'.$patient->id, 'class' => 'form-inline', 'id' => 'form-patientreport-filter', 'method'=>'POST')) !!}
-						{!! Form::hidden('patient', $patient->id, array('id' => 'patient')) !!}			            
-			            <div class='col-md-12'>
-			            	<div class='col-md-2'>
-			            		{!! Form::checkbox('pending', "1", isset($pending)) !!}&nbsp;&nbsp;<strong>{!! trans('terms.include-pending') !!}</strong>
-			            	</div>
-			                <div class='col-md-4'>
-			                    {!! Form::label('date_from', trans('terms.from').':', array('class' => 'col-sm-3 form-control-label')) !!}
-			                    <div class='col-md-9 input-group date datepicker'>
-			                        {!! Form::text('from', old('from') ? old('from') : $from, array('class' => 'form-control')) !!}
-			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
-			                    </div>
-			                </div>
-			                <div class='col-md-3'>
-			                    {!! Form::label('date_to', trans('terms.to').':', array('class' => 'col-sm-2 form-control-label')) !!}
-			                    <div class='col-md-10 input-group date datepicker'>
-			                        {!! Form::text('to', old('to') ? old('to') : $to, array('class' => 'form-control')) !!}
-			                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
-			                    </div>
-			                </div>
-			                <div class='col-md-3'>
-								{!! Form::button("<i class='fa fa-filter'></i> ".trans('action.filter'), array('class' => 'btn btn-sm btn-primary', 'type' => 'submit', 'id' => 'filter')) !!}
-								{!! Form::button("<i class='fa fa-file-word-o'></i> ".trans('action.export'), array('class' => 'btn btn-sm btn-midnight-blue', 'type' => 'submit', 'id' => 'word', 'value' => 'word', 'name' => 'word')) !!}
-			                </div>
-		                </div>
-		                {!! Form::hidden('visit_id', $visit, array('id'=>'visit_id')) !!}
-			        {!! Form::close() !!}
-			    </div>
-            </div>
-            @if($error!='')
-			<!-- if there are search errors, they will show here -->
-				<div class="alert alert-info">{!! $error !!}</div>
-			@else
-            <div class="row">
-            	<div class="col-sm-1"></div>
-            	<div class="col-sm-3">
-            		<img src="{{ Config::get('blis.organization-logo') }}" height="60px" align="center">
-            	</div>
-            	<div class="col-sm-4">
-            		<h6 align="center"><small>
-	            		{!! strtoupper(Config::get('blis.organization')) !!}<br>
-	                    {!! strtoupper(Config::get('blis.address-info')) !!}<br>
-                    </small></h6>
-            	</div>
-            	<div class="col-sm-3">
-            		<img src="{{ Config::get('blis.organization-logo') }}" height="60px" align="center">
-            	</div>
-            	<div class="col-sm-1"></div>
-            </div>
-            <div class="row">
-            	<div class="col-md-12">
-					<ul class="list-group" style="padding-bottom:5px;">
-					  	<li class="list-group-item"><strong>{!! $patient->name !!}</strong></li>
-					  	<li class="list-group-item">
-					  		<h6>
-					  			<span>{!! trans("terms.patient-id").':' !!}<small> {!! $patient->patient_number !!}</small></span>&nbsp;&nbsp;
-					  			<span>{!! trans("terms.lab-no").':' !!}<small> {!! $patient->external_patient_number !!}</small></span>&nbsp;&nbsp;
-					  			<span>{!! trans("terms.age").'/'.trans("terms.gender").'/'.trans("terms.dob").':' !!}<small> {!! $patient->getAge().'/'.($patient->gender==0?trans_choice('terms.sex', 1):trans_choice('terms.sex', 2)).'/'.Carbon::parse($patient->dob)->toDateString() !!}</small></span>
-					  		</h6>
-					  	</li>
-					</ul>
-				</div>
-			</div>
-			<div class="row">
-				@forelse($tests as $test)
-				<div class="col-md-12">
-					<ul class="list-group" style="padding-bottom:5px;">
-					  	<li class="list-group-item">
-					  		<h6>
-					  			<span>{!! trans("terms.lab-ref").':' !!}<small> {!! $patient->id !!}</small></span>&nbsp;&nbsp;
-					  			<span>{!! trans("terms.spec-id").':' !!}<small> {!! $test->specimen->id !!}</small></span>&nbsp;&nbsp;
-					  			<span>
-					  				{!! trans("terms.test-status").':' !!}
-					  				<small> 
-					  					@if($test->specimen->specimen_status_id == App\Models\Specimen::NOT_COLLECTED)
-					  						{!! trans('terms.specimen-not-collected') !!}
-					  					@elseif($test->specimen->specimen_status_id == App\Models\Specimen::ACCEPTED)
-					  						{!! trans('terms.specimen-accepted') !!}
-					  					@elseif($test->specimen->specimen_status_id == App\Models\Specimen::REJECTED)
-					  						{!! trans('terms.specimen-rejected') !!}
-					  					
-					  				</small>
-					  			</span>&nbsp;&nbsp;
-					  			@if($test->specimen->specimen_status_id == App\Models\Specimen::ACCEPTED)
-					  				<span>{!! trans("terms.collect-date").':' !!}<small> {!! $test->specimen->time_accepted !!}</small></span>&nbsp;&nbsp;
-						  			<span>{!! trans("terms.accepted-by").':' !!}<small> {!! $test->specimen->acceptedBy->name !!}</small></span>
-					  			@elseif($test->specimen->specimen_status_id == App\Models\Specimen::REJECTED)
-					  				<span>{!! trans("terms.reject-date").':' !!}<small> {!! $test->specimen->time_rejected !!}</small></span>&nbsp;&nbsp;
-						  			<span>{!! trans("terms.rejected-by").':' !!}<small> {!! $test->specimen->rejectedBy->name !!}</small></span>
-					  			
-					  		</h6>
-					  	</li>
-					  	<li class="list-group-item">
-					  		<h6>
-					  			<span>{!! trans("terms.requested").':' !!}<small> {!! $test->testType->name !!}</small></span>&nbsp;&nbsp;
-					  			<span>{!! trans("terms.performed-by").':' !!}<small> {!! $test->testedBy->name or trans('terms.pending') !!}</small></span>&nbsp;&nbsp;
-					  			<span>{!! trans("terms.report-date").':' !!}<small> {!! $test->testResults->last()->time_entered !!}</small></span>&nbsp;&nbsp;
-					  			<span>{!! trans("terms.verified-by").':' !!}<small> {!! $test->verifiedBy->name or trans('terms.verification-pending') !!}</small></span>&nbsp;&nbsp;
-					  			<span>{!! trans("terms.date-verified").':' !!}<small> {!! $test->time_verified or trans('terms.verification-pending') !!}</small></span>
-					  		</h6>
-					  	</li>
-					</ul>
-				</div>
-				@empty
-        			<div class="col-sm-12">
-            			{!! trans('terms.no-records-found') !!}
-            		</div>
-        		@endforelse
-        	</div>
-			@forelse($tests as $test)
-			<div class="row">
-				<div class="col-md-12">
-					<div class="card card-block">
-						<div class="row">				
-							<strong>
-								<div class="col-md-12">
-									<div class="col-sm-4">{!! trans_choice('menu.test', 1) !!}</div>
-								  	<div class="col-sm-4">{!! trans('terms.result') !!}</div>
-								  	<div class="col-sm-4">{!! trans('terms.reference') !!}</div>
-							  	</div>
-							</strong>
-						  	<div class="col-sm-12">
-		            			<div class="col-sm-4">
-		            				{!! $test->testType->name !!}           				
-		           
-		            		</div>
-		            		<hr>
-		            		@foreach($test->testResults as $result)
-		            			<div class="col-sm-12">
-			            			<div class="col-sm-4">
-			            				{!! App\Models\Measure::find($result->measure_id)->name !!}           				
-			           
-			            			<div class="col-sm-4">
-			            				{!! $result->result !!}           				
-			           
-			            			<div class="col-sm-4">
-			            				{!! App\Models\Measure::getRange($test->visit->patient, $result->measure_id).' '.App\Models\Measure::find($result->measure_id)->unit !!}
-			           
-			            		</div>
-		            		@endforeach
-		            	</div>
-	            	</div>
-            	</div>
-    		@empty
-    			<div class="col-sm-12">
-        			{!! trans('terms.no-records-found') !!}
-        		</div>
-			</div>
-    		@endforelse
-    		
-	  	</div>
-	</div>
-</div>
-@endsection	
\ No newline at end of file
diff --git a/resources/views/reportconfig/disease.blade.php b/resources/views/reportconfig/disease.blade.php
index e8ee4e4..1addc8c 100755
--- a/resources/views/reportconfig/disease.blade.php
+++ b/resources/views/reportconfig/disease.blade.php
@@ -1,15 +1,15 @@
-@extends("app")
+@extends("layout")
 @section("content")
 <div>
 	<ol class="breadcrumb">
 	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
-	  <li class="active">{{ trans_choice('messages.disease',2) }}</li>
+	  <li class="active">{{ Lang::choice('messages.disease',2) }}</li>
 	</ol>
 </div>
 <div class="panel panel-primary">
 	<div class="panel-heading ">
 		<span class="glyphicon glyphicon-edit"></span>
-		{{ trans_choice('messages.disease',2) }}
+		{{ Lang::choice('messages.disease',2) }}
 	</div>
 	{{ Form::open(array('route' => 'reportconfig.disease', 'id' => 'form-edit-disease')) }}
 		<div class="panel-body disease-input">
@@ -33,7 +33,7 @@
 		</div>
 		<div class="panel-footer">
 			<div class="form-group actions-row">
-				<input class="hidden" name="fromForm" type="text" value="fromForm">
+				<input class="hidden" name="from-form" type="text" value="from-form">
 				{{ Form::button(
 					'<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'), 
 					['class' => 'btn btn-primary', 'onclick' => 'authenticate("#form-edit-disease")']
diff --git a/resources/views/reportconfig/surveillance.blade.php b/resources/views/reportconfig/surveillance.blade.php
index c867311..19ec44d 100755
--- a/resources/views/reportconfig/surveillance.blade.php
+++ b/resources/views/reportconfig/surveillance.blade.php
@@ -1,4 +1,4 @@
-@extends("app")
+@extends("layout")
 @section("content")
 <div>
 	<ol class="breadcrumb">
@@ -27,19 +27,19 @@

 			<div class="row">
 				<div class="col-sm-5 col-md-3">
-	                <label>{{ trans_choice('messages.test-type',2) }}</label>
+	                <label>{{ Lang::choice('messages.test-type',2) }}</label>
 				</div>
 				<div class="col-sm-5 col-md-3">
-	                <label>{{ trans_choice('messages.disease',2) }}</label>
+	                <label>{{ Lang::choice('messages.disease',2) }}</label>
 				</div>

 			@foreach($diseaseTests as $diseaseTest)

 				<div class="row">
 					<div class="col-sm-5 col-md-3">
-		                <select class="form-control" name="surveillance[{{ $diseaseTest->id }}][test_type]"> 
+		                <select class="form-control" name="surveillance[{{ $diseaseTest->id }}][test-type]"> 
 		                    <option value="0"></option>
-		                    @foreach ($testTypes as $testType)
+		                    @foreach (TestType::all() as $testType)
 		                        <option value="{{ $testType->id }}"
 		                        	{{($testType->id == $diseaseTest->test_type_id) ? 'selected="selected"' : '' }}>
 		                        	{{ $testType->name }}</option>
@@ -49,7 +49,7 @@
 					<div class="col-sm-5 col-md-3">
 					    <select class="form-control" name="surveillance[{{ $diseaseTest->id }}][disease]"> 
 					        <option value="0"></option>
-					        @foreach ($diseases as $disease)
+					        @foreach (Disease::all() as $disease)
 					            <option value="{{ $disease->id }}"
 					            	{{($disease->id == $diseaseTest->disease_id) ? 'selected="selected"' : '' }}>
 					            	{{ $disease->name }}</option>
@@ -66,7 +66,7 @@
 		</div>
 		<div class="panel-footer">
 			<div class="form-group actions-row">
-				<input class="hidden" name="fromForm" type="text" value="fromForm">
+				<input class="hidden" name="from-form" type="text" value="from-form">
 				{{ Form::button(
 					'<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'), 
 					['class' => 'btn btn-primary', 'onclick' => 'authenticate("#form-edit-surveillance")']
@@ -87,7 +87,7 @@
 			<div class="col-sm-5 col-md-3">
                 <select class="form-control test-type" name=""> 
 					<option value="0"></option>
-					@foreach ($testTypes as $testType)
+					@foreach (TestType::all() as $testType)
 					    <option value="{{ $testType->id }}">{{ $testType->name }}</option>
 					@endforeach
             	</select>
@@ -95,7 +95,7 @@
 			<div class="col-sm-5 col-md-3">
 			    <select class="form-control disease" name=""> 
 			        <option value="0"></option>
-			        @foreach ($diseases as $disease)
+			        @foreach (Disease::all() as $disease)
 			            <option value="{{ $disease->id }}">{{ $disease->name }}</option>
 			        @endforeach
 			    </select>
diff --git a/resources/views/role/assign.blade.php b/resources/views/role/assign.blade.php
index 8e11823..7b54302 100755
--- a/resources/views/role/assign.blade.php
+++ b/resources/views/role/assign.blade.php
@@ -1,90 +1,64 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-users"></i> {!! trans('menu.access-control') !!}</li>
-            <li class="active"><i class="fa fa-cube"></i> {!! trans('menu.authorized-users') !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="row">
-		<div class="col-sm-12">
-			<div class="card">
-				<div class="card-header">
-				    <i class="fa fa-book"></i> {!! trans('menu.authorized-users') !!}
-				    <span>
-					    <a class="btn btn-sm btn-belize-hole" href="{!! url("role/create") !!}">
-							<i class="fa fa-plus-circle"></i>
-							{!! trans('action.new').' '.trans_choice('menu.role', 1) !!}
-						</a>
-						<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-							<i class="fa fa-step-backward"></i>
-							{!! trans('action.back') !!}
-						</a>				
-					</span>
-				</div>
-			  	<div class="card-block">	  		
-					@if (Session::has('message'))
-						<div class="alert alert-info">{!! Session::get('message') !!}</div>
-					
-					@if($errors->all())
-		            <div class="alert alert-danger alert-dismissible" role="alert">
-		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-		            </div>
-		            
-					{!! Form::open(array('route'=>'authorize')) !!}
-				 	<table class="table table-bordered table-sm">
-						<thead>
-		                    <tr>
-		                        <th>{!! trans_choice('menu.user', 2) !!}</th>
-		                        <th colspan="{!! count($roles)!!}">{!! trans_choice('menu.role', 2) !!}</th>
-		                    </tr>
-		                </thead>
-		                <tbody>
-		                <tr>
-		                    <td></td>
-		                    @forelse($roles as $role)
-		                        <td>{!!$role->name!!}</td>
-		                    @empty
-		                        <td>{!!trans('terms.no-records')!!}</td>
-		                    @endforelse
-		                </tr>
-		                @forelse($users as $userKey=>$user)
-		                    <tr>
-		                        <td>{!! $user->username !!}</td>
-		                        @forelse($roles as $roleKey=>$role)
-		                        <td>
-		                            @if ($role == App\Models\Role::getAdminRole() && $user == App\Models\User::getAdminUser())
-		                                <i class="fa fa-lock"></i>
-		                                {!! Form::checkbox('userRoles['.$userKey.']['.$roleKey.']', '1', $user->hasRole($role->name),
-		                                array('style'=>'display:none')) !!}
-		                            @else
-		                               {!! Form::checkbox('userRoles['.$userKey.']['.$roleKey.']', '1', $user->hasRole($role->name)) !!}
-		                            
-		                        </td>
-		                        @empty
-		                            <td>[-]</td>
-		                        @endforelse
-		                    </tr>
-		                @empty
-		                <tr><td colspan="2">{!!trans('terms.no-records')!!}</td></tr>
-		                @endforelse 
-		                </tbody>
-					</table>
-					<div class="form-group actions-row" align="right">
-                    {!! Form::button("<i class='fa fa-check-circle'></i> ".trans('action.update'), 
-						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-		            </div>
-		            {!!Form::close()!!}
-			  	</div>
-			</div>
-		</div>
-	</div>
-	{!! session(['SOURCE_URL' => URL::full()]) !!}
+<div>
+    <ol class="breadcrumb">
+      <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+      <li class="active">{{trans('messages.access-controls')}}</li>
+    </ol>
 </div>
-@endsection
\ No newline at end of file
+@if (Session::has('message'))
+    <div class="alert alert-info">{{ Session::get('message') }}</div>
+
+<div class="panel panel-primary">
+            <div class="panel-heading ">
+                <span class="glyphicon glyphicon-user"></span>
+                {{trans('messages.assign-roles-to-users')}}
+            </div>
+            <div class="panel-body" >
+            {{ Form::open(array('route'=>'role.assign'))}}
+            <table class="table table-striped table-hover table-bordered">
+                <thead>
+                    <tr>
+                        <th>{{ Lang::choice('messages.user',2) }}</th>
+                        <th colspan="{{ count($roles)}}">{{ Lang::choice('messages.role',2) }}</th>
+                    </tr>
+                </thead>
+                <tbody>
+                <tr>
+                    <td></td>
+                    @forelse($roles as $role)
+                        <td>{{$role->name}}</td>
+                    @empty
+                        <td>{{ trans('messages.no-roles-found')}}</td>
+                    @endforelse
+                </tr>
+                @forelse($users as $userKey=>$user)
+                    <tr>
+                        <td>{{$user->username}}</td>
+                        @forelse($roles as $roleKey=>$role)
+                        <td>
+                            @if ($role == Role::getAdminRole() && $user == User::getAdminUser())
+                                <span class="glyphicon glyphicon-lock"></span>
+                                {{ Form::checkbox('userRoles['.$userKey.']['.$roleKey.']', '1', $user->hasRole($role->name),
+                                array('style'=>'display:none')) }}
+                            @else
+                               {{ Form::checkbox('userRoles['.$userKey.']['.$roleKey.']', '1', $user->hasRole($role->name)) }}
+                            
+                        </td>
+                        @empty
+                            <td>[-]</td>
+                        @endforelse
+                    </tr>
+                @empty
+                <tr><td colspan="2">{{ trans('messages.no-users-found')}}</td></tr>
+                @endforelse 
+                </tbody>
+            </table>
+            <div class="form-group actions-row">
+                    {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
+                        array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
+            </div>
+            {{Form::close()}}
+        </div>
+    </div>
+@stop
\ No newline at end of file
diff --git a/resources/views/role/create.blade.php b/resources/views/role/create.blade.php
index 53786dc..8aede84 100755
--- a/resources/views/role/create.blade.php
+++ b/resources/views/role/create.blade.php
@@ -1,60 +1,43 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-users"></i> {!! trans('menu.access-control') !!}</li>
-            <li><a href="{!! route('role.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.role', 2) !!}</a></li>
-            <li class="active">{!! trans('action.new').' '.trans_choice('menu.role', 1) !!}</li>
-        </ul>
-    </div>
+<div>
+    <ol class="breadcrumb">
+      <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+      <li>
+        <a href="{{ URL::route('role.index') }}">{{ Lang::choice('messages.role',1) }}</a>
+      </li>
+      <li class="active">{{trans('messages.new-role')}}</li>
+    </ol>
 </div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-pencil"></i> {!! trans('action.new').' '.trans_choice('menu.role', 1) !!} 
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
-			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
+<div class="panel panel-primary">
+    <div class="panel-heading ">
+        <span class="glyphicon glyphicon-user"></span>
+        {{trans('messages.new-role')}}
+    </div>
+    <div class="panel-body">
+    <!-- if there are creation errors, they will show here -->
+        @if($errors->all())
+            <div class="alert alert-danger">
+                {{ HTML::ul($errors->all()) }}
             </div>
-            
+        
 
-			{!! Form::open(array('route' => 'role.store', 'id' => 'form-create-role')) !!}
-				<!-- CSRF Token -->
-                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-                <!-- ./ csrf token -->
-				<div class="form-group row">
-					{!! Form::label('name', trans_choice('terms.name',1), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
-					</div>
-				</div>
-				<div class="form-group row">
-					{!! Form::label('description', trans("terms.description"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
-					<div class="col-sm-6">
-						{!! Form::textarea('description', old('description'), array('class' => 'form-control', 'rows' => '2')) !!}
-					</div>
-				</div>
-				<div class="form-group row col-sm-offset-2">
-					{!! Form::button("<i class='fa fa-plus-circle'></i> ".trans('action.save'), 
-						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
-				</div>
+        {{ Form::open(array('url' => 'role', 'id' => 'form-create-role')) }}
 
-			{!! Form::close() !!}
-	  	</div>
-	</div>
+            
+                {{ Form::label('name', Lang::choice('messages.name',1)) }}
+                {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
+            </div>
+            
+                {{ Form::label('description', trans('messages.description')) }}
+                {{ Form::textarea('description', Input::old('description'), 
+                    array('class' => 'form-control', 'rows' => '2')) }}
+            </div>
+            <div class="form-group actions-row">
+                    {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
+                        array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
+            </div>
+        {{ Form::close() }}
+    </div>
 </div>
-@endsection	
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/role/edit.blade.php b/resources/views/role/edit.blade.php
index bda5180..098cb77 100755
--- a/resources/views/role/edit.blade.php
+++ b/resources/views/role/edit.blade.php
@@ -1,61 +1,43 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-users"></i> {!! trans('menu.access-control') !!}</li>
-            <li><a href="{!! route('role.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.role', 2) !!}</a></li>
-            <li class="active">{!! trans('action.edit').' '.trans_choice('menu.role', 1) !!}</li>
-        </ul>
-    </div>
+<div>
+    <ol class="breadcrumb">
+      <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+      <li>
+        <a href="{{ URL::route('role.index') }}">{{ Lang::choice('messages.role',1) }}</a>
+      </li>
+      <li class="active">{{trans('messages.edit-role')}}</li>
+    </ol>
 </div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-edit"></i> {!! trans('action.edit').' '.trans_choice('menu.role', 1) !!} 
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
-			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
+<div class="panel panel-primary">
+    <div class="panel-heading ">
+        <span class="glyphicon glyphicon-edit"></span>
+            {{trans('messages.edit-role')}}
+    </div>
+    <div class="panel-body">
+        @if($errors->all())
+            <div class="alert alert-danger">
+                {{ HTML::ul($errors->all()) }}
+            </div>
+        
+        {{ Form::model($role, array(
+                'route' => array('role.update', $role->id), 'method' => 'PUT',
+                'id' => 'form-edit-role')) }}
+            
+                {{ Form::label('name',  Lang::choice('messages.name',1)) }}
+                {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
+            </div>
+            
+                {{ Form::label('description', trans('messages.description')) }}
+                {{ Form::textarea('description', Input::old('description'), 
+                    array('class' => 'form-control', 'rows' => '2')) }}
+            </div>
+            <div class="form-group actions-row">
+                    {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
+                        array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
             </div>
-            
-
-			{!! Form::model($role, array('route' => array('role.update', $role->id), 
-				'method' => 'PUT', 'id' => 'form-edit-role')) !!}
-				<!-- CSRF Token -->
-                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-                <!-- ./ csrf token -->
-				<div class="form-group row">
-					{!! Form::label('name', trans_choice('terms.name',1), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
-					</div>
-				</div>
-				<div class="form-group row">
-					{!! Form::label('description', trans("terms.description"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
-					<div class="col-sm-6">
-						{!! Form::textarea('description', old('description'), array('class' => 'form-control', 'rows' => '2')) !!}
-					</div>
-				</div>
-				<div class="form-group row col-sm-offset-2">
-					{!! Form::button("<i class='fa fa-check-circle'></i> ".trans('action.update'), 
-						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
-				</div>
 
-			{!! Form::close() !!}
-	  	</div>
-	</div>
+        {{ Form::close() }}
+    </div>
 </div>
-@endsection
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/role/index.blade.php b/resources/views/role/index.blade.php
index d0e1834..d0ca49f 100755
--- a/resources/views/role/index.blade.php
+++ b/resources/views/role/index.blade.php
@@ -1,89 +1,62 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-users"></i> {!! trans('menu.access-control') !!}</li>
-            <li class="active"><i class="fa fa-cube"></i> {!! trans_choice('menu.role', 2) !!}</li>
-        </ul>
-    </div>
+<div>
+    <ol class="breadcrumb">
+      <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+      <li class="active">{{ Lang::choice('messages.role', 2) }}</li>
+    </ol>
 </div>
-<div class="conter-wrapper">
-	<div class="row">
-		<div class="col-sm-12">
-			<div class="card">
-				<div class="card-header">
-				    <i class="fa fa-book"></i> {!! trans_choice('menu.role', 2) !!} 
-				    <span>
-					    <a class="btn btn-sm btn-belize-hole" href="{!! url("role/create") !!}" >
-							<i class="fa fa-plus-circle"></i>
-							{!! trans('action.new').' '.trans_choice('menu.role', 1) !!}
-						</a>
-						<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-							<i class="fa fa-step-backward"></i>
-							{!! trans('action.back') !!}
-						</a>				
-					</span>
-				</div>
-			  	<div class="card-block">	  		
-					@if (Session::has('message'))
-						<div class="alert alert-info">{!! Session::get('message') !!}</div>
-					
-					@if($errors->all())
-		            <div class="alert alert-danger alert-dismissible" role="alert">
-		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-		            </div>
-		            
-				 	<table class="table table-bordered table-sm search-table">
-						<thead>
-							<tr>
-								<th>{!! trans('terms.name') !!}</th>
-								<th>{!! trans('terms.description') !!}</th>
-								<th></th>
-							</tr>
-						</thead>
-						<tbody>
-						@foreach($roles as $key => $value)
-							<tr @if(session()->has('active_role'))
-				                    {!! (session('active_role') == $value->id)?"class='warning'":"" !!}
-				                
-				                >
-								<td>{!! $value->name !!}</td>
-								<td>{!! $value->description !!}</td>
-								
-								<td>
-
-								<!-- show the test category (uses the show method found at GET /role/{id} -->
-									<a class="btn btn-sm btn-success" href="{!! url("role/" . $value->id) !!}" >
-										<i class="fa fa-folder-open-o"></i>
-										{!! trans('action.view') !!}
-									</a>
-
-								<!-- edit this test category (uses edit method found at GET /role/{id}/edit -->
-									<a class="btn btn-sm btn-info" href="{!! url("role/" . $value->id . "/edit") !!}" >
-										<i class="fa fa-edit"></i>
-										{!! trans('action.edit') !!}
-									</a>
-									
-								<!-- delete this test category (uses delete method found at GET /role/{id}/delete -->
-									<button class="btn btn-sm btn-danger delete-item-link"
-										data-toggle="modal" data-target=".confirm-delete-modal"	
-										data-id='{!! url("role/" . $value->id . "/delete") !!}'>
-										<i class="fa fa-trash-o"></i>
-										{!! trans('action.delete') !!}
-									</button>
-								</td>
-							</tr>
-						@endforeach
-						</tbody>
-					</table>
-			  	</div>
-			</div>
-		</div>
-	</div>
-	{!! session(['SOURCE_URL' => URL::full()]) !!}
+@if (Session::has('message'))
+    <div class="alert alert-info">{{ Session::get('message') }}</div>
+
+<div class="panel panel-primary">
+    <div class="panel-heading ">
+        <span class="glyphicon glyphicon-user"></span>
+        {{ Lang::choice('messages.role', 2) }}
+        <div class="panel-btn">
+            <a class="btn btn-sm btn-info" href="{{ URL::to("role/create") }}" >
+                <span class="glyphicon glyphicon-plus-sign"></span>
+                {{trans('messages.new-role')}}
+            </a>
+        </div>
+    </div>
+    <div class="panel-body">
+        <table class="table table-striped table-hover table-condensed">
+            <thead>
+                <tr>
+                    <th>{{ Lang::choice('messages.name', 1 ) }}</th>
+                    <th>{{trans('messages.description')}}</th>
+                    <th></th>
+                </tr>
+            </thead>
+            <tbody>
+            @forelse($roles as $role)
+                <tr @if(Session::has('activerole'))
+                            {{(Session::get('activerole') == $role->id)?"class='info'":""}}
+                        >
+                    <td>{{ $role->name }}</td>
+                    <td>{{ $role->description }}</td>
+                    <td>
+                        <a class="btn btn-sm btn-info {{($role == Role::getAdminRole()) ? 'disabled': ''}}" 
+                            href="{{ URL::to("role/" . $role->id . "/edit") }}" >
+                            <span class="glyphicon glyphicon-edit"></span>
+                            {{ trans('messages.edit') }}
+                        </a>
+                        <button class="btn btn-sm btn-danger delete-item-link {{($role == Role::getAdminRole()) ? 'disabled': ''}}" 
+                            data-toggle="modal" data-target=".confirm-delete-modal" 
+                            data-id='{{ URL::to("role/" . $role->id . "/delete") }}'>
+                            <span class="glyphicon glyphicon-trash"></span>
+                            {{ trans('messages.delete') }}
+                        </button>
+                    </td>
+                </tr>
+            @empty
+                <tr><td colspan="2">{{ trans('messages.no-roles-found') }}</td></tr>
+            @endforelse
+            </tbody>
+        </table>
+        <?php echo $roles->links(); 
+        Session::put('SOURCE_URL', URL::full());?>
+    </div>
 </div>
-@endsection
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/role/show.blade.php b/resources/views/role/show.blade.php
deleted file mode 100755
index 53cd8c4..0000000
--- a/resources/views/role/show.blade.php
+++ /dev/null
@@ -1,46 +0,0 @@
-@extends("app")
-
-@section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-users"></i> {!! trans('menu.access-control') !!}</li>
-            <li><a href="{!! route('role.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.role', 2) !!}</a></li>
-            <li class="active">{!! trans('action.view').' '.trans_choice('menu.role', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-file-text"></i> <strong>{!! trans('terms.details-for').': '.$role->name !!}</strong>
-		    <span>
-		    	<a class="btn btn-sm btn-belize-hole" href="{!! url("role/create") !!}" >
-					<i class="fa fa-plus-circle"></i>
-					{!! trans('action.new').' '.trans_choice('menu.role', 1) !!}
-				</a>
-				<a class="btn btn-sm btn-info" href="{!! url("role/" . $role->id . "/edit") !!}" >
-					<i class="fa fa-edit"></i>
-					{!! trans('action.edit') !!}
-				</a>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>	  		
-		<!-- if there are creation errors, they will show here -->
-		@if($errors->all())
-			<div class="alert alert-danger">
-				{!! HTML::ul($errors->all()) !!}
-			</div>
-		
-
-		<ul class="list-group list-group-flush">
-		    <li class="list-group-item"><h4>{!! trans('terms.name').': ' !!}<small>{!! $role->name !!}</small></h4></li>
-		    <li class="list-group-item"><h5>{!! trans('terms.description').': ' !!}<small>{!! $role->description !!}</small></h5></li>
-	  	</ul>
-	</div>
-</div>
-@endsection	
\ No newline at end of file
diff --git a/resources/views/specimentype/create.blade.php b/resources/views/specimentype/create.blade.php
index 9f3b45d..2cb4376 100755
--- a/resources/views/specimentype/create.blade.php
+++ b/resources/views/specimentype/create.blade.php
@@ -1,60 +1,47 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li><a href="{!! route('specimentype.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.specimen-type', 2) !!}</a></li>
-            <li class="active">{!! trans('action.new').' '.trans_choice('menu.specimen-type', 1) !!}</li>
-        </ul>
-    </div>
+<div>
+	<ol class="breadcrumb">
+	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+	  <li>
+	  	<a href="{{ URL::route('specimentype.index') }}">{{ Lang::choice('messages.specimen-type',2) }}</a>
+	  </li>
+	  <li class="active">{{trans('messages.create-specimen-type')}}</li>
+	</ol>
 </div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-pencil"></i> {!! trans('action.new').' '.trans_choice('menu.specimen-type', 1) !!} 
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
-			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" specimen-type="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
+<div class="panel panel-primary">
+	<div class="panel-heading ">
+		<span class="glyphicon glyphicon-user"></span>
+		{{trans('messages.create-specimen-type')}}
+	</div>
+	<div class="panel-body">
+	<!-- if there are creation errors, they will show here -->
+		
+		@if($errors->all())
+			<div class="alert alert-danger">
+				{{ HTML::ul($errors->all()) }}
+			</div>
+		
+
+		{{ Form::open(array('url' => 'specimentype', 'id' => 'form-create-specimentype')) }}
 
-			{!! Form::open(array('route' => 'specimentype.store', 'id' => 'form-create-specimen-type')) !!}
-				<!-- CSRF Token -->
-                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-                <!-- ./ csrf token -->
-				<div class="form-group row">
-					{!! Form::label('name', trans_choice('terms.name',1), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
-					</div>
-				</div>
-				<div class="form-group row">
-					{!! Form::label('description', trans("terms.description"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
-					<div class="col-sm-6">
-						{!! Form::textarea('description', old('description'), array('class' => 'form-control', 'rows' => '2')) !!}
-					</div>
-				</div>
-				<div class="form-group row col-sm-offset-2">
-					{!! Form::button("<i class='fa fa-plus-circle'></i> ".trans('action.save'), 
-						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
-				</div>
+			
+				{{ Form::label('name', Lang::choice('messages.name', 1)) }}
+				{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
+			</div>
+			
+				{{ Form::label('description', trans('messages.description')) }}
+				{{ Form::textarea('description', Input::old('description'), 
+					array('class' => 'form-control', 'rows' => '2')) }}
+			</div>
+			<div class="form-group actions-row">
+				{{ Form::button(
+					'<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'),
+					['class' => 'btn btn-primary', 'onclick' => 'submit()'] 
+				) }}
+			</div>
 
-			{!! Form::close() !!}
-	  	</div>
+		{{ Form::close() }}
 	</div>
 </div>
-@endsection	
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/specimentype/edit.blade.php b/resources/views/specimentype/edit.blade.php
index 9bc610f..3118f3f 100755
--- a/resources/views/specimentype/edit.blade.php
+++ b/resources/views/specimentype/edit.blade.php
@@ -1,61 +1,45 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li><a href="{!! route('specimentype.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.specimen-type', 2) !!}</a></li>
-            <li class="active">{!! trans('action.edit').' '.trans_choice('menu.specimen-type', 1) !!}</li>
-        </ul>
-    </div>
+<div>
+	<ol class="breadcrumb">
+	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+	  <li>
+	  	<a href="{{ URL::route('specimentype.index') }}">{{ Lang::choice('messages.specimen-type',2) }}</a>
+	  </li>
+	  <li class="active">{{trans('messages.edit-specimen-type')}}</li>
+	</ol>
 </div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-edit"></i> {!! trans('action.edit').' '.trans_choice('menu.specimen-type', 1) !!} 
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
-			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
-
-			{!! Form::model($specimentype, array('route' => array('specimentype.update', $specimentype->id), 
-				'method' => 'PUT', 'id' => 'form-edit-specimen-type')) !!}
-				<!-- CSRF Token -->
-                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-                <!-- ./ csrf token -->
-				<div class="form-group row">
-					{!! Form::label('name', trans_choice('terms.name',1), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
-					</div>
-				</div>
-				<div class="form-group row">
-					{!! Form::label('description', trans("terms.description"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
-					<div class="col-sm-6">
-						{!! Form::textarea('description', old('description'), array('class' => 'form-control', 'rows' => '2')) !!}
-					</div>
-				</div>
-				<div class="form-group row col-sm-offset-2">
-					{!! Form::button("<i class='fa fa-check-circle'></i> ".trans('action.update'), 
-						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
-				</div>
+<div class="panel panel-primary">
+	<div class="panel-heading ">
+		<span class="glyphicon glyphicon-edit"></span>
+		{{trans('messages.edit-specimen-type')}}
+	</div>
+	<div class="panel-body">
+		@if($errors->all())
+			<div class="alert alert-danger">
+				{{ HTML::ul($errors->all()) }}
+			</div>
+		
+		{{ Form::model($specimentype, array(
+				'route' => array('specimentype.update', $specimentype->id), 'method' => 'PUT',
+				'id' => 'form-edit-specimentype'
+			)) }}
 
-			{!! Form::close() !!}
-	  	</div>
+			
+				{{ Form::label('name', Lang::choice('messages.name',1)) }}
+				{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
+			</div>
+			
+				{{ Form::label('description', trans('messages.description')) }}
+				{{ Form::textarea('description', Input::old('description'), 
+					array('class' => 'form-control', 'rows' => '2')) }}
+			</div>
+			<div class="form-group actions-row">
+				{{ Form::button('<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'), 
+					['class' => 'btn btn-primary', 'onclick' => 'submit()']
+				) }}
+			</div>
+		{{ Form::close() }}
 	</div>
 </div>
-@endsection
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/specimentype/index.blade.php b/resources/views/specimentype/index.blade.php
index ebe5fb1..7237eee 100755
--- a/resources/views/specimentype/index.blade.php
+++ b/resources/views/specimentype/index.blade.php
@@ -1,89 +1,75 @@
-@extends("app")
 
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li class="active"><i class="fa fa-cube"></i> {!! trans_choice('menu.specimen-type', 2) !!}</li>
-        </ul>
-    </div>
+<div>
+
+	<ol class="breadcrumb">
+	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+	  <li class="active">{{ Lang::choice('messages.specimen-type',2) }}</li>
+	</ol>
 </div>
-<div class="conter-wrapper">
-	<div class="row">
-		<div class="col-sm-12">
-			<div class="card">
-				<div class="card-header">
-				    <i class="fa fa-book"></i> {!! trans_choice('menu.specimen-type', 2) !!} 
-				    <span>
-					    <a class="btn btn-sm btn-belize-hole" href="{!! url("specimentype/create") !!}" >
-							<i class="fa fa-plus-circle"></i>
-							{!! trans('action.new').' '.trans_choice('menu.specimen-type', 1) !!}
+@if (Session::has('message'))
+	<div class="alert alert-info">{{ Session::get('message') }}</div>
+
+<div class="panel panel-primary">
+	<div class="panel-heading ">
+		<span class="glyphicon glyphicon-user"></span>
+		{{trans('messages.list-specimen-types')}}
+		<div class="panel-btn">
+			<a class="btn btn-sm btn-info" href="{{ URL::to("specimentype/create") }}" >
+				<span class="glyphicon glyphicon-plus-sign"></span>
+				{{trans('messages.new-specimen-type')}}
+			</a>
+		</div>
+	</div>
+	<div class="panel-body">
+		<table class="table table-striped table-hover table-condensed search-table">
+			<thead>
+				<tr>
+					<th>{{ Lang::choice('messages.name',2) }}</th>
+					<th>{{trans('messages.description')}}</th>
+					<th></th>
+				</tr>
+			</thead>
+			<tbody>
+			@foreach($specimentypes as $key => $value)
+				<tr @if(Session::has('activespecimentype'))
+                            {{(Session::get('activespecimentype') == $value->id)?"class='info'":""}}
+                        
+                        >
+
+					<td>{{ $value->name }}</td>
+					<td>{{ $value->description }}</td>
+
+					<td>
+
+					<!-- show the specimentype (uses the show method found at GET /specimentype/{id} -->
+						<a class="btn btn-sm btn-success" href="{{ URL::to("specimentype/" . $value->id) }}" >
+							<span class="glyphicon glyphicon-eye-open"></span>
+							{{trans('messages.view')}}
 						</a>
-						<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-							<i class="fa fa-step-backward"></i>
-							{!! trans('action.back') !!}
-						</a>				
-					</span>
-				</div>
-			  	<div class="card-block">	  		
-					@if (Session::has('message'))
-						<div class="alert alert-info">{!! Session::get('message') !!}</div>
-					
-					@if($errors->all())
-		            <div class="alert alert-danger alert-dismissible" role="alert">
-		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-		            </div>
-		            
-				 	<table class="table table-bordered table-sm search-table">
-						<thead>
-							<tr>
-								<th>{!! trans('terms.name') !!}</th>
-								<th>{!! trans('terms.description') !!}</th>
-								<th></th>
-							</tr>
-						</thead>
-						<tbody>
-						@foreach($specimentypes as $key => $value)
-							<tr @if(session()->has('active_specimentype'))
-				                    {!! (session('active_specimentype') == $value->id)?"class='warning'":"" !!}
-				                
-				                >
-								<td>{!! $value->name !!}</td>
-								<td>{!! $value->description !!}</td>
-								
-								<td>
 
-								<!-- show the test category (uses the show method found at GET /specimen-type/{id} -->
-									<a class="btn btn-sm btn-success" href="{!! url("specimentype/" . $value->id) !!}" >
-										<i class="fa fa-folder-open-o"></i>
-										{!! trans('action.view') !!}
-									</a>
+					<!-- edit this specimentype (uses the edit method found at GET /specimentype/{id}/edit -->
+						<a class="btn btn-sm btn-info" href="{{ URL::to("specimentype/" . $value->id . "/edit") }}" >
+							<span class="glyphicon glyphicon-edit"></span>
 
-								<!-- edit this test category (uses edit method found at GET /specimen-type/{id}/edit -->
-									<a class="btn btn-sm btn-info" href="{!! url("specimentype/" . $value->id . "/edit") !!}" >
-										<i class="fa fa-edit"></i>
-										{!! trans('action.edit') !!}
-									</a>
-									
-								<!-- delete this test category (uses delete method found at GET /specimen-type/{id}/delete -->
-									<button class="btn btn-sm btn-danger delete-item-link"
-										data-toggle="modal" data-target=".confirm-delete-modal"	
-										data-id='{!! url("specimentype/" . $value->id . "/delete") !!}'>
-										<i class="fa fa-trash-o"></i>
-										{!! trans('action.delete') !!}
-									</button>
-								</td>
-							</tr>
-						@endforeach
-						</tbody>
-					</table>
-			  	</div>
-			</div>
-		</div>
+							{{trans('messages.edit')}}
+
+						</a>
+					<!-- delete this specimentype (uses delete method found at GET /specimentype/{id}/delete -->
+						<button class="btn btn-sm btn-danger delete-item-link" 
+							data-toggle="modal" data-target=".confirm-delete-modal"	
+							data-id='{{ URL::to("specimentype/" . $value->id . "/delete") }}'>
+							<span class="glyphicon glyphicon-trash"></span>
+							{{trans('messages.delete')}}
+						</button>
+
+					</td>
+				</tr>
+			@endforeach
+			</tbody>
+		</table>
+		{{ Session::put('SOURCE_URL', URL::full()) }}
 	</div>
-	{!! session(['SOURCE_URL' => URL::full()]) !!}
 </div>
-@endsection
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/specimentype/show.blade.php b/resources/views/specimentype/show.blade.php
index cba5952..a8b8af9 100755
--- a/resources/views/specimentype/show.blade.php
+++ b/resources/views/specimentype/show.blade.php
@@ -1,46 +1,30 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li><a href="{!! route('specimentype.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.specimen-type', 2) !!}</a></li>
-            <li class="active">{!! trans('action.view').' '.trans_choice('menu.specimen-type', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-file-text"></i> <strong>{!! trans('terms.details-for').': '.$specimentype->name !!}</strong>
-		    <span>
-		    	<a class="btn btn-sm btn-belize-hole" href="{!! url("specimentype/create") !!}" >
-					<i class="fa fa-plus-circle"></i>
-					{!! trans('action.new').' '.trans_choice('menu.specimen-type', 1) !!}
-				</a>
-				<a class="btn btn-sm btn-info" href="{!! url("specimentype/" . $specimentype->id . "/edit") !!}" >
-					<i class="fa fa-edit"></i>
-					{!! trans('action.edit') !!}
+	<div>
+		<ol class="breadcrumb">
+		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+		  <li><a href="{{ URL::route('specimentype.index') }}">{{ Lang::choice('messages.specimen-type',2) }}</a></li>
+		  <li class="active">{{trans('messages.specimen-type-details')}}</li>
+		</ol>
+	</div>
+	<div class="panel panel-primary specimentype-create">
+		<div class="panel-heading ">
+			<span class="glyphicon glyphicon-user"></span>
+			{{trans('messages.specimen-type-details')}}
+			<div class="panel-btn">
+				<a class="btn btn-sm btn-info" href="{{ URL::to("specimentype/". $specimentype->id ."/edit") }}">
+					<span class="glyphicon glyphicon-edit"></span>
+					{{trans('messages.edit')}}
 				</a>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>	  		
-		<!-- if there are creation errors, they will show here -->
-		@if($errors->all())
-			<div class="alert alert-danger">
-				{!! HTML::ul($errors->all()) !!}

-		
-
-		<ul class="list-group list-group-flush">
-		    <li class="list-group-item"><h4>{!! trans('terms.name').': ' !!}<small>{!! $specimentype->name !!}</small></h4></li>
-		    <li class="list-group-item"><h5>{!! trans('terms.description').': ' !!}<small>{!! $specimentype->description !!}</small></h5></li>
-	  	</ul>
+		</div>
+		<div class="panel-body">
+			<div class="display-details">
+				<h3 class="view"><strong>{{ Lang::choice('messages.name',1) }}</strong>{{ $specimentype->name }} </h3>
+				<p class="view-striped"><strong>{{trans('messages.description')}}</strong>
+					{{ $specimentype->description }}</p>
+				<p class="view"><strong>{{trans('messages.date-created')}}</strong>{{ $specimentype->created_at }}</p>
+			</div>
+		</div>
 	</div>
-</div>
-@endsection	
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/test/changeSpecimenType.blade.php b/resources/views/test/changeSpecimenType.blade.php
index 97953f2..c8362af 100755
--- a/resources/views/test/changeSpecimenType.blade.php
+++ b/resources/views/test/changeSpecimenType.blade.php
@@ -1,63 +1,38 @@
-@extends("app")
-
-@section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li><a href="{!! url('test') !!}"><i class="fa fa-user-md"></i> {!! trans_choice('menu.test', 2) !!}</a></li>
-            <li class="active">{!! trans(;action.chage).' '.trans('menu.specimen') !!}</li>
-        </ul>
+<div class="display-details">
+    {{ Form::hidden('specimen_id', $test->specimen_id) }}
+    <div class="container-fluid">
+        <div class="row">
+            <div class="col-md-4">
+                <strong>{{ Lang::choice('messages.test-type',1) }}</strong>
+            </div>
+            <div class="col-md-8">
+                {{$test->testType->name}}
+            </div>
+        </div><br />
+        <div class="row">
+            <div class="col-md-4">
+                <strong>{{trans('messages.specimen-number')}}</strong>
+            </div>
+            <div class="col-md-8">
+                {{$test->specimen_id}}
+            </div>
+        </div><br />
+        <div class="row">
+            <div class="col-md-4">
+                <strong>{{trans('messages.specimen-status')}}</strong>
+            </div>
+            <div class="col-md-8">
+                {{trans('messages.'.$test->specimen->specimenStatus->name)}}
+            </div>
+        </div><br />
+        <div class="row">
+            <div class="col-md-4">
+                <strong>{{ Lang::choice('messages.specimen-type',2) }}</strong>
+            </div>
+            <div class="col-md-8">
+                {{ Form::select('specimen_type', $test->testType->specimenTypes->lists('name','id'),
+                    array($test->specimen->specimen_type_id), array('class' => 'form-control')) }}</p>
+            </div>
+        </div>
     </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-random"></i> {!! $specimen->test->visit->patient->name.' - '.$specimen->specimenType->name !!}
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
-			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
-            <div class="row">
-	            <div class="col-md-8">
-				{!! Form::open(array('route' => 'test.rejectAction')) !!}
-					<!-- CSRF Token -->
-	                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-	                <!-- ./ csrf token -->
-					{!! Form::hidden('specimen_id', $specimen->id) !!}
-	                <div class="form-group row">
-						{!! Form::label('specimen', trans('terms.specimen'), array('class' => 'col-sm-3 form-control-label')) !!}
-						<div class="col-sm-9">
-							{!! Form::select('specimen', $specimentypes, old('specimentype'), array('class' => 'form-control c-select')) !!}
-						</div>
-					</div>
-					<div class="form-group row" align="right">
-						{!! Form::button("<i class='fa fa-plus-circle'></i> ".trans('action.save'), 
-							array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-						<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
-					</div>
-				{!! Form::close() !!}
-				</div>
-				<div class="col-md-4">
-					<ul class="list-group">
-						<li class="list-group-item"><strong>{!! trans_choice('menu.specimen-type', 1).': '.$specimen->specimenType->name !!}</strong></li>
-						<li class="list-group-item"><h6>{!! trans("terms.specimen-id") !!}<small> {!! $specimen->id !!}</small></h6></li>
-						<li class="list-group-item"><h6>{!! trans_choice('menu.test-type', 1) !!}<small> {!! $specimen->test->testType->name !!}</small></h6></li>
-					</ul>
-				</div>
-			</div>
-	  	</div>
-	</div>
-</div>
-@endsection	
\ No newline at end of file
+</div>
\ No newline at end of file
diff --git a/resources/views/test/create.blade.php b/resources/views/test/create.blade.php
index 8791aae..de587c1 100755
--- a/resources/views/test/create.blade.php
+++ b/resources/views/test/create.blade.php
@@ -1,81 +1,98 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li><a href="{!! url('test') !!}"><i class="fa fa-user-md"></i> {!! trans_choice('menu.test', 2) !!}</a></li>
-            <li class="active">{!! trans('action.new').' '.trans_choice('menu.test', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-pencil"></i> {!! trans('action.new').' '.trans_choice('menu.test', 1) !!} 
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
+
+	<div>
+		<ol class="breadcrumb">
+		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+		  <li>
+		  	<a href="{{ URL::route('test.index') }}">{{ Lang::choice('messages.test',2) }}</a>
+		  </li>
+		  <li class="active">{{trans('messages.new-test')}}</li>
+		</ol>
+	</div>
+	<div class="panel panel-primary">
+		<div class="panel-heading ">
+            <div class="container-fluid">
+                <div class="row less-gutter">
+                    <div class="col-md-11">
+						<span class="glyphicon glyphicon-adjust"></span>{{trans('messages.new-test')}}
+                    </div>
+                    <div class="col-md-1">
+                        <a class="btn btn-sm btn-primary pull-right" href="#" onclick="window.history.back();return false;"
+                            alt="{{trans('messages.back')}}" title="{{trans('messages.back')}}">
+                            <span class="glyphicon glyphicon-backward"></span></a>
+                    </div>
+                </div>
+            </div>
 		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
+		<div class="panel-body">
+		<!-- if there are creation errors, they will show here -->
 			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
-            <ul class="list-group" style="padding-bottom:5px;">
-			  	<li class="list-group-item"><strong>{!! trans('terms.details-for').': '.$patient->name !!}</strong></li>
-			  	<li class="list-group-item">
-			  		<h6>
-			  			<span>{!! trans("terms.patient-no") !!}<small> {!! $patient->patient_number !!}</small></span>
-			  			<span>{!! trans("terms.name") !!}<small> {!! $patient->name !!}</small></span>
-			  			<span>{!! trans("terms.age") !!}<small> {!! $patient->getAge() !!}</small></span>
-			  			<span>{!! trans("terms.gender") !!}<small> {!! ($patient->gender==0?trans_choice('terms.sex', 1):trans_choice('terms.sex', 2)) !!}</small></span>
-			  		</h6>
-			  	</li>
-			</ul>
-			{!! Form::open(array('route' => 'test.saveNewTest', 'id' => 'form-new-test')) !!}
-				<!-- CSRF Token -->
-                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-                <!-- ./ csrf token -->
-                {!! Form::hidden('patient_id', $patient->id) !!}
-                <div class="form-group row">
-					{!! Form::label('visit_type', trans('terms.visit-type'), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::select('visit_type', [' ' => '--- Select visit type ---','0' => trans("terms.out-patient"),'1' => trans("terms.in-patient")], null, array('class' => 'form-control c-select')) !!}
-					</div>
-				</div>
-				<div class="form-group row">
-					{!! Form::label('physician', trans("terms.physician"), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!!Form::text('physician', old('physician'), array('class' => 'form-control'))!!}
-					</div>
+				<div class="alert alert-danger">
+					{{ HTML::ul($errors->all()) }}
 				</div>
-				<div class="form-group row">
-					{!! Form::label('tests', trans_choice("menu.test", 2),  array('class' => 'col-sm-2 form-control-label')) !!}
-				</div>					
-				<div class="col-sm-12 card card-block">	
-					@foreach($testtypes as $key=>$value)
-						<div class="col-md-3">
-							<label  class="checkbox">
-								<input type="checkbox" name="testtypes[]" value="{!! $value->id!!}" />{!!$value->name!!}
-							</label>
+			
+
+			{{ Form::open(array('route' => 'test.saveNewTest', 'id' => 'form-new-test')) }}
+				<div class="container-fluid">
+					<div class="row">
+						<div class="col-md-12">
+							<div class="panel panel-info">
+								<div class="panel-heading">
+									<h3 class="panel-title">{{trans("messages.patient-details")}}</h3>
+								</div>
+								<div class="panel-body inline-display-details">
+									<span><strong>{{trans("messages.patient-number")}}</strong> {{ $patient->patient_number }}</span>
+									<span><strong>{{ Lang::choice('messages.name',1) }}</strong> {{ $patient->name }}</span>
+									<span><strong>{{trans("messages.age")}}</strong> {{ $patient->getAge() }}</span>
+									<span><strong>{{trans("messages.gender")}}</strong>
+										{{ $patient->gender==0?trans("messages.male"):trans("messages.female") }}</span>
+								</div>
+							</div>
+							
+								{{ Form::hidden('patient_id', $patient->id) }}
+								{{ Form::label('visit_type', trans("messages.visit-type")) }}
+								{{ Form::select('visit_type', [' ' => '--- Select visit type ---','0' => trans("messages.out-patient"),'1' => trans("messages.in-patient")], null,
+									 array('class' => 'form-control')) }}
+							</div>
+							
+								{{ Form::label('physician', trans("messages.physician")) }}
+								{{Form::text('physician', Input::old('physician'), array('class' => 'form-control'))}}
+							</div>
+							
+								{{ Form::label('tests', trans("messages.select-tests")) }}
+								<div class="form-pane">
+
+									<table class="table table-striped table-hover table-condensed search-table">
+									<thead>
+										<tr>
+											<th>{{ Lang::choice('messages.test',2) }}</th>
+											<th>{{ trans('messages.actions') }}</th>
+														
+										</tr>
+									</thead>
+									<tbody>
+									@foreach($testtypes as $key => $value)
+										<tr>
+											<td>{{ $value->name }}</td>
+											<td><label  class="editor-active">
+												<input type="checkbox" name="testtypes[]" value="{{ $value->id}}" />
+												</label>
+											</td>
+										</tr>
+									@endforeach
+									</tbody>
+						            </table>
+				
+								<div class="form-group actions-row">
+								{{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save-test'), 
+									array('class' => 'btn btn-primary', 'onclick' => 'submit()', 'alt' => 'save_new_test')) }}
+								</div>
 						</div>
-					@endforeach
-				</div>
-				<div class="form-group row" align="right">
-					{!! Form::button("<i class='fa fa-plus-circle'></i> ".trans('action.save'), 
-						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
+					</div>
 				</div>
-			{!! Form::close() !!}
-	  	</div>
+
+			{{ Form::close() }}
+		</div>
 	</div>
-</div>
-@endsection	
\ No newline at end of file
+@stop	
\ No newline at end of file
diff --git a/resources/views/test/edit.blade.php b/resources/views/test/edit.blade.php
index 638b7e0..120cc5d 100755
--- a/resources/views/test/edit.blade.php
+++ b/resources/views/test/edit.blade.php
@@ -1,61 +1,68 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li><a href="{!! url('test') !!}"><i class="fa fa-user-md"></i> {!! trans_choice('menu.test', 2) !!}</a></li>
-            <li class="active">{!! trans('action.edit').' '.trans_choice('menu.test', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-edit"></i> {!! $test->visit->patient->name.' - '.$test->testType->name !!} 
-		    <span>
-				 @if($test->isCompleted() && $test->specimen->isAccepted())
-				 	@if(Auth::user()->can('edit_test_results'))
-					<a class="btn btn-sm btn-info" href="{!! url('test/'.$test->id.'/edit') !!}" >
-						<i class="fa fa-edit"></i>
-						{!! trans('action.edit') !!}
-					</a>
-					
-					@if(Auth::user()->can('verify_test_results') && Auth::user()->id != $test->tested_by)
-					<a class="btn btn-sm btn-midnight-blue" href="{!! route('test.verify', array($test->id)) !!}">
-	                    <i class="fa fa-check-square"></i>
-	                    {!! trans('action.verify') !!}
-	                </a>
-	                
-	            
-	            @if($test->isCompleted() || $test->isVerified())
-		            @if(Auth::user()->can('view_reports'))
-					<a class="btn btn-sm btn-pomegranate" href="{!! route('test.viewDetails', array($test->id)) !!}">
-	                    <i class="fa fa-file-text"></i>
-	                    {!! trans_choice('menu.report', 1) !!}
-	                </a>
-	                
-                
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
+	<div>
+		<ol class="breadcrumb">
+		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+		  <li><a href="{{ URL::route('test.index') }}">{{ Lang::choice('messages.test',2) }}</a></li>
+		  <li class="active">{{ trans('messages.edit') }}</li>
+		</ol>
+	</div>
+	<div class="panel panel-primary">
+		<div class="panel-heading ">
+            <div class="container-fluid">
+	            <div class="row less-gutter">
+		            <div class="col-md-11">
+						<span class="glyphicon glyphicon-filter"></span>{{ trans('messages.edit') }}
+                        @if($test->testType->instruments->count() > 0)
+                        <div class="panel-btn">
+                            <a class="btn btn-sm btn-info fetch-test-data" href="javascript:void(0)"
+                                title="{{trans('messages.fetch-test-data-title')}}"
+                                data-test-type-id="{{$test->testType->id}}"
+                                data-url="{{URL::route('instrument.getResult')}}"
+                                data-instrument-count="{{$test->testType->instruments->count()}}">
+                                <span class="glyphicon glyphicon-plus-sign"></span>
+                                {{trans('messages.fetch-test-data')}}
+                            </a>
+                        </div>
+                        
+                        @if($test->isCompleted() && $test->specimen->isAccepted())
+						<div class="panel-btn">
+							@if(Auth::user()->can('verify_test_results') && Auth::user()->id != $test->tested_by)
+							<a class="btn btn-sm btn-success" href="{{ URL::route('test.verify', array($test->id)) }}">
+								<span class="glyphicon glyphicon-thumbs-up"></span>
+								{{trans('messages.verify')}}
+							</a>
+							
+							@if(Auth::user()->can('view_reports'))
+								<a class="btn btn-sm btn-default" href="{{ URL::to('patientreport/'.$test->visit->patient->id) }}">
+									<span class="glyphicon glyphicon-eye-open"></span>
+									{{trans('messages.view-report')}}
+								</a>
+							
+						</div>
+						
+					</div>
+		            <div class="col-md-1">
+		                <a class="btn btn-sm btn-primary pull-right" href="#" onclick="window.history.back();return false;"
+		                    alt="{{trans('messages.back')}}" title="{{trans('messages.back')}}">
+		                    <span class="glyphicon glyphicon-backward"></span></a>
+		            </div>
+		        </div>
+		    </div>
 		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
+		<div class="panel-body">
+		<!-- if there are creation errors, they will show here -->
 			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
-            <div class="row">
-	            <div class="col-md-6">
-		            {!! Form::open(array('route' => array('test.saveResults', $test->id), 'method' => 'POST')) !!}
+				<div class="alert alert-danger">
+					{{ HTML::ul($errors->all()) }}
+				</div>
+			
+			<div class="container-fluid">
+                <div class="row">
+                    <div class="col-md-6">
+					{{ Form::open(array('route' => array('test.saveResults', $test->id), 'method' => 'POST')) }}
 						@foreach($test->testType->measures as $measure)
-							<div class="form-group row">
+							
 								<?php
 								$ans = "";
 								foreach ($test->testResults as $res) {
@@ -65,153 +72,314 @@
 							<?php
 							$fieldName = "m_".$measure->id;
 							?>
-							@if ( $measure->isNumeric() ) 
-		                        {!! Form::label($fieldName , $measure->name, array('class' => 'col-sm-2 form-control-label')) !!}
-		                        <div class="col-sm-8"> 
-			                        {!! Form::text($fieldName, $ans, array(
+								@if ( $measure->isNumeric() ) 
+			                        {{ Form::label($fieldName , $measure->name) }}
+			                        {{ Form::text($fieldName, $ans, array(
 			                            'class' => 'form-control result-interpretation-trigger',
-			                            'data-url' => route('test.resultinterpretation'),
+			                            'data-url' => URL::route('test.resultinterpretation'),
 			                            'data-age' => $test->visit->patient->dob,
 			                            'data-gender' => $test->visit->patient->gender,
-			                            'data-measureid' => $measure->id
+			                            'data-measureid' => $measure->id,
+                                        'data-test_id' => $test->id
 			                            ))
-			                        !!}
-			                    </div>
-	                            <span class='units'>
-	                                {!! App\Models\Measure::getRange($test->visit->patient, $measure->id) !!}
-	                                {!! $measure->unit !!}
-	                            </span>
-							@elseif ( $measure->isAlphanumeric() || $measure->isAutocomplete() ) 
-		                        <?php
-		                        $measure_values = array();
-	                            $measure_values[] = '';
-		                        foreach ($measure->measureRanges as $range) {
-		                            $measure_values[$range->alphanumeric] = $range->alphanumeric;
-		                        }
-		                        ?>
-	                            {!! Form::label($fieldName , $measure->name, array('class' => 'col-sm-2 form-control-label')) !!}
-	                            <div class="col-sm-8"> 
-		                            {!! Form::select($fieldName, $measure_values, array_search($ans, $measure_values),
+			                        }}
+		                            <span class='units'>
+		                                {{Measure::getRange($test->visit->patient, $measure->id)}}
+		                                {{$measure->unit}}
+		                            </span>
+								@elseif ( $measure->isAlphanumeric() || $measure->isAutocomplete() ) 
+			                        <?php
+			                        $measure_values = array();
+		                            $measure_values[] = '';
+			                        foreach ($measure->measureRanges as $range) {
+			                            $measure_values[$range->alphanumeric] = $range->alphanumeric;
+			                        }
+			                        ?>
+		                            {{ Form::label($fieldName , $measure->name) }}
+		                            {{ Form::select($fieldName, $measure_values, array_search($ans, $measure_values),
 		                                array('class' => 'form-control result-interpretation-trigger',
-		                                'data-url' => route('test.resultinterpretation'),
+		                                'data-url' => URL::route('test.resultinterpretation'),
 		                                'data-measureid' => $measure->id
 		                                )) 
-		                            !!}
-		                           </div>
-							@elseif ( $measure->isFreeText() ) 
-	                            {!! Form::label($fieldName, $measure->name, array('class' => 'col-sm-2 form-control-label')) !!}
-	                            <?php
-									$sense = '';
-									if($measure->name=="Sensitivity"||$measure->name=="sensitivity")
-										$sense = ' sense'.$test->id;
-								?>
-								<div class="col-sm-8"> 
-	                            	{!!Form::text($fieldName, $ans, array('class' => 'form-control'.$sense))!!}
-	                            </div>
-							
-	                    </div>
-	                @endforeach
-	                <div class="form-group row">
-	                    {!! Form::label('interpretation', trans('terms.remarks'), array('class' => 'col-sm-2 form-control-label')) !!}
-	                    <div class="col-sm-8"> 
-	                    	{!! Form::textarea('interpretation', $test->interpretation, array('class' => 'form-control result-interpretation', 'rows' => '2')) !!}
-	                    </div>
-	                </div>
-	                <div class="form-group row col-sm-offset-2">
-						{!! Form::button("<i class='fa fa-check-circle'></i> ".trans('action.update'), 
-							array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-						<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
-					</div>
-					{!! Form::close() !!}
-				</div>
-				<div class="col-md-6">
-					<ul class="list-group" style="padding-bottom:5px">
-  						<li class="list-group-item"><strong>{!! trans_choice('menu.patient', 1) !!}</strong></li>
-  						<li class="list-group-item">
-  							<h6>
-					  			<span>{!! trans("terms.patient-no") !!}<small> {!! $test->visit->patient->patient_number !!}</small></span>
-					  			<span>{!! trans("terms.age") !!}<small> {!! $test->visit->patient->getAge() !!}</small></span>
-					  			<span>{!! trans("terms.gender") !!}<small> {!! ($test->visit->patient->gender==0?trans_choice('terms.sex', 1):trans_choice('terms.sex', 2)) !!}</small></span>
-					  		</h6>
-  						</li>
-					</ul>
-					<ul class="list-group" style="padding-bottom:5px">
-  						<li class="list-group-item"><strong>{!! trans('terms.specimen') !!}</strong></li>
-  						<li class="list-group-item">
-  							<h6>
-					  			<span>{!! trans("terms.type") !!}<small> {!! $test->specimen->specimenType->name or trans('messages.pending') !!}</small></span>
-					  			<span>{!! trans("terms.specimen-id") !!}<small> {!! $test->getSpecimenId() !!}</small></span>
-					  			<span>{!! trans("terms.test-status") !!}<small> {!! trans('terms.'.$test->specimen->specimenStatus->name) !!}</small></span>
-
-								@if($test->specimen->isRejected())
-									<span>{!! trans("menu.reject-reason") !!}<small> {!! $test->specimen->rejectionReason->reason or trans('messages.pending') !!}</small></span>
-									<span>{!! trans("terms.explained-to") !!}<small> {!! $test->specimen->reject_explained_to or trans('messages.pending') !!}</small></span>
-								
-								@if($test->specimen->isReferred())
-								<br>
-									<span>{!! trans("terms.referred") !!}
-										<small> 
-											@if($test->specimen->referral->status == Referral::REFERRED_IN)
-												{!! trans("messages.in") !!}
-											@elseif($test->specimen->referral->status == Referral::REFERRED_OUT)
-												{!! trans("messages.out") !!}
-											
-										</small>
-									</span>
-									<span>{!! trans_choice("menu.facility", 1) !!}<small> {!! $test->specimen->referral->facility->name !!}</small></span>
-									<span>
-										@if($test->specimen->referral->status == Referral::REFERRED_IN)
-											{!! trans("messages.originating-from") !!}
-										@elseif($test->specimen->referral->status == Referral::REFERRED_OUT)
-											{!! trans("messages.intended-reciepient") !!}
-										
-										<small> {!! $test->specimen->referral->person !!}</small>
-									</span>
-									<span>{!! trans("terms.contacts") !!}<small> {!! $test->specimen->referral->contacts !!}</small></span>
-									<span>
-										@if($test->specimen->referral->status == Referral::REFERRED_IN)
-											{!! trans("messages.recieved-by") !!}
-										@elseif($test->specimen->referral->status == Referral::REFERRED_OUT)
-											{!! trans("messages.referred-by") !!}
-										
-										<small> {!! $test->specimen->referral->user->name !!}</small>
-									</span>
-									<span>{!! trans("terms.specimen-id") !!}<small> {!! $test->getSpecimenId() !!}</small></span>
+		                            }}
+								@elseif ( $measure->isFreeText() ) 
+		                            {{ Form::label($fieldName, $measure->name) }}
+		                            <?php
+										$sense = '';
+										if($measure->name=="Sensitivity"||$measure->name=="sensitivity")
+											$sense = ' sense'.$test->id;
+									?>
+		                            {{Form::text($fieldName, $ans, array('class' => 'form-control'.$sense))}}
 								
-					  		</h6>
-  						</li>
-					</ul>
-					<ul class="list-group" style="padding-bottom:5px;">
-					  	<li class="list-group-item"><strong>{!! trans('terms.details-for').': '.$test->visit->patient->name.' - '.$test->testType->name !!}</strong></li>
-					  	<li class="list-group-item"><h6>{!! trans_choice("menu.test-type", 1) !!}<small> {!! $test->testType->name or trans('messages.unknown') !!}</small></h6></li>
-					  	<li class="list-group-item"><h6>{!! trans("terms.visit-no") !!}<small> {!! $test->visit->visit_number or trans('messages.unknown') !!}</small></h6></li>
-					  	<li class="list-group-item"><h6>{!! trans("terms.date-ordered") !!}<small> {!! $test->isExternal()?$test->external()->request_date:$test->time_created !!}</small></h6></li>
-					  	<li class="list-group-item"><h6>{!! trans("terms.date-received") !!}<small> {!! $test->time_created !!}</small></h6></li>
-					  	<li class="list-group-item"><h6>{!! trans("terms.test-status") !!}<small> {!! trans('terms.'.$test->testStatus->name) !!}</small></h6></li>
-					  	<li class="list-group-item"><h6>{!! trans("terms.physician") !!}<small> {!! $test->requested_by or trans('messages.unknown') !!}</small></h6></li>
-					  	<li class="list-group-item">
-					  		<h6>{!! trans("terms.origin") !!}
-				  				<small>
-				  					@if($test->specimen->isReferred() && $test->specimen->referral->status == Referral::REFERRED_IN)
-										{!! trans("messages.in") !!}
+		                    </div>
+		                @endforeach
+		                
+		                    {{ Form::label('interpretation', trans('messages.interpretation')) }}
+		                    {{ Form::textarea('interpretation', $test->interpretation, 
+		                        array('class' => 'form-control result-interpretation', 'rows' => '2')) }}
+		                </div>
+		                <div class="form-group actions-row" align="left">
+							{{ Form::button('<span class="glyphicon glyphicon-save"></span> '.trans('messages.update-test-results'),
+								array('class' => 'btn btn-default', 'onclick' => 'submit()')) }}
+						</div>
+					{{ Form::close() }}
+	                @if(count($test->testType->organisms)>0)
+                    <div class="panel panel-success">  <!-- Patient Details -->
+                        <div class="panel-heading">
+                            <h3 class="panel-title">{{trans("messages.culture-worksheet")}}</h3>
+                        </div>
+                        <div class="panel-body">
+                            <p><strong>{{trans("messages.culture-work-up")}}</strong></p>
+                            <table class="table table-bordered">
+                            	<thead>
+                            		<tr>
+										<th width="15%">{{ trans('messages.date')}}</th>
+										<th width="10%">{{ trans('messages.tech-initials')}}</th>
+										<th>{{ trans('messages.observations-and-work-up')}}</th>
+										<th width="10%"></th>
+									</tr>
+                            	</thead>
+								<tbody id="tbbody_<?php echo $test->id ?>">
+									@if(($observations = $test->culture) != null)
+										@foreach($observations as $observation)
+										<tr>
+											<td>{{ Culture::showTimeAgo($observation->created_at) }}</td>
+											<td>{{ User::find($observation->user_id)->name }}</td>
+											<td>{{ $observation->observation }}</td>
+											<td></td>
+										</tr>
+										@endforeach
+										<tr>
+											<td>{{ Culture::showTimeAgo(date('Y-m-d H:i:s')) }}</td>
+											<td>{{ Auth::user()->name }}</td>
+											<td>{{ Form::textarea('observation', '', 
+					                        	array('class' => 'form-control result-interpretation', 'rows' => '2', 'id' => 'observation_'.$test->id)) }}
+					                        </td>
+											<td><a class="btn btn-xs btn-success" href="javascript:void(0)" onclick="saveObservation(<?php echo $test->id; ?>, <?php echo Auth::user()->id; ?>, <?php echo "'".Auth::user()->name."'"; ?>)">
+												{{ trans('messages.save') }}</a>
+											</td>
+										</tr>
 									@else
-										{!! $test->visit->visit_type !!}
+										<tr>
+											<td>{{ Culture::showTimeAgo(date('Y-m-d H:i:s')) }}</td>
+											<td>{{ Auth::user()->name }}</td>
+											<td>{{ Form::textarea('observation', $test->interpretation, 
+					                        	array('class' => 'form-control result-interpretation', 'rows' => '2', 'id' => 'observation_'.$test->id)) }}
+					                        </td>
+											<td><a class="btn btn-xs btn-success" href="javascript:void(0)" onclick="saveObservation(<?php echo $test->id; ?>, <?php echo Auth::user()->id; ?>, <?php echo "'".Auth::user()->name."'"; ?>)">
+												{{ trans('messages.save') }}</a>
+											</td>
+										</tr>
+									
+								</tbody>
+							</table>
+							<p><strong>{{trans("messages.susceptibility-test-results")}}</strong></p>
+							
+								
+									<div class="container-fluid">
+										<?php 
+											$cnt = 0;
+											$zebra = "";
+											$checked=false; 
+											$checker = '';
+											$susOrgIds = array();
+											$defaultZone='';
+											$defaultInterp='';
+										?>
+										@foreach($test->testType->organisms as $key=>$value)
+											{{ ($cnt%4==0)?"<div class='row $zebra'>":"" }}
+											<?php
+												$cnt++;
+												$zebra = (((int)$cnt/4)%2==1?"row-striped":"");
+											?>
+											<div class="col-md-4">
+												<label  class="checkbox">
+													<input type="checkbox" name="organism[]" value="{{ $value->id}}" {{ count($test->susceptibility)>0?(in_array($value->id, $test->susceptibility->lists('organism_id'))?'checked':''):'' }} onchange="javascript:showSusceptibility(<?php echo $value->id; ?>)" />{{$value->name}}
+												</label>
+											</div>
+											{{ ($cnt%4==0)?"</div>":"" }}
+										@endforeach
+									</div>
+								</div>
+							</div>
+							@foreach($test->testType->organisms as $key=>$value)
+								<?php $chckd = null; ?>
+								@if(count($test->susceptibility)>0)
+								<?php
+									if(in_array($value->id, $test->susceptibility->lists('organism_id')))
+										$chckd='checked';
+								?>
+								
+								<?php if($chckd){$display='display:block';}else{$display='display:none';} ?>
+							{{ Form::open(array('','id' => 'drugSusceptibilityForm_'.$value->id, 'name' => 'drugSusceptibilityForm_'.$value->id, 'style'=>$display)) }}
+							<table class="table table-bordered">
+								<thead>
+									<tr>
+										<th colspan="3">{{ $value->name }}</th>
+									</tr>
+									<tr>
+										<th width="50%">{{ Lang::choice('messages.drug',1) }}</th>
+										<th>{{ trans('messages.zone-size')}}</th>
+										<th>{{ trans('messages.interp')}}</th>
+									</tr>
+								</thead>
+								<tbody id="enteredResults_<?php echo $value->id; ?>">
+									@foreach($value->drugs as $drug)
+									{{ Form::hidden('test[]', $test->id, array('id' => 'test[]', 'name' => 'test[]')) }}
+									{{ Form::hidden('drug[]', $drug->id, array('id' => 'drug[]', 'name' => 'drug[]')) }}
+									{{ Form::hidden('organism[]', $value->id, array('id' => 'organism[]', 'name' => 'organism[]')) }}
+									@if($sensitivity=Susceptibility::getDrugSusceptibility($test->id, $value->id, $drug->id))
+										<?php
+										$defaultZone = $sensitivity->zone;
+										$defaultInterp = $sensitivity->interpretation;
+										?>
 									
-				  				</small>
-					  		</h6>
-					  	</li>
-					  	<li class="list-group-item"><h6>{!! trans("terms.registered-by") !!}<small> {!! $test->createdBy->name or trans('messages.unknown') !!}</small></h6></li>
-					  	<li class="list-group-item"><h6>{!! trans("terms.performed-by") !!}<small> {!! $test->testedBy->name or trans('messages.unknown') !!}</small></h6></li>
-					  	@if($test->isVerified())
-					  		<li class="list-group-item"><h6>{!! trans("terms.verified-by") !!}<small> {!! $test->verifiedBy->name or trans('messages.verification-pending') !!}</small></h6></li>
-					  	
-					  	@if((!$test->specimen->isRejected()) && ($test->isCompleted() || $test->isVerified()))
-					  		<li class="list-group-item"><h6>{!! trans("menu.turn-around-time") !!}<small> {!! $test->getFormattedTurnaroundTime() !!}</small></h6></li>
-					  	
-					</ul>
+									<tr>
+										<td>{{ $drug->name }}</td>
+										<td>
+											{{ Form::selectRange('zone[]', 0, 50, $defaultZone, ['class' => 'form-control', 'id' => 'zone[]', 'style'=>'width:auto']) }}
+										</td>
+										<td>{{ Form::select('interpretation[]', array($defaultInterp=>$defaultInterp, 'S' => 'S', 'I' => 'I', 'R' => 'R'),'', ['class' => 'form-control', 'id' => 'interpretation[]', 'style'=>'width:auto']) }}</td>
+									</tr>
+									@endforeach
+									<tr id="submit_drug_susceptibility_<?php echo $value->id; ?>">
+										<td colspan="3" align="right">
+											<div class="col-sm-offset-2 col-sm-10">
+												<a class="btn btn-default" href="javascript:void(0)" onclick="saveDrugSusceptibility(<?php echo $test->id; ?>, <?php echo $value->id; ?>)">
+												{{ trans('messages.save') }}</a>
+										    </div>
+									    </td>
+									</tr>
+								</tbody>
+							</table>
+							{{ Form::close() }}
+							@endforeach
+                          </div>
+                        </div> <!-- ./ panel-body -->
+                    
+                    </div>
+	                <div class="col-md-6">
+	                    <div class="panel panel-info">  <!-- Patient Details -->
+	                        <div class="panel-heading">
+	                            <h3 class="panel-title">{{trans("messages.patient-details")}}</h3>
+	                        </div>
+	                        <div class="panel-body">
+	                            <div class="container-fluid">
+	                            	<div class="display-details">
+                                        <p class="view"><strong>{{trans("messages.patient-number")}}</strong>
+	                                        {{$test->visit->patient->patient_number}}</p>
+	                                    <p class="view"><strong>{{ Lang::choice('messages.name',1) }}</strong>
+                                	        {{$test->visit->patient->name}}</p>
+                                        <p class="view"><strong>{{trans("messages.age")}}</strong>
+	                                        {{$test->visit->patient->getAge()}}</p>
+                                        <p class="view"><strong>{{trans("messages.gender")}}</strong>
+	                                        {{$test->visit->patient->gender==0?trans("messages.male"):trans("messages.female")}}</p>
+	                            	</div>
+	                        	</div> <!-- ./ panel-body -->
+	                        </div>
+	                    </div> <!-- ./ panel -->
+	                    <div class="panel panel-info"> <!-- Specimen Details -->
+	                        <div class="panel-heading">
+	                            <h3 class="panel-title">{{trans("messages.specimen-details")}}</h3>
+	                        </div>
+	                        <div class="panel-body">
+	                            <div class="container-fluid">
+	                                <div class="display-details">
+	                                    <p class="view"><strong>{{ Lang::choice('messages.specimen-type',1) }}</strong>
+	                                    	{{$test->specimen->specimenType->name or trans('messages.pending') }}</p>
+	                                    <p class="view"><strong>{{trans('messages.specimen-number')}}</strong>
+	                                    	{{$test->specimen->id or trans('messages.pending') }}</p>
+	                                    <p class="view"><strong>{{trans('messages.specimen-status')}}</strong>
+	                                        {{trans('messages.'.$test->specimen->specimenStatus->name) }}</p>
+	                                
+	                            		@if($test->specimen->isRejected())
+	                                        <p class="view"><strong>{{trans('messages.rejection-reason-title')}}</strong>
+	                                        	{{$test->specimen->rejectionReason->reason or trans('messages.pending') }}</p>
+	                                        <p class="view"><strong>{{trans('messages.reject-explained-to')}}</strong>
+	                                        	{{$test->specimen->reject_explained_to or trans('messages.pending') }}</p>
+	                            		
+			                            @if($test->specimen->isReferred())
+	    	                        	<br>
+	                                        <p class="view"><strong>{{trans("messages.specimen-referred-label")}}</strong>
+	                                        @if($test->specimen->referral->status == Referral::REFERRED_IN)
+	                                            {{ trans("messages.in") }}</p>
+	                                        @elseif($test->specimen->referral->status == Referral::REFERRED_OUT)
+	                                            {{ trans("messages.out") }}</p>
+	                                        
+	                                        <p class="view"><strong>{{Lang::choice("messages.facility", 1)}}</strong>
+	                                        {{$test->specimen->referral->facility->name }}</p>
+	                                        <p class="view"><strong>{{trans("messages.person-involved")}}</strong>
+	                                        {{$test->specimen->referral->person }}</p>
+	                                        <p class="view"><strong>{{trans("messages.contacts")}}</strong>
+	                                        {{$test->specimen->referral->contacts }}</p>
+	                                        <p class="view"><strong>{{trans("messages.referred-by")}}</strong>
+	                                        {{ $test->specimen->referral->user->name }}</p>
+	                            		
+	                            	</div>
+	                        	</div>
+	                   		</div> <!-- ./ panel -->
+	                   	</div>
+	                    <div class="panel panel-info">  <!-- Test Results -->
+	                        <div class="panel-heading">
+	                            <h3 class="panel-title">{{trans("messages.test-details")}}</h3>
+	                        </div>
+	                        <div class="panel-body">
+	                            <div class="container-fluid">
+	                                <div class="display-details">
+	                                    <p class="view"><strong>{{ Lang::choice('messages.test-type',1) }}</strong>
+	                                        {{ $test->testType->name or trans('messages.unknown') }}</p>
+	                                    <p class="view"><strong>{{trans('messages.visit-number')}}</strong>
+	                                        {{$test->visit->visit_number or trans('messages.unknown') }}</p>
+	                                    <p class="view"><strong>{{trans('messages.date-ordered')}}</strong>
+                                            {{ $test->isExternal()?$test->external()->request_date:$test->time_created }}</p>
+	                                    <p class="view"><strong>{{trans('messages.lab-receipt-date')}}</strong>
+	                                        {{$test->time_created}}</p>
+	                                    <p class="view"><strong>{{trans('messages.test-status')}}</strong>
+	                                        {{trans('messages.'.$test->testStatus->name)}}</p>
+	                                    <p class="view-striped"><strong>{{trans('messages.physician')}}</strong>
+	                                        {{$test->requested_by or trans('messages.unknown') }}</p>
+	                                    <p class="view-striped"><strong>{{trans('messages.request-origin')}}</strong>
+	                                        @if($test->specimen->isReferred() && $test->specimen->referral->status == Referral::REFERRED_IN)
+	                                            {{ trans("messages.in") }}
+	                                        @else
+	                                            {{ $test->visit->visit_type }}
+	                                        </p>
+	                                    <p class="view-striped"><strong>{{trans('messages.registered-by')}}</strong>
+	                                        {{$test->createdBy->name or trans('messages.unknown') }}</p>
+	                                    @if($test->isCompleted())
+	                                    <p class="view"><strong>{{trans('messages.tested-by')}}</strong>
+	                                        {{$test->testedBy->name or trans('messages.unknown')}}</p>
+	                                    
+	                                    @if($test->isVerified())
+	                                    <p class="view"><strong>{{trans('messages.verified-by')}}</strong>
+	                                        {{$test->verifiedBy->name or trans('messages.verification-pending')}}</p>
+	                                    
+	                                    @if((!$test->specimen->isRejected()) && ($test->isCompleted() || $test->isVerified()))
+	                                    <!-- Not Rejected and (Verified or Completed)-->
+	                                    <p class="view-striped"><strong>{{trans('messages.turnaround-time')}}</strong>
+	                                        {{$test->getFormattedTurnaroundTime()}}</p>
+	                                    
+	                                </div>
+	                            </div>
+	                        </div> <!-- ./ panel-body -->
+	                    </div>  <!-- ./ panel -->
+
+	                    <div class="panel panel-info">  <!-- Audit trail for results -->
+	                        <div class="panel-heading">
+	                            <h3 class="panel-title">{{trans("messages.previous-results")}}</h3>
+	                        </div>
+	                        <div class="panel-body">
+	                            <div class="container-fluid">
+	                                <div class="display-details">
+	                                    <p class="view-striped"><strong>{{trans('messages.previous-results')}}</strong>
+	                                        <a href="{{URL::route('reports.audit.test', array($test->id))}}">{{trans('messages.audit-report')}}</a></p>
+	                                </div>
+	                            </div>
+	                        </div> <!-- ./ panel-body -->
+	                    </div>  <!-- ./ panel -->
+	                </div>
 				</div>

-	  	</div>
+		</div>
 	</div>
-</div>
-@endsection	
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/test/enterResults.blade.php b/resources/views/test/enterResults.blade.php
index fcdc632..e8dc955 100755
--- a/resources/views/test/enterResults.blade.php
+++ b/resources/views/test/enterResults.blade.php
@@ -1,217 +1,428 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li><a href="{!! url('test') !!}"><i class="fa fa-user-md"></i> {!! trans_choice('menu.test', 2) !!}</a></li>
-            <li class="active">{!! trans('action.edit').' '.trans_choice('menu.test', 1) !!}</li>
-        </ul>
+    <div>
+        <ol class="breadcrumb">
+          <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+          <li><a href="{{ URL::route('test.index') }}">{{ Lang::choice('messages.test',2) }}</a></li>
+          <li class="active">{{ trans('messages.enter-test-results') }}</li>
+        </ol>
     </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-edit"></i> {!! $test->visit->patient->name.' - '.$test->testType->name !!} 
-		    <span>
-				 @if($test->isCompleted() && $test->specimen->isAccepted())
-				 	@if(Auth::user()->can('edit_test_results'))
-					<a class="btn btn-sm btn-info" href="{!! url('test/'.$test->id.'/edit') !!}" >
-						<i class="fa fa-edit"></i>
-						{!! trans('action.edit') !!}
-					</a>
-					
-					@if(Auth::user()->can('verify_test_results') && Auth::user()->id != $test->tested_by)
-					<a class="btn btn-sm btn-midnight-blue" href="{!! route('test.verify', array($test->id)) !!}">
-	                    <i class="fa fa-check-square"></i>
-	                    {!! trans('action.verify') !!}
-	                </a>
-	                
-	            
-	            @if($test->isCompleted() || $test->isVerified())
-		            @if(Auth::user()->can('view_reports'))
-					<a class="btn btn-sm btn-pomegranate" href="{!! route('test.viewDetails', array($test->id)) !!}">
-	                    <i class="fa fa-file-text"></i>
-	                    {!! trans_choice('menu.report', 1) !!}
-	                </a>
-	                
-                
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
-			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
+    <div class="panel panel-primary">
+        <div class="panel-heading ">
+            <div class="container-fluid">
+                <div class="row less-gutter">
+                    <div class="col-md-11">
+                        <span class="glyphicon glyphicon-user"></span> {{ trans('messages.test-results') }}
+                        @if($test->testType->instruments->count() > 0)
+                        <div class="panel-btn">
+                            <a class="btn btn-sm btn-info fetch-test-data" href="javascript:void(0)"
+                                title="{{trans('messages.fetch-test-data-title')}}"
+                                data-test-type-id="{{$test->testType->id}}"
+                                data-url="{{URL::route('instrument.getResult')}}"
+                                data-instrument-count="{{$test->testType->instruments->count()}}">
+                                <span class="glyphicon glyphicon-plus-sign"></span>
+                                {{trans('messages.fetch-test-data')}}
+                            </a>
+                        </div>
+                        
+                    </div>
+                    <div class="col-md-1">
+                        <a class="btn btn-sm btn-primary pull-right"  href="#" onclick="window.history.back();return false;"
+                            alt="{{trans('messages.back')}}" title="{{trans('messages.back')}}">
+                            <span class="glyphicon glyphicon-backward"></span></a>
+                    </div>
+                </div>
             </div>
+        </div>
+        <div class="panel-body">
+        <!-- if there are creation errors, they will show here -->
+            
+            @if($errors->all())
+                <div class="alert alert-danger">
+                    {{ HTML::ul($errors->all()) }}
+                </div>
             
-            <div class="row">
-	            <div class="col-md-6">
-		            {!! Form::open(array('route' => array('test.saveResults', $test->id), 'method' => 'POST')) !!}
-						@foreach($test->testType->measures as $measure)
-							<div class="form-group row">
-								<?php
-								$ans = "";
-								foreach ($test->testResults as $res) {
-									if($res->measure_id == $measure->id)$ans = $res->result;
-								}
-								 ?>
-							<?php
-							$fieldName = "m_".$measure->id;
-							?>
-							@if ( $measure->isNumeric() ) 
-		                        {!! Form::label($fieldName , $measure->name, array('class' => 'col-sm-2 form-control-label')) !!}
-		                        <div class="col-sm-8"> 
-			                        {!! Form::text($fieldName, $ans, array(
+            <div class="container-fluid">
+                <div class="row">
+                    <div class="col-md-6">
+                    {{ Form::open(array('route' => array('test.saveResults',$test->id), 'method' => 'POST',
+                        'id' => 'form-enter-results')) }}
+                        @foreach($test->testType->measures as $measure)
+                            
+                                <?php
+                                $ans = "";
+                                foreach ($test->testResults as $res) {
+                                    if($res->measure_id == $measure->id)$ans = $res->result;
+                                }
+                                $fieldName = "m_".$measure->id;
+                                ?>
+                                @if ( $measure->isNumeric() ) 
+                                    {{ Form::label($fieldName , $measure->name) }}
+                                    {{ Form::text($fieldName, $ans, array(
                                         'class' => 'form-control result-interpretation-trigger',
-                                        'data-url' => route('test.resultinterpretation'),
+                                        'data-url' => URL::route('test.resultinterpretation'),
                                         'data-age' => $test->visit->patient->dob,
                                         'data-gender' => $test->visit->patient->gender,
-                                        'data-measureid' => $measure->id
+                                        'data-measureid' => $measure->id,
+                                        'data-test_id' => $test->id
                                         ))
-                                    !!}
-			                    </div>
-	                            <span class='units'>
-	                                {!! App\Models\Measure::getRange($test->visit->patient, $measure->id) !!}
-	                                {!! $measure->unit !!}
-	                            </span>
-							@elseif ( $measure->isAlphanumeric() || $measure->isAutocomplete() ) 
-		                        <?php
-		                        $measure_values = array();
-	                            $measure_values[] = '';
-		                        foreach ($measure->measureRanges as $range) {
-		                            $measure_values[$range->alphanumeric] = $range->alphanumeric;
-		                        }
-		                        ?>
-	                            {!! Form::label($fieldName , $measure->name, array('class' => 'col-sm-2 form-control-label')) !!}
-	                            <div class="col-sm-8"> 
-		                            {!! Form::select($fieldName, $measure_values, array_search($ans, $measure_values),
+                                    }}
+                                    <span class='units'>
+
+                                        {{Measure::getRange($test->visit->patient, $measure->id)}}
+                                        {{$measure->unit}}
+                                    </span>
+                                @elseif ( $measure->isAlphanumeric() || $measure->isAutocomplete() ) 
+                                    <?php
+                                    $measure_values = array();
+                                    $measure_values[] = '';
+                                    foreach ($measure->measureRanges as $range) {
+                                        $measure_values[$range->alphanumeric] = $range->alphanumeric;
+                                    }
+                                    ?>
+                                    {{ Form::label($fieldName , $measure->name) }}
+                                    {{ Form::select($fieldName, $measure_values, array_search($ans, $measure_values),
                                         array('class' => 'form-control result-interpretation-trigger',
-                                        'data-url' => route('test.resultinterpretation'),
+                                        'data-url' => URL::route('test.resultinterpretation'),
                                         'data-measureid' => $measure->id
                                         )) 
-                                    !!}
-		                           </div>
-							@elseif ( $measure->isFreeText() ) 
-	                            {!! Form::label($fieldName, $measure->name, array('class' => 'col-sm-2 form-control-label')) !!}
-	                            <?php
-									$sense = '';
-									if($measure->name=="Sensitivity"||$measure->name=="sensitivity")
-										$sense = ' sense'.$test->id;
-								?>
-								<div class="col-sm-8"> 
-	                            	{!!Form::text($fieldName, $ans, array('class' => 'form-control'.$sense))!!}
-	                            </div>
-							
-	                    </div>
-	                @endforeach
-	                <div class="form-group row">
-	                    {!! Form::label('interpretation', trans('terms.remarks'), array('class' => 'col-sm-2 form-control-label')) !!}
-	                    <div class="col-sm-8"> 
-	                    	{!! Form::textarea('interpretation', $test->interpretation, array('class' => 'form-control result-interpretation', 'rows' => '2')) !!}
-	                    </div>
-	                </div>
-	                <div class="form-group row col-sm-offset-2">
-						{!! Form::button("<i class='fa fa-check-circle'></i> ".trans('action.save'), 
-							array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-						<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
-					</div>
-					{!! Form::close() !!}
-				</div>
-				<div class="col-md-6">
-					<ul class="list-group" style="padding-bottom:5px">
-  						<li class="list-group-item"><strong>{!! trans_choice('menu.patient', 1) !!}</strong></li>
-  						<li class="list-group-item">
-  							<h6>
-					  			<span>{!! trans("terms.patient-no") !!}<small> {!! $test->visit->patient->patient_number !!}</small></span>
-					  			<span>{!! trans("terms.age") !!}<small> {!! $test->visit->patient->getAge() !!}</small></span>
-					  			<span>{!! trans("terms.gender") !!}<small> {!! ($test->visit->patient->gender==0?trans_choice('terms.sex', 1):trans_choice('terms.sex', 2)) !!}</small></span>
-					  		</h6>
-  						</li>
-					</ul>
-					<ul class="list-group" style="padding-bottom:5px">
-  						<li class="list-group-item"><strong>{!! trans('terms.specimen') !!}</strong></li>
-  						<li class="list-group-item">
-  							<h6>
-					  			<span>{!! trans("terms.type") !!}<small> {!! $test->specimen->specimenType->name or trans('messages.pending') !!}</small></span>
-					  			<span>{!! trans("terms.specimen-id") !!}<small> {!! $test->getSpecimenId() !!}</small></span>
-					  			<span>{!! trans("terms.test-status") !!}<small> {!! trans('terms.'.$test->specimen->specimenStatus->name) !!}</small></span>
-
-								@if($test->specimen->isRejected())
-									<span>{!! trans("menu.reject-reason") !!}<small> {!! $test->specimen->rejectionReason->reason or trans('messages.pending') !!}</small></span>
-									<span>{!! trans("terms.explained-to") !!}<small> {!! $test->specimen->reject_explained_to or trans('messages.pending') !!}</small></span>
-								
-								@if($test->specimen->isReferred())
-								<br>
-									<span>{!! trans("terms.referred") !!}
-										<small> 
-											@if($test->specimen->referral->status == Referral::REFERRED_IN)
-												{!! trans("messages.in") !!}
-											@elseif($test->specimen->referral->status == Referral::REFERRED_OUT)
-												{!! trans("messages.out") !!}
-											
-										</small>
-									</span>
-									<span>{!! trans_choice("menu.facility", 1) !!}<small> {!! $test->specimen->referral->facility->name !!}</small></span>
-									<span>
-										@if($test->specimen->referral->status == Referral::REFERRED_IN)
-											{!! trans("messages.originating-from") !!}
-										@elseif($test->specimen->referral->status == Referral::REFERRED_OUT)
-											{!! trans("messages.intended-reciepient") !!}
-										
-										<small> {!! $test->specimen->referral->person !!}</small>
-									</span>
-									<span>{!! trans("terms.contacts") !!}<small> {!! $test->specimen->referral->contacts !!}</small></span>
-									<span>
-										@if($test->specimen->referral->status == Referral::REFERRED_IN)
-											{!! trans("messages.recieved-by") !!}
-										@elseif($test->specimen->referral->status == Referral::REFERRED_OUT)
-											{!! trans("messages.referred-by") !!}
-										
-										<small> {!! $test->specimen->referral->user->name !!}</small>
-									</span>
-									<span>{!! trans("terms.specimen-id") !!}<small> {!! $test->getSpecimenId() !!}</small></span>
-								
-					  		</h6>
-  						</li>
-					</ul>
-					<ul class="list-group" style="padding-bottom:5px;">
-					  	<li class="list-group-item"><strong>{!! trans('terms.details-for').': '.$test->visit->patient->name.' - '.$test->testType->name !!}</strong></li>
-					  	<li class="list-group-item"><h6>{!! trans_choice("menu.test-type", 1) !!}<small> {!! $test->testType->name or trans('messages.unknown') !!}</small></h6></li>
-					  	<li class="list-group-item"><h6>{!! trans("terms.visit-no") !!}<small> {!! $test->visit->visit_number or trans('messages.unknown') !!}</small></h6></li>
-					  	<li class="list-group-item"><h6>{!! trans("terms.date-ordered") !!}<small> {!! $test->isExternal()?$test->external()->request_date:$test->time_created !!}</small></h6></li>
-					  	<li class="list-group-item"><h6>{!! trans("terms.date-received") !!}<small> {!! $test->time_created !!}</small></h6></li>
-					  	<li class="list-group-item"><h6>{!! trans("terms.test-status") !!}<small> {!! trans('terms.'.$test->testStatus->name) !!}</small></h6></li>
-					  	<li class="list-group-item"><h6>{!! trans("terms.physician") !!}<small> {!! $test->requested_by or trans('messages.unknown') !!}</small></h6></li>
-					  	<li class="list-group-item">
-					  		<h6>{!! trans("terms.origin") !!}
-				  				<small>
-				  					@if($test->specimen->isReferred() && $test->specimen->referral->status == Referral::REFERRED_IN)
-										{!! trans("messages.in") !!}
-									@else
-										{!! $test->visit->visit_type !!}
-									
-				  				</small>
-					  		</h6>
-					  	</li>
-					  	<li class="list-group-item"><h6>{!! trans("terms.registered-by") !!}<small> {!! $test->createdBy->name or trans('messages.unknown') !!}</small></h6></li>
-					  	<li class="list-group-item"><h6>{!! trans("terms.performed-by") !!}<small> {!! $test->testedBy->name or trans('messages.unknown') !!}</small></h6></li>
-					  	@if($test->isVerified())
-					  		<li class="list-group-item"><h6>{!! trans("terms.verified-by") !!}<small> {!! $test->verifiedBy->name or trans('messages.verification-pending') !!}</small></h6></li>
-					  	
-					  	@if((!$test->specimen->isRejected()) && ($test->isCompleted() || $test->isVerified()))
-					  		<li class="list-group-item"><h6>{!! trans("menu.turn-around-time") !!}<small> {!! $test->getFormattedTurnaroundTime() !!}</small></h6></li>
-					  	
-					</ul>
-				</div>
-			</div>
-	  	</div>
-	</div>
-</div>
-@endsection	
\ No newline at end of file
+                                    }}
+                                @elseif ( $measure->isFreeText() ) 
+                                    {{ Form::label($fieldName, $measure->name) }}
+                                    <?php
+                                        $sense = '';
+                                        if($measure->name=="Sensitivity"||$measure->name=="sensitivity")
+                                            $sense = ' sense'.$test->id;
+                                    ?>
+                                    {{Form::text($fieldName, $ans, array('class' => 'form-control'.$sense))}}
+                                
+                            </div>
+                        @endforeach
+                        
+                            {{ Form::label('interpretation', trans('messages.interpretation')) }}
+                            {{ Form::textarea('interpretation', $test->interpretation, 
+                                array('class' => 'form-control result-interpretation', 'rows' => '2')) }}
+                        </div>
+                        <div class="form-group actions-row">
+                            {{ Form::button('<span class="glyphicon glyphicon-save">
+                                </span> '.trans('messages.save-test-results'),
+                                array('class' => 'btn btn-default', 'onclick' => 'submit()')) }}
+                        </div>
+                    {{ Form::close() }}
+                    @if(count($test->testType->organisms)>0)
+                        <div class="panel panel-success">  <!-- Patient Details -->
+                            <div class="panel-heading">
+                                <h3 class="panel-title">{{trans("messages.culture-worksheet")}}</h3>
+                            </div>
+                            <div class="panel-body">
+                                <p><strong>{{trans("messages.culture-work-up")}}</strong></p>
+                                <table class="table table-bordered">
+                                    <thead>
+                                        <tr>
+                                            <th width="15%">{{ trans('messages.date')}}</th>
+                                            <th width="10%">{{ trans('messages.tech-initials')}}</th>
+                                            <th>{{ trans('messages.observations-and-work-up')}}</th>
+                                            <th width="10%"></th>
+                                        </tr>
+                                    </thead>
+                                    <tbody id="tbbody_<?php echo $test->id ?>">
+                                        @if(($observations = $test->culture) != null)
+                                            @foreach($observations as $observation)
+                                            <tr>
+                                                <td>{{ Culture::showTimeAgo($observation->created_at) }}</td>
+                                                <td>{{ User::find($observation->user_id)->name }}</td>
+                                                <td>{{ $observation->observation }}</td>
+                                                <td></td>
+                                            </tr>
+                                            @endforeach
+                                            <tr>
+                                                <td>{{ Culture::showTimeAgo(date('Y-m-d H:i:s')) }}</td>
+                                                <td>{{ Auth::user()->name }}</td>
+                                                <td>{{ Form::textarea('observation', $test->interpretation, 
+                                                    array('class' => 'form-control result-interpretation', 'rows' => '2', 'id' => 'observation_'.$test->id)) }}
+                                                </td>
+                                                <td><a class="btn btn-xs btn-success" href="javascript:void(0)" onclick="saveObservation(<?php echo $test->id; ?>, <?php echo Auth::user()->id; ?>, <?php echo "'".Auth::user()->name."'"; ?>)">
+                                                    {{ trans('messages.save') }}</a>
+                                                </td>
+                                            </tr>
+                                        @else
+                                            <tr>
+                                                <td>{{ Culture::showTimeAgo(date('Y-m-d H:i:s')) }}</td>
+                                                <td>{{ Auth::user()->name }}</td>
+                                                <td>{{ Form::textarea('observation', '', 
+                                                    array('class' => 'form-control result-interpretation', 'rows' => '2', 'id' => 'observation_'.$test->id)) }}
+                                                </td>
+                                                <td><a class="btn btn-xs btn-success" href="javascript:void(0)" onclick="saveObservation(<?php echo $test->id; ?>, <?php echo Auth::user()->id; ?>, <?php echo "'".Auth::user()->name."'"; ?>)">
+                                                    {{ trans('messages.save') }}</a>
+                                                </td>
+                                            </tr>
+                                        
+                                    </tbody>
+                                </table>
+                                <p><strong>{{trans("messages.susceptibility-test-results")}}</strong></p>
+                                
+                                    
+                                        <div class="container-fluid">
+                                            <?php 
+                                                $cnt = 0;
+                                                $zebra = "";
+                                                $checked=false; 
+                                                $checker = '';
+                                                $susOrgIds = array();
+                                            ?>
+                                            @foreach($test->testType->organisms as $key=>$value)
+                                                @if(count($test->susceptibility)>0)
+                                                    @foreach($test->susceptibility as $drugSusceptibility)
+                                                        <?php
+                                                        array_push($susOrgIds, $drugSusceptibility->organism_id);
+                                                        if(in_array($value->id, $susOrgIds))
+                                                            $checked='checked';
+                                                        ?>
+                                                    @endforeach
+                                                
+                                                {{ ($cnt%4==0)?"<div class='row $zebra'>":"" }}
+                                                <?php
+                                                    $cnt++;
+                                                    $zebra = (((int)$cnt/4)%2==1?"row-striped":"");
+                                                ?>
+                                                <div class="col-md-4">
+                                                    <label  class="checkbox">
+                                                        <input type="checkbox" name="organism[]" value="{{ $value->id}}" {{ $checked }} onchange="javascript:showSusceptibility(<?php echo $value->id; ?>)" />{{$value->name}}
+                                                    </label>
+                                                </div>
+                                                {{ ($cnt%4==0)?"</div>":"" }}
+                                            @endforeach
+                                        </div>
+                                    </div>
+                                </div>
+                                @foreach($test->testType->organisms as $key=>$value)
+                                    @if(count($test->susceptibility)>0)
+                                        @foreach($test->susceptibility as $drugSusceptibility)
+                                            <?php
+                                            array_push($susOrgIds, $drugSusceptibility->organism_id);
+                                            if(in_array($value->id, $susOrgIds))
+                                                $checker='checked';
+                                            ?>
+                                        @endforeach
+                                    
+                                    <?php if($checker=='checked'){$display='display:block';}else if($checker!='checked'){$display='display:none';} ?>
+                                {{ Form::open(array('','id' => 'drugSusceptibilityForm_'.$value->id, 'name' => 'drugSusceptibilityForm_'.$value->id, 'style'=>$display)) }}
+                                <table class="table table-bordered">
+                                    <thead>
+                                        <tr>
+                                            <th colspan="3">{{ $value->name }}</th>
+                                        </tr>
+                                        <tr>
+                                            <th width="50%">{{ Lang::choice('messages.drug',1) }}</th>
+                                            <th>{{ trans('messages.zone-size')}}</th>
+                                            <th>{{ trans('messages.interp')}}</th>
+                                        </tr>
+                                    </thead>
+                                    <tbody id="enteredResults_<?php echo $value->id; ?>">
+                                        @foreach($value->drugs as $drug)
+                                        {{ Form::hidden('test[]', $test->id, array('id' => 'test[]', 'name' => 'test[]')) }}
+                                        {{ Form::hidden('drug[]', $drug->id, array('id' => 'drug[]', 'name' => 'drug[]')) }}
+                                        {{ Form::hidden('organism[]', $value->id, array('id' => 'organism[]', 'name' => 'organism[]')) }}
+                                        <tr>
+                                            <td>{{ $drug->name }}</td>
+                                            <td>
+                                                {{ Form::select('zone[]', ['' => '']+range(0, 50), '', ['class' => 'form-control', 'id' => 'zone[]', 'style'=>'width:auto']) }}
+                                            </td>
+                                            <td>{{ Form::select('interpretation[]', array('' => '', 'S' => 'S', 'I' => 'I', 'R' => 'R'),'', ['class' => 'form-control', 'id' => 'interpretation[]', 'style'=>'width:auto']) }}</td>
+                                        </tr>
+                                        @endforeach
+                                        <tr id="submit_drug_susceptibility_<?php echo $value->id; ?>">
+                                            <td colspan="3" align="right">
+                                                <div class="col-sm-offset-2 col-sm-10">
+                                                    <a class="btn btn-default" href="javascript:void(0)" onclick="saveDrugSusceptibility(<?php echo $test->id; ?>, <?php echo $value->id; ?>)">
+                                                    {{ trans('messages.save') }}</a>
+                                                </div>
+                                            </td>
+                                        </tr>
+                                    </tbody>
+                                </table>
+                                {{ Form::close() }}
+                                @endforeach
+                            </div><!-- ./ panel-body -->
+                        </div>
+                        
+                        </div>
+                        <div class="col-md-6">
+                            <div class="panel panel-info">  <!-- Patient Details -->
+                                <div class="panel-heading">
+                                    <h3 class="panel-title">{{trans("messages.patient-details")}}</h3>
+                                </div>
+                                <div class="panel-body">
+                                    <div class="container-fluid">
+                                        <div class="row">
+                                            <div class="col-md-3">
+                                                <p><strong>{{trans("messages.patient-number")}}</strong></p></div>
+                                            <div class="col-md-9">
+                                                {{$test->visit->patient->patient_number}}</div></div>
+                                        <div class="row">
+                                            <div class="col-md-3">
+                                                <p><strong>{{ Lang::choice('messages.name',1) }}</strong></p></div>
+                                            <div class="col-md-9">
+                                                {{$test->visit->patient->name}}</div></div>
+                                        <div class="row">
+                                            <div class="col-md-3">
+                                                <p><strong>{{trans("messages.age")}}</strong></p></div>
+                                            <div class="col-md-9">
+                                                {{$test->visit->patient->getAge()}}</div></div>
+                                        <div class="row">
+                                            <div class="col-md-3">
+                                                <p><strong>{{trans("messages.gender")}}</strong></p></div>
+                                            <div class="col-md-9">
+                                                {{$test->visit->patient->gender==0?trans("messages.male"):trans("messages.female")}}
+                                            </div></div>
+                                    </div>
+                                </div> <!-- ./ panel-body -->
+                            </div> <!-- ./ panel -->
+                            <div class="panel panel-info"> <!-- Specimen Details -->
+                                <div class="panel-heading">
+                                    <h3 class="panel-title">{{trans("messages.specimen-details")}}</h3>
+                                </div>
+                                <div class="panel-body">
+                                    <div class="container-fluid">
+                                        <div class="row">
+                                            <div class="col-md-4">
+                                                <p><strong>{{ Lang::choice('messages.specimen-type',1) }}</strong></p>
+                                            </div>
+                                            <div class="col-md-8">
+                                                {{$test->specimen->specimenType->name or trans('messages.pending') }}
+                                            </div>
+                                        </div>
+                                        <div class="row">
+                                            <div class="col-md-4">
+                                                <p><strong>{{trans('messages.specimen-number')}}</strong></p>
+                                            </div>
+                                            <div class="col-md-8">
+                                                {{$test->specimen->id or trans('messages.pending') }}
+                                            </div>
+                                        </div>
+                                        <div class="row">
+                                            <div class="col-md-4">
+                                                <p><strong>{{trans('messages.specimen-status')}}</strong></p>
+                                            </div>
+                                            <div class="col-md-8">
+                                                {{trans('messages.'.$test->specimen->specimenStatus->name) }}
+                                            </div>
+                                        </div>
+                                    @if($test->specimen->isRejected())
+                                        <div class="row">
+                                            <div class="col-md-4">
+                                                <p><strong>{{trans('messages.rejection-reason-title')}}</strong></p>
+                                            </div>
+                                            <div class="col-md-8">
+                                                {{$test->specimen->rejectionReason->reason or trans('messages.pending') }}
+                                            </div>
+                                        </div>
+                                        <div class="row">
+                                            <div class="col-md-4">
+                                                <p><strong>{{trans('messages.reject-explained-to')}}</strong></p>
+                                            </div>
+                                            <div class="col-md-8">
+                                                {{$test->specimen->reject_explained_to or trans('messages.pending') }}
+                                            </div>
+                                        </div>
+                                    
+                                    @if($test->specimen->isReferred())
+                                    <br>
+                                        <div class="row">
+                                            <div class="col-md-4">
+                                                <p><strong>{{trans("messages.specimen-referred-label")}}</strong></p>
+                                            </div>
+                                            <div class="col-md-8">
+                                                @if($test->specimen->referral->status == Referral::REFERRED_IN)
+                                                    {{ trans("messages.in") }}
+                                                @elseif($test->specimen->referral->status == Referral::REFERRED_OUT)
+                                                    {{ trans("messages.out") }}
+                                                
+                                            </div>
+                                        </div>
+                                        <div class="row">
+                                            <div class="col-md-4">
+                                                <p><strong>{{Lang::choice("messages.facility", 1)}}</strong></p>
+                                            </div>
+                                            <div class="col-md-8">
+                                                {{$test->specimen->referral->facility->name }}
+                                            </div>
+                                        </div>
+                                        <div class="row">
+                                            <div class="col-md-4">
+                                                <p><strong>{{trans("messages.person-involved")}}</strong></p>
+                                            </div>
+                                            <div class="col-md-8">
+                                                {{$test->specimen->referral->person }}
+                                            </div>
+                                        </div>
+                                        <div class="row">
+                                            <div class="col-md-4">
+                                                <p><strong>{{trans("messages.contacts")}}</strong></p>
+                                            </div>
+                                            <div class="col-md-8">
+                                                {{$test->specimen->referral->contacts }}
+                                            </div>
+                                        </div>
+                                        <div class="row">
+                                            <div class="col-md-4">
+                                                <p><strong>{{trans("messages.referred-by")}}</strong></p>
+                                            </div>
+                                            <div class="col-md-8">
+                                                {{ $test->specimen->referral->user->name }}
+                                            </div>
+                                        </div>
+                                    
+                                    </div>
+                                </div>
+                            </div> <!-- ./ panel -->
+                            <div class="panel panel-info">  <!-- Test Results -->
+                                <div class="panel-heading">
+                                    <h3 class="panel-title">{{trans("messages.test-details")}}</h3>
+                                </div>
+                                <div class="panel-body">
+                                    <div class="container-fluid">
+                                        <div class="display-details">
+                                            <p class="view"><strong>{{ Lang::choice('messages.test-type',1) }}</strong>
+                                                {{ $test->testType->name or trans('messages.unknown') }}</p>
+                                            <p class="view"><strong>{{trans('messages.visit-number')}}</strong>
+                                                {{$test->visit->visit_number or trans('messages.unknown') }}</p>
+                                            <p class="view"><strong>{{trans('messages.date-ordered')}}</strong>
+                                                {{ $test->isExternal()?$test->external()->request_date:$test->time_created }}</p>
+                                            <p class="view"><strong>{{trans('messages.lab-receipt-date')}}</strong>
+                                                {{$test->time_created}}</p>
+                                            <p class="view"><strong>{{trans('messages.test-status')}}</strong>
+                                                {{trans('messages.'.$test->testStatus->name)}}</p>
+                                            <p class="view-striped"><strong>{{trans('messages.physician')}}</strong>
+                                                {{$test->requested_by or trans('messages.unknown') }}</p>
+                                            <p class="view-striped"><strong>{{trans('messages.request-origin')}}</strong>
+                                                @if($test->specimen->isReferred() && $test->specimen->referral->status == Referral::REFERRED_IN)
+                                                    {{ trans("messages.in") }}
+                                                @else
+                                                    {{ $test->visit->visit_type }}
+                                                </p>
+                                            <p class="view-striped"><strong>{{trans('messages.registered-by')}}</strong>
+                                                {{$test->createdBy->name or trans('messages.unknown') }}</p>
+                                            @if($test->isCompleted())
+                                            <p class="view"><strong>{{trans('messages.tested-by')}}</strong>
+                                                {{$test->testedBy->name or trans('messages.unknown')}}</p>
+                                            
+                                            @if($test->isVerified())
+                                            <p class="view"><strong>{{trans('messages.verified-by')}}</strong>
+                                                {{$test->verifiedBy->name or trans('messages.verification-pending')}}</p>
+                                            
+                                            @if((!$test->specimen->isRejected()) && ($test->isCompleted() || $test->isVerified()))
+                                            <!-- Not Rejected and (Verified or Completed)-->
+                                            <p class="view-striped"><strong>{{trans('messages.turnaround-time')}}</strong>
+                                                {{$test->getFormattedTurnaroundTime()}}</p>
+                                            
+                                        </div>
+                                    </div>
+                                </div> <!-- ./ panel-body -->
+                            </div>  <!-- ./ panel -->
+                        </div>                    
+                    </div>
+                </div>
+            </div>
+        </div>
+@stop
\ No newline at end of file
diff --git a/resources/views/test/index.blade.php b/resources/views/test/index.blade.php
index 72a2181..1a878e6 100755
--- a/resources/views/test/index.blade.php
+++ b/resources/views/test/index.blade.php
@@ -1,448 +1,455 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-user-md"></i> {!! trans_choice('menu.test', 2) !!}</li>
-        </ul>
+    <div>
+        <ol class="breadcrumb">
+          <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+          <li class="active">{{ Lang::choice('messages.test',2) }}</li>
+        </ol>
     </div>
-</div>
-<div class="conter-wrapper">
-	<div class="row">
-		<div class="col-sm-12">
-			<div class="card">
-				<div class="card-header">
-				    <i class="fa fa-book"></i> {!! trans_choice('menu.test', 2) !!} 
-				    <span>
-					    <a class="btn btn-sm btn-belize-hole" href="javascript:void(0)"
-                                data-toggle="modal" data-target="#new-test-modal">
-							<i class="fa fa-plus-circle"></i>
-							{!! trans('action.new').' '.trans_choice('menu.test', 1) !!}
-						</a>
-						<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-							<i class="fa fa-step-backward"></i>
-							{!! trans('action.back') !!}
-						</a>				
-					</span>
-				</div>
-			  	<div class="card-block">	  		
-					@if (Session::has('message'))
-						<div class="alert alert-info">{!! Session::get('message') !!}</div>
-					
-					@if($errors->all())
-		            <div class="alert alert-danger alert-dismissible" role="alert">
-		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-		            </div>
-		            
-					<div class='col-md-12' style="padding-bottom:5px;">
-				        {!! Form::open(array('route' => array('test.index'))) !!}
-				            <div class='row'>
-					            <div class='col-md-12'>
-					                <div class='col-md-3'>
-					                    {!! Form::label('date_from', trans('terms.from').':', array('class' => 'col-sm-3 form-control-label')) !!}
-					                    <div class='col-md-9 input-group date datepicker'>
-					                        {!! Form::text('date_from', Input::get('date_from'), array('class' => 'form-control')) !!}
-					                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
-					                    </div>
-					                </div>
-					                <div class='col-md-3'>
-					                    {!! Form::label('date_to', trans('terms.to').':', array('class' => 'col-sm-2 form-control-label')) !!}
-					                    <div class='col-md-10 input-group date datepicker'>
-					                        {!! Form::text('date_to', Input::get('date_to'), array('class' => 'form-control')) !!}
-					                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
-					                    </div>
-					                </div>
-					                <div class='col-md-3'>
-					                    {!! Form::label('test_status', trans('terms.test-status').':', array('class' => 'col-sm-3 form-control-label')) !!}
-					                    <div class='col-md-9'>
-					                        {!! Form::select('test_status', $statuses, Input::get('test_status'), array('class' => 'form-control')) !!}
-					                    </div>
-					                </div>
-					                <div class='col-md-2'>
-				                        {!! Form::text('search', Input::get('search'), array('class' => 'form-control', 'placeholder' => 'Keyword')) !!}
-					                </div>
-					                <div class='col-md-1'>
-										{!! Form::button("<i class='fa fa-search'></i> ".trans('terms.search'), array('class' => 'btn btn-sm btn-primary', 'type' => 'submit')) !!}									
-					                </div>
-				                </div>
-				            </div>
-				        {!! Form::close() !!}
-				    </div>
-				 	<table class="table table-bordered table-sm search-table">
-						<thead>
-							<tr>
-								<th>{!! trans('terms.date-ordered') !!}</th>
-		                        <th>{!! trans('terms.test-id') !!}</th>
-		                        <th>{!! trans('terms.visit-no') !!}</th>
-		                        <th class="col-md-2">{!! trans('terms.name') !!}</th>
-		                        <th class="col-md-1">{!! trans('terms.specimen-id') !!}</th>
-		                        <th>{!! trans_choice('menu.test', 1) !!}</th>
-		                        <th>{!! trans('terms.visit-type') !!}</th>
-		                        <th>{!! trans('terms.test-status') !!}</th>
-								<th></th>
-							</tr>
-						</thead>
-						<tbody>
-						@foreach($tests as $test)
-							<tr @if(session()->has('active_test'))
-				                    {!! (session('active_test') == $value->id)?"class='warning'":"" !!}
-				                
-				                >
-								<td>{!! Carbon::parse($test->time_created)->toDateTimeString() !!}</td>  <!--Date Ordered-->
-		                        <td>{!! empty($test->visit->patient->external_patient_number)?$test->visit->patient->patient_number:$test->visit->patient->external_patient_number !!}</td> <!--Patient Number -->
-		                        <td>{!! empty($test->visit->visit_number)?$test->visit->id:$test->visit->visit_number !!}</td> <!--Visit Number -->
-		                        <td>{!! $test->visit->patient->name.' ('.($test->visit->patient->getGender(true)).', '.Carbon::parse($test->visit->patient->dob)->age. ')' !!}</td> <!--Patient Name -->
-		                        <td>{!! $test->getSpecimenId() !!}</td> <!--Specimen ID -->
-		                        <td>{!! $test->testType->name !!}</td> <!--Test-->
-		                        <td>{!! $test->visit->visit_type !!}</td> <!--Visit Type -->
-								<td id="test-status-{!!$test->id!!}" class='test-status'>
-		                            <!-- Test Statuses -->
-		                            <div class="container-fluid">
-		                            
-		                                <div class="row">
-
-		                                    <div class="col-md-12">
-		                                        @if($test->isNotReceived())
-		                                            @if(!$test->isPaid())
-		                                                <span class='label label-silver'>
-		                                                    {!! trans('terms.not-paid') !!}</span>
-		                                            @else
-		                                            <span class='label label-asbestos'>
-		                                                {!! trans('terms.not-received') !!}</span>
-		                                            
-		                                        @elseif($test->isPending())
-		                                            <span class='label label-pumpkin'>
-		                                                {!! trans('terms.pending') !!}</span>
-		                                        @elseif($test->isStarted())
-		                                            <span class='label label-sub-flower'>
-		                                                {!! trans('terms.started') !!}</span>
-		                                        @elseif($test->isCompleted())
-		                                            <span class='label label-nephritis'>
-		                                                {!! trans('terms.completed') !!}</span>
-		                                        @elseif($test->isVerified())
-		                                            <span class='label label-wet-asphalt'>
-		                                                {!! trans('terms.verified') !!}</span>
-		                                        
-		                                    </div>
-		    
-		                                    </div>
-		                                <div class="row">
-		                                    <div class="col-md-12">
-		                                        <!-- Specimen statuses -->
-		                                        @if($test->specimen->isNotCollected())
-		                                         @if(($test->isPaid()))
-		                                            <span class='label label-silver'>
-		                                                {!! trans('terms.specimen-not-collected') !!}</span>
-		                                            
-		                                        @elseif($test->specimen->isReferred())
-		                                            <span class='label label-asbestos'>
-		                                                {!! trans('messages.specimen-referred-label') !!}
-		                                                @if($test->specimen->referral->status == App\Models\Referral::REFERRED_IN)
-		                                                    {!! trans("messages.in") !!}
-		                                                @elseif($test->specimen->referral->status == App\Models\Referral::REFERRED_OUT)
-		                                                    {!! trans("messages.out") !!}
-		                                                
-		                                            </span>
-		                                        @elseif($test->specimen->isAccepted())
-		                                            <span class='label label-success'>
-		                                                {!! trans('terms.specimen-accepted') !!}</span>
-		                                        @elseif($test->specimen->isRejected())
-		                                            <span class='label label-danger'>
-		                                                {!! trans('terms.specimen-rejected') !!}</span>
-		                                        
-		                                    </div>
-		                                </div>
-		                            </div>
-		                        </td>
-								<!-- ACTION BUTTONS -->
-		                        <td>
-		                            <a class="btn btn-sm btn-success"
-		                                href="{!! route('test.viewDetails', $test->id) !!}"
-		                                id="view-details-{!!$test->id!!}-link" 
-		                                title="{!!trans('action.view')!!}">
-		                                <i class="fa fa-folder-open"></i>
-		                                {!! trans('action.view') !!}
-		                            </a>
-		                            <!-- /. barcode-button -->
-		                            {!! Form::open() !!}
-		                            <!-- CSRF Token -->
-					                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
-					                <!-- ./ csrf token -->
-		                            <a class="btn btn-sm btn-asbestos barcode-button" onclick="print_specimen_barcode('{!! $test->specimen->id !!}')">
-                                        <i class="fa fa-barcode"></i>
-                                        {!! trans('terms.barcode') !!}
-                                    </a>
-                                    {!! Form::close() !!}
-		                            
-		                        @if ($test->isNotReceived()) 
-		                            @if(Auth::user()->can('receive_external_test') && $test->isPaid())
-		                                <a class="btn btn-sm btn-green-sea receive-test" href="javascript:void(0)"
-		                                    data-test-id="{!!$test->id!!}" data-specimen-id="{!!$test->specimen->id!!}"
-		                                    title="{!!trans('action.receive-test')!!}">
-		                                    <i class="fa fa-cloud-download"></i>
-		                                    {!! trans('action.receive-test') !!}
-		                                </a>
-		                            
-		                        @elseif ($test->specimen->isNotCollected())
-		                            @if(Auth::user()->can('accept_test_specimen'))
-		                                <a class="btn btn-sm btn-wisteria accept-specimen" href="javascript:void(0)"
-		                                    data-test-id="{!!$test->id!!}" data-specimen-id="{!!$test->specimen->id!!}"
-		                                    title="{!!trans('action.accept-specimen')!!}"
-		                                    data-url="{!! route('test.acceptSpecimen') !!}">
-		                                    <i class="fa fa-check-circle"></i>
-		                                    {!! trans('action.accept-specimen') !!}
-		                                </a>
-		                            
-		                            @if(count($test->testType->specimenTypes) > 1 && Auth::user()->can('change_test_specimen'))
-		                                <!-- 
-		                                    If this test can be done using more than 1 specimen type,
-		                                    allow the user to change to any of the other eligible ones.
-		                                -->
-		                                <a class="btn btn-sm btn-pumpkin change-specimen" href="#change-specimen-modal"
-		                                    data-toggle="modal" data-url="{!! route('test.changeSpecimenType') !!}"
-		                                    data-test-id="{!!$test->id!!}" data-target="#change-specimen-modal"
-		                                    title="{!!trans('action.change-specimen')!!}">
-		                                    <i class="fa fa-refresh"></i>
-		                                    {!! trans('action.change-specimen') !!}
-		                                </a>
-		                            
-		                        
-		                        @if ($test->specimen->isAccepted() && !($test->isVerified()))
-		                            @if(Auth::user()->can('reject_test_specimen') && !($test->specimen->isReferred()))
-		                                <a class="btn btn-sm btn-alizarin" id="reject-{!!$test->id!!}-link"
-		                                    href="{!!route('test.reject', array($test->specimen_id))!!}"
-		                                    title="{!!trans('action.reject')!!}">
-		                                    <i class="fa fa-stop-circle"></i>
-		                                    {!! trans('action.reject') !!}
-		                                </a>
-		                            
-		                            @if ($test->isPending())
-		                                @if(Auth::user()->can('start_test'))
-		                                    <a class="btn btn-sm btn-sub-flower start-test" href="javascript:void(0)"
-		                                        data-test-id="{!!$test->id!!}" data-url="{!! route('test.start') !!}"
-		                                        title="{!!trans('action.start-test')!!}">
-		                                        <i class="fa fa-play-circle"></i>
-		                                        {!! trans('action.start-test') !!}
-		                                    </a>
-		                                
-		                                @if(Auth::user()->can('refer_specimens') && !($test->isExternal()) && !($test->specimen->isReferred()))
-		                                    <a class="btn btn-sm btn-silver" href="{!! route('test.refer', array($test->specimen_id)) !!}">
-		                                        <i class="fa fa-send"></i>
-		                                        {!! trans('action.refer-sample') !!}
-		                                    </a>
-		                                
-		                            @elseif ($test->isStarted())
-		                                @if(Auth::user()->can('enter_test_results'))
-		                                    <a class="btn btn-sm btn-peter-river" id="enter-results-{!!$test->id!!}-link"
-		                                        href="{!! route('test.enterResults', array($test->id)) !!}"
-		                                        title="{!!trans('action.enter-results')!!}">
-		                                        <i class="fa fa-pencil-square"></i>
-		                                        {!! trans('action.enter-results') !!}
-		                                    </a>
-		                                
-		                            @elseif ($test->isCompleted())
-		                                @if(Auth::user()->can('edit_test_results'))
-		                                    <a class="btn btn-sm btn-peter-river" id="edit-{!!$test->id!!}-link"
-		                                        href="{!! route('test.edit', array($test->id)) !!}"
-		                                        title="{!!trans('action.edit-results')!!}">
-		                                        <i class="fa fa-file-text"></i>
-		                                        {!! trans('action.edit-results') !!}
-		                                    </a>
-		                                
-		                                @if(Auth::user()->can('verify_test_results') && Auth::user()->id != $test->tested_by)
-		                                    <a class="btn btn-sm btn-midnight-blue" id="verify-{!!$test->id!!}-link"
-		                                        href="{!! route('test.viewDetails', array($test->id)) !!}"
-		                                        title="{!!trans('action.verify')!!}">
-		                                        <i class="fa fa-check-square"></i>
-		                                        {!! trans('action.verify') !!}
-		                                    </a>
-		                                
-		                            
-		                        
-		                        </td>
-							</tr>
-						@endforeach
-						</tbody>
-					</table>
-			  	</div>
-			</div>
-		</div>
-	</div>
-	<div id="count" style='display:none;'>0</div>
-	<div id ="barcodeList" style="display:none;"></div>
-	<!-- jQuery barcode script -->
-	<script type="text/javascript" src="{{ asset('js/barcode.js') }} "></script>
-	{!! session(['SOURCE_URL' => URL::full()]) !!}
-</div>
+    @if (Session::has('message'))
+        @if(isset(Session::get('message')->danger))
+            <div class="alert alert-danger">{{ trans(Session::get('message')->danger) }}</div>
+        @elseif(isset(Session::get('message')->info))
+            <div class="alert alert-info">{{ trans(Session::get('message')->info) }}</div>
+        
+    
 
-<!-- MODALS -->
-<div class="modal fade" id="new-test-modal">
-  <div class="modal-dialog">
-    <div class="modal-content">
-    {!! Form::open(array('route' => 'test.create')) !!}
-      <input type="hidden" id="patient_id" name="patient_id" value="0" />
-      <div class="modal-header">
-        <button type="button" class="close" data-dismiss="modal">
-            <span aria-hidden="true">&times;</span>
-            <span class="sr-only">{!!trans('messages.close')!!}</span>
-        </button>
-        <h4 class="modal-title">{!! trans('action.new').' '.trans_choice('menu.test', 1) !!}</h4>
-      </div>
-      <div class="modal-body">
-        <p>{!! trans('terms.select-patient') !!}</p>
-        <div class="row">
-          <div class="col-lg-12">
-            <div class="input-group">
-              <input type="text" class="form-control search-text" 
-                placeholder="{!! trans('terms.keyword') !!}">
-	              	<span class="input-group-btn">
-	                	<button class="btn btn-sm btn-wet-asphalt search-patient" type="button">{!! trans('action.find') !!}</button>
-	              	</span>
-            </div><!-- /input-group -->
-            <div class="patient-search-result form-group">
-                <table class="table table-condensed table-striped table-bordered table-hover hide">
-                  <thead>
-                    <th> </th>
-                    <th>{!! trans('action.patient-id') !!}</th>
-                    <th>{!! trans('terms.name') !!}</th>
-                  </thead>
-                  <tbody>
-                  </tbody>
-                </table>
+    <div class='container-fluid'>
+        {{ Form::open(array('route' => array('test.index'))) }}
+            <div class='row'>
+                <div class='col-md-3'>
+                        {{ Form::label('search', trans('messages.search'), array('class' => 'sr-only')) }}
+                        {{ Form::text('search', Input::get('search'),
+                            array('class' => 'form-control', 'placeholder' => 'Search')) }}
+                </div>
+                <div class='col-md-4'>
+                    <div class='col-md-3'>
+                        {{ Form::label('test_status', trans('messages.test-status')) }}
+                    </div>
+                    <div class='col-md-6'>
+                        {{ Form::select('test_status', $testStatus,
+                            Input::get('test_status'), array('class' => 'form-control')) }}
+                    </div>
+                </div>
+                <div class='col-md-2'>
+                    <div class='col-md-3'>
+                        {{ Form::label('date_from', trans('messages.from')) }}
+                    </div>
+                    <div class='col-md-9'>
+                        {{ Form::text('date_from', Input::get('date_from'), 
+                            array('class' => 'form-control standard-datepicker')) }}
+                    </div>
+                </div>
+                <div class='col-md-2'>
+                    <div class='col-md-3'>
+                        {{ Form::label('date_to', trans('messages.to')) }}
+                    </div>
+                    <div class='col-md-9'>
+                        {{ Form::text('date_to', Input::get('date_to'), 
+                            array('class' => 'form-control standard-datepicker')) }}
+                    </div>
+                </div>
+                <div class='col-md-1'>
+                        {{ Form::submit(trans('messages.search'), array('class'=>'btn btn-primary')) }}
+                </div>
             </div>
-          </div><!-- /.col-lg-12 -->
-        </div><!-- /.row -->          </div>
-      <div class="modal-footer">
-        <button type="button" class="btn btn-sm btn-silver" data-dismiss="modal">
-            <i class="fa fa-times-circle"></i> {!! trans('action.close') !!}
-        </button>
-        <button type="button" class="btn btn-sm btn-peter-river next" onclick="submit();" disabled>
-            <i class="fa fa-chevron-circle-right"></i> {!! trans('action.next') !!}
-        </button>
-      </div>
-    {!! Form::close() !!}
-    </div><!-- /.modal-content -->
-  </div><!-- /.modal-dialog -->
-</div><!-- /.modal -->
+        {{ Form::close() }}
+    </div>
 
-<div class="modal fade" id="change-specimen-modal">
-  <div class="modal-dialog">
-    <div class="modal-content">
-    {!! Form::open(array('route' => 'test.updateSpecimenType')) !!}
-    	<!-- CSRF Token -->
-        <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-        <!-- ./ csrf token -->
-      	<div class="modal-header">
-        	<button type="button" class="close" data-dismiss="modal">
-            	<span aria-hidden="true">&times;</span>
-            	<span class="sr-only">{!!trans('messages.close')!!}</span>
-        	</button>
-        	<h4 class="modal-title">
-            <span class="glyphicon glyphicon-transfer"></span>
-            {!!trans('messages.change-specimen-title')!!}</h4>
-      	</div>
-      	<div class="modal-body">
-      	</div>
-      	<div class="modal-footer">
-        	{!! Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'),
-            array('class' => 'btn btn-primary', 'data-dismiss' => 'modal', 'onclick' => 'submit()')) !!}
-        	<button type="button" class="btn btn-default" data-dismiss="modal">
-            	{!!trans('messages.close')!!}</button>
-      	</div>
-    	{!! Form::close() !!}
-    	</div><!-- /.modal-content -->
-  	</div><!-- /.modal-dialog -->
-</div><!-- /.modal /#change-specimen-modal-->
+    <br>
 
-<!-- OTHER UI COMPONENTS -->
-<div class="hidden pending-test-not-collected-specimen">
-    <div class="container-fluid">
-        <div class="row">
-            <div class="col-md-12">
-                <span class='label label-info'>
-                    {!!trans('messages.pending')!!}</span>
+    <div class="panel panel-primary tests-log">
+        <div class="panel-heading ">
+            <div class="container-fluid">
+                <div class="row less-gutter">
+                    <div class="col-md-11">
+                        <span class="glyphicon glyphicon-filter"></span>{{trans('messages.list-tests')}}
+                        @if(Auth::user()->can('request_test'))
+                        <div class="panel-btn">
+                            <a class="btn btn-sm btn-info" href="javascript:void(0)"
+                                data-toggle="modal" data-target="#new-test-modal">
+                                <span class="glyphicon glyphicon-plus-sign"></span>
+                                {{trans('messages.new-test')}}
+                            </a>
+                        </div>
+                        
+                    </div>
+                    <div class="col-md-1">
+                        <a class="btn btn-sm btn-primary pull-right" href="#" onclick="window.history.back();return false;"
+                            alt="{{trans('messages.back')}}" title="{{trans('messages.back')}}">
+                            <span class="glyphicon glyphicon-backward"></span></a>
+                    </div>
+                </div>
             </div>
         </div>
-        <div class="row">
-            <div class="col-md-12">
-                <span class='label label-default'>
-                    {!!trans('messages.specimen-not-collected-label')!!}</span>                
-            </div>
+        <div class="panel-body">
+            <table class="table table-striped table-hover table-condensed">
+                <thead>
+                    <tr>
+                        <th>{{trans('messages.date-ordered')}}</th>
+                        <th>{{trans('messages.patient-number')}}</th>
+                        <th>{{trans('messages.visit-number')}}</th>
+                        <th class="col-md-2">{{trans('messages.patient-name')}}</th>
+                        <th class="col-md-1">{{trans('messages.specimen-id')}}</th>
+                        <th>{{ Lang::choice('messages.test',1) }}</th>
+                        <th>{{trans('messages.visit-type')}}</th>
+                        <th>{{trans('messages.test-status')}}</th>
+                        <th class="col-md-3">{{trans('messages.test-status')}}</th>
+                    </tr>
+                </thead>
+                <tbody>
+                @foreach($testSet as $key => $test)
+                    <tr 
+                        @if(Session::has('activeTest'))
+                            {{ in_array($test->id, Session::get('activeTest'))?"class='info'":""}}
+                        
+                        >
+                        <td>{{ date('d-m-Y H:i', strtotime($test->time_created));}}</td>  <!--Date Ordered-->
+                        <td>{{ empty($test->visit->patient->external_patient_number)?
+                                $test->visit->patient->patient_number:
+                                $test->visit->patient->external_patient_number
+                            }}</td> <!--Patient Number -->
+                        <td>{{ empty($test->visit->visit_number)?
+                                $test->visit->id:
+                                $test->visit->visit_number
+                            }}</td> <!--Visit Number -->
+                        <td>{{ $test->visit->patient->name.' ('.($test->visit->patient->getGender(true)).',
+                            '.$test->visit->patient->getAge('Y'). ')'}}</td> <!--Patient Name -->
+                        <td>{{ $test->getSpecimenId() }}</td> <!--Specimen ID -->
+                        <td>{{ $test->testType->name }}</td> <!--Test-->
+                        <td>{{ $test->visit->visit_type }}</td> <!--Visit Type -->
+                        <td id="test-status-{{$test->id}}" class='test-status'>
+                            <!-- Test Statuses -->
+                            <div class="container-fluid">
+                            
+                                <div class="row">
+
+                                    <div class="col-md-12">
+                                        @if($test->isNotReceived())
+                                            @if(!$test->isPaid())
+                                                <span class='label label-default'>
+                                                    {{trans('messages.not-paid')}}</span>
+                                            @else
+                                            <span class='label label-default'>
+                                                {{trans('messages.not-received')}}</span>
+                                            
+                                        @elseif($test->isPending())
+                                            <span class='label label-info'>
+                                                {{trans('messages.pending')}}</span>
+                                        @elseif($test->isStarted())
+                                            <span class='label label-warning'>
+                                                {{trans('messages.started')}}</span>
+                                        @elseif($test->isCompleted())
+                                            <span class='label label-primary'>
+                                                {{trans('messages.completed')}}</span>
+                                        @elseif($test->isVerified())
+                                            <span class='label label-success'>
+                                                {{trans('messages.verified')}}</span>
+                                        
+                                    </div>
+    
+                                    </div>
+                                <div class="row">
+                                    <div class="col-md-12">
+                                        <!-- Specimen statuses -->
+                                        @if($test->specimen->isNotCollected())
+                                         @if(($test->isPaid()))
+                                            <span class='label label-default'>
+                                                {{trans('messages.specimen-not-collected-label')}}</span>
+                                            
+                                        @elseif($test->specimen->isReferred())
+                                            <span class='label label-primary'>
+                                                {{trans('messages.specimen-referred-label') }}
+                                                @if($test->specimen->referral->status == Referral::REFERRED_IN)
+                                                    {{ trans("messages.in") }}
+                                                @elseif($test->specimen->referral->status == Referral::REFERRED_OUT)
+                                                    {{ trans("messages.out") }}
+                                                
+                                            </span>
+                                        @elseif($test->specimen->isAccepted())
+                                            <span class='label label-success'>
+                                                {{trans('messages.specimen-accepted-label')}}</span>
+                                        @elseif($test->specimen->isRejected())
+                                            <span class='label label-danger'>
+                                                {{trans('messages.specimen-rejected-label')}}</span>
+                                        
+                                        </div></div></div>
+                        </td>
+                        <!-- ACTION BUTTONS -->
+                        <td>
+                            <a class="btn btn-sm btn-success"
+                                href="{{ URL::route('test.viewDetails', $test->id) }}"
+                                id="view-details-{{$test->id}}-link" 
+                                title="{{trans('messages.view-details-title')}}">
+                                <span class="glyphicon glyphicon-eye-open"></span>
+                                {{trans('messages.view-details')}}
+                            </a>
+                            
+                        @if ($test->isNotReceived()) 
+                            @if(Auth::user()->can('receive_external_test') && $test->isPaid())
+                                <a class="btn btn-sm btn-default receive-test" href="javascript:void(0)"
+                                    data-test-id="{{$test->id}}" data-specimen-id="{{$test->specimen->id}}"
+                                    title="{{trans('messages.receive-test-title')}}">
+                                    <span class="glyphicon glyphicon-thumbs-up"></span>
+                                    {{trans('messages.receive-test')}}
+                                </a>
+                            
+                        @elseif ($test->specimen->isNotCollected())
+                            @if(Auth::user()->can('accept_test_specimen'))
+                                <a class="btn btn-sm btn-info accept-specimen" href="javascript:void(0)"
+                                    data-test-id="{{$test->id}}" data-specimen-id="{{$test->specimen->id}}"
+                                    title="{{trans('messages.accept-specimen-title')}}"
+                                    data-url="{{ URL::route('test.acceptSpecimen') }}">
+                                    <span class="glyphicon glyphicon-thumbs-up"></span>
+                                    {{trans('messages.accept-specimen')}}
+                                </a>
+                            
+                            @if(count($test->testType->specimenTypes) > 1 && Auth::user()->can('change_test_specimen'))
+                                <!-- 
+                                    If this test can be done using more than 1 specimen type,
+                                    allow the user to change to any of the other eligible ones.
+                                -->
+                                <a class="btn btn-sm btn-danger change-specimen" href="#change-specimen-modal"
+                                    data-toggle="modal" data-url="{{ URL::route('test.changeSpecimenType') }}"
+                                    data-test-id="{{$test->id}}" data-target="#change-specimen-modal"
+                                    title="{{trans('messages.change-specimen-title')}}">
+                                    <span class="glyphicon glyphicon-transfer"></span>
+                                    {{trans('messages.change-specimen')}}
+                                </a>
+                            
+                        
+                        @if ($test->specimen->isAccepted() && !($test->isVerified()))
+                            @if(Auth::user()->can('reject_test_specimen') && !($test->specimen->isReferred()))
+                                <a class="btn btn-sm btn-danger" id="reject-{{$test->id}}-link"
+                                    href="{{URL::route('test.reject', array($test->specimen_id))}}"
+                                    title="{{trans('messages.reject-title')}}">
+                                    <span class="glyphicon glyphicon-thumbs-down"></span>
+                                    {{trans('messages.reject')}}
+                                </a>
+                                <a class="btn btn-sm btn-midnight-blue barcode-button" onclick="print_barcode({{ "'".$test->specimen->id."'".', '."'".$barcode->encoding_format."'".', '."'".$barcode->barcode_width."'".', '."'".$barcode->barcode_height."'".', '."'".$barcode->text_size."'" }})" title="{{trans('messages.barcode')}}">
+                                    <span class="glyphicon glyphicon-barcode"></span>
+                                    {{trans('messages.barcode')}}
+                                </a>
+                            
+                            @if ($test->isPending())
+                                @if(Auth::user()->can('start_test'))
+                                    <a class="btn btn-sm btn-warning start-test" href="javascript:void(0)"
+                                        data-test-id="{{$test->id}}" data-url="{{ URL::route('test.start') }}"
+                                        title="{{trans('messages.start-test-title')}}">
+                                        <span class="glyphicon glyphicon-play"></span>
+                                        {{trans('messages.start-test')}}
+                                    </a>
+                                
+                                @if(Auth::user()->can('refer_specimens') && !($test->isExternal()) && !($test->specimen->isReferred()))
+                                    <a class="btn btn-sm btn-info" href="{{ URL::route('test.refer', array($test->specimen_id)) }}">
+                                        <span class="glyphicon glyphicon-edit"></span>
+                                        {{trans('messages.refer-sample')}}
+                                    </a>
+                                
+                            @elseif ($test->isStarted())
+                                @if(Auth::user()->can('enter_test_results'))
+                                    <a class="btn btn-sm btn-info" id="enter-results-{{$test->id}}-link"
+                                        href="{{ URL::route('test.enterResults', array($test->id)) }}"
+                                        title="{{trans('messages.enter-results-title')}}">
+                                        <span class="glyphicon glyphicon-pencil"></span>
+                                        {{trans('messages.enter-results')}}
+                                    </a>
+                                
+                            @elseif ($test->isCompleted())
+                                @if(Auth::user()->can('edit_test_results'))
+                                    <a class="btn btn-sm btn-info" id="edit-{{$test->id}}-link"
+                                        href="{{ URL::route('test.edit', array($test->id)) }}"
+                                        title="{{trans('messages.edit-test-results')}}">
+                                        <span class="glyphicon glyphicon-edit"></span>
+                                        {{trans('messages.edit')}}
+                                    </a>
+                                
+                                @if(Auth::user()->can('verify_test_results') && Auth::user()->id != $test->tested_by)
+                                    <a class="btn btn-sm btn-success" id="verify-{{$test->id}}-link"
+                                        href="{{ URL::route('test.viewDetails', array($test->id)) }}"
+                                        title="{{trans('messages.verify-title')}}">
+                                        <span class="glyphicon glyphicon-thumbs-up"></span>
+                                        {{trans('messages.verify')}}
+                                    </a>
+                                
+                            
+                        
+                        </td>
+                    </tr>
+                @endforeach
+                </tbody>
+            </table>
+            
+            {{ $testSet->links() }}
+        {{ Session::put('SOURCE_URL', URL::full()) }}
+        {{ Session::put('TESTS_FILTER_INPUT', Input::except('_token')); }}
+        
         </div>
     </div>
-</div> <!-- /. pending-test-not-collected-specimen -->
 
-<div class="hidden pending-test-accepted-specimen">
-    <div class="container-fluid">
-        <div class="row">
-            <div class="col-md-12">
-                <span class='label label-info'>
-                    {!!trans('messages.pending')!!}</span>
+    <!-- MODALS -->
+    <div class="modal fade" id="new-test-modal">
+      <div class="modal-dialog">
+        <div class="modal-content">
+        {{ Form::open(array('route' => 'test.create')) }}
+          <input type="hidden" id="patient_id" name="patient_id" value="0" />
+          <div class="modal-header">
+            <button type="button" class="close" data-dismiss="modal">
+                <span aria-hidden="true">&times;</span>
+                <span class="sr-only">{{trans('messages.close')}}</span>
+            </button>
+            <h4 class="modal-title">{{trans('messages.create-new-test')}}</h4>
+          </div>
+          <div class="modal-body">
+            <h4>{{ trans('messages.first-select-patient') }}</h4>
+            <div class="row">
+              <div class="col-lg-12">
+                <div class="input-group">
+                  <input type="text" class="form-control search-text" 
+                    placeholder="{{ trans('messages.search-patient-placeholder') }}">
+                  <span class="input-group-btn">
+                    <button class="btn btn-default search-patient" type="button">
+                        {{ trans('messages.patient-search-button') }}</button>
+                  </span>
+                </div><!-- /input-group -->
+                <div class="patient-search-result form-group">
+                    <table class="table table-condensed table-striped table-bordered table-hover hide">
+                      <thead>
+                        <th> </th>
+                        <th>{{ trans('messages.patient-id') }}</th>
+                        <th>{{ Lang::choice('messages.name',2) }}</th>
+                      </thead>
+                      <tbody>
+                      </tbody>
+                    </table>
+                </div>
+              </div><!-- /.col-lg-12 -->
+            </div><!-- /.row -->          </div>
+          <div class="modal-footer">
+            <button type="button" class="btn btn-default" data-dismiss="modal">
+                {{trans('messages.close')}}</button>
+            <button type="button" class="btn btn-primary next" onclick="submit();" disabled>
+                {{trans('messages.next')}}</button>
+          </div>
+        {{ Form::close() }}
+        </div><!-- /.modal-content -->
+      </div><!-- /.modal-dialog -->
+    </div><!-- /.modal -->
+
+    <div class="modal fade" id="change-specimen-modal">
+      <div class="modal-dialog">
+        <div class="modal-content">
+        {{ Form::open(array('route' => 'test.updateSpecimenType')) }}
+          <div class="modal-header">
+            <button type="button" class="close" data-dismiss="modal">
+                <span aria-hidden="true">&times;</span>
+                <span class="sr-only">{{trans('messages.close')}}</span>
+            </button>
+            <h4 class="modal-title">
+                <span class="glyphicon glyphicon-transfer"></span>
+                {{trans('messages.change-specimen-title')}}</h4>
+          </div>
+          <div class="modal-body">
+          </div>
+          <div class="modal-footer">
+            {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'),
+                array('class' => 'btn btn-primary', 'data-dismiss' => 'modal', 'onclick' => 'submit()')) }}
+            <button type="button" class="btn btn-default" data-dismiss="modal">
+                {{trans('messages.close')}}</button>
+          </div>
+        {{ Form::close() }}
+        </div><!-- /.modal-content -->
+      </div><!-- /.modal-dialog -->
+    </div><!-- /.modal /#change-specimen-modal-->
+
+    <!-- OTHER UI COMPONENTS -->
+    <div class="hidden pending-test-not-collected-specimen">
+        <div class="container-fluid">
+            <div class="row">
+                <div class="col-md-12">
+                    <span class='label label-info'>
+                        {{trans('messages.pending')}}</span>
+                </div>
             </div>
-        </div>
-        <div class="row">
-            <div class="col-md-12">
-                <span class='label label-success'>
-                    {!!trans('messages.specimen-accepted-label')!!}</span>
+            <div class="row">
+                <div class="col-md-12">
+                    <span class='label label-default'>
+                        {{trans('messages.specimen-not-collected-label')}}</span>                
+                </div>
             </div>
         </div>
-    </div>
-</div> <!-- /. pending-test-accepted-specimen -->
+    </div> <!-- /. pending-test-not-collected-specimen -->
 
-<div class="hidden started-test-accepted-specimen">
-    <div class="container-fluid">
-        <div class="row">
-            <div class="col-md-12">
-                <span class='label label-warning'>
-                    {!!trans('messages.started')!!}</span>
+    <div class="hidden pending-test-accepted-specimen">
+        <div class="container-fluid">
+            <div class="row">
+                <div class="col-md-12">
+                    <span class='label label-info'>
+                        {{trans('messages.pending')}}</span>
+                </div>
+            </div>
+            <div class="row">
+                <div class="col-md-12">
+                    <span class='label label-success'>
+                        {{trans('messages.specimen-accepted-label')}}</span>
+                </div>
             </div>
         </div>
-        <div class="row">
-            <div class="col-md-12">
-                <span class='label label-success'>
-                    {!!trans('messages.specimen-accepted-label')!!}</span>
+    </div> <!-- /. pending-test-accepted-specimen -->
+
+    <div class="hidden started-test-accepted-specimen">
+        <div class="container-fluid">
+            <div class="row">
+                <div class="col-md-12">
+                    <span class='label label-warning'>
+                        {{trans('messages.started')}}</span>
+                </div>
+            </div>
+            <div class="row">
+                <div class="col-md-12">
+                    <span class='label label-success'>
+                        {{trans('messages.specimen-accepted-label')}}</span>
+                </div>
             </div>
         </div>
-    </div>
-</div> <!-- /. started-test-accepted-specimen -->
+    </div> <!-- /. started-test-accepted-specimen -->
 
-<div class="hidden accept-button">
-    <a class="btn btn-sm btn-info accept-specimen" href="javascript:void(0)"
-        title="{!!trans('messages.accept-specimen-title')!!}"
-        data-url="{!! route('test.acceptSpecimen') !!}">
-        <span class="glyphicon glyphicon-thumbs-up"></span>
-        {!!trans('messages.accept-specimen')!!}
-    </a>
-</div> <!-- /. accept-button -->
+    <div class="hidden accept-button">
+        <a class="btn btn-sm btn-info accept-specimen" href="javascript:void(0)"
+            title="{{trans('messages.accept-specimen-title')}}"
+            data-url="{{ URL::route('test.acceptSpecimen') }}">
+            <span class="glyphicon glyphicon-thumbs-up"></span>
+            {{trans('messages.accept-specimen')}}
+        </a>
+    </div> <!-- /. accept-button -->
 
-<div class="hidden reject-start-buttons">
-    <a class="btn btn-sm btn-danger reject-specimen" href="#" title="{!!trans('messages.reject-title')!!}">
-        <span class="glyphicon glyphicon-thumbs-down"></span>
-        {!!trans('messages.reject')!!}</a>
-    <a class="btn btn-sm btn-warning start-test" href="javascript:void(0)"
-        data-url="{!! route('test.start') !!}" title="{!!trans('messages.start-test-title')!!}">
-        <span class="glyphicon glyphicon-play"></span>
-        {!!trans('messages.start-test')!!}</a>
-</div> <!-- /. reject-start-buttons -->
+    <div class="hidden reject-start-buttons">
+        <a class="btn btn-sm btn-danger reject-specimen" href="#" title="{{trans('messages.reject-title')}}">
+            <span class="glyphicon glyphicon-thumbs-down"></span>
+            {{trans('messages.reject')}}</a>
+        <a class="btn btn-sm btn-warning start-test" href="javascript:void(0)"
+            data-url="{{ URL::route('test.start') }}" title="{{trans('messages.start-test-title')}}">
+            <span class="glyphicon glyphicon-play"></span>
+            {{trans('messages.start-test')}}</a>
+    </div> <!-- /. reject-start-buttons -->
 
-<div class="hidden enter-result-buttons">
-    <a class="btn btn-sm btn-info enter-result">
-        <span class="glyphicon glyphicon-pencil"></span>
-        {!!trans('messages.enter-results')!!}</a>
-</div> <!-- /. enter-result-buttons -->
+    <div class="hidden enter-result-buttons">
+        <a class="btn btn-sm btn-info enter-result">
+            <span class="glyphicon glyphicon-pencil"></span>
+            {{trans('messages.enter-results')}}</a>
+    </div> <!-- /. enter-result-buttons -->
 
-<div class="hidden start-refer-button">
-    <a class="btn btn-sm btn-info refer-button" href="#">
-        <span class="glyphicon glyphicon-edit"></span>
-        {!!trans('messages.refer-sample')!!}
-    </a>
-</div> <!-- /. referral-button -->
-<div id="count" style='display:none;'>0</div>
-<div id="specimenBarcodeDiv" style="display:none;"></div>
+    <div class="hidden start-refer-button">
+        <a class="btn btn-sm btn-info refer-button" href="#">
+            <span class="glyphicon glyphicon-edit"></span>
+            {{trans('messages.refer-sample')}}
+        </a>
+    </div> <!-- /. referral-button -->
+    <!-- Barcode begins -->
+    
+    <div id="count" style='display:none;'>0</div>
+    <div id ="barcodeList" style="display:none;"></div>
 
-<!-- jQuery barcode script -->
-<script type="text/javascript" src="{{ asset('js/barcode.js') }} "></script>
-@endsection
\ No newline at end of file
+    <!-- jQuery barcode script -->
+    <script type="text/javascript" src="{{ asset('js/barcode.js') }} "></script>
+@stop
\ No newline at end of file
diff --git a/resources/views/test/refer.blade.php b/resources/views/test/refer.blade.php
index e3c9fc3..bb4cc5c 100755
--- a/resources/views/test/refer.blade.php
+++ b/resources/views/test/refer.blade.php
@@ -1,82 +1,74 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li><a href="{!! url('test') !!}"><i class="fa fa-user-md"></i> {!! trans_choice('menu.test', 2) !!}</a></li>
-            <li class="active">{!! trans('terms.specimen-referral') !!}</li>
-        </ul>
+    <div>
+        <ol class="breadcrumb">
+          <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+          <li><a href="{{ URL::route('test.index') }}">{{ Lang::choice('messages.test', 2) }}</a></li>
+          <li class="active">{{trans('messages.referrals')}}</li>
+        </ol>
     </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-send"></i> {!! $specimen->test->visit->patient->name.' - '.$specimen->specimenType->name !!}
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
-			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
+    <div class="panel panel-primary">
+        <div class="panel-heading ">
+            <div class="container-fluid">
+                <div class="row less-gutter">
+                    <div class="col-md-11">
+                        <span class="glyphicon glyphicon-filter"></span> {{trans('messages.referrals')}}
+                    </div>
+                    <div class="col-md-1">
+                        <a class="btn btn-sm btn-primary pull-right" href="#" onclick="window.history.back();return false;"
+                            alt="{{trans('messages.back')}}" title="{{trans('messages.back')}}">
+                            <span class="glyphicon glyphicon-backward"></span></a>
+                    </div>
+                </div>
             </div>
-            
-            <div class="row">
-	            <div class="col-md-8">
-				{!! Form::open(array('route' => 'test.referAction')) !!}
-					<!-- CSRF Token -->
-	                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-	                <!-- ./ csrf token -->
-					{!! Form::hidden('specimen_id', $specimen->id) !!}
-	                <div class="form-group row">
-						{!! Form::label('refer', trans('action.refer-sample'), array('class' => 'col-sm-3 form-control-label')) !!}
-						<div class="col-sm-9">
-							<label class="radio-inline">{!! Form::radio('referral-status', 0, true) !!}{!! trans('terms.in') !!}</label>
-                        	<label class="radio-inline">{!! Form::radio("referral-status", 1, false) !!}{!! trans('terms.out') !!}</label>
-						</div>
-					</div>
-					<div class="form-group row">
-						{!! Form::label('facility', trans_choice("menu.facility", 1), array('class' => 'col-sm-3 form-control-label')) !!}
-						<div class="col-sm-9">
-							{!! Form::select('facility_id', $facilities, old('facility_id'), array('class' => 'form-control c-select')) !!}
-						</div>
-					</div>
-					<div class="form-group row">
-						{!! Form::label('person', trans("terms.person"), array('class' => 'col-sm-3 form-control-label')) !!}
-						<div class="col-sm-9">
-							{!!Form::text('person', old('person'), array('class' => 'form-control'))!!}
-						</div>
-					</div>
-					<div class="form-group row">
-						{!! Form::label('contacts', trans("terms.contacts"), array('class' => 'col-sm-3 form-control-label')) !!}
-						<div class="col-sm-9">
-							{!!Form::textarea('contacts', old('contacts'), array('class' => 'form-control', 'rows' => '2'))!!}
-						</div>
-					</div>
-					<div class="form-group row" align="right">
-						{!! Form::button("<i class='fa fa-plus-circle'></i> ".trans('action.save'), 
-							array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-						<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
-					</div>
-				{!! Form::close() !!}
-				</div>
-				<div class="col-md-4">
-					<ul class="list-group">
-						<li class="list-group-item"><strong>{!! trans_choice('menu.specimen-type', 1).': '.$specimen->specimenType->name !!}</strong></li>
-						<li class="list-group-item"><h6>{!! trans("terms.specimen-id") !!}<small> {!! $specimen->id !!}</small></h6></li>
-						<li class="list-group-item"><h6>{!! trans_choice('menu.test-type', 1) !!}<small> {!! $specimen->test->testType->name !!}</small></h6></li>
-					</ul>
-				</div>
-			</div>
-	  	</div>
-	</div>
-</div>
-@endsection	
\ No newline at end of file
+        </div>
+        <div class="panel-body">
+        <!-- if there are creation errors, they will show here -->
+        @if($errors->all())
+            <div class="alert alert-danger">
+                {{ HTML::ul($errors->all()) }}
+            </div>
+        
+        {{ Form::open(array('route' => 'test.referAction')) }}
+            {{ Form::hidden('specimen_id', $specimen->id) }}
+            <div class="panel-body">
+                <div class="display-details">
+                    <p><strong>{{trans('messages.specimen-type-title')}}</strong>
+                        {{$specimen->specimenType->name}}</p>
+                    <p>
+                    <p><strong>{{ Lang::choice('messages.test-type',1) }}</strong>
+                        {{$specimen->test->testType->name}}</p>
+                    </p>
+                </div>
+                <br>
+                
+                    {{ Form::label('refer', trans('messages.refer')) }}
+                    <div>{{ Form::radio('referral-status', '0', true) }}<span class='input-tag'>
+                        {{trans('messages.in')}}</span></div>
+                    <div>{{ Form::radio('referral-status', '1', false) }}<span class='input-tag'>
+                        {{trans('messages.out')}}</span></div>
+                </div>
+                
+                    {{ Form::label('facility', Lang::choice("messages.facility",1)) }}
+                    {{ Form::select('facility_id', array(0 => '')+$facilities->lists('name', 'id'), Input::old('facility_id'),
+                        array('class' => 'form-control')) }}
+                </div>
+                
+                    {{ Form::label('person', trans("messages.person")) }}
+                    {{Form::text('person', Input::old('person'),
+                        array('class' => 'form-control'))}}
+                </div>
+                
+                    {{ Form::label('contacts', trans("messages.contacts")) }}
+                    {{Form::textarea('contacts', Input::old('contacts'),
+                        array('class' => 'form-control'))}}
+                </div>
+                <div class="form-group actions-row">
+                    {{ Form::button("<span class='glyphicon glyphicon-thumbs-up'></span> ".trans('messages.refer'),
+                        ['class' => 'btn btn-danger', 'onclick' => 'submit()']) }}
+                </div>
+            </div>
+        {{ Form::close() }}
+        </div>
+    </div>
+@stop
\ No newline at end of file
diff --git a/resources/views/test/reject.blade.php b/resources/views/test/reject.blade.php
index 5d3cc42..b48d761 100755
--- a/resources/views/test/reject.blade.php
+++ b/resources/views/test/reject.blade.php
@@ -1,69 +1,63 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li><a href="{!! url('test') !!}"><i class="fa fa-user-md"></i> {!! trans_choice('menu.test', 2) !!}</a></li>
-            <li class="active">{!! trans('menu.specimen-rejection') !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-stop-cirle"></i> {!! $specimen->test->visit->patient->name.' - '.$specimen->specimenType->name !!}
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
-			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
+	<div>
+		<ol class="breadcrumb">
+		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+		  <li><a href="{{ URL::route('test.index') }}">{{ Lang::choice('messages.test',2) }}</a></li>
+		  <li class="active">{{trans('messages.reject-title')}}</li>
+		</ol>
+	</div>
+	<div class="panel panel-primary">
+		<div class="panel-heading ">
+            <div class="container-fluid">
+                <div class="row less-gutter">
+                    <div class="col-md-11">
+						<span class="glyphicon glyphicon-filter"></span>{{trans('messages.reject-title')}}
+                    </div>
+                    <div class="col-md-1">
+                        <a class="btn btn-sm btn-primary pull-right" href="#" onclick="window.history.back();return false;"
+                            alt="{{trans('messages.back')}}" title="{{trans('messages.back')}}">
+                            <span class="glyphicon glyphicon-backward"></span></a>
+                    </div>
+                </div>
             </div>
-            
-            <div class="row">
-	            <div class="col-md-8">
-				{!! Form::open(array('route' => 'test.rejectAction')) !!}
-					<!-- CSRF Token -->
-	                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-	                <!-- ./ csrf token -->
-					{!! Form::hidden('specimen_id', $specimen->id) !!}
-	                <div class="form-group row">
-						{!! Form::label('rejectionReason', trans('terms.reject-reason'), array('class' => 'col-sm-3 form-control-label')) !!}
-						<div class="col-sm-9">
-							{!! Form::select('rejectionReason', $reasons, old('rejectionReason'), array('class' => 'form-control c-select')) !!}
-						</div>
-					</div>
-					<div class="form-group row">
-						{!! Form::label('reject_explained_to', trans("terms.explained-to"), array('class' => 'col-sm-3 form-control-label')) !!}
-						<div class="col-sm-9">
-							{!!Form::text('reject_explained_to', old('reject_explained_to'), array('class' => 'form-control'))!!}
-						</div>
-					</div>
-					<div class="form-group row" align="right">
-						{!! Form::button("<i class='fa fa-plus-circle'></i> ".trans('action.save'), 
-							array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-						<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
-					</div>
-				{!! Form::close() !!}
+		</div>
+		<div class="panel-body">
+		<!-- if there are creation errors, they will show here -->
+		@if($errors->all())
+			<div class="alert alert-danger">
+				{{ HTML::ul($errors->all()) }}
+			</div>
+		
+		{{ Form::open(array('route' => 'test.rejectAction')) }}
+			{{ Form::hidden('specimen_id', $specimen->id) }}
+			<div class="panel-body">
+				<div class="display-details">
+				    <p><strong>{{ Lang::choice('messages.test-type',1) }}</strong>
+				        {{$specimen->test->testType->name}}</p>
+				    <p><strong>{{trans('messages.specimen-type-title')}}</strong>
+				        {{$specimen->specimenType->name}}</p>
+				    <p>
+				        <strong>{{trans('messages.specimen-number-title')}}</strong>
+				        {{$specimen->id}}
+				    </p>
 				</div>
-				<div class="col-md-4">
-					<ul class="list-group">
-						<li class="list-group-item"><strong>{!! trans_choice('menu.specimen-type', 1).': '.$specimen->specimenType->name !!}</strong></li>
-						<li class="list-group-item"><h6>{!! trans("terms.specimen-id") !!}<small> {!! $specimen->id !!}</small></h6></li>
-						<li class="list-group-item"><h6>{!! trans_choice('menu.test-type', 1) !!}<small> {!! $specimen->test->testType->name !!}</small></h6></li>
-					</ul>
+				
+					{{ Form::label('rejectionReason', trans('messages.rejection-reason')) }}
+					{{ Form::select('rejectionReason', array(0 => '')+$rejectionReason->lists('reason', 'id'),
+						Input::old('rejectionReason'), array('class' => 'form-control')) }}
+				</div>
+				
+					{{ Form::label('reject_explained_to', trans("messages.reject-explained-to")) }}
+					{{Form::text('reject_explained_to', Input::old('reject_explained_to'),
+						array('class' => 'form-control'))}}
+				</div>
+				<div class="form-group actions-row">
+					{{ Form::button("<span class='glyphicon glyphicon-thumbs-down'></span> ".trans('messages.reject'),
+						['class' => 'btn btn-danger', 'onclick' => 'submit()']) }}
 				</div>

-	  	</div>
+		{{ Form::close() }}
+		</div>
 	</div>
-</div>
-@endsection	
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/test/viewDetails.blade.php b/resources/views/test/viewDetails.blade.php
index 08164f2..c0de51c 100755
--- a/resources/views/test/viewDetails.blade.php
+++ b/resources/views/test/viewDetails.blade.php
@@ -1,163 +1,337 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li><a href="{!! url('test') !!}"><i class="fa fa-user-md"></i> {!! trans_choice('menu.test', 2) !!}</a></li>
-            <li class="active">{!! trans('action.view').' '.trans_choice('menu.test', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-folder-open"></i> {!! $test->visit->patient->name.' - '.$test->testType->name !!} 
-		    <span>
-				 @if($test->isCompleted() && $test->specimen->isAccepted())
-				 	@if(Auth::user()->can('edit_test_results'))
-					<a class="btn btn-sm btn-info" href="{!! url('test/'.$test->id.'/edit') !!}" >
-						<i class="fa fa-edit"></i>
-						{!! trans('action.edit') !!}
-					</a>
-					
-					@if(Auth::user()->can('verify_test_results') && Auth::user()->id != $test->tested_by)
-					<a class="btn btn-sm btn-midnight-blue" href="{!! route('test.verify', array($test->id)) !!}">
-	                    <i class="fa fa-check-square"></i>
-	                    {!! trans('action.verify') !!}
-	                </a>
-	                
-	            
-	            @if($test->isCompleted() || $test->isVerified())
-		            @if(Auth::user()->can('view_reports'))
-					<a class="btn btn-sm btn-pomegranate" href="{!! route('test.viewDetails', array($test->id)) !!}">
-	                    <i class="fa fa-file-text"></i>
-	                    {!! trans_choice('menu.report', 1) !!}
-	                </a>
-	                
-                
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
-			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
-            <div class="row">
-	            <div class="col-md-6">
-		            <ul class="list-group" style="padding-bottom:5px;">
-					  	<li class="list-group-item"><strong>{!! trans('terms.details-for').': '.$test->visit->patient->name.' - '.$test->testType->name !!}</strong></li>
-					  	<li class="list-group-item"><h6>{!! trans_choice("menu.test-type", 1) !!}<small> {!! $test->testType->name or trans('messages.unknown') !!}</small></h6></li>
-					  	<li class="list-group-item"><h6>{!! trans("terms.visit-no") !!}<small> {!! $test->visit->visit_number or trans('messages.unknown') !!}</small></h6></li>
-					  	<li class="list-group-item"><h6>{!! trans("terms.date-ordered") !!}<small> {!! $test->isExternal()?$test->external()->request_date:$test->time_created !!}</small></h6></li>
-					  	<li class="list-group-item"><h6>{!! trans("terms.date-received") !!}<small> {!! $test->time_created !!}</small></h6></li>
-					  	<li class="list-group-item"><h6>{!! trans("terms.test-status") !!}<small> {!! trans('terms.'.$test->testStatus->name) !!}</small></h6></li>
-					  	<li class="list-group-item"><h6>{!! trans("terms.physician") !!}<small> {!! $test->requested_by or trans('messages.unknown') !!}</small></h6></li>
-					  	<li class="list-group-item">
-					  		<h6>{!! trans("terms.origin") !!}
-				  				<small>
-				  					@if($test->specimen->isReferred() && $test->specimen->referral->status == Referral::REFERRED_IN)
-										{!! trans("messages.in") !!}
-									@else
-										{!! $test->visit->visit_type !!}
-									
-				  				</small>
-					  		</h6>
-					  	</li>
-					  	<li class="list-group-item"><h6>{!! trans("terms.registered-by") !!}<small> {!! $test->createdBy->name or trans('messages.unknown') !!}</small></h6></li>
-					  	<li class="list-group-item"><h6>{!! trans("terms.performed-by") !!}<small> {!! $test->testedBy->name or trans('messages.unknown') !!}</small></h6></li>
-					  	@if($test->isVerified())
-					  		<li class="list-group-item"><h6>{!! trans("terms.verified-by") !!}<small> {!! $test->verifiedBy->name or trans('messages.verification-pending') !!}</small></h6></li>
-					  	
-					  	@if((!$test->specimen->isRejected()) && ($test->isCompleted() || $test->isVerified()))
-					  		<li class="list-group-item"><h6>{!! trans("menu.turn-around-time") !!}<small> {!! $test->getFormattedTurnaroundTime() !!}</small></h6></li>
-					  	
-					</ul>
-				</div>
-				<div class="col-md-6">
-					<ul class="list-group" style="padding-bottom:5px">
-  						<li class="list-group-item"><strong>{!! trans_choice('menu.patient', 1) !!}</strong></li>
-  						<li class="list-group-item">
-  							<h6>
-					  			<span>{!! trans("terms.patient-no") !!}<small> {!! $test->visit->patient->patient_number !!}</small></span>
-					  			<span>{!! trans("terms.age") !!}<small> {!! $test->visit->patient->getAge() !!}</small></span>
-					  			<span>{!! trans("terms.gender") !!}<small> {!! ($test->visit->patient->gender==0?trans_choice('terms.sex', 1):trans_choice('terms.sex', 2)) !!}</small></span>
-					  		</h6>
-  						</li>
-					</ul>
-					<ul class="list-group" style="padding-bottom:5px">
-  						<li class="list-group-item"><strong>{!! trans('terms.specimen') !!}</strong></li>
-  						<li class="list-group-item">
-  							<h6>
-					  			<span>{!! trans("terms.type") !!}<small> {!! $test->specimen->specimenType->name or trans('messages.pending') !!}</small></span>
-					  			<span>{!! trans("terms.specimen-id") !!}<small> {!! $test->getSpecimenId() !!}</small></span>
-					  			<span>{!! trans("terms.test-status") !!}<small> {!! trans('terms.'.$test->specimen->specimenStatus->name) !!}</small></span>
+	<div>
+		<ol class="breadcrumb">
+		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+		  <li><a href="{{ URL::route('test.index') }}">{{ Lang::choice('messages.test',2) }}</a></li>
+		  <li class="active">{{trans('messages.test-details')}}</li>
+		</ol>
+	</div>
+	@if (Session::has('message'))
+        <div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
+    
+	<div class="panel panel-primary">
+		<div class="panel-heading ">
+            <div class="container-fluid">
+                <div class="row less-gutter">
+                    <div class="col-md-11">
+						<span class="glyphicon glyphicon-cog"></span>{{trans('messages.test-details')}}
 
+						@if($test->isCompleted() && $test->specimen->isAccepted())
+						<div class="panel-btn">
+							@if(Auth::user()->can('edit_test_results'))
+								<a class="btn btn-sm btn-info" href="{{ URL::to('test/'.$test->id.'/edit') }}">
+									<span class="glyphicon glyphicon-edit"></span>
+									{{trans('messages.edit-test-results')}}
+								</a>
+							
+							@if(Auth::user()->can('verify_test_results') && Auth::user()->id != $test->tested_by)
+							<a class="btn btn-sm btn-success" href="{{ URL::route('test.verify', array($test->id)) }}">
+								<span class="glyphicon glyphicon-thumbs-up"></span>
+								{{trans('messages.verify')}}
+							</a>
+							
+						</div>
+						
+						@if($test->isCompleted() || $test->isVerified())
+						<div class="panel-btn">
+							@if(Auth::user()->can('view_reports'))
+								<a class="btn btn-sm btn-default" href="{{ URL::to('patientreport/'.$test->visit->patient->id.'/'.$test->visit->id) }}">
+									<span class="glyphicon glyphicon-eye-open"></span>
+									{{trans('messages.view-visit-report')}}
+								</a>
+								<a class="btn btn-sm btn-default" href="{{ URL::to('patientreport/'.$test->visit->patient->id.'/'.$test->visit->id.'/'.$test->id ) }}">
+									<span class="glyphicon glyphicon-eye-open"></span>
+									{{trans('messages.view-test-report')}}
+								</a>
+							
+						</div>
+						
+                    </div>
+                    <div class="col-md-1">
+                        <a class="btn btn-sm btn-primary pull-right" href="#" onclick="window.history.back();return false;"
+                            alt="{{trans('messages.back')}}" title="{{trans('messages.back')}}">
+                            <span class="glyphicon glyphicon-backward"></span></a>
+                    </div>
+                </div>
+            </div>
+		</div> <!-- ./ panel-heading -->
+		<div class="panel-body">
+			<div class="container-fluid">
+				<div class="row">
+					<div class="col-md-6">
+						<div class="display-details">
+							<h3 class="view"><strong>{{ Lang::choice('messages.test-type',1) }}</strong>
+								{{ $test->testType->name or trans('messages.unknown') }}</h3>
+							<p class="view"><strong>{{trans('messages.visit-number')}}</strong>
+								{{$test->visit->visit_number or trans('messages.unknown') }}</p>
+							<p class="view"><strong>{{trans('messages.date-ordered')}}</strong>
+								{{ $test->isExternal()?$test->external()->request_date:$test->time_created }}</p>
+							<p class="view"><strong>{{trans('messages.lab-receipt-date')}}</strong>
+								{{$test->time_created}}</p>
+							<p class="view"><strong>{{trans('messages.test-status')}}</strong>
+								{{trans('messages.'.$test->testStatus->name)}}</p>
+							<p class="view-striped"><strong>{{trans('messages.physician')}}</strong>
+								{{$test->requested_by or trans('messages.unknown') }}</p>
+							<p class="view-striped"><strong>{{trans('messages.request-origin')}}</strong>
+								@if($test->specimen->isReferred() && $test->specimen->referral->status == Referral::REFERRED_IN)
+									{{ trans("messages.in") }}
+								@else
+									{{ $test->visit->visit_type }}
+								</p>
+							<p class="view-striped"><strong>{{trans('messages.registered-by')}}</strong>
+								{{$test->createdBy->name or trans('messages.unknown') }}</p>
+							<p class="view"><strong>{{trans('messages.tested-by')}}</strong>
+								{{$test->testedBy->name or trans('messages.unknown')}}</p>
+							@if($test->isVerified())
+							<p class="view"><strong>{{trans('messages.verified-by')}}</strong>
+								{{$test->verifiedBy->name or trans('messages.verification-pending')}}</p>
+							
+							@if((!$test->specimen->isRejected()) && ($test->isCompleted() || $test->isVerified()))
+							<!-- Not Rejected and (Verified or Completed)-->
+							<p class="view-striped"><strong>{{trans('messages.turnaround-time')}}</strong>
+								{{$test->getFormattedTurnaroundTime()}}</p>
+							
+						</div>
+					</div>
+					<div class="col-md-6">
+						<div class="panel panel-info">  <!-- Patient Details -->
+							<div class="panel-heading">
+								<h3 class="panel-title">{{trans("messages.patient-details")}}</h3>
+							</div>
+							<div class="panel-body">
+								<div class="container-fluid">
+									<div class="row">
+										<div class="col-md-3">
+											<p><strong>{{trans("messages.patient-number")}}</strong></p></div>
+										<div class="col-md-9">
+											{{$test->visit->patient->external_patient_number}}</div></div>
+									<div class="row">
+										<div class="col-md-3">
+											<p><strong>{{ Lang::choice('messages.name',1) }}</strong></p></div>
+										<div class="col-md-9">
+											{{$test->visit->patient->name}}</div></div>
+									<div class="row">
+										<div class="col-md-3">
+											<p><strong>{{trans("messages.age")}}</strong></p></div>
+										<div class="col-md-9">
+											{{$test->visit->patient->getAge()}}</div></div>
+									<div class="row">
+										<div class="col-md-3">
+											<p><strong>{{trans("messages.gender")}}</strong></p></div>
+										<div class="col-md-9">
+											{{$test->visit->patient->gender==0?trans("messages.male"):trans("messages.female")}}
+										</div></div>
+								</div>
+							</div> <!-- ./ panel-body -->
+						</div> <!-- ./ panel -->
+						<div class="panel panel-info"> <!-- Specimen Details -->
+							<div class="panel-heading">
+								<h3 class="panel-title">{{trans("messages.specimen-details")}}</h3>
+							</div>
+							<div class="panel-body">
+								<div class="container-fluid">
+									<div class="row">
+										<div class="col-md-4">
+											<p><strong>{{ Lang::choice('messages.specimen-type',1) }}</strong></p>
+										</div>
+										<div class="col-md-8">
+											{{$test->specimen->specimenType->name or trans('messages.pending') }}
+										</div>
+									</div>
+									<div class="row">
+										<div class="col-md-4">
+											<p><strong>{{trans('messages.specimen-number')}}</strong></p>
+										</div>
+										<div class="col-md-8">
+											{{$test->getSpecimenId() }}
+										</div>
+									</div>
+									<div class="row">
+										<div class="col-md-4">
+											<p><strong>{{trans('messages.specimen-status')}}</strong></p>
+										</div>
+										<div class="col-md-8">
+											{{trans('messages.'.$test->specimen->specimenStatus->name) }}
+										</div>
+									</div>
 								@if($test->specimen->isRejected())
-									<span>{!! trans("menu.reject-reason") !!}<small> {!! $test->specimen->rejectionReason->reason or trans('messages.pending') !!}</small></span>
-									<span>{!! trans("terms.explained-to") !!}<small> {!! $test->specimen->reject_explained_to or trans('messages.pending') !!}</small></span>
+									<div class="row">
+										<div class="col-md-4">
+											<p><strong>{{trans('messages.rejection-reason-title')}}</strong></p>
+										</div>
+										<div class="col-md-8">
+											{{$test->specimen->rejectionReason->reason or trans('messages.pending') }}
+										</div>
+									</div>
+									<div class="row">
+										<div class="col-md-4">
+											<p><strong>{{trans('messages.reject-explained-to')}}</strong></p>
+										</div>
+										<div class="col-md-8">
+											{{$test->specimen->reject_explained_to or trans('messages.pending') }}
+										</div>
+									</div>
 								
 								@if($test->specimen->isReferred())
 								<br>
-									<span>{!! trans("terms.referred") !!}
-										<small> 
+									<div class="row">
+										<div class="col-md-4">
+											<p><strong>{{trans("messages.specimen-referred-label")}}</strong></p>
+										</div>
+										<div class="col-md-8">
 											@if($test->specimen->referral->status == Referral::REFERRED_IN)
-												{!! trans("messages.in") !!}
+												{{ trans("messages.in") }}
 											@elseif($test->specimen->referral->status == Referral::REFERRED_OUT)
-												{!! trans("messages.out") !!}
+												{{ trans("messages.out") }}
 											
-										</small>
-									</span>
-									<span>{!! trans_choice("menu.facility", 1) !!}<small> {!! $test->specimen->referral->facility->name !!}</small></span>
-									<span>
-										@if($test->specimen->referral->status == Referral::REFERRED_IN)
-											{!! trans("messages.originating-from") !!}
-										@elseif($test->specimen->referral->status == Referral::REFERRED_OUT)
-											{!! trans("messages.intended-reciepient") !!}
-										
-										<small> {!! $test->specimen->referral->person !!}</small>
-									</span>
-									<span>{!! trans("terms.contacts") !!}<small> {!! $test->specimen->referral->contacts !!}</small></span>
-									<span>
-										@if($test->specimen->referral->status == Referral::REFERRED_IN)
-											{!! trans("messages.recieved-by") !!}
-										@elseif($test->specimen->referral->status == Referral::REFERRED_OUT)
-											{!! trans("messages.referred-by") !!}
-										
-										<small> {!! $test->specimen->referral->user->name !!}</small>
-									</span>
-									<span>{!! trans("terms.specimen-id") !!}<small> {!! $test->getSpecimenId() !!}</small></span>
+										</div>
+									</div>
+									<div class="row">
+										<div class="col-md-4">
+											<p><strong>{{Lang::choice("messages.facility", 1)}}</strong></p>
+										</div>
+										<div class="col-md-8">
+											{{$test->specimen->referral->facility->name }}
+										</div>
+									</div>
+									<div class="row">
+										<div class="col-md-4">
+											<p><strong>@if($test->specimen->referral->status == Referral::REFERRED_IN)
+												{{ trans("messages.originating-from") }}
+											@elseif($test->specimen->referral->status == Referral::REFERRED_OUT)
+												{{ trans("messages.intended-reciepient") }}
+											</strong></p>
+										</div>
+										<div class="col-md-8">
+											{{$test->specimen->referral->person }}
+										</div>
+									</div>
+									<div class="row">
+										<div class="col-md-4">
+											<p><strong>{{trans("messages.contacts")}}</strong></p>
+										</div>
+										<div class="col-md-8">
+											{{$test->specimen->referral->contacts }}
+										</div>
+									</div>
+									<div class="row">
+										<div class="col-md-4">
+											<p><strong>@if($test->specimen->referral->status == Referral::REFERRED_IN)
+												{{ trans("messages.recieved-by") }}
+											@elseif($test->specimen->referral->status == Referral::REFERRED_OUT)
+												{{ trans("messages.referred-by") }}
+											</strong></p>
+										</div>
+										<div class="col-md-8">
+											{{ $test->specimen->referral->user->name }}
+										</div>
+									</div>
 								
-					  		</h6>
-  						</li>
-					</ul>
-					<ul class="list-group" style="padding-bottom:5px">
-						<li class="list-group-item"><strong>{!! trans_choice('terms.result', 2) !!}</strong></li>
-						@foreach($test->testResults as $result)
-							<li class="list-group-item">
-								<h6>
-									{!! App\Models\Measure::find($result->measure_id)->name !!}
-									<small> 
-										{!! $result->result !!}
-										{!! App\Models\Measure::getRange($test->visit->patient, $result->measure_id) !!}
-										{!! App\Models\Measure::find($result->measure_id)->unit !!}
-									</small>
-								</h6>
-							</li>
-						@endforeach
-						<li class="list-group-item"><h6>{!! trans('messages.test-remarks') !!}<small> {!! $test->interpretation !!}</small></h6></li>
-					</ul>
+								</div>
+							</div>
+						</div> <!-- ./ panel -->
+						<div class="panel panel-info">  <!-- Test Results -->
+							<div class="panel-heading">
+								<h3 class="panel-title">{{trans("messages.test-results")}}</h3>
+							</div>
+							<div class="panel-body">
+								<div class="container-fluid">
+								@foreach($test->testResults as $result)
+									<div class="row">
+										<div class="col-md-4">
+											<p><strong>{{ Measure::find($result->measure_id)->name }}</strong></p>
+										</div>
+										<div class="col-md-3">
+											{{$result->result}}	
+										</div>
+										<div class="col-md-5">
+	        								{{ Measure::getRange($test->visit->patient, $result->measure_id) }}
+											{{ Measure::find($result->measure_id)->unit }}
+										</div>
+									</div>
+								@endforeach
+									<div class="row">
+										<div class="col-md-2">
+											<p><strong>{{trans('messages.test-remarks')}}</strong></p>
+										</div>
+										<div class="col-md-10">
+											{{$test->interpretation}}
+										</div>
+									</div>
+								</div>
+							</div> <!-- ./ panel-body -->
+						</div>  <!-- ./ panel -->
+					</div>
 				</div>
-			</div>
-	  	</div>
-	</div>
-</div>
-@endsection	
\ No newline at end of file
+			</div> <!-- ./ container-fluid -->
+			@if(count($test->testType->organisms)>0)
+            <div class="panel panel-success">  <!-- Patient Details -->
+                <div class="panel-heading">
+                    <h3 class="panel-title">{{trans("messages.culture-worksheet")}}</h3>
+                </div>
+                <div class="panel-body">
+                    <p><strong>{{trans("messages.culture-work-up")}}</strong></p>
+                    <table class="table table-bordered">
+                        <thead>
+                            
+                        </thead>
+                        <tbody id="tbbody">
+                        	<tr>
+                                <th width="15%">{{ trans('messages.date')}}</th>
+                                <th width="10%">{{ trans('messages.tech-initials')}}</th>
+                                <th>{{ trans('messages.observations-and-work-up')}}</th>
+                            </tr>
+                            @if(($observations = $test->culture) != null)
+                                @foreach($observations as $observation)
+                                <tr>
+                                    <td>{{ $observation->created_at }}</td>
+                                    <td>{{ User::find($observation->user_id)->name }}</td>
+                                    <td>{{ $observation->observation }}</td>
+                                </tr>
+                                @endforeach
+                            @else
+                            	<tr>
+                            		<td colspan="3">{{ trans('messages.no-data-found') }}</td>
+                            	</tr>
+                            
+                        </tbody>
+                    </table>
+                    <p><strong>{{trans("messages.susceptibility-test-results")}}</strong></p>
+                    <div class="row">
+                    	@if(count($test->susceptibility)>0)
+	                    	@foreach($test->testType->organisms as $organism)
+	                    	<div class="col-md-6">
+	                    		<table class="table table-bordered">
+			                        <tbody>
+			                        	<tr>
+			                                <th colspan="3">{{ $organism->name }}</th>
+			                            </tr>
+			                            <tr>
+			                                <th width="50%">{{ Lang::choice('messages.drug',1) }}</th>
+			                                <th>{{ trans('messages.zone-size')}}</th>
+			                                <th>{{ trans('messages.interp')}}</th>
+			                            </tr>
+			                            @foreach($organism->drugs as $drug)
+			                            	@if($drugSusceptibility = Susceptibility::getDrugSusceptibility($test->id, $organism->id, $drug->id))
+			                            		@if($drugSusceptibility->interpretation)
+					                            <tr>
+					                                <td>{{ $drug->name }}</td>
+					                                <td>{{ $drugSusceptibility->zone!=null?$drugSusceptibility->zone:'' }}</td>
+					                                <td>{{ $drugSusceptibility->interpretation!=null?$drugSusceptibility->interpretation:'' }}</td>
+					                            </tr>
+					                            
+				                            
+			                            @endforeach
+			                        </tbody>
+			                    </table>
+	                    	</div>
+	                    	@endforeach
+                    	
+                    </div>
+                  </div>
+                </div> <!-- ./ panel-body -->
+            
+		</div> <!-- ./ panel-body -->
+	</div> <!-- ./ panel -->
+@stop
\ No newline at end of file
diff --git a/resources/views/testcategory/create.blade.php b/resources/views/testcategory/create.blade.php
index c717f56..ccfd9d6 100755
--- a/resources/views/testcategory/create.blade.php
+++ b/resources/views/testcategory/create.blade.php
@@ -1,60 +1,45 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li><a href="{!! route('testcategory.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.lab-section', 2) !!}</a></li>
-            <li class="active">{!! trans('action.new').' '.trans_choice('menu.lab-section', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-pencil"></i> {!! trans('action.new').' '.trans_choice('menu.lab-section', 1) !!} 
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
+
+	<div>
+		<ol class="breadcrumb">
+		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+		  <li>
+		  	<a href="{{ URL::route('testcategory.index') }}">{{ Lang::choice('messages.test-category',1) }}</a>
+		  </li>
+		  <li class="active">{{trans('messages.create-test-category')}}</li>
+		</ol>
+	</div>
+	<div class="panel panel-primary">
+		<div class="panel-heading ">
+			<span class="glyphicon glyphicon-adjust"></span>
+			{{trans('messages.create-test-category')}}
 		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
+		<div class="panel-body">
+		<!-- if there are creation errors, they will show here -->
 			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
+				<div class="alert alert-danger">
+					{{ HTML::ul($errors->all()) }}
+				</div>
+			
+
+			{{ Form::open(array('route' => 'testcategory.store', 'id' => 'form-create-testcategory')) }}
 
-			{!! Form::open(array('route' => 'testcategory.store', 'id' => 'form-create-testcategory')) !!}
-				<!-- CSRF Token -->
-                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-                <!-- ./ csrf token -->
-				<div class="form-group row">
-					{!! Form::label('name', trans_choice('terms.name',1), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
-					</div>
+				
+					{{ Form::label('name', Lang::choice('messages.name',1)) }}
+					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
 				</div>
-				<div class="form-group row">
-					{!! Form::label('description', trans("terms.description"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
-					<div class="col-sm-6">
-						{!! Form::textarea('description', old('description'), array('class' => 'form-control', 'rows' => '2')) !!}
-					</div>
+				
+					{{ Form::label('description', trans("messages.description")) }}</label>
+					{{ Form::textarea('description', Input::old('description'), 
+						array('class' => 'form-control', 'rows' => '2')) }}
 				</div>
-				<div class="form-group row col-sm-offset-2">
-					{!! Form::button("<i class='fa fa-plus-circle'></i> ".trans('action.save'), 
-						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
+				<div class="form-group actions-row">
+					{{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
+						array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
 				</div>
 
-			{!! Form::close() !!}
-	  	</div>
+			{{ Form::close() }}
+		</div>
 	</div>
-</div>
-@endsection	
\ No newline at end of file
+@stop	
\ No newline at end of file
diff --git a/resources/views/testcategory/edit.blade.php b/resources/views/testcategory/edit.blade.php
index 097c406..4f5129c 100755
--- a/resources/views/testcategory/edit.blade.php
+++ b/resources/views/testcategory/edit.blade.php
@@ -1,61 +1,46 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li><a href="{!! route('testcategory.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.lab-section', 2) !!}</a></li>
-            <li class="active">{!! trans('action.edit').' '.trans_choice('menu.lab-section', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-edit"></i> {!! trans('action.edit').' '.trans_choice('menu.lab-section', 1) !!} 
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
+
+	@if (Session::has('message'))
+		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
+	
+	<div>
+		<ol class="breadcrumb">
+		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+		  <li>
+		  	<a href="{{ URL::route('testcategory.index') }}">{{ Lang::choice('messages.test-category',1) }}</a>
+		  </li>
+		  <li class="active">{{ trans('messages.edit-test-category') }}</li>
+		</ol>
+	</div>
+	<div class="panel panel-primary">
+		<div class="panel-heading ">
+			<span class="glyphicon glyphicon-edit"></span>
+			{{ trans('messages.edit-test-category') }}
 		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
+		<div class="panel-body">
 			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
-
-			{!! Form::model($testcategory, array('route' => array('testcategory.update', $testcategory->id), 
-				'method' => 'PUT', 'id' => 'form-edit-testcategory')) !!}
-				<!-- CSRF Token -->
-                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-                <!-- ./ csrf token -->
-				<div class="form-group row">
-					{!! Form::label('name', trans_choice('terms.name',1), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
-					</div>
+				<div class="alert alert-danger">
+					{{ HTML::ul($errors->all()) }}
+				</div>
+			
+			{{ Form::model($testcategory, array('route' => array('testcategory.update', $testcategory->id), 
+				'method' => 'PUT', 'id' => 'form-edit-testcategory')) }}
+				
+					{{ Form::label('name', Lang::choice('messages.name',1)) }}
+					{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
 				</div>
-				<div class="form-group row">
-					{!! Form::label('description', trans("terms.description"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
-					<div class="col-sm-6">
-						{!! Form::textarea('description', old('description'), array('class' => 'form-control', 'rows' => '2')) !!}
-					</div>
+				
+					{{ Form::label('description', trans('messages.description')) }}
+					{{ Form::textarea('description', Input::old('description'), 
+						array('class' => 'form-control', 'rows' => '2')) }}
 				</div>
-				<div class="form-group row col-sm-offset-2">
-					{!! Form::button("<i class='fa fa-check-circle'></i> ".trans('action.update'), 
-						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
+				<div class="form-group actions-row">
+					{{ Form::button('<span class="glyphicon glyphicon-save"></span> '. trans('messages.save'), 
+						['class' => 'btn btn-primary', 'onclick' => 'submit()']) }}
 				</div>
 
-			{!! Form::close() !!}
-	  	</div>
+			{{ Form::close() }}
+		</div>
 	</div>
-</div>
-@endsection
\ No newline at end of file
+@stop	
\ No newline at end of file
diff --git a/resources/views/testcategory/index.blade.php b/resources/views/testcategory/index.blade.php
index d205961..a91c0ea 100755
--- a/resources/views/testcategory/index.blade.php
+++ b/resources/views/testcategory/index.blade.php
@@ -1,89 +1,71 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li class="active"><i class="fa fa-cube"></i> {!! trans_choice('menu.lab-section', 2) !!}</li>
-        </ul>
-    </div>
+<div>
+	<ol class="breadcrumb">
+	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+	  <li class="active">{{ Lang::choice('messages.test-category',1) }}</li>
+	</ol>
 </div>
-<div class="conter-wrapper">
-	<div class="row">
-		<div class="col-sm-12">
-			<div class="card">
-				<div class="card-header">
-				    <i class="fa fa-book"></i> {!! trans_choice('menu.lab-section', 2) !!} 
-				    <span>
-					    <a class="btn btn-sm btn-belize-hole" href="{!! url("testcategory/create") !!}" >
-							<i class="fa fa-plus-circle"></i>
-							{!! trans('action.new').' '.trans_choice('menu.lab-section', 1) !!}
-						</a>
-						<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-							<i class="fa fa-step-backward"></i>
-							{!! trans('action.back') !!}
-						</a>				
-					</span>
-				</div>
-			  	<div class="card-block">	  		
-					@if (Session::has('message'))
-						<div class="alert alert-info">{!! Session::get('message') !!}</div>
-					
-					@if($errors->all())
-		            <div class="alert alert-danger alert-dismissible" role="alert">
-		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-		            </div>
-		            
-				 	<table class="table table-bordered table-sm search-table">
-						<thead>
-							<tr>
-								<th>{!! trans('terms.name') !!}</th>
-								<th>{!! trans('terms.description') !!}</th>
-								<th></th>
-							</tr>
-						</thead>
-						<tbody>
-						@foreach($testcategory as $key => $value)
-							<tr @if(session()->has('active_testCategory'))
-				                    {!! (session('active_testCategory') == $value->id)?"class='warning'":"" !!}
-				                
-				                >
-								<td>{!! $value->name !!}</td>
-								<td>{!! $value->description !!}</td>
-								
-								<td>
+@if (Session::has('message'))
+	<div class="alert alert-info">{{ Session::get('message') }}</div>
+
+<div class="panel panel-primary">
+	<div class="panel-heading ">
+		<span class="glyphicon glyphicon-adjust"></span>
+		{{ Lang::choice('messages.test-category',1) }}
+		<div class="panel-btn">
+			<a class="btn btn-sm btn-info" href="{{ URL::to("testcategory/create") }}" >
+				<span class="glyphicon glyphicon-plus-sign"></span>
+				{{ trans('messages.create-test-category') }}
+			</a>
+		</div>
+	</div>
+	<div class="panel-body">
+		<table class="table table-striped table-hover table-condensed search-table">
+			<thead>
+				<tr>
+					<th>{{ Lang::choice('messages.name',1) }}</th>
+					<th>{{ trans('messages.description') }}</th>
+					<th></th>
+				</tr>
+			</thead>
+			<tbody>
+			@foreach($testcategory as $key => $value)
+				<tr @if(Session::has('activetestcategory'))
+                            {{(Session::get('activetestcategory') == $value->id)?"class='info'":""}}
+                        
+                        >
 
-								<!-- show the test category (uses the show method found at GET /testcategory/{id} -->
-									<a class="btn btn-sm btn-success" href="{!! url("testcategory/" . $value->id) !!}" >
-										<i class="fa fa-folder-open-o"></i>
-										{!! trans('action.view') !!}
-									</a>
+					<td>{{ $value->name }}</td>
+					<td>{{ $value->description }}</td>
+					
+					<td>
 
-								<!-- edit this test category (uses edit method found at GET /testcategory/{id}/edit -->
-									<a class="btn btn-sm btn-info" href="{!! url("testcategory/" . $value->id . "/edit") !!}" >
-										<i class="fa fa-edit"></i>
-										{!! trans('action.edit') !!}
-									</a>
-									
-								<!-- delete this test category (uses delete method found at GET /testcategory/{id}/delete -->
-									<button class="btn btn-sm btn-danger delete-item-link"
-										data-toggle="modal" data-target=".confirm-delete-modal"	
-										data-id='{!! url("testcategory/" . $value->id . "/delete") !!}'>
-										<i class="fa fa-trash-o"></i>
-										{!! trans('action.delete') !!}
-									</button>
-								</td>
-							</tr>
-						@endforeach
-						</tbody>
-					</table>
-			  	</div>
-			</div>
-		</div>
+					<!-- show the test category (uses the show method found at GET /testcategory/{id} -->
+						<a class="btn btn-sm btn-success" href="{{ URL::to("testcategory/" . $value->id) }}" >
+							<span class="glyphicon glyphicon-eye-open"></span>
+							{{ trans('messages.view') }}
+						</a>
+
+					<!-- edit this test category (uses edit method found at GET /testcategory/{id}/edit -->
+						<a class="btn btn-sm btn-info" href="{{ URL::to("testcategory/" . $value->id . "/edit") }}" >
+							<span class="glyphicon glyphicon-edit"></span>
+							{{ trans('messages.edit') }}
+						</a>
+						
+					<!-- delete this test category (uses delete method found at GET /testcategory/{id}/delete -->
+						<button class="btn btn-sm btn-danger delete-item-link"
+							data-toggle="modal" data-target=".confirm-delete-modal"	
+							data-id='{{ URL::to("testcategory/" . $value->id . "/delete") }}'>
+							<span class="glyphicon glyphicon-trash"></span>
+							{{ trans('messages.delete') }}
+						</button>
+					</td>
+				</tr>
+			@endforeach
+			</tbody>
+		</table>
+		{{ Session::put('SOURCE_URL', URL::full()) }}
 	</div>
-	{!! session(['SOURCE_URL' => URL::full()]) !!}
 </div>
-@endsection
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/testcategory/show.blade.php b/resources/views/testcategory/show.blade.php
index 9c0d4f0..694a321 100755
--- a/resources/views/testcategory/show.blade.php
+++ b/resources/views/testcategory/show.blade.php
@@ -1,46 +1,35 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li><a href="{!! route('testcategory.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.lab-section', 2) !!}</a></li>
-            <li class="active">{!! trans('action.view').' '.trans_choice('menu.lab-section', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-file-text"></i> <strong>{!! trans('terms.details-for').': '.$testcategory->name !!}</strong>
-		    <span>
-		    	<a class="btn btn-sm btn-belize-hole" href="{!! url("testcategory/create") !!}" >
-					<i class="fa fa-plus-circle"></i>
-					{!! trans('action.new').' '.trans_choice('menu.lab-section', 1) !!}
-				</a>
-				<a class="btn btn-sm btn-info" href="{!! url("testcategory/" . $testcategory->id . "/edit") !!}" >
-					<i class="fa fa-edit"></i>
-					{!! trans('action.edit') !!}
+
+@if (Session::has('message'))
+	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
+
+
+	<div>
+		<ol class="breadcrumb">
+		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+		  <li><a href="{{ URL::route('testcategory.index') }}">{{ Lang::choice('messages.test-category',1) }}</a></li>
+		  <li class="active">{{ trans('messages.test-category-details') }}</li>
+		</ol>
+	</div>
+	<div class="panel panel-primary ">
+		<div class="panel-heading ">
+			<span class="glyphicon glyphicon-adjust"></span>
+			{{ trans('messages.test-category-details') }}
+			<div class="panel-btn">
+				<a class="btn btn-sm btn-info" href="{{ URL::route('testcategory.edit', array($testcategory->id)) }}">
+					<span class="glyphicon glyphicon-edit"></span>
+					{{ trans('messages.edit') }}
 				</a>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>	  		
-		<!-- if there are creation errors, they will show here -->
-		@if($errors->all())
-			<div class="alert alert-danger">
-				{!! HTML::ul($errors->all()) !!}

-		
-
-		<ul class="list-group list-group-flush">
-		    <li class="list-group-item"><h4>{!! trans('terms.name').': ' !!}<small>{!! $testcategory->name !!}</small></h4></li>
-		    <li class="list-group-item"><h5>{!! trans('terms.description').': ' !!}<small>{!! $testcategory->description !!}</small></h5></li>
-	  	</ul>
+		</div>
+		<div class="panel-body">
+			<div class="display-details">
+				<h3 class="view"><strong>{{ Lang::choice('messages.name',1) }}:</strong>{{ $testcategory->name }} </h3>
+				<p class="view-striped"><strong>{{ trans('messages.description') }}:</strong>
+					{{ $testcategory->description }}</p>
+				
+			</div>
+		</div>
 	</div>
-</div>
-@endsection	
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/testtype/create.blade.php b/resources/views/testtype/create.blade.php
index a78452e..7950a41 100755
--- a/resources/views/testtype/create.blade.php
+++ b/resources/views/testtype/create.blade.php
@@ -1,133 +1,135 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li><a href="{!! route('testtype.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.test-type', 2) !!}</a></li>
-            <li class="active">{!! trans('action.new').' '.trans_choice('menu.test-type', 1) !!}</li>
-        </ul>
-    </div>
+<div>
+	<ol class="breadcrumb">
+	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+	  <li><a href="{{ URL::route('testtype.index') }}">{{ Lang::choice('messages.test-type',1) }}</a></li>
+	  <li class="active">{{trans('messages.create-test-type')}}</li>
+	</ol>
 </div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-pencil"></i> {!! trans('action.new').' '.trans_choice('menu.test-type', 1) !!}
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
-			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
+<div class="panel panel-primary">
+	<div class="panel-heading ">
+		<span class="glyphicon glyphicon-cog"></span>
+		{{trans('messages.create-test-type')}}
+	</div>
+	{{ Form::open(array('route' => array('testtype.index'), 'id' => 'form-create-testtype')) }}
+	<div class="panel-body">
+	<!-- if there are creation errors, they will show here -->
+		
+		@if($errors->all())
+			<div class="alert alert-danger">
+				{{ HTML::ul($errors->all()) }}
+			</div>
+		
 
-			{!! Form::open(array('route' => 'testtype.store', 'id' => 'form-create-test-type')) !!}
-				<!-- CSRF Token -->
-                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-                <!-- ./ csrf token -->
-				<div class="form-group row">
-					{!! Form::label('name', trans_choice('terms.name', 1), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
-					</div>
-				</div>
-				<div class="form-group row">
-					{!! Form::label('description', trans("terms.description"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
-					<div class="col-sm-6">
-						{!! Form::textarea('description', old('description'), array('class' => 'form-control', 'rows' => '2')) !!}
-					</div>
-				</div>
-				<div class="form-group row">
-					{!! Form::label('test_category_id', trans_choice('menu.lab-section', 1), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::select('test_category_id', $testcategories, '', array('class' => 'form-control c-select')) !!}
-					</div>
-				</div>
-				<div class="form-group row">
-					{!! Form::label('specimen_types', trans_choice('menu.specimen-type', 2),  array('class' => 'col-sm-2 form-control-label')) !!}
-				</div>					
-				<div class="col-md-12 card card-block">
-					@foreach($specimentypes as $key=>$value)
-						<div class="col-md-3">
-							<label  class="checkbox">
-								<input type="checkbox" name="specimentypes[]" value="{!! $value->id!!}" />{!!$value->name!!}
-							</label>
+			
+				{{ Form::label('name', Lang::choice('messages.name',1)) }}
+				{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
+			</div>
+			
+				{{ Form::label('description', trans('messages.description')) }}
+				{{ Form::textarea('description', Input::old('description'), 
+					array('class' => 'form-control', 'rows' => '2')) }}
+			</div>
+			
+				{{ Form::label('test_category_id', Lang::choice('messages.test-category',1)) }}
+				{{ Form::select('test_category_id', array(0 => '')+$testcategory->lists('name', 'id'),
+					Input::old('test_category_id'),	array('class' => 'form-control')) }}
+			</div>
+			
+				{{ Form::label('specimen_types', trans('messages.select-specimen-types')) }}
+				
+					<div class="container-fluid">
+						<?php 
+							$cnt = 0;
+							$zebra = "";
+						?>
+						@foreach($specimentypes as $key=>$value)
+							{{ ($cnt%4==0)?"<div class='row $zebra'>":"" }}
+							<?php
+								$cnt++;
+								$zebra = (((int)$cnt/4)%2==1?"row-striped":"");
+							?>
+							<div class="col-md-3">
+								<label  class="checkbox">
+									<input type="checkbox" name="specimentypes[]" value="{{ $value->id}}" />{{$value->name}}
+								</label>
+							</div>
+							{{ ($cnt%4==0)?"</div>":"" }}
+						@endforeach
 						</div>
-					@endforeach
-				</div>
-				<div class="form-group row">
-					{!! Form::label('measures', trans_choice('menu.measure', 2),  array('class' => 'col-sm-2 form-control-label')) !!}
-				</div>
-				<div class="form-group row">
-					<div class="measure-container">
 					</div>
-					<a class="btn btn-sm btn-belize-hole add-another-measure" href="javascript:void(0);" data-new-measure="1">
-				        	<i class="fa fa-plus-circle"></i></i> {!! trans('action.new').' '.trans_choice('menu.measure', 1) !!}</a>
 				</div>
-				<div class="form-group row">
-					{!! Form::label('targetTAT', trans('terms.target-tat'), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('targetTAT', old('targetTAT'), array('class' => 'form-control')) !!}
+			</div>
+			
+				{{ Form::label('measures', Lang::choice('messages.measure',2)) }}
+				
+					
 					</div>
+		        	<a class="btn btn-default add-another-measure" href="javascript:void(0);" data-new-measure="1">
+		         		<span class="glyphicon glyphicon-plus-sign"></span>{{trans('messages.add-new-measure')}}</a>
 				</div>
-				<div class="form-group row">
-					{!! Form::label('prevalence_threshold', trans('terms.prevalence-threshold'), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('prevalence_threshold', old('prevalence_threshold'), array('class' => 'form-control')) !!}
-					</div>
-				</div>
-				<div class="form-group row">
-					{!! Form::label('culture-worksheet', trans('terms.culture-worksheet'), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::checkbox(trans('terms.culture-worksheet'), "1", '', array('onclick'=>'toggle(".organismsClass", this)')) !!}
-					</div>
-				</div>
-				<div class="form-group row organismsClass" style="display:none;">
-					{!! Form::label('organisms', trans_choice('menu.organism', 2), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-offset-2 col-sm-10 list-group list-group-flush">	
-						<div class="row">
-						@foreach($organisms as $key=>$val)
+			</div>
+			
+				{{ Form::label('targetTAT', trans('messages.target-turnaround-time')) }}
+				{{ Form::text('targetTAT', Input::old('targetTAT'), array('class' => 'form-control')) }}
+			</div>
+			
+				{{ Form::label('prevalence_threshold', trans('messages.prevalence-threshold')) }}
+				{{ Form::text('prevalence_threshold', Input::old('prevalence_threshold'), 
+					array('class' => 'form-control')) }}
+			</div>
+			
+				{{ Form::label('culture-worksheet', trans('messages.show-culture-worksheet')) }}
+				{{ Form::checkbox(trans('messages.show-culture-worksheet'), "1", '', array('onclick'=>'toggle(".organismsClass", this)')) }}
+			</div>
+			<div class="form-group organismsClass" style="display:none;">
+				{{ Form::label('organisms', trans('messages.select-organisms')) }}
+				
+					<div class="container-fluid">
+						<?php 
+							$counter = 0;
+							$alternator = "";
+						?>
+						@foreach($organisms as $key=>$value)
+							{{ ($counter%4==0)?"<div class='row $alternator'>":"" }}
+							<?php
+								$counter++;
+								$alternator = (((int)$counter/4)%2==1?"row-striped":"");
+							?>
 							<div class="col-md-3">
 								<label  class="checkbox">
-									<input type="checkbox" name="organisms[]" value="{!! $value->id!!}" />
-										{!!$value->name !!}
+									<input type="checkbox" name="organisms[]" value="{{ $value->id}}" />
+										{{$value->name }}
 								</label>
 							</div>
+							{{ ($counter%4==0)?"</div>":"" }}
 						@endforeach
 						</div>
 					</div>
 				</div>
-				<div class="form-group row">
-					{!! Form::label('orderable_test', trans('terms.lab-ordered'), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">	
-						{!! Form::checkbox('orderable_test', 1, '', array('class' => '')) !!}
-					</div>
-				</div>
-				<div class="form-group row">
-					{!! Form::label('accredited', trans('terms.accredited'), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::checkbox('accredited', "1", '', array('class' => '')) !!}
-					</div>
-				</div>
-				<div class="form-group row col-sm-offset-2">
-					{!! Form::button("<i class='fa fa-check-circle'></i> ".trans('action.update'), 
-						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
-				</div>
-
-			{!! Form::close() !!}
-	  	</div>
-	</div>
+			</div>
+		
+			{{ Form::label('orderable_test', trans('messages.orderable-test')) }}
+			{{ Form::checkbox('orderable_test', 1, Input::old('orderable_test')) }}
+		</div>
+		
+			{{ Form::label('accredited', trans('messages.accredited')) }}
+			{{ Form::checkbox('accredited', "1", '', array()) }}
+		</div>
+		</div>
+		<div class="panel-footer">
+			<div class="form-group actions-row">
+				{{ Form::button(
+					'<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'),
+					['class' => 'btn btn-primary', 'onclick' => 'submit()']
+				) }}
+				{{ Form::button(trans('messages.cancel'), 
+					['class' => 'btn btn-default', 'onclick' => 'javascript:history.go(-1)']
+				) }}
+			</div>
+		</div>
+	{{ Form::close() }}
 </div>
 @include("measure.measureinput")
-@endsection
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/testtype/edit.blade.php b/resources/views/testtype/edit.blade.php
index 4022137..06c4d7b 100755
--- a/resources/views/testtype/edit.blade.php
+++ b/resources/views/testtype/edit.blade.php
@@ -1,139 +1,163 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li><a href="{!! route('testtype.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.test-type', 2) !!}</a></li>
-            <li class="active">{!! trans('action.edit').' '.trans_choice('menu.test-type', 1) !!}</li>
-        </ul>
-    </div>
+<div>
+	<ol class="breadcrumb">
+	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+	  <li><a href="{{ URL::route('testtype.index') }}">{{ Lang::choice('messages.test-type',1) }}</a></li>
+	  <li class="active">{{trans('messages.edit-test-type')}}</li>
+	</ol>
 </div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-edit"></i> {!! trans('action.edit').' '.trans_choice('menu.test-type', 1) !!} 
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>
-	  	<div class="card-block">	  		
-			<!-- if there are creation errors, they will show here -->
+<div class="panel panel-primary">
+	<div class="panel-heading ">
+		<span class="glyphicon glyphicon-edit"></span>
+		{{trans('messages.edit-test-type')}}
+	</div>
+	{{ Form::model($testtype, array(
+			'route' => array('testtype.update', $testtype->id), 'method' => 'PUT',
+			'id' => 'form-edit-testtype'
+		)) }}
+		<div class="panel-body">
 			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
-
-			{!! Form::model($testtype, array('route' => array('testtype.update', $testtype->id), 
-				'method' => 'PUT', 'id' => 'form-edit-test-type')) !!}
-				<!-- CSRF Token -->
-                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-                <!-- ./ csrf token -->
-				<div class="form-group row">
-					{!! Form::label('name', trans_choice('terms.name', 1), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
-					</div>
+				<div class="alert alert-danger">
+					{{ HTML::ul($errors->all()) }}
 				</div>
-				<div class="form-group row">
-					{!! Form::label('description', trans("terms.description"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
-					<div class="col-sm-6">
-						{!! Form::textarea('description', old('description'), array('class' => 'form-control', 'rows' => '2')) !!}
-					</div>
-				</div>
-				<div class="form-group row">
-					{!! Form::label('test_category_id', trans_choice('menu.lab-section', 1), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::select('test_category_id', $testcategories, old('testcategory') ? old('testcategory') : $testcategory, array('class' => 'form-control c-select')) !!}
+			
+
+			
+				{{ Form::label('name', Lang::choice('messages.name',1)) }}
+				{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
+			</div>
+			
+				{{ Form::label('description', trans('messages.description')) }}
+				{{ Form::textarea('description', Input::old('description'), 
+					array('class' => 'form-control', 'rows' => '2' )) }}
+			</div>
+			
+				{{ Form::label('test_category_id', Lang::choice('messages.test-category',1)) }}
+				{{ Form::select('test_category_id', array(0 => '')+$testcategory->lists('name', 'id'),
+					Input::old('test_category_id'), array('class' => 'form-control')) }}
+			</div>
+			
+				{{ Form::label('specimen_types', trans('messages.select-specimen-types')) }}
+				
+					<div class="container-fluid">
+						<?php 
+							$cnt = 0;
+							$zebra = "";
+						?>
+						@foreach($specimentypes as $key=>$value)
+							{{ ($cnt%4==0)?"<div class='row $zebra'>":"" }}
+							<?php
+								$cnt++;
+								$zebra = (((int)$cnt/4)%2==1?"row-striped":"");
+							?>
+							<div class="col-md-3">
+								<label  class="checkbox">
+									<input type="checkbox" name="specimentypes[]" value="{{ $value->id}}" 
+										{{ in_array($value->id, $testtype->specimenTypes->lists('id'))?"checked":"" }} />
+										{{$value->name }}
+								</label>
+							</div>
+							{{ ($cnt%4==0)?"</div>":"" }}
+						@endforeach
+						</div>
 					</div>
 				</div>
-				<div class="form-group row">
-					{!! Form::label('specimen_types', trans_choice('menu.specimen-type', 2),  array('class' => 'col-sm-2 form-control-label')) !!}
-				</div>					
-				<div class="col-md-12 card card-block">
-					@foreach($specimentypes as $key=>$value)
-						<div class="col-md-3">
-							<label  class="checkbox">
-								<input type="checkbox" name="specimentypes[]" value="{!! $value->id!!}" 
-									{!! in_array($value->id, $testtype->specimenTypes->lists('id')->toArray())?"checked":"" !!} />
-									{!!$value->name !!}
-							</label>
+			</div>
+			<ul class="nav nav-tabs" data-tabs="tabs">
+				<li role="presentation" class="active"><a href="#measure"  data-toggle="tab">{{Lang::choice('messages.measure',2)}}</a></li>
+				<li role="presentation"><a href="#reorder" data-toggle="tab">{{trans('messages.reorder')}}</a></li>
+			</ul>
+			
+			<div id="my-tab-content" class="tab-content">
+				<div class="tab-pane active" id="measure">
+					
+						<br/>
+						
+							
+								@include("measure.edit")
+							</div>
+							<a class="btn btn-default add-another-measure" href="javascript:void(0);" data-new-measure="1">
+								<span class="glyphicon glyphicon-plus-sign"></span>{{trans('messages.add-new-measure')}}</a>
 						</div>
-					@endforeach
-				</div>
-				<div class="form-group row">
-					{!! Form::label('measures', trans_choice('menu.measure', 2),  array('class' => 'col-sm-2 form-control-label')) !!}
-				</div>
-				<div class="form-group row">
-					<div class="measure-container">
-					@include("measure.edit")
 					</div>
-					<a class="btn btn-sm btn-belize-hole add-another-measure" href="javascript:void(0);" data-new-measure="1">
-				        	<i class="fa fa-plus-circle"></i></i> {!! trans('action.new').' '.trans_choice('menu.measure', 1) !!}</a>
-				</div>
-				<div class="form-group row">
-					{!! Form::label('targetTAT', trans('terms.target-tat'), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('targetTAT', old('targetTAT'), array('class' => 'form-control')) !!}
+
+					
+						{{ Form::label('targetTAT', trans('messages.target-turnaround-time')) }}
+						{{ Form::text('targetTAT', Input::old('targetTAT'), array('class' => 'form-control')) }}
 					</div>
-				</div>
-				<div class="form-group row">
-					{!! Form::label('prevalence_threshold', trans('terms.prevalence-threshold'), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::text('prevalence_threshold', old('prevalence_threshold'), array('class' => 'form-control')) !!}
+					
+						{{ Form::label('prevalence_threshold', trans('messages.prevalence-threshold')) }}
+						{{ Form::text('prevalence_threshold', Input::old('prevalence_threshold'), 
+							array('class' => 'form-control')) }}
 					</div>
-				</div>
-				<div class="form-group row">
-					{!! Form::label('culture-worksheet', trans('terms.culture-worksheet'), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
+					
+						{{ Form::label('culture-worksheet', trans('messages.show-culture-worksheet')) }}
 						<?php if(count($testtype->organisms)>0){$checked=true;} else{$checked=false;} ?>
-						{!! Form::checkbox(trans('terms.culture-worksheet'), "1", $checked, array('onclick'=>'toggle(".organismsClass", this)')) !!}
+						{{ Form::checkbox(trans('messages.show-culture-worksheet'), "1", $checked, array('onclick'=>'toggle(".organismsClass", this)')) }}
 					</div>
-				</div>
-				<div class="form-group row organismsClass" <?php if($checked==true){ ?>style="dispaly:block;"<?php }else{ ?>style="display:none;"<?php } ?>>
-					{!! Form::label('organisms', trans_choice('menu.organism', 2), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-offset-2 col-sm-10 list-group list-group-flush">	
-						<div class="row">
-						@foreach($organisms as $key=>$val)
-							<div class="col-md-3">
-								<label  class="checkbox">
-									<input type="checkbox" name="organisms[]" value="{!! $val->id!!}" 
-										{!! in_array($val->id, $testtype->organisms->lists('id')->toArray())?"checked":"" !!} >
-										{!! $val->name !!}
-								</label>
+					<div class="form-group organismsClass" <?php if($checked==true){ ?>style="dispaly:block;"<?php }else{ ?>style="display:none;"<?php } ?>>
+						{{ Form::label('organisms', trans('messages.select-organisms')) }}
+						
+							<div class="container-fluid">
+								<?php 
+									$counter = 0;
+									$alternator = "";
+								?>
+								@foreach($organisms as $key=>$val)
+									{{ ($counter%4==0)?"<div class='row $alternator'>":"" }}
+									<?php
+										$counter++;
+										$alternator = (((int)$counter/4)%2==1?"row-striped":"");
+									?>
+									<div class="col-md-3">
+										<label  class="checkbox">
+											<input type="checkbox" name="organisms[]" value="{{ $val->id}}" 
+												{{ in_array($val->id, $testtype->organisms->lists('id'))?"checked":"" }} >
+												{{ $val->name }}
+										</label>
+									</div>
+									{{ ($counter%4==0)?"</div>":"" }}
+								@endforeach
+								</div>
 							</div>
-						@endforeach
 						</div>
 					</div>
-				</div>
-				<div class="form-group row">
-					{!! Form::label('orderable_test', trans('terms.lab-ordered'), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">	
-						{!! Form::checkbox('orderable_test', 1, old('orderable_test'), array('class' => '')) !!}
+					
+						{{ Form::label('orderable_test', trans('messages.orderable-test')) }}
+						{{ Form::checkbox('orderable_test', 1, Input::old('orderable_test')) }}
 					</div>
-				</div>
-				<div class="form-group row">
-					{!! Form::label('accredited', trans('terms.accredited'), array('class' => 'col-sm-2 form-control-label')) !!}
-					<div class="col-sm-6">
-						{!! Form::checkbox('accredited', "1", $testtype->isAccredited(), array('class' => '')) !!}
+					
+						{{ Form::label('accredited', trans('messages.accredited')) }}
+						{{ Form::checkbox('accredited', "1", $testtype->isAccredited(), array()) }}
 					</div>
 				</div>
-				<div class="form-group row col-sm-offset-2">
-					{!! Form::button("<i class='fa fa-check-circle'></i> ".trans('action.update'), 
-						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-					<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
+				<div class="tab-pane col-md-6" id="reorder">
+					</br>
+					<ul class="list-group list-group-sm sortable" data-test-id="{{$testtype->id}}">
+					@foreach($testtype->measures as $key=>$measure)
+						@if($measure->pivot->ordering == null)
+							<li class="list-group-item" value="{{$key}}">{{$measure->name}}</li>
+						@else
+							<li class="list-group-item" value="{{$measure->pivot->ordering}}">{{$measure->name}}</li>
+						
+					@endforeach
+					</ul>
 				</div>
-
-			{!! Form::close() !!}
-	  	</div>
-	</div>
+			</div>
+		</div>
+		<div class="panel-footer">
+			<div class="form-group actions-row">
+				{{ Form::button(
+					'<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'), 
+					['class' => 'btn btn-primary', 'onclick' => 'submit()']
+				) }}
+				{{ Form::button(trans('messages.cancel'), 
+					['class' => 'btn btn-default', 'onclick' => 'javascript:history.go(-1)']
+				) }}
+			</div>
+		</div>
+	{{ Form::close() }}
 </div>
 @include("measure.measureinput")
-@endsection
\ No newline at end of file
+@stop
diff --git a/resources/views/testtype/index.blade.php b/resources/views/testtype/index.blade.php
index ebedaf4..604ff24 100755
--- a/resources/views/testtype/index.blade.php
+++ b/resources/views/testtype/index.blade.php
@@ -1,93 +1,72 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li class="active"><i class="fa fa-cube"></i> {!! trans_choice('menu.test-type', 2) !!}</li>
-        </ul>
-    </div>
+<div>
+	<ol class="breadcrumb">
+	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+	  <li class="active">{{ Lang::choice('messages.test-type',1) }}</li>
+	</ol>
 </div>
-<div class="conter-wrapper">
-	<div class="row">
-		<div class="col-sm-12">
-			<div class="card">
-				<div class="card-header">
-				    <i class="fa fa-book"></i> {!! trans_choice('menu.test-type', 2) !!} 
-				    <span>
-					    <a class="btn btn-sm btn-belize-hole" href="{!! url("testtype/create") !!}" >
-							<i class="fa fa-plus-circle"></i>
-							{!! trans('action.new').' '.trans_choice('menu.test-type', 1) !!}
+@if (Session::has('message'))
+	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
+
+<div class="panel panel-primary">
+	<div class="panel-heading ">
+		<span class="glyphicon glyphicon-cog"></span>
+		{{trans('messages.list-test-types')}}
+		<div class="panel-btn">
+			<a class="btn btn-sm btn-info" href="{{ URL::to("testtype/create") }}" >
+				<span class="glyphicon glyphicon-plus-sign"></span>
+				{{trans('messages.new-test-type')}}
+			</a>
+		</div>
+	</div>
+	<div class="panel-body">
+		<table class="table table-striped table-hover table-condensed search-table">
+			<thead>
+				<tr>
+					<th>{{ Lang::choice('messages.name',1) }}</th>
+					<th>{{trans('messages.description')}}</th>
+					<th>{{trans('messages.target-turnaround-time')}}</th>
+					<th>{{trans('messages.prevalence-threshold')}}</th>
+					<th></th>
+				</tr>
+			</thead>
+			<tbody>
+			@foreach($testtypes as $key => $value)
+				<tr @if(Session::has('activetesttype'))
+                            {{(Session::get('activetesttype') == $value->id)?"class='info'":""}}
+                        
+                        >
+					<td>{{ $value->name }}</td>
+					<td>{{ $value->description }}</td>
+					<td>{{ $value->targetTAT }}</td>
+					<td>{{ $value->prevalence_threshold }}</td>
+					<td>
+						<!-- show the testtype (uses the show method found at GET /testtype/{id} -->
+						<a class="btn btn-sm btn-success" href="{{ URL::to("testtype/" . $value->id) }}">
+							<span class="glyphicon glyphicon-eye-open"></span>
+							{{trans('messages.view')}}
 						</a>
-						<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-							<i class="fa fa-step-backward"></i>
-							{!! trans('action.back') !!}
-						</a>				
-					</span>
-				</div>
-			  	<div class="card-block">	  		
-					@if (Session::has('message'))
-						<div class="alert alert-info">{!! Session::get('message') !!}</div>
-					
-					@if($errors->all())
-		            <div class="alert alert-danger alert-dismissible" role="alert">
-		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-		            </div>
-		            
-				 	<table class="table table-bordered table-sm search-table">
-						<thead>
-							<tr>
-								<th>{!! trans('terms.name') !!}</th>
-								<th>{!! trans('terms.description') !!}</th>
-								<th>{!! trans('terms.target-tat') !!}</th>
-								<th>{!! trans('terms.prevalence-threshold') !!}</th>
-								<th></th>
-							</tr>
-						</thead>
-						<tbody>
-						@foreach($testtypes as $key => $value)
-							<tr @if(session()->has('active_testtype'))
-				                    {!! (session('active_testtype') == $value->id)?"class='warning'":"" !!}
-				                
-				                >
-								<td>{!! $value->name !!}</td>
-								<td>{!! $value->description !!}</td>
-								<td>{!! $value->targetTAT !!}</td>
-								<td>{!! $value->prevalence_threshold !!}</td>
-								
-								<td>
 
-								<!-- show the test category (uses the show method found at GET /test-type/{id} -->
-									<a class="btn btn-sm btn-success" href="{!! url("testtype/" . $value->id) !!}" >
-										<i class="fa fa-folder-open-o"></i>
-										{!! trans('action.view') !!}
-									</a>
+						<!-- edit this testtype (uses the edit method found at GET /testtype/{id}/edit -->
+						<a class="btn btn-sm btn-info" href="{{ URL::to("testtype/" . $value->id . "/edit") }}" >
+							<span class="glyphicon glyphicon-edit"></span>
+							{{trans('messages.edit')}}
+						</a>
+						<!-- delete this testtype (uses the delete method found at GET /testtype/{id}/delete -->
+						<button class="btn btn-sm btn-danger delete-item-link"
+							data-toggle="modal" data-target=".confirm-delete-modal"	
+							data-id='{{ URL::to("testtype/" . $value->id . "/delete") }}'>
+							<span class="glyphicon glyphicon-trash"></span>
+							{{trans('messages.delete')}}
+						</button>
 
-								<!-- edit this test category (uses edit method found at GET /test-type/{id}/edit -->
-									<a class="btn btn-sm btn-info" href="{!! url("testtype/" . $value->id . "/edit") !!}" >
-										<i class="fa fa-edit"></i>
-										{!! trans('action.edit') !!}
-									</a>
-									
-								<!-- delete this test category (uses delete method found at GET /test-type/{id}/delete -->
-									<button class="btn btn-sm btn-danger delete-item-link"
-										data-toggle="modal" data-target=".confirm-delete-modal"	
-										data-id='{!! url("testtype/" . $value->id . "/delete") !!}'>
-										<i class="fa fa-trash-o"></i>
-										{!! trans('action.delete') !!}
-									</button>
-								</td>
-							</tr>
-						@endforeach
-						</tbody>
-					</table>
-			  	</div>
-			</div>
-		</div>
+					</td>
+				</tr>
+			@endforeach
+			</tbody>
+		</table>
+		{{ Session::put('SOURCE_URL', URL::full()) }}
 	</div>
-	{!! session(['SOURCE_URL' => URL::full()]) !!}
 </div>
-@endsection
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/testtype/show.blade.php b/resources/views/testtype/show.blade.php
index bbe36b6..ca8e401 100755
--- a/resources/views/testtype/show.blade.php
+++ b/resources/views/testtype/show.blade.php
@@ -1,51 +1,41 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
-            <li><a href="{!! route('testtype.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.test-type', 2) !!}</a></li>
-            <li class="active">{!! trans('action.view').' '.trans_choice('menu.test-type', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-file-text"></i> <strong>{!! trans('terms.details-for').': '.$testtype->name !!}</strong>
-		    <span>
-		    	<a class="btn btn-sm btn-belize-hole" href="{!! url("testtype/create") !!}" >
-					<i class="fa fa-plus-circle"></i>
-					{!! trans('action.new').' '.trans_choice('menu.test-type', 1) !!}
-				</a>
-				<a class="btn btn-sm btn-info" href="{!! url("testtype/" . $testtype->id . "/edit") !!}" >
-					<i class="fa fa-edit"></i>
-					{!! trans('action.edit') !!}
+	<div>
+		<ol class="breadcrumb">
+		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+		  <li><a href="{{ URL::route('testtype.index') }}">{{ Lang::choice('messages.test-type',1) }}</a></li>
+		  <li class="active">{{trans('messages.test-type-details')}}</li>
+		</ol>
+	</div>
+	<div class="panel panel-primary">
+		<div class="panel-heading ">
+			<span class="glyphicon glyphicon-cog"></span>
+			{{trans('messages.test-type-details')}}
+			<div class="panel-btn">
+				<a class="btn btn-sm btn-info" href="{{ URL::to("testtype/". $testtype->id ."/edit") }}">
+					<span class="glyphicon glyphicon-edit"></span>
+					{{trans('messages.edit')}}
 				</a>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>	  		
-		<!-- if there are creation errors, they will show here -->
-		@if($errors->all())
-			<div class="alert alert-danger">
-				{!! HTML::ul($errors->all()) !!}

-		
-
-		<ul class="list-group list-group-flush">
-		    <li class="list-group-item"><h4>{!! trans('terms.name').': ' !!}<small>{!! $testtype->name !!}</small></h4></li>
-		    <li class="list-group-item"><h5>{!! trans('terms.description').': ' !!}<small>{!! $testtype->description !!}</small></h5></li>
-		    <li class="list-group-item"><h6>{!! trans_choice('menu.lab-section', 1).': ' !!}<small>{!! $testtype->testCategory->name !!}</small></h6></li>
-		    <li class="list-group-item"><h6>{!! trans_choice('menu.specimen-type', 2).': ' !!}<small>{!! implode(", ", $testtype->specimenTypes->lists('name')->toArray()) !!}</small></h6></li>
-		    <li class="list-group-item"><h6>{!! trans_choice('menu.measure', 2).': ' !!}<small>{!! implode(", ", $testtype->measures->lists('name')->toArray()) !!}</small></h6></li>
-		    <li class="list-group-item"><h6>{!! trans('terms.target-tat').': ' !!}<small>{!! $testtype->targetTAT !!}</small></h6></li>
-		    <li class="list-group-item"><h6>{!! trans('terms.prevalence-threshold').': ' !!}<small>{!! $testtype->prevalence_threshold !!}</small></h6></li>
-	  	</ul>
+		</div>
+		<div class="panel-body">
+			<div class="display-details">
+				<h3 class="view"><strong>{{ Lang::choice('messages.name',1) }}</strong>{{ $testtype->name }} </h3>
+				<p class="view-striped"><strong>{{trans('messages.description')}}</strong>
+					{{ $testtype->description }}</p>
+				<p class="view"><strong>{{ Lang::choice('messages.test-category',1) }}</strong>
+					{{ $testtype->testCategory->name }}</p>
+				<p class="view-striped"><strong>{{trans('messages.compatible-specimen')}}</strong>
+					{{ implode(", ", $testtype->specimenTypes->lists('name')) }}</p>
+				<p class="view"><strong>{{ Lang::choice('messages.measure',1) }}</strong>
+					{{ implode(", ", $testtype->measures->lists('name')) }}</p>
+				<p class="view-striped"><strong>{{trans('messages.turnaround-time')}}</strong>
+					{{ $testtype->targetTAT }}</p>
+				<p class="view"><strong>{{trans('messages.prevalence-threshold')}}</strong>
+					{{ $testtype->prevalence_threshold }}</p>
+				<p class="view-striped"><strong>{{trans('messages.date-created')}}</strong>
+					{{ $testtype->created_at }}</p>
+			</div>
+		</div>
 	</div>
-</div>
-@endsection	
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/user/create.blade.php b/resources/views/user/create.blade.php
index fb6e75f..669fc23 100755
--- a/resources/views/user/create.blade.php
+++ b/resources/views/user/create.blade.php
@@ -1,123 +1,74 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-users"></i> {!! trans('menu.access-control') !!}</li>
-            <li><a href="{!! route('user.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.user', 2) !!}</a></li>
-            <li class="active">{!! trans('action.new').' '.trans_choice('menu.user', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-pencil"></i> {!! trans('action.new').' '.trans_choice('menu.user', 1) !!} 
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
+	<div>
+		<ol class="breadcrumb">
+		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+		  <li><a href="{{ URL::route('user.index') }}">{{ Lang::choice('messages.user', 1) }}</a></li>
+		  <li class="active">{{ trans('messages.create-user') }}</li>
+		</ol>
+	</div>
+	<div class="panel panel-primary">
+		<div class="panel-heading ">
+			<span class="glyphicon glyphicon-user"></span>
+			{{ trans('messages.create-user') }}
 		</div>
-	  	<div class="card-block">	  		  		
-			<!-- if there are creation errors, they will show here -->
+		<div class="panel-body">
+		<!-- if there are creation errors, they will show here -->
+			
 			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
-			<div class="row">
-				{!! Form::open(array('route' => 'user.store', 'id' => 'form-add-user', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'files' => 'true')) !!}
-				<!-- CSRF Token -->
-                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
-                <!-- ./ csrf token -->
-				<div class="col-md-8"> 
-					<div class="form-group row">
-						{!! Form::label('name', trans_choice('terms.name',1), array('class' => 'col-sm-4 form-control-label')) !!}
-						<div class="col-sm-6">
-							{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
-						</div>
-					</div>
-					<div class="form-group row">
-						{!! Form::label('gender', trans('terms.gender'), array('class' => 'col-sm-4 form-control-label')) !!}
-						<div class="col-sm-6">
-							<label class="radio-inline">{!! Form::radio('gender', App\Models\User::MALE, true) !!}{!! trans_choice('terms.sex', 1) !!}</label>
-	                        <label class="radio-inline">{!! Form::radio("gender", App\Models\User::FEMALE, false) !!}{!! trans_choice('terms.sex', 2) !!}</label>
-						</div>
-					</div>
-					<div class="form-group row">
-						{!! Form::label('email', trans('terms.email-address'), array('class' => 'col-sm-4 form-control-label')) !!}
-						<div class="col-sm-6">
-							{!! Form::text('email', old('email'), array('class' => 'form-control')) !!}
-						</div>
-					</div>
-	                <div class="form-group row">
-	                    {!! Form::label('phone', trans('terms.phone'), array('class' => 'col-sm-4 form-control-label')) !!}
-	                    <div class="col-sm-6">
-	                        {!! Form::text('phone', old('phone'), array('class' => 'form-control')) !!}
-	                    </div>
-	                </div>
-	                <div class="form-group row">
-	                    {!! Form::label('address', trans('terms.address'), array('class' => 'col-sm-4 form-control-label')) !!}
-	                    <div class="col-sm-6">
-	                        {!! Form::textarea('address', old('address'), array('class' => 'form-control', 'rows' => '3')) !!}
-	                    </div>
-	                </div>
-	                <div class="form-group row">
-	                    {!! Form::label('username', trans('terms.username'), array('class' => 'col-sm-4 form-control-label')) !!}
-	                    <div class="col-sm-6">
-	                        {!! Form::text('username', old('username'), array('class' => 'form-control')) !!}
-	                    </div>
-	                </div>
-	                <div class="form-group row">
-	                    <div class="col-sm-offset-4 col-sm-6">
-	                        <label class="checkbox-inline">
-	                            {!! Form::checkbox("default_password", '1', '', array('onclick' => 'toggle(".pword", this)')) !!}{!! trans('terms.use-default') !!}
-	                        </label>
-	                    </div>
-	                </div>
-	                <div class="pword">
-		                <div class="form-group row">
-		                    {!! Form::label('password', trans_choice('terms.password', 1), array('class' => 'col-sm-4 form-control-label')) !!}
-		                    <div class="col-sm-6">
-		                        {!! Form::password('password', array('class' => 'form-control')) !!}
-		                    </div>
-		                </div>
-		                <div class="form-group row">
-		                    {!! Form::label('password_confirmation', trans_choice('terms.password', 2), array('class' => 'col-sm-4 form-control-label')) !!}
-		                    <div class="col-sm-6">
-		                        {!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
-		                    </div>
-		                </div>
-	                </div>
-					<div class="form-group row col-sm-offset-4 col-sm-8">
-						{!! Form::button("<i class='fa fa-plus-circle'></i> ".trans('action.save'), 
-							array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-						<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
-					</div>
-				</div>				
-		        <div class="col-md-4">
-		            <div class="row">
-		                <div class="col-md-12">
-		                    <div class="thumbnail">
-		                        {!! HTML::image('images/profile1.jpg', trans('terms.no-photo'), array('class'=>'img-responsive img-thumbnail user-image')) !!}
-		                    </div>
-		                </div>
-		                <div class="col-md-8 col-sm-offset-1">
-		                    
-		                        <label>{!! trans('terms.profile-photo') !!}</label>
-		                        {!! Form::file('photo', null, ['class' => 'form-control']) !!}
-		                    </div>
-		                </div>
-		            </div>
-		        </div>
-				{!! Form::close() !!}
-			</div>
-	  	</div>
+				<div class="alert alert-danger">
+					{{ HTML::ul($errors->all()) }}
+				</div>
+			
+
+			{{ Form::open(array('route' => array('user.index'), 'id' => 'form-create-user', 'files' => true)) }}
+
+				
+					{{ Form::label('username', trans('messages.username')) }}
+					{{ Form::text('username', Input::old('username'), ["placeholder" => "jsiku",
+						'class' => 'form-control']) }}
+				</div>
+				
+					{{ Form::label('password', Lang::choice('messages.password',1)) }}
+					{{ Form::password('password', ['class' => 'form-control']) }}
+				</div>
+				
+					{{ Form::label('password_confirmation', trans('messages.repeat-password')) }}
+					{{ Form::password('password_confirmation', ['class' => 'form-control']) }}
+				</div>
+				
+					{{ Form::label('full_name', trans('messages.full-name')) }}
+					{{ Form::text('full_name', Input::old('full_name'), ["placeholder" => "Jay Siku", 
+						'class' => 'form-control']) }}
+				</div>
+				
+					{{ Form::label('email', trans('messages.email-address')) }}
+					{{ Form::email('email', Input::old('email'), ["placeholder" => "j.siku@ilabafrica.ac.ke", 
+						'class' => 'form-control']) }}
+				</div>
+				
+					{{ Form::label('designation', trans('messages.designation')) }}
+					{{ Form::text('designation', Input::old('designation'), ["placeholder" => "Lab Technologist", 
+						'class' => 'form-control']) }}
+				</div>
+                
+                    {{ Form::label('gender', trans('messages.gender')) }}
+                    <div>{{ Form::radio('gender', Patient::MALE, true) }}
+                    	<span class='input-tag'>{{trans('messages.male')}}</span></div>
+                    <div>{{ Form::radio("gender", Patient::FEMALE, false) }}
+                    	<span class='input-tag'>{{trans('messages.female')}}</span></div>
+                </div>
+                
+                	{{ Form::label('image', trans('messages.photo')) }}
+                    {{ Form::file("image") }}
+                </div>
+				<div class="form-group actions-row">
+					{{ Form::button('<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'), 
+						['class' => 'btn btn-primary', 'onclick' => 'submit()']
+					) }}
+				</div>
+
+			{{ Form::close() }}
+		</div>
 	</div>
-</div>
-@endsection	
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/user/edit.blade.php b/resources/views/user/edit.blade.php
index f7fe9ee..065aaa2 100755
--- a/resources/views/user/edit.blade.php
+++ b/resources/views/user/edit.blade.php
@@ -1,124 +1,141 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-users"></i> {!! trans('menu.access-control') !!}</li>
-            <li><a href="{!! url('user.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.user', 2) !!}</a></li>
-            <li class="active">{!! trans('action.new').' '.trans_choice('menu.user', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-edit"></i> {!! trans('action.new').' '.trans_choice('menu.user', 1) !!} 
-		    <span>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
+	<div>
+		<ol class="breadcrumb">
+		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}} </a></li>
+		  <li><a href="{{ URL::route('user.index') }}">{{ Lang::choice('messages.user',1) }}</a></li>
+		  <li class="active">{{trans('messages.edit-user')}}</li>
+		</ol>
+	</div>
+	<div class="panel panel-primary">
+		<div class="panel-heading ">
+			<span class="glyphicon glyphicon-edit"></span>
+			{{trans('messages.edit-user-details')}}
 		</div>
-	  	<div class="card-block">	  		  		
-			<!-- if there are creation errors, they will show here -->
+		<div class="panel-body 
+			{{(Auth::id() == $user->id || !Entrust::hasRole(Role::getAdminRole()->name)) ? 'user-profile': ''}}">
 			@if($errors->all())
-            <div class="alert alert-danger alert-dismissible" role="alert">
-                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-            </div>
-            
-			<div class="row">
-				{!! Form::model($user, array('route' => array('user.update', $user->id), 
-        		'method' => 'PUT', 'enctype' => 'multipart/form-data', 'id' => 'form-edit-user', 'class' => 'form-horizontal', 'files' => 'true')) !!}
-				<!-- CSRF Token -->
-				{!! csrf_field() !!}
-                <!-- ./ csrf token -->
-				<div class="col-md-8"> 
-					<div class="form-group row">
-						{!! Form::label('name', trans_choice('terms.name',1), array('class' => 'col-sm-4 form-control-label')) !!}
-						<div class="col-sm-6">
-							{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
-						</div>
-					</div>
-					<div class="form-group row">
-						{!! Form::label('gender', trans('terms.gender'), array('class' => 'col-sm-4 form-control-label')) !!}
-						<div class="col-sm-6">
-							<label class="radio-inline">{!! Form::radio('gender', App\Models\User::MALE, true) !!}{!! trans_choice('terms.sex', 1) !!}</label>
-	                        <label class="radio-inline">{!! Form::radio("gender", App\Models\User::FEMALE, false) !!}{!! trans_choice('terms.sex', 2) !!}</label>
-						</div>
-					</div>
-					<div class="form-group row">
-						{!! Form::label('email', trans('terms.email-address'), array('class' => 'col-sm-4 form-control-label')) !!}
-						<div class="col-sm-6">
-							{!! Form::text('email', old('email'), array('class' => 'form-control')) !!}
-						</div>
-					</div>
-	                <div class="form-group row">
-	                    {!! Form::label('phone', trans('terms.phone'), array('class' => 'col-sm-4 form-control-label')) !!}
-	                    <div class="col-sm-6">
-	                        {!! Form::text('phone', old('phone'), array('class' => 'form-control')) !!}
-	                    </div>
-	                </div>
-	                <div class="form-group row">
-	                    {!! Form::label('address', trans('terms.address'), array('class' => 'col-sm-4 form-control-label')) !!}
-	                    <div class="col-sm-6">
-	                        {!! Form::textarea('address', old('address'), array('class' => 'form-control', 'rows' => '3')) !!}
-	                    </div>
-	                </div>
-	                <div class="form-group row">
-	                    {!! Form::label('username', trans('terms.username'), array('class' => 'col-sm-4 form-control-label')) !!}
-	                    <div class="col-sm-6">
-	                        {!! Form::text('username', old('username'), array('class' => 'form-control')) !!}
-	                    </div>
-	                </div>
-	                <div class="form-group row">
-	                    <div class="col-sm-offset-4 col-sm-6">
-	                        <label class="checkbox-inline">
-	                            {!! Form::checkbox("default_password", '1', '', array('onclick' => 'toggle(".pword", this)')) !!}{!! trans('terms.use-default') !!}
-	                        </label>
-	                    </div>
-	                </div>
-	                <div class="pword">
-		                <div class="form-group row">
-		                    {!! Form::label('password', trans_choice('terms.password', 1), array('class' => 'col-sm-4 form-control-label')) !!}
-		                    <div class="col-sm-6">
-		                        {!! Form::password('password', array('class' => 'form-control')) !!}
-		                    </div>
-		                </div>
-		                <div class="form-group row">
-		                    {!! Form::label('password_confirmation', trans_choice('terms.password', 2), array('class' => 'col-sm-4 form-control-label')) !!}
-		                    <div class="col-sm-6">
-		                        {!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
-		                    </div>
-		                </div>
-	                </div>
-					<div class="form-group row col-sm-offset-4 col-sm-8">
-						{!! Form::button("<i class='fa fa-check-circle'></i> ".trans('action.update'), 
-						array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
-						<a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('action.cancel') !!}</a>
+				<div class="alert alert-danger">
+					{{ HTML::ul($errors->all()) }}
+				</div>
+			
+
+			<div class="container-fluid">
+				<div class="row">
+					<div class="col-md-12">
+						<!-- For Users to edit their own profiles -->
+						@if(Auth::id() == $user->id || !Entrust::hasRole(Role::getAdminRole()->name))
+						<ul class="nav nav-tabs" role="tablist">
+							<li class="active">
+								<a href="#edit-profile" role="tab" data-toggle="tab">
+									{{trans('messages.edit-profile')}}</a></li>
+							<li>
+								<a href="#change-password" role="tab" data-toggle="tab">
+									{{trans('messages.change-password')}}</a></li>
+						</ul>
+						<br />
+						
+						<div class="tab-content">
+							<div class="tab-pane fade in active" id="edit-profile">
+								{{ Form::model($user, array(
+									'route' => array('user.update', $user->id), 
+									'method' => 'PUT', 'role' => 'form', 'files' => true,
+									'id' => 'form-edit-user'
+								 )) }}
+								<div class="container-fluid">
+									<div class="row">
+										<div class="col-md-8">
+											
+												{{ Form::label('username', trans('messages.username')) }}
+												<p class="form-control-static">{{$user->username}}</p>
+											</div>
+											
+												{{ Form::label('full_name', trans('messages.full-name')) }}
+												{{ Form::text('full_name', $user->name, ["placeholder" => "Jay Siku",
+													'class' => 'form-control']) }}
+											</div>
+											
+												{{ Form::label('email', trans('messages.email-address')) }}
+												{{ Form::email('email', Input::old('email'), 
+													["placeholder" => "j.siku@ilabafrica.ac.ke",
+													'class' => 'form-control']) }}
+											</div>
+											
+												{{ Form::label('designation', trans('messages.designation')) }}
+												{{ Form::text('designation', Input::old('designation'), 
+													["placeholder" => "Lab Technologist", 'class' => 'form-control'])}}
+											</div>
+							                
+							                    {{ Form::label('gender', trans('messages.gender')) }}
+							                    <div>{{ Form::radio('gender', '0', true) }}<span class='input-tag'>
+							                    	{{trans('messages.male')}}</span></div>
+							                    <div>{{ Form::radio('gender', '1', false) }}<span class='input-tag'>
+							                    	{{trans('messages.female')}}</span></div>
+							                </div>
+											@if(Auth::id() != $user->id && Entrust::hasRole(Role::getAdminRole()->name))
+												<!-- For the administrator to reset other users' passwords -->
+								                
+								                	<label for="reset-password"><a class="reset-password" 
+								                		href="javascript:void(0)">{{trans('messages.reset-password')}}
+								                		</label></a>
+													{{ Form::password('reset-password', 
+														['class' => 'form-control reset-password hidden']) }}
+								                </div>
+							                
+							                <div class="form-group actions-row">
+												{{ Form::button('<span class="glyphicon glyphicon-save"></span> '.
+													trans('messages.update'), 
+													['class' => 'btn btn-primary', 'onclick' => 'submit()']) }}
+											</div>
+							            </div>
+										<div class="col-md-4">
+											<div class="profile-photo">
+								                
+								                	{{ Form::label('image', trans('messages.photo')) }}
+								                    {{ Form::file("image") }}
+								                </div>
+								                
+								                	<img class="img-responsive img-thumbnail user-image"
+								                		src="{{ $user->image }}" 
+								                		alt="{{trans('messages.image-alternative')}}"></img>
+								                </div>
+											</div>
+							            </div>
+						            </div>
+					            </div>
+								{{ Form::close() }}
+				            </div>
+							<!-- For users to edit their own passwords -->
+							<div class="tab-pane fade" id="change-password">
+								{{ Form::open(array('route' => array('user.updateOwnPassword', $user->id),
+									 'id' => 'form-edit-password', 'method' => 'PUT')) }}
+								
+									{{ Form::label('current_password', trans('messages.current-password')) }}
+									{{ Form::password('current_password', ['class' => 'form-control']) }}
+									<span class="curr-pwd-empty hidden" >{{trans('messages.field-required')}}</span>
+								</div>
+								
+									{{ Form::label('new_password', trans('messages.new-password')) }}
+									{{ Form::password('new_password', ['class' => 'form-control']) }}
+									<span class="new-pwd-empty hidden" >{{trans('messages.field-required')}}</span>
+								</div>
+								
+									{{ Form::label('new_password_confirmation', trans('messages.repeat-password')) }}
+									{{ Form::password('new_password_confirmation', ['class' => 'form-control']) }}
+									<span class="new-pwdrepeat-empty hidden" >{{trans('messages.field-required')}}</span>
+									<span class="new-pwdmatch-error hidden" >{{trans('messages.password-mismatch')}}</span>
+								</div>
+								<div class="form-group actions-row">
+									<a class="btn btn-primary update-reset-password" href="javascript:void(0);">
+										<span class="glyphicon glyphicon-save"></span>{{trans('messages.update')}}
+									</a>
+								</div>
+								{{ Form::close() }}
+							</div>
+			            </div>
 					</div>
-				</div>				
-		        <div class="col-md-4">
-		            <div class="row">
-		                <div class="col-md-12">
-		                    <div class="thumbnail">
-		                        {!! HTML::image('images/profile1.jpg', trans('terms.no-photo'), array('class'=>'img-responsive img-thumbnail user-image')) !!}
-		                    </div>
-		                </div>
-		                <div class="col-md-8 col-sm-offset-1">
-		                    
-		                        <label>{!! trans('terms.profile-photo') !!}</label>
-		                        {!! Form::file('photo', null, ['class' => 'form-control']) !!}
-		                    </div>
-		                </div>
-		            </div>
 		        </div>
-				{!! Form::close() !!}

-	  	</div>
+		</div>
 	</div>
-</div>
-@endsection	
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/user/index.blade.php b/resources/views/user/index.blade.php
index f4e8927..dc33fe9 100755
--- a/resources/views/user/index.blade.php
+++ b/resources/views/user/index.blade.php
@@ -1,95 +1,77 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-users"></i> {!! trans('menu.access-control') !!}</li>
-            <li class="active"><i class="fa fa-cube"></i> {!! trans_choice('menu.user', 2) !!}</li>
-        </ul>
-    </div>
+<div>
+	<ol class="breadcrumb">
+	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
+	  <li class="active">{{ Lang::choice('messages.user',1) }}</li>
+	</ol>
 </div>
-<div class="conter-wrapper">
-	<div class="row">
-		<div class="col-sm-12">
-			<div class="card">
-				<div class="card-header">
-				    <i class="fa fa-book"></i> {!! trans_choice('menu.user', 2) !!} 
-				    <span>
-					    <a class="btn btn-sm btn-belize-hole" href="{!! url("user/create") !!}" >
-							<i class="fa fa-plus-circle"></i>
-							{!! trans('action.new').' '.trans_choice('menu.user', 1) !!}
+@if (Session::has('message'))
+	<div class="alert alert-info">{{ Session::get('message') }}</div>
+
+<div class="panel panel-primary">
+	<div class="panel-heading ">
+		<span class="glyphicon glyphicon-user"></span>
+		List Users
+		<div class="panel-btn">
+			<a class="btn btn-sm btn-info" href="{{ URL::to("user/create") }}" >
+				<span class="glyphicon glyphicon-plus-sign"></span>
+				{{ trans('messages.new-user') }}
+			</a>
+		</div>
+	</div>
+	<div class="panel-body">
+		<table class="table table-striped table-hover table-condensed search-table">
+			<thead>
+				<tr>
+					<th>{{ trans('messages.username') }}</th>
+					<th>{{ Lang::choice('messages.name',1) }}</th>
+					<th>{{ trans('messages.email') }}</th>
+					<th>{{ trans('messages.gender') }}</th>
+					<th>{{ trans('messages.designation') }}</th>
+					<th>{{ trans('messages.actions') }}</th>
+				</tr>
+			</thead>
+			<tbody>
+			@foreach($users as $user)
+				<tr @if(Session::has('activeuser'))
+                            {{(Session::get('activeuser') == $user->id)?"class='info'":""}}
+                        
+                        >
+
+					<td>{{ $user->username }}</td>
+					<td>{{ $user->name }}</td>
+					<td>{{ $user->email }}</td>
+					<td>{{ ($user->gender == 0) ? "Male":"Female" }}</td>
+					<td>{{ $user->designation }}</td>
+
+					<td>
+
+						<!-- show the user (uses the show method found at GET /user/{id} -->
+						<a class="btn btn-sm btn-success" href="{{ URL::to("user/" . $user->id) }}">
+							<span class="glyphicon glyphicon-eye-open"></span>
+							{{ trans('messages.view') }}
 						</a>
-						<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-							<i class="fa fa-step-backward"></i>
-							{!! trans('action.back') !!}
-						</a>				
-					</span>
-				</div>
-			  	<div class="card-block">	  		
-					@if (Session::has('message'))
-						<div class="alert alert-info">{!! Session::get('message') !!}</div>
-					
-					@if($errors->all())
-		            <div class="alert alert-danger alert-dismissible" role="alert">
-		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
-		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
-		            </div>
-		            
-				 	<table class="table table-bordered table-sm search-table">
-						<thead>
-							<tr>
-								<th>{!! trans('terms.full-name') !!}</th>
-								<th>{!! trans('terms.username') !!}</th>
-								<th>{!! trans('terms.gender') !!}</th>
-								<th>{!! trans('terms.email-address') !!}</th>
-								<th>{!! trans_choice('menu.role', 1) !!}</th>
-								<th></th>
-							</tr>
-						</thead>
-						<tbody>
-						@foreach($users as $key => $value)
-							<tr @if(session()->has('active_user'))
-				                    {!! (session('active_user') == $value->id)?"class='warning'":"" !!}
-				                
-				                >
-								<td>{!! $value->name !!}</td>
-								<td>{!! $value->username !!}</td>
-								<td>{!! ($value->gender == 0) ? "Male":"Female" !!}</td>
-								<td>{!! $value->email !!}</td>
-								<td></td>
-								
-								<td>
 
-								<!-- show the test category (uses the show method found at GET /user/{id} -->
-									<a class="btn btn-sm btn-success" href="{!! url("user/" . $value->id) !!}" >
-										<i class="fa fa-folder-open-o"></i>
-										{!! trans('action.view') !!}
-									</a>
+						<!-- edit this user (uses the edit method found at GET /user/{id}/edit -->
+						<a class="btn btn-sm btn-info" href="{{ URL::to("user/" . $user->id . "/edit") }}" >
+							<span class="glyphicon glyphicon-edit"></span>
+							{{ trans('messages.edit') }}
+						</a>
+						<!-- delete this user (uses the delete method found at GET /user/{id}/delete -->
+						<button class="btn btn-sm btn-danger delete-item-link {{($user == User::getAdminUser()) ? 'disabled': ''}}"
+							data-toggle="modal" data-target=".confirm-delete-modal"	
+							data-id='{{ URL::to("user/" . $user->id . "/delete") }}'>
+							<span class="glyphicon glyphicon-trash"></span>
+							{{ trans('messages.delete') }}
+						</button>
 
-								<!-- edit this test category (uses edit method found at GET /user/{id}/edit -->
-									<a class="btn btn-sm btn-info" href="{!! url("user/" . $value->id . "/edit") !!}" >
-										<i class="fa fa-edit"></i>
-										{!! trans('action.edit') !!}
-									</a>
-									
-								<!-- delete this test category (uses delete method found at GET /user/{id}/delete -->
-									<button class="btn btn-sm btn-danger delete-item-link"
-										data-toggle="modal" data-target=".confirm-delete-modal"	
-										data-id='{!! url("user/" . $value->id . "/delete") !!}'>
-										<i class="fa fa-trash-o"></i>
-										{!! trans('action.delete') !!}
-									</button>
-								</td>
-							</tr>
-						@endforeach
-						</tbody>
-					</table>
-			  	</div>
-			</div>
-		</div>
+					</td>
+				</tr>
+			@endforeach
+			</tbody>
+		</table>
+		{{ Session::put('SOURCE_URL', URL::full()) }}
 	</div>
-	{!! session(['SOURCE_URL' => URL::full()]) !!}
 </div>
-@endsection
\ No newline at end of file
+@stop
\ No newline at end of file
diff --git a/resources/views/user/show.blade.php b/resources/views/user/show.blade.php
index 18af62f..86b69d5 100755
--- a/resources/views/user/show.blade.php
+++ b/resources/views/user/show.blade.php
@@ -1,46 +1,42 @@
-@extends("app")
-
+@extends("layout")
 @section("content")
-<div class="row">
-    <div class="col-sm-12">
-        <ul class="breadcrumb">
-            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
-            <li class="active"><i class="fa fa-users"></i> {!! trans('menu.access-control') !!}</li>
-            <li><a href="{!! route('user.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('menu.user', 2) !!}</a></li>
-            <li class="active">{!! trans('action.view').' '.trans_choice('menu.user', 1) !!}</li>
-        </ul>
-    </div>
-</div>
-<div class="conter-wrapper">
-	<div class="card">
-		<div class="card-header">
-		    <i class="fa fa-file-text"></i> <strong>{!! trans('terms.details-for').': '.$user->name !!}</strong>
-		    <span>
-		    	<a class="btn btn-sm btn-belize-hole" href="{!! url("user/create") !!}" >
-					<i class="fa fa-plus-circle"></i>
-					{!! trans('action.new').' '.trans_choice('menu.user', 1) !!}
-				</a>
-				<a class="btn btn-sm btn-info" href="{!! url("user/" . $user->id . "/edit") !!}" >
-					<i class="fa fa-edit"></i>
-					{!! trans('action.edit') !!}
+	<div>
+		<ol class="breadcrumb">
+		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
+		  <li><a href="{{ URL::route('user.index') }}">{{ Lang::choice('messages.user', 2)}}</a></li>
+		  <li class="active">{{trans('messages.user-details')}}</li>
+		</ol>
+	</div>
+	<div class="panel panel-primary">
+		<div class="panel-heading ">
+			<span class="glyphicon glyphicon-user"></span>
+			{{trans('messages.user-details')}}
+			<div class="panel-btn">
+				<a class="btn btn-sm btn-info" href="{{ URL::to("user/". $user->id ."/edit") }}">
+					<span class="glyphicon glyphicon-edit"></span>
+					{{trans('messages.edit')}}
 				</a>
-				<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
-					<i class="fa fa-step-backward"></i>
-					{!! trans('action.back') !!}
-				</a>				
-			</span>
-		</div>	  		
-		<!-- if there are creation errors, they will show here -->
-		@if($errors->all())
-			<div class="alert alert-danger">
-				{!! HTML::ul($errors->all()) !!}

-		
-
-		<ul class="list-group list-group-flush">
-		    <li class="list-group-item"><h4>{!! trans('terms.name').': ' !!}<small>{!! $user->name !!}</small></h4></li>
-		    <li class="list-group-item"><h5>{!! trans('terms.description').': ' !!}<small>{!! $user->description !!}</small></h5></li>
-	  	</ul>
+		</div>
+		<div class="panel-body">
+			<div class="container-fluid">
+				<div class="row">
+					<div class="col-md-6">
+						<div class="display-details">
+							<h3><strong>{{trans('messages.full-name')}}</strong>{{ $user->name }} </h3>
+							<p><strong>{{trans('messages.username')}}</strong>{{ $user->username }}</p>
+							<p><strong>{{trans('messages.email-address')}}</strong>{{ $user->email }}</p>
+							<p><strong>{{trans('messages.designation')}}</strong>{{ $user->designation }}</p>
+							<p><strong>{{trans('messages.gender')}}</strong>{{ ($user->gender==0?"Male":"Female") }}</p>
+							<p><strong>{{trans('messages.date-created')}}</strong>{{ $user->created_at }}</p>
+						</div>
+					</div>
+					<div class="col-md-6">
+						<img class="img-responsive img-thumbnail user-image" src="{{ $user->image }}" 
+							alt="{{trans('messages.image-alternative')}}"></img>
+					</div>
+				</div>
+			</div>
+		</div>
 	</div>
-</div>
-@endsection	
\ No newline at end of file
+@stop
\ No newline at end of file
