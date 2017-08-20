<?php

    // include the configs / constants for the database connection
	require_once("config/db.php");

	// include the configs / constans for aws connection
	require_once("config/aws-config.php");

	// load the registration class
	require_once("classes/Delete.php");
	

	// create the registration object. when this object is created, it will do all registration stuff automatically
	// so this single line handles the entire registration process.
	$delete = new Delete();

	// show the register view (with the registration form, and messages/errors)
	if($_GET['source'] == "list")
	{
		header("location: list-contacts.php");	
	}
	else
	{
		header("location: search-contacts.php");
	}
	

?>
