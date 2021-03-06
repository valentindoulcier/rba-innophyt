<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" />

		<title>Parcelles</title>

		<?php
			$HEADER = false;
			$PageType    = "prepareQuizz";
			$CurrentPath = "/pages";
			$Component   = array("GoogleMap");
			require_once("parts/variables.php");

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
						</div><h1>Parcelles<br><small>Veuillez sélectionner votre parcelle</small></h1>
						<div class="clearer"></div>
					</div>
				</div>
			</div>

			<div id="selection-2_3">
				<div id="liste_elem">
					<header id="title_parcelle">
						<h2>Liste des parcelles</h2>
					</header>
					<section id="liste_parcelle">
						Liste des éléments
					</section>
					<section id="map" style='display: none;'>
						<div id="map-canvas">
							<div class="clearer"></div>
						</div>
						<div id="map-marker-legend">
							<img src="<?php echo $IMG_PATH ?>/mapMarkers/googleMapsMarkerYellow.png" atl="Marqueur Jaune" class="markerLegend" /> Bol Jaune
							<img src="<?php echo $IMG_PATH ?>/mapMarkers/googleMapsMarkerGreen.png" atl="Marqueur Vert" class="markerLegend" /> Tente Malaise
							<img src="<?php echo $IMG_PATH ?>/mapMarkers/googleMapsMarkerBlue.png" atl="Marquer Bleu" class="markerLegend" /> Piège Barber
							<img src="<?php echo $IMG_PATH ?>/mapMarkers/googleMapsMarkerRed.png" atl="Marqueur Rouge" class="markerLegend" /> Type Inconnu
							<div class="clearer"></div>
						</div>
					</section>
				</div>
				<div id="infos_elem">
					<header>
						<h2>Information</h2>
					</header>
					<section>
						<div class="field" style="display: none;">
							Id<span id="fieldId" class="fieldSpan"></span>
						</div>
						<div class="field">
							Nom<span id="fieldName" class="fieldSpan">&nbsp;</span>
						</div>
						<div class="field">
							Description<span id="fieldDescription" class="fieldSpan">&nbsp;</span>
						</div>
						<div class="field">
							Lieu<span id="fieldAdresse" class="fieldSpan">&nbsp;</span>
						</div>
						<div class="field">
							Date de début<span id="fieldDateDebut" class="fieldSpan">&nbsp;</span>
						</div>
						<div class="field">
							Date de fin<span id="fieldDateFin" class="fieldSpan">&nbsp;</span>
						</div>
						<div class="field">
							Latitude<span id="fieldLatitude" class="fieldSpan">&nbsp;</span>
						</div>
						<div class="field">
							Longitude<span id="fieldLongitude" class="fieldSpan">&nbsp;</span>
						</div>

						<div class="control-group">
							<div class="controls">
								<div class="btn-toolbar">
									<div class="btn-group" style="margin-left: 10px;">
										<a href="#selectionner-item" rel='shadowbox;width=450px;height=150px' id="modif-item" class="btn btn-link" onclick="loadInfoModif();">Modifier</a>
										<a href="#selectionner-item" rel='shadowbox;width=450px;height=150px' id="delete-item" class="btn btn-link">Supprimer</a>
									</div>
									<div class="btn-group">
										<a href="#selectionner-item" rel='shadowbox;width=450px;height=150px' id="choose-item" class="btn btn-large btn-success">Suivant</a>
									</div>
									<br/>
									<div class="btn-group" style="margin-left: 25px; margin-top: 5px;">
										<a href="#selectionner-item" rel='shadowbox;width=450px;height=150px' id="googleMap-item" class="btn btn-link">Carte des pièges</a>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
				<div class="clearer"></div>
			</div>
		</div>

		<div id="resultRightDiv" style="display: none;">
			<div class="window" id="resultWindow">
				<ul>
					<li class="windowTitle"><h3><i class="icon-ok"></i>Parcelle</h3></li>
					<li id="resultWindowContent">
						<div class="form-info"></div>
						<form class="form-horizontal formCampagne" action="<?php echo $PHP_SCRIPT_PATH . "/parcelle.php"; ?>" method="post">
							<div class="control-group">
								<label class="control-label" for="nom">Nom</label>
								<div class="controls">
									<input id="nom" class="nom" name="nom" type="text" placeholder="Nom de la parcelle" required autofocus>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="description">Description</label>
								<div class="controls">
									<input id="description" class="description" name="description" type="text" placeholder="Description">
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="description">Lieu</label>
								<div class="controls">
									<input id="adresse" class="adresse" name="adresse" type="text" placeholder="Lieu">
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="dateDeb">Date de début</label>
								<div class="controls">
									<input id="dateDeb" class="dateDeb" name="dateDeb" type="text" placeholder="2013-02-24">
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="dateFin">Date de fin</label>
								<div class="controls">
									<input id="dateFin" class="dateFin" name="dateFin" type="text" placeholder="2013-05-30">
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="dateFin">Latitude</label>
								<div class="controls">
									<input id="latitude" class="latitude" name="latitude" type="text" placeholder="47.3590900">
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="dateFin">Longitude</label>
								<div class="controls">
									<input id="longitude" class="longitude" name="longitude" type="text" placeholder="3.3852100">
								</div>
							</div>
							
							<input id="idKey-field" class="idKey-field" name="idKey" type="hidden">
							<input id="action-field" class="action-field" name="action" type="hidden">
							<input id="id-field" class="id-field" name="id" type="hidden">
							<input id="campagne-id-field" class="campagne-id-field" name="campagneId" type="hidden">
							<script type="text/javascript">
								$('.idKey-field').val(authInfo.idKeyMd5);
							</script>

							<div class="control-group">
								<div class="controls">
									<div class="btn-toolbar">
										<div class="btn-group">
											<a href="#" id="cancel-form" class="btn" onclick="Shadowbox.close();">Annuler</a>
											<a href="#" id="reinit-form" class="btn" onclick="setEmptyForm();">Réinitialiser</a>
											<a href="#" id="submit-form" class="btn btn-success" onclick="$('.action-field').val(sessionStorage.getItem(session_action)); javascript:submit()">Enregistrer</a>
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
			include $PAGE_PART_PATH . "/popupsPrepareQuizz.php";
			include $PAGE_PART_PATH . "/footer.php";
			include $PAGE_PART_PATH . "/script.php";
		?>
	</body>
</html>