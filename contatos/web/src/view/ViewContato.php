<?php
	require("DefaultView.php");

	class ViewContato extends DefaultView{
		private $action;
		private $contatoId;
		private $contatoNome;
		private $contatoEndereco;
		private $arrTelefones;
		private $arrEmails;


		function __construct($action,$contatoId,$contatoNome,$contatoEndereco,$contatoTelefones,$contatoEmails){
			$this->action = $action;
			$this->contatoId = $contatoId;
			$this->contatoNome = $contatoNome;
			$this->contatoEndereco = $contatoEndereco;
			$this->arrTelefones = $contatoTelefones;
			$this->arrEmails = $contatoEmails;

			$this->GerarView();
		}

		function GerarView(){
			Parent::Header("../","Contatos");
			if($this->action == "novo"){
				$cabecalho = "Novo Contato";
			}else{
				$cabecalho = "Editar Contato";
			}
		?>
				<body>
					<div class="col-xs-12  col-md-10 main mainc">

						<?php  Parent::HeaderRestrito("../", $cabecalho) ?>

						<section class="col-md-12 content contentc">
							<?php
							if($this->action == "novo"){
								$this->frmNovo();
							}else{
								$this->frmEditar();
							}
							?>
						</section>


						<footer>
							<a href="contatos"><i class="fa fa-chevron-left"></i> Voltar para Contatos</a>
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

		function frmNovo(){
		?>
			<form name="contato" method="post" action="../contato/action=add" class="frmrestrito">
				<br />
				<div class="row col-md-12">
					<label for="nome">Nome</label>
					<br />
					<input type="text" name="nome" id="nome" value="" size="50">
					<br /><br />
				</div>

				<div class="row">
					<div class="col-md-5">
						<label for="telefone">Telefone(s)</label>
						<br />
						<input type="text" name="telefone[]" id="telefone" value="" class="col-md-12 col-xs-12">
						<br />
						<input type="text" name="telefone[]" id="telefone" value="" class="col-md-12 col-xs-12">
						<br />
						<input type="text" name="telefone[]" id="telefone" value="" class="col-md-12 col-xs-12">
						<br />
					</div>
					<div class="col-md-6 col-md-offset-1">
						<label for="email">E-mail(s)</label>
						<br />
						<input type="text" name="email[]" id="email" value="" class="col-md-12 col-xs-12">
						<br />
						<input type="text" name="email[]" id="email" value="" class="col-md-12 col-xs-12">
						<br />
						<input type="text" name="email[]" id="email" value="" class="col-md-12 col-xs-12">
						<br />
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<br />
						<label for="endereco">Endereço</label>
						<br />
						<textarea rows="2" class="col-md-12" name="endereco"></textarea>
					</div>
				</div>

				<div class="row send col-md-12 col-xs-12">
					<button type="submit" name="submit" value="Cadastrar" class="pull-right">Cadastrar <i class="fa fa-check"></i></button>
				</div>
			</form>
		<?php }

		function frmEditar(){
		?>
			<form name="contato" method="post" action="../contato/action=update" class="frmrestrito">
				<input type="hidden" name="contatoId" value="<?php echo $this->contatoId ?>">
				<br />
				<div class="row col-md-12">
					<label for="nome">Nome</label>
					<br />
					<input type="text" name="nome" id="nome" value="<?php echo $this->contatoNome ?>" size="50">
					<br /><br />
				</div>

				<div class="row">
					<div class="col-md-5">
						<label for="telefone">Telefone(s)</label>
						<br />
						<?php $this->frmEditarTelefones() ?>
					</div>
					<div class="col-md-6 col-md-offset-1">
						<label for="email">E-mail(s)</label>
						<br />
						<?php $this->frmEditarEmails() ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<br />
						<label for="endereco">Endereço</label>
						<br />
						<textarea rows="2" class="col-md-12" name="endereco"><?php echo $this->contatoEndereco ?></textarea>
					</div>
				</div>

				<div class="row send">
					<button type="submit" name="submit" value="Cadastrar" class="pull-right">Cadastrar <i class="fa fa-check"></i></button>
				</div>
			</form>
		<?php }

		function frmEditarTelefones(){
			for($i=0; $i < sizeof($this->arrTelefones); $i++){ ?>
				<input type="text" name="telefone[]" id="telefone" value="<?php echo $this->arrTelefones[$i]["telefoneNum"] ?>" class="col-md-12">
				<br />
			<?php
			}
			while($i < 3){ ?>
				<input type="text" name="telefone[]" id="telefone" value="" class="col-md-12">
				<br />
			<?php
			$i++;
			}
		}

		function frmEditarEmails(){
			for($i=0; $i < sizeof($this->arrEmails); $i++){ ?>
				<input type="text" name="email[]" id="email" value="<?php echo $this->arrEmails[$i]["emailEndereco"] ?>" class="col-md-12">
				<br />
			<?php
			}
			while($i < 3){ ?>
				<input type="text" name="email[]" id="email" value="" class="col-md-12">
				<br />
			<?php
			$i++;
			}
		}

	}
?>