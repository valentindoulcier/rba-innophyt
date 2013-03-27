/**
 * Met en place du graphique
 *
 * @method setGaphique
 * @return {Void}
 **/
function setGaphique() {
	initializeGraph();
}

/**
 * Définit les paramètres du graphique
 *
 * @method initialize
 * @return {Void}
 **/
function initializeGraph() {
	$.ajax({
		type : "POST",
		url : php_script_url + "/recolte.php",
		data : { "idKey" : authInfo.idKeyMd5, "action": "graph", "piegeId-insecte": sessionStorage.getItem(session_id_piege) },
		success : function(msg) {
			var data = $.parseJSON(msg);
			if (data.idKey == authInfo.idKeyMd5 && data.dataType == "graph") {
				console.debug(data);
				makeMyPlot(data.data);
			} else {
				// Affichage d'un message d'erreur dans le cas où l'utilisateur n'est pas reconnu
				$('#liste_' + sessionStorage.getItem('pageChoix')).html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Erreur !</strong> " + data.data + " </div>");
			}
		},
		error : function(jqXHR, textStatus, errorThrown) {
			// Affichage d'un message d'erreur si il y a une erreur lors de l'exécution de la requête ajax
			console.error("Connexion fail : " + textStatus + " - " + errorThrown);
			$('#liste_' + sessionStorage.getItem('pageChoix')).html("<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Connexion fail !</strong> " + textStatus + " - " + errorThrown + " </div>")
		}
	});
}



function makeMyPlot(data) {
	
	var datas = new Array();
	$.each(data, function() {
		if (this.regime_insecte) {
			if(this.regime && this.nombre) {
				var tempo = new Array();
				
				tempo.push(this.regime);
				tempo.push(parseFloat(this.nombre));
				
				datas.push(tempo);
			}
		}
	});
	
	//var data = [['Mouches', 12],['Vaches', 9], ['Moutons', 14], ['Brebis', 16]];
  var plot2 = jQuery.jqplot ('graph-canvas', [datas], 
    {
      seriesDefaults: {
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          // Turn off filling of slices.
          fill: false,
          showDataLabels: true, 
          // Add a margin to seperate the slices.
          sliceMargin: 4, 
          // stroke the slices with a little thicker line.
          lineWidth: 5
        }
      }, 
      legend: { show:true, location: 'e' }
    }
  );
}


$(document).ready(function() {
	if ($('#graph-canvas')) {
		setGaphique();
	}
});