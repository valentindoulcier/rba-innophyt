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
		data : {
			"idKey" : authInfo.idKeyMd5,
			"action" : "graph",
			"piegeId-insecte" : sessionStorage.getItem(session_id_piege)
		},
		success : function(msg) {
			var data = $.parseJSON(msg);
			if (data.idKey == authInfo.idKeyMd5 && data.dataType == "graph") {
				//console.debug(data);
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
	//console.debug(data);
	var datas = [['Carnivore', 0], ['Carnivore et Nectarivore', 0], ['Herbivore', 0], ['Herbivore et Nectarivore', 0], ['Nectarivore', 0]];
	$.each(data, function() {
		if (this.regime && this.nombre) {
			if (datas[0][0] == this.regime)
				datas[0][1] += parseFloat(this.nombre);
			if (datas[1][0] == this.regime)
				datas[1][1] += parseFloat(this.nombre);
			if (datas[2][0] == this.regime)
				datas[2][1] += parseFloat(this.nombre);
			if (datas[3][0] == this.regime)
				datas[3][1] += parseFloat(this.nombre);
			if (datas[4][0] == this.regime)
				datas[4][1] += parseFloat(this.nombre);
		}
	});

	var somme = (datas[0][1] + datas[1][1] + datas[2][1] + datas[3][1] + datas[4][1]) / 100;

	$("#nb1").html(datas[0][1]);
	$("#nb2").html(datas[1][1]);
	$("#nb3").html(datas[2][1]);
	$("#nb4").html(datas[3][1]);
	$("#nb5").html(datas[4][1]);

	if (somme == 0) {
		$("#po1").html("0%");
		$("#po2").html("0%");
		$("#po3").html("0%");
		$("#po4").html("0%");
		$("#po5").html("0%");
	} else {
		$("#po1").html(Math.round(datas[0][1] / somme, 2) + "%");
		$("#po2").html(Math.round(datas[1][1] / somme, 2) + "%");
		$("#po3").html(Math.round(datas[2][1] / somme, 2) + "%");
		$("#po4").html(Math.round(datas[3][1] / somme, 2) + "%");
		$("#po5").html(Math.round(datas[4][1] / somme, 2) + "%");

		var plot2 = jQuery.jqplot('graph-canvas', [datas], {
			title : "Répartition",
			seriesDefaults : {
				renderer : jQuery.jqplot.PieRenderer,
				rendererOptions : {
					// Turn off filling of slices.
					fill : false,
					showDataLabels : true,
					// Add a margin to seperate the slices.
					sliceMargin : 4,
					// stroke the slices with a little thicker line.
					lineWidth : 5
				}
			},
			legend : {
				show : true,
				location : 'e'
			}
		});
		jqplotToImg();
	}
}

function jqplotToImg() {
	var imgData = $('#graph-canvas').jqplotToImageStr({});
	$('#imageGraph').attr('src',imgData);
}


$(document).ready(function() {
	if ($('#graph-canvas')) {
		//setGaphique();
	}
}); 