<?php
	require("../dao/Strings.php");

	class Usuario{
		private $usuarioId;
		private $usuarioNome;
		private $usuarioEmail;
		private $usuarioSenha;

		function __get($atributo){
			if(isset($this->$atributo))
				return $this->$atributo;
			else
				return NULL;
		}

		function Login($email, $senha,$Conn){
			$this->usuarioEmail = $email;
			$this->usuarioSenha = md5($senha);

			$valores = array();
			$valores[0] = "usuarioId ,usuarioNome";
			$valores[1] = "Usuarios";
			$valores[2] = "WHERE usuarioEmail = '$this->usuarioEmail' && usuarioSenha = '$this->usuarioSenha'";

			$query = Strings::Buscar($valores);
			$query = $Conn->Execute($query);

			if(mysql_num_rows($query) > 0){
				$values = mysql_fetch_array($query);
				$this->usuarioNome =  $values["usuarioNome"];
				$this->usuarioId =  $values["usuarioId"];
				return 0;
			}else{
				return 1;
			}
		}

		function Cadastrar($nome, $email, $senha, $Conn){
			$this->usuarioEmail = $email;
			$this->usuarioNome = $nome;
			$this->usuarioSenha = md5($senha);

			$valores = array();
			$valores[0] = "Usuarios";
			$valores[1] = "usuarioNome,usuarioEmail,usuarioSenha";
			$valores[2] = "'$this->usuarioNome','$this->usuarioEmail','$this->usuarioSenha'";

			$query = Strings::Inserir($valores);
			$query = $Conn->Execute($query);

			$this->usuarioId = mysql_insert_id();

			if(!$query) return 1; //E-mail já cadastrado

			return 0;
		}

		function Update($usuarioId,$usuarioNome,$usuarioEmail,$Conn){
			$this->usuarioId = mysql_real_escape_string($usuarioId);
			$this->usuarioNome = mysql_real_escape_string($usuarioNome);
			$this->usuarioEmail = mysql_real_escape_string($usuarioEmail);

			$valores = array();
			$valores[0] = "Usuarios";
			$valores[1] = "usuarioNome = '$this->usuarioNome', usuarioEmail = '$this->usuarioEmail'";
			$valores[2] = "WHERE usuarioId = '$this->usuarioId'";

			$query = Strings::Atualizar($valores);
			$query = $Conn->Execute($query);

			return $query;
		}

		function UpdateSenha($usuarioId,$usuarioNSenha,$Conn){
			$this->usuarioId = mysql_real_escape_string($usuarioId);
			$this->usuarioNSenha = md5($usuarioNSenha);

			$valores = array();
			$valores[0] = "Usuarios";
			$valores[1] = "usuarioSenha = '$this->usuarioNSenha'";
			$valores[2] = "WHERE usuarioId = '$this->usuarioId'";

			$query = Strings::Atualizar($valores);
			$query = $Conn->Execute($query);

			return $query;
		}

		function Excluir($usuarioId,$Conn){
			$this->usuarioId = mysql_real_escape_string($usuarioId);

			$valores = array();
			$valores[0] = "Contatos";
			$valores[1] = "WHERE usuarioId = '$this->usuarioId'";

			$query = Strings::Deletar($valores);
			$query = $Conn->Execute($query);

			$valores[0] = "Usuarios";
			$valores[1] = "WHERE usuarioId = '$this->usuarioId'";

			$query = Strings::Deletar($valores);
			$query = $Conn->Execute($query);


			return $query;
		}
	}
?>