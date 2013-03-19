<?php
	$HEADER = true;
	$CurrentPath = "/php_script";
	include "../pages/parts/variables.php";
	
	$returnItem = "";
	
	if (isset($_POST['idKey']) && strcmp($_POST['action'], 'lister') == 0) { // Fait en requête ajax, pas besoin de header pour redirection de la page et des infos
	//if (TRUE) {
	
		$mysqli = new mysqli("127.0.0.1", "admin", "", "rba-innophyt", 3306);
		if ($mysqli->connect_errno) {
			$returnItem = '{ "statut": "0", "dataType": "error", "data": "Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
		} else {
	
			$query = "SELECT * FROM TABLE_USER WHERE RSA_PRIVE='" . $_POST[idKey] . "'";
			$res = $mysqli->query($query);
			if ($res) {
				$row = $res->fetch_assoc();
				if (isset($row['ID'])) {
					$query = "SELECT * FROM TABLE_CAMPAGNE WHERE UTILISATEUR_ID='" . $row['ID'] . "'";
					$campagne = $mysqli->query($query);
	
					if ($campagne) {
						$returnItem = '{ "statut": "1", "dataType": "campagne", "data": { ';
						
						 while ($rowC = $campagne->fetch_assoc()) {
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
						$returnItem .= ' "":"" }, "idKey": "' . $row['RSA_PRIVE'] . '"}';
					} else {
						$returnItem = '{ "statut": "0", "dataType": "error", "data": "Aucune campagnes trouvées" }';
					}
				} else {
					$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l\'identification de l\'utilisateur avec son ID" }';
			}
			} else {
				$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l\'identification de l\'utilisateur" }';
			}
		}
	} else if (isset($_POST['idKey']) && strcmp($_POST['action'], 'ajouter') == 0 && isset($_POST['nom'])) {
		$ERROR = false;
		
		if (strcmp($_POST['nom'], '') == 0) {
			$ERROR = true;
			header('Location: ' . $CAMPAGNE_URL . '?statut=0&dataType=error&data=Le champ nom ne peut pas être vide&action=ajouter&field={"nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '"}');
		}
		if (isset($_POST['dateDeb']) && strcmp($_POST['dateDeb'], '') && !$ERROR) {
			$date = explode('-', $_POST['dateDeb']);
			if (sizeof($date) != 3 || intval($date[0]) < 2000 || intval($date[0]) > 2100 || intval($date[1]) < 1 || intval($date[1]) > 12 || intval($date[2]) < 1 || intval($date[2]) > 31 ) {
				$ERROR = true;
				header('Location: ' . $CAMPAGNE_URL . '?statut=0&dataType=error&data=La date de début est incorrecte&action=ajouter&field={"nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '"}');
			}
		} else {
			$_POST['dateDeb'] = date("Y-m-d");
		}
		if (isset($_POST['dateFin']) && strcmp($_POST['dateFin'], '') && !$ERROR) {
			$date = explode('-', $_POST['dateFin']);
			if (sizeof($date) != 3 || intval($date[0]) < 2000 || intval($date[0]) > 2100 || intval($date[1]) < 1 || intval($date[1]) > 12 || intval($date[2]) < 1 || intval($date[2]) > 31 ) {
				$ERROR = true;
				header('Location: ' . $CAMPAGNE_URL . '?statut=0&dataType=error&data=La date de fin est incorrecte&action=ajouter&field={"nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '"}');
			}
		} else {
			$_POST['dateFin'] = date("Y-m-d", mktime(0, 0, 0, date("m") + 1, date("d"), date("Y")));
		}
		
		if (!$ERROR) {
	
			$mysqli = new mysqli("127.0.0.1", "admin", "", "rba-innophyt", 3306);
			if ($mysqli->connect_errno) {
				//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
				header('Location: ' . $CAMPAGNE_URL . '?statut=0&dataType=error&data=Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '&action=ajouter&field={"nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '"}');
			} else {
		
				$query = "SELECT * FROM TABLE_USER WHERE RSA_PRIVE='" . $_POST[idKey] . "'";
				$res = $mysqli->query($query);
				if ($res) {
					$row = $res->fetch_assoc();
					if (isset($row['ID'])) {
		
						if (!($stmt = $mysqli->prepare("INSERT INTO TABLE_CAMPAGNE(UTILISATEUR_ID, NOM, DATE_DEBUT, DATE_FIN, DESCRIPTION) VALUES (?, ?, ?, ?, ?)"))) {
							//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec de la preparation de la requete: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
							header('Location: ' . $CAMPAGNE_URL . '?statut=0&dataType=error&data=Echec de la preparation de la requete: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '&action=ajouter&field={"nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '"}');
						}
						
						if (!$stmt->bind_param("issss", $row['ID'], htmlentities($_POST['nom']), htmlentities($_POST['dateDeb']), htmlentities($_POST['dateFin']), htmlentities($_POST['description']))) {
							//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec lors du liage des paramètres: (' . $mysqli->connect_errno . ') ' . $mysqli-connect_error . '" }';
							header('Location: ' . $CAMPAGNE_URL . '?statut=0&dataType=error&data=Echec lors du liage des parametres: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '&action=ajouter&field={"nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '"}');
						}
						
						if (!$stmt->execute()) {
							//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec lors de l execution: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
							header('Location: ' . $CAMPAGNE_URL . '?statut=0&dataType=error&data=Saisie invalide (nom non unique)&action=ajouter&field={"nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '"}');
						} else {
							//$returnItem = '{ "statut": "2", "dataType": "ok", "data": "Campagne ajoutée" , "idKey": "' . $row['RSA_PRIVE'] . '"}';
							header('Location: ' . $CAMPAGNE_URL);
						}
					} else {
						//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l identification de l utilisateur avec son ID" }';
						header('Location: ' . $CAMPAGNE_URL . '?statut=0&dataType=error&data=Erreur lors de l identification de l utilisateur avec son ID&action=ajouter&field={"nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '"}');
					}
				} else {
					//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l identification de l utilisateur" }';
					header('Location: ' . $CAMPAGNE_URL . '?statut=0&dataType=error&data=Erreur lors de l identification de l utilisateur&action=ajouter&field={"nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '"}');
				}
			}
		}
	} else if (isset($_POST['idKey']) && strcmp($_POST['action'], 'modifier') == 0 && isset($_POST['nom']) && isset($_POST['id'])) {
		$ERROR = false;
		
		if (strcmp($_POST['nom'], '') == 0) {
			$ERROR = true;
			header('Location: ' . $CAMPAGNE_URL . '?statut=0&dataType=error&data=Le champ nom ne peut pas être vide&action=modifier&field={"id":"' . $_POST['id'] . '","nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '"}');
		}
		if (isset($_POST['dateDeb']) && strcmp($_POST['dateDeb'], '') && !$ERROR) {
			$date = explode('-', $_POST['dateDeb']);
			if (sizeof($date) != 3 || intval($date[0]) < 2000 || intval($date[0]) > 2100 || intval($date[1]) < 1 || intval($date[1]) > 12 || intval($date[2]) < 1 || intval($date[2]) > 31 ) {
				$ERROR = true;
				header('Location: ' . $CAMPAGNE_URL . '?statut=0&dataType=error&data=La date de début est incorrecte&action=modifier&field={"id":"' . $_POST['id'] . '","nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '"}');
			}
		} else {
			$_POST['dateDeb'] = date("Y-m-d");
		}
		if (isset($_POST['dateFin']) && strcmp($_POST['dateFin'], '') && !$ERROR) {
			$date = explode('-', $_POST['dateFin']);
			if (sizeof($date) != 3 || intval($date[0]) < 2000 || intval($date[0]) > 2100 || intval($date[1]) < 1 || intval($date[1]) > 12 || intval($date[2]) < 1 || intval($date[2]) > 31 ) {
				$ERROR = true;
				header('Location: ' . $CAMPAGNE_URL . '?statut=0&dataType=error&data=La date de fin est incorrecte&action=modifier&field={"id":"' . $_POST['id'] . '","nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '"}');
			}
		} else {
			$_POST['dateFin'] = date("Y-m-d", mktime(0, 0, 0, date("m") + 1, date("d"), date("Y")));
		}
		
		if (!$ERROR) {
			
			$mysqli = new mysqli("127.0.0.1", "admin", "", "rba-innophyt", 3306);
			if ($mysqli->connect_errno) {
				//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
				header('Location: ' . $CAMPAGNE_URL . '?statut=0&dataType=error&data=Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '&action=modifier&field={"id":"' . $_POST['id'] . '","nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '"}');
			} else {
		
				$query = "SELECT * FROM TABLE_USER WHERE RSA_PRIVE='" . $_POST[idKey] . "'";
				$res = $mysqli->query($query);
				if ($res) {
					$row = $res->fetch_assoc();
					if (isset($row['ID'])) {
						
						$query = "UPDATE TABLE_CAMPAGNE SET NOM='" . htmlentities($_POST['nom']) . "', DATE_DEBUT='" . htmlentities($_POST['dateDeb']) . "', DATE_FIN='" . htmlentities($_POST['dateFin']) . "', DESCRIPTION='" . htmlentities($_POST['description']) . "' WHERE ID=" . $_POST['id'];
						
						if (!($stmt = $mysqli->prepare($query))) {
							//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec de la preparation: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
							header('Location: ' . $CAMPAGNE_URL . '?statut=0&dataType=error&data=Saisie invalide (nom non unique)&action=modifier&field={"id":"' . $_POST['id'] . '","nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '"}');
						}
						
						if (!$stmt->execute()) {
							//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec lors de l execution: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
							header('Location: ' . $CAMPAGNE_URL . '?statut=0&dataType=error&data=Echec lors de l execution: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '&action=modifier&field={"id":"' . $_POST['id'] . '","nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '"}');
						} else {
							//$returnItem = '{ "statut": "2", "dataType": "ok", "data": "Campagne modifiée" , "idKey": "' . $row['RSA_PRIVE'] . '"}';
							header('Location: ' . $CAMPAGNE_URL . '?id=' . $_POST['id']);
						}
					} else {
						//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l identification de l utilisateur avec son ID" }';
						header('Location: ' . $CAMPAGNE_URL . '?statut=0&dataType=error&data=Erreur lors de l identification de l utilisateur avec son ID&action=modifier&field={"id":"' . $_POST['id'] . '","nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '"}');
					}
				} else {
					//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l identification de l utilisateur" }';
					header('Location: ' . $CAMPAGNE_URL . '?statut=0&dataType=error&data=Erreur lors de l identification de l utilisateur&action=modifier&field={"id":"' . $_POST['id'] . '","nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '"}');
				}
			}
		}
	} else if (isset($_POST['idKey']) && strcmp($_POST['action'], 'supprimer') == 0 && isset($_POST['id'])) {
			
		$mysqli = new mysqli("127.0.0.1", "admin", "", "rba-innophyt", 3306);
		if ($mysqli->connect_errno) {
			$returnItem = '{ "statut": "0", "dataType": "error", "data": "Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
		} else {
		
			$query = "SELECT * FROM TABLE_USER WHERE RSA_PRIVE='" . $_POST[idKey] . "'";
			$res = $mysqli->query($query);
			if ($res) {
				$row = $res->fetch_assoc();
				if (isset($row['ID'])) {
					
					$query = "DELETE FROM TABLE_CAMPAGNE  WHERE ID=" . $_POST['id'];
					
					if (!($stmt = $mysqli->prepare($query))) {
						$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec de la preparation: (' . $mysqli -> connect_errno . ') ' . $mysqli -> connect_error . '" }';
					}
					
					if (!$stmt->execute()) {
						$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec lors de l execution: (' . $mysqli -> connect_errno . ') ' . $mysqli -> connect_error . '" }';
					} else {
						$returnItem = '{ "statut": "2", "dataType": "ok", "data": "Campagne supprimée" , "idKey": "' . $row['RSA_PRIVE'] . '"}';
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
		header('Location: ' . $CAMPAGNE_URL . '?statut=0&dataType=error&data=Missing request parameters');
	}
	
	echo $returnItem;
?>