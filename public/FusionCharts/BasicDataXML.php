<?php
include 'FusionCharts.php';
?>
<HTML>
    <HEAD>
        <TITLE>FusionCharts - Simple Column 3D Chart</TITLE>
    </HEAD>
    <BODY>
        <?php
        $strXML = "";
        $strXML .= "<chart caption='Monthly Unit Sales' xAxisName='Month' yAxisName='Units' showValues='0' formatNumberScale='0' showBorder='1'>";
        $strXML .= "<set label='Jan' value='462' />";
        $strXML .= "<set label='Feb' value='857' />";
        $strXML .= "<set label='Mar' value='671' />";
        $strXML .= "<set label='Apr' value='494' />";
        $strXML .= "<set label='May' value='761' />";
        $strXML .= " <set label='Jun' value='960' />";
        $strXML .= "<set label='Jul' value='629' />";
        $strXML .= "<set label='Aug' value='622' />";
        $strXML .= "<set label='Sep' value='376' />";
        $strXML .= "<set label='Oct' value='494' />";
        $strXML .= "<set label='Nov' value='761' />";
        $strXML .= "<set label='Dec' value='960' />";
        $strXML .= "</chart>";

        echo renderChartHTML("Column3D.swf", "", $strXML, "dave", 600, 300, FALSE);

        /* $browsers = array("Firefox","IE","Opera");
          echo "<select>";
          foreach ($browsers as $browser){
          echo "<option name='$browser'>$browser</option>";
          }//end foreach
          echo "</select>"; */

        ?>
    </BODY>
</HTML>