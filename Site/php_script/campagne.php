<?php
	$HEADER = true;
	$CurrentPath = "/php_script";
	include "../pages/parts/variables.php";
	
	$returnCampagne = "";
	
	if (isset($_POST['idKey']) && strcmp($_POST['action'], 'lister') == 0) {
	
		$mysqli = new mysqli("127.0.0.1", "admin", "", "rba-innophyt", 3306);
		if ($mysqli -> connect_errno) {
			$returnCampagne = '{ "statut": "0", "dataType": "error", "data": "Failed to connect to MySQL: (' . $mysqli -> connect_errno . ') ' . $mysqli -> connect_error . '" }';
		} else {
	
			$query = "SELECT * FROM TABLE_USER WHERE RSA_PRIVE='" . $_POST[idKey] . "'";
			$res = $mysqli -> query($query);
			if ($res) {
				$row = $res -> fetch_assoc();
				if (isset($row['ID'])) {
					$query = "SELECT * FROM TABLE_CAMPAGNE WHERE UTILISATEUR_ID='" . $row['ID'] . "'";
					$campagne = $mysqli -> query($query);
	
					if ($campagne) {
						$returnCampagne = '{ "statut": "1", "dataType": "campagne", "data": { ';
						
						 while ($rowC = $campagne->fetch_assoc()) {
							 $returnCampagne .= '"' . $rowC['ID'] . '": {';
							 $returnCampagne .= '"id": "'           . $rowC['ID'] . '",';
							 $returnCampagne .= '"nom": "'          . $rowC['NOM'] . '",';
							 $returnCampagne .= '"description": "'  . $rowC['DESCRIPTION'] . '",';
							 $returnCampagne .= '"date_debut": "'   . $rowC['DATE_DEBUT'] . '",';
							 $returnCampagne .= '"date_fin": "'     . $rowC['DATE_FIN'] . '",';
							 $returnCampagne .= '"adresse": "'      . $rowC['ADRESSE'] . '",';
							 $returnCampagne .= '"latitude": "'     . $rowC['LATITUDE'] . '",';
							 $returnCampagne .= '"longitude": "'    . $rowC['LONGITUDE'] . '"';
							 $returnCampagne .= '},';
						}
						$returnCampagne .= ' "":"" }, "idKey": "' . $row['RSA_PRIVE'] . '"}';
					} else {
						$returnCampagne = '{ "statut": "0", "dataType": "error", "data": "Aucune campagnes trouvées" }';
					}
				} else {
					$returnCampagne = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l\'identification de l\'utilisateur avec son ID" }';
			}
			} else {
				$returnCampagne = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l\'identification de l\'utilisateur" }';
			}
		}
	} else if (isset($_POST['idKey']) && strcmp($_POST['action'], 'ajouter') == 0) {
	
		$mysqli = new mysqli("127.0.0.1", "admin", "", "rba-innophyt", 3306);
		if ($mysqli -> connect_errno) {
			$returnCampagne = '{ "statut": "0", "dataType": "error", "data": "Failed to connect to MySQL: (' . $mysqli -> connect_errno . ') ' . $mysqli -> connect_error . '" }';
		} else {
	
			$query = "SELECT * FROM TABLE_USER WHERE RSA_PRIVE='" . $_POST[idKey] . "'";
			$res = $mysqli -> query($query);
			if ($res) {
				$row = $res -> fetch_assoc();
				if (isset($row['ID'])) {
	
					if (!($stmt = $mysqli->prepare("INSERT INTO TABLE_CAMPAGNE(UTILISATEUR_ID, NOM, DATE_DEBUT, DATE_FIN, DESCRIPTION) VALUES (?, ?, ?, ?, ?)"))) {
						$returnCampagne = '{ "statut": "0", "dataType": "error", "data": "Echec de la preparation: (' . $mysqli -> connect_errno . ') ' . $mysqli -> connect_error . '" }';
					}
					
					if (!$stmt->bind_param("issss", $row['ID'], $_POST['nom'], $_POST['dateDeb'], $_POST['dateFin'], $_POST['description'])) {
						$returnCampagne = '{ "statut": "0", "dataType": "error", "data": "Echec lors du liage des paramètres: (' . $mysqli -> connect_errno . ') ' . $mysqli -> connect_error . '" }';
					}
					
					if (!$stmt->execute()) {
						$returnCampagne = '{ "statut": "0", "dataType": "error", "data": "Echec lors de l execution: (' . $mysqli -> connect_errno . ') ' . $mysqli -> connect_error . '" }';
					} else {
						//$returnCampagne = '{ "statut": "2", "dataType": "ok", "data": "Campagne ajoutée" , "idKey": "' . $row['RSA_PRIVE'] . '"}';
						header('Location: ' . $CAMPAGNE_URL);
					}
				} else {
					$returnCampagne = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l\'identification de l\'utilisateur avec son ID" }';
				}
			} else {
				$returnCampagne = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l\'identification de l\'utilisateur" }';
			}
		}
	} else if (isset($_POST['idKey']) && strcmp($_POST['action'], 'modifier') == 0 && isset($_POST['id'])) {
	
		$mysqli = new mysqli("127.0.0.1", "admin", "", "rba-innophyt", 3306);
		if ($mysqli -> connect_errno) {
			$returnCampagne = '{ "statut": "0", "dataType": "error", "data": "Failed to connect to MySQL: (' . $mysqli -> connect_errno . ') ' . $mysqli -> connect_error . '" }';
		} else {
	
			$query = "SELECT * FROM TABLE_USER WHERE RSA_PRIVE='" . $_POST[idKey] . "'";
			$res = $mysqli->query($query);
			if ($res) {
				$row = $res->fetch_assoc();
				if (isset($row['ID'])) {
					
					$query = "UPDATE TABLE_CAMPAGNE SET NOM='" . $_POST['nom'] . "', DATE_DEBUT='" . $_POST['dateDeb'] . "', DATE_FIN='" . $_POST['dateFin'] . "', DESCRIPTION='" . $_POST['description'] . "' WHERE ID=" . $_POST['id'];
					
					if (!($stmt = $mysqli->prepare($query))) {
						$returnCampagne = '{ "statut": "0", "dataType": "error", "data": "Echec de la preparation: (' . $mysqli -> connect_errno . ') ' . $mysqli -> connect_error . '" }';
					}
					
					if (!$stmt->execute()) {
						$returnCampagne = '{ "statut": "0", "dataType": "error", "data": "Echec lors de l execution: (' . $mysqli -> connect_errno . ') ' . $mysqli -> connect_error . '" }';
					} else {
						//$returnCampagne = '{ "statut": "2", "dataType": "ok", "data": "Campagne ajoutée" , "idKey": "' . $row['RSA_PRIVE'] . '"}';
						header('Location: ' . $CAMPAGNE_URL);
					}
					
				} else {
					$returnCampagne = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l\'identification de l\'utilisateur avec son ID" }';
			}
			} else {
				$returnCampagne = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l\'identification de l\'utilisateur" }';
			}
		}
	} else {
		$returnCampagne = '{ "statut": "0", "dataType": "error", "data": "Missing request parameters" }';
	}
	
	echo $returnCampagne;
?>