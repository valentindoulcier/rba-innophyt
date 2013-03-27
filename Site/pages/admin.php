<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" />

		<title>Administration</title>

		<?php
			$HEADER = false;
			$PageType    = "admin";
			$CurrentPath = "/pages";
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
						<div id="questionTextIcon"><img src="<?php echo $IMG_PATH; ?>/home.png" alt="icone accueil"></div>
						<div><h1>Administration<br><small>Veuillez choisir une action</small></h1></div>
						<div><a id="generateThumbnailButton" class="btn btn-warning btn-large" title="Générer les thumbnail"><h3>Générer les thumbnails</h3></a></div>
						<div class="clearer"></div>
					</div>
				</div>
			</div>
			
			<div id="info" class="alert alert-info" style="display: none;">
				<div class="progress progress-striped active" style=" margin-bottom: 0px;">
			  		<div class="bar" style="width: 100%;"></div>
				</div>
			</div>

			<div id="selection-2_3">
				<div id="liste_elem">
					<header id="title_admin">
						<h2>Liste des utilisateurs<span style="position: relative; float: right;"><a href="#formUser" rel="shadowbox;width=500px;height=410px" title="Ajouter un utilisateur" id="ajoutUser" class="btn btn-info btn-large" onclick="$('.admin').removeAttr('checked'); sessionStorage.setItem(session_action, 'ajouter');">Ajouter un utilisateur</a></span></h2>
					</header>
					<section id="liste_admin">
						<table class="table table-striped table-hover">
							<thead>
								<th>Nom</th>
								<th>Mail</th>
								<th>Type d'authentification</th>
							</thead>
							<tbody id="user_list">
							</tbody>
						</table>
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
							Mail<span id="fieldMail" class="fieldSpan">&nbsp;</span>
						</div>
						<div class="field">
							Administrateur<span id="fieldAdmin" class="fieldSpan">&nbsp;</span>
						</div>
						<div class="field">
							Type d'authentification<span id="fieldTypeAuth" class="fieldSpan">&nbsp;</span>
						</div>
						<div class="field" style="display: none;">
							IP min<span id="fieldIPmin" class="fieldSpan"></span>
						</div>
						<div class="field" style="display: none;">
							IP max<span id="fieldIPmax" class="fieldSpan"></span>
						</div>
						<div class="control-group">
							<div class="controls">
								<div class="btn-toolbar">
									<div class="btn-group" style="margin-left: 10px;">
										<a href="#selectionner-item" rel='shadowbox;width=450px;height=150px' id="modif-item" class="btn btn-link" onclick="loadInfoModif();">Modifier</a>
										<a href="#selectionner-item" rel='shadowbox;width=450px;height=150px' id="delete-item" class="btn btn-link">Supprimer</a>
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
		

		<div id="formUser" style="display: none;">
			<div class="window" id="resultWindow">
				<ul>
					<li class="windowTitle"><h3><i class="icon-ok"></i>Utilisateur</h3></li>
					<li id="resultWindowContent">
						<div class="form-info"></div>
						<form class="form-horizontal formCampagne" action="<?php echo $PHP_SCRIPT_PATH . "/admin.php"; ?>" method="post">
							<div class="control-group">
								<label class="control-label" for="nom">Nom</label>
								<div class="controls">
									<input id="nom" class="nom" name="nom" type="text" placeholder="Nom de l'utilisateur" required autofocus>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="mail">Adresse mail</label>
								<div class="controls">
									<input id="mail" class="mail" name="mail" type="text" placeholder="rba-innophyt@gmail.com" required>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="passwd">Mot de passe</label>
								<div class="controls">
									<input id="passwd" class="passwd" name="passwd" type="password" placeholder="Mot de passe" data-toggle="popover" data-original-title="Attention !" data-content="Si vous ne modifiez pas le mot de passe, laisser ce champ vide.">
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="admin">Administrateur</label>
								<div class="controls">
									<input id="admin" class="admin" name="admin" type="checkbox">
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="ip_min">Adresse IP Basse</label>
								<div class="controls">
									<input id="ip_min" class="ip_min" name="ip_min" type="text" placeholder="10.172.10.12">
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="ip_max">Adresse IP Haute</label>
								<div class="controls">
									<input id="ip_max" class="ip_max" name="ip_max" type="text" placeholder="10.175.25.36">
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

		<?php
			include $PAGE_PART_PATH . "/popupsPrepareQuizz.php";
			include $PAGE_PART_PATH . "/footer.php";
			include $PAGE_PART_PATH . "/script.php";
		?>
	</body>
</html>