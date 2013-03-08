<?php
	$JS_PATH = "../js";
	$CSS_PATH = "../css";
	$IMG_PATH = "../images";
	
	$PageType = "page";
?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" />

		<title>Site title here !</title>

		<?php
			include "parts/headCssJs.php";
		?>
	</head>
	<body>
		<?php
			include "parts/header.php";
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
				<div class="span3 cell">
					<a href="#" title=""><img src="<?php echo $IMG_PATH ?>/questionnaire.png" alt="icone questionnaire" class="ico-accueil"/></a>
				</div>
				<div class="span3 cell">
					<a href="#" title=""><img src="<?php echo $IMG_PATH ?>/questionnaire.png" alt="icone questionnaire" class="ico-accueil"/></a>
				</div>
			</div>
		</div>
		
		

		<?php
			include "parts/footer.php";
			include "parts/script.php";
		?>
	</body>
</html>