<?php
	require("../model/Usuario.php");
	require("../dao/Conexao.php");

	//FUNÇÕES
	function validaEmail($email){
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			return ""; //E-mail inválido

		return $email; //Email Válido
	}

	function validaSenha($senha){
		$senha = trim($senha);
		if(strlen($senha) < 8)
			return ""; //Senha muito curta

		return $senha;
	}

	function validaNome($nome){
		$pattern = "/[^a-zà-úA-ZÀ-Ú( )]/";
		if(strlen(trim($nome)) < 1)
			return "";
		elseif(preg_match($pattern, $nome))
			return "";

		return $nome;
	}

	//Cria cookie ou  sessão, de acordo com checkbox "lembrar-me"
	function lembrar($nome, $email,$id){
		$lembrar = "";

		if(isset($_POST["lembrar"]))
			$lembrar = $_POST["lembrar"];

		echo "<script>alert('$lembrar')</script>";

		if($lembrar == "lembrar"){
			$tempo = 3600*24*30;
			setcookie(md5("listaContatos") . "_uId",  $id, time() + $tempo);
			setcookie(md5("listaContatos") . "_uNome",  $nome, time() + $tempo);
			setcookie(md5("listaContatos") . "_uEmail",   $email, time() + $tempo);
			setcookie(md5("listaContatos") . "_uLogado",  true, time() + $tempo);
			setcookie(md5("listaContatos") . "_uLembrar",  true, time() + $tempo);
		}else{
			setcookie(md5("listaContatos") . "_uId",  $id);
			setcookie(md5("listaContatos") . "_uNome",  $nome);
			setcookie(md5("listaContatos") . "_uEmail",   $email);
			setcookie(md5("listaContatos") . "_uLogado",  true);
			setcookie(md5("listaContatos") . "_uLembrar",  false);
		}
	}

	function logoff(){
		setcookie(md5("listaContatos") . "_uId",  "");
		setcookie(md5("listaContatos") . "_uNome",  "");
		setcookie(md5("listaContatos") . "_uEmail",  "");
		setcookie(md5("listaContatos") . "_uLogado",  false);

		header("location: login");
	}

	function excluir(){
		$Conn = new Conexao();
		$Conn->Open();
		$objUsuario = new Usuario();
		$usuarioId = $_COOKIE[md5("listaContatos") . "_uId"];
		echo $usuarioId;
		$objUsuario->Excluir($usuarioId, $Conn);
		$Conn->Close();

		logoff();
	}

	function cadastrar(){
		$nome = validaNome($_POST["nome"]);
		$email = validaEmail($_POST["email"]);
		$senha = validaSenha($_POST["senha"]);
		$rsenha = $_POST["rsenha"];

		if($nome == ""){
			header("location: cadastro?error=nome&nome=$nome&email=$email"); //Nomeinválido
			return;
		}
		if($email == ""){
			header("location: cadastro?error=email&nome=$nome&email=$email"); //Email inválido
			return;
		}

		if($senha == ""){
			header("location: cadastro?error=pssw&nome=$nome&email=$email"); //Senha inválida
			return;
		}

		if(strcmp($senha,$rsenha)){
			header("location: cadastro?error=rpssw&nome=$nome&email=$email"); //Sehas diferentes
			return;
		}

		$Conn = new Conexao();
		$Conn->Open();
		$objUsuario = new Usuario();
		if($objUsuario->Cadastrar($nome,$email,$senha,$rsenha) == 1){
			header("location: cadastro?error=already&nome=$nome&email=$email"); //Email já exsite
			return;
		}
		$Conn->Close();

		$id = $objUsuario->usuarioId;
		lembrar($nome,$email,$id);

		header("location:contatos");
		return;
	}

	function login(){
		$email = validaEmail($_POST["email"]);
		$senha = validaSenha($_POST["senha"]);

		$Conn = new Conexao();
		$Conn->Open();
		$objUsuario = new Usuario();
		$objUsuario->Login($email,$senha,$Conn);
		$Conn->Close();

		$nome = $objUsuario->usuarioNome;
		$id = $objUsuario->usuarioId;

		if(strlen($nome) < 1){
			header("location: login?error=email&email=$email"); //Falha no login
			return;
		}

		lembrar($nome,$email,$id);
		header("location:contatos");
		return;
	}

	function controller(){
		if(isset($_GET["action"])){
			if($_GET["action"] == "sair"){
				logoff();
				return;
			}elseif($_GET["action"] == "excluir"){
				echo "Excluindo";
				excluir();
				return;
			}
		}else if(isset($_POST["submit"])){
			if($_POST["submit"] == "Entrar")
				login();
			else if($_POST["submit"] == "Cadastrar")
				cadastrar();
			else
				header("location: login");

		}else{
			header("location: login");
		}
	}
	//FIM FUNÇÕES

	controller();
?>