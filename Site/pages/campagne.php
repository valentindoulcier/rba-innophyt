<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" />

		<title>Menu</title>

		<?php
			$PageType    = "prepareQuizz";
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
						</div><h1>Campagne<br><small>Veuillez sélectionner votre campagne</small></h1>
						<div class="clearer"></div>
					</div>
				</div>
			</div>
			
			<div id="selection-2_3">
				<div id="liste_elem">
					<header><h2>Liste des campagnes</h2></header>
					<section id="liste_campagne">
						Liste des éléments
					</section>
				</div>
				<div id="infos_elem">
					<header><h2>Information</h2></header>
					<section>
						<div class="field">Nom<span id="fieldName" class="fieldSpan">2013</span></div>
						<div class="field">Description<span id="fieldDescription" class="fieldSpan">Je fais une belle est longue description de merde</span></div>
						<div class="field">Date de début<span id="fieldDateDebut" class="fieldSpan">10/03/2013</span></div>
						<div class="field">Date de fin<span id="fieldDateFin" class="fieldSpan">31/03/2013</span></div>
						
						<a rel="shadowbox" href="menu.php">kjwshvkhbqsdkjfsd</a>
					</section>
				</div>
				<div class="clearer"></div>
			</div>
			
			<div class="clearer"></div>
		</div>
		
		
		<?php
			include $PAGE_PART_PATH . "/footer.php";
			include $PAGE_PART_PATH . "/script.php";
		?>
	</body>
</html>