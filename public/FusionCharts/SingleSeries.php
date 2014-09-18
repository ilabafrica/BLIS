<?php
//We've included ../Includes/FusionCharts.php, which contains functions
//to help us easily embed the charts.
include("FusionCharts.php");
?>
<HTML>
    <HEAD>
        <TITLE> FusionCharts - Array Example using Single Series Column 3D Chart</TITLE>
        <SCRIPT LANGUAGE="Javascript" SRC="FusionCharts.js"></SCRIPT>
    </HEAD>
    <BODY>
        <?php
        //In this example, we plot a single series chart from data contained
        //in an array. The array will have two columns - first one for data label
        //and the next one for data values.
        //Let's store the sales data for 6 products in our array). We also store
        //the name of products.
        //Store Name of Products
        $arrData[0][1] = "Product A";
        $arrData[1][1] = "Product B";
        $arrData[2][1] = "Product C";
        $arrData[3][1] = "Product D";
        $arrData[4][1] = "Product E";
        $arrData[5][1] = "Product F";

        //Store sales data
        $arrData[0][2] = 567500;
        $arrData[1][2] = 815300;
        $arrData[2][2] = 556800;
        $arrData[3][2] = 734500;
        $arrData[4][2] = 676800;
        $arrData[5][2] = 648500;

        $arrData[0][3] = 56760;
        $arrData[1][3] = 81600;
        $arrData[2][3] = 55600;
        $arrData[3][3] = 73600;
        $arrData[4][3] = 67800;
        $arrData[5][3] = 64400;

        
        $strXML = "<chart caption='Sales by Product' numberPrefix='$' formatNumberScale='1' rotateValues='1' placeValuesInside='1' decimals='0'>";

        $strCategories = "<categories>";

        $strDataCurr = "<dataset seriesName='Current Year'>";
        $strDataPrev = "<dataset seriesName='Previous Year'>";

        foreach ($arrData as $arSubData) {
            $strCategories .= "<category name='" . $arSubData[1] . "'/>";
            $strDataCurr .= "<set value='" . $arSubData[2] . "' label='" . $arSubData[2] . "'/>";
            $strDataPrev .= "<set value='" . $arSubData[3] . "' label='" . $arSubData[3] . "'/>";
        }

        $strCategories .= "</categories>";

        $strDataCurr .= "</dataset>";
        $strDataPrev .= "</dataset>";
        
        $strXML .= $strCategories .= $strDataCurr .= $strDataPrev . "</chart>";

        //Create the chart - Column 3D Chart with data contained in strXML
        echo renderChart("StackedColumn3D.swf", "", $strXML, "productSales", 600, 300, false, false);
        ?>
    </BODY>
</HTML>