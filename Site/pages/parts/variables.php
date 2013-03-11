<?php
	$BACK_PATH = "";
	if (strcmp($CurrentPath, "/") == 0) {
		$BACK_PATH = ".";
	} else if (strcmp($CurrentPath, "/arbres") == 0 || strcmp($CurrentPath, "/pages") == 0 || strcmp($CurrentPath, "/php_script") == 0) {
		$BACK_PATH = "..";
	}
	
	$JS_PATH           = $BACK_PATH . "/js";
	$CSS_PATH          = $BACK_PATH . "/css";
	$IMG_PATH          = $BACK_PATH . "/images";
	$PAGE_PATH         = $BACK_PATH . "/pages";
	$PAGE_PART_PATH    = $PAGE_PATH . "/parts";
	$PHP_SCRIPT_PATH   = $BACK_PATH . "/php_script";
	$LIB_PATH          = $BACK_PATH . "/lib";
	$ARBRE_PATH        = $BACK_PATH . "/arbres";
	
	$BASE_URL          = "http://localhost/RBA-INNOPHYT/Site";
	$CURRENT_URL       = $CurrentPath;
	$PAGES_URL         = $BASE_URL . "/pages";
	$PHP_SCRIPT_URL    = $BASE_URL . "/php_script";
	$LOGIN_URL         = $PAGES_URL . "/login.php";
	$MENU_URL          = $PAGES_URL . "/menu.php";
	$QUIZZ_URL         = $PAGES_URL . "/quizz.php";
	
	$LOGIN_PAGE        = $PAGE_PATH . "/login.php";
	
	define('XML_FILEPATH', $ARBRE_PATH . '/structure_xml.xml');
	
	//$PageType = page / login / quizz
	
	if (!$HEADER) {
?>

		<script type="text/javascript">
			/*
             *  Define path variable 
             */
			var base_url            = "<?php echo $BASE_URL ?>";
			var current_url         = "<?php echo $CURRENT_URL ?>";
			var pages_url           = "<?php echo $PAGES_URL ?>"
			var php_script_url      = "<?php echo $PHP_SCRIPT_URL ?>"
			var page_type           = "<?php echo $PageType ?>";
			
			var session_login_name  = "loginInfoRBA-INNOPHYT";
		</script>
<?php
	}
?>