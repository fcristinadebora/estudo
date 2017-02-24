<?php
	class ViewCadastro{
		private $error;
		private $email;
		private $nome;

		function __construct($error, $email, $nome){
			$this->error = $error;
			$this->email = $email;
			$this->nome = $nome;

			$this->GerarView();
		}

		function GerarView(){
			switch($this->error){
				case "email":
					$errormsg = "&nbsp;&nbsp;Formato de e-mail incorreto &nbsp;&nbsp;";
				break;
				case "nome":
					$errormsg = "&nbsp;&nbsp;O nome deve conter apenas letras e espaços&nbsp;&nbsp;";
				break;
				case "pssw":
					$errormsg = "&nbsp;&nbsp;Senha muito curta&nbsp;&nbsp;";
				break;
				case "rpssw":
					$errormsg = "&nbsp;&nbsp;As senhas devem ser iguais&nbsp;&nbsp;";
				break;
				case "already":
					$errormsg = "&nbsp;&nbsp;E-mail já cadastrado&nbsp;&nbsp;";
				break;
				default:
					$errormsg = "";
			}
		?>
			<html>
				<head>
						<title>MyContatcBook - Cadastro</title>
						<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
						<link rel="stylesheet" type="text/css" href="css/main.css">
						<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
				</head>

				<body>
					<div class="col-md-4 col-xs-12 main">

						<header class="col-md-12 text-center">
							<h3 class="title text-center">Cadastro</h3>
						</header>

						<section class="col-md-12 content">
							<p class="pull-left error" id="error"><b><?php echo $errormsg ?></b></p>

							<form name="cadastro" method="post" action="cadastrar">
								<br />

								<input type="text" name="nome" id="nome" placeholder="Nome" value="<?php echo $this->nome ?>" class="col-md-12 col-xs-12">
								<br />

								<input type="email" name="email" id="email" placeholder="E-mail" value="<?php echo $this->email ?>" class="col-md-12 col-xs-12">
								<br />

								<input type="password" name="senha" id="senha" placeholder="Senha" class="col-md-12 col-xs-12">
								<br />

								<input type="password" name="rsenha" id="rsenha" placeholder="Confirmar senha" class="col-md-12 col-xs-12">
								<br />

								<div class="send">
									<span class="lembrar">
										<input type="checkbox" name="lembrar" id="rlembrar" value="lembrar"> <label for="rlembrar">Lembrar-me</label>
									</span>

									<button type="submit" name="submit" value="Cadastrar" class="pull-right"><i class="fa fa-chevron-right"></i></button>
								</div>

							</form>

					 	</section>

					 	<footer class="col-md-12 loginf">
							<a href="login"><i class="fa fa-chevron-left"></i> Voltar para Login</a>
							<br />
						</footer>

					</div>

				</body>

			</html>
		<?php
		}
	}
?>