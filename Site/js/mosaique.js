/**
 * Ajout de la fonction appelée lorsque l'utilisateur clique sur un item (campagne/parcelle/piege)
 *
 * @method bindItemClick
 * @return {Void}
 **/
function bindItemClick() {
	$('.mosaiqueCell').bind('click', function() {
		
		var item = document.getElementById($(this).attr('id'));
		
		var mosaiqueInfo = '{ "idreponse": "' + item.dataset.idreponse + '" , "idresultat": "' + item.dataset.idresultat + '" ,  "mediaId": "' + item.dataset.mediaid + '" , "mediaChemin": "' + item.dataset.mediachemin + '" }';
		
		sessionStorage.setItem(session_id_mosaique, mosaiqueInfo);
		
		//console.debug(authInfo);
		
		//event.preventDefault();
		//return false;
	});
}

/****** DOCUMENT READY *****/

$(document).ready(function() {
	bindItemClick();
	
	if (getURLParameter('statut') == "1") {
		$('#debugText').html("<div class='alert alert-info'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Récolte enregistée !</strong> Vous pouvez enregistrer une nouvelle récolte pour ce piège.</div>");
	}
});
