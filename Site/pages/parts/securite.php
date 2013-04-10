		<script type="text/javascript">
			function logout() {
				if (sessionStorage.getItem(session_login_name)) {
					sessionStorage.removeItem(session_login_name);
				} else if (localStorage.getItem(session_login_name)) {
					localStorage.removeItem(session_login_name);
				} else {
					console.error("Non connecté !");
				}
				location = "<?php echo $LOGIN_URL ?>";
			}
			
			var authInfo = null;
			if (sessionStorage.getItem(session_login_name)) {
				authInfo = sessionStorage.getItem(session_login_name);
			} else if (localStorage.getItem(session_login_name)) {
				authInfo = localStorage.getItem(session_login_name);
			} else if (location != "<?php echo $LOGIN_URL ?>") {
				console.error("Error login - Missing authentification informations !");
				location = "<?php echo $LOGIN_URL ?>";
			}
			
			if (authInfo != null) {
				authInfo = $.parseJSON(authInfo);
				$.ajax({
					type : "POST",
					url : "<?php echo $PHP_SCRIPT_URL ?>/checkIdentity.php",
					data : { "login" : authInfo.loginEmail, "pass" : authInfo.pass },
					success : function(msg) {
						var msg = $.parseJSON(msg);
						if (msg.token == authInfo.idKeyMd5) {
							console.debug("securite ok");
							setTimeout(function () {
								$('#footer p.right').html('Vous êtes connecté en tant que ' + authInfo.loginEmail + '<i class="icon-ok-sign"></i> - <a href="<?php echo $MENU_URL ?>" alt="Menu">Menu<i class="icon-th"></i></a> - <a href="#" title="Déconnexion" onClick="logout();">Déconnexion<i class="icon-off"></i></a>');
							}, 200);
							if (location == "<?php echo $LOGIN_URL ?>") {
								location = "<?php echo $MENU_URL ?>";
							}
							// Si la personne essaie d'accéder à la page d'administration sans les droits administrateur
							if (location == "<?php echo $ADMIN_URL?>" && msg.admin != "1") {
								location = "<?php echo $MENU_URL ?>";
							}
							// Si la personne est administrateur, on ajoute l'icone
							if (msg.admin == "1") {
								$('#adminCell').html("<a href='<?php echo $ADMIN_URL ?>' title='Administration de l application'><img src='<?php echo $IMG_PATH ?>/menu/vache6.png' alt='icone questionnaire' class='ico-accueil'/><h3 class='overMenuItem'>Administration</h3></a>");
							}
						} else {
							console.error(msg);
							logout();
						}
					},
					error : function(jqXHR, textStatus, errorThrown) {
						console.error("Connexion fail : " + textStatus + " - " + errorThrown);
						logout();
					}
				});
			}
			
		</script>
