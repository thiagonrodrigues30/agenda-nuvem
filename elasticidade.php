<?php
	
	// load the registration class
	require_once("classes/Process.php");

	// create the registration object. when this object is created, it will do all registration stuff automatically
	// so this single line handles the entire registration process.
	$process = new Process();

	// show the register view (with the registration form, and messages/errors)
	include("views/elasticidade.php");


?>