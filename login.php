<?php

require_once "DB.php";

class log_in extends DB{
	function logInU(){
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		$query = "SELECT * FROM users WHERE username = '$user'";
		echo $user;
		$res = $this->query($query);

		if($row = mysqli_fetch_row($res)){
			if($row[3] == $pass){
				@session_start();
				$_SESSION['user'] = $user;
				echo "<script>window.open('profile.php','_self');</script>";
			}else{
				echo "<script>window.open('login.php?err=Wrong username or password','_self');</script>";
			}
		}else{
			echo "<script>window.open('login.php?err=Wrong username or password','_self');</script>";
		}
		
	}
}
$login = new log_in();

if(isset($_POST['login_s'])){
	$login->logInU();
}
	

?>
<html>
	<head>
		<title>Interview</title>
		<link type="text/css" rel='stylesheet' href='styles.css'>
	</head>
	<header>
		<?php include "header.php";?>
	</header>
	<body class='form'>

		<form action="login.php" method='post'>
			<h1><center>Log In</center></h1>
			<center>
			<label>Username</label><br>
			<input type="text" name='user' required><br>
			<label>Password</label><br>
			<input type="password" name='pass' required><br>
			<input type="submit" name="login_s" value='Log In' class='btn'>
			<?php $login->report()?>
			</center>
		</form>
	</body>
	<script type="text/javascript">
		setTimeout(function(){
			try{
				document.getElementById('error').innerHTML = "";
			}catch(err){}

			try{
				document.getElementById('success').innerHTML = "";
			}catch(err){}

		},5000);
	</script>
</html>