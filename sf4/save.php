<?php
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'))
	die('<h1>Error: Direct Access Denied.</h1>');
define('BASE_C', TRUE);
define('CONN_C', TRUE);
require 'base.php';
require 'connect.php';
if(!loggedin())
	die('<h1>You are not logged in.</h1>');
$user_id = $_SESSION['user_id'];
$bname = addslashes(format($_POST['bname']));
$author = addslashes(format($_POST['author']));
$publisher = addslashes(format($_POST['publisher']));
try
	{    
		$query = "INSERT INTO books VALUES('', '$bname', '$author', '$publisher', 1, 0)";
        $query_run = $conn->prepare($query);
	    if($query_run->execute())
		{
			$data->id = $query_run->lastInsertId();
			$data->note = '<div class="bname">'.$bname.'</div>'.
            '<div class="author">By: '.$author.'</div>'.
            '<div class="publisher">Publisher: '.$publisher.'</div>'.
            '<button type="button" class="delete">Delete</button>';
			$conn = null;
			echo json_encode($data);
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