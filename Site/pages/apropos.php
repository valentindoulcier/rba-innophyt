<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" />

		<title>A Propos</title>

		<?php
			$HEADER = false;
			$CurrentPath = "/pages";
			require_once("parts/variables.php");
	
			include $PAGE_PART_PATH . "/headCssJs.php";
			include $PAGE_PART_PATH . "/securite.php";
		?>
	</head>
	<body>
		<?php
			include $PAGE_PART_PATH . "/header.php";
		?>

		<div id="" class="myContainer">
			<div id="debugText">
				<!--[Debug text]-->
			</div>
		</div>

		<div id="questionFrame" class="myContainer">
			<div id="questionTextDivContainer">
				<div id="questionTextDivSubNav">
					<div id="questionTextDiv" class="myContainer">
						<div id="questionTextIcon"><img src="<?php echo $IMG_PATH; ?>/question-mark.png" alt="icone question">
						</div><h1>A propos<br><small></small></h1>
						<div class="clearer"></div>
					</div>
				</div>
			</div>

			<div id="bodyQuestionContent">

				<div class="tabbable"> <!-- Only required for left/right tabs -->
  					<ul class="nav nav-tabs">
    					<li class="active"><a href="#tab1" data-toggle="tab">Acteurs</a></li>
    					<li><a href="#tab2" data-toggle="tab">Comment faire ?</a></li>
    					<li><a href="#tab3" data-toggle="tab">Bibiographie</a></li>
  					</ul>
  					
  					<div class="tab-content">
    					<div class="tab-pane active" id="tab1">
   					   		<div id="resultRightDiv" style="width: 945px;">
								<div class="window" id="resultWindow">
									<ul>
										<li class="windowTitle">
											<h3><i class="icon-ok"></i>Financeurs</h3>
										</li>
										<li id="resultWindowContent">
											<div class="row partenaire">
												<div class="span3 cell">
													<a href="#" title=""><img src="<?php echo $APROPOS_PATH; ?>/financeur1.jpg" alt="icone questionnaire" class="ico-apropos"/></a>
												</div>
												<div class="span3 cell">
													<a href="#" title=""><img src="<?php echo $APROPOS_PATH; ?>/financeur2.jpg" alt="icone questionnaire" class="ico-apropos"/></a>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
							
							<div id="resultRightDiv" style="width: 945px;">
								<div class="window" id="resultWindow">
									<ul>
										<li class="windowTitle">
											<h3><i class="icon-ok"></i>Auteurs</h3>
										</li>
										<li id="resultWindowContent">
											<div class="row partenaire">
												<div class="span3 cell">
													<a href="#" title=""><img src="<?php echo $APROPOS_PATH; ?>/auteur1.jpg" alt="icone questionnaire" class="ico-apropos"/></a>
												</div>
												<div class="span3 cell">
													<a href="#" title=""><img src="<?php echo $APROPOS_PATH; ?>/auteur2.png" alt="icone questionnaire" class="ico-apropos"/></a>
												</div>
												<div class="span3 cell">
													<a href="#" title=""><img src="<?php echo $APROPOS_PATH; ?>/auteur3.gif" alt="icone questionnaire" class="ico-apropos"/></a>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
							
							<div id="resultRightDiv" style="width: 945px;">
								<div class="window" id="resultWindow">
									<ul>
										<li class="windowTitle">
											<h3><i class="icon-ok"></i>Partenaires</h3>
										</li>
										<li id="resultWindowContent">
											<div class="row partenaire">
												<div class="span3 cell">
													<a href="#" title=""><img src="<?php echo $APROPOS_PATH; ?>/partenaire1.png" alt="icone questionnaire" class="ico-apropos"/></a>
												</div>
												<div class="span3 cell">
													<a href="#" title=""><img src="<?php echo $APROPOS_PATH; ?>/partenaire2.jpg" alt="icone questionnaire" class="ico-apropos"/></a>
												</div>
												<div class="span3 cell">
													<a href="#" title=""><img src="<?php echo $APROPOS_PATH; ?>/partenaire3.jpg" alt="icone questionnaire" class="ico-apropos"/></a>
												</div>
												<div class="span3 cell">
													<a href="#" title=""><img src="<?php echo $APROPOS_PATH; ?>/partenaire4.jpg" alt="icone questionnaire" class="ico-apropos"/></a>
												</div>
												<div class="span3 cell">
													<a href="#" title=""><img src="<?php echo $APROPOS_PATH; ?>/logoINRA.jpg" alt="icone questionnaire" class="ico-apropos"/></a>
												</div>
												<div class="span3 cell">
													<a href="#" title=""><img src="<?php echo $APROPOS_PATH; ?>/partenaire6.jpg" alt="icone questionnaire" class="ico-apropos"/></a>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
   						</div>
   						
   						<div class="tab-pane" id="tab2">
      						<div id="resultRightDiv" style="width: 945px;">
								<div class="window" id="resultWindow">
									<ul>
										<li class="windowTitle">
											<h3><i class="icon-ok"></i>Version Pro de la méthode RBA - Insect Id</h3>
										</li>
										<li id="resultWindowContent">
											<p>
												Cette application vous permet d'identifier facilement des insectes à l'aide d'un arbre de question ou d'une
												mosaïque d'images. Elle propose également la consultation, l'interprétation et l'exportation de vos résultats.
											</p>
											<p>
												Afin d'afficher les différents graphiques de l'application, la librairie AChartEngine est utilisée. AChartEnfine
												a pour license Apache Version 2.0.
												Cette licence est disponible à l'adresse suivante : <a href="http://www.apache.org/licenses/LICENSE-2.0" onclick="window.open(this.href, 'apache'); return false;">Apache 2.0</a>
											</p>
											<p>
												Une application mobile qui permet à l'utilisateur, directement sur le terrain, de déterminer le type de l'insecte
												et de décider s'il est nuisible ou non. L'application va poser un certain nombre de questions et va déduire des choses
												à partir des réponses obtenues (via l'arbre de décision). Celle-ci propose à l'utilisateur différents médias (photo, vidéos,
												sons, animations...) pour l'aider à prendre une décision.
												Elle permets aussi de fournir un rapport des actions effectuées sur celle-ci (espèces inconnues, questions/réponses floues, 
												résultat...) pour permettre à l'équipe INNOPHYT de corriger ou de faire évoler la base.
											</p>
											<p>
												La tablette est l'outil utiliserpar les biologistes de terrain. Elle doit permettre d'exploiter le fichier XML conçu via
												le logiciel bureau. Un utilisateur doit pouvoir, via une série de questions, associer l'insecte qu'il observe sous la caméra
												avec une morpho-espèce de notre base de données. Pour cela, il dispose d'aide textuelle, ou visuelle lui permettant de repérer
												les points clés sur les insectes permettant leurs identifications.
											</p>
											<p>
												L'application tablette est destinée à des personnes non scientifiques. Ceci a été très important pour nous puisqu'il a fallu
												concevoir une interface graphique adaptée, simple, sans terme technique particulier et tout en gardant en tête que la personne 
												devait pouvoir se retrouver facilement sans aucune connaissance pré requise.
											</p>
										</li>
									</ul>
								</div>
							</div>
    					</div>
    					
    					<div class="tab-pane" id="tab3">
      						<div id="resultRightDiv" style="width: 945px;">
								<div class="window" id="resultWindow">
									<ul>
										<li class="windowTitle">
											<h3><i class="icon-ok"></i>Bibiographie</h3>
										</li>
										<li id="resultWindowContent">
											<p>
												Insectes de France et d'Europe occidentale - Michael CHINERY (Auteur)
											</p>
										</li>
									</ul>
								</div>
							</div>
    					</div>
  					</div>
				</div>
				
				<div class="clearer"></div>
			</div>
		</div>

		<?php
			include $PAGE_PART_PATH . "/footer.php";
			include $PAGE_PART_PATH . "/script.php";
		?>
	</body>
</html>