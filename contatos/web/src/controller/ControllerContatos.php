<?php
	require("aux/Restrito.php");
	if(!isLogged()) header("location: login");

	require("../model/Contato.php");
	require("aux/Validacoes.php");
	require("../dao/Conexao.php");

	//FUNÇÕES
	function cadastrar(){
		$usuarioId = $_COOKIE[md5("listaContatos") . "_uId"];
		$nome = validaNome($_POST["nome"]);
		$endereco = $_POST["endereco"];
		$telefones = $_POST["telefone"];
		$emails = $_POST["email"];

		if($nome == ""){
			header("location: novocontato?error=nome&nome=$nome&endereco=$endereco"); //Nomeinválido
			return;
		}

		$Conn = new Conexao();
		$Conn->Open();
		$objContato = new Contato();
		$cadastrar = $objContato->Cadastrar($usuarioId,$nome,$endereco,$telefones,$emails,$Conn);
		$Conn->Close();

		if($cadastrar != 0){
			header("location: novocontato?error&nome=$nome&endereco=$endereco");
			return;
		}

		return;
	}

	function listar(){
		$usuarioId = $_COOKIE[md5("listaContatos") . "_uId"];

		$Conn = new Conexao();
		$Conn->Open();
		$objContato = new Contato();

		//Busca os contatos
		$resultadoContatos = $objContato->Listar($usuarioId,$Conn);
		if(mysql_num_rows($resultadoContatos) < 1){
			return 1;
		}else{
			$arrContatos = array(); $j = 0;
			while($listaContatos = mysql_fetch_array($resultadoContatos)){
				$contato = array();
				$arrTelefones = array();
				$arrEmails = array();

				$contato["contatoId"] = $listaContatos["contatoId"];
				$contato["contatoNome"] = $listaContatos["contatoNome"];
				$contato["contatoEndereco"] = $listaContatos["contatoEndereco"];
				$contato["contatoTelefones"] = $objContato->ListarTelefones($contato["contatoId"],$Conn);
				$contato["contatoEmails"]  = $objContato->ListarEmails($contato["contatoId"],$Conn);

				$arrContatos[$j++] = $contato;
			}
		}

		$Conn->Close();

		return $arrContatos;
	}

	function controller(){
		if(isset($_GET["action"])){
			if($_GET["action"] == "add" && isset($_POST["submit"])){
				cadastrar();
				header("location:../contatos");
				return;
			}
		}else{
			require("../view/ViewContatos.php");
			$objViewContatos = new ViewContatos(listar());
		}
	}
	//FIM FUNÇÕES

	controller();
?>