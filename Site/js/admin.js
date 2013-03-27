/**
 * Cette fonction gère la génération des thumbnail sur le serveur
 * 
 * @method bindActionGenerateThumbnail
 * @return {Void}
 */
function bindActionGenerateThumbnail() {
	$('#generateThumbnailButton').bind('click', function(e) {
		
		$('body').bind('click', blockClick());
		$('body').fadeTo(500, 0.5);
		
		$('#info').fadeIn(500);
		$.ajax({
			type : "POST",
			url : php_script_url + "/createThumbnail.php",
			success : function(msg) {
				$('#info').fadeOut(500);
				$('body').unbind('click', blockClick());
				$('body').fadeTo(500, 1);
			},
			error : function(jqXHR, textStatus, errorThrown) {
				console.error("Creation fail : " + textStatus + " - " + errorThrown);
				alert('fail');
				$('body').fadeTo(500, 1);
			}
		});
		e.preventDefault();
		return false;
	});
}

/**
 * Cette fonction bloque tous les cliques sur la page
 * 
 * @method blockClick
 * @return {Void}
 */
function blockClick () {
	event.preventDefault();
	return false;
}

/**
 * Affiche les informations des utilisateurs
 * 
 * @method loadUserTable
 * @return {Void}
 */
function loadUserTable() {
	$.ajax({
		type : "POST",
		url : php_script_url + "/admin.php",
		data : {"idKey" : authInfo.idKeyMd5, "action": "lister" },
		success : function(msg) {
			var data = $.parseJSON(msg);
			if (data.idKey == authInfo.idKeyMd5) {
				if (data.dataType == "user") {
					var htmlListeUser = "";
					
					$.each(data.data, function() {
						if (this.id) {
							var classCss = this.admin == "1" ? "admin" : "";
							var typeAuth = this.ip_min != "" || this.ip_max != "" ? "Adresse IP" : "Mot de passe";
							var dataSet = "";
							
							dataSet += "data-id='" + this.id + "' ";
							dataSet += "data-nom='" + this.nom + "' ";
							dataSet += "data-admin='" + this.admin + "' ";
							dataSet += "data-typeauth='" + typeAuth + "' ";
							dataSet += "data-mail='" + this.mail + "' ";
							dataSet += "data-ip_min='" + this.ip_min + "' ";
							dataSet += "data-ip_max'" + this.ip_max + "' ";
							
							
							htmlListeUser += "<tr id='u_" + this.id + "' class='" + classCss + " existingUser' " + dataSet + ">";
							htmlListeUser += "<td>" + this.nom + "</td>";
							htmlListeUser += "<td>" + this.mail + "</td>";
							htmlListeUser += "<td>" + typeAuth + "</td>";
							htmlListeUser += "</tr>"
						}
					});
					
					$('#user_list').html(htmlListeUser);
					
					$('#txt-selectionner-item').html("Sélectionner un utilisateur !");
					$('#txt-delete-item').html("Supprimer l'utilisateur ?");
					
					bindUserClick();
					
					// Mise à jour de shadowbox pour les pop-up de modification et suppression
					Shadowbox.clearCache();
					Shadowbox.setup();
				} else {
					// Affichage d'un message d'erreur dans le cas où il y a une erreur pour la récupération des items
					$('#liste_admin').html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Erreur !</strong> Problème dans la récupération de la liste des utilisateurs </div>")
				}
			} else {
				// Affichage d'un message d'erreur dans le cas où l'utilisateur n'est pas reconnu
				$('#liste_admin').html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Erreur !</strong> " + data.data + " </div>");
			}
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.error("Creation fail : " + textStatus + " - " + errorThrown);
		}
	});
}

/**
 * Ajout de la fonction appelée lorsque l'utilisateur clique sur un utilisateur
 *
 * @method bindUserClick
 * @return {Void}
 **/
function bindUserClick() {
	$('.existingUser').bind('click', function() {
		var item = document.getElementById($(this).attr('id'));
		var shadowBoxModifier = "shadowbox;width=500px;height=410px";
		var shadowBoxSupprimer = "shadowbox;width=450px;height=150px";
		
		// Chargement des champs dans la partie information
		$('#fieldId').html(item.dataset.id);
		$('#fieldName').html(item.dataset.nom);
		$('#fieldAdmin').html(item.dataset.admin == "1" ? "Oui" : "Non");
		$('#fieldMail').html(item.dataset.mail);
		$('#fieldTypeAuth').html(item.dataset.typeauth);
		$('#fieldIPmin').html(item.dataset.ip_min);
		$('#fieldIPmax').html(item.dataset.ip_max);
		
		// Ajout du shadow sur l'item sélectionné
		$('.existingUser').removeClass('active');
		$(this).addClass('active');
		
		// Modification du lien pour modifier
		$('#modif-item').attr('href', '#formUser');
		$('#modif-item').attr('rel', shadowBoxModifier);
		// Modification du lien pour supprimer
		$('#delete-item').attr('href', '#deleteForm');
		$('#delete-item').attr('rel', shadowBoxSupprimer);
		
		setTimeout( function() {
			// Mise à jour de shadowbox pour les pop-up de modification et suppression
			Shadowbox.clearCache();
			Shadowbox.setup();
		}, 500);

	});
}

/**
 * Suppression de l'utilisateur sélectionné suite à la pop-up de confimation
 *
 * @method deleteItem
 * @return {Void}
 **/
function deleteItem() {
	if ($("#fieldId").html() != "") {
		
		$.ajax({
			type : "POST",
			url : php_script_url + "/admin.php",
			data : { "idKey" : authInfo.idKeyMd5, "action": "supprimer", "id": $("#fieldId").html() },
			success : function(msg) {
				var data = $.parseJSON(msg);
				if (data.idKey == authInfo.idKeyMd5) {
					location = location.pathname;
				} else {
					// Affichage d'un message d'erreur dans le cas où l'utilisateur n'est pas reconnu
					$('#liste_admin').html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Erreur !</strong> " + data.data + " </div>")
				}
			},
			error : function(jqXHR, textStatus, errorThrown) {
			// Affichage d'un message d'erreur si il y a une erreur lors de l'exécution de la requête ajax
				console.error("Connexion fail : " + textStatus + " - " + errorThrown);
				$('#liste_admin').html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Connexion fail !</strong> " + textStatus + " - " + errorThrown + " </div>")
			}
		});
	}
}

/*
 * Modif
 * 
 * $('.passwd').popover();
 */

/****** DOCUMENT READY *****/

$(document).ready(function() {
	bindActionGenerateThumbnail();
	
	// Charge la liste des utilisateurs
	loadUserTable();
});