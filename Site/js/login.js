function loadSubmitFormAction() {
	$('#rba-innophyt-connection').submit(function(e) {
		var email     = $("#loginEmail").val();
		var password  = CryptoJS.MD5($("#loginPass").val()).toString();
		
		$.ajax({
			type : "POST",
			url : php_script_url + "/login.php",
			data : { "login" : email, "pass" : password, "idKey" : idKey },
			success : function(msg) {
				var data = $.parseJSON(msg);
				if (data.state == "done") {
					$('#login-info').html("<div class='alert alert-success'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Authentification réussit !</strong> Vous allez être redirigé vers le menu </div>")
					var authInfo = '{ "loginEmail": "' + email + '" , "pass": "' + password + '" , "idKeyMd5": "' + data.token + '", "auth": "' + data.auth + '" }';
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

function loadSubmitForgetPasswdForm() {
	$('#rba-innophyt-forgetPasswd').submit(function() {
		var email     = $("#loginEmail").val();
		
		;
		
		event.preventDefault();
		return false;
	});
}

function showForgetPasswdForm() {
	$('#forgetPasswd').bind('click', function() {
		$('#rba-innophyt-connection').hide();
		$('#rba-innophyt-forgetPasswd').show();
	});
}

function showConnectForm() {
	$('#formConnect').bind('click', function() {
		$('#rba-innophyt-connection').show();
		$('#rba-innophyt-forgetPasswd').hide();
	});
}

/****** DOCUMENT READY *****/

$(document).ready(function() {
	loadSubmitFormAction();
	showForgetPasswdForm();
	showConnectForm();
});