function loadSubmitFormAction() {
	$('#rba-innophyt-connection').submit(function(e) {
		var email     = $("#loginEmail").val();
		var password  = CryptoJS.MD5($("#loginPass").val()).toString();
		
		$.ajax({
			type : "POST",
			url : php_script_url + "/login.php",
			data : { "login" : email, "pass" : password, "idKey" : idKey },
			success : function(msg) {
				if (msg == CryptoJS.MD5(idKey)) {
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