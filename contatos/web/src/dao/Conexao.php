<?php
	class Conexao{
		private $host = "localhost";
		private $user = "root";
		private $password = "";
		private $database = "listaContatos";
		private $conn;
		private $resultado;

		function Open(){
			$this->conn = mysql_connect($this->host, $this->user, $this->password);

			if($this->conn){
				if(!mysql_select_db($this->database, $this->conn))
					echo "Erro ao selecionar a base";
			} else {
				echo "Falha na conexão";
			}
		}

		function Close(){
			$this->conn = mysql_close();
		}

		function Execute($query){
			$this->resultado = mysql_query($query);

			return $this->resultado;
		}
	}
?>