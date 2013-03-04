<?php
	// connexion avec la base de données
	//$link = mysql_connect("localhost", "root", "") or die("Impossible de se connecter : " . mysql_error());
	//mysql_select_db("nomDeMaBase");
 
	// on exécute maintenant la requete sql pour tester si les parametres de connexion sont ok
	//$result = mysql_query("SELECT login, pass, id FROM membres WHERE login = '$_POST[login]' AND pass = '$_POST[pass]'");
	//$membre = mysql_fetch_assoc($result);
 
	if(($_POST[login]=="Val")&&($_POST[pass]=="tempo"))
	{
		//setcookie("id",$membre[id]); // genere un cookie contenant l'id du membre
		//setcookie("login",$membre[login]); // genere un cookie contenant le login du membre		
		echo "1"; // on 'retourne' la valeur 1 au javascript si la connexion est bonne
	}
	else 
	{
		echo "0"; // on 'retourne' la valeur 0 au javascript si la connexion n'est pas bonne
	}

/*
	// connexion avec la base de données
//	$link = mysql_connect("localhost", "root", "") or die("Impossible de se connecter : " . mysql_error());
//	mysql_select_db("nomDeMaBase");
 
	// on exécute maintenant la requete sql pour tester si les parametres de connexion sont ok
//	$result = mysql_query("SELECT login, pass, id FROM membres WHERE login = '$_POST[login]' AND pass = '$_POST[pass]'");
//	$membre = mysql_fetch_assoc($result);
 
//	if(($_POST[login]==$membre[login])&&($_POST[pass]==$membre[pass]))
//	{
//		setcookie("id",$membre[id]); // genere un cookie contenant l'id du membre
//		setcookie("login",$membre[login]); // genere un cookie contenant le login du membre		
//		echo "1"; // on 'retourne' la valeur 1 au javascript si la connexion est bonne
//	}
//	else 
//	{
//		echo "0"; // on 'retourne' la valeur 0 au javascript si la connexion n'est pas bonne
//	}
*/
?>