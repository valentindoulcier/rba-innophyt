<?php

	$HEADER = true;
	$CurrentPath = "/php_script";
	include "../pages/parts/variables.php";
	
	$mysqli = new mysqli($HOST_DB, $USER_DB, $PASSWORD_DB, $SCHEMA_DB, $PORT_DB);
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		exit();
	}
	
	// la variable qui va contenir les données CSV
	$outputCsv = '';
	
	// Nom du fichier final
	$fileName = 'export-csv.csv';
	
	$requete = "SELECT
					TUT.NOM AS UTILISATEUR_NOM,
					
					TCA.NOM AS CAMPAGNE_NOM,
					TCA.DESCRIPTION AS CAMPAGNE_DESCRIPTION,
					TCA.DATE_DEBUT AS DATE_DEBUT,
					TCA.DATE_FIN AS DATE_FIN,
					
					TPA.NOM AS PARCELLE_NOM,
					TPA.DESCRIPTION AS PARCELLE_DESCRIPTION,
					TPA.DATE_DEBUT AS PARCELLE_DEBUT,
					TPA.DATE_FIN AS PARCELLE_FIN,
					TPA.ADRESSE AS PARCELLE_LIEU,
					TPA.LATITUDE AS PARCELLE_LATITUDE,
					TPA.LONGITUDE AS PARCELLE_LONGITUDE,
					
					TPI.NOM AS PIEGE_NOM,
					TPI.DESCRIPTION AS PIEGE_DESCRIPTION,
					TPI.DATE_DEBUT AS PIEGE_DATE_POSE,
					TPI.DATE_FIN AS PIEGE_DATE_RECOLTE,
					TPI.ADRESSE AS PIEGE_LIEU,
					TPI.LATITUDE AS PIEGE_LATITUDE,
					TPI.LONGITUDE AS PIEGE_LONGITUDE,
					
					TRE.DATE AS RECOLTE_DATE,
					TRE.NOM AS RECOLTE_NOM,
					TRE.NOMBRE AS RECOLTE_NOMBRE,
					TRE.REGIME_INSECTE AS RECOLTE_REGIME,
					TRE.INFOS_INSECTE AS RECOLTE_INFOS,
					TRE.TYPE_ID_INSECTE AS RECOLTE_TYPE_ID_INSECTE,
					TRE.DEBUT_ID_INSECTE AS RECOLTE_DEBUT,
					TRE.FIN_ID_INSECTE AS RECOLTE_FIN
					
				FROM
					TABLE_USER TUT
					LEFT OUTER JOIN TABLE_CAMPAGNE TCA ON TCA.UTILISATEUR_ID = TUT.ID
					LEFT OUTER JOIN TABLE_PARCELLE TPA ON TPA.CAMPAGNE_ID = TCA.ID
					LEFT OUTER JOIN TABLE_PIEGE TPI ON TPI.PARCEL_ID = TPA.ID
					LEFT OUTER JOIN TABLE_RECOLTE TRE ON TRE.PIEGE_ID = TPI.ID
				WHERE
					TUT.TOKEN = '" . $_GET['idKey'] . "'";
					
	$sql = $mysqli->query($requete);
	if($sql)
	{
	    $i = 0;
	
	    while($Row = $sql->fetch_assoc())
	    {
	        $i++;
	
	        // Si c'est la 1er boucle, on affiche le nom des champs pour avoir un titre pour chaque colonne
	        if($i == 1)
	        {
	            foreach($Row as $clef => $valeur)
	                $outputCsv .= trim($clef).';';
	
	            $outputCsv = rtrim($outputCsv, ';');
	            $outputCsv .= "\n";
	        }
	
	        // On parcours $Row et on ajout chaque valeur à cette ligne
	        foreach($Row as $clef => $valeur) {
	        	//str_replace("\n", " ", $valeur);
	        	//preg_replace("\n", " ", $valeur);
	        	//preg_replace("/(.)?\\n/"," ",$valeur);
	        	var_dump($valeur);
	        	echo "<br/><br/><br/><br/><br/>";
	        	//str_replace('  ', ' &nbsp;', $valeur);
	        	//nl2br($valeur);
	        	//str_replace(chr(13), "", $valeur);
	        	
	        	if((strcmp($clef, "RECOLTE_NOM") == 0) && $valeur != NULL) {
	        		$Val = explode("#", $valeur);
	        		$Val1 = $Val[0];
					$outputCsv .= trim($Val1).';';
	  		    }
				else {
	            	$outputCsv .= trim($valeur).';';
				}
			}
	
	        // Suppression du ; qui traine à la fin
	        $outputCsv = rtrim($outputCsv, ';');
	
	        // Saut de ligne
	        $outputCsv .= "\n";
	    }
	
	}
	else
	    exit('Aucune donnée à enregistrer.');
	/*
	// Entêtes (headers) PHP qui vont bien pour la création d'un fichier Excel CSV
	header("Content-disposition: attachment; filename=".$fileName);
	header("Content-Type: application/force-download");
	header("Content-Transfer-Encoding: application/vnd.ms-excel\n");
	header("Pragma: no-cache");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
	header("Expires: 0");
	
	echo $outputCsv;
	exit();
	 */
?>