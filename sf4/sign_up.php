<?php
define('BASE_C', TRUE);
define('CONN_C', TRUE);
require 'base.php';
require 'connect.php';
if(loggedin())
{
	header('Location: index.php');
}
$name = $uname = $gender = $dob = $email = $pword = $cword = $type = ''; 
$nameErr = $unameErr = $genderErr = $dobErr = $emailErr = $pwordErr = $cwordErr = $typeErr = '';
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$name = format($_POST["name"]);
	$uname = format($_POST["uname"]);
	if(isset($_POST["gender"]))
		$gender = format($_POST["gender"]);
	else
		$gender = '';
	if(isset($_POST["type"]))
		$type = format($_POST["type"]);
	else
		$type = '';	
	$dob = format($_POST["dob"]);
	$email = format($_POST["email"]);
	$pword = format($_POST["pword"]);
	$cword = format($_POST["cword"]);
	$ctr = 0;
    if(empty($name))
    {
		$nameErr = 'Name is required.';
		$ctr++;
	}
	else if(!preg_match("/^[a-zA-Z ]*$/",$name))
	{
		$nameErr = 'Only letters and whitespaces allowed.';
		$ctr++;
	}
	if(empty($uname))
	{
		$unameErr = 'Username is required.';
	}
	else
	{
		try
		{
			$query = 'SELECT username FROM users WHERE username = :uname';
            $query_run = $conn->prepare($query);
	        $query_run->bindParam(':uname',$uname);
	        $query_run->execute();
			if($query_run->rowCount() == 1)
			{
				$unameErr = 'Username already exists.';
				$ctr++;
			}
		}
		catch(PDOException $e)
		{
			die('Connection failed!');
		}
	}
	if(empty($gender))
	{
		$genderErr = 'Gender is required.';
		$ctr++;
	}
	if(empty($type))
	{
		$typeErr = 'Type is required.';
		$ctr++;
	}
	if(empty($dob))
	{
		$dobErr = 'Date of Birth is required.';
		$ctr++;
	}
	if(empty($email))
	{
		$emailErr = 'E-mail Id is required.';
		$ctr++;
	}
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$emailErr = 'Invalid email format.';
		$ctr++;
	}
    if(empty($pword))
	{
		$pwordErr = 'Password is required.';
		$ctr++;
	}
	else if(strlen($pword)<8)
	{
		$pwordErr = 'Password must contain at least 8 characters.';
		$ctr++;
	}
	if(empty($cword))
	{
		$cwordErr = 'Confirm your password.';
		$ctr++;
	}
	else if($cword != $pword)
	{
		$cwordErr = 'Passwords do not match.' ;
		$ctr++;
	}
	if($ctr == 0)
	{
		try
		{
			$pword_hash = password_hash($pword ,PASSWORD_DEFAULT);
			$query = "INSERT INTO users VALUES('', '$name', '$uname', '$email', '$gender', '$dob', '$type', '$pword_hash')";
            $query_run = $conn->prepare($query);
	        if($query_run->execute())
			{
				$conn = null;
				header('Location: index.php');
			}
			else
			{
				$conn = null;
				die('<h1>Could not sign up.</h1>');
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
<title> Sign up
</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="icon" href="lib.png" sizes="any">
<meta name="viewport" content="width=device-width,initial-scale=1.0" />
</head>
<body>
<div class="formBox">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
Name:<br />
<input type="text" name="name" maxlength=30 value="<?php echo $name; ?>" /><br />
<?php
if(!empty($nameErr))
echo '<div class="err">'.$nameErr.'</div>';	
?>
<br />Username:<br />
<input type="text" name="uname" maxlength=30 value="<?php echo $uname; ?>" /><br />
<?php
if(!empty($unameErr))
echo '<div class="err">'.$unameErr.'</div>';	
?>
<br />Type:<br />
User <input type="radio" name="type" value="user" <?php if($type == 'user') echo 'checked'; ?> /><br />
Administrator <input type="radio" name="type" value="admin" <?php if($type == 'admin') echo 'checked'; ?> /><br />
<?php
if(!empty($typeErr))
echo '<div class="err">'.$typeErr.'</div>';	
?>
<br />Gender:<br />
Male <input type="radio" name="gender" value="male" <?php if($gender == 'male') echo 'checked'; ?> /><br />
Female <input type="radio" name="gender" value="female" <?php if($gender == 'female') echo 'checked'; ?> /><br />
<?php
if(!empty($genderErr))
echo '<div class="err">'.$genderErr.'</div>';	
?>
<br />Date of Birth:<br />
<input type="date" name="dob" min="1990-01-01" max="2005-12-31" value="<?php echo $dob; ?>" /><br />
<?php
if(!empty($dobErr))
echo '<div class="err">'.$dobErr.'</div>';	
?>
<br />E-mail id:<br />
<input type="text" name="email" maxlength=30 value="<?php echo $email; ?>" /><br />
<?php
if(!empty($emailErr))
echo '<div class="err">'.$emailErr.'</div>';	
?>
<br />Password (at least 8 characters):<br />
<input type="password" name="pword" /><br />
<?php
if(!empty($pwordErr))
echo '<div class="err">'.$pwordErr.'</div>';	
?>
<br />Confirm Password:<br />
<input type="password" name="cword" /><br />
<?php
if(!empty($cwordErr))
echo '<div class="err">'.$cwordErr.'</div>';	
?>
<br />
<button class="fButton" type="submit" >Sign up</button><br /><br />
<small>Already have an account? <a href="index.php" class="fLink">Log in</a></small>
</form>
</div>
</body>
</html>
