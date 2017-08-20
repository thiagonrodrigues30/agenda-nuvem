<?php

    // include the configs / constants for the database connection
	require_once("config/db.php");

	// include the configs / constans for aws connection
	require_once("config/aws-config.php");

	// load the registration class
	require_once("classes/Search.php");

	// create the registration object. when this object is created, it will do all registration stuff automatically
	// so this single line handles the entire registration process.
	$search = new Search();

	// show the register view (with the registration form, and messages/errors)
	include("views/search-contacts.php");

?>
