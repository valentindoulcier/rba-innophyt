Modifier le .htaccess :
	Modifier la ligne "AuthUserFile D:/wamp/www/OptionWeb/foobar/.htpasswd" par le chemin complet absolu du .htpasswd pour le serveur o� est install�e l'application.
	Voir dans "phpinfo()" pour r�cup�rer la valeur du chemin absolu du dossier.
	
Ajouter des utilisateurs :
	Les identifiants et mots de passe sont stock�s dans le fichier .htpasswd, sous la forme : "identifiant:mot_de_passe".
	On mettra un utilisateur par ligne (sauter une ligne apr�s chaque couple identifiant:mot_de_passe).