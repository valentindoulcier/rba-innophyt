<?php
	if(isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['idKey']))
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
				$returnHash = md5($_POST['idKey']);
				mysqli_query($mysqli,"UPDATE TABLE_User SET RSA_PRIVE='" . $returnHash . "' WHERE ID=" . $row['ID']);
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