<?php
	if(isset($_POST['login']) && isset($_POST['pass']))
	{
		$mysqli = new mysqli("127.0.0.1", "admin", "", "rba-innophyt", 3306);
		if ($mysqli->connect_errno) {
			echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
			exit();
		}
		
		$query = "SELECT * FROM TABLE_User WHERE EMAIL='" . $_POST[login] . "'";
		$res = $mysqli->query($query);
		if ($res) {
			$row = $res->fetch_assoc();
			if (strcasecmp($row['PASSWD'], $_POST['pass']) == 0) {
				echo $row['RSA_PRIVE'];
				mysqli_close($mysqli);
			} else {
				echo "0 - Wrong passwd : '" . $row['PASSWD'] . "'";
			}
		} else {
			echo "0 - No data in DB";
		}
	}
	else 
	{
		echo "0 - Missing request parameters : login -> " . isset($_POST['login']) . ", pass -> " . isset($_POST['pass']);
	}
?>