<?php
	$HEADER = true;
	$CurrentPath = "/php_script";
	require_once("../pages/parts/variables.php");
	
	$returnItem = "";
	
	if (strcmp($_POST['action'], 'lister') == 0) {
			
		$mysqli = new mysqli($HOST_DB, $USER_DB, $PASSWORD_DB, $SCHEMA_DB, $PORT_DB);
		if ($mysqli->connect_errno) {
			$returnItem = '{ "statut": "0", "dataType": "error", "data": "Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
		} else {
		
			$query = "SELECT * FROM TABLE_USER";
			$res = $mysqli->query($query);
			if ($res) {
				$returnItem = '{ "statut": "1", "dataType": "user", "data": { ';
				while($row = $res->fetch_assoc()) {
					$returnItem .= '"' . $row['ID'] . '": {';
					$returnItem .= '"id":"' . $row['ID'] . '",';
					$returnItem .= '"nom":"' . $row['NOM'] . '",';
					$returnItem .= '"admin":"' . $row['ADMIN'] . '",';
					$returnItem .= '"mail":"' . $row['EMAIL'] . '",';
					$returnItem .= '"ip_min":"' . $row['IP_LB'] . '",';
					$returnItem .= '"ip_max":"' . $row['IP_UB'] . '"';
					$returnItem .= '},';
				}
				$returnItem .= ' "":"" }, "idKey": "' . $_POST['idKey'] . '"}';
				
			} else {
				$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l\'identification de l\'utilisateur" }';
			}
		}
	} else if (isset($_POST['idKey']) && strcmp($_POST['action'], 'supprimer') == 0 && isset($_POST['id'])) {
			
		$mysqli = new mysqli($HOST_DB, $USER_DB, $PASSWORD_DB, $SCHEMA_DB, $PORT_DB);
		if ($mysqli->connect_errno) {
			$returnItem = '{ "statut": "0", "dataType": "error", "data": "Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
		} else {
		
			$query = "SELECT * FROM TABLE_USER WHERE TOKEN='" . $_POST[idKey] . "'";
			$res = $mysqli->query($query);
			if ($res) {
				$row = $res->fetch_assoc();
				if (isset($row['ID'])) {
					
					$query = "DELETE FROM TABLE_USER WHERE ID=" . $_POST['id'];
					
					if (!($stmt = $mysqli->prepare($query))) {
						$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec de la preparation: (' . $mysqli -> connect_errno . ') ' . $mysqli -> connect_error . '" }';
					}
					
					if (!$stmt->execute()) {
						$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec lors de l execution: (' . $mysqli -> connect_errno . ') ' . $mysqli -> connect_error . '" }';
					} else {
						$returnItem = '{ "statut": "2", "dataType": "ok", "data": "Utilsateur supprimé" , "idKey": "' . $row['TOKEN'] . '"}';
					}
					
				} else {
					$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l\'identification de l\'utilisateur avec son ID" }';
				}
			} else {
				$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l\'identification de l\'utilisateur" }';
			}
		}
	}  else {
		$returnItem = '{ "statut": "0", "dataType": "error", "data": "Missing request parameters" }';
		//header('Location: ' . $PIEGE_URL . '?statut=0&dataType=error&data=Missing request parameters');
		//var_dump($_POST);
	}
	
	echo $returnItem;
?>