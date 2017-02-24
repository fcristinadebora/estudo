<?php
	error_reporting(0);
	$root = "";
	require("DefaultView.php");

	class ViewContatos extends DefaultView{
		private $arrContatos;


	function __construct($arrContatos){
		$this->arrContatos = $arrContatos;

		$this->GeraView();
	}

	function GeraView(){
		Parent::Header("","Contatos");
		?>
			<body>
		<div class="col-xs-12 col-md-10 main mainc">

			<?php  Parent::HeaderRestrito("","Contatos") ?>

			<section class="col-xs-12 col-md-12 content contentc">
					<form name="search" class="search col-md-12 ">
						<input type="text" name="search" id="search" class="col-md-11" style="margin:0" placeholder="Buscar por nome">
						<nav class="col-md-1 col-xs-1 btncontatos pull-right">
							<a href="contato/action=novo" class="btn btn-success" data-toggle="tooltip" data-placement="bottom"  title="Novo contato"><i class="fa fa-user-plus"></i></a>
						</nav>
					</form>


					<br />

					<?php  $this->geraContatos() ?>

			</section>


			<footer>

			</footer>
		</div>

		<script>
			$("#search").keyup(function(){
				$value = $("#search").val().toUpperCase();

				$(".contatoNome").each(function(){
					$(this).parent().parent().css("display", "block");
					if($(this).text().toUpperCase().indexOf($value) < 0)
					   $(this).parent().parent().css("display", "none");
				});
			});


			$(document).ready(function(){
			    $('[data-toggle="tooltip"]').tooltip();
			});
		</script>

	</body>
	</html>
	<?php
	}

	function GeraContatos(){
		if(sizeof($this->arrContatos) < 1){
		?>
			<p class="col-md-12">
				<br />
				Você ainda não cadastrou nenhum contato!
			</p>
		<?php
		}else{
			if(sizeof($this->arrContatos) > 0){
				foreach($this->arrContatos as $itemContato){
				?>
						<div class="contato pull-left bg-info col-xs-12 col-md-4">
							<h4>
								<span class="contatoNome"><?php echo $itemContato["contatoNome"] ?></span>
								<a href="contato/action=excluir&id=<?php echo $itemContato["contatoId"] ?>" class="btn btn-sm btn-danger pull-right" data-toggle="tooltip" data-placement="bottom"  title="Excluir"><i class="fa fa-trash"></i></a>
								<a href="contato/action=editar&id=<?php echo $itemContato["contatoId"] ?>" class="btn btn-sm btn-warning pull-right" data-toggle="tooltip" data-placement="bottom"  title="Editar"><i class="fa fa-edit"></i></a>
							</h4>
							<br />
							<?php
							//Exibe telefones
							if(sizeof($itemContato["contatoTelefones"]) > 0){ ?>
								<div class="telefones col-md-4 col-xs-12">
									<h5><strong>Telefone(s):</strong></h5>
									<?php foreach($itemContato["contatoTelefones"] as $item){
										echo "<p>$item[telefoneNum]</p>";
									  } ?>
								</div>
							<?php
							}

							//Exibe emails
							if(sizeof($itemContato["contatoEmails"]) > 0){ ?>
								<div class="telefones col-md-6">
									<h5><strong>Email(s):</strong></h5>
									<?php foreach($itemContato["contatoEmails"] as $item){
										echo "<p>$item[emailEndereco]</p>";
									  } ?>
								</div>
							<?php } ?>
							<h5 class="col-md-12 col-xs-12"><strong>Endereço:</strong></h5>
							<p class="endereco col-md-12">

								<?php echo $itemContato["contatoEndereco"] ?>
							</p>
						</div>
				<?php
				}
			}
		?>

		<?php
		}
	}

}
?>