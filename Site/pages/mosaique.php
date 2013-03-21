<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" />

		<title>Mosaïque</title>

		<?php
			$CurrentPath = "/pages";
			include "parts/variables.php";
	
			include $PAGE_PART_PATH  . "/headCssJs.php";
			include $PAGE_PART_PATH  . "/securite.php";
			include $PHP_SCRIPT_PATH . "/mosaique.php";
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
				
				<?php
					//echo $nbMedias;
					echo ('<div id="mosaique" class="row">');
					
					$lol = 0;
					
					//echo (' medias<br/><br/>');
					
					for ($numResultat = 0; $numResultat < count($mosaiqueArray); $numResultat++)
					{
					    $lol++;
						$lol1 = 0;
						if(count($mosaiqueArray[$numResultat][5]) != 0) {
							for ($numMedia = 0; $numMedia < count($mosaiqueArray[$numResultat][5]); $numMedia++)
							{?>
								<div class="span1 mosaiqueCell">
									<img src="<?php echo $MEDIA_ARBRE_PATH . "/" .$mosaiqueArray[$numResultat][5][$numMedia][1]; ?>" alt="icone mosaique" class="ico-mosaique"/>
								</div>
							<?php
							    $lol1++;
							}
							//echo $lol1;
							//echo (' media(s) pour le resultat ' . $numResultat . ' <br/>');
						}
					}
					//echo $lol;
					//echo (' resultats<br/><br/>');
					
					echo ('</div>');

					var_dump($mosaiqueArray);
					
					//echo "<a href='#' title='identification de bob' onclick='sessionStorage.setItem(\"insecte_selectionne-rba\", " . "res1" . ")'><img src='" . $mosaiqueArray['res1']['media']['media1'] . "'/></a>";
				?>

				<div class="clearer"></div>
			</div>
		</div>

		<?php
			include $PAGE_PART_PATH . "/footer.php";
			include $PAGE_PART_PATH . "/script.php";
		?>
	</body>
</html>