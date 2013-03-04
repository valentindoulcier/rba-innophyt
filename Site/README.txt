Modifier le .htaccess :
	Modifier la ligne "AuthUserFile D:/wamp/www/OptionWeb/foobar/.htpasswd" par le chemin complet absolu du .htpasswd pour le serveur où est installée l'application.
	Voir dans "phpinfo()" pour récupérer la valeur du chemin absolu du dossier.
	
Ajouter des utilisateurs :
	Les identifiants et mots de passe sont stockés dans le fichier .htpasswd, sous la forme : "identifiant:mot_de_passe".
	On mettra un utilisateur par ligne (sauter une ligne après chaque couple identifiant:mot_de_passe).