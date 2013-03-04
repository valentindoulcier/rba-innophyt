
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/shadowbox.min.js"></script>
	
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
	
	<script type="text/javascript" src="js/permalink.js"></script> 
	<script type="text/javascript" src="js/contentManagment.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<!-- Demo Content -->
	<!--<script type="text/javascript" src="js/test.js"></script>-->