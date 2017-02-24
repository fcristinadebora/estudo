<?php
	require("aux/Restrito.php");
	if(isLogged() == true) header("location: contatos");

	require("../view/ViewLogin.php");

	$error = "";
	$email = "";

	if(isset($_GET['error'])){
		if(isset($_GET['error'])) $error = $_GET['error'];
		if(isset($_GET['email'])) $email = $_GET['email'];
	}

	$VLogin = new ViewLogin($error, $email);

?>