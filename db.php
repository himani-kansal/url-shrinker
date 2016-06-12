<?php

//mysql db connection information
$hostname = "localhost"; //host
$database = "urlshortener"; //database
$username = "root"; //username for your database
$password = ""; //password for your database

$site = mysql_connect($hostname, $username, $password); 
mysql_select_db($database, $site);
//

$server_name = "http://".$_SERVER['HTTP_HOST']."/";

?>