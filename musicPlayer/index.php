<!doctype html>
<html>
	<head>
		<title>musicPlayer</title>	
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=iso-8859-1" />
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<link rel="stylesheet" type= "text/css" href="css/form.css" />
		<link rel="stylesheet" type= "text/css" href="css/musicPlayer.css" />

		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

		<meta name="viewport" content="width=device-width, initial-scale=1"/>
	</head>
  <body>
    
    <?php 

  session_start();
  $_SESSION['cloud_directory']="/music/";   // Your music folder
    
  require ('musicPlayer/musicPlayer.php'); ?>

  </body>
</html>
