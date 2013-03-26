<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" />

		<title>Mosaïque</title>

		<?php
			$HEADER = false;
			$PageType    = "mosaique";
			$CurrentPath = "/pages";
			require_once("parts/variables.php");
	
			include $PAGE_PART_PATH  . "/headCssJs.php";
			include $PAGE_PART_PATH  . "/securite.php";
			include $PHP_SCRIPT_PATH . "/mosaique.php";
		?>
	</head>
	<body>
		<?php
			include $PAGE_PART_PATH . "/header.php";
			$count = 0;
			$extension;
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
						</div><h1>Mosaïque<br><small>Présentation des bestioles</small></h1>
						<div class="clearer"></div>
					</div>
				</div>
			</div>

			<div id="bodyQuestionContent">
				
				<?php
					afficher();
				?>

				<div class="clearer"></div>
			</div>
		</div>

		<?php
			include $PAGE_PART_PATH . "/footer.php";
			include $PAGE_PART_PATH . "/script.php";
		?>
	</body>
</html>