<?php

	if (!(isset($_GET['id']) OR isset($_POST['edit']))) 
	{
   		header("location: new-contact.php");
   		exit;
	}

    // include the configs / constants for the database connection
	require_once("config/db.php");

	// include the configs / constans for aws connection
	require_once("config/aws-config.php");

	// load the registration class
	require_once("classes/Edit.php");

	// create the registration object. when this object is created, it will do all registration stuff automatically
	// so this single line handles the entire registration process.
	$edit = new Edit();

	if($edit->updated == true)
	{
		echo '
		<script type="text/javascript">
			alert("Contato atualizado com sucesso!");
			window.location="new-contact.php";
		</script>';
	}
	else
	{
		include("views/edit-contact.php");
	}

?>
