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
						if (msg == authInfo.idKeyMd5) {
							console.debug("securite ok");
							$('#footer p.right').html('Vous êtes connecté en tant que ' + authInfo.loginEmail + '<i class="icon-ok-sign"></i> - <a href="<?php echo $MENU_URL ?>" alt="Menu">Menu<i class="icon-th"></i></a> - <a href="#" title="Déconnexion" onClick="logout();">Déconnexion<i class="icon-off"></i></a>');
							if (location == "<?php echo $LOGIN_URL ?>") {
								location = "<?php echo $MENU_URL ?>";
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
