/**
 * Met en place la Google Map
 *
 * @method setGoogleMap
 * @return {Void}
 **/
function setGoogleMap() {
	google.maps.event.addDomListener(window, 'load', initialize);
}

/**
 * Définit les paramètres de la carte
 *
 * @method initialize
 * @return {Void}
 **/
function initialize() {
	$.ajax({
		type : "POST",
		url : php_script_url + "/piege.php",
		data : { "idKey" : authInfo.idKeyMd5, "action": "map", "parcelleId": sessionStorage.getItem(session_id_parcelle) },
		success : function(msg) {
			var data = $.parseJSON(msg);
			if (data.idKey == authInfo.idKeyMd5 && data.dataType == "map") {
				//console.debug(data);
				setMarkers(data.data);
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

/**
 * Ajoute les points à la carte
 * 
 * @method setMakers
 * @para {Object} data Structure contenant les informations des points à ajouter sur le Google Map
 * @return {Void}
 */
function setMarkers(data) {
	var minLat, maxLat;
	var minLon, maxLon;
	var latitude, longitude;

	$.each(data, function() {
		if (this.id) {
			if(this.latitude && this.longitude) {
				if(minLat == undefined && maxLat == undefined && minLon == undefined && maxLon == undefined) {
					minLat = parseFloat(this.latitude);
					maxLat = parseFloat(this.latitude);
					minLon = parseFloat(this.longitude);
					maxLon = parseFloat(this.longitude);
				} else {
					if (parseFloat(minLat) > parseFloat(this.latitude)) {
						minLat = parseFloat(this.latitude);
					} else if (parseFloat(maxLat) < parseFloat(this.latitude)) {
						maxLat = parseFloat(this.latitude);
					}
					
					if (parseFloat(minLon) > parseFloat(this.longitude)) {
						minLon = parseFloat(this.longitude);
					} else if (parseFloat(maxLon) < parseFloat(this.longitude)) {
						maxLon = parseFloat(this.longitude);
					}
				}
			}
		}
	});
	
	latitude  = (minLat + maxLat) / 2;
	longitude = (minLon + maxLon) / 2;
	
console.debug("lat " + minLat + " - " + maxLat);
console.debug("lon " + minLon + " - " + maxLon);
console.debug("avg " + latitude + " / " + longitude);
	
	var mapOptions = {
		center : new google.maps.LatLng(minLat, minLon),
		zoom : 13,
		mapTypeId : google.maps.MapTypeId.ROADMAP
	};
	
	var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

	$.each(data, function() {
		if (this.id) {
			if(this.latitude && this.longitude) {
				var imageMarker = null;
				var typePiege = "";

				// Choix de l'icone pour le marker
				if(this.nom.indexOf("BJ-") == 0) {
					imageMarker = new google.maps.MarkerImage(images_url + "/googleMapsMarkerYellow.png");
					typePiege = "Bol Jaune";
				} else if(this.nom.indexOf("TM-") == 0) {
					imageMarker = new google.maps.MarkerImage(images_url + "/googleMapsMarkerGreen.png");
					typePiege = "Tente Malaise";
				} else if(this.nom.indexOf("B-") == 0) {
					imageMarker = new google.maps.MarkerImage(images_url + "/googleMapsMarkerBlue.png");
					typePiege = "Piège Barber";
				} else {
					imageMarker = new google.maps.MarkerImage(images_url + "/googleMapsMarkerRed.png");
					typePiege = "Inconnu";
				}
				
				//Création du marker
				var marker = new google.maps.Marker({
					position: new google.maps.LatLng(this.latitude, this.longitude),
					map: map,
					icon: imageMarker,
					title: this.nom
				});
				
				// Option de la petite pop-up d'informations
				var windowOptions = {
					content:
					'<h6>' + this.nom + '</h6>'+
					'<p>Type du piège : ' + typePiege + '</p>'
				};
				
				// Création de la fenêtre
				var infoWindow = new google.maps.InfoWindow(windowOptions);
				
				google.maps.event.addListener(marker, 'click', function() {
					infoWindow.open(map,marker);
				});
			}
		}
	});
	
}

/* ---------
 * Execute me once when the DOM is ready
 * --------- */
$(document).ready(function() {
	setGoogleMap();
})
