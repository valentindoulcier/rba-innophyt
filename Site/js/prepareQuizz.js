/**
 * Ajout de la fonction appelée lorsque l'utilisateur clique sur un item (campagne/parcelle/piege)
 *
 * @method bindItemClick
 * @return {Void}
 **/
function bindItemClick() {
	$('.existingItem').bind('click', function() {
		var pageChoix = sessionStorage.getItem('pageChoix');
		var item = document.getElementById($(this).attr('id'));
		var urlPageSuivante = "";
		var shadowBoxModifier = "shadowbox;width=500px;height=313px";
		var shadowBoxSupprimer = "shadowbox;width=400px;height=109px";
		
		// Mise à jour de l'item sélectionné dans la sessionStorage
		if (pageChoix == "campagne") {
			sessionStorage.setItem(session_id_campagne, item.dataset.id);
			urlPageSuivante = pages_url + '/parcelle.php';
		} else if (pageChoix == "parcelle") {
			sessionStorage.setItem(session_id_parcelle, item.dataset.id);
			urlPageSuivante = pages_url + '/piege.php';
		} if (pageChoix == "piege") {
			sessionStorage.setItem(session_id_piege, item.dataset.id);
			urlPageSuivante = pages_url + '/quizz.php';
		}
		
		// Chargement des champs dans la partie information
		$('#fieldId').html(item.dataset.id);
		$('#fieldName').html(item.dataset.nom);
		$('#fieldDescription').html(item.dataset.description);
		$('#fieldDateDebut').html(item.dataset.datedebut);
		$('#fieldDateFin').html(item.dataset.datefin);
		
		// Ajout du shadow sur l'item sélectionné
		$('.existingItem').removeClass('active');
		$(this).addClass('active');
		
		// Modification du lien pour modifier
		$('#modif-item').attr('href', '#resultRightDiv');
		$('#modif-item').attr('rel', shadowBoxModifier);
		// Modification du lien pour supprimer
		$('#delete-item').attr('href', '#deleteForm');
		$('#delete-item').attr('rel', shadowBoxSupprimer);
		// Modification du lien pour passer à la page suivante
		$('#choose-item').attr('href', urlPageSuivante);
		$('#choose-item').removeAttr('rel');
		
		// Mise à jour de shadowbox pour les pop-up de modification et suppression
		Shadowbox.clearCache();
		Shadowbox.setup();
	});
}

/**
 * Mise en place de la liste des items (campagne/parcelle/piege) récupérés du serveur
 *
 * @method listerItem
 * @param {String} pageChoix Nom de l'item qui est affiché sur la page (campagne/parcelle/piege)
 * @return {Void}
 **/
function listerItem(pageChoix) {
	var itemForm = "#resultRightDiv";
	
	$.ajax({
		type : "POST",
		url : php_script_url + "/" + pageChoix + ".php",
		data : { "idKey" : authInfo.idKeyMd5, "action": "lister" },
		success : function(msg) {
			var data = $.parseJSON(msg);
			if (data.idKey == authInfo.idKeyMd5) {
				if (data.dataType != "error") {
					var shadowboxRelAjouter = "";
					var htmlListeItem = "<div class='row'>";
					var ajouterOnClickAction = "";
					
					ajouterOnClickAction += "setEmptyForm(); ";
					ajouterOnClickAction += "sessionStorage.setItem(session_action, 'ajouter'); ";
					
					if (pageChoix == "campagne") {
						sessionStorage.setItem(session_liste_camp + authInfo.idKeyMd5, msg);
						
						if (getURLParameter('statut') == "0" && getURLParameter('dataType') == "error") {
							shadowboxRelAjouter = "shadowbox;width=500px;height=343px";
						} else {
							shadowboxRelAjouter = "shadowbox;width=500px;height=313px";
						}
					} else if (pageChoix == "parcelle") {
						sessionStorage.setItem(session_liste_parc + authInfo.idKeyMd5, msg);
					} if (pageChoix == "piege") {
						sessionStorage.setItem(session_liste_pieg + authInfo.idKeyMd5, msg);
					}
		
					
					// Ajout du premier lien pour ajouter un item
					htmlListeItem += "<a id='ajout-item' ";
					htmlListeItem += "href='" + itemForm + "' ";
					htmlListeItem += "rel='" + shadowboxRelAjouter + "' ";
					htmlListeItem += "title='Ajouter un item (" + pageChoix + ")' ";
					htmlListeItem += "onclick=\"" + ajouterOnClickAction + "\">";
					htmlListeItem += "<div class='span1 newItem'>";
					htmlListeItem += "<img src='" + images_url + "/add2.png' ";
					htmlListeItem += "alt='Ajouter un item (" + pageChoix + ")' ";
					htmlListeItem += "style='padding-top: 34px; width: 58px; height: auto;' />";
					htmlListeItem += "</div></a>";
					
					// Ajout de tous les items récupérés de la base de données
					$.each(data.data, function() {
						if (this.id) {
							htmlListeItem += "<div id='" + pageChoix + this.id + "' ";
							htmlListeItem += "class='span1 existingItem' ";
							htmlListeItem += "data-id='" + this.id + "' ";
							htmlListeItem += "data-nom='" + this.nom + "' ";
							htmlListeItem += "data-description='" + this.description + "' ";
							htmlListeItem += "data-datedebut='" + this.date_debut + "' ";
							htmlListeItem += "data-datefin='" + this.date_fin + "' ";
							htmlListeItem += "data-adresse='" + this.adresse + "' ";
							htmlListeItem += "data-latitude='" + this.latitude + "' ";
							htmlListeItem += "data-longitude='" + this.longitude + "' >";
							htmlListeItem += "<h3>" + this.nom + "</h3></div>";
						}
					});
					htmlListeItem += "</div>";
					// Ajout de la liste générée dans la page
					$('#liste_campagne').html(htmlListeItem);
					
					// Mise à jour de shadowbox pour les pop-up de modification et suppression
					Shadowbox.clearCache();
					Shadowbox.setup();
					
					// Appel à la fonction contenant la listenner sur les items de la liste
					bindItemClick();
					
					// Récupération de l'id de l'item précédement sélectionné
					var id = sessionStorage.getItem(session_id_campagne) ? sessionStorage.getItem(session_id_campagne) : getURLParameter('id');
					$('#' + pageChoix + id).click();
					
					// Appel de la fonction qui gère les retours d'erreurs du serveur
					loadPopUpAfterError();
				} else {
					// Affichage d'un message d'erreur dans le cas où il y a une erreur pour la récupération des items
					$('#liste_campagne').html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Erreur !</strong> Problème dans la récupération de la liste des " + pageChoix + "s </div>")
				}
			} else {
				// Affichage d'un message d'erreur dans le cas où l'utilisateur n'est pas reconnu
				$('#liste_campagne').html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Erreur !</strong> " + data.data + " </div>")
			}
		},
		error : function(jqXHR, textStatus, errorThrown) {
			// Affichage d'un message d'erreur si il y a une erreur lors de l'exécution de la requête ajax
			console.error("Connexion fail : " + textStatus + " - " + errorThrown);
			$('#liste_campagne').html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Connexion fail !</strong> " + textStatus + " - " + errorThrown + " </div>")
		}
	});
}

/**
 * Suppression de l'item (campagne/parcelle/piege) sélectionné suite à la pop-up de confimation
 *
 * @method deleteItem
 * @return {Void}
 **/
function deleteItem(pageChoix) {
	if ($("#fieldId").html() != "") {
		var pageChoix = sessionStorage.getItem('pageChoix');
		
		$.ajax({
			type : "POST",
			url : php_script_url + "/" + pageChoix + ".php",
			data : { "idKey" : authInfo.idKeyMd5, "action": "supprimer", "id": $("#fieldId").html() },
			success : function(msg) {
				var data = $.parseJSON(msg);
				if (data.idKey == authInfo.idKeyMd5) {
					location = location.pathname;
				} else {
					// Affichage d'un message d'erreur dans le cas où l'utilisateur n'est pas reconnu
					$('#liste_campagne').html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Erreur !</strong> " + data.data + " </div>")
				}
			},
			error : function(jqXHR, textStatus, errorThrown) {
			// Affichage d'un message d'erreur si il y a une erreur lors de l'exécution de la requête ajax
				console.error("Connexion fail : " + textStatus + " - " + errorThrown);
				$('#liste_campagne').html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Connexion fail !</strong> " + textStatus + " - " + errorThrown + " </div>")
			}
		});
	}
}

/**
 * Modification de l'item (campagne/parcelle/piege) sélectionné
 *
 * @method loadInfoModif
 * @param {String} pageChoix Type de l'item qui est affiché sur la page (campagne/parcelle/piege)
 * @return {Void}
 **/
function loadInfoModif() {
	sessionStorage.setItem(session_action, 'modifier');
	
	if ($("#fieldId").html() != "" && !(getURLParameter('statut') == "0" && getURLParameter('dataType') == "error")) {
		setTimeout(function () {
			$('#sb-container .dateDeb').attr('id', 'dateDeb-field');
			$('#sb-container .dateFin').attr('id', 'dateFin-field');
			$('#dateDeb-field').datepicker();
			$('#dateFin-field').datepicker();
			$('#dateDeb-field').datepicker("option", "dateFormat", "yy-mm-dd");
			$('#dateFin-field').datepicker("option", "dateFormat", "yy-mm-dd");
			
			$(".id-field").val($('#fieldId').html());
			$(".nom").val($('#fieldName').html());
			$(".description").val($('#fieldDescription').html());
			$("#dateDeb-field").val($('#fieldDateDebut').html());
			$("#dateFin-field").val($('#fieldDateFin').html());
		}, 1500);
	}
}

/**
 * Vide les informations du formulaire de la pop-up et initialise le datepicker
 *
 * @method setEmptyForm
 * @return {Void}
 **/
function setEmptyForm() {
	$('.form-info').empty();
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

/**
 * Cette fonction remet en place la pop-up avec les données dedans suite à une validation contenant une ou plusieurs erreur(s)
 *
 * @method loadPopUpAfterError
 * @return {Void}
 **/
function loadPopUpAfterError() {
	if (getURLParameter('statut') == "0" && getURLParameter('dataType') == "error") {
		var field = $.parseJSON(getURLParameter('field'));
		var action = getURLParameter('action');
		
		$('.form-info').html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Erreur !</strong> " + getURLParameter('data') + " </div>")
		
		sessionStorage.setItem(session_action, action);
		
		setTimeout( function (){
			// Ouverture du formulaire
			$('#ajout-item').click();
			
			setTimeout(function () {
				$('#sb-container .dateDeb').attr('id', 'dateDeb-field');
				$('#sb-container .dateFin').attr('id', 'dateFin-field');

				$('#dateDeb-field').datepicker();
				$('#dateFin-field').datepicker();
				$('#dateDeb-field').datepicker("option", "dateFormat", "yy-mm-dd");
				$('#dateFin-field').datepicker("option", "dateFormat", "yy-mm-dd");

				// Chargement des champs saisie dans le formulaire
				$(".nom").val(field.nom);
				$(".description").val(field.description);
				$("#dateDeb-field").val(field.dateDeb);
				$("#dateFin-field").val(field.dateFin);
				
				normalSizeCampagneForm();
			}, 1500);
		}, 1000);
	}
}

/**
 * Cette fonction permet de remttre la bonne taille de la pop-up lorsque l'utilisateur ferme le message d'erreur
 *
 * @method normalSizeCampagneForm
 * @return {Void}
 **/
function normalSizeCampagneForm() {
	$('.close').bind('click', function() {
		var pageChoix = sessionStorage.getItem('pageChoix');

		if (pageChoix == "campagne") {
			Shadowbox.skin.dynamicResize(500, 313);
		} else if (pageChoix == "parcelle") {
			Shadowbox.skin.dynamicResize(500, 313);
		} if (pageChoix == "piege") {
			Shadowbox.skin.dynamicResize(500, 313);
		}
	});
}

/***** DOCUMENT READY *****/

$(document).ready(function() {
	var pageChoix = "";
	
	// Détection du type d'item dans la page
	if ($('liste_campagne')) {
		pageChoix = "campagne";
	} else if ($('liste_parcelle')) {
	} else if ($('liste_piege')) {
	}
	sessionStorage.setItem('pageChoix', pageChoix);
	listerItem(pageChoix);
});