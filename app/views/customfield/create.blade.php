@extends("layout")
@section("content")

    <div>
        <ol class="breadcrumb">
          <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
          <li class="active"><a href="{{ URL::route('customfield.index') }}">Custom Fields</a></li>
          <li class="active">Add Custom Fields</li>
        </ol>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading ">
            <span class="glyphicon glyphicon-adjust"></span>
            Add Custom Fields
        </div>
        <div class="panel-body">
        <!-- if there are creation errors, they will show here -->
            @if($errors->all())
                <div class="alert alert-danger">
                    {{ HTML::ul($errors->all()) }}
                </div>
            @endif

            {{ Form::open(array('route' => 'customfield.store', 'id' => 'form-add-customfields')) }}

                <div class="form-group">
                    {{ Form::label('name', Lang::choice('messages.name',1)) }}
                    {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
                </div>
                <div class="form-group">
                {{ Form::label('label', 'Label') }}
                {{ Form::text('label', Input::old('label'), array('class' => 'form-control')) }}
                </div>
                <div class="form-group">
                {{ Form::label('customfieldtype', 'Custom Field Type') }}
                {{ Form::select('customfieldtype', $customfieldTypes, Input::old('customfieldtype->id'), array('class' => 'form-control')) }}
                </div>
                <div class="form-group actions-row">
                    {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
                        array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
                </div>

            {{ Form::close() }}
        </div>
    </div>
@stop