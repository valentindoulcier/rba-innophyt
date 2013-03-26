function loadSubmitFormAction() {
	$('#generateThumbnailButton').bind('click', function(e) {
		$('#Blop').fadeIn(500);
		$.ajax({
			type : "POST",
			//url : php_script_url + "/createThumbnail.php",
			success : function(msg) {
				$('#Blop').fadeOut(500);
				//$('#liste_admin').html("OOKKKKEEEEE !!!!!!<br/>" + msg);
			},
			error : function(jqXHR, textStatus, errorThrown) {
				console.error("Creation fail : " + textStatus + " - " + errorThrown);
				alert('fail');
			}
		});
		e.preventDefault();
		return false;
	});
}

/****** DOCUMENT READY *****/

$(document).ready(function() {
	loadSubmitFormAction();
});