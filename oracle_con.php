<?php

//oracle database address
$db ='(DESCRIPTION=
(ADDRESS_LIST = 
(ADDRESS = (PROTOCOL = TCP)(HOST = 203.249.87.57)(PORT = 1521)))
(CONNECT_DATA = (SID = orcl)))';


//enter user name & password

$username = "S10_501";
$password = "pw1234";

// connect with oracle db
$connect = oci_connect($username, $password, $db,'AL32UTF8');

// oracle db connection error message
if(!$connect){
    echo "접속 실패<BR>";
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
?>