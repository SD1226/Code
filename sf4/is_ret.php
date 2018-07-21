<?php
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'))
	die('<h1>Error: Direct Access Denied.</h1>');
define('BASE_C', TRUE);
define('CONN_C', TRUE);
require 'base.php';
require 'connect.php';
if(!loggedin())
	die('<h1>You are not logged in.</h1>');
$book_id = $_POST['book_id'];
$status = $_POST['new_status'];
$uid = $_POST['uid'];
try
	{    
		$query = "UPDATE books SET status = '$status', user_id = '$uid' WHERE book_id = :id";
        $query_run = $conn->prepare($query);
		$query_run->bindParam(':id',$book_id);
	    if($query_run->execute())
		{
			$conn = null;
			echo true;
		}
		else
		{
			$conn = null;
			echo false;
		}
	}
catch(PDOException $e)
	{
		die(false);
	}
?>