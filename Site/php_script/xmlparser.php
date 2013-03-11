<?php

$HEADER = true;
$CurrentPath = "/php_script";
include "../pages/parts/variables.php";

$responseId = isset($_POST['responseid']) ? $_POST['responseid'] : '';
$questionId = isset($_POST['questionid']) ? $_POST['questionid'] : '';

//$questionId = 'q1';
//echo $responseId.', '.$questionId;
$value = '';
if ($responseId != '') {
	$value = getBranchOrResultFromResponse($responseId);
} else if ($questionId != '') {
	$value = getBranchFromQuestion($questionId);
}

//echo '-->';
echo $value;

function getBranchOrResultFromResponse($responseId) {
	// Chargement du fichier XML d'origine
	if (($xmlDoc = createDOMFromXML(XML_FILEPATH)) == null)
		return generateErrorXML("Ce document n'est pas valide !");

	// Recherche de la branche contenant la question passée en argument
	$root = null;
	$response = $xmlDoc -> getElementById($responseId);
	foreach ($response->childNodes as $node) {
		if ($node -> nodeName == "branche") {
			$root = $node;
			break;
		}
	}
	if ($root == null) {
		foreach ($response->childNodes as $node) {
			if ($node -> nodeName == "resultat") {
				$root = $node;
				break;
			}
		}
	}

	return generateXML($root);
}

function getBranchFromQuestion($questionId) {

	// Chargement du fichier XML d'origine
	if (($xmlDoc = createDOMFromXML(XML_FILEPATH)) == null)
		return generateErrorXML("Ce document n'est pas valide !");

	// Recherche de la branche contenant la question passée en argument
	$question = $xmlDoc -> getElementById($questionId);
	$root = $question -> parentNode;

	return generateXML($root);
}

function getResultFromResponse($responseID) {

}

/* INTERNAL FUNCTIONS */

function createDOMFromXML($filename) {
	$xmlDoc = new DOMDocument();
	$xmlDoc -> load(XML_FILEPATH);
	if (!$xmlDoc -> validate()) {
		return null;
	}

	return $xmlDoc;
}

function generateXML($root) {
	$rootID = $root -> getAttribute("id");

	// Creation d'un nouveau XML ayant pour racine cette branche
	$newDoc = new DomDocument();
	$newDoc -> appendChild($newDoc -> importNode($root, true));

	// Coupe des branches inférieures pour ne garder qu'une seule branche
	$branchesList = $newDoc -> getElementsByTagname("branche");
	$branchesToRemove = array();
	foreach ($branchesList as $branch) {
		if ($branch -> getAttribute("id") != $rootID)
			$branchesToRemove[] = $branch;
		// On ne peut pas supprimer directement ici apparament
	}
	foreach ($branchesToRemove as $branch) {
		$branch -> parentNode -> removeChild($branch);
		// Il faut passer par le père pour supprimer son fils
	}

	return $newDoc -> saveXML();
}

function generateErrorXML($errorMsg) {
	//$domDoc = new DomDocument();
	$domDoc = DOMDocument::loadXML('<error>' . $errorMsg . '</error>');

	return $domDoc -> saveXML();
}

/**
 function cutBranches($node, $questionID)
 {
 if($node->nodeName == "question" && ($node->getAttribute("id")==$questionID))
 {
 //print $xmlDoc->saveXML($node->parentNode);//->nodeValue;
 return $node->parentNode;
 }

 foreach ($node->childNodes AS $child)
 {
 getBranch($xmlDoc, $child, $questionID);
 }
 }
 **/
?>
