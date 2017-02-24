<?php
	require("aux/Restrito.php");
	if(!isLogged()) header("location:login");

	require("aux/Validacoes.php");
	require("../model/Usuario.php");
	require("../dao/Conexao.php");

	function update(){
		if(!isset($_POST["submit"]))
			return;

		$nome = validaNome($_POST["nome"]);
		if(strlen($nome) < 1){
			return -1;
		}

		$email = validaEmail($_POST["email"]);
		if(strlen($email) < 1){
			return -2;
		}

		$usuarioId = $_COOKIE[md5("listaContatos") . "_uId"];

		$Conn = new Conexao();
		$Conn->Open();
		$objUsuario = new Usuario();
		$cadastrar = $objUsuario->Update($usuarioId,$nome,$email,$Conn);
		$Conn->Close();

		if($_COOKIE[md5("listaContatos") . "_uLembrar"] == true){
			$tempo = 3600*24*30;
			setcookie(md5("listaContatos") . "_uNome",  $nome, time() + $tempo);
			setcookie(md5("listaContatos") . "_uEmail",   $email, time() + $tempo);
		}else{
			setcookie(md5("listaContatos") . "_uNome",  $nome);
			setcookie(md5("listaContatos") . "_uEmail",   $email);
		}

		return 0;
	}

	function controller(){
		require("../view/ViewPerfil.php");

		$action = "";
		$error = "";
		$nome = $_COOKIE[md5("listaContatos") . "_uNome"];
		$email = $_COOKIE[md5("listaContatos") . "_uEmail"];

		if(isset($_GET['action'])) $action = $_GET['action'];
		if(isset($_GET['error'])) $error = $_GET['error'];

		$root = "../";
		switch($action){
			case "":
				$root = "";
			break;
			case "update":
				$root = "../";
				switch(update()){
					case 0:
						header("location:$root"."perfil/action=updatescc");
					break;
					case -1:
						header("location:$root"."perfil/action=nome");
					break;
					case -2:
						header("location:$root"."perfil/action=email");
					break;
					default:
						header("location:$root"."perfil/action=nome");

				}
				$error = "";
			break;
		}
		$VPerfil = new ViewPerfil($root,$action,$error,$nome,$email);

	}

	controller();


?>