<?php
define('INDEX', TRUE);
define('BASE_C', TRUE);
define('CONN_C', TRUE);
require 'base.php';
if(loggedin())
{
	if($_SESSION['type'] == "admin")
		include 'home_admin.php';
	else if($_SESSION['type'] == "user")
		include 'home_user.php';
}
else
	include 'log_in.php';
?>