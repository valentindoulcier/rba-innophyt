<?php

$HEADER = true;
$CurrentPath = "/php_script";
include "../pages/parts/variables.php";

// Chargement du fichier XML d'origine
//if (($xmlDoc = createDOMFromXML(XML_FILEPATH)) == null)
//	return generateErrorXML("Ce document n'est pas valide !");

$mosaiqueArray = array();
$nbMedias = 0;

$reader = new XMLReader();
$reader -> open(XML_FILEPATH);

//while ($reader->read() && $reader->nodeType == XMLReader::ELEMENT && $reader->name != 'resultat');

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

$reader -> close();

?>