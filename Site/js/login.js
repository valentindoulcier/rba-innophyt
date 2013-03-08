function loadSubmitFormAction() {
	$('#rba-innophyt-connection').submit(function(e) {
		var email     = $("#loginEmail").val();
		var password  = cryptico.encrypt($("#loginPass").val(), public_key).cipher;
		
		$.ajax({
			type : "POST",
			url : "pages/login.php",
			data : "login=" + email + "&pass=" + password + "&private_key=" + private_key,
			success : function(msg) {
				if (msg == "1") {
					$('#login-info').html("<div class='alert alert-success'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Authentification réussit !</strong> Vous allez être redirigé vers le menu </div>")
					if ($('#remember-me').attr('checked') == "checked") {
						sessionStorage.setItem('loginEmail',   email);
						sessionStorage.setItem('loginPassWd',  password);
					} else {
						localStorage.setItem('loginEmail',   email);
						localStorage.setItem('loginPassWd',  password);
					}
				} else {
					$('#login-info').html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Authentification impossible !</strong> Erreur dans votre email ou votre mot de passe </div>")
				} alert(msg);
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