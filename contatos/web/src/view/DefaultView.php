<?php
	//Classe com estrutura padrão de página
	class DefaultView{

		function Header($root, $title){
		?>
		<html>
		<head>
			<title>MyContatcBook - <?php echo $title ?></title>
			<link rel="stylesheet" type="text/css" href="<?php echo $root ?>css/bootstrap.css">
			<link rel="stylesheet" type="text/css" href="<?php echo $root ?>css/main.css">
			<link rel="stylesheet" type="text/css" href="<?php echo $root ?>css/font-awesome.css">
			<meta charset="UTF-8">
			<script src="<?php echo $root ?>js/jquery-3.1.1.min.js"></script>
			<script src="<?php echo $root ?>js/bootstrap.js"></script>
		</head>
		<?php
		}

		function HeaderRestrito($root,$title){
		?>
		<header class="col-md-12 col-xs-12">
			<h4 class="title text-left col-md-10 col-xs-12"> MyContactBook - <span class="description"><?php echo $title ?></span></h4>

			<span class="user pull-right col-md-2 col-xs-12">
				<?php echo $_COOKIE[md5("listaContatos") . "_uNome"]; ?>
				<a href="<?php echo $root ?>sair" class="fa fa-power-off menu pull-right user"  data-toggle="tooltip" data-placement="bottom"  title="Sair"></a>
				<a href="<?php echo $root ?>perfil" class="fa fa-vcard-o menu pull-right user"  data-toggle="tooltip" data-placement="bottom"  title="Meus Dados"></a>
			</span>
		</header>
		<?php
		}
	}
?>