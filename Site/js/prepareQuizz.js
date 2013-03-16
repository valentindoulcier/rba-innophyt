function bindCampagneClick() {
	$('.existingCampagne').bind('click', function() {
		var campagne = document.getElementById($(this).attr('id'));
		$('#fieldId').html(campagne.dataset.id);
		$('#fieldName').html(campagne.dataset.nom);
		$('#fieldDescription').html(campagne.dataset.description);
		$('#fieldDateDebut').html(campagne.dataset.datedebut);
		$('#fieldDateFin').html(campagne.dataset.datefin);
		$('.existingCampagne').removeClass('active');
		$(this).addClass('active');
		
		$('#modif-campagne').attr('href', '#resultRightDiv');
		$('#modif-campagne').attr('rel', 'shadowbox;width=500px;height=313px');
		
		$('#delete-campagne').attr('href', '#deleteForm');
		$('#delete-campagne').attr('rel', 'shadowbox;width=400px;height=109px');
		Shadowbox.clearCache();
		Shadowbox.setup();
	});
}

function lister_campagne() {
	var campagneForm = "#resultRightDiv";
	$.ajax({
		type : "POST",
		url : php_script_url + "/campagne.php",
		data : { "idKey" : authInfo.idKeyMd5, "action": "lister" },
		success : function(msg) {
			var data = $.parseJSON(msg);
			//console.debug(data);
			if (data.idKey == authInfo.idKeyMd5) {
				if (data.dataType == "campagne") {
					sessionStorage.setItem("liste_campagne-" + authInfo.idKeyMd5, msg);
					var html = "<div class='row'>";
					html += "<a href='" + campagneForm + "' rel='shadowbox;width=500px;height=313px' title='Ajouter une campagne' onclick=\"$('.form-info').empty(); sessionStorage.setItem('action-rba-innophyt', 'ajouter'); setEmptyForm();\"><div class='span1 campagne'><img src='" + images_url + "/add2.png' alt='Ajouter une campange' style='padding-top: 34px; width: 58px; height: auto;' /></div></a>";
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

/*----------------
 * Form functions
 */
function normalSizeCampagneForm() {
	$('.close').bind('click', function() {
		Shadowbox.skin.dynamicResize(500, 313);
	});
}
function setEmptyForm() {
	$(".nom").val("");
	$(".description").val("");
	$(".dateDeb").val("");
	$(".dateFin").val("");
};
function deleteCampagne() {
	if ($("#fieldId").html() != "") {
		$.ajax({
			type : "POST",
			url : php_script_url + "/campagne.php",
			data : { "idKey" : authInfo.idKeyMd5, "action": "supprimer", "id": $("#fieldId").html() },
			success : function(msg) {
				var data = $.parseJSON(msg);
				//console.debug(data);
				if (data.idKey == authInfo.idKeyMd5) {
					location.reload();
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
}
function loadInfoModif() {
	if ($("#fieldId").html() != "") {
		setTimeout(function () {
			$(".nom").val($('#fieldName').html());
			$(".description").val($('#fieldDescription').html());
			$(".dateDeb").val($('#fieldDateDebut').html());
			$(".dateFin").val($('#fieldDateFin').html());
			$(".id-field").val($('#fieldId').html());
		}, 1500);
	}
}
