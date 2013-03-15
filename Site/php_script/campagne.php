<?php
	$returnCampagne = "";
	
	if (isset($_POST['idKey'])) {
	
		$mysqli = new mysqli("127.0.0.1", "admin", "", "rba-innophyt", 3306);
		if ($mysqli -> connect_errno) {
			$returnCampagne = '{ "statut": "0", "dataType": "error", "data": "Failed to connect to MySQL: (' . $mysqli -> connect_errno . ') ' . $mysqli -> connect_error . '" }';
		} else {
	
			$query = "SELECT * FROM TABLE_User WHERE RSA_PRIVE='" . $_POST[idKey] . "'";
			$res = $mysqli -> query($query);
			if ($res) {
				$row = $res -> fetch_assoc();
				if (isset($row['ID'])) {
					$query = "SELECT * FROM TABLE_CAMPAGNE WHERE UTILISATEUR_ID='" . $row['ID'] . "'";
					$campagne = $mysqli -> query($query);
	
					if ($campagne) {
						$returnCampagne = '{ "statut": "1", "dataType": "campagne", "data": { ';
						
						 while ($rowC = $campagne->fetch_assoc()) {
							 $returnCampagne .= '"' . $row['ID'] . '": {';
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
	} else {
		$returnCampagne = '{ "statut": "0", "dataType": "error", "data": "Missing request parameters" }';
	}
	
	echo $returnCampagne;
?>