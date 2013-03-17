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
		
		$('#choose-campagne').attr('href', pages_url + '/parcelle.php');
		$('#choose-campagne').removeAttr('rel');
		Shadowbox.clearCache();
		Shadowbox.setup();
		
		sessionStorage.setItem(session_id_campagne, campagne.dataset.id);
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
					html += "<a id='ajout-campagne' href='" + campagneForm + "' rel='shadowbox;width=500px;height=313px' title='Ajouter une campagne' onclick=\"$('.form-info').empty(); sessionStorage.setItem('action-rba-innophyt', 'ajouter'); setEmptyForm();\"><div class='span1 campagne'><img src='" + images_url + "/add2.png' alt='Ajouter une campange' style='padding-top: 34px; width: 58px; height: auto;' /></div></a>";
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
					
					var id = sessionStorage.getItem(session_id_campagne) ? sessionStorage.getItem(session_id_campagne) : getURLParameter('id');
					$('#c' + id).click();
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
	if (getURLParameter('statut') == "0" && getURLParameter('dataType') == "error") {
		var field = $.parseJSON(getURLParameter('field'));
		$('.form-info').html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Erreur !</strong> " + getURLParameter('data') + " </div>")
		if (getURLParameter('action') == "ajouter") {
			setTimeout( function (){
				$(".nom").val(field.nom);
				$(".description").val(field.description);
				$(".dateDeb").val(field.dateDeb);
				$(".dateFin").val(field.dateFin);
				$('#ajout-campagne').click();
				setTimeout(function () {
					$('#sb-container .dateDeb').attr('id', 'dateDeb-field');
					$('#sb-container .dateFin').attr('id', 'dateFin-field');
					$('#dateDeb-field').datepicker();
					$('#dateFin-field').datepicker();
					$('#dateDeb-field').datepicker("option", "dateFormat", "yy-mm-dd");
					$('#dateFin-field').datepicker("option", "dateFormat", "yy-mm-dd");
				}, 1500);
				Shadowbox.skin.dynamicResize(500, 403);
			}, 1000);
		} else if (getURLParameter('action') == "modifier") {
			setTimeout( function (){ $('#ajout-campagne').click(); loadInfoModif(); }, 1000);
		}
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
	setTimeout(function () {
		$('#sb-container .dateDeb').attr('id', 'dateDeb-field');
		$('#sb-container .dateFin').attr('id', 'dateFin-field');
		$('#dateDeb-field').datepicker();
		$('#dateFin-field').datepicker();
		$('#dateDeb-field').datepicker("option", "dateFormat", "yy-mm-dd");
		$('#dateFin-field').datepicker("option", "dateFormat", "yy-mm-dd");
	}, 1500);
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
	sessionStorage.setItem('action-rba-innophyt', 'modifier');
	
	if ($("#fieldId").html() != "") {
		setTimeout(function () {
			$('#sb-container .dateDeb').attr('id', 'dateDeb-field');
			$('#sb-container .dateFin').attr('id', 'dateFin-field');
			$('#dateDeb-field').datepicker();
			$('#dateFin-field').datepicker();
			$('#dateDeb-field').datepicker("option", "dateFormat", "yy-mm-dd");
			$('#dateFin-field').datepicker("option", "dateFormat", "yy-mm-dd");
			
			$(".nom").val($('#fieldName').html());
			$(".description").val($('#fieldDescription').html());
			$(".id-field").val($('#fieldId').html());
			$(".dateDeb").val($('#fieldDateDebut').html());
			$(".dateFin").val($('#fieldDateFin').html());
		}, 1500);
	}
}
