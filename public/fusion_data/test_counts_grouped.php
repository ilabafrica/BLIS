<?php
include('DBConn.php');
$link = connectToDB();
$monthnames=array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
if(!isset($_GET['parameters'])){
	$result = date('Y');
	$sql_months = "SELECT DISTINCT MONTH(time_created) as month, YEAR(time_created) as year FROM tests ORDER BY month ASC;";
	$sql_result_months = mysql_query($sql_months) or die(mysql_error());
	$months = array();
	$years = array();
	$counter = 0;
	while($month = mysql_fetch_assoc($sql_result_months)){
		$months[$counter] = $month['month'];
		$years[$counter] =  $month['year'];
		//echo $monthnames[$months[$counter]-1];
		$counter++;
	}

	//$strXML will be used to store the entire XML document generated
	//Generate the chart element
		?>
	<chart palette='2' caption='Test Counts Comparison' shownames='1' showvalues='0' decimals='0' numberPrefix='' numberSuffix='' useRoundEdges='1' legendBorderAlpha='0'>
    <categories>
    <?php
	$x=0;
	foreach($months as $dist_month){
		?>
		<category label='<?php echo $monthnames[$dist_month-1] ." ".$years[$x]; ?>' />
        <?php
		$x++;
	}
	?>
    </categories>
    <dataset seriesName='Completed' color='607142' showValues='0'>
    <?php
	$x=0;
	foreach($months as $dist_month){
		$sql_get_data = "SELECT COUNT(*) AS total_count FROM tests WHERE MONTH(time_created) = $dist_month AND YEAR(time_created)=$result AND test_status_id IN(SELECT id FROM test_statuses WHERE name='Completed' OR name='Verified');";
		//echo $sql_get_data;
		$sql_result_get_data = mysql_query($sql_get_data) or die(mysql_error());
		$get_data_resultset = mysql_fetch_assoc($sql_result_get_data);
		$total = $get_data_resultset['total_count']; 
		//echo $distributed;
		?>
		<set value='<?php echo $total; ?>' />
		<?php
			//free the resultset
			//mysql_free_result($get_data_resultset);
			//echo $monthnames[1]."  ".$distributed.'<br />';
			$x++;
	}
	?>
    </dataset>
    <dataset seriesName='Pending' color='8EAC41' showValues='0'>
    <?php
	$x=0;
	foreach($months as $dist_month){
		$sql_get_data = "SELECT COUNT(*) AS total_count FROM tests WHERE MONTH(time_created) = $dist_month AND YEAR(time_created)=$result AND test_status_id IN(SELECT id FROM test_statuses WHERE name='Pending' OR name='Started');";
		//echo $sql_get_data;
		$sql_result_get_data = mysql_query($sql_get_data) or die(mysql_error());
		$get_data_resultset = mysql_fetch_assoc($sql_result_get_data);
		$total = $get_data_resultset['total_count']; 
		//echo $distributed;
		?>
		<set value='<?php echo $total; ?>' />
		<?php
			$x++;
	}
	?>
    </dataset>
</chart>
<?php
}
?>