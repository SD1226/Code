<?php
if(!defined('INDEX'))
	header('Location: index.php');
require 'connect.php';
try
	{
		$list = array();
		$i = 0;
		$user_id = $_SESSION['user_id'];
		$query = 'SELECT name FROM users WHERE user_id = :user_id';
        $query_run = $conn->prepare($query);
	    $query_run->bindParam(':user_id',$user_id);
	    $query_run->execute();
	    $data = $query_run->fetch(PDO::FETCH_OBJ);
		$name = $data->name;
		$query = 'SELECT book_id, bookname, author, publisher, status, user_id FROM books';
		$query_run = $conn->prepare($query);
	    $query_run->execute();
	    while($data = $query_run->fetch(PDO::FETCH_OBJ))
		{
			$list[$i] = 
			array('book_id'=>$data->book_id, 'bookname'=>$data->bookname, 'author'=>$data->author, 
			'publisher'=>$data->publisher, 'status'=>$data->status, 'user_id'=>$data->user_id);
		    $i++;
		}
		$conn = null;
	}
catch(PDOException $e)
	{
	    die('<h1>Connection failed!</h1>');
	}	
?>
<!DOCTYPE html>
<html>
<head>
<title>HOME
</title>
<link rel="stylesheet" type="text/css" href="style2.css" />
<link rel="icon" href="lib.png" sizes="any">
<meta name="viewport" content="width=device-width,initial-scale=1.0" />
</head>
<body>
    <div id="header">
		<img src="dd.png" id="dd" />
        Library Portal
	</div>
<div id="content">
<?php 
$j = 0;
while($j < $i)
{
	if($list[$j]['status'] == 1)
	{
		echo '<div class="book">'.
		'<div class="bname">'. $list[$j]['bookname'].'</div>'.
        '<div class="author">By: '. $list[$j]['author'].'</div>'.
        '<div class="publisher">Publisher: '. $list[$j]['publisher'].'</div>'.
        '<button type="button" class="issue">Issue</button>'.
        '</div>';
	}
	else
	{
		if($list[$j]['user_id'] == $user_id)
		{
			echo '<div class="book">'.
		    '<div class="bname">'. $list[$j]['bookname'].'</div>'.
			'<div class="author">By: '. $list[$j]['author'].'</div>'.
            '<div class="publisher">Publisher: '. $list[$j]['publisher'].'</div>'.
            '<button type="button" class="return">Return</button>'.
            '</div>';
		}
		else
	    {
			echo '<div class="book">'.
		    '<div class="bname">'. $list[$j]['bookname'].'</div>'.
			'<div class="author">By: '. $list[$j]['author'].'</div>'.
            '<div class="publisher">Publisher: '. $list[$j]['publisher'].'</div>'.
            '<button type="button" class="issued">Issued</button>'.
            '</div>';
		}	
	}
	$j++;
}
?>
</div>
<div id="dBar">
    <span id="user">Welcome <?php echo $name; ?></span><br />
	<span id="mybooks">My Books</span><br />
    <a href="edit_profile.php">Edit Profile</a><br />
    <a href='log_out.php'>Log out</a>
</div>
</body>
<script>
var ids = [];
var state = [];
<?php
$j = 0;
while($j < $i)
{
	echo 'ids['.$j.'] = '.$list[$j]['book_id'].';';
	echo 'state['.$j.'] = '.$list[$j]['status'].';';
	$j++;
}
echo 'var uid = '.$_SESSION['user_id'].';';
?>
</script>
<script src="jquery-3.3.1.min.js"></script>
<script src="script_user.js"></script>
</html>