<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" />

		<title>Protocoles</title>

		<?php
			$HEADER = false;
			$CurrentPath = "/pages";
			require_once("parts/variables.php");
	
			include $PAGE_PART_PATH . "/headCssJs.php";
			include $PAGE_PART_PATH . "/securite.php";
		?>
	</head>
	<body>
		<?php
			include $PAGE_PART_PATH . "/header.php";
		?>

		<div id="" class="myContainer">
			<div id="debugText">
				<!--[Debug text]-->
			</div>
		</div>

		<div id="questionFrame" class="myContainer">
			<div id="questionTextDivContainer">
				<div id="questionTextDivSubNav">
					<div id="questionTextDiv" class="myContainer">
						<div id="questionTextIcon"><img src="<?php echo $IMG_PATH; ?>/question-mark.png" alt="icone question">
						</div><h1>Protocoles<br><small>Comment monter les pièges ..</small></h1>
						<div class="clearer"></div>
					</div>
				</div>
			</div>

			<div id="bodyQuestionContent">

				<object data="<?php echo $DOCUMENTS_PATH; ?>/Protocole.pdf" type="text/html" codetype="application/pdf" width="940px" height="650px"></object>

				<div class="clearer"></div>
			</div>
		</div>

		<?php
			include $PAGE_PART_PATH . "/footer.php";
			include $PAGE_PART_PATH . "/script.php";
		?>
	</body>
</html>