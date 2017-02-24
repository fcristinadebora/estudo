<?php
	require("src/controller/aux/Restrito.php");
	if(isLogged()) header("location: contatos");
	else  header("location: login");
?>