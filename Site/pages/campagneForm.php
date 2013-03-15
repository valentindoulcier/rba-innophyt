<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" />

		<title>test</title>

		<?php
		$CurrentPath = "/pages";
		include "parts/variables.php";

		include $PAGE_PART_PATH . "/headCssJs.php";
		//include $PAGE_PART_PATH . "/securite.php";
		?>
	</head>
	<body>

		<div id="resultRightDiv">
			<div class="window" id="resultWindow">
				<ul>
					<li class="windowTitle">
						<h3><i class="icon-ok"></i>Campagne</h3>
					</li>
					<li id="resultWindowContent">
						<form id="formCampagne">
							<li>
								<label for="nom">Nom</label>
								<input id="nom" name="nom" type="text" placeholder="Nom de la Campagne" required autofocus>

								<label for="description">Description</label>
								<input id="description" name="description" type="text" placeholder="Description">

								<label for="dateDeb">Date de début</label>
								<input id="dateDeb" name="dateDeb" type="date" placeholder="26/02/2012">

								<label for="dateFin">Date de fin</label>
								<input id="dateFin" name="dateFin" type="date" placeholder="28/02/2012">

							</li>
							<div class="btn-toolbar">
								<div class="btn-group">
									<button class="btn" type="button">
										Annuler
									</button>
									<button class="btn" type="submit">
										Enregistrer
									</button>
								</div>
							</div>
						</form>
					</li>
				</ul>
			</div>
		</div>

		<script type="text/javascript">
			function loadSubmitFormAction() {
				$('#formCampagne').submit(function(e) {
					var nom         = $("#nom").val();
					var description = $("#description").val();
					var datedeb     = $("#dateDeb").val();
					var datefin     = $("#dateFin").val();
					

					$.ajax({
						type : "POST",
						url : php_script_url + "/campagneCreateOrUpdate.php",
						data : {
							"nom" : nom,
							"description" : description,
							"datedeb" : datedeb,
							"datefin" : datefin,
							"idKey" : authInfo.idKeyMd5
						},
						success : function(msg) {
							if (msg == authInfo.idKeyMd5) {
								$('#login-info').html("<div class='alert alert-success'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Authentification réussit !</strong> Vous allez être redirigé vers le menu </div>")
								var authInfo = '{ "loginEmail": "' + email + '" , "pass": "' + password + '" , "idKeyMd5": "' + CryptoJS.MD5(idKey).toString() + '" }';
								if ($('#remember-me').attr('checked') == "checked") {
									localStorage.setItem('loginInfoRBA-INNOPHYT', authInfo);
								} else {
									sessionStorage.setItem('loginInfoRBA-INNOPHYT', authInfo);
								}
								location = pages_url + "/menu.php";
							} else {
								console.error(msg);
								$('#login-info').html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Authentification impossible !</strong> Erreur dans votre email ou votre mot de passe </div>")
							}
						},
						error : function(jqXHR, textStatus, errorThrown) {
							console.error("Connexion fail : " + textStatus + " - " + errorThrown)
						}
					});
					e.preventDefault();
					return false;
				});
			}

			/****** DOCUMENT READY *****/

			$(document).ready(function() {
				loadSubmitFormAction();
			});

		</script>

	</body>
</html>