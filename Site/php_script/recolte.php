<?php
/*
	var_dump($_POST);
/* 
 * 
 * ["idKey-field"]=> string(32) "aa75364c8a02b9e06a31c42aa5658558"
 * ["piegeId-insecte"]=> string(1) "8"
 * ["nom-insecte"]=> string(4) "MEL1"
 * 
 * ["type-insecte"]=> string(21) "Auxiliaire prédateur"
 * ["regime-insecte"]=> string(9) "Carnivore"
 * ["info-insecte"]=> string(154) "Ces arthropodes sont des prédateurs généralistes. Plus il y a de ravageurs, plus ils sont consommés par ce groupe d\'individus."
 * 
 * ['type-id-insecte']
 * ['debut-id-insecte']
 * ['fin-id-insecte']
 * 
 * ["nombre-insecte"]=> string(0) "23"
 * ["idResultat"]=> string(3) "r85"
 * ["idReponse"]=> string(5) "res45"
 * 
 */
	$HEADER = true;
	$CurrentPath = "/php_script";
	include "../pages/parts/variables.php";
	
	$returnItem = "";
	$myDate = date("Y-m-d");
	
	if (isset($_POST['idKey-field']) && isset($_POST['piegeId-insecte']) && isset($_POST['nom-insecte']) && isset($_POST['nombre-insecte']) && isset($_POST['idResultat']) && isset($_POST['idReponse'])) {
		$nombreInsecte = intval($_POST['nombre-insecte']);
		
		$data  = '{';
		$data .= ' "piegeId-insecte": "'. $_POST['piegeId-insecte'] . '",';
		$data .= ' "nom-insecte": "' . $_POST['nom-insecte'] . '",';
		//$data .= ' "type-insecte": "' .  $_POST['type-insecte'] . '",';
		//$data .= ' "regime-insecte": "' . $_POST['regime-insecte'] . '",';
		//$data .= ' "info-insecte": "' . str_replace("\'", "&#39;", $_POST['info-insecte']) . '",';
		//$data .= ' "type-id-insecte": "' . $_POST['type-id-insecte'] . '",';
		//$data .= ' "debut-id-insecte": "' . $_POST['debut-id-insecte'] . '",';
		//$data .= ' "fin-id-insecte": "' . $_POST['fin-id-insecte'] . '",';
		$data .= ' "nombre-insecte": "' . $nombreInsecte . '",';
		$data .= ' "idResultat": "' . $_POST['idResultat'] . '",';
		$data .= ' "idReponse": "' . $_POST['idReponse'] . '"';
		$data .= '}';
	
		$mysqli = new mysqli($HOST_DB, $USER_DB, $PASSWORD_DB, $SCHEMA_DB, $PORT_DB);
		if ($mysqli->connect_errno) {
			$returnItem = '{ "statut": "0", "dataType": "error", "data": "Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
		} else {
			
			$query = "SELECT * FROM TABLE_USER WHERE TOKEN='" . $_POST['idKey-field'] . "'";
			$res = $mysqli->query($query);
			
			if ($res) {
				$row = $res->fetch_assoc();
				
				if (isset($row['ID'])) {
					//if (!($stmt = $mysqli->prepare("INSERT INTO TABLE_RECOLTE(PIEGE_ID, NOM, TYPE_INSECTE, REGIME_INSECTE, INFOS_INSECTE, TYPE_ID_INSECTE, DEBUT_ID_INSECTE, FIN_ID_INSECTE, NOMBRE, DATE, ID_UTILISATEUR) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
					if (!($stmt = $mysqli->prepare("INSERT INTO TABLE_RECOLTE(PIEGE_ID, NOM, TYPE_INSECTE, REGIME_INSECTE, INFOS_INSECTE, NOMBRE, DATE, ID_UTILISATEUR) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"))) {
						//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec de la preparation de la requete: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
						header('Location: ' . $QUIZZ_URL . '?statut=0&dataType=error&data=Echec de la preparation de la requete: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '&field=' . $data);
					}
					
					if ($nombreInsecte > intval(0)) {
						//if (!$stmt->bind_param("isssssssdsd",
						if (!$stmt->bind_param("issssisi",
								intval($_POST['piegeId-insecte']),
								htmlentities($_POST['nom-insecte']),
								htmlentities($_POST['type-insecte']),
								htmlentities($_POST['regime-insecte']),
								htmlentities($_POST['info-insecte']),
								//htmlentities($_POST['type-id-insecte']),
								//htmlentities($_POST['debut-id-insecte']),
								//htmlentities($_POST['fin-id-insecte']),
								$nombreInsecte,
								$myDate,
								intval($row['ID']))) {
							//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec lors du liage des paramètres: (' . $mysqli->connect_errno . ') ' . $mysqli-connect_error . '" }';
							header('Location: ' . $QUIZZ_URL . '?statut=0&dataType=error&data=Echec lors du liage des parametres: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '&field=' . $data);
						}
							
						if (!$stmt->execute()) {
							//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Echec lors de l execution: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '" }';
							header('Location: ' . $QUIZZ_URL . '?statut=0&dataType=error&data=Récolte déjà effectuée&field=' . $data);
						} else {
							//$returnItem = '{ "statut": "2", "dataType": "ok", "data": "Récolte ajoutée" , "idKey": "' . $row['RSA_PRIVE'] . '"}';
							header('Location: ' . $QUIZZ_URL . '?statut=1&dataType=ok&data=Récolte ajoutée');
						}
					} else {
						header('Location: ' . $QUIZZ_URL . '?statut=0&dataType=error&data=Nombre d\'insecte incorrect&field=' . $data);
					}
				} else {
					//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l identification de l utilisateur avec son ID" }';
					header('Location: ' . $QUIZZ_URL . '?statut=0&dataType=error&data=Erreur lors de l identification de l utilisateur avec son ID&field=' . $data);
					
				}
			} else {
				//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Erreur lors de l identification de l utilisateur" }';
				header('Location: ' . $QUIZZ_URL . '?statut=0&dataType=error&data=Erreur lors de l identification de l utilisateur&field=' . $data);
			}
		}
	} else {
		//$returnItem = '{ "statut": "0", "dataType": "error", "data": "Missing request parameters" }';
		header('Location: ' . $PIEGE_URL . '?statut=0&dataType=error&data=Missing request parameters');
		//var_dump($_POST);
	}
	echo $returnItem;
?>