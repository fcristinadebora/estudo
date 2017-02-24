<?php
	require("DefaultView.php");

	class ViewPerfil extends DefaultView{
		private $usuarioId;
		private $root;
		private $usuarioNome;
		private $usuarioEmail;
		private $action;
		private $error;

		function __construct($root, $action, $error, $usuarioNome, $usuarioEmail){
			$this->usuarioId = $_COOKIE[md5("listaContatos") . "_uId"];
			$this->root = $root;
			$this->usuarioNome = $usuarioNome;
			$this->usuarioEmail = $usuarioEmail;
			$this->action = $action;
			$this->error = $error;

			$this->GerarView();
		}

		function GerarView(){
			Parent::Header($this->root,"Meus Dados");
			$cabecalho = "Meus Dados";
		?>
				<body>
					<div class="col-xs-12  col-md-10 main mainc">

						<?php  Parent::HeaderRestrito($this->root, $cabecalho) ?>

						<section class="col-md-12 content contentc">
							<?php	$this->frmPerfil();	?>
						</section>

						<footer>
							<a href="<?php echo $this->root ?>contatos"><i class="fa fa-chevron-left"></i> Voltar para Contatos</a>
						</footer>
					</div>

					<script>
						$(document).ready(function(){
						    $('[data-toggle="tooltip"]').tooltip();
						});
					</script>

				</body>
			</html>
		<?php
		}

		function frmPerfil(){
		switch($this->action){
			case ("updatescc"):
				$errorType = "text-success";
				$errorMsg = "Dados alterados com sucesso";
			break;
			case ("email"):
				$errorType = "error";
				$errorMsg = "Formato de e-mail incorreto!";
			break;
			case ("nome"):
				$errorType = "error";
				$errorMsg = "Formato de nome!";
			break;
			default:
				$errorType = "";
				$errorMsg = "";
		}
		?>
			<form name="contato" method="post" action="<?php echo $this->root ?>perfil/action=update" class="frmrestrito">
				<br />

				<label class="<?php echo $errorType ?>"><?php echo $errorMsg ?></label>

				<div class="row col-md-12">
					<label for="nome">Nome</label>
					<br />
					<input type="text" name="nome" id="nome" value="<?php echo $this->usuarioNome ?>" size="50" class="col-md-6 col-xs-12">
					<br /><br />
				</div>

				<div class="row">
					<div class="col-md-12">
						<label for="nome">E-mail</label>
						<br />
						<input type="text" name="email" id="email" value="<?php echo $this->usuarioEmail ?>" class="col-md-6 col-xs-12">
						<br />
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<br /><br />
						<a href="alterarsenha">Alterar minha senha</a>
						<br />
						<a href="excluir">Excluir minha conta</a>
					</div>
				</div>

				<div class="row send col-md-6 col-xs-12" style="position:absolute;bottom:20px;">
					<button type="submit" name="submit" value="Salvar" class="pull-right">Salvar <i class="fa fa-check"></i></button>
				</div>
			</form>
		<?php }

		function update(){

		}

	}
?>