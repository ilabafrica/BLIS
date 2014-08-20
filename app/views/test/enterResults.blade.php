@extends("layout")
@section("content")
    <div>
        <ol class="breadcrumb">
          <li><a href="{{{URL::route('user.home')}}}">Home</a></li>
          <li><a href="{{ URL::route('test.index') }}">Test</a></li>
          <li class="active">Enter Results</li>
        </ol>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading ">
            <span class="glyphicon glyphicon-user"></span>
            Enter Results
        </div>
        <div class="panel-body">
        <!-- if there are creation errors, they will show here -->
            
            @if($errors->all())
                <div class="alert alert-danger">
                    {{ HTML::ul($errors->all()) }}
                </div>
            @endif
            {{ Form::open(array('url' => 'test/'.$testId.'/saveresults', 'method' => 'GET', 'id' => 'form-enter-results')) }}
                <div class="form-group">
                    {{ Form::label('result', $testType) }}
                    {{ Form::text('result', Input::old('result'), 
                        array('class' => 'form-control')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('interpretation', 'Result Interpretation') }}
                    {{ Form::text('interpretation', Input::old('interpretation'), array('class' => 'form-control')) }}
                </div>
                <div class="form-group actions-row">
                    {{ Form::submit('Save',['class' => 'btn btn-primary',]) }}
                </div>
            {{ Form::close() }}
        </div>
    </div>
@stop