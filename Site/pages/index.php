<?php
	$JS_PATH   = "../js";
	$CSS_PATH  = "../css";
	$IMG_PATH  = "../images";
	$PHP_PATH  = "./parts";
	
	$PageType = "quizz";
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8" />
	
	<title>Site title here !</title>
	
	<?php
		include $PHP_PATH . "/headCssJs.php";
	?>
</head>
<body>
	<?php
		include $PHP_PATH . "/header.php";
	?>
	
	<div id="" class="myContainer">
		<div id="debugText">
			<!--[Debug text]-->
		</div>
	</div>
	
	<script type="text/javascript">


function openLogin() {

    // open a welcome message as soon as the window loads
    Shadowbox.open({
        content:    '<script>loadLoginFormAction("lol");<\/script><div id="formContainer"> <form id="login" method="post" action="./"> <a href="#" id="flipToRecover" class="flipLink">Forgot?</a> <input type="text" name="loginEmail" id="loginEmail" placeholder="Email" /> 			<input type="password" name="loginPass" id="loginPass" placeholder="Password" />			<input type="submit" name="submit" value="Login" />		</form>		<form id="recover" method="post" action="./">			<a href="#" id="flipToLogin" class="flipLink">Forgot?</a>			<input type="text" name="recoverEmail" id="recoverEmail" placeholder="Your Email" />			<input type="submit" name="submit" value="Recover" />		</form>	</div>',
        player:     "html",
        title:      "Login",
        height:     350,
        width:      350
    });
}
</script>
<!--
<a href="#" rel="shadowbox[login]" title="index" onclick="openLogin();">shadow box login js</a>
<br />
<a href="#formContainer" rel="shadowbox[login]" title="index">shadow box login html</a>

	<div id="formContainer">
		<form id="login" method="post" action="./">
			<a href="#" id="flipToRecover" class="flipLink">Forgot?</a>
			<input type="text" name="loginEmail" id="loginEmail" placeholder="Email" />
			<input type="password" name="loginPass" id="loginPass" placeholder="Password" />
			<input type="submit" name="submit" value="Login" />
		</form>
	
		<form id="recover" method="post" action="./">
			<a href="#" id="flipToLogin" class="flipLink">Forgot?</a>
			<input type="text" name="recoverEmail" id="recoverEmail" placeholder="Your Email" />
			<input type="submit" name="submit" value="Recover" />
		</form>
	</div>

	<br />
	<br />
-->
<!--
	<div id="loginFrame">
		<div id="debugText">			
			<form name="connexionForm" id="connexionForm" action="#"><!-- début du formulaire de connexion ->
 
				<label for="login">Nom d'utilisateur :</label>
        		<input type="text" name="login" id="login" /><!-- champ pour le login ->
 
				<label for="pass">Mot de passe :</label>
				<input type="password" name="pass" id="pass" /><!-- champ pour le mot de passe ->
 
				 <br />
        		<input type="submit" value="Je me connecte" class="bouton" /><!-- bouton de connexion ->
			</form><!-- fin du formulaire ->
		</div>
	</div>
-->

	<div id="questionFrame" class="myContainer">
		<div id="questionTextDivContainer">
			<div id="questionTextDivSubNav">
				 <div id="questionTextDiv" class="myContainer">
			    	<div id="questionTextIcon"><img src="images/question-mark.png" alt="icone question"></div>
			    	<h1><!--[Question]--><br><small><!--[Legend]--></small></h1>
			    	<div class="clearer"></div>
			    </div>
			</div>
		</div>
    
		<div id="bodyQuestionContent">

			<div id="responsesDiv">
				<!--[Responses]-->
     		</div>			
		    <div id="questionInfoDiv">

		    	<div class="window" id="informationsWindow">
		    		<ul>
		    			<li class="windowTitle">
				    		<h3><i class="icon-info-sign"></i>Informations</h3>
				    	</li>
				    	<li id="questionInfoContent">
							<!--[Informations carsousel]-->
			     		</li>
			     	</ul>
	     		</div>		    	
				<div class="window" id="webcamWindow">
		    		<ul>
		    			<li class="windowTitle">
				    		<h3><i class="icon-eye-open"></i>Web-cam</h3>
				    	</li>
				    	<li>
							<object type="application/x-shockwave-flash" data="lib/webcam/webcamvid.swf"  width="434" height="300">
								<param name="webcam" value="webcamvid.swf">
							</object>
			     		 </li>
			     	</ul>
	     		 </div>							
		    </div>
		    
     		 <div class="clearer"></div>
	    </div>
	</div>

	<div id="resultFrame" class="myContainer">
		<div id="bodyResultContent">

			<div id="resultLeftDiv">
		    	<div class="window" id="resultCarouselWindow">
		    		<ul>
		    			<li class="windowTitle">
				    		<h3><i class="icon-picture"></i>Images</h3>
				    	</li>
				    	<li id="resultCarouselWindowContent">
							Blabla
			     		 </li>
			     	</ul>
	     		 </div>		     		 
     		</div>			
		    <div id="resultRightDiv">			
				<div class="window" id="resultWindow">
		    		<ul>
		    			<li class="windowTitle">
				    		<h3><i class="icon-ok"></i>Résultat</h3>
				    	</li>
				    	<li id="resultWindowContent">
							Blabla
			     		 </li>
			     	</ul>
	     		</div>	
	     	</div>
	     	<div class="clearer"></div>
		</div>
	</div>

	<?php
		include $PHP_PATH . "/footer.php";
		include $PHP_PATH . "/script.php";
	?>
</body>
</html>