
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/shadowbox.min.js"></script>
	
	<script type="text/javascript">
	<?php
		$questionId = isset($_GET['questionid']) ? $_GET['questionid'] : '';
		if ($questionId) {
	?>
			var firstQuestionId = '<?php echo $questionId; ?>';
	<?php
		} else {
	?>
			var firstQuestionId ='q1';
	<?php
		}
	?>
	</script>
	
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/contentManagment.js"></script>
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/script.js"></script>
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/permalink.js"></script>
<?php

	if (strcmp($PageType, "quizz") == 0) {
?>
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/quizz.js"></script>
	<!-- Demo Content -->
	<!--<script type="text/javascript" src="js/test.js"></script>-->
<?php
	}
?>

<?php
	if (strcmp($PageType, "login") == 0) {
		
		mt_srand();
		
		echo "\t<script>\n";
		echo "\t\tvar idKey = '" . mt_rand() . "'";
		echo "\t</script>\n";
?>
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/md5.min.js"></script>
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/login.js"></script>
<?php
	}
?>

<?php
	if (strcmp($PageType, "prepareQuizz") == 0) {
?>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfZN9a70ZRFuLhcNNzDm-q_JlkLyWyW3w&sensor=true"></script>
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/prepareQuizz.js"></script>
<?php
	}
?>

<?php
	if (strcmp($PageType, "admin") == 0) {
?>
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/admin.js"></script>
<?php
	}
?>

<?php
	if (strcmp($PageType, "mosaique") == 0) {
?>
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/jail.js"></script>
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/mosaique.js"></script>
	<script type="text/javascript">
		$(function(){
			$('img.lazy').jail();
		});
	</script>
<?php
	}
?>
