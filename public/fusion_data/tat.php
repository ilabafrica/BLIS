<?php 
include("DBConn.php");
$link = connectToDB();
/*Functions to calsulate TAT*/
/**
 * Function to return target turnaround time
 *
 */
public static function targetTurnAroundTime($id=null)
{
	if($id!=null){
		$test_types_query = mysql_query("SELECT id, name FROM test_types;") or die("Error ".mysql_error());
		$test_types_rs = mysql_fetch_assoc($test_types_query);
		foreach ($test_types_rs as $test_type) {
			# code...
		}
	$target_tat_query = mysql_query("SELECT ")
	return TestType::select(DB::raw('targetTAT'))
                 ->where('id', '=', $id)
                 ->get();
    }
    else{
    	$target_tat_query = mysql_query("SELECT targetTAT as tat FROM test_types WHERE id=$id") or die("Error ".mysql_error());
    	$target_tat_rs = mysql_fetch_assoc($target_tat_query);
    	$target_tat = $target_tat['tat'];
    }
}

/**
 * Function to return waiting time
 *
 */
public static function waitingTime($id)
{
	$total_test_count = Test::select(DB::raw(' COUNT( id ), GROUP BY test_type_id'))
                 	->where('test_type_id', '=', $id)
    				->get();
    $tests = Test::where('test_type_id', '=', $id);
    $total_waiting_time = 0.00;
    foreach ($tests as $key => $test) {
    	$waiting_time = $test->time_started - $test->specimen->time_accepted;
    	$total_waiting_time+=$waiting_time;
    }
    return $total_waiting_time/$total_test_count;
}

/**
 * Function to return actual turnaround time
 *
 */
public static function actualTurnAroundTime($id)
{
	$total_test_count = Test::select(DB::raw(' COUNT( id ), GROUP BY test_type_id'))
                 	->where('test_type_id', '=', $id)
    				->get();
    $tests = Test::where('test_type_id', '=', $id);
    $total_actual_tat = 0.00;
    foreach ($tests as $key => $test) {
    	$actual_tat = $test->time_completed - $test->time_started;
    	$total_actual_tat+=$actual_tat;
    }
    return $total_actual_tat/$total_test_count;
}
/*End TAT Functions*/
if(!isset($_GET['year'])){
	$year = date('Y');
}
else{
	$year = $_GET['year'];
}
//echo $year;
$monthnames=array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
$sql_months = "select distinct MONTH(time_created) as month from tests WHERE YEAR(time_created) = $year order by month asc;";
$sql_result_months = mysql_query($sql_months) or die(mysql_error());
$months = array();
$counter = 0;
while($month = mysql_fetch_assoc($sql_result_months)){
	$months[$counter] = $month['month'];
	$counter++;
}

$sql_test_types_query = "SELECT tt.id as id, tt.name as name FROM test_types tt, testtype_measures ttm, measures m WHERE tt.id = ttm.test_type_id AND ttm.measure_id=m.id AND m.measure_range LIKE '%Positive/Negative%';";
$sql_test_types_result = mysql_query($sql_test_types_query) or die("Error ".mysql_error());
$test_types = array();
while($test_type = mysql_fetch_assoc($sql_test_types_result)){
	$test_types[$test_type['id']] = $test_type['name'];
}
?>

<chart caption='Prevalence Rate' subcaption='By Test Type' lineThickness='1' showValues='0' formatNumberScale='0'  divLineAlpha='20' divLineColor='CC3300' divLineIsDashed='1' showAlternateHGridColor='1' alternateHGridAlpha='5' alternateHGridColor='CC3300' shadowAlpha='40'   numvdivlines='5'   bgColor='#ffffff' showBorder='0' bgAngle='270' bgAlpha='10,10' xAxisName='Months' yAxisName='Stoves Distributed'>
<categories >

<?php 
foreach($months as $month){?>
	<category label='<?php echo $monthnames[$month-1];?>' />
<?php }
?>
</categories>

<?php 
$counter = 0;
$test_type_ids = array_keys($fieldofficers);
foreach($test_types as $test_type){echo $test_type;?>
	<dataset seriesName='<?php echo $test_type;?>' >
<?php 
	foreach($months as $month){
		$sql_get_data = "SELECT COUNT(*) as prevalence FROM tests WHERE test_type_id=$test_type_ids[$counter] AND MONTH(time_created)=$month;";
	
		$sql_result_get_data = mysql_query($sql_get_data) or die("Error ".mysql_error());
		$get_data_resultset = mysql_fetch_assoc($sql_result_get_data);
		$prevalence = $get_data_resultset['prevalence']; 
		?>
		<set value='<?php echo $prevalence;?>' />
	<?php }?>
	</dataset>
	<?php 
	$counter++;
}

?>
	<styles>                
		<definition>
                         
			<style name='CaptionFont' type='font' size='12' />
		</definition>
		<application>

			<apply toObject='CAPTION' styles='CaptionFont' />
			<apply toObject='SUBCAPTION' styles='CaptionFont' />
		</application>
	</styles>

</chart>
