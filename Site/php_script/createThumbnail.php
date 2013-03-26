<?php

$HEADER = true;
$CurrentPath = "/php_script";
require_once("../pages/parts/variables.php");

define(MEDIA_ARBRE_PATH, $MEDIA_ARBRE_PATH);
define(THUMBNAIL_ARBRE_PATH, $THUMBNAIL_ARBRE_PATH);

$mosaiqueArray = array();
$nbMedias = 0;

function parse($mosaiqueArray, $nbMedias) {
	
	$reader = new XMLReader();
	$reader->open(XML_FILEPATH);

	while($reader->read()) {
	
		if ($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'resultat') {
			$res = array();
			array_push($res, $reader->getAttribute('id'));
			
			while($reader->read()) {
				if ($reader->nodeType==XMLReader::END_ELEMENT && $reader->name=='resultat') {
					array_push($res, $medias);
					array_push($mosaiqueArray, $res);
					break;
				}
				
				if($reader->name=='nom' && $reader->nodeType == XMLReader::ELEMENT) {
					if($reader->read()){
						array_push($res, $reader->value);
					}
				}
				
				if($reader->name=='type' && $reader->nodeType == XMLReader::ELEMENT) {
					if($reader->read()){
						array_push($res, $reader->value);
					}
				}
				
				if($reader->name=='regimeAlimentaire' && $reader->nodeType == XMLReader::ELEMENT) {
					if($reader->read()){
						array_push($res, $reader->value);
					}
				}
				
				if($reader->name=='informations' && $reader->nodeType == XMLReader::ELEMENT) {
					if($reader->read()){
						array_push($res, $reader->value);
					}
					$medias = array();
				}
				
				if($reader->name=='media' && $reader->nodeType == XMLReader::ELEMENT) {
					$nbMedias++;
					if($reader->read()) {
						$media = array();
						if($reader->read()) {
							if($reader->name=='img' && $reader->nodeType == XMLReader::ELEMENT) {
								array_push($media, $reader->getAttribute('id'));
								array_push($media, $reader->getAttribute('src'));
							}
							if($reader->read()) {
								if($reader->read()) {
									if($reader->name=='legende' && $reader->nodeType == XMLReader::ELEMENT) {
										if($reader->read()) {
											array_push($media, $reader->value);
										}
									}
								}
							}
						}
					}
				}
				
				if($reader->name=='media' && $reader->nodeType == XMLReader::END_ELEMENT) {
					array_push($medias, $media);
				}
			}
		}
	}
	$reader->close();
	
	return $mosaiqueArray;
}


function create($mosaiqueArray, $nbMedias) {
	$count = 0;
	
	for ($numResultat = 0; $numResultat < count($mosaiqueArray); $numResultat++) {
		if(count($mosaiqueArray[$numResultat][5]) != 0) {
			for ($numMedia = 0; $numMedia < count($mosaiqueArray[$numResultat][5]); $numMedia++) {
				redimensionner_image(MEDIA_ARBRE_PATH . "/" .$mosaiqueArray[$numResultat][5][$numMedia][1], ++$count);
			}
		}
	}
}

function redimensionner_image($fichier, $count) {
		
	$file = $fichier;
	# L'emplacement de l'image à redimensionner. L'image peut être de type jpeg, gif ou png

	$x = 440;

	$y = 440;
	# Taille en pixel de l'image redimensionnée

	$size = getimagesize($file);

	if ($size) {
		//echo 'Image en cours de redimensionnement...';
				
		$img_big = imagecreatefromjpeg($file);
		# On ouvre l'image d'origine
		$img_new = imagecreate($x, $y);
		# création de la miniature
		$img_mini = imagecreatetruecolor($x, $y) or $img_mini = imagecreate($x, $y);
				
		// copie de l'image, avec le redimensionnement.
		imagecopyresized($img_mini, $img_big, 0, 0, 0, 0, $x, $y, $size[0], $size[1]);
		
		$new_path = createFolderIfNeeded($fichier);

		if ($size['mime'] == 'image/jpeg') {

			//imagejpeg($img_mini, "../arbres/thumbnail/thumbnail" . $count . ".jpeg"); /*$THUMBNAIL_ARBRE_PATH*/
			imagejpeg($img_mini, $new_path); /*$THUMBNAIL_ARBRE_PATH*/

		} elseif ($size['mime'] == 'image/png') {
					
			imagepng($img_mini, "../arbres/thumbnail/thumbnail" . $count . ".png", 0, PNG_NO_FILTER);

		} elseif ($size['mime'] == 'image/gif') {

			imagegif($img_mini, "../arbres/thumbnail/thumbnail" . $count . ".gif", 0, PNG_NO_FILTER);

		}

	}
}

function createFolderIfNeeded($fichier) {
	$folder = explode('/', $fichier);
	$path = THUMBNAIL_ARBRE_PATH;
	$numFolder = 2;
	
	for (; $numFolder < count($folder) - 1; $numFolder++) {
		$path .= "/" . $folder[$numFolder];
		mkdir($path, 0777);
	}
	$path .= "/" . $folder[$numFolder];
	//var_dump($folder[$numFolder]);
	//echo "<br>";
	//var_dump($numFolder);
	return $path;
}

$mosaiqueArray = parse($mosaiqueArray, $nbMedias);

create($mosaiqueArray, $nbMedias);

?>