<?php
@session_start();
class DB{
	function connect(){
		$dbase = "dbase";
		$username = "root";
		$pass = "";
		$host = "localhost";

		try {
			$conn = mysqli_connect($dbase, $username, $host, $pass);
			return connect;

			
		} catch (Exception $e) {
			echo "Could not connect to database";
			return null;
			
		}
	}
	function report(){
		if (isset($_GET['err'])) {
			
		}
	}
	function query(){

		$host = "localhost";
		$username = "root";
		$pass = "";
		$dbase = "dbase";

		$conn = mysql_connect($host, $username, $pass, 	$dbase );
		$result = mysql_query($query, $conn);
		return $result();
	}
}

?>