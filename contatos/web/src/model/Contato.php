<?php
	require("../dao/Strings.php");

	class Contato{
		private $contatoId;
		private $usuarioId;
		private $contatoNome;
		private $contatoEndereco;
		private $contatoTelefones;
		private $contatoEmails;

		function __get($key){
			return $this->$key;
		}

		function Cadastrar($usuarioId, $contatoNome, $contatoEndereco, $contatoTelefones, $contatoEmails, $Conn){
			$this->usuarioId = mysql_real_escape_string($usuarioId);
			$this->contatoNome = mysql_real_escape_string($contatoNome);
			$this->contatoEndereco = mysql_real_escape_string($contatoEndereco);
			$this->contatoTelefones = $contatoTelefones;
			$this->contatoEmails = $contatoEmails;

			//Cadastra contato
			$valores = array();
			$valores[0] = "Contatos";
			$valores[1] = "usuarioId, contatoNome,contatoEndereco";
			$valores[2] = "$this->usuarioId,'$this->contatoNome','$this->contatoEndereco'";

			$query = Strings::Inserir($valores);
			echo $query;
			$query = $Conn->Execute($query);
			$this->contatoId = mysql_insert_id();


			if(!$query) return -1; //Erro

			//Cadastra telefones
			$valores = array();
			$valores[0] = "ContatoTelefones";
			$valores[1] = "contatoId,telefoneNum";

			$valores[2] = array();
			$i = 0;
			foreach($this->contatoTelefones as $telefone){
				if(strlen($telefone) > 0){
					$telefone = mysql_real_escape_string($telefone);
					$valores[2][$i++] = "$this->contatoId,'$telefone'";
				}
			}

			$query = Strings::Inserir($valores);
			$query = $Conn->Execute($query);

			//Cadastra emails
			$valores = array();
			$valores[0] = "ContatoEmails";
			$valores[1] = "contatoId, emailEndereco";


			$valores[2] = array();
			$i = 0;
			foreach($this->contatoEmails as $email){
				if(strlen($email) > 0){
					$email = mysql_real_escape_string($email);
					$valores[2][$i++] = "$this->contatoId,'$email'";
				}
			}

			$query = Strings::Inserir($valores);
			$query = $Conn->Execute($query);

			//return 0;
		}

		function Atualizar($usuarioId, $contatoId, $contatoNome, $contatoEndereco, $contatoTelefones, $contatoEmails, $Conn){
			$this->usuarioId = mysql_real_escape_string($usuarioId);
			$this->contatoId = mysql_real_escape_string($contatoId);
			$this->contatoNome = mysql_real_escape_string($contatoNome);
			$this->contatoEndereco = mysql_real_escape_string($contatoEndereco);
			$this->contatoTelefones = $contatoTelefones;
			$this->contatoEmails = $contatoEmails;

			//Cadastra contato
			$valores = array();
			$valores[0] = "Contatos";
			$valores[1] = "contatoNome = '$this->contatoNome',contatoEndereco = '$this->contatoEndereco'";
			$valores[2] = "WHERE contatoId = '$this->contatoId'";

			$query = Strings::Atualizar($valores);
			$query = $Conn->Execute($query);


			if(!$query) return -1; //Erro

			//Exclui telefones e add novos
			$deletar = array();
			$deletar[0] = "ContatoTelefones";
			$deletar[1] = "WHERE contatoId = $this->contatoId";
			$query = Strings::Deletar($deletar);
			$query = $Conn->Execute($query);

			//Add novo
			$valores = array();
			$valores[0] = "ContatoTelefones";
			$valores[1] = "contatoId, telefoneNum";
			$valores[2] = array();
			$i = 0;
			foreach($this->contatoTelefones as $telefone){
				if(strlen($telefone) > 0){
					$telefone = mysql_real_escape_string($telefone);
					$valores[2][$i++] = "$this->contatoId,'$telefone'";
				}
			}

			$query = Strings::Inserir($valores);
			$query = $Conn->Execute($query);

			//Excluir e Insere emails
			$deletar = array();
			$deletar[0] = "ContatoEmails";
			$deletar[1] = "WHERE contatoId = $this->contatoId";

			$query = Strings::Deletar($deletar);
			$query = $Conn->Execute($query);

			//Addnovo
			$valores = array();
			$valores[0] = "ContatoEmails";
			$valores[1] = "contatoId, emailEndereco";
			$valores[2] = array();
			$i = 0;
			foreach($this->contatoEmails as $email){
				if(strlen($email) > 0){
					$email = mysql_real_escape_string($email);
					$valores[2][$i++] = "$this->contatoId,'$email'";
				}
			}

			$query = Strings::Inserir($valores);
			$query = $Conn->Execute($query);
			//return 0;
		}

		function Deletar($usuarioId, $contatoId, $Conn){
			$this->usuarioId = mysql_real_escape_string($usuarioId);
			$this->contatoId = mysql_real_escape_string($contatoId);

			$valores = array();
			$valores[0] = "Contatos";
			$valores[1] = "WHERE usuarioId = '$this->usuarioId' && contatoId = '$this->contatoId'";

			$query = Strings::Deletar($valores);
			$query = $Conn->Execute($query);

			return $query;
		}

		function GetInfos($usuarioId, $contatoId, $Conn){
			$this->usuarioId = mysql_real_escape_string($usuarioId);
			$this->contatoId = mysql_real_escape_string($contatoId);

			$valores = array();
			$valores[0] = "contatoNome, contatoEndereco";
			$valores[1] = "Contatos";
			$valores[2] = "WHERE usuarioId = '$this->usuarioId' && contatoId = '$this->contatoId'";

			$query = Strings::Buscar($valores);
			$query = $Conn->Execute($query);

			if(mysql_num_rows($query) > 0){
				$resultado = mysql_fetch_array($query);

				$this->contatoNome = $resultado["contatoNome"];
				$this->contatoEndereco = $resultado["contatoEndereco"];
				$this->contatoEmails = $this->ListarEmails($this->contatoId, $Conn);
				$this->contatoTelefones = $this->ListarTelefones($this->contatoId, $Conn);
			}

			return $query;
		}

		function Listar($usuarioId, $Conn){
			$this->usuarioId = mysql_real_escape_string($usuarioId);

			$valores = array();
			$valores[0] = "contatoId, contatoNome, contatoEndereco";
			$valores[1] = "Contatos";
			$valores[2] = "WHERE usuarioId = '$this->usuarioId' ORDER BY contatoNome";

			$query = Strings::Buscar($valores);
			$query = $Conn->Execute($query);

			return $query;
		}


		function ListarTelefones($contatoId,$Conn){
			$this->contatoId = $contatoId;
			$this->contatoTelefones = array();

			$valores = array();
			$valores[0] = "telefoneId, telefoneNum";
			$valores[1] = "ContatoTelefones";
			$valores[2] = "WHERE contatoId = '$this->contatoId'";

			$query = Strings::Buscar($valores);
			$query = $Conn->Execute($query);

			if(mysql_num_rows($query) > 0){
				$i = 0;
				while($telefone = mysql_fetch_array($query)){
					$this->contatoTelefones[$i] = array();
					$this->contatoTelefones[$i]["telefoneId"] = $telefone["telefoneId"];
					$this->contatoTelefones[$i]["telefoneNum"] = $telefone["telefoneNum"];
					$i++;
				}
			}

			return $this->contatoTelefones;
		}

		function ListarEmails($contatoId,$Conn){
			$this->contatoId = $contatoId;
			$this->contatoEmails = array();

			$valores = array();
			$valores[0] = "emailId, emailEndereco";
			$valores[1] = "ContatoEmails";
			$valores[2] = "WHERE contatoId = '$this->contatoId'";

			$query = Strings::Buscar($valores);
			$query = $Conn->Execute($query);

			if(mysql_num_rows($query) > 0){
				$i = 0;
				while($email = mysql_fetch_array($query)){
					$this->contatoEmails[$i] = array();
					$this->contatoEmails[$i]["emailId"] = $email["emailId"];
					$this->contatoEmails[$i]["emailEndereco"] = $email["emailEndereco"];
					$i++;
				}
			}

			return $this->contatoEmails;
		}
	}
?>