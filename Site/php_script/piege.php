<?php
	$HEADER = true;
	$CurrentPath = "/php_script";
	require_once("../pages/parts/variables.php");
	
	$returnItem = "";
	
	if (isset($_POST['idKey']) && isset($_POST['parcelleId']) && strcmp($_POST['action'], 'lister') == 0) { // Fait en requête ajax, pas besoin de header pour redirection de la page et des infos
	
		$mysqli = new mysqli($HOST_DB, $USER_DB, $PASSWORD_DB, $SCHEMA_DB, $PORT_DB);
		if ($mysqli->connect_errno) {
			$returnItem = '{ "statut": "0", "dataType": "error", "data": "Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
		} else {
	
			$query = "SELECT * FROM TABLE_USER WHERE TOKEN='" . $_POST[idKey] . "'";
			$res = $mysqli->query($query);
			if ($res) {
				$row = $res->fetch_assoc();
				if (isset($row['ID'])) {
					$query = "SELECT * FROM TABLE_PIEGE WHERE PARCEL_ID='" . $_POST['parcelleId'] . "'";
					$item = $mysqli->query($query);
	
					if ($item) {
						$returnItem = '{ "statut": "1", "dataType": "parcelle", "data": { ';
						
						 while ($rowC = $item->fetch_assoc()) {
							 $returnItem .= '"' . $rowC['ID'] . '": {';
							 $returnItem .= '"id": "'           . html_entity_decode($rowC['ID']) . '",';
							 $returnItem .= '"nom": "'          . html_entity_decode(str_replace("\'", "&#39;", $rowC['NOM'])) . '",';
							 $returnItem .= '"description": "'  . html_entity_decode(str_replace("\'", "&#39;", $rowC['DESCRIPTION'])) . '",';
							 $returnItem .= '"date_debut": "'   . html_entity_decode($rowC['DATE_DEBUT']) . '",';
							 $returnItem .= '"date_fin": "'     . html_entity_decode($rowC['DATE_FIN']) . '",';
							 $returnItem .= '"adresse": "'      . html_entity_decode($rowC['ADRESSE']) . '",';
							 $returnItem .= '"latitude": "'     . html_entity_decode($rowC['LATITUDE']) . '",';
							 $returnItem .= '"longitude": "'    . html_entity_decode($rowC['LONGITUDE']) . '"';
							 $returnItem .= '},';
						}
						$returnItem .= ' "":"" }, "idKey": "' . $row['TOKEN'] . '"}';
					} else {
						//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Aucuns pièges trouves" }';
						$returnItem = '{ "statut": "1", "dataType": "parcelle", "data": {}, "idKey": "' . $row['TOKEN'] . '"}';
					}
				} else {
					$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l\'identification de l\'utilisateur avec son ID" }';
				}
			} else {
				$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l\'identification de l\'utilisateur" }';
			}
		}
	} else if (isset($_POST['idKey']) && isset($_POST['parcelleId']) && strcmp($_POST['action'], 'ajouter') == 0 && isset($_POST['nom']) && isset($_POST['prefixepiege'])) {
		$ERROR = false;
		//var_dump($_POST);
		if (strcmp($_POST['nom'], '') == 0) {
			$ERROR = true;
			header('Location: ' . $PIEGE_URL . '?statut=0&dataType=error&data=Le champ nom ne peut pas être vide&action=ajouter&field={"prefixe": "' . $_POST['prefixepiege'] . '", "nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
		}
		if (isset($_POST['dateDeb']) && strcmp($_POST['dateDeb'], '') && !$ERROR) {
			$date = explode('-', $_POST['dateDeb']);
			if (sizeof($date) != 3 || intval($date[0]) < 2000 || intval($date[0]) > 2100 || intval($date[1]) < 1 || intval($date[1]) > 12 || intval($date[2]) < 1 || intval($date[2]) > 31 ) {
				$ERROR = true;
				header('Location: ' . $PIEGE_URL . '?statut=0&dataType=error&data=La date de début est incorrecte&action=ajouter&field={"prefixe": "' . $_POST['prefixepiege'] . '", "nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
			}
		} else {
			$_POST['dateDeb'] = date("Y-m-d");
		}
		if (isset($_POST['dateFin']) && strcmp($_POST['dateFin'], '') && !$ERROR) {
			$date = explode('-', $_POST['dateFin']);
			if (sizeof($date) != 3 || intval($date[0]) < 2000 || intval($date[0]) > 2100 || intval($date[1]) < 1 || intval($date[1]) > 12 || intval($date[2]) < 1 || intval($date[2]) > 31 ) {
				$ERROR = true;
				header('Location: ' . $PIEGE_URL . '?statut=0&dataType=error&data=La date de fin est incorrecte&action=ajouter&field={"prefixe": "' . $_POST['prefixepiege'] . '", "nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
			}
		} else {
			$_POST['dateFin'] = date("Y-m-d", mktime(0, 0, 0, date("m") + 1, date("d"), date("Y")));
		}
		
		if (!$ERROR) {
	
			$mysqli = new mysqli($HOST_DB, $USER_DB, $PASSWORD_DB, $SCHEMA_DB, $PORT_DB);
			if ($mysqli->connect_errno) {
				//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
				header('Location: ' . $PIEGE_URL . '?statut=0&dataType=error&data=Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '&action=ajouter&field={"prefixe": "' . $_POST['prefixepiege'] . '", "nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
			} else {
		
				$query = "SELECT * FROM TABLE_USER WHERE TOKEN='" . $_POST[idKey] . "'";
				$res = $mysqli->query($query);
				if ($res) {
					$row = $res->fetch_assoc();
					if (isset($row['ID'])) {
		
						if (!($stmt = $mysqli->prepare("INSERT INTO TABLE_PIEGE(PARCEL_ID, NOM, DATE_DEBUT, DATE_FIN, ADRESSE, LATITUDE, LONGITUDE, DESCRIPTION) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"))) {
							//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec de la preparation de la requete: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
							header('Location: ' . $PIEGE_URL . '?statut=0&dataType=error&data=Echec de la preparation de la requete: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '&action=ajouter&field={"prefixe": "' . $_POST['prefixepiege'] . '", "nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
						}
						
						if (!$stmt->bind_param("isssssss", $_POST['parcelleId'], htmlentities($_POST['prefixepiege'] . $_POST['nom']), htmlentities($_POST['dateDeb']), htmlentities($_POST['dateFin']), htmlentities($_POST['adresse']), htmlentities($_POST['latitude']), htmlentities($_POST['longitude']), htmlentities($_POST['description']))) {
							//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec lors du liage des paramètres: (' . $mysqli->connect_errno . ') ' . $mysqli-connect_error . '" }';
							header('Location: ' . $PIEGE_URL . '?statut=0&dataType=error&data=Echec lors du liage des parametres: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '&action=ajouter&field={"prefixe": "' . $_POST['prefixepiege'] . '", "nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
						}
						
						if (!$stmt->execute()) {
							//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec lors de l execution: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
							header('Location: ' . $PIEGE_URL . '?statut=0&dataType=error&data=Saisie invalide (nom non unique)&action=ajouter&field={"prefixe": "' . $_POST['prefixepiege'] . '", "nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
						} else {
							//$returnItem = '{ "statut": "2", "dataType": "ok", "data": "Campagne ajoutée" , "idKey": "' . $row['RSA_PRIVE'] . '"}';
							header('Location: ' . $PIEGE_URL);
						}
					} else {
						//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l identification de l utilisateur avec son ID" }';
						header('Location: ' . $PIEGE_URL . '?statut=0&dataType=error&data=Erreur lors de l identification de l utilisateur avec son ID&action=ajouter&field={"prefixe": "' . $_POST['prefixepiege'] . '", "nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
					}
				} else {
					//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l identification de l utilisateur" }';
					header('Location: ' . $PIEGE_URL . '?statut=0&dataType=error&data=Erreur lors de l identification de l utilisateur&action=ajouter&field={"prefixe": "' . $_POST['prefixepiege'] . '", "nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
				}
			}
		}
	} else if (isset($_POST['idKey']) && isset($_POST['parcelleId']) && strcmp($_POST['action'], 'modifier') == 0 && isset($_POST['nom']) && isset($_POST['id']) && isset($_POST['prefixepiege'])) {
		$ERROR = false;
		
		if (strcmp($_POST['nom'], '') == 0) {
			$ERROR = true;
			header('Location: ' . $PIEGE_URL . '?statut=0&dataType=error&data=Le champ nom ne peut pas être vide&action=modifier&field={"id":"' . $_POST['id'] . '","prefixe": "' . $_POST['prefixepiege'] . '", "nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
		}
		if (isset($_POST['dateDeb'])) {
			$date = explode('-', $_POST['dateDeb']);
			if (sizeof($date) != 3 || intval($date[0]) < 2000 || intval($date[0]) > 2100 || intval($date[1]) < 1 || intval($date[1]) > 12 || intval($date[2]) < 1 || intval($date[2]) > 31 ) {
				$ERROR = true;
				header('Location: ' . $PIEGE_URL . '?statut=0&dataType=error&data=La date de début est incorrecte&action=modifier&field={"id":"' . $_POST['id'] . '","prefixe": "' . $_POST['prefixepiege'] . '", "nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
			}
		} else {
			$_POST['dateDeb'] = date("Y-m-d");
		}
		if (isset($_POST['dateFin'])) {
			$date = explode('-', $_POST['dateFin']);
			if (sizeof($date) != 3 || intval($date[0]) < 2000 || intval($date[0]) > 2100 || intval($date[1]) < 1 || intval($date[1]) > 12 || intval($date[2]) < 1 || intval($date[2]) > 31 ) {
				$ERROR = true;
				header('Location: ' . $PIEGE_URL . '?statut=0&dataType=error&data=La date de fin est incorrecte&action=modifier&field={"id":"' . $_POST['id'] . '","prefixe": "' . $_POST['prefixepiege'] . '", "nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
			}
		} else {
			$_POST['dateFin'] = date("Y-m-d", mktime(0, 0, 0, date("m") + 1, date("d"), date("Y")));
		}
		
		if (!$ERROR) {
			
			$mysqli = new mysqli($HOST_DB, $USER_DB, $PASSWORD_DB, $SCHEMA_DB, $PORT_DB);
			if ($mysqli->connect_errno) {
				//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
				header('Location: ' . $PIEGE_URL . '?statut=0&dataType=error&data=Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '&action=modifier&field={"id":"' . $_POST['id'] . '","prefixe": "' . $_POST['prefixepiege'] . '", "nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
			} else {
		
				$query = "SELECT * FROM TABLE_USER WHERE TOKEN='" . $_POST[idKey] . "'";
				$res = $mysqli->query($query);
				if ($res) {
					$row = $res->fetch_assoc();
					if (isset($row['ID'])) {
						
						$query = "UPDATE TABLE_PIEGE SET NOM='" . htmlentities($_POST['prefixepiege'] . $_POST['nom']) . "', ADRESSE='" . htmlentities($_POST['adresse']) . "', DATE_DEBUT='" . htmlentities($_POST['dateDeb']) . "', DATE_FIN='" . htmlentities($_POST['dateFin']) . "', DESCRIPTION='" . htmlentities($_POST['description']) . "', LATITUDE='" . htmlentities($_POST['latitude']) . "', LONGITUDE='" . htmlentities($_POST['longitude']) . "' WHERE ID=" . $_POST['id'];
						
						if (!($stmt = $mysqli->prepare($query))) {
							//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec de la preparation: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
							header('Location: ' . $PIEGE_URL . '?statut=0&dataType=error&data=Saisie invalide (nom non unique)&action=modifier&field={"id":"' . $_POST['id'] . '","prefixe": "' . $_POST['prefixepiege'] . '", "nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
						}
						
						if (!$stmt->execute()) {
							//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec lors de l execution: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
							header('Location: ' . $PIEGE_URL . '?statut=0&dataType=error&data=Saisie invalide (nom non unique)&action=modifier&field={"id":"' . $_POST['id'] . '","prefixe": "' . $_POST['prefixepiege'] . '", "nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
						} else {
							//$returnItem = '{ "statut": "2", "dataType": "ok", "data": "Campagne modifiée" , "idKey": "' . $row['RSA_PRIVE'] . '"}';
							header('Location: ' . $PIEGE_URL . '?id=' . $_POST['id']);
						}
					} else {
						//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l identification de l utilisateur avec son ID" }';
						header('Location: ' . $PIEGE_URL . '?statut=0&dataType=error&data=Erreur lors de l identification de l utilisateur avec son ID&action=modifier&field={"id":"' . $_POST['id'] . '","prefixe": "' . $_POST['prefixepiege'] . '", "nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
					}
				} else {
					//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l identification de l utilisateur" }';
					header('Location: ' . $PIEGE_URL . '?statut=0&dataType=error&data=Erreur lors de l identification de l utilisateur&action=modifier&field={"id":"' . $_POST['id'] . '","prefixe": "' . $_POST['prefixepiege'] . '", "nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
				}
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
					
					$query = "DELETE FROM TABLE_PIEGE  WHERE ID=" . $_POST['id'];
					
					if (!($stmt = $mysqli->prepare($query))) {
						$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec de la preparation: (' . $mysqli -> connect_errno . ') ' . $mysqli -> connect_error . '" }';
					}
					
					if (!$stmt->execute()) {
						$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec lors de l execution: (' . $mysqli -> connect_errno . ') ' . $mysqli -> connect_error . '" }';
					} else {
						$returnItem = '{ "statut": "2", "dataType": "ok", "data": "Campagne supprimée" , "idKey": "' . $row['TOKEN'] . '"}';
					}
					
				} else {
					$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l\'identification de l\'utilisateur avec son ID" }';
				}
			} else {
				$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l\'identification de l\'utilisateur" }';
			}
		}
	} else if (isset($_POST['idKey']) && strcmp($_POST['action'], 'map') == 0 && isset($_POST['parcelleId'])) {
			
		$mysqli = new mysqli($HOST_DB, $USER_DB, $PASSWORD_DB, $SCHEMA_DB, $PORT_DB);
		if ($mysqli->connect_errno) {
			$returnItem = '{ "statut": "0", "dataType": "error", "data": "Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
		} else {
		
			$query = "SELECT * FROM TABLE_USER WHERE TOKEN='" . $_POST[idKey] . "'";
			$res = $mysqli->query($query);
			if ($res) {
				$row = $res->fetch_assoc();
				if (isset($row['ID'])) {
					$query = "SELECT * FROM TABLE_PIEGE WHERE PARCEL_ID='" . $_POST['parcelleId'] . "'";
					$item = $mysqli->query($query);
	
					if ($item) {
						$returnItem = '{ "statut": "1", "dataType": "map", "data": { ';
						
						 while ($rowC = $item->fetch_assoc()) {
							 $returnItem .= '"' . $rowC['ID'] . '": {';
							 $returnItem .= '"id": "'           . html_entity_decode($rowC['ID']) . '",';
							 $returnItem .= '"nom": "'          . html_entity_decode(str_replace("\'", "&#39;", $rowC['NOM'])) . '",';
							 //$returnItem .= '"description": "'  . html_entity_decode(str_replace("\'", "&#39;", $rowC['DESCRIPTION'])) . '",';
							 //$returnItem .= '"date_debut": "'   . html_entity_decode($rowC['DATE_DEBUT']) . '",';
							 //$returnItem .= '"date_fin": "'     . html_entity_decode($rowC['DATE_FIN']) . '",';
							 //$returnItem .= '"adresse": "'      . html_entity_decode($rowC['ADRESSE']) . '",';
							 $returnItem .= '"latitude": "'     . html_entity_decode($rowC['LATITUDE']) . '",';
							 $returnItem .= '"longitude": "'    . html_entity_decode($rowC['LONGITUDE']) . '"';
							 $returnItem .= '},';
						}
						$returnItem .= ' "":"" }, "idKey": "' . $row['TOKEN'] . '"}';
					} else {
						//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Aucuns pièges trouves" }';
						$returnItem = '{ "statut": "1", "dataType": "map", "data": {}, "idKey": "' . $row['TOKEN'] . '"}';
					}
					
				} else {
					$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l\'identification de l\'utilisateur avec son ID" }';
				}
			} else {
				$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l\'identification de l\'utilisateur" }';
			}
		}
	} else {
		//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Missing request parameters" }';
		header('Location: ' . $PIEGE_URL . '?statut=0&dataType=error&data=Missing request parameters');
		//var_dump($_POST);
	}
	
	echo $returnItem;
?>