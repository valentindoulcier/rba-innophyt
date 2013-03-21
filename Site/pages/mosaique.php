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
			$count = 0;
			$extension;
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
								<div id="<?php echo $mosaiqueArray[$numResultat][5][$numMedia][0] ?>" class="span1 mosaiqueCell" data-idRes="<?php echo $mosaiqueArray[$numResultat][0] ?>" data-nom="<?php echo $mosaiqueArray[$numResultat][1] ?>" data-type="<?php echo $mosaiqueArray[$numResultat][2] ?>" data-regimeAlimentaire="<?php echo $mosaiqueArray[$numResultat][3] ?>" data-informations="<?php echo $mosaiqueArray[$numResultat][4] ?>" data-mediaId="<?php echo $mosaiqueArray[$numResultat][5][$numMedia][0] ?>" data-mediaChemin="<?php echo $mosaiqueArray[$numResultat][5][$numMedia][1] ?>" data-mediaLegende="<?php echo $mosaiqueArray[$numResultat][5][$numMedia][2] ?>">
									<?php redimensionner_image($MEDIA_ARBRE_PATH . "/" .$mosaiqueArray[$numResultat][5][$numMedia][1], ++$count) ?>
									<img src="<?php echo $THUMBNAIL_ARBRE_PATH . "/thumbnail" . $count . $extension; ?>" alt="icone mosaique" class="ico-mosaique"/>
									<!-- <img src="<?php echo $MEDIA_ARBRE_PATH . "/" .$mosaiqueArray[$numResultat][5][$numMedia][1]; ?>" alt="icone mosaique" class="ico-mosaique"/> -->
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
		function redimensionner_image($fichier, $count) {
		
			$file = $fichier;
			# L'emplacement de l'image à redimensionner. L'image peut être de type jpeg, gif ou png

			$x = 440;

			$y = 440;
			# Taille en pixel de l'image redimensionnée

			$size = getimagesize($file);

			if ($size) {
				//echo 'Image en cours de redimensionnement...';

				if ($size['mime'] == 'image/jpeg') {
					$extension = "jpeg";
					$img_big = imagecreatefromjpeg($file);
					# On ouvre l'image d'origine
					$img_new = imagecreate($x, $y);
					# création de la miniature
					$img_mini = imagecreatetruecolor($x, $y) or $img_mini = imagecreate($x, $y);

					// copie de l'image, avec le redimensionnement.
					imagecopyresized($img_mini, $img_big, 0, 0, 0, 0, $x, $y, $size[0], $size[1]);

					imagejpeg($img_mini, "../arbres/thumbnail/thumbnail" . $count . ".jpeg"); /*$THUMBNAIL_ARBRE_PATH*/

				} elseif ($size['mime'] == 'image/png') {
					$extension = "png";
					$img_big = imagecreatefrompng($file);
					# On ouvre l'image d'origine
					$img_new = imagecreate($x, $y);
					# création de la miniature
					$img_mini = imagecreatetruecolor($x, $y) or $img_mini = imagecreate($x, $y);

					// copie de l'image, avec le redimensionnement.
					imagecopyresized($img_mini, $img_big, 0, 0, 0, 0, $x, $y, $size[0], $size[1]);
					
					imagepng($img_mini, "../arbres/thumbnail/thumbnail" . $count . ".png", 0, PNG_NO_FILTER);

				} elseif ($size['mime'] == 'image/gif') {
					$extension = "gif";
					$img_big = imagecreatefromgif($file);
					# On ouvre l'image d'origine
					$img_new = imagecreate($x, $y);
					# création de la miniature
					$img_mini = imagecreatetruecolor($x, $y) or $img_mini = imagecreate($x, $y);

					// copie de l'image, avec le redimensionnement.
					imagecopyresized($img_mini, $img_big, 0, 0, 0, 0, $x, $y, $size[0], $size[1]);

					imagegif($img_mini, "../arbres/thumbnail/thumbnail" . $count . ".gif", 0, PNG_NO_FILTER);
				}
				//echo 'Image redimensionnée !';
			}
			}
		?> 

		<?php
			include $PAGE_PART_PATH . "/footer.php";
			include $PAGE_PART_PATH . "/script.php";
		?>
	</body>
</html>