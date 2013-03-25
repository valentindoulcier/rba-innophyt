<?php
	$BACK_PATH = "";
	if (strcmp($CurrentPath, "/") == 0) {
		$BACK_PATH = ".";
	} else if (strcmp($CurrentPath, "/arbres") == 0 || strcmp($CurrentPath, "/pages") == 0 || strcmp($CurrentPath, "/php_script") == 0) {
		$BACK_PATH = "..";
	}
	
	/* ----------------------
	 * Data Base Informations
	 * ------------------- */
	 
	$HOST_DB           = "127.0.0.1";
	$USER_DB           = "admin";
	$PASSWORD_DB       = "";
	$SCHEMA_DB         = "rba-innophyt";
	$PORT_DB           = 3306;
	
	date_default_timezone_set('UTC');
	
	$JS_PATH           = $BACK_PATH  . "/js";
	$CSS_PATH          = $BACK_PATH  . "/css";
	$DOCUMENTS_PATH    = $BACK_PATH  . "/documents";
	$IMG_PATH          = $BACK_PATH  . "/images";
	$APROPOS_PATH      = $IMG_PATH   . "/apropos";
	$PAGE_PATH         = $BACK_PATH  . "/pages";
	$PAGE_PART_PATH    = $PAGE_PATH  . "/parts";
	$PHP_SCRIPT_PATH   = $BACK_PATH  . "/php_script";
	$LIB_PATH          = $BACK_PATH  . "/lib";
	$ARBRE_PATH        = $BACK_PATH  . "/arbres";
	$THUMBNAIL_ARBRE_PATH  = $ARBRE_PATH . "/thumbnail";
	$MEDIA_ARBRE_PATH  = $ARBRE_PATH . "/medias";
	
	$BASE_URL          = "http://localhost/RBA-INNOPHYT/Site";
	$CURRENT_URL       = $CurrentPath;
	$PAGES_URL         = $BASE_URL  . "/pages";
	$PHP_SCRIPT_URL    = $BASE_URL  . "/php_script";
	$LOGIN_URL         = $PAGES_URL . "/login.php";
	$MENU_URL          = $PAGES_URL . "/menu.php";
	$PROTOCOLES_URL    = $PAGES_URL . "/protocoles.php";
	$MOSAIQUE_URL      = $PAGES_URL . "/mosaique.php";
	$CAMPAGNE_URL      = $PAGES_URL . "/campagne.php";
	$PARCELLE_URL      = $PAGES_URL . "/parcelle.php";
	$PIEGE_URL         = $PAGES_URL . "/piege.php";
	$QUIZZ_URL         = $PAGES_URL . "/quizz.php";
	$ADMIN_URL         = $PAGES_URL . "/admin.php";
	
	//$LOGIN_PAGE        = $PAGE_PATH . "/login.php";
	
	$ADRESSE_MAIL      = "admin@rba-innophyt.fr";
	$SUJET_MAIL        = "[" . date("Y-m-d") . "] - Aide Application Web RBA-INNOPHYT";
	$BODY_MAIL         = "Bonsoir, je sui nul et j'ai besoin d'aide";
	$MAILTO            = "mailto:" . $ADRESSE_MAIL . "?subject=" . $SUJET_MAIL . "&body=" . $BODY_MAIL;
	
	$FAVICON           = $IMG_PATH . "/favicon.ico";
	
	define('XML_FILEPATH', $ARBRE_PATH . '/structure_xml.xml');
	
	//$PageType = page / login / quizz / prepareQuizz / admin / mosaique
	
	if (!$HEADER) {
?>

		<script type="text/javascript">
			/*
             *  Define path variable 
             */
			var base_url            = "<?php echo $BASE_URL ?>";
			var current_url         = "<?php echo $CURRENT_URL ?>";
			var arbre_media_url     = "<?php echo $BASE_URL ?>/arbres/medias";
			var images_url          = "<?php echo $BASE_URL ?>/images";
			var pages_url           = "<?php echo $PAGES_URL ?>";
			var php_script_url      = "<?php echo $PHP_SCRIPT_URL ?>";
			var page_type           = "<?php echo $PageType ?>";
			
			var campagne_url        = "<?php echo $CAMPAGNE_URL ?>";
			var parcelle_url        = "<?php echo $PARCELLE_URL ?>";
			var piege_url           = "<?php echo $PIEGE_URL ?>";
			
			var session_login_name  = "loginInfoRBA-INNOPHYT";
			var action_form         = "action-rba-innophyt";
			var session_id_campagne = "id_campagne-rba-innophyt";
			var session_id_parcelle = "id_parcelle-rba-innophyt";
			var session_id_piege    = "id_piege-rba-innophyt";
			var session_liste_camp  = "liste_campagne-rba-innophyt_";
			var session_liste_parc  = "liste_parcelle-rba-innophyt_";
			var session_liste_pieg  = "liste_piege-rba-innophyt_";
			var session_action      = "action-rba-innophyt";
			var session_save        = "rba-innophyt-save";
			var session_id_mosaique = "mosaiqueInfoRBA-INNOPHYT";
		</script>
<?php
	}
?>