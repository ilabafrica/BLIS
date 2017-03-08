<h3>Speciments report</h3>
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
		  		
		  		@foreach($specimenTypes as $specimenType)
		  		<tr>
				  @forelse($testColumns as $testColumn)
				  	@if($testColumn['name']==Lang::choice('messages.test-type', 2))
			  		<td>{{ $specimenType->name }}</td>
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
							{{ $perAgeRange[$specimenType->id][$ageRange]["male"] }}
							<br />
							{{ $perAgeRange[$specimenType->id][$ageRange]["female"] }}<br />
							@else
							@foreach($gender as $sex)
							@if($sex["name"]=='Male')
							{{ $perAgeRange[$specimenType->id][$ageRange]["male"] }}<br />
							@else
							{{ $perAgeRange[$specimenType->id][$ageRange]["female"] }}<br />
							@endif
							@endforeach
							@endif
							
						</td>
						@endforeach
					@endif
					@if($testColumn['name']==Lang::choice('messages.total-tests', 2))
					<td>{{ $perSpecimenType[$specimenType->id]['countAll'] }}</td>
					@endif
				@empty
			  	<tr>
			  		<td>{{ trans('messages.no-records-found') }}</td>
			  	</tr>
			  	@endforelse
			  	</tr>  	
				  @endforeach	
		  	</tbody>
		  </table>
		 
		  