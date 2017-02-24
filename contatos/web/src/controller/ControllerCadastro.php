<?php
	require("aux/Restrito.php");
	if(isLogged()) header("location:contatos");

	require("../view/ViewCadastro.php");

	$error = "";
	$nome = "";
	$email = "";

	if(isset($_GET['error'])){
		if(isset($_GET['error'])) $error = $_GET['error'];
		if(isset($_GET['email'])) $email = $_GET['email'];
		if(isset($_GET['nome'])) $nome = $_GET['nome'];
	}

	$VCadastro = new ViewCadastro($error, $email, $nome);

?>