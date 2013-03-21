<?php

	$HEADER = true;
	$CurrentPath = "/php_script";
	include "../pages/parts/variables.php";
	
	if(isset($_POST['login']) && isset($_POST['pass']))
	{
		$mysqli = new mysqli($HOST_DB, $USER_DB, $PASSWORD_DB, $SCHEMA_DB, $PORT_DB);
		if ($mysqli->connect_errno) {
			echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
			exit();
		}
		
		$query = "SELECT * FROM TABLE_USER WHERE EMAIL='" . $_POST[login] . "'";
		$res = $mysqli->query($query);
		if ($res) {
			$row = $res->fetch_assoc();
			if (strcasecmp($row['PASSWD'], $_POST['pass']) == 0) {
				echo '{ "token": "' . $row['TOKEN'] . '", "admin": "' . $row['ADMIN'] . '" }';
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