<?php
if(!defined('INDEX'))
	header('Location: index.php');
require 'connect.php';
$uname = $pword = $unameErr = $pwordErr = '';
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$uname = format($_POST["uname"]);
	$pword = format($_POST["pword"]);
    if(empty($uname))
    {
		$unameErr = 'Userame is required.';
	}
    if(empty($pword))
	{
		$pwordErr = 'Password is required.';
	}	
	if(!empty($uname) && !empty($pword))
	{
		try
		{
			$query = 'SELECT user_id, type, password FROM users WHERE username = :uname';
            $query_run = $conn->prepare($query);
	        $query_run->bindParam(':uname',$uname);
	        $query_run->execute();
			if($query_run->rowCount() == 0)
			{
				$unameErr = 'Username does not exist.';
			}
			else if(($data = $query_run->fetch(PDO::FETCH_OBJ))&&(password_verify($pword, $data->password)))
			{
				$_SESSION['user_id'] = $data->user_id;
				$_SESSION['type'] = $data->type;
				$conn = null;
				header('Location: index.php');
			}
			else 
			{
			     $pwordErr = 'Incorrect password.';
			}
		}
	    catch(PDOException $e)
		{
	        die('<h1>Connection failed!</h1>');
		}	
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<title> Log in
</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="icon" href="lib.png" sizes="any">
<meta name="viewport" content="width=device-width,initial-scale=1.0" />
</head>
<body>
<div class="formBox">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
Username:<br />
<input type="text" name="uname" maxlength=30 value="<?php echo $uname; ?>" /><br />
<?php
if(!empty($unameErr))
echo '<div class="err">'.$unameErr.'</div>';	
?>
<br />Password:<br />
<input type="password" name="pword" /><br />
<?php
if(!empty($pwordErr))
echo '<div class="err">'.$pwordErr.'</div>';	
?>
<br /><button class="fButton" type="submit" >Log in</button><br /><br />
<small>
Don't have a account? <a href="sign_up.php" class="fLink">Sign up</a>
</small>
</form>
</div>
</body>
</html>