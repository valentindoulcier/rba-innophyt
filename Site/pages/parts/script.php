
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/shadowbox.min.js"></script>
	
	<script type="text/javascript">
	<?php
		$questionId = isset($_GET['questionid']) ? $_GET['questionid'] : '';
		if ($questionId) {
	?>
			var firstQuestionId = '<?php echo $questionId; ?>';
	<?php
		} else {
	?>
			var firstQuestionId ='q1';
	<?php
		}
	?>
	</script>
	
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/contentManagment.js"></script>
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/script.js"></script>
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/permalink.js"></script>
<?php

	if (strcmp($PageType, "quizz") == 0) {
?>
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/quizz.js"></script>
	<!-- Demo Content -->
	<!--<script type="text/javascript" src="js/test.js"></script>-->
<?
	}
?>

<?php
	if (strcmp($PageType, "login") == 0) {
			
		$pkbits=512;
		$rsaKey = array('private' => '', 'public' => '');
		$pkbits = intval($pkbits);
		$res = openssl_pkey_new(array('private_key_bits' => $pkbits));
		
		// Get private key
		openssl_pkey_export($res, $privkey);
		
		// Get public key
		$pubkey = openssl_pkey_get_details($res);
		
		$rsaKey['private'] = str_replace("\n", " ", substr($privkey, 32, strrpos($privkey, " -----END RSA PRIVATE KEY-----") - 32)) ;
		$rsaKey['public'] = str_replace("\n", " ", substr($pubkey['key'], 27, strrpos($pubkey['key'], " -----END PUBLIC KEY-----") - 26));
		
		echo "\t<script>\n";
		echo "\t\tvar public_key = '" . $rsaKey['public'] . "';\n";
		echo "\t\tvar private_key = '" . $rsaKey['private'] . "';\n";
		echo "\t</script>\n";
		
		// Insérer clé privée dans la bdd
		
		/*
		$data = "tempo";
        if (openssl_private_decrypt(base64_decode($data), $decrypted, $this->privkey))
            $data = $decrypted;
        else
            $data = '';

        return $data;
		*/
		
		//insert in bdd the private key
		//echo 
?>
	
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/jsbn.js"></script>
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/random.js"></script>
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/hash.js"></script>
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/rsa.js"></script>
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/aes.js"></script>
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/api.js"></script>
	
	<script type="text/javascript" src="<?php echo $JS_PATH; ?>/login.js"></script>
<?
	}
?>