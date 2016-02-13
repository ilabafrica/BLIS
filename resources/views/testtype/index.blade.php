@extends("app")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('menu.home') !!}</a></li>
            <li class="active"><i class="fa fa-database"></i> {!! trans('menu.test-catalog') !!}</li>
            <li class="active"><i class="fa fa-cube"></i> {!! trans_choice('menu.test-type', 2) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
				    <i class="fa fa-book"></i> {!! trans_choice('menu.test-type', 2) !!} 
				    <span>
					    <a class="btn btn-sm btn-belize-hole" href="{!! url("testtype/create") !!}" >
							<i class="fa fa-plus-circle"></i>
							{!! trans('action.new').' '.trans_choice('menu.test-type', 1) !!}
						</a>
						<a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
							<i class="fa fa-step-backward"></i>
							{!! trans('action.back') !!}
						</a>				
					</span>
				</div>
			  	<div class="card-block">	  		
					@if (Session::has('message'))
						<div class="alert alert-info">{!! Session::get('message') !!}</div>
					@endif
					@if($errors->all())
		            <div class="alert alert-danger alert-dismissible" role="alert">
		                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('action.close') !!}</span></button>
		                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
		            </div>
		            @endif
				 	<table class="table table-bordered table-sm search-table">
						<thead>
							<tr>
								<th>{!! trans('general-terms.name') !!}</th>
								<th>{!! trans('general-terms.description') !!}</th>
								<th>{!! trans('general-terms.target-tat') !!}</th>
								<th>{!! trans('general-terms.prevalence-threshold') !!}</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						@foreach($testtypes as $key => $value)
							<tr @if(session()->has('active_testtype'))
				                    {!! (session('active_testtype') == $value->id)?"class='warning'":"" !!}
				                @endif
				                >
								<td>{!! $value->name !!}</td>
								<td>{!! $value->description !!}</td>
								<td>{!! $value->targetTAT !!}</td>
								<td>{!! $value->prevalence_threshold !!}</td>
								
								<td>

								<!-- show the test category (uses the show method found at GET /test-type/{id} -->
									<a class="btn btn-sm btn-success" href="{!! url("testtype/" . $value->id) !!}" >
										<i class="fa fa-folder-open-o"></i>
										{!! trans('action.view') !!}
									</a>

								<!-- edit this test category (uses edit method found at GET /test-type/{id}/edit -->
									<a class="btn btn-sm btn-info" href="{!! url("testtype/" . $value->id . "/edit") !!}" >
										<i class="fa fa-edit"></i>
										{!! trans('action.edit') !!}
									</a>
									
								<!-- delete this test category (uses delete method found at GET /test-type/{id}/delete -->
									<button class="btn btn-sm btn-danger delete-item-link"
										data-toggle="modal" data-target=".confirm-delete-modal"	
										data-id='{!! url("testtype/" . $value->id . "/delete") !!}'>
										<i class="fa fa-trash-o"></i>
										{!! trans('action.delete') !!}
									</button>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
			  	</div>
			</div>
		</div>
	</div>
	{!! session(['SOURCE_URL' => URL::full()]) !!}
</div>
@endsection