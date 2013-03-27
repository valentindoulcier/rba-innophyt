<!DOCTYPE html>
<html>
	<head>
		<?php
			$HEADER = false;
			$PageType    = "map";
			$CurrentPath = "/pages";
			require_once("parts/variables.php");
		?>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<style type="text/css">
			html {
				height: 100%
			}
			body {
				height: 100%;
				margin: 0;
				padding: 0
			}
			#map-canvas {
				height: 100%
			}
		</style>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfZN9a70ZRFuLhcNNzDm-q_JlkLyWyW3w&sensor=false"></script>
		<script type="text/javascript"></script>
	</head>
	<body>
		<div id="map-canvas"/>
	</body>
</html>