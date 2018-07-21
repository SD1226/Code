<?php
if(!defined('BASE_C'))
	die('<h1>Direct Access Denied.</h1>');
session_start();
ob_start();
function loggedin()
{
	if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
		return true;
	else
		return false;
}
function format($data)
{
	return htmlspecialchars(stripslashes(trim($data)));
}
?>