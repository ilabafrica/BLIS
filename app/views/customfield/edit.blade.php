@extends("layout")
@section("content")

    <div>
        <ol class="breadcrumb">
        <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
        <li class="active">Custom Field</li>
        </ol>
    </div>
    @if (Session::has('message'))
        <div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
    @endif
    <div class="panel panel-primary">
        <div class="panel-heading ">
            <span class="glyphicon glyphicon-edit"></span>
           Edit Custom Field
        </div>
        <div class="panel-body">
            @if($errors->all())
                <div class="alert alert-danger">
                    {{ HTML::ul($errors->all()) }}
                </div>
            @endif
            {{ Form::model($customField, array('route' => array('customfield.update', $customField->id),
                'method' => 'PUT', 'id' => 'form-edit-customfield')) }}
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
                    {{ Form::button('<span class="glyphicon glyphicon-save"></span> '. trans('messages.save'),
                        ['class' => 'btn btn-primary', 'onclick' => 'submit()']) }}
                </div>
            {{ Form::close() }}
        </div>
    </div>
@stop