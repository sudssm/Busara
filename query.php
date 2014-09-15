<?php
// NOTE - VERY INSECURE. NOT TO BE RUN ANYWHERE BUT LOCALHOST
$query = $_POST['query'];
// Connecting, selecting database
$link = mysql_connect('localhost', 'root', '')
    or die('Could not connect: ' . mysql_error());
mysql_select_db('busara') or die('Could not select database');

// Performing SQL query
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$rows = array();
while($r = mysql_fetch_array($result)) {
    $rows[] = $r;
}

// Free resultset
mysql_free_result($result);

// Closing connection
mysql_close($link);

print json_encode($rows);

?>