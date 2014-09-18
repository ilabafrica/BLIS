<?php
$link = mysql_connect('192.168.1.2:80', 'root', '');
if(!$link){
    die("No link");
}//end if
echo "Link";
mysql_close($link);
?>
