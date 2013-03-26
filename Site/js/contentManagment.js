/* Exemple de window response et de carousel element*/
/*
	var carouselElement1 = {
		mediaId: 'med3', // id du media dans le xml
		mediaType: 'image', // image/video/sound
		mediaSrc: 'images/Reponse1/1.jpg',
		mediaCaption: 'Une libelube',
		mediaThumb: ''
	}
	var carouselElement2 = {
		mediaType: 'video',	
		mediaSrc: 'images/Reponse1/vid.flv',
		mediaCaption: 'Une video',
		mediaThumb: 'image/vidThumb.jpg'
	}

	var response = { 
	    title: "valeur", 
	    text: "Lorem ipsum dolor si amet.",
	    responseId: 1,
	    carousel: Array(
	    	carouselElement1,
	    	carouselElement2
	    )
	} 

	var resultInfo = {
		nom: 'Nom de la morpho-espèce trouvée',
		type: 'MEL1',
		regimeAlimentaire: 'Prédateur',
		informations: 'Informations complementaires sur la morpho-espèce'
	}
*/

/***** DEFINES *****/

var BREADCRUM_ID = '#breadcrumb';

var DEBUG_FRAME_ID = '#debugFrame';
var DEBUG_TEXT_ID = '#debugText';

var QUESTION_FRAME_ID = '#questionFrame';
var QUESTIONBAR_ID = '#questionTextDiv';
var RESPONSES_DIV_ID = '#responsesDiv'
var INFORMATIONS_CONTENT_ID = '#questionInfoContent';
var INFORMATION_WINDOW_ID = '#informationsWindow';

var RESULT_FRAME_ID = '#resultFrame';
var RESULT_CONTENT_ID = '#resultWindowContent'
var RESULT_CAROUSEL_CONTENT_ID = "#resultCarouselWindowContent"
var RESULT_CAROUSE_WINDOWS_ID = '#resultCarouselWindow';


/***** PRIVATE VARIABLES *****/
var _carouselResponseId = 0; // Used in addResponseWindow() function
var _emptyBreadcrumbContent = '';


/***** PUBLIC FUNCTION *****/

/*
	Fonction d'initialisation du "content managment"
*/
function initContentmanagment()
{
	_carouselResponseId = 0;
	_emptyBreadcrumbContent = $(BREADCRUM_ID).html()
}

/*
	Affiche ou cache la fernêtre qui contient le carousel dans la partie RESULTAT
	@in bool value - true pour afficher, false pour caché
*/
function setResultCarouselWindowDisplay(value)
{
	setElementDisplay($(RESULT_CAROUSE_WINDOWS_ID), value)
}
/*
	Defini le carousel dans la partie RESULTAT
	@in carouselElement[] carouselContent - Tableau de carouselElement (voir en-tête du fichier pour la structure)
*/
function setResultCarousel(carouselContent)
{
	var mosaiqueRes = sessionStorage.getItem(session_id_mosaique);
	if(mosaiqueRes) {
		mosaiqueRes = $.parseJSON(mosaiqueRes);
	} else {
		mosaiqueRes = false;
	}
	setResultCarouselWindowDisplay(true);
	var infoContent = '';

	infoContent +=
		'<div id="carouselResult" class="carousel slide carouselQuestion">'+
			'<div class="carousel-inner">';

				for(i=0; i<carouselContent.length; i++)
				{
					if (!mosaiqueRes) {
						infoContent += generateCarouselItem('resultGal', carouselContent[i]);
					} else if (mosaiqueRes.mediaId == carouselContent[i].mediaId) {
						infoContent += generateCarouselItem('resultGal', carouselContent[i]);
					}
				}

	infoContent +=		           
			'</div>';
	if(carouselContent.length > 1 && !mosaiqueRes){
		infoContent +=	
			'<a class="left carousel-control" href="#carouselResult" data-slide="prev">‹</a>'+
			'<a class="right carousel-control" href="#carouselResult" data-slide="next">›</a>';
	}
	infoContent +=	
		'</div>'+
		'<div style="clear:both;"></div>';

	$(RESULT_CAROUSEL_CONTENT_ID).html(infoContent);
}
/*
	Defini les Informations dans la partie RESULTAT
	@in resultInfo resultInfo - (voir en-tête du fichier pour la structure)
*/
function setResultInformations(resultInfo)
{
	var output = '';
	if (sessionStorage.getItem(session_save) == "true") {
		output += 
			"<ul>" +
				"<li>" +
					"<form class='form-horizontal formCampagne' action='" + php_script_url + "/recolte.php' method='post'>" + 
						"<div>" +
							"<input id='nom-insecte' class='nom-insecte' name='nom-insecte' type='hidden'>" +
							"<input id='type-insecte' class='type-insecte' name='type-insecte' type='hidden'>" +
							"<input id='regime-insecte' class='regime-insecte' name='regime-insecte' type='hidden'>" +
							"<input id='info-insecte' class='info-insecte' name='info-insecte' type='hidden'>" +
							"<input id='piegeId-insecte' class='piegeId-insecte' name='piegeId-insecte' type='hidden'>" +
							"<input id='idKey-field' class='idKey-field' name='idKey-field' type='hidden'>" +
							"<input id='idResultat' class='idResultat' name='idResultat' type='hidden'>" +
							"<input id='idReponse' class='idReponse' name='idReponse' type='hidden'>" +
							"<script type='text/javascript'>" +
								"$('.piegeId-insecte').val(sessionStorage.getItem(session_id_piege));" +
								"$('.idKey-field').val(authInfo.idKeyMd5);" +
								"$('.nom-insecte').val('" + resultInfo.nom + "');" +
								"$('.type-insecte').val('" + resultInfo.type + "');" +
								"$('.regime-insecte').val('" + resultInfo.regimeAlimentaire + "');" +
								"$('.info-insecte').val(eval(\"$('.resultInfo li:last-child span:last-child').html()\"));" +
								"$('.idResultat').val('" + resultInfo.idReponse + "');" +
								"$('.idReponse').val('" + resultInfo.idResultat + "');" +
							"</script>" +
						"</div>" +
						
						"<div>" +
							"<label for='nombre-insecte'><h3>Nombre d'individus trouvés :</h3></label>" +
							"<input style='margin-left: 15px; margin-top: 10px;' id='nombre-insecte' class='nombre-insecte' name='nombre-insecte' type='text' placeholder='Nombre trouvé' required autofocus>" +
							"<a href='#' id='submit-form' class='btn btn-success' style='margin-left: 50px; margin-top: 10px;' onclick='javascript:submit();'>Enregistrer</a>" +
						"</div>" +
					"</form>" +
					"<hr style='margin: 28px 0 0 0; border: 0; border-top: 1px solid #ddd; border-bottom: 1px solid #eee;'>" +
			"</ul>";
	}
	output += 
		'<ul class="resultInfo">'+
			'<li><span class="resultInfosListLabel">Nom :</span>'+resultInfo.nom+'</li>'+
			'<li><span class="resultInfosListLabel">Type :</span>'+resultInfo.type+'</li>'+
			'<li><span class="resultInfosListLabel">Regime alimentaire :</span>'+resultInfo.regimeAlimentaire+'</li>'+
			'<li><span class="resultInfosListLabel">Informations complementaires :</span><span>'+resultInfo.informations+'<span></li>'+
		'</ul>';

	$(RESULT_CONTENT_ID).html(output);
}

/*
	Efface tous les elements du fil d'ariane (breadcrum)
*/
function clearBreadcrumb()
{
	$(BREADCRUM_ID).html(_emptyBreadcrumbContent);
}
/*
	Ajoute un élement au fil d'ariane
	@in string text - Texte affiché de l'élément
	@in string title - Texte qui s'affiche quand on passe la souris sur l'élément
	@in string id - Id de la question ou du résultat vers lequel le lien doit mener
	@in bool isResult - true si le lien de l'élément mène à un resultat, false s'il mène à une question

*/
function addBreadcrumbElement(text, title, id, isResult)
{
	var lastNumber = 0;
	var stop = false;
	var noElement = true;
	var breadcrumbTilActive = '<i class="icon-leaf"></i>';

	var liElement = $(BREADCRUM_ID+' li:first');

	var timeOut = 0
	while(!stop && liElement.html()!=null && timeOut < 10)
	{
		noElement = false;
		if(liElement.hasClass('active'))
		{ 
			liElement.removeClass('active')
			lastNumber = liElement.attr('number')
			stop = true;
		}	
		var liId = '';
		if(liElement.attr('id')) liId = liElement.attr('id')

		breadcrumbTilActive += '<li class="'+liElement.attr('class')+'" id="'+liId+'" number="'+liElement.attr('number')+'">'+liElement.html()+'</li>';	

		// On récupère le prochain li
		liElement = liElement.next();
		timeOut++;
	}

	var breadcrumnContentToAdd = '';

	var nextNumber = parseInt(lastNumber)+1;
	breadcrumnContentToAdd += 
		'<li class="active" id="quest'+id+'" number="'+nextNumber+'">';
		if(!noElement){
			breadcrumnContentToAdd += '<span class="divider">&raquo;</span>';
		}

		var jsFunctionName;
		if(isResult) jsFunctionName = "selectResponse('"+id+"',1)";
		else jsFunctionName = "selectQuestion('"+id+"')";

		breadcrumnContentToAdd += '<a href="#" onClick="'+jsFunctionName+';"  title="'+title+'">'+text+'#'+id+'</a>';

		breadcrumnContentToAdd += 
		'</li>';

	$(BREADCRUM_ID).html(breadcrumbTilActive+breadcrumnContentToAdd);
	
}
/*
	Défini l'élément actif du fil d'ariane (breadcrum)
	@in string id - Id de l'élément (question ou resultat) a définir comme étant actif
*/
function setBreadbrumbActiveElement(id)
{
	$(BREADCRUM_ID+' li').removeClass('active');
	$(BREADCRUM_ID+' li#quest'+id).addClass('active');
}

/*
	Défini le texte de la question avec la légende
	@in string question - Texte de la question
	@in string legend - Texte de la légende de la question
*/
function setQuestionText(question, legend)
{
	var legendHtml = ''
	if(legend) legendHtml = '<br/><small>'+legend+'</small>'
	//$(QUESTIONBAR_ID+' h1').html(question+'&nbsp;<i class="permalink-icon" onClick="javascript:permalinkCopy()" title="Permalink">&nbsp;</i>'+legendHtml);
	$(QUESTIONBAR_ID+' h1').html(question+legendHtml);
}

/*
	Affiche ou cache la fernetre qui contient le carousel d'Informations dans la partie QUESTION
	@in bool value - true pour afficher, false pour caché
*/
function setInformationsWindowDisplay(value)
{
	setElementDisplay($(INFORMATION_WINDOW_ID), value);
}

/*
	Affiche ou cache complétement la partie QUESTION
	@in bool value - true pour afficher, false pour caché
*/
function setQuestionFrameDisplay(value)
{
	setElementDisplay($(QUESTION_FRAME_ID), value);
}
/*
	Affiche ou cache complétement la partie RESULTAT
	@in bool value - true pour afficher, false pour caché
*/
function setResultFrameDisplay(value)
{
	setElementDisplay($(RESULT_FRAME_ID), value);
}
/*
	Affiche complétement SOIT la partie QUESTION, SOIT la partie RESULTAT
	@in string value - 'question' pour afficher complétement la partie QUESTION, 'result' pour afficher complétement la partie RESULTAT
*/
function setQuestionResultFrameDisplay(value)
{
	if(value == 'question'){
		setResultFrameDisplay(false);
		setQuestionFrameDisplay(true);
	}
	else if(value == 'result'){
		setQuestionFrameDisplay(false);		
		setResultFrameDisplay(true);
	}
}

/*
	Defini les éléments du carousel qui vont se trouver dans la fenêtre d'Information dans la partie QUESTION
	@in carouselElment[] carouselContent - Tableau de carouselElement (voir en-tête du fichier pour la structure)
*/
function setInformationsWindow(carouselContent)
{
	setInformationsWindowDisplay(true);
	var infoContent = '';

	infoContent +=
		'<div id="carouselQuestion" class="carousel slide carouselQuestion">'+
			'<div class="carousel-inner">';

				for(i=0; i<carouselContent.length; i++)
				{
					infoContent += generateCarouselItem('infosGal', carouselContent[i]);
				}

	infoContent +=		           
			'</div>';
	if(carouselContent.length > 1){
		infoContent +=	
			'<a class="left carousel-control" href="#carouselQuestion" data-slide="prev">‹</a>'+
			'<a class="right carousel-control" href="#carouselQuestion" data-slide="next">›</a>';
	}
	infoContent +=	
		'</div>'+
		'<div style="clear:both;"></div>';

	$(INFORMATIONS_CONTENT_ID).html(infoContent)
}

/*
	Efface toutes les fenêtres de réponse dans la partie QUESTION
*/
function clearResponesWindow()
{
	$(RESPONSES_DIV_ID).html('');
	_carouselResponseId = 0;
}
/*
	Ajoute une réponse dans la partie QUESTION
	@in response myResponse - (voir en-tête du fichier pour la structure)
*/
function addResponseWindow(myResponse)
{
	var responsesContentToAdd = '';
	responsesContentToAdd += 
		'<div class="window responseWindow">'+
		'<ul>'+
			'<li class="windowTitle">'+
	    		'<h3><i class="icon-chevron-right "></i><a href="#" onClick="selectResponse(\''+myResponse.responseId+'\',0)"  title="Valider cette réponse">'+myResponse.title+'</a></h3>'+
	    	'</li>'+
	    	'<li>'+
		        '<div class="responseDivInfo">'+			
		        	'<p>'+myResponse.text+'</p>'+
		        	'<a href="#" onClick="selectResponse(\''+myResponse.responseId+'\',0)" class="btn"><i class="icon-ok"></i> Valider cette réponse</a>'+
		       	'</div>';

	responsesContentToAdd += 
				'<div class="responseDivCarousel" id="carouselResponse'+_carouselResponseId+'">'+
					'<div class="carousel slide carouselResponse">'+
						'<div class="carousel-inner">';		
						
							for(i=0; i<myResponse.carousel.length; i++)
							{
								responsesContentToAdd += generateCarouselItem('respGal'+_carouselResponseId, myResponse.carousel[i]);
							}

	responsesContentToAdd += 
						'</div>';

	if(myResponse.carousel.length > 1){
		responsesContentToAdd += 
		        		'<a class="left carousel-control" href="#carouselResponse'+_carouselResponseId+'" data-slide="prev">‹</a>'+
	        			'<a class="right carousel-control" href="#carouselResponse'+_carouselResponseId+'" data-slide="next">›</a>';
	}
	responsesContentToAdd += 
					'</div>'+
				'</div>';

	responsesContentToAdd += 
	 		 	'<div class="clearer"></div>'+
	 		 '</li>'+
	 	'</ul>'+
		'</div>';

	$(RESPONSES_DIV_ID).append(responsesContentToAdd);

	_carouselResponseId++;
}

/* DEBUG FUNCTIONS */
/*
	Ajoute de texte dans la div de debug
*/
function appendDebug(value){
	setElementDisplay($(DEBUG_FRAME_ID), true, 500);
	$(DEBUG_TEXT_ID).append(value);
	activateFloatableQuestionBar();
	
	setTimeout(
		function(){
			setElementDisplay($(DEBUG_FRAME_ID), false, 500);
		}, 3000);
}
/*
	Ecrit du texte dans la div de debug
*/
function printDebug(value){
	setElementDisplay($(DEBUG_FRAME_ID), true, 500);
	$(DEBUG_TEXT_ID).html(value);
	activateFloatableQuestionBar();
	
	setTimeout(
		function(){
			setElementDisplay($(DEBUG_FRAME_ID), false, 500);
		}, 3000);
}


/***** PRIVATE FUNCTIONS *****/
/*
	Permet de générer une élément de carousel (image, légende, ...)
	@in string shadowboxGallery - Nom de la gallerie (ShadowBox) qui permet de regrouper les images dans le diaporam ShadowBox
	@in carouselElement carouselElement - (voir en-tête du fichier pour la structure)

	@out Code HTML d'un élément de carousel
*/
function generateCarouselItem(shadowboxGallery, carouselElement)
{
	var mediaType = carouselElement.mediaType;
	var mediaId = carouselElement.mediaId;
	var thumbSrc = carouselElement.mediaThumb;
	var mediaSrc = arbre_media_url + "/" + carouselElement.mediaSrc;
	var caption = carouselElement.mediaCaption;
	var title = caption;

	var mediaTypeIconClass = '';

	var isActive = 0;
	if(i == 0) isActive = 1;

	// Type: image
	if(mediaType == 'image'){
		if(!thumbSrc) {
			// S'il s'agit d'une image, on va chercher sa thumbnail dans le dossier
			thumbSrc = arbre_thumbnail_url + "/" + carouselElement.mediaSrc;
		}
	}
	// Type: video
	else if(mediaType == 'video'){
		if(!thumbSrc)
			thumbSrc = images_url + "/" + 'movie-clap.png';

		if(!caption){
			caption = 'Cliquez pour lire la vidéo';
			title = '';
		}

		carouselLabel = 'Cliquez sur l\'image pour lire la vidéo';
		mediaTypeIconClass = 'videoIcon';
	}
	// Type: sound
	else if(mediaType == 'sound'){
		if(!thumbSrc)
			thumbSrc = images_url + "/" + 'speaker.png';

		if(!caption){
			caption = 'Cliquez pour écouter';
			title = '';
		}					

		carouselLabel = 'Cliquez sur l\'image pour écouter';
		mediaTypeIconClass = 'soundIcon';
	}

	var carouselItem = '';

	activeClass = '';
	if(isActive) activeClass = 'active';
	carouselItem += 
  		'<div class="item '+activeClass+'">';

  	if(mediaTypeIconClass){
  		carouselItem +=	'<div id="' + mediaId + '" title="'+carouselLabel+'" class="mediaTypeIcon '+mediaTypeIconClass+'"> </div>';
  	}
/*
  	carouselItem +=
    		'<a href="'+mediaSrc+'" target="_blank" rel="shadowbox['+shadowboxGallery+']" title="'+title+'"><img src="' + thumbSrc+'" alt=""></a>';
    		*/
    carouselItem += '<a href="'+mediaSrc+'" target="_blank" rel="shadowbox" title="'+title+'">';
    carouselItem += '<img src="' + thumbSrc+'" alt="">';
    carouselItem += '</a>';

    if(caption)
    {
	    carouselItem += 
            '<div class="carousel-caption">'+
                //'<!--<h4>Second Thumbnail label</h4>-->'+
                '<p>'+caption+'</p>'+
            '</div>';
	}

	carouselItem += 
		'</div>';

	return carouselItem;
}

/*
	Affiche ou cache un élément quelconque de la page
	@in element - Element à cacher. Il s'agit d'un élément de l'arbre DOM que l'on séléctionne avec jQuery (Ex : $('#idElment'))
	@in bool value - true pour afficher, false pour caché
*/
function setElementDisplay(element, value, time)
{
	if(value){
		if (time) {
			element.fadeIn(time);
		} else {
			element.css('display', 'block');
		}
	}
	else{
		if (time) {
			element.fadeOut(time);
		} else {
			element.css('display', 'none');
		}
	}
}