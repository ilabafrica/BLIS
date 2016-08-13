@extends("layout")
@section("content")
<br />
<div>
  <ol class="breadcrumb">
    <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
    <li class="active">{{Lang::choice('messages.region',2)}}</li>
  </ol>
</div>


<div class="panel panel-primary">
        <div class="panel-heading ">
            <span class="glyphicon glyphicon-adjust"></span>
            {{trans('messages.create-region')}}
        </div>
        <div class="panel-body">
        <!-- if there are creation errors, they will show here -->
            @if($errors->all())
                <div class="alert alert-danger">
                    {{ HTML::ul($errors->all()) }}
                </div>
            @endif

            {{ Form::open(array('route' => 'region.store', 'id' => 'form-add-Region')) }}

                <div class="form-group">
                    {{ Form::label('name', Lang::choice('messages.name',2)) }}
                    {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('regiontype_id', Lang::choice('messages.region-type', 2)) }}
                    {{ Form::select('regiontype_id', array(''=>trans('messages.select-region-type'))+$regionTypes,'', 
                            array('class' => 'form-control', 'id' => 'regiontype_id')) }}
                </div>
                <div class="form-group actions-row">
                    {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
                        array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
                </div>

            {{ Form::close() }}
        </div>
    </div>

@stop