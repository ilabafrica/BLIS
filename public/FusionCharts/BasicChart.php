<?php
include 'FusionCharts.php';
?>	
	<HTML>
   <HEAD>
      <TITLE>FusionCharts - Simple Column 3D Chart</TITLE>
   </HEAD>
   <BODY>
   <?php
      //Create the chart - Column 3D Chart with data from Data/Data.xml
      echo renderChartHTML("Column3D.swf", "Data.xml", "", "myFirst", 600, 300, false);
   ?>
   </BODY>
</HTML>
