<?php

require_once "DB.php";

class register extends DB{

	function insert($fname,$lname,$uname,$pass){
		connect()->query("INSERT INTO dbase.users values('$fname','$lname','$uname','pass')");
	}

	function registerU(){
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$uname = $_POST['uname'];
		$pass = $_POST['pass'];

		$query = "SELECT * FROM dbase.users WHERE username = $uname";

		$res = $this->query($query);
		if(mysqli_num_rows($res) > 0){
			header("Location:index.php?err=Username already in use");
		}else{
			$query = "INSERT INTO dbase.users VALUES ('$fname', '$lname', '$uname', '$pass')";
			$this->query($query);
			header("Location:index.php?suc=Successfully Registered");
		}
	}

}

	$reg = new register();

	if(isset($_POST['register'])){
		$reg->registerU();
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
	<script>
		function check(){
			var pass = document.getElementById('pass').value;
			var cpass = document.getElementById('cpass').value;

			if(pass === cpass){
				return true;
			}else{
				alert("Passwords do not match");
				return false;
			}
		}
	</script>
	<body class='form'>
		<form action='index.php' method='post' onsubmit="return check()">
			<center><h1>Register</h1></center>
			<table>
				<tr>
					<td><label>First Name</label></td>
					<td><input type="text" name='fname' required="true"></td>
				</tr>
				<tr>
					<td><label>Last Name</label></td>
					<td><input type="text" name='lname' required="true"></td>
				</tr>
				<tr>
					<td><label>User Name</label></td>
					<td><input type="text" name='uname' required="true"></td>
				</tr>
				<tr>
					<td><label>Password</label></td>
					<td><input type="password" name='pass' required="true" id='pass'></td>
				</tr>
				<tr>
					<td><label>Confirm Password</label></td>
					<td><input type="password" name='confirm' required="true" id='cpass'></td>
				</tr>
				<tr>
					<td colspan="2">
						<center><input type="submit" name='register' value='Register' class='btn'></center>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<center><?php  $reg->report();?></center>
					</td>
				</tr>
				
			</table>
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