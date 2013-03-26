<?php

$HEADER = true;
$CurrentPath = "/php_script";
require_once("../pages/parts/variables.php");

define(MEDIA_ARBRE_PATH, $MEDIA_ARBRE_PATH);
define(THUMBNAIL_ARBRE_PATH, $THUMBNAIL_ARBRE_PATH);
define(IMAGE_PATH, $IMG_PATH);
define(QUIZZ_URL,$QUIZZ_URL);

function parse($mosaiqueArray) {
	
	$reader = new XMLReader();
	$reader->open(XML_FILEPATH);
	$chemins = array();
	
	while($reader->read()) {
	
		if ($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'reponse') {
			$reponse = array();
			array_push($reponse, $reader->getAttribute('id'));
		}
			
		if ($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'resultat') {
			$resultat = array();
			array_push($resultat, $reader->getAttribute('id'));
			$medias = array();
			
			
			while($reader->read()) {
				
				if ($reader->nodeType==XMLReader::END_ELEMENT && $reader->name=='resultat') {
					if(count($medias) != 0) {
						array_push($resultat, $medias);
						array_push($reponse, $resultat);
						array_push($mosaiqueArray, $reponse);
					}
					break;
				}
				
				if($reader->name=='media' && $reader->nodeType == XMLReader::ELEMENT) {
					if($reader->read()) {
						if($reader->read()) {
							if($reader->name=='img' && $reader->nodeType == XMLReader::ELEMENT) {
								$nomImg = explode("/", $reader->getAttribute('src'));
								$imgName = $nomImg[count($nomImg) - 1];
								if(!in_array($imgName, $chemins)) {
									$media = array();
									array_push($media, $reader->getAttribute('id'));
									array_push($media, $reader->getAttribute('src'));
									array_push($chemins, $imgName);
									array_push($medias, $media);
								}
							}
						}
					}
				}
			}
		}
	}
	$reader->close();
	
	return $mosaiqueArray;
}


function create($mosaiqueArray) {
	
	echo ('<div id="mosaique" class="row">');
	
	for ($numResultat = 0; $numResultat < count($mosaiqueArray); $numResultat++) {
		if(count($mosaiqueArray[$numResultat][1][1]) != 0) {
			for ($numMedia = 0; $numMedia < count($mosaiqueArray[$numResultat][1][1]); $numMedia++) {
				?>
				<div id="<?php echo $mosaiqueArray[$numResultat][1][1][$numMedia][0] ?>" class="span1 mosaiqueCell" data-idreponse="<?php echo $mosaiqueArray[$numResultat][0] ?>" data-idresultat="<?php echo $mosaiqueArray[$numResultat][1][0] ?>" data-mediaId="<?php echo $mosaiqueArray[$numResultat][1][1][$numMedia][0] ?>" data-mediaChemin="<?php echo $mosaiqueArray[$numResultat][1][1][$numMedia][1] ?>">
					<!-- <img src="<?php echo $THUMBNAIL_ARBRE_PATH . "/thumbnail" . $count . $extension; ?>" alt="icone mosaique" class="ico-mosaique"/> -->
					<!-- <img src="<?php echo THUMBNAIL_ARBRE_PATH . "/medias/" .$mosaiqueArray[$numResultat][5][$numMedia][1]; ?>" alt="icone mosaique" class="ico-mosaique"/> -->
					<a href="<?php echo QUIZZ_URL ?>">
						<img src="<?php echo IMAGE_PATH ?>/blank.gif" data-src="<?php echo THUMBNAIL_ARBRE_PATH . "/medias/" .$mosaiqueArray[$numResultat][1][1][$numMedia][1]; ?>" alt="icone mosaique" class=" lazy ico-mosaique"/>
						<noscript>
							<img src="<?php echo THUMBNAIL_ARBRE_PATH . "/medias/" .$mosaiqueArray[$numResultat][1][1][$numMedia][1]; ?>" alt="icone mosaique" class="nolazy ico-mosaique"/>
						</noscript>
					</a>
				</div>
				<?php
			}
		}
	}
	echo ('</div>');
}

function afficher() {
	$mosaiqueArray = array();

	$mosaiqueArray = parse($mosaiqueArray);

	create($mosaiqueArray);

}

?>