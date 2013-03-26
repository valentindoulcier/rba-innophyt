function loadSubmitFormAction() {
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

function blockClick () {
	event.preventDefault();
	return false;
}

/****** DOCUMENT READY *****/

$(document).ready(function() {
	loadSubmitFormAction();
});