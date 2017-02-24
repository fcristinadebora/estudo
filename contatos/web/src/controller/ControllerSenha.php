<?php
	require("aux/Restrito.php");
	if(!isLogged()) header("location:login");

	require("aux/Validacoes.php");
	require("../model/Usuario.php");
	require("../dao/Conexao.php");

	function alterarsenha(){
		if(!isset($_POST["submit"]))
			return;

		$senha = validaSenha($_POST["senha"]);
		if(strlen($senha) < 1){
			return -1;
		}

		$nSenha = validaSenha($_POST["nsenha"]);
		if(strlen($nSenha) < 1){
			return -2;
		}

		$usuarioId = $_COOKIE[md5("listaContatos") . "_uId"];

		$Conn = new Conexao();
		$Conn->Open();
		$objUsuario = new Usuario();
		$alterar = $objUsuario->UpdateSenha($usuarioId,$nSenha,$Conn);
		$Conn->Close();

		header("location:../sair");

		return 0;
	}

	function controller(){
		require("../view/ViewSenha.php");

		$action = "";
		$error = "";

		if(isset($_GET['error'])) $error = $_GET['error'];
		if(isset($_GET['action'])) $action = $_GET['action'];

		if(!isset($_GET['error']) && !isset($_GET['action']))
			$root = "";
		else
			$root = "../";

		switch($action){
			case "update":
				$root = "../";
				switch(alterarsenha()){
					case 0:
						//header("location:$root"."login");
					break;
					case -1:
						header("location:$root"."alterarsenha/error=pssw");
					break;
					case -2:
						header("location:$root"."alterarsenha/error=rpssw");
					break;
					default:
						header("location:$root"."perfil");

				}
				$error = "";
			break;
		}
		$VSenha = new ViewSenha($root,$error);

	}

	controller();


?>