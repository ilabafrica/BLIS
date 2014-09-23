{{--*/ $test_types = TestType::all() /*--}}
{{--*/ $test_statuses = TestStatus::all() /*--}}
?>
<chart palette='2' caption='Test Counts Comparison' shownames='1' showvalues='0' decimals='0' numberPrefix='$' useRoundEdges='1' legendBorderAlpha='0'>
<categories>
{{--*/ $months_names = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec") /*--}} 
@foreach ($test_types as $key => $test_type) {
	$test_type_month = date_parse_from_format("Y-m-d", $test_type->time_created);
<category label='{{ $months_names[$test_type_month['month']-1] }}' /></categories>
<dataset seriesName='Completed' color='607142' showValues='0'>

@foreach ($test_types as $key => $test_type) {
	$count_completed = Test::whereIn('test_status_id', function($query)
												    $query->select('id')
												    ->from(with(new TestStatus)->getTable())
												    ->whereIn('name', ['Completed', 'Verified'])
												    ->where('test_type_id', $test_type->id);
												})->count();
												<set value='{{ $count_completed }}' />
												
@endforeach
</dataset>
<dataset seriesName='Pending' color='8EAC41' showValues='0'>
@foreach ($test_types as $key => $test_type)
	$count_pending = Test::whereIn('test_status_id', function($query){
												    $query->select('id')
												    ->from(with(new TestStatus)->getTable())
												    ->whereIn('name', ['Pending', 'Started'])
												    ->where('test_type_id', $test_type->id);
												})->count();
												<set value='{{ $count_pending }}' />
												
@endforeach
</dataset>
}
</chart>