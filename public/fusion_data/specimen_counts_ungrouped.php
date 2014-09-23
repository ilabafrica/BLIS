<?php
include('DBConn.php');
$link = connectToDB();
if(!isset($_GET['parameters'])){
	$sql_specimens_query = "SELECT id, name from specimen_types;";
	$sql_specimens_result = mysql_query($sql_specimens_query) or die(mysql_error());
	$names = array();
	$ids = array();
	$counter = 0;
	while($specimen_types = mysql_fetch_assoc($sql_specimens_result)){
		$ids[$counter] = $specimen_types['id'];
		$names[$counter] =  $specimen_types['name'];
		//echo $monthnames[$months[$counter]-1];
		$counter++;
	}

	//$strXML will be used to store the entire XML document generated
	//Generate the chart element
		?>
	<chart caption="Specimen Count" subcaption="Accepted/Rejected" showvalues="0" numberprefix="" plotspacepercent="50" plotgradientcolor="" plotborderalpha="0" canvasbordercolor="#6E98AA" canvasborderalpha="25" canvasborderthickness="1" bgalpha="0" alternatehgridalpha="0" numbersuffix="B" divlinecolor="#6E98AA" basefontcolor="#6E98AA" legendbordercolor="#6E98AA" legendshadow="0" divlinealpha="25" tooltipbordercolor="#6E98AA" bordercolor="#6E98AA" legendborderalpha="30" palettecolors="#02295B,#FCB63C,#A8B1B8" showborder="0">
    <categories>
    <?php
	$x=0;
	foreach($names as $specimen_type){
		?>
		<category label='<?php echo $specimen_type; ?>' />
        <?php
		$x++;
	}
	?>
    </categories>
    <dataset seriesName='Accepted' showValues='0'>
    <?php
	$x=0;
	foreach($ids as $id){
		$sql_get_data = "SELECT COUNT(*) AS total_count FROM specimens WHERE specimen_type_id=$id AND specimen_status_id IN(SELECT id FROM specimen_statuses WHERE name='Accepted');";
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
    <dataset seriesName='Rejected' showValues='0'>
    <?php
	$x=0;
	foreach($ids as $id){
		$sql_get_data = "SELECT COUNT(*) AS total_count FROM specimens WHERE specimen_type_id=$id AND specimen_status_id IN(SELECT id FROM specimen_statuses WHERE name='Rejected');";
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