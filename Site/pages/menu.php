<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" />

		<title>Menu</title>

		<?php
			$HEADER = false;
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
					<a href="<?php echo $PROTOCOLES_URL?>" title="Liste des protocoles"><img src="<?php echo $IMG_PATH ?>/vache1.png" alt="icone questionnaire" class="ico-accueil"/></a>
				</div>
				<div class="span3 cell">
					<a href="<?php echo $CAMPAGNE_URL?>" title="Accès au choix des campagnes / parcelles / pièges"><img src="<?php echo $IMG_PATH ?>/vache2.png" alt="icone questionnaire" class="ico-accueil"/></a>
				</div>
				<div class="span3 cell">
					<a href="<?php echo $QUIZZ_URL?>" title="Accès à l'arbre d'identification"><img src="<?php echo $IMG_PATH ?>/vache3.png" alt="icone questionnaire" class="ico-accueil"/></a>
				</div>
				<div class="span3 cell">
					<a href="<?php echo $MOSAIQUE_URL?>" title="Accès à la mosaïque"><img src="<?php echo $IMG_PATH ?>/vache4.png" alt="icone questionnaire" class="ico-accueil"/></a>
				</div>
				<div class="span3 cell">
					<a id="exportCSV" href="<?php echo($PHP_SCRIPT_PATH)?>/exportCSV.php?idKey=" title="Export des données"><img src="<?php echo $IMG_PATH ?>/vache5.png" alt="icone questionnaire" class="ico-accueil"/></a>
				</div>
				<div id="adminCell" class="span3 cell">
					
				</div>
			</div>
		</div>
		
		

		<?php
			include $PAGE_PART_PATH . "/footer.php";
			include $PAGE_PART_PATH . "/script.php";
		?>
	</body>
</html>