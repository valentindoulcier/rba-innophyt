<?php
	if(isset($_POST['nom']) && isset($_POST['description']) && isset($_POST['datedeb']) && isset($_POST['datefin']))
	{
		$mysqli = new mysqli("127.0.0.1", "admin", "", "rba-innophyt", 3306);
		if ($mysqli->connect_errno) {
			echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
			exit();
		}
		
		$query = "SELECT * FROM TABLE_Campagne WHERE nom='" . $_POST[nom] . "'";
		$res = $mysqli->query($query);
		if ($res) {
			$row = $res->fetch_assoc();
			
			mysqli_query($mysqli,"UPDATE TABLE_User SET RSA_PRIVE='" . $returnHash . "' WHERE ID=" . $row['ID']);
			mysqli_close($mysqli);
			echo $return1;
		} else {
			echo "0 - No data in DB";
		}
	}
	else 
	{
		echo "0 - Missing request parameters";
	}
?>