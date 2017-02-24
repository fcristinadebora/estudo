<?php
	class ViewLogin{
		private $error;
		private $email;

		function __construct($error, $email){
			$this->error = $error;
			$this->email = $email;

			$this->GerarView();
		}

		function GerarView(){
			if($this->error != ""){
				$errormsg = "&nbsp;&nbsp;E-mail ou senha incorretos&nbsp;&nbsp;";
			}else{
				$errormsg = "";
			}
		?>
			<html>
				<head>
						<title>MyContatcBook - Login</title>
						<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
						<link rel="stylesheet" type="text/css" href="css/main.css">
						<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
				</head>

				<body>
					<div class="col-md-4 main">

						<header class="col-md-12 text-center">
							<h3 class="title text-center">Login</h3>
						</header>

						<section class="col-md-12 content">


							<p class="pull-left error" id="error"><b><?php echo $errormsg ?></b></p>

							<form name="login" method="post" action="logar">
								<br />

								<input type="email" name="email" id="email" placeholder="E-mail" value="<?php echo $this->email ?>" class="col-md-12 col-xs-12">

								<br />

								<input type="password" name="senha" id="senha" placeholder="Senha" class="col-md-12 col-xs-12">

								<div class="send">
									<span class="lembrar">
										<input type="checkbox" name="lembrar" id="rlembrar" value="lembrar"> <label for="rlembrar">Lembrar-me</label>
									</span>

									<button type="submit" name="submit" value="Entrar" class="pull-right"><i class="fa fa-chevron-right"></i></button>
								</div>

							</form>

					 	</section>

					 	<footer class="col-md-12">
							<p>
								Não possui cadastro? <a href="cadastro">Clique aqui</a>
							</p>
						</footer>

					</div>

				</body>

			</html>
		<?php
		}
	}
?>