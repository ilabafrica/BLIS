@extends("layout")
@section("content")
<br />
<div>
  <ol class="breadcrumb">
    <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
    <li class="active">{{Lang::choice('messages.county',2)}}</li>
  </ol>
</div>
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.create-county', '2') }}</div>
    <div class="panel-body">
        <div class="col-lg-6 main">
            <!-- Begin form --> 
            @if($errors->all())
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                {{ HTML::ul($errors->all(), array('class'=>'list-unstyled')) }}
            </div>
            @endif
            {{ Form::open(array('route' => 'county.store', 'id' => 'form-add-county', 'class' => 'form-horizontal')) }}
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                <!-- ./ csrf token -->
                <div class="form-group">
                    {{ Form::label('name', Lang::choice('messages.name', 1), array('class' => 'col-sm-4 control-label')) }}
                    <div class="col-sm-8">
                        {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('country_id', Lang::choice('messages.country', 1), array('class' => 'col-sm-4 control-label')) }}
                    <div class="col-sm-8">
                        {{ Form::select('country_id', array(''=>trans('messages.select-country'))+$countries,'', 
                            array('class' => 'form-control', 'id' => 'country_id')) }}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                    {{ Form::button("<i class='glyphicon glyphicon-ok-circle'></i> ".Lang::choice('messages.save', 1), 
                          array('class' => 'btn btn-success', 'onclick' => 'submit()')) }}
                          {{ Form::button("<i class='glyphicon glyphicon-remove-circle'></i> ".'Reset', 
                          array('class' => 'btn btn-default', 'onclick' => 'reset()')) }}
                    <a href="#" class="btn btn-s-md btn-warning"><i class="glyphicon glyphicon-ban-circle"></i> {{ Lang::choice('messages.cancel', 1) }}</a>
                    </div>
                </div>
            {{ Form::close() }} 
            <!-- End form -->
        </div> 
    </div>
</div>
@stop