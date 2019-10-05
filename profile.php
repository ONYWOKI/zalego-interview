<?php

require_once "DB.php";

class profile extends DB{

	function displayInfo(){
		$user = $_SESSION['user'];

		$query = "SELECT * FROM dbase.users WHERE username = '$user'";

		$res = $this->connect()->query($query);

		if($row = mysqli_fetch_row($res)){
			echo "<table id='info'>
				<tr>
					<td>First Name</td>
					<td>".$row[0]."</td>
					<td><button id='fchange'>Change</button></td>
				</tr>
				<tr>
					<td>Last Name</td>
					<td>".$row[1]."</td>
					<td><button id='lchange'>Change</button></td>
				</tr>
				<tr>
					<td>User Name</td>
					<td>".$row[2]."</td>
					<td><button id='uchange'>Change</button></td>
				</tr>
				<tr>
					<td><button id='pchange'>Change Password</button></td>
				</tr>
				";
		}
	}

	function changeFname(){
		$new = $_POST['new'];
		$user = $_SESSION['user'];

		$query = "UPDATE dbase.users SET first_name = '$new' WHERE username = '$user'";
		$this->query($query);
		header("Location:profile.php?suc=First name successfully changed");
	}

	function changeLname(){
		$new = $_POST['new'];
		$user = $_SESSION['user'];

		$query = "UPDATE dbase.users SET last_name = '$new' WHERE username = '$user'";
		$this->query($query);
		header("Location:profile.php?suc=Last name successfully changed");
	}

	function changeUname(){
		$new = $_POST['new'];
		$user = $_SESSION['user'];
		
		$query = "SELECT * FROM dbase.users WHERE username = '$new'";

		$res = $this->query($query);
		if(mysqli_num_rows($res) > 0){
			header("Location:profile.php?err=Username already in use");
		}else{
			$query = "UPDATE dbase.users SET username = '$new' WHERE username = '$user'";
			$this->query($query);
			$_SESSION['user'] = $new;
			header("Location:profile.php?suc=Username successfully changed");

		}

	}

	function changePass(){
		$new = $_POST['new'];
		$user = $_SESSION['user'];
		$old = $_POST['old'];

		$query = "SELECT * FROM dbase.users WHERE username = '$user'";

		$res = $this->query($query);
		if($row = mysqli_fetch_row($res)){
			if($row[3] == $old )
			$query = "UPDATE dbase.users SET password = '$new' WHERE username = '$user'";
			$this->query($query);
			header("Location:profile.php?suc=Password successfully changed");
		}else{
			
			header("Location:profile.php?err=Wrong original password");

		}

		
	}
}

$profile = new profile();

if(isset($_POST['changeFname'])){
	$profile->changeFname();
}

if(isset($_POST['changeLname'])){
	$profile->changeLname();
}

if(isset($_POST['changeUname'])){
	$profile->changeUname();
}

if(isset($_POST['changePass'])){
	$profile->changePass();
}

if(isset($_POST['logout'])){
	session_destroy();
	header("Location:login.php");
}

?>

<html>
`	<head>
		<title>Interview Brian</title>
		<link type="text/css" rel='stylesheet' href='styles.css'>
	</head>
	<header>
		<nav>
			<ul>
				<form action='profile.php' method='post' id='profile'><input type="submit" value='Log Out' name='logout'></form>
			</ul>
		</nav>
	</header>
	<script>
		function check(){
			var pass = document.getElementById('new').value;
			var cpass = document.getElementById('cnew').value;

			if(pass === cpass){
				return true;
			}else{
				alert("Passwords do not match");
				return false;
			}
		}
	</script>
	<center><h1>User Information</h1></center>
	<body class='profile'>
		<?php $profile->displayInfo();?>
		<div id='fname' class='pForms' style='display: none'>
			<form action='profile.php' method='post'>
				<label>Enter new First Name</label><br>
				<input type="text" name='new' required><br>
				<input type="submit" name='changeFname' value='Change' class='btn'>
			</form>
		</div>

		<div id='lname' class='pForms' style='display: none'>
			<form action='profile.php' method='post'>
				<label>Enter new Last Name</label><br>
				<input type="text" name='new' required><br>
				<input type="submit" name='changeLname' value='Change' class='btn'>
			</form>
		</div>

		<div id='uname' class='pForms' style='display: none'>
			<form action='profile.php' method='post'>
				<label>Enter new User Name</label><br>
				<input type="text" name='new' required><br>
				<input type="submit" name='changeUname' value='Change' class='btn'>
			</form>
		</div>

		<div id='pass' class='pForms' style='display: none'>
			<form action='profile.php' method='post' onsubmit="return check()">
				<label>Enter old password</label><br>
				<input type="password" name='old' required><br>
				<label>Enter New password</label><br>
				<input type="password" name='new' required><br>
				<label>Confirm New password</label><br>
				<input type="password" name='cnew' required><br>
				<input type="submit" name='changePass' value='Change' class='btn'>
			</form>
		</div>

	</body>
	<center><?php $profile->report();?></center>
	<script>
		
		var fn = document.getElementById('fchange');
		var ln = document.getElementById('lchange');
		var un = document.getElementById('uchange');
		var p = document.getElementById('pchange');

		var fdiv = document.getElementById('fname');
		var ldiv = document.getElementById('lname');
		var udiv = document.getElementById('uname');
		var pdiv = document.getElementById('pass');

		p.onclick = function(){
			pdiv.style.display = 'block';
			ldiv.style.display = 'none';
			udiv.style.display = 'none';
			fdiv.style.display = 'none';
		}

		fn.onclick = function(){
			pdiv.style.display = 'none';
			ldiv.style.display = 'none';
			udiv.style.display = 'none';
			fdiv.style.display = 'block';
		}

		ln.onclick = function(){
			pdiv.style.display = 'none';
			ldiv.style.display = 'block';
			udiv.style.display = 'none';
			fdiv.style.display = 'none';
		}

		un.onclick = function(){
			pdiv.style.display = 'none';
			ldiv.style.display = 'none';
			udiv.style.display = 'block';
			fdiv.style.display = 'none';
		}

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