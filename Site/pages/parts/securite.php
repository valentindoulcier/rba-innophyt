		<script type="text/javascript">
			var authInfo = null;
			if (sessionStorage.getItem(session_login_name)) {
				authInfo = sessionStorage.getItem(session_login_name);
			} else if (localStorage.getItem(session_login_name)) {
				authInfo = localStorage.getItem(session_login_name);
			} else {
				console.error("Error login - Missing authentification informations !");
				location = "<?php echo $LOGIN_URL ?>";
			}
			
			authInfo = $.parseJSON(authInfo);
			$.ajax({
				type : "POST",
				url : "<?php echo $PHP_SCRIPT_URL ?>/checkIdentity.php",
				data : { "login" : authInfo.loginEmail, "pass" : authInfo.pass },
				success : function(msg) {
					if (msg == authInfo.idKeyMd5) {
						console.debug("securite ok");
						if (location == "<?php echo $LOGIN_URL ?>") {
							location = "<?php echo $MENU_URL ?>";
						}
					} else {
						console.error(msg);
						location = "<?php echo $LOGIN_URL ?>";
					}
				},
				error : function(jqXHR, textStatus, errorThrown) {
					console.error("Connexion fail : " + textStatus + " - " + errorThrown);
					location = "<?php echo $BASE_URL ?>";
				}
			});
		</script>
