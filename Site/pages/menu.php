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
						</div><h1>Accueil<br><small>Veuillez choisir un élément</small></h1>
						<div class="clearer"></div>
					</div>
				</div>
			</div>
			
			<div id="menu" class="row">
				<div class="span3 cell">
					<a href="<?php echo $PROTOCOLES_URL?>" title="Liste des protocoles">
						<img src="<?php echo $IMG_PATH ?>/vache1.png" alt="icone questionnaire" class="ico-accueil"/>
						<h3 class="overMenuItem">Protocoles</h3>
					</a>
				</div>
				<div class="span3 cell">
					<a href="<?php echo $CAMPAGNE_URL?>" title="Accès au choix des campagnes / parcelles / pièges" onclick="sessionStorage.setItem(session_save, 'true');">
						<img src="<?php echo $IMG_PATH ?>/vache2.png" alt="icone questionnaire" class="ico-accueil"/>
						<h3 class="overMenuItem">Expérimentation</h3>
					</a>
				</div>
				<div class="span3 cell">
					<a href="#selectionner-item" title="Accès à l'arbre d'identification" rel='shadowbox;width=450px;height=155px' onclick="sessionStorage.setItem('item-rba-menu', 'quizz');">
						<img src="<?php echo $IMG_PATH ?>/vache3.png" alt="icone questionnaire" class="ico-accueil"/>
						<h3 class="overMenuItem">Identification</h3>
					</a>
				</div>
				<div class="span3 cell">
					<a href="#selectionner-item" title="Accès à la mosaïque" rel='shadowbox;width=450px;height=155px' onclick="sessionStorage.setItem('item-rba-menu', 'mosaique');">
						<img src="<?php echo $IMG_PATH ?>/vache4.png" alt="icone questionnaire" class="ico-accueil"/>
						<h3 class="overMenuItem">Mosaïque</h3>
					</a>
				</div>
				<div class="span3 cell">
					<a id="exportCSV" href="<?php echo($PHP_SCRIPT_PATH)?>/exportCSV.php?idKey=" title="Export des données">
						<img src="<?php echo $IMG_PATH ?>/vache5.png" alt="icone questionnaire" class="ico-accueil"/>
						<h3 class="overMenuItem">Export</h3>
					</a>
				</div>
				<div id="adminCell" class="span3 cell">
					
				</div>
			</div>
		</div>
		
		
		<div id="selectionner-item" style="display: none;">
			<div class="window" id="resultWindow">
				<ul>
					<li class="windowTitle"><h3><i class="icon-ok"></i>Attention</h3></li>
					<li id="resultWindowContent">
							
						<div class="control-group">
							<div class="controls">
								<p class="lead">Les données ne pourront pas être enregistrées.</p>
							</div>
						</div>
							
						<div class="control-group">
							<div class="controls">
								<div class="btn-toolbar">
									<div class="btn-group" style="margin-left: 150px; margin-top: 10px;">
										<a href="#" id="cancel-form" class="btn" onclick="Shadowbox.close();">Annuler</a>
										<a href="#" id="continue-form" class="btn btn-warning continue-form" onclick="sessionStorage.setItem(session_save, 'false');">Continuer</a>
										<script>
											$('.cell').bind('click', function() {
												setTimeout( function() {
													if (sessionStorage.getItem('item-rba-menu') == 'quizz') {
														$('.continue-form').attr('href', '<?php echo $QUIZZ_URL?>');
													} else if (sessionStorage.getItem('item-rba-menu') == 'mosaique') {
														$('.continue-form').attr('href', '<?php echo $MOSAIQUE_URL?>');
													}
												}, 1500);
											});
										</script>
									</div>
								</div>
							</div>
						</div>
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