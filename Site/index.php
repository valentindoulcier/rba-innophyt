<html>
<head>
	<title>Site title here !</title>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-responsive.min.css">
	<link rel="stylesheet" type="text/css" href="shadowbox-3.0.3/shadowbox.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">

	<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="shadowbox-3.0.3/shadowbox.js"></script>
		
	<script type="text/javascript">
	<?php
		$questionId = isset($_GET['questionid']) ? $_GET['questionid'] : '';
		if($questionId){
		?>
			var firstQuestionId = '<?php echo $questionId; ?>';
		<?php
		}else{
		?>
			var firstQuestionId ='q1';
		<?php
		}
	?>

	</script>

	<script type="text/javascript" src="js/permalink.js"></script> 
	<script type="text/javascript" src="js/contentManagment.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/test.js"></script>

</head>
<body>
	<div class="topbar" id="header">
		<div class="fill">
			<div class="myContainer">
				<ul class="breadcrumb" id="breadcrumb">
				</ul>				
			</div>
		</div>
	</div>
	<div class="myContainer">
		<div id="debugFrame"></div>
	</div>

	<div id="questionFrame" class="myContainer">
		<div id="questionTextDivContainer">
			<div id="questionTextDivSubNav">
				 <div id="questionTextDiv" class="myContainer">
			    	<div id="questionTextIcon"><img src="images/question-mark.png"></div>
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
							<object type="application/x-shockwave-flash" data="webcam/webcamvid.swf"  width="434" height="300">
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

	<div class="myContainer">
		<div id="footer">
			<p class="left">All right reverved <a href="">Lorem Ipsum</a></p>
			<p class="right">Made by <a href="">Foobar <i class="icon-ok-sign"></i></a></p>
			<div class="clearer"></div>
		</div>
	</div>
	<input type="hidden" id="permalinkQuestionId" value=""/>
</body>
</html>