<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" />

		<title>Campagnes</title>

		<?php
			$PageType    = "prepareQuizz";
			$CurrentPath = "/pages";
			include "parts/variables.php";

			include $PAGE_PART_PATH . "/headCssJs.php";
			include $PAGE_PART_PATH . "/securite.php";
		?>
		<style>
			#sb-wrapper-inner{
				border: none !important;
			}
			#sb-body{
				background-color: transparent !important;
			}
		</style>
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
						</div><h1>Campagnes
						<br>
						<small>Veuillez sélectionner votre campagne</small></h1>
						<div class="clearer"></div>
					</div>
				</div>
			</div>

			<div id="selection-2_3">
				<div id="liste_elem">
					<header>
						<h2>Liste des campagnes</h2>
					</header>
					<section id="liste_campagne">
						Liste des éléments
					</section>
				</div>
				<div id="infos_elem">
					<header>
						<h2>Information</h2>
					</header>
					<section>
						<div class="field">
							Nom<span id="fieldName" class="fieldSpan">&nbsp;</span>
						</div>
						<div class="field">
							Description<span id="fieldDescription" class="fieldSpan">&nbsp;</span>
						</div>
						<div class="field">
							Date de début<span id="fieldDateDebut" class="fieldSpan">&nbsp;</span>
						</div>
						<div class="field">
							Date de fin<span id="fieldDateFin" class="fieldSpan">&nbsp;</span>
						</div>
					</section>
				</div>
				<div class="clearer"></div>
			</div>

			<div class="clearer"></div>
		</div>

		<div id="resultRightDiv" style="display: none;">
			<div class="window" id="resultWindow">
				<ul>
					<li class="windowTitle"><h3><i class="icon-ok"></i>Campagne</h3></li>
					<li id="resultWindowContent">
						<form class="form-horizontal" id="formCampagne">
							<div class="control-group">
								<label class="control-label" for="nom">Nom</label>
								<div class="controls">
									<input id="nom" name="nom" type="text" placeholder="Nom de la Campagne" required autofocus>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="description">Description</label>
								<div class="controls">
									<input id="description" name="description" type="text" placeholder="Description">
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="dateDeb">Date de début</label>
								<div class="controls">
									<input id="dateDeb" name="dateDeb" type="date" placeholder="26/02/2012">
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="dateFin">Date de fin</label>
								<div class="controls">
									<input id="dateFin" name="dateFin" type="date" placeholder="28/02/2012">
								</div>
							</div>

							<div class="control-group">
								<div class="controls">
									<div class="btn-toolbar">
										<div class="btn-group">
											<button class="btn" type="reset">Réinitialiser</button>
											<button class="btn" type="submit">Enregistrer</button>
										</div>
									</div>
								</div>
							</div>

						</form>
					</li>
				</ul>
			</div>
		</div>
		
		
		<?php
			include $PAGE_PART_PATH . "/footer.php";
			include $PAGE_PART_PATH . "/script.php";
		?>
	</body>
</html>