<?php
	function isLogged(){
		if(isset($_COOKIE[md5("listaContatos") . "_uLogado"])){
			return ($_COOKIE[md5("listaContatos") . "_uLogado"] == true);
		}
		return false;
	}
?>