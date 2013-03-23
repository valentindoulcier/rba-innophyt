/**
 * Ajout de la fonction appelée lorsque l'utilisateur clique sur un item (campagne/parcelle/piege)
 *
 * @method bindItemClick
 * @return {Void}
 **/
function bindItemClick() {
	$('.mosaiqueCell').bind('click', function() {
		
		var item = document.getElementById($(this).attr('id'));
		
		//var item = document.getElementById($(this).attr('id'));
		var authInfo = '{ "idRes": "' + item.dataset.idres + '" , "nom": "' + item.dataset.nom + '" , "type": "' + item.dataset.type + '" }';
		
		
		console.debug(authInfo);
		
		event.preventDefault();
		return false;
	});
}

/****** DOCUMENT READY *****/

$(document).ready(function() {
	bindItemClick();
});
