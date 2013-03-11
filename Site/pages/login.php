<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" />

		<title>Connexion</title>

		<?php
			$PageType    = "login";
			$CurrentPath = "/pages";
			include "parts/variables.php";
			
			include $PAGE_PART_PATH . "/headCssJs.php";
			// On désactive le module de sécurité sur la page de login car l'utilisateur doit s'authentifier
			//include $PAGE_PART_PATH . "/securite.php";
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
						</div><h1>Connexion<br><small>Veuillez vous identifier</small></h1>
						<div class="clearer"></div>
					</div>
				</div>
			</div>
			
			<div id="menu">
				<div id="connection-form">
					
					<div id="login-info"></div>
					
					<form class="form-horizontal" id="rba-innophyt-connection">
						<div class="control-group">
							<label class="control-label" for="loginEmail">Email</label>
							<div class="controls">
								<input type="text" id="loginEmail" placeholder="Email">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="loginPass">Mot de passe</label>
							<div class="controls">
								<input type="password" id="loginPass" placeholder="Mot de passe">
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<label class="checkbox"><input type="checkbox" id="remember-me">Se souvenir de moi</label>
								<button type="submit" class="btn">Connexion</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<?php
			include $PAGE_PART_PATH . "/footer.php";
			include $PAGE_PART_PATH . "/script.php";
		?>
	</body>
</html>