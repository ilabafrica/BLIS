@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li><a href="{{ URL::route('user.index') }}">{{Lang::choice('messages.user', 2)}}</a></li>
		  <li class="active">{{trans('messages.user-details')}}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			{{trans('messages.user-details')}}
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::to("user/". $user->id ."/edit") }}">
					<span class="glyphicon glyphicon-edit"></span>
					{{trans('messages.edit')}}
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6">
						<div class="display-details">
							<h3><strong>{{trans('messages.full-name')}}</strong>{{ $user->name }} </h3>
							<p><strong>{{trans('messages.username')}}</strong>{{ $user->username }}</p>
							<p><strong>{{trans('messages.email-address')}}</strong>{{ $user->email }}</p>
							<p><strong>{{trans('messages.designation')}}</strong>{{ $user->designation }}</p>
							<p><strong>{{trans('messages.gender')}}</strong>{{ ($user->gender==0?"Male":"Female") }}</p>
							<p><strong>{{trans('messages.date-created')}}</strong>{{ $user->created_at }}</p>
						</div>
					</div>
					<div class="col-md-6">
						<img class="img-responsive img-thumbnail user-image" src="{{ $user->image }}" 
							alt="{{trans('messages.image-alternative')}}"></img>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop