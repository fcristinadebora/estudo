<?php
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
?>