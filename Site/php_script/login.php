<?php

	$HEADER = true;
	$CurrentPath = "/php_script";
	include "../pages/parts/variables.php";

	if(isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['idKey']))
	{
		$mysqli = new mysqli($HOST_DB, $USER_DB, $PASSWORD_DB, $SCHEMA_DB, $PORT_DB);
		if ($mysqli->connect_errno) {
			echo '{ "statut": "0", "dataType": "error", "state": "fail", "data": "Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
			exit();
		}
		
		$query = "SELECT * FROM TABLE_USER WHERE EMAIL='" . $_POST[login] . "'";
		$res = $mysqli->query($query);
		if ($res) {
			$row = $res->fetch_assoc();
			if (strcasecmp($row['PASSWD'], $_POST['pass']) == 0) {
				$returnHash = '{ "statut": "1", "dataType": "ok"';
				if (strcmp($row['TOKEN'], "")) {
					$returnHash .= ', "token": "' . $row['TOKEN'] . '", "auth": "bd"';
				} else {
					$returnHash .= ', "token": "' . md5($_POST['idKey']) . '", "auth": "new"';
					mysqli_query($mysqli,"UPDATE TABLE_USER SET TOKEN='" . md5($_POST['idKey']) . "' WHERE ID=" . $row['ID']);
				}
				$returnHash .= ', "state": "done"}';
				mysqli_close($mysqli);
				echo $returnHash;
			} else {
				echo '{ "statut": "0", "dataType": "error", "state": "fail", "data": "Wrong passwd" }';
			}
		} else {
			echo '{ "statut": "0", "dataType": "error", "state": "fail", "data": "No data in DB" }';
		}
	} elseif (isset($_POST['login']) && isset($_POST['idKey'])) {
		$to      = 'adrien.bataille@icloud.com';
		$subject = 'le sujet';
	    $message = 'Bonjour !';
	    $headers = 'From: webmaster@example.com' . "\r\n" .
	    'Reply-To: webmaster@example.com' . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();
	
	     mail($to, $subject, $message, $headers);
	} else {
		echo "0 - Missing request parameters";
	}
?>