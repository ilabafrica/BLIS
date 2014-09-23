<?php
/*Begin Function to connect to DB*/ 
function connectToDB( $dbName="" ) {
    // These four parameters must be changed dependent on your MySQL settings
    $hostdb = 'localhost';   // MySQl host
    $userdb = 'root';    // MySQL username
    $passdb = 'Admin123';    // MySQL password
    $namedb =  $dbName ? $dbName : 'iblis'; // MySQL database name

    $link = mysql_connect ($hostdb, $userdb, $passdb);

    if (!$link) {
        // we should have connected, but if any of the above parameters
        // are incorrect or we can't access the DB for some reason,
        // then we will stop execution here
        die('Could not connect: ' . mysql_error());
    }

    $db_selected = mysql_select_db($namedb);
    if (!$db_selected) {
        die ('Can\'t use database : ' . mysql_error());
    }
    return $link;
}
/*End Function*/
?>