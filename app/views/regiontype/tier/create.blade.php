@extends("layout")
@section("content")
<br />
<div>
  <ol class="breadcrumb">
    <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
    <li class="active">{{Lang::choice('messages.region-type',2)}}</li>
  </ol>
</div>


<div class="panel panel-primary">
        <div class="panel-heading ">
            <span class="glyphicon glyphicon-adjust"></span>
            {{trans('messages.create-region-type')}}
        </div>
        <div class="panel-body">
        <!-- if there are creation errors, they will show here -->
            @if($errors->all())
                <div class="alert alert-danger">
                    {{ HTML::ul($errors->all()) }}
                </div>
            @endif

            {{ Form::open(array('route' => 'regiontypetier.store', 'id' => 'form-add-regiontypetier')) }}
                {{ Form::hidden('tier_id', $region_type_id) }}
                <div class="form-group">
                    {{ Form::label('name', Lang::choice('messages.name',2)) }}
                    {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
                </div>
                <div class="form-group actions-row">
                    {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
                        array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
                </div>

            {{ Form::close() }}
        </div>
    </div>

@stop