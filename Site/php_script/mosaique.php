<?php

$HEADER = true;
$CurrentPath = "/php_script";
include "../pages/parts/variables.php";

define(MEDIA_ARBRE_PATH, $MEDIA_ARBRE_PATH);
define(THUMBNAIL_ARBRE_PATH, $THUMBNAIL_ARBRE_PATH);

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
	
	echo ('<div id="mosaique" class="row">');
	
	for ($numResultat = 0; $numResultat < count($mosaiqueArray); $numResultat++) {
		if(count($mosaiqueArray[$numResultat][5]) != 0) {
			for ($numMedia = 0; $numMedia < count($mosaiqueArray[$numResultat][5]); $numMedia++) {
				?>
				<div id="<?php echo $mosaiqueArray[$numResultat][5][$numMedia][0] ?>" class="span1 mosaiqueCell" data-idRes="<?php echo $mosaiqueArray[$numResultat][0] ?>" data-nom="<?php echo $mosaiqueArray[$numResultat][1] ?>" data-type="<?php echo $mosaiqueArray[$numResultat][2] ?>" data-regimeAlimentaire="<?php echo $mosaiqueArray[$numResultat][3] ?>" data-informations="<?php echo $mosaiqueArray[$numResultat][4] ?>" data-mediaId="<?php echo $mosaiqueArray[$numResultat][5][$numMedia][0] ?>" data-mediaChemin="<?php echo $mosaiqueArray[$numResultat][5][$numMedia][1] ?>" data-mediaLegende="<?php echo $mosaiqueArray[$numResultat][5][$numMedia][2] ?>">
					<!-- <img src="<?php echo $THUMBNAIL_ARBRE_PATH . "/thumbnail" . $count . $extension; ?>" alt="icone mosaique" class="ico-mosaique"/> -->
					<img src="<?php echo THUMBNAIL_ARBRE_PATH . "/medias/" .$mosaiqueArray[$numResultat][5][$numMedia][1]; ?>" alt="icone mosaique" class="ico-mosaique"/>
				</div>
				<?php
			}
		}
	}
	echo ('</div>');
}

function afficher() {
	$mosaiqueArray = array();
	$nbMedias = 0;

	$mosaiqueArray = parse($mosaiqueArray, $nbMedias);

	create($mosaiqueArray, $nbMedias);

}

?>