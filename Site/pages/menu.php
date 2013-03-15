<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" />

		<title>Menu</title>

		<?php
			$PageType    = "page";
			$CurrentPath = "/pages";
			include "parts/variables.php";

			include $PAGE_PART_PATH . "/headCssJs.php";
			include $PAGE_PART_PATH . "/securite.php";
		?>
	</head>
	<body>
		<?php
			include $PAGE_PART_PATH . "/header.php";
		?>

		<div id="debugFrame" class="myContainer">
			<div id="debugText">
				<!--[Debug text]-->
			</div>
		</div>
	
		<div id="questionFrame" class="myContainer">
			<div id="questionTextDivContainer">
				<div id="questionTextDivSubNav">
					<div id="questionTextDiv" class="myContainer">
						<div id="questionTextIcon"><img src="<?php echo $IMG_PATH; ?>/home.png" alt="icone accueil">
						</div><h1>Accueil<br><small>Veuillez choisir un élément</small></h1>
						<div class="clearer"></div>
					</div>
				</div>
			</div>
			
			<div id="menu" class="row">
				<div class="span3 cell">
					<a href="<?php echo $PROTOCOLES_URL?>" title=""><img src="<?php echo $IMG_PATH ?>/vache.png" alt="icone questionnaire" class="ico-accueil"/></a>
				</div>
				<div class="span3 cell">
					<a href="<?php echo $QUIZZ_URL?>" title=""><img src="<?php echo $IMG_PATH ?>/vache.png" alt="icone questionnaire" class="ico-accueil"/></a>
				</div>
				<div class="span3 cell">
					<a href="#" title=""><img src="<?php echo $IMG_PATH ?>/questionnaire.png" alt="icone questionnaire" class="ico-accueil"/></a>
				</div>
				<div class="span3 cell">
					<a href="#" title=""><img src="<?php echo $IMG_PATH ?>/questionnaire.png" alt="icone questionnaire" class="ico-accueil"/></a>
				</div>
				<div class="span3 cell">
					<a href="#" title=""><img src="<?php echo $IMG_PATH ?>/questionnaire.png" alt="icone questionnaire" class="ico-accueil"/></a>
				</div>
				<div class="span3 cell">
					<a href="#" title=""><img src="<?php echo $IMG_PATH ?>/questionnaire.png" alt="icone questionnaire" class="ico-accueil"/></a>
				</div>
			</div>
		</div>
		
		

		<?php
			include $PAGE_PART_PATH . "/footer.php";
			include $PAGE_PART_PATH . "/script.php";
		?>
	</body>
</html>