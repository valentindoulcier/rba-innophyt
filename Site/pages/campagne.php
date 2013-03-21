<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" />

		<title>Campagnes</title>

		<?php
			$HEADER = false;
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
						</div><h1>Campagnes<br><small>Veuillez sélectionner votre campagne</small></h1>
						<div class="clearer"></div>
					</div>
				</div>
			</div>

			<div id="selection-2_3">
				<div id="liste_elem">
					<header id="title_campagne">
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
							Date de début<span id="fieldDateDebut" class="fieldSpan">&nbsp;</span>
						</div>
						<div class="field">
							Date de fin<span id="fieldDateFin" class="fieldSpan">&nbsp;</span>
						</div>

						<div class="control-group">
							<div class="controls">
								<div class="btn-toolbar">
									<div class="btn-group" style="margin-left: 10px;">
										<a href="#selectionner-item" rel='shadowbox;width=400px;height=109px' id="modif-item" class="btn btn-link" onclick="loadInfoModif();">Modifier</a>
										<a href="#selectionner-item" rel='shadowbox;width=400px;height=109px' id="delete-item" class="btn btn-link">Supprimer</a>
									</div>
									<div class="btn-group">
										<a href="#selectionner-item" rel='shadowbox;width=400px;height=109px' id="choose-item" class="btn btn-large btn-success">Suivant</a>
									</div>
								</div>
							</div>
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
						<div class="form-info"></div>
						<form class="form-horizontal formCampagne" action="<?php echo $PHP_SCRIPT_PATH . "/campagne.php"; ?>" method="post">
							<div class="control-group">
								<label class="control-label" for="nom">Nom</label>
								<div class="controls">
									<input id="nom" class="nom" name="nom" type="text" placeholder="Nom de la Campagne" required autofocus>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="description">Description</label>
								<div class="controls">
									<input id="description" class="description" name="description" type="text" placeholder="Description">
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
							
							<input id="idKey-field" class="idKey-field" name="idKey" type="hidden">
							<input id="action-field" class="action-field" name="action" type="hidden">
							<input id="id-field" class="id-field" name="id" type="hidden">
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
		
		

		<div id="deleteForm" style="display: none;">
			<div class="window" id="resultWindow">
				<ul>
					<li class="windowTitle"><h3><i class="icon-ok"></i>Suppression de la campagne</h3></li>
					<li id="resultWindowContent">
						<div class="control-group">
							<div class="controls">
								<div class="btn-toolbar">
									<div class="btn-group" style="margin-left: 120px;">
										<a href="#" id="cancel-form" class="btn" onclick="Shadowbox.close();">Annuler</a>
										<a href="#" id="submit-form" class="btn btn-danger" onclick="deleteItem();">Supprimer</a>
									</div>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
		
		

		<div id="selectionner-item" style="display: none;">
			<div class="window" id="resultWindow">
				<ul>
					<li class="windowTitle"><h3><i class="icon-ok"></i>Sélectionner une campagne</h3></li>
					<li id="resultWindowContent">
						<div class="control-group">
							<div class="controls">
								<div class="btn-toolbar">
									<div class="btn-group" style="margin-left: 150px;">
										<a href="#" id="cancel-form" class="btn" onclick="Shadowbox.close();">Fermer</a>
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