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
	} else if (isset($_POST['idKey']) && isset($_POST['mail']) && strcmp($_POST['action'], 'ajouter') == 0 && isset($_POST['nom'])) {
		$ERROR = false;
		
		$admin = 0;
		if(strcmp($_POST['admin'], "on") == 0) { $admin = 1; }
		
		$field  = '&field={';
		$field .= '"nom":"' . $_POST['nom'] . '",';
		$field .= '"mail":"' . $_POST['mail'] . '",';
		$field .= '"admin":"' . $admin . '",';
		$field .= '"ip_min":"' . $_POST['ip_min'] . '",';
		$field .= '"ip_max":"' . $_POST['ip_max'] . '"';
		$field .= '}';
		
		if (strcmp($_POST['nom'], '') == 0) {
			$ERROR = true;
			header('Location: ' . $ADMIN_URL . '?statut=0&dataType=error&data=Le champ nom ne peut pas être vide&action=ajouter' . $field);
		}
		if (strcmp($_POST['mail'], '') == 0) {
			$ERROR = true;
			header('Location: ' . $ADMIN_URL . '?statut=0&dataType=error&data=Le champ mail ne peut pas être vide&action=ajouter' . $field);
		}
		if ((isset($_POST['ip_min']) || isset($_POST['ip_max'])) && !$ERROR) {
			if ((strcmp($_POST['ip_min'], '') == 0 || strcmp($_POST['ip_max'], '') == 0) && strcmp($_POST['passwd'], '') == 0) {
				$ERROR = true;
				header('Location: ' . $ADMIN_URL . '?statut=0&dataType=error&data=Renseigner les adresses IP ou le mot de passe&action=ajouter' . $field);
			}
		}
		if (isset($_POST['passwd']) && strcmp($_POST['passwd'], '') == 0 && !$ERROR) {
			header('Location: ' . $ADMIN_URL . '?statut=0&dataType=error&data=Le mot de passe ne peut pas être vide&action=ajouter' . $field);
		}
		
		if (!$ERROR) {
			$mysqli = new mysqli($HOST_DB, $USER_DB, $PASSWORD_DB, $SCHEMA_DB, $PORT_DB);
			if ($mysqli->connect_errno) {
				//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
				header('Location: ' . $ADMIN_URL . '?statut=0&dataType=error&data=Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '&action=ajouter&field={"nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
			} else {
		
				$query = "SELECT * FROM TABLE_USER WHERE TOKEN='" . $_POST[idKey] . "'";
				$res = $mysqli->query($query);
				if ($res) {
					$row = $res->fetch_assoc();
					if (isset($row['ID'])) {
		
						if (!($stmt = $mysqli->prepare("INSERT INTO TABLE_USER(NOM, ADMIN, EMAIL, PASSWD, IP_LB, IP_UB) VALUES (?, ?, ?, ?, ?, ?)"))) {
							//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec de la preparation de la requete: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
							header('Location: ' . $ADMIN_URL . '?statut=0&dataType=error&data=Echec de la preparation de la requete: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '&action=ajouter&field={"nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
						}
						
						if (!$stmt->bind_param("sissss", $_POST['nom'], $admin, $_POST['mail'], md5($_POST['passwd']), $_POST['ip_min'], $_POST['ip_max'])) {
							//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec lors du liage des paramètres: (' . $mysqli->connect_errno . ') ' . $mysqli-connect_error . '" }';
							header('Location: ' . $ADMIN_URL . '?statut=0&dataType=error&data=Echec lors du liage des parametres: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '&action=ajouter&field={"nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
						}
						
						if (!$stmt->execute()) {
							//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec lors de l execution: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
							header('Location: ' . $ADMIN_URL . '?statut=0&dataType=error&data=Saisie invalide (nom non unique)&action=ajouter&field={"nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
						} else {
							//$returnItem = '{ "statut": "2", "dataType": "ok", "data": "Campagne ajoutée" , "idKey": "' . $row['RSA_PRIVE'] . '"}';
							header('Location: ' . $ADMIN_URL);
						}
					} else {
						//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l identification de l utilisateur avec son ID" }';
						header('Location: ' . $ADMIN_URL . '?statut=0&dataType=error&data=Erreur lors de l identification de l utilisateur avec son ID&action=ajouter&field={"nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
					}
				} else {
					//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l identification de l utilisateur" }';
					header('Location: ' . $ADMIN_URL . '?statut=0&dataType=error&data=Erreur lors de l identification de l utilisateur&action=ajouter&field={"nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
				}
			}
		}
	} else if (isset($_POST['idKey']) && isset($_POST['id']) && isset($_POST['mail']) && strcmp($_POST['action'], 'modifier') == 0 && isset($_POST['nom'])) {
		$ERROR = false;
		
		$admin = 0;
		if(strcmp($_POST['admin'], "on") == 0) { $admin = 1; }
		
		$field  = '&field={';
		$field .= '"id":"' . $_POST['id'] . '",';
		$field .= '"nom":"' . $_POST['nom'] . '",';
		$field .= '"mail":"' . $_POST['mail'] . '",';
		$field .= '"admin":"' . $admin . '",';
		$field .= '"ip_min":"' . $_POST['ip_min'] . '",';
		$field .= '"ip_max":"' . $_POST['ip_max'] . '"';
		$field .= '}';
		
		if (strcmp($_POST['nom'], '') == 0) {
			$ERROR = true;
			header('Location: ' . $ADMIN_URL . '?statut=0&dataType=error&data=Le champ nom ne peut pas être vide&action=ajouter' . $field);
		}
		if (strcmp($_POST['mail'], '') == 0) {
			$ERROR = true;
			header('Location: ' . $ADMIN_URL . '?statut=0&dataType=error&data=Le champ mail ne peut pas être vide&action=ajouter' . $field);
		}
		
		if (!$ERROR) {
			$mysqli = new mysqli($HOST_DB, $USER_DB, $PASSWORD_DB, $SCHEMA_DB, $PORT_DB);
			if ($mysqli->connect_errno) {
				//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
				header('Location: ' . $ADMIN_URL . '?statut=0&dataType=error&data=Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '&action=ajouter&field={"nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
			} else {
		
				$query = "SELECT * FROM TABLE_USER WHERE TOKEN='" . $_POST[idKey] . "'";
				$res = $mysqli->query($query);
				if ($res) {
					$row = $res->fetch_assoc();
					if (isset($row['ID'])) {
						
						$query = "UPDATE TABLE_USER SET ";
						
						if(strcmp($_POST['passwd'], "")) {
							$query .= "PASSWD='" . md5($_POST['passwd']) . "', ";
						}
						
						$query .= "NOM='" . $_POST['nom'] . "', ADMIN='" . $admin . "', EMAIL='" . $_POST['mail'] . "', IP_LB='" . $_POST['ip_min'] . "', IP_UB='" . $_POST['ip_max'] . "' WHERE ID=" . $_POST['id'];
		
						if (!($stmt = $mysqli->prepare($query))) {
							//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec de la preparation: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
							header('Location: ' . $PIEGE_URL . '?statut=0&dataType=error&data=Saisie invalide (nom non unique)&action=modifier&field={"id":"' . $_POST['id'] . '","nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
						}
		
						if (!$stmt->execute()) {
							//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec lors de l execution: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
							header('Location: ' . $ADMIN_URL . '?statut=0&dataType=error&data=Echec lors de l execution&action=ajouter&field={"nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
						} else {
							//$returnItem = '{ "statut": "2", "dataType": "ok", "data": "Campagne ajoutée" , "idKey": "' . $row['RSA_PRIVE'] . '"}';
							header('Location: ' . $ADMIN_URL . '?id=' . $_POST['id']);
						}
					} else {
						//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l identification de l utilisateur avec son ID" }';
						header('Location: ' . $ADMIN_URL . '?statut=0&dataType=error&data=Erreur lors de l identification de l utilisateur avec son ID&action=ajouter&field={"nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
					}
				} else {
					//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l identification de l utilisateur" }';
					header('Location: ' . $ADMIN_URL . '?statut=0&dataType=error&data=Erreur lors de l identification de l utilisateur&action=ajouter&field={"nom":"' . $_POST['nom'] . '","description":"' . $_POST['description'] . '","dateDeb":"' . $_POST['dateDeb'] . '","dateFin":"' . $_POST['dateFin'] . '","adresse":"' . $_POST['adresse'] . '","latitude":"' . $_POST['latitude'] . '","longitude":"' . $_POST['longitude'] . '"}');
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
		var_dump($_POST);
	}
	
	echo $returnItem;
?>