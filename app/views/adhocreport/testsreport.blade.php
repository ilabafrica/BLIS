<h3>Tests report</h3>
<table class="table table-striped table-bordered">
		  	<tbody>
		  		<tr>
				@foreach($testColumns as $testColumn)
				
					  @if($testColumn['name']==Lang::choice('messages.test-type', 2))
		  			<th rowspan="2">{{Lang::choice('messages.test-type',2)}}</th>
					  @endif
					  @if($testColumn['name']==Lang::choice('messages.gender', 2))
		  			<th rowspan="2">{{trans('messages.gender')}}</th>
					  @endif
					  @if($testColumn['name']==Lang::choice('messages.age-ranges', 2))
		  			<th colspan="{{ count($ageRanges) }}">{{trans('messages.age-ranges')}}</th>
					  @endif
					  @if($testColumn['name']==Lang::choice('messages.total-tests', 2))
		  			<th rowspan="2">{{trans('messages.total-tests')}}</th>
					  @endif
					
				@endforeach
				@forelse($statusColumns as $statusColumn)
					<th rowspan="2">{{$statusColumn['name']}}</th>
					@empty

					@endforelse
		  		</tr>
				  <tr>
				  
				  @foreach($testColumns as $testColumn)
				 @if($testColumn['name']==Lang::choice('messages.age-ranges', 2))
				  @foreach($ageRanges as $ageRange)
		  				<th>{{ $ageRange }}</th>
		  			@endforeach
				  </tr>
				   @endif
				   @endforeach
		  		
		  		@foreach($testType as $testType)
		  		<tr>
				  @foreach($testColumns as $testColumn)
				  	@if($testColumn['name']==Lang::choice('messages.test-type', 2))
			  		<td>{{ $testType->name }}</td>
					  @endif
					@if($testColumn['name']==Lang::choice('messages.gender', 2))
			  		<td>@foreach($gender as $sex)
			  				{{ $sex["name"]}}<br />
			  			@endforeach</td>
					  @endif
					@if($testColumn['name']==Lang::choice('messages.age-ranges', 2))
					@foreach($ageRanges as $ageRange)
					<td>
							
							@if($genderCount>1)
							{{ $perAgeRange[$testType->id][$ageRange]["male"] }}
							<br />
							{{ $perAgeRange[$testType->id][$ageRange]["female"] }}<br />
							@else
							@foreach($gender as $sex)
							@if($sex["name"]=='Male')
							{{ $perAgeRange[$testType->id][$ageRange]["male"] }}<br />
							@else
							{{ $perAgeRange[$testType->id][$ageRange]["female"] }}<br />
							@endif
							@endforeach
							@endif
							
						</td>
						@endforeach
					@endif
					@if($testColumn['name']==Lang::choice('messages.total-tests', 2))
					<td>{{ $perTestType[$testType->id]['countAll'] }}</td>
					@endif
					
				@endforeach
				@forelse($statusColumns as $statusColumn)
				 @foreach($perStatus[$testType->id] as $status)
				 @if($statusColumn['name']==$status['name'])
				<td>{{$status['count']}}</td>
				@endif
				@endforeach
				@empty
				<td>No Values</td>
				@endforelse
			  	</tr>
				  @endforeach  		
		  	</tbody>
		  </table>
		 
		  