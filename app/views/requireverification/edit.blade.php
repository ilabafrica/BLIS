@extends("layout")
@section("content")
    <div>
    	<ol class="breadcrumb">
            <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
            <li class="active">{{ trans('messages.require-verification') }}</li>
    	</ol>
    </div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
@if($errors->all())
    <div class="alert alert-danger">
        {{ HTML::ul($errors->all()) }}
    </div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.require-verification') }}
	</div>
	<div class="panel-body">
		{{ Form::model($requireVerification, array('route' => array('requireverification.update'),
		  	'method' => 'PUT', 'id' => 'form-edit-require-verification')) }}
			<div class="form-group">
				{{ Form::label('requireVerification', trans('messages.require-verification-to-send')) }}
                <?php $periodChecked = ($requireVerification->verification_required) ? true : false ; ?>
                {{ Form::checkbox('verify', "1", $periodChecked, array('onclick'=>'toggle(".periodClass", this)')) }}
            </div>
            <div class="form-group periodClass"
				<?php if ($periodChecked) { ?>style="dispaly:block;"<?php }
				else { ?>style="display:none;"<?php }
				 ?>>
                {{ Form::label('period', trans('messages.specify-period')) }}
                <div class="form-pane panel panel-default">
                    <div class="container-fluid">
                        <div class='row'>
                            <div class='col-md-6 restrictionClass'
                            <?php if ($restrictVerification) { ?>style="dispaly:block;"<?php }
                            else { ?>style="display:none;"<?php }
                             ?>>
                                <div class='col-md-2'>
                                    {{ Form::label('time_from', trans('messages.from')) }}
                                </div>
                                <div class='col-md-10'>
                                    <input id="timepickerfrom" name="time_from"
                                        value="<?php echo $requireVerification->verification_required_from; ?>"type="text" class="form-control">
                                    <i class="icon-time"></i>
                                </div>
                            </div>
                            <div class='col-md-6 restrictionClass'
                                <?php if ($restrictVerification) { ?>style="dispaly:block;"<?php }
                                else { ?>style="display:none;"<?php }
                                 ?>>
                                <div class='col-md-2'>
                                    {{ Form::label('time_to', trans('messages.to')) }}
                                </div>
                                <div class='col-md-10'>
                                    <input id="timepickerto" name="time_to"
                                        value="<?php echo $requireVerification->verification_required_to; ?>"type="text" class="form-control">
                                    <i class="icon-time"></i>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                {{ Form::label('always', trans('messages.twenty-four-hours')) }}
                            </div>
                            <div class='col-md-10'>
                                <div class="form-group">
                                    <?php $restrictionChecked = ($restrictVerification) ? false : true ; ?>
                                    {{ Form::checkbox('always', "1", $restrictionChecked, array('onclick'=>'toggleInverse(".restrictionClass ", this)')) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group actions-row">
                {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
                    array('class' => 'btn btn-primary', 'onclick' => 'submit()')) }}
            </div>
        {{ Form::close() }}
	</div>
</div>
@stop
