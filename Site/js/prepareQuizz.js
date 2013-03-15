var data
function lister_campagne() {
	$.ajax({
		type : "POST",
		url : php_script_url + "/campagne.php",
		data : { "idKey" : authInfo.idKeyMd5 },
		success : function(msg) {
			 data = $.parseJSON(msg);
			if (data.idKey == authInfo.idKeyMd5) {
				if (data.dataType == "campagne") {
					sessionStorage.setItem("liste_campagne-" + authInfo.idKeyMd5, msg);
					console.debug(data);
					var html = "<div class='row'>";
					html += "<div class='span1 campagne'><h3>+</h3></div>";
					$.each(data.data, function() {
						if (this.id) {
							html += "<div class='span1 campagne'><span class='nom-item'><h3>" + this.nom + "</h3></span></div>";
						}
					});
					html += "</div>";
					$('#liste_campagne').html(html);
				} else {
					$('#liste_campagne').html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Erreur !</strong> Problème dans la récupération de la liste des campagnes </div>")
				}
			} else {
				$('#liste_campagne').html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Erreur !</strong> " + data.data + " </div>")
			}
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.error("Connexion fail : " + textStatus + " - " + errorThrown);
			$('#liste_campagne').html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Connexion fail !</strong> " + textStatus + " - " + errorThrown + " </div>")
		}
	});
}

function liste_parcelle() {
}

function liste_piege() {
}

/****** DOCUMENT READY *****/

$(document).ready(function() {
	if ($('liste_campagne')) {
		lister_campagne();
	} else if ($('liste_parcelle')) {
		liste_parcelle();
	} else if ($('liste_piege')) {
		liste_piege();
	}
}); 