/****** DOCUMENT READY *****/

$(document).ready(function() {
	Shadowbox.init();
	activateFloatableQuestionBar();
	// Active la barre de question flotante qui reste haut lorsque l'on scroll

	initContentmanagment();
	// Initialise le "content managment"

	loadAllPulgins();
	// Charge les différents plugins
});

/****** LOAD PLUGINS *****/
/*
 Charge les différents plugins
 */
function loadAllPulgins() {
	Shadowbox.clearCache();
	Shadowbox.setup();

	$('.carousel').carousel();

	// Stop response carousels sliding
	$('.carouselResponse').carousel('pause');
	$('.carouselResponse').off('mouseleave');

	$('.breadcrumb a').tooltip({
		placement : 'bottom'
	});
	/*
	 // NOT IMPLEMENTED ! For permalink
	 $('.permalink-icon').popover({
	 content: '<strong>Cliquez pour copier</strong> le lien "permalink" de cette page dans le presse papier.<br />Ce lien vous permetra d\'<strong>accéder de nouveau à cette question</strong>.'
	 });
	 */
}

/***** ACTIVATE FLOATABLE QUESTION BAR *****/

function activateFloatableQuestionBar() {
	setQuestionResultFrameDisplay('question');
	// Sinon positionElementInPage = 0
	var positionElementInPage = $('#questionTextDivSubNav').offset().top;
	//var elementSpaceHeight = $('#questionTextDivContainer').height();
	var elementSpaceHeight = $('#questionTextDivContainer').css('height');
	$(window).scroll(function() {

		if ($(window).scrollTop() >= positionElementInPage) {
			// fixed
			$('#questionTextDivSubNav').addClass("floatable");
		} else {
			// relative
			$('#questionTextDivSubNav').removeClass("floatable");
			$('#questionTextDivContainer').height(elementSpaceHeight);
		}
	});
}
function getURLParameter(name) {
    return decodeURI(
        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
    );
}
