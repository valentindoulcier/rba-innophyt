/****** DOCUMENT READY *****/

$(document).ready(function() {
	// Permet de lancer l'application avec la première question du fichier XML
	//loadTestContent();
	
	//style='background-color: #F9F9F9; margin: 10px;'
	switch (getURLParameter('statut')) {
		case "1": //OK
			$('#debugText').html("<div class='alert alert-info'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Récolte enregistée !</strong> Vous pouvez enregistrer une nouvelle récolte pour ce piège.</div>");
			selectFirstQuestion(firstQuestionId);
			break;
		case "0": //Erreur
			var msgError = "<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button> <strong>Erreur !</strong> " + getURLParameter('data') + ".</div>";
			afficheResult($.parseJSON(getURLParameter('field')).idResultat, msgError)
			break;
		default:
			if(sessionStorage.getItem(session_id_mosaique) != null) {
				var resultat = $.parseJSON(sessionStorage.getItem(session_id_mosaique));
				afficheResult(resultat.idreponse);
			} else {
				selectFirstQuestion(firstQuestionId);
			}
			break;
	}
});

function afficheResult(resultat, message) {
	clearBreadcrumb();
	selectResponse(resultat, true, message);
}

/***** SELECT RESPONSE / QUESTION (AJAX REQUESTS) *****/

/*
 Permet de séléctionner la première question au lancement de l'aplication
 @in string questionId - Id de la question
 */
function selectFirstQuestion(questionId) {
	var DATA = 'questionid=' + questionId;
	$.ajax({
		type : "POST",
		url : php_script_url + "/xmlparser.php",
		dataType : "text",
		data : DATA,
		cache : false,
		statusCode : {
			404 : function() {
				alert("Page introuvable !");
			}
		},
		error : function(xhr, ajaxOptions, thrownError) {
			printDebug('Status code :' + xhr.status + '<br/>' + thrownError);
		},
		cache : false,
		success : function(data) {
			setQuestionResultFrameDisplay('question');
			clearBreadcrumb();
			var questionText = $(data).find('question').attr('texte');
			var questionId = $(data).find('question').attr('id');
			setQuestionResultFrameDisplay('question');
			addBreadcrumbElement('Question ', questionText, questionId, 0);
			fillQuestionContent(data);
		}
	});
}

/*
 Permet de séléctionner une question
 @in string questionId - Id de la question
 */
function selectQuestion(questionId) {
	//alert('Question #'+questionId);

	var DATA = 'questionid=' + questionId;
	$.ajax({
		type : "POST",
		url : php_script_url + "/xmlparser.php",
		dataType : "text",
		data : DATA,
		cache : false,
		statusCode : {
			404 : function() {
				alert("Page introuvable !");
			}
		},
		error : function(xhr, ajaxOptions, thrownError) {
			printDebug('Status code :' + xhr.status + '<br/>' + thrownError);
		},
		cache : false,
		success : function(data) {
			//printDebug(data);
			setQuestionResultFrameDisplay('question');
			setBreadbrumbActiveElement(questionId);
			fillQuestionContent(data);
		}
	});

	return false;
}

/**
 * Permet de séléctionner une réponse et de charger soit la prochaine question soit une réponse
 *
 * @method selectResponse
 * @param {String} responseId Id de la question
 * @param {String} mode Ajoute ou non l'élément dans le breadcrumb
 * @param {String} message Permet d'afficher un message dans la zone de debug
 * @return {Void}
 **/
function selectResponse(responseId, mode, message) {

	var DATA = 'responseid=' + responseId;
	$.ajax({
		type : "POST",
		url : php_script_url + "/xmlparser.php",
		dataType : "xml",
		data : DATA,
		cache : false,
		statusCode : {
			404 : function() {
				alert("Page introuvable !");
			}
		},
		error : function(xhr, ajaxOptions, thrownError) {
			printDebug('Status code :' + xhr.status + '<br/>' + thrownError);
		},
		success : function(data) {
			var questionText = $(data).find('question').attr('texte');
			var questionId = $(data).find('question').attr('id');

			if (questionText != null) {
				setQuestionResultFrameDisplay('question');
				if (!mode)
					addBreadcrumbElement('Question ', questionText, questionId, 0);
				else
					setBreadbrumbActiveElement(responseId);
				fillQuestionContent(data);
			} else {
				setQuestionResultFrameDisplay('result');
				if (!mode)
					addBreadcrumbElement('Résultat ', '', responseId, 1);
				else
					setBreadbrumbActiveElement(responseId);
				fillResultContent(data, responseId);
				$('#debugTextResultat').html(message);
			}
		}
	});

	return false;
}

/***** FILLE CONTENT *****/

/* To fill question content */
function fillQuestionContent(data) {
	var questionText = $(data).find('question').attr('texte');
	var questionId = $(data).find('question').attr('id');

	setPermalinkQuestionId(questionId);

	setQuestionText(questionText, 'Choisissez une des réponses');

	clearResponesWindow();

	$(data).find('reponse').each(function() {

		var responseCarousel = Array();
		responseCarousel = getCarouselContentFromElement($(this));

		var responseEntry = {
			title : $(this).attr('texte'),
			text : '',
			responseId : $(this).attr('id'),
			carousel : responseCarousel
		};

		addResponseWindow(responseEntry);
	});

	var questionCarousel = Array();
	questionCarousel = getCarouselContentFromElement($(data).find('question'));

	// If the carousel is empty, do not display the window
	if (questionCarousel.length < 1)
		setInformationsWindowDisplay(false)
	else
		setInformationsWindow(questionCarousel);

	loadAllPulgins();

}

/* To fill result content */
function fillResultContent(data, idRep) {
	console.debug("fillResultContent - quizz.js - #167");
	var resutElement = $(data).find('resultat');

	var resultInfo = {
		idReponse : idRep,
		idResultat : resutElement.attr('id'),
		nom : resutElement.find('nom').text(),
		type : resutElement.find('type').text(),
		regimeAlimentaire : resutElement.find('regimeAlimentaire').text(),
		informations : resutElement.find('informations').text()
	}
	console.debug(resultInfo);

	setResultInformations(resultInfo);

	var resultCarousel = Array();
	resultCarousel = getCarouselContentFromElement(resutElement);

	// If the carousel is empty, do not display the window
	if (resultCarousel.length < 1)
		setResultCarouselWindowDisplay(false);
	else
		setResultCarousel(resultCarousel);

	loadAllPulgins();
}

function getCarouselContentFromElement(element) {
	var myCarousel = Array();
	element.children('media').each(function() {
		var myMedia;
		var myMediaType = '';
		if ( myMediaSrc = $(this).find('img').attr('src')) {
			myMediaType = 'image';
		} else if ( myMediaSrc = $(this).find('video').attr('src')) {
			myMediaType = 'video';
			myMedia = $(this).find('video');
		} else if ( myMediaSrc = $(this).find('sound').attr('src')) {
			myMediaType = 'sound';
			myMedia = $(this).find('video');
		}

		var myMediaCaption = $(this).find('legende').text();

		myCarousel.push({
			mediaType : myMediaType,
			mediaSrc : myMediaSrc,
			mediaCaption : myMediaCaption,
			mediaThumb : ''
		});
	});

	return myCarousel;
}
