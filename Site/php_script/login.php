<?php

	$HEADER = true;
	$CurrentPath = "/php_script";
	include "../pages/parts/variables.php";

	if(isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['idKey']))
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
				$returnHash = md5($_POST['idKey']);
				mysqli_query($mysqli,"UPDATE TABLE_USER SET TOKEN='" . $returnHash . "' WHERE ID=" . $row['ID']);
				mysqli_close($mysqli);
				echo $returnHash;
			} else {
				echo "0 - Wrong passwd : '" . $row['PASSWD'] . "'";
			}
		} else {
			echo "0 - No data in DB";
		}
	}
	else 
	{
		echo "0 - Missing request parameters";
	}
?>