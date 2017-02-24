<?php
	require("aux/Restrito.php");
	if(!isLogged()) header("location:login");
	require("../model/Contato.php");
	require("aux/Validacoes.php");
	require("../dao/Conexao.php");

	//FUNÇÕES
	function cadastrar(){
		$usuarioId = $_COOKIE[md5("listaContatos") . "_uId"];
		$nome = $_POST["nome"];
		$endereco = $_POST["endereco"];
		$telefones = $_POST["telefone"];
		$emails = $_POST["email"];

		$Conn = new Conexao();
		$Conn->Open();
		$objContato = new Contato();
		$cadastrar = $objContato->Cadastrar($usuarioId,$nome,$endereco,$telefones,$emails,$Conn);
		$Conn->Close();

		return;
	}

	function update(){
		$usuarioId = $_COOKIE[md5("listaContatos") . "_uId"];
		$contatoId = $_POST["contatoId"];
		$nome = $_POST["nome"];
		$endereco = $_POST["endereco"];
		$telefones = $_POST["telefone"];
		$emails = $_POST["email"];

		$Conn = new Conexao();
		$Conn->Open();
		$objContato = new Contato();
		$cadastrar = $objContato->Atualizar($usuarioId,$contatoId,$nome,$endereco,$telefones,$emails,$Conn);
		$Conn->Close();

		//return;
	}

	function viewEditar($contatoId){
		$usuarioId = $_COOKIE[md5("listaContatos") . "_uId"];

		$Conn = new Conexao();
		$Conn->Open();
		$contatoId = mysql_real_escape_string($contatoId);
		$objContato = new Contato();
		$objContato->GetInfos($usuarioId,$contatoId,$Conn);
		$Conn->Close();

		require("../view/ViewContato.php");
		$viewContato = new ViewContato("editar", $objContato->contatoId,$objContato->contatoNome,$objContato->contatoEndereco,$objContato->contatoTelefones,$objContato->contatoEmails);
	}

	function deletar($contatoId){
		$usuarioId = $_COOKIE[md5("listaContatos") . "_uId"];

		$Conn = new Conexao();
		$Conn->Open();
		$contatoId = mysql_real_escape_string($contatoId);
		$objContato = new Contato();
		$query = $objContato->Deletar($usuarioId,$contatoId,$Conn);
		$Conn->Close();
	}

	function controller(){
		if(isset($_GET["action"])){
			if($_GET["action"] == "add" && isset($_POST["submit"])){
				cadastrar();
				header("location:../contatos");
				return;
			}elseif($_GET["action"] == "update"  && isset($_POST["submit"])){
				update();
				header("location:../contatos");
				return;
			}elseif($_GET["action"] == "excluir" && isset($_GET["id"])){
				deletar($_GET["id"]);
				header("location:../contatos");
				return;
			}elseif($_GET["action"] == "editar" && isset($_GET["id"])){
				viewEditar($_GET["id"]);
				return;
			}elseif($_GET["action"] == "novo"){
				require("../view/ViewContato.php");
				$viewContato = new ViewContato("novo","","","","","","");
			}
		}else{
			header("location:../contatos");
			return;
		}

	}
	//FIM FUNÇÕES

	controller();
?>