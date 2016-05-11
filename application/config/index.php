<?php

// Create connection to Oracle
$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 100.90.103.110)(PORT = 1521)))(CONNECT_DATA=(SID=orcl)))" ;
$conn = oci_connect("scott", "tiger", $db);
if (!$conn) {
   $m = oci_error();
   echo $m['message'], "\n";
   exit;
}
else {
   print "Connected to Oracle Database using OCI!";
}

// Close the Oracle connection
oci_close($conn);

?>
