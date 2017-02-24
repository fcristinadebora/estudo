<?php
	/*Prepara strings de busca a partir de modelos predefinidos
	funções Insert, Delete e Update recebem os dados por uma array */
	class Strings{

		function Inserir($valores){
			//Caso de inserções multiplas
			if(is_array($valores[2])){
				$values = "";
				$i = 0;
				for($i = 0; $i < sizeof($valores[2]); $i++){
					$values .= "(". $valores[2][$i] . "),";
				}
				$values = substr($values, 0, -1);
			}else{
				$values = "($valores[2])";
			}

			$query = "INSERT INTO $valores[0] ($valores[1]) VALUES $values";

			return $query;
		}

		function Atualizar($valores){
			//Caso de inserções multiplas
			$query = "UPDATE  $valores[0] SET $valores[1] $valores[2]";

			return $query;
		}

		function Buscar($valores){
			$query = "SELECT $valores[0] FROM $valores[1] $valores[2]";

			return $query;
		}

		function Deletar($valores){
			$query = "DELETE FROM $valores[0] $valores[1]";

			return $query;
		}
	}
?>