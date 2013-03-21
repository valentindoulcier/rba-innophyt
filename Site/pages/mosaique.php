<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" />

		<title>Mosaïque</title>

		<?php
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
						</div><h1>Mosaïque<br><small>Présentation des bestioles</small></h1>
						<div class="clearer"></div>
					</div>
				</div>
			</div>

			<div id="bodyQuestionContent">

				<a class="btn btn-primary" href="<?php echo($PHP_SCRIPT_PATH)?>/mosaique.php" type="button">Charger Mosaique</a>
				
				<!--
				<?php
					$myArray = array('res1' => array('nom' => 'MEJ', 'type' => 'Phytophage', 'regime' => 'Carnivore', 'info' => 'une info', 'media' => array('media1' => 'URL du média')));
					var_dump($myArray);
					
					echo "<a href='recolte.php' title='identification de bob' onclick='sessionStorage(\"insecte_selectionne-rba\", " . "res1" . ")'><img src='" . $myArray['res1']['media']['media1'] . "'/></a>";
				?>
				-->

				<div class="clearer"></div>
			</div>
		</div>

		<?php
			include $PAGE_PART_PATH . "/footer.php";
			include $PAGE_PART_PATH . "/script.php";
		?>
	</body>
</html>