<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" />

		<title>Arbre de question</title>

		<?php
			$HEADER = false;
			$PageType = "quizz";
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

		<div id="questionFrame" class="myContainer">
			<div id="questionTextDivContainer">
				<div id="questionTextDivSubNav">
					<div id="questionTextDiv" class="myContainer">
						<div id="questionTextIcon"><img src="<?php echo $IMG_PATH; ?>/question-mark.png" alt="icone question">
						</div><h1><!--[Question]--><br><small><!--[Legend]--></small></h1>
						<div class="clearer"></div>
					</div>
				</div>
			</div>

		<!--<div id="" class="myContainer">-->
			<div id="debugText">
				<!--[Debug text]-->
			</div>
		<!--</div>-->

			<div id="bodyQuestionContent">

				<div id="responsesDiv">
					<!--[Responses]-->
				</div>
				<div id="questionInfoDiv">

					<div class="window" id="informationsWindow">
						<ul>
							<li class="windowTitle">
								<h3><i class="icon-info-sign"></i>Informations</h3>
							</li>
							<li id="questionInfoContent">
								<!--[Informations carsousel]-->
							</li>
						</ul>
					</div>
					<div class="window" id="webcamWindow">
						<ul>
							<li class="windowTitle">
								<h3><i class="icon-eye-open"></i>Web-cam</h3>
							</li>
							<li>
								<object type="application/x-shockwave-flash" data="<?php echo $LIB_PATH; ?>/webcam/webcamvid.swf"  width="434" height="300">
									<param name="webcam" value="webcamvid.swf">
								</object>
							</li>
						</ul>
					</div>
				</div>

				<div class="clearer"></div>
			</div>
		</div>

		<div id="resultFrame" class="myContainer">
			<div id="bodyResultContent">

				<div id="resultLeftDiv">
					<div class="window" id="resultCarouselWindow">
						<ul>
							<li class="windowTitle">
								<h3><i class="icon-picture"></i>Images</h3>
							</li>
							<li id="resultCarouselWindowContent">
								Blabla
							</li>
						</ul>
					</div>
				</div>
				<div id="resultRightDiv">
					<div class="window" id="resultWindow">
						<ul>
							<li class="windowTitle">
								<h3><i class="icon-ok"></i>Résultat</h3>
							</li>
							<li id="resultWindowContent">
								Blabla
							</li>
						</ul>
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