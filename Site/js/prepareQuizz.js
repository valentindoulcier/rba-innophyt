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
		var shadowBoxModifier = "";
		var shadowBoxSupprimer = "shadowbox;width=450px;height=150px";
		
		// Mise à jour de l'item sélectionné dans la sessionStorage
		if (pageChoix == "campagne") {
			if (sessionStorage.getItem(session_id_campagne) !=  item.dataset.id) {
				sessionStorage.setItem(session_id_campagne, item.dataset.id);
				sessionStorage.removeItem(session_id_parcelle);
				sessionStorage.removeItem(session_id_piege);
			}
			urlPageSuivante = pages_url + '/parcelle.php';
			
			shadowBoxModifier = "shadowbox;width=500px;height=313px";
		} else if (pageChoix == "parcelle") {
			if (sessionStorage.getItem(session_id_parcelle) !=  item.dataset.id) {
				sessionStorage.setItem(session_id_parcelle, item.dataset.id);
				sessionStorage.removeItem(session_id_piege);
			}
			urlPageSuivante = pages_url + '/piege.php';
			
			shadowBoxModifier = "shadowbox;width=500px;height=453px";
			
			$('#googleMap-item').removeAttr('rel');
			$('#googleMap-item').attr('href', '#');
			$('#googleMap-item').attr('onclick', 'toogleItemGoogleMap()');
		} if (pageChoix == "piege") {
			sessionStorage.setItem(session_id_piege, item.dataset.id);
			urlPageSuivante = '#items-choisis';
			
			shadowBoxModifier = "shadowbox;width=500px;height=500px";
			
			$('#rba-item').removeAttr('rel');
			$('#rba-item').attr('href', '#');
			$('#rba-item').attr('onclick', 'toogleItemRBA()');
		}
		
		// Chargement des champs dans la partie information
		$('#fieldId').html(item.dataset.id);
		$('#fieldName').html(item.dataset.nom);
		$('#fieldAdresse').html(item.dataset.adresse);
		$('#fieldDescription').html(item.dataset.description);
		$('#fieldDateDebut').html(item.dataset.datedebut);
		$('#fieldDateFin').html(item.dataset.datefin);
		$('#fieldLatitude').html(item.dataset.latitude);
		$('#fieldLongitude').html(item.dataset.longitude);
		
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
		if (pageChoix == "piege") {
			$('#choose-item').attr('rel', 'shadowbox;width=500px;height=270px');
		} else {
			$('#choose-item').removeAttr('rel');
		}
		
		// Mise à jour du "fil d'arinne" de la sélection de la campagne / parcelle / piege
		updateTitle();
		
		setTimeout( function() {
			// Mise à jour de shadowbox pour les pop-up de modification et suppression
			Shadowbox.clearCache();
			Shadowbox.setup();
		}, 500);

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
	$.ajax({
		type : "POST",
		url : php_script_url + "/" + pageChoix + ".php",
		data : { "idKey" : authInfo.idKeyMd5, "action": "lister", "campagneId": sessionStorage.getItem(session_id_campagne), "parcelleId": sessionStorage.getItem(session_id_parcelle) },
		success : function(msg) {
			var data = $.parseJSON(msg);
			if (data.idKey == authInfo.idKeyMd5) {
				if (data.dataType != "error") {
					var shadowboxRelAjouter = "";
					var htmlListeItem = "<div class='row'>";
					var ajouterOnClickAction = "";
					var itemForm = "#resultRightDiv";
					
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
						$('.campagne-id-field').val(sessionStorage.getItem(session_id_campagne));
						
						if (getURLParameter('statut') == "0" && getURLParameter('dataType') == "error") {
							shadowboxRelAjouter = "shadowbox;width=500px;height=483px";
						} else {
							shadowboxRelAjouter = "shadowbox;width=500px;height=453px";
						}
					} if (pageChoix == "piege") {
						sessionStorage.setItem(session_liste_pieg + authInfo.idKeyMd5, msg);
						$('.parcelle-id-field').val(sessionStorage.getItem(session_id_parcelle));
						
						if (getURLParameter('statut') == "0" && getURLParameter('dataType') == "error") {
							shadowboxRelAjouter = "shadowbox;width=500px;height=555px";
						} else {
							shadowboxRelAjouter = "shadowbox;width=500px;height=500px";
						}
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
					$('#liste_' + sessionStorage.getItem('pageChoix')).html(htmlListeItem);
					
					// Mise à jour de shadowbox pour les pop-up de modification et suppression
					Shadowbox.clearCache();
					Shadowbox.setup();
					
					// Appel à la fonction contenant la listenner sur les items de la liste
					bindItemClick();
					
					// Récupération de l'id de l'item précédement sélectionné
					var id = sessionStorage.getItem(eval('session_id_' + pageChoix)) ? sessionStorage.getItem(eval('session_id_' + pageChoix)) : getURLParameter('id');
					$('#' + pageChoix + id).click();
					
					// Mettre le texte dans la pop-up sélectionner un item
					var pageTypeNameS = pageChoix == "piege" ? " piège" : "e " + pageChoix;
					var pageTypeNameD = pageChoix == "piege" ? "e piège sélectionné" : "a " + pageChoix + " sélectionnée";
					$('#txt-selectionner-item').html("Sélectionner un" + pageTypeNameS + " !");
					$('#txt-delete-item').html("Supprimer l" + pageTypeNameD + " ?");
					
					// Appel de la fonction qui gère les retours d'erreurs du serveur
					loadPopUpAfterError();
				} else {
					// Affichage d'un message d'erreur dans le cas où il y a une erreur pour la récupération des items
					$('#liste_' + sessionStorage.getItem('pageChoix')).html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Erreur !</strong> Problème dans la récupération de la liste des " + pageChoix + "s </div>")
				}
			} else {
				// Affichage d'un message d'erreur dans le cas où l'utilisateur n'est pas reconnu
				$('#liste_' + sessionStorage.getItem('pageChoix')).html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Erreur !</strong> " + data.data + " </div>");
			}
					
			// Mise à jour du "fil d'arinne" de la sélection de la campagne / parcelle / piege
			updateTitle();
		},
		error : function(jqXHR, textStatus, errorThrown) {
			// Affichage d'un message d'erreur si il y a une erreur lors de l'exécution de la requête ajax
			console.error("Connexion fail : " + textStatus + " - " + errorThrown);
			$('#liste_' + sessionStorage.getItem('pageChoix')).html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Connexion fail !</strong> " + textStatus + " - " + errorThrown + " </div>")
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
				// Supprime l'info session id de l'item sur lequel est l'utilisateur
				sessionStorage.removeItem(eval('session_id_' + pageChoix));
				
				// Suprression en cascade des autres session id en fonction de la page où l'utilisateur est
				if (pageChoix == "campagne") {
					sessionStorage.getItem(session_id_parcelle);
					sessionStorage.getItem(session_id_piege);
				}
				if (pageChoix == "parcelle") {
					sessionStorage.getItem(session_id_piege);
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
	
	setTimeout(function () {console.log("info modif");
		var pageChoix = sessionStorage.getItem('pageChoix');
	
		$('.nom').removeAttr('disabled');
		setPrefixePiege();
		
		$('#sb-container .dateDeb').attr('id', 'dateDeb-field');
		$('#sb-container .dateFin').attr('id', 'dateFin-field');
		$('#dateDeb-field').datepicker();
		$('#dateFin-field').datepicker();
		$('#dateDeb-field').datepicker("option", "dateFormat", "yy-mm-dd");
		$('#dateFin-field').datepicker("option", "dateFormat", "yy-mm-dd");
		$('#sb-container .prefixe').attr('id', 'prefixe');
		
		$(".id-field").val($('#fieldId').html());
		if (pageChoix != "piege") {
			$(".nom").val($('#fieldName').html());
		} else {
			$('.' + $('#fieldName').html().substring(0, $('#fieldName').html().indexOf('-'))).click();
			$(".nom").val($('#fieldName').html().substring($('#fieldName').html().indexOf('-') + 1));
		}
		$(".description").val($('#fieldDescription').html());
		$('.adresse').val($('#fieldAdresse').html())
		$("#dateDeb-field").val($('#fieldDateDebut').html());
		$("#dateFin-field").val($('#fieldDateFin').html());
		$(".latitude").val($('#fieldLatitude').html());
		$('.longitude').val($('#fieldLongitude').html())
	}, 1500);
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
	$(".adresse").val("");
	
	setTimeout(function () {
		$('#sb-container .dateDeb').attr('id', 'dateDeb-field');
		$('#sb-container .dateFin').attr('id', 'dateFin-field');
		$('#sb-container .prefixe').attr('id', 'prefixe');
		$('#dateDeb-field').datepicker();
		$('#dateFin-field').datepicker();
		$('#dateDeb-field').datepicker("option", "dateFormat", "yy-mm-dd");
		$('#dateFin-field').datepicker("option", "dateFormat", "yy-mm-dd");
		
		setPrefixePiege();
	}, 1500);
}

/**
 * Cette fonction remet en place la pop-up avec les données dedans suite à une validation contenant une ou plusieurs erreur(s)
 *
 * @method loadPopUpAfterError
 * @return {Void}
 **/
function loadPopUpAfterError() {
	if (getURLParameter('statut') == "0" && getURLParameter('dataType') == "error") {
		
		$('.form-info').html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Erreur !</strong> " + getURLParameter('data') + " </div>")
		
		setTimeout( function (){
			var action = getURLParameter('action');
		
			// Ouverture du formulaire
			$('#ajout-item').click();
			sessionStorage.setItem(session_action, action);
			
			setTimeout(function () {
				var pageChoix = sessionStorage.getItem('pageChoix');
				var field = $.parseJSON(getURLParameter('field'));
			
				if ($('.nom').val()) {
					$('.nom').removeAttr('disabled');
				}
				setPrefixePiege();
				
				$('#sb-container .dateDeb').attr('id', 'dateDeb-field');
				$('#sb-container .dateFin').attr('id', 'dateFin-field');
				$('#sb-container .prefixe').attr('id', 'prefixe');

				$('#dateDeb-field').datepicker();
				$('#dateFin-field').datepicker();
				$('#dateDeb-field').datepicker("option", "dateFormat", "yy-mm-dd");
				$('#dateFin-field').datepicker("option", "dateFormat", "yy-mm-dd");

				// Chargement des champs saisie dans le formulaire
				if (pageChoix != "piege") {
					$(".nom").val(field.nom);
				} else {
					$('.' + field.prefixe.substring(0, field.prefixe.indexOf("-"))).click();
					$(".nom").val(field.nom);
				}
				$(".id-field").val(field.id);
				$(".description").val(field.description);
				$("#dateDeb-field").val(field.dateDeb);
				$("#dateFin-field").val(field.dateFin);
				
				normalSizeCampagneForm();
			}, 1500);
		}, 1000);
	}
}

/**
 * Cette fonction permet de remettre la bonne taille de la pop-up lorsque l'utilisateur ferme le message d'erreur
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
			Shadowbox.skin.dynamicResize(500, 453);
		} if (pageChoix == "piege") {
			Shadowbox.skin.dynamicResize(500, 500);
		}
	});
}

/**
 * Cette fonction permet de mettre à jour le titre par rapport aux items sélectionnés
 *
 * @method updateTitle
 * @return {Void}
 **/
function updateTitle() {
	var pageChoix = sessionStorage.getItem('pageChoix');
	var title = "<h2>";
	
	var campagne_id = sessionStorage.getItem(session_id_campagne);
	var parcelle_id = sessionStorage.getItem(session_id_parcelle);
	var piege_id    = sessionStorage.getItem(session_id_piege);
	
	if (campagne_id) {
		var campagne = $.parseJSON(sessionStorage.getItem(session_liste_camp + authInfo.idKeyMd5));
		title += "<a href='" + campagne_url + "' title='Retour à la liste des campagnes'>" + campagne.data[campagne_id].nom + "</a> / ";
	}
	if (campagne_id && parcelle_id) {
		var parcelle = $.parseJSON(sessionStorage.getItem(session_liste_parc + authInfo.idKeyMd5));
		title += "<a href='" + parcelle_url + "' title='Retour à la liste des campagnes'>" + parcelle.data[parcelle_id].nom + "</a> / ";
	}
	if (campagne_id && parcelle_id && piege_id) {
		var piege    = $.parseJSON(sessionStorage.getItem(session_liste_pieg + authInfo.idKeyMd5));
		title += "<a href='" + piege_url    + "' title='Retour à la liste des campagnes'>" + piege.data[piege_id].nom + "</a> /";
		title += " <a href='#items-choisis' rel='shadowbox;width=500px;height=265px' onclick='loadInfoBeaforeQuizz();' title='Accès direct au quizz' class='btn btn-info btn-large'>Identification</a>";
	}
	title += "</h2>";
	
	if (pageChoix == "campagne") {
		$('#title_campagne').html(title);
	} else if (pageChoix == "parcelle") {
		$('#title_parcelle').html(title);
	} else if (pageChoix == "piege") {
		$('#title_piege').html(title);
	}
	
}

/**
 * Cette fonction permet d'ajouter le préfix pour le type de piège et de débloquer le champ nom
 *
 * @method updateTitle
 * @return {Void}
 **/
function setPrefixePiege() {
	$('.piegeType').bind('click', function() {
		var type    = document.getElementById($(this).attr('id'));
		$('.nom').removeAttr('disabled');
		$('.prefixe').text(type.dataset.prefix);
		$('.prefixepiege').val(type.dataset.prefix);
		//console.log($('.prefixepiege').val());
	});
}

/**
 * Cette fonction charge les informations dans la pop-up avant de passer au quizz
 *
 * @method loadInfoBeaforeQuizz
 * @return {Void}
 **/
function loadInfoBeaforeQuizz() {
	setTimeout( function() {
		var campagne_id = sessionStorage.getItem(session_id_campagne);
		var parcelle_id = sessionStorage.getItem(session_id_parcelle);
		var piege_id    = sessionStorage.getItem(session_id_piege);
			
		var campagne = $.parseJSON(sessionStorage.getItem(session_liste_camp + authInfo.idKeyMd5));
		var parcelle = $.parseJSON(sessionStorage.getItem(session_liste_parc + authInfo.idKeyMd5));
		var piege    = $.parseJSON(sessionStorage.getItem(session_liste_pieg + authInfo.idKeyMd5));
				
		$('.choose-campagne-field').val(campagne.data[campagne_id].nom);
		$('.choose-parcelle-field').val(parcelle.data[parcelle_id].nom);
		$('.choose-piege-field').val(piege.data[piege_id].nom);
	}, 1250);
}

/**
 * Cette fonction fait le toggle entre la carte et la liste des items pour afficher la Google Map
 * 
 * @method toogleItemGoogleMap
 * @return {Void}
 */
function toogleItemGoogleMap() {
	//$('#googleMap-item');
	$('#liste_parcelle').toggle(100);
	$('#map').toggle(100);
	$('#googleMap-item').toggleClass('active');
	$('#googleMap-item').toggleClass('btn-info');
	if($('#googleMap-item').attr('class').indexOf('active') >= 0) {	
		if ($('#map-canvas')) {
			try {
				$('#map-canvas').empty();
				setGoogleMap();
			} catch (err) {}
		}
	}
}

/**
 * Cette fonction affiche le RBA du piège (Graphique JQuery)
 *
 * @method toogleItemRBA
 * @return {Void}
 **/
function toogleItemRBA() {
	//$('#googleMap-item');
	$('#liste_piege').toggle(100);
	$('#rba').toggle(100);
	$('#rba-item').toggleClass('active');
	$('#rba-item').toggleClass('btn-info');
	if($('#rba-item').attr('class').indexOf('active') >= 0) {	
		if ($('#rba')) {
			try {
				$('#graph-canvas').empty();
				setGaphique();
			} catch (err) {}
		}
	}
}

/***** DOCUMENT READY *****/

$(document).ready(function() {
	var pageChoix = "";
	
	// Détection du type d'item dans la page
	if ($('#liste_campagne').length) {
		pageChoix = "campagne";
	} else if ($('#liste_parcelle').length) {
		pageChoix = "parcelle";
	} else if ($('#liste_piege').length) {
		pageChoix = "piege";
	}
	sessionStorage.setItem('pageChoix', pageChoix);
	listerItem(pageChoix);
});

