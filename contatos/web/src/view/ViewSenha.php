<?php
	require("DefaultView.php");

	class ViewSenha extends DefaultView{
		private $usuarioId;
		private $root;
		private $usuarioNome;
		private $usuarioEmail;
		private $action;
		private $error;

		function __construct($root, $error){
			$this->usuarioId = $_COOKIE[md5("listaContatos") . "_uId"];
			$this->root = $root;
			$this->error = $error;

			$this->GerarView();
		}

		function GerarView(){
			Parent::Header($this->root,"Meus Dados");
			$cabecalho = "Alterar senha";
		?>
				<body>
					<div class="col-xs-12  col-md-10 main mainc">

						<?php  Parent::HeaderRestrito($this->root, $cabecalho) ?>

						<section class="col-md-12 content contentc">
							<?php	$this->frmSenha();	?>
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

		function frmSenha(){
		switch($this->error){
			case ("success"):
				$errorType = "text-success";
				$errorMsg = "Dados alterados com sucesso";
			break;
			case ("pssw"):
				$errorType = "error";
				$errorMsg = "Senha atual incorreta!";
			break;
			case ("rpssw"):
				$errorType = "error";
				$errorMsg = "Nova senha é muito curta!";
			break;
			default:
				$errorType = "";
				$errorMsg = "";
		}
		?>
			<form name="contato" method="post" action="<?php echo $this->root ?>alterarsenha/action=update" class="frmrestrito">
				<br />

				<label class="<?php echo $errorType ?>"><?php echo $errorMsg ?></label>

				<div class="row col-md-12">
					<label for="senha">Senha atual</label>
					<br />
					<input type="password" name="senha" id="nome" value="" size="50" class="col-md-6 col-xs-12">
					<br /><br />
				</div>

				<div class="row col-md-12">
					<label for="nsenha">Nova Senha</label>
					<br />
					<input type="password" name="nsenha" id="nome" value="" size="50" class="col-md-6 col-xs-12">
					<br /><br />
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