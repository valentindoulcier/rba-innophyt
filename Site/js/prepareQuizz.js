function bindCampagneClick() {
	$('.existingCampagne').bind('click', function() {
		var campagne = document.getElementById($(this).attr('id'));
		console.debug(campagne.dataset);
		$('#fieldName').html(campagne.dataset.nom);
		$('#fieldDescription').html(campagne.dataset.description);
		$('#fieldDateDebut').html(campagne.dataset.datedebut);
		$('#fieldDateFin').html(campagne.dataset.datefin);
	});
}
function lister_campagne() {
	var campagneForm = pages_url + "campagneForm.php";
	$.ajax({
		type : "POST",
		url : php_script_url + "/campagne.php",
		data : { "idKey" : authInfo.idKeyMd5 },
		success : function(msg) {
			var data = $.parseJSON(msg);
			if (data.idKey == authInfo.idKeyMd5) {
				if (data.dataType == "campagne") {
					sessionStorage.setItem("liste_campagne-" + authInfo.idKeyMd5, msg);
					console.debug(data);
					var html = "<div class='row'>";
					html += "<div class='span1 campagne'><a href='" + campagneForm + "' rel='shadowbox;width=490px;height=400px' title='Formulaire d\'ajout dune campagne'><img src='" + images_url + "/add2.png' alt='Ajouter une campange' style='padding-top: 34px; width: 58px; height: auto;' /></a></div>";
					$.each(data.data, function() {
						if (this.id) {
							html += "<div id='c" + this.id + "' class='span1 campagne existingCampagne' data-id='" + this.id + "' data-nom='" + this.nom + "' data-description='" + this.description + "' data-datedebut='" + this.date_debut + "' data-datefin='" + this.date_fin + "' data-adresse='" + this.adresse + "' data-latitude='" + this.latitude + "' data-longitude='" + this.longitude + "'><h3>" + this.nom + "</h3></div>";
						}
					});
					html += "</div>";
					$('#liste_campagne').html(html);
					Shadowbox.clearCache();
					Shadowbox.setup();
					
					bindCampagneClick();
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