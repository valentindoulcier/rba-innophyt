<?php

$HEADER = true;
$CurrentPath = "/php_script";
include "../pages/parts/variables.php";

define(MEDIA_ARBRE_PATH, $MEDIA_ARBRE_PATH);
define(THUMBNAIL_ARBRE_PATH, $THUMBNAIL_ARBRE_PATH);

$mosaiqueArray = array();

function parse($mosaiqueArray) {
	
	$reader = new XMLReader();
	$reader->open(XML_FILEPATH);

	while($reader->read()) {
		if($reader->name=='img' && $reader->nodeType == XMLReader::ELEMENT) {
			array_push($mosaiqueArray, $reader->getAttribute('src'));
		}
	}
	
	$reader->close();
	
	return $mosaiqueArray;
}


function create($mosaiqueArray) {
	
	for ($numResultat = 0; $numResultat < count($mosaiqueArray); $numResultat++) {
		redimensionner_image(MEDIA_ARBRE_PATH . "/" .$mosaiqueArray[$numResultat]);
	}
}

function redimensionner_image($fichier) {
		
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

			imagejpeg($img_mini, $new_path); /*$THUMBNAIL_ARBRE_PATH*/

		} elseif ($size['mime'] == 'image/png') {
					
			imagepng($img_mini, $new_path, 0, PNG_NO_FILTER);

		} elseif ($size['mime'] == 'image/gif') {

			imagegif($img_mini, $new_path, 0);

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

$mosaiqueArray = parse($mosaiqueArray);

create($mosaiqueArray);

?>