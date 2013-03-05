
/****** DOCUMENT READY *****/

$(document).ready(function() {
	Shadowbox.init(); 
	activateFloatableQuestionBar(); // Active la barre de question flotante qui reste haut lorsque l'on scroll

	initContentmanagment(); // Initialise le "content managment"

	selectFirstQuestion(firstQuestionId); // Permet de lancer l'application avec la première question du fichier XML
	//loadTestContent();

	loadAllPulgins(); // Charge les différents plugins

	$(function(){
	
	// Checking for CSS 3D transformation support
	$.support.css3d = supportsCSS3D();
	
	var formContainer = $('#formContainer');
	
	// Listening for clicks on the ribbon links
	$('.flipLink').click(function(e){
		
		// Flipping the forms
		formContainer.toggleClass('flipped');
		
		// If there is no CSS3 3D support, simply
		// hide the login form (exposing the recover one)
		if(!$.support.css3d){
			$('#login').toggle();
		}
		e.preventDefault();
	});
	
	formContainer.find('form').submit(function(e){
		// Preventing form submissions. If you implement
		// a backend, you might want to remove this code
		e.preventDefault();
	});
	
	
	// A helper function that checks for the 
	// support of the 3D CSS3 transformations.
	function supportsCSS3D() {
		var props = [
			'perspectiveProperty', 'WebkitPerspective', 'MozPerspective'
		], testDom = document.createElement('a');
		  
		for(var i=0; i<props.length; i++){
			if(props[i] in testDom.style){
				return true;
			}
		}
		
		return false;
	}
});
	
	//bindLoginAction();
});


function bindLoginAction()
{
	$("#connexionForm").submit( function(){

	// Checking for CSS 3D transformation support
	$.support.css3d = supportsCSS3D();

	var formContainer = $('#formContainer');

	// Listening for clicks on the ribbon links
	$('.flipLink').click(function(e){

		// Flipping the forms
		formContainer.toggleClass('flipped');

		// If there is no CSS3 3D support, simply
		// hide the login form (exposing the recover one)
		if(!$.support.css3d){
			$('#login').toggle();
		}
		e.preventDefault();
	});

	formContainer.find('form').submit(function(e){
		// Preventing form submissions. If you implement
		// a backend, you will want to remove this code
		e.preventDefault();
	});

	// A helper function that checks for the
	// support of the 3D CSS3 transformations.
	function supportsCSS3D() {
		var props = [
			'perspectiveProperty', 'WebkitPerspective', 'MozPerspective'
		], testDom = document.createElement('a');

		for(var i=0; i<props.length; i++){
			if(props[i] in testDom.style){
				return true;
			}
		}

		return false;
	}
});
		
		
		/*function() {	// à la soumission du formulaire						 
		$.ajax({ // fonction permettant de faire de l'ajax
		   type: "POST", // methode de transmission des données au fichier php
		   url: "pages/login.php", // url du fichier php
		   data: "login="+$("#login").val()+"&pass="+$("#pass").val(), // données à transmettre
		   success: function(msg){ // si l'appel a bien fonctionné
				if(msg=="1") // si la connexion en php a fonctionnée
				{
					printDebug("Tu es bien connecté !!");
					// on désactive l'affichage du formulaire et on affiche un message de bienvenue à la place
				}
				else // si la connexion en php n'a pas fonctionnée
				{
					printDebug("<span class='error'>Erreur d'authentification</span>");
					// on affiche un message d'erreur dans le span prévu à cet effet
				}
		  },
		  error: function(jqXHR, textStatus, errorThrown) {
		  	console.error("Connexion fail : " + textStatus + " - " + errorThrown)
		  }
		});
		event.preventDefault();
		return false; // permet de rester sur la même page à la soumission du formulaire
	});
	*/
}

/****** LOAD PLUGINS *****/
/*
	Charge les différents plugins
*/
function loadAllPulgins()
{
	Shadowbox.clearCache();
	Shadowbox.setup(); 

	$('.carousel').carousel();

	// Stop response carousels sliding
	$('.carouselResponse').carousel('pause');
	$('.carouselResponse').off('mouseleave');

	$('.breadcrumb a').tooltip({
		placement: 'bottom'
	});
	/* 
	// NOT IMPLEMENTED ! For permalink
	$('.permalink-icon').popover({
		content: '<strong>Cliquez pour copier</strong> le lien "permalink" de cette page dans le presse papier.<br />Ce lien vous permetra d\'<strong>accéder de nouveau à cette question</strong>.'
	});	
	*/
}	


/***** ACTIVATE FLOATABLE QUESTION BAR *****/

function activateFloatableQuestionBar()
{
	setQuestionResultFrameDisplay('question'); // Sinon positionElementInPage = 0
	var positionElementInPage = $('#questionTextDivSubNav').offset().top;
	//var elementSpaceHeight = $('#questionTextDivContainer').height();
	var elementSpaceHeight = $('#questionTextDivContainer').css('height');
	$(window).scroll(
	    function() {

	        if ($(window).scrollTop() >= positionElementInPage) {
	            // fixed
	            $('#questionTextDivSubNav').addClass("floatable");
	        } else {
	            // relative
	            $('#questionTextDivSubNav').removeClass("floatable");
	            $('#questionTextDivContainer').height(elementSpaceHeight);
	        }
	    }
	);		
}

/***** SELECT RESPONSE / QUESTION (AJAX REQUESTS) *****/

/*
	Permet de séléctionner la première question au lancement de l'aplication
	@in string questionId - Id de la question
*/
function selectFirstQuestion(questionId)
{
	var DATA = 'questionid=' + questionId;
    $.ajax({
        type: "POST",
        url: "arbres/xmlparser.php",
        dataType: "text",
        data: DATA,
        cache: false,
        statusCode: {
			404: function() {
				alert("Page introuvable !");
			}
		},
        error:function (xhr, ajaxOptions, thrownError){
            printDebug('Status code :'+xhr.status+'<br/>'+thrownError);
        },
        cache: false,
        success: function(data){
        	setQuestionResultFrameDisplay('question');
        	clearBreadcrumb();
        	var questionText = $(data).find('question').attr('texte');
        	var questionId = $(data).find('question').attr('id');
        	setQuestionResultFrameDisplay('question');
        	addBreadcrumbElement( 'Question ',  questionText, questionId, 0);
            fillQuestionContent(data);
        }
    });  
}

/*
	Permet de séléctionner une question
	@in string questionId - Id de la question
*/
function selectQuestion(questionId){
	//alert('Question #'+questionId);

	var DATA = 'questionid=' + questionId;
    $.ajax({
        type: "POST",
        url: "arbres/xmlparser.php",
        dataType: "text",
        data: DATA,
        cache: false,
         statusCode: {
			404: function() {
				alert("Page introuvable !");
			}
		},
        error:function (xhr, ajaxOptions, thrownError){
            printDebug('Status code :'+xhr.status+'<br/>'+thrownError);
        },
        cache: false,
        success: function(data){
        	//printDebug(data);
        	setQuestionResultFrameDisplay('question');
        	setBreadbrumbActiveElement(questionId);
            fillQuestionContent(data);
        }
    });  

	return false;
}

/*
	Permet de séléctionner une réponse et de charge soit la prochaine question soit une réponse
	@in string questionId - Id de la question
	@in bool mode - Regardez le code!
*/
function selectResponse(responseId, mode){

	var DATA = 'responseid=' + responseId;
    $.ajax({
        type: "POST",
        url: "arbres/xmlparser.php",
        dataType: "xml",
        data: DATA,
        cache: false,
         statusCode: {
			404: function() {
				alert("Page introuvable !");
			}
		},
        error:function (xhr, ajaxOptions, thrownError){
            printDebug('Status code :'+xhr.status+'<br/>'+thrownError);
        },
        success: function(data){
        	var questionText = $(data).find('question').attr('texte');
        	var questionId = $(data).find('question').attr('id');
        	
        	if(questionText != null){
        		setQuestionResultFrameDisplay('question');
		    	if(!mode) addBreadcrumbElement( 'Question ',  questionText, questionId, 0);
				else setBreadbrumbActiveElement(responseId);
		        fillQuestionContent(data);
		    }
		    else{
		    	setQuestionResultFrameDisplay('result');
		    	if(!mode) addBreadcrumbElement( 'Résultat ',  '', responseId, 1);
				else setBreadbrumbActiveElement(responseId);
		    	fillResultContent(data);
		    }
        }
    });  

	return false;
}

/***** FILLE CONTENT *****/

/* To fill question content */
function fillQuestionContent(data)
{
	var questionText = $(data).find('question').attr('texte');
	var questionId = $(data).find('question').attr('id');

	setPermalinkQuestionId(questionId);

	setQuestionText(questionText, 'Choisissez une des réponses');

	clearResponesWindow();

	$(data).find('reponse').each(function(){

		var responseCarousel = Array();
		responseCarousel = getCarouselContentFromElement($(this));

		var responseEntry = { 
		    title: $(this).attr('texte'), 
		    text: '',
		    responseId: $(this).attr('id'),
		    carousel: responseCarousel
		};	

		addResponseWindow(responseEntry);
	});

	var questionCarousel = Array();
	questionCarousel = getCarouselContentFromElement($(data).find('question'));

	// If the carousel is empty, do not display the window
	if(questionCarousel.length < 1)
		setInformationsWindowDisplay(false)
	else	
		setInformationsWindow(questionCarousel);

	loadAllPulgins();

}

/* To fill result content */
function fillResultContent(data)
{
	var resutElement = $(data).find('resultat');

	var resultInfo = {
		nom: resutElement.find('nom').text(),
		type: resutElement.find('type').text(),
		regimeAlimentaire: resutElement.find('regimeAlimentaire').text(),
		informations: resutElement.find('informations').text()
	}

	setResultInformations(resultInfo);

	var resultCarousel = Array();
	resultCarousel = getCarouselContentFromElement(resutElement);

	// If the carousel is empty, do not display the window
	if(resultCarousel.length < 1)
		setResultCarouselWindowDisplay(false);
	else
		setResultCarousel(resultCarousel);

	loadAllPulgins();
}



function getCarouselContentFromElement(element)
{
	var myCarousel = Array();
	element.children('media').each(function(){
		var myMedia;
		var myMediaType='';
		if(myMediaSrc = $(this).find('img').attr('src')) {
			myMediaType = 'image';
		}
		else if(myMediaSrc = $(this).find('video').attr('src')) {
			myMediaType = 'video';
			myMedia = $(this).find('video');
		}
		else if(myMediaSrc = $(this).find('sound').attr('src')) {
			myMediaType = 'sound';
			myMedia = $(this).find('video');
		}

		var myMediaCaption = $(this).find('legende').text();

		myCarousel.push({
			mediaType: myMediaType,					
			mediaSrc: myMediaSrc,
			mediaCaption: myMediaCaption,
			mediaThumb: ''
		});
	});

	return myCarousel;
}

