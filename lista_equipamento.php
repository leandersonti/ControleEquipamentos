<?php
require 'conn.php'; 
include_once('head.php');
include_once('topoLogo.php');
include_once('menu.php');

$limite = 10; #!!!!ATENÇÃO!!!! Esta variável define a quantidade de elementos exibidos por página na tabela //Cley
?>
<script defer src="scripts/lista_equipamento.js" type="text/javascript"></script>
<body>

	<!-- Inputs do tipo hidden para controlar a paginação feita no JavaScript //Cley -->
	<input type="hidden" id="inputEscondido" value="1">
	<?php
	$sql = "SELECT COUNT(*) AS qtdd FROM equipamento WHERE status!=4";
	if(isset($_POST['submit']))
	{
		if($_POST['tipo']!="")
			$sql .= " and tipo='".$_POST['tipo']."'";
		if($_POST['status']!="")
			$sql .= " and status=".$_POST['status'];
	}
	$consulta = mysqli_query($conn,$sql);
	$rs = mysqli_fetch_object($consulta);
	$maximo = ceil($rs->qtdd/$limite);
	?>
	<input type="hidden" id="fecharPagina" value="0">
	<input type="hidden" id="totalPaginas" value="<?php echo $maximo ?>">

	<div style="width:90%; margin:100px auto" class="panel panel-defalt">

		<!-- Formulário de FILTRO //Cley -->
		<form method="post">
			<div class="form-group col-md-6" style="margin-left:-15px">
				Filtrar por:
			</div>

			<div class="form-row">

				<div class="form-group col-md-6">

					<select id="inputEstado" name="tipo" class="form-control">
						<option value="">Equipamento</option>
						<?php
						$query = "SELECT tipo FROM equipamento GROUP BY tipo";
						$result = mysqli_query($conn,$query);
						while ($rs = mysqli_fetch_object($result))
						{
							echo "<option value='$rs->tipo'>$rs->tipo</option>";
						}
						?>
					</select>
				</div>
				<div class="form-group col-md-6">

					<select name="status" class="form-control">
						<option value="">Status</option>
						<option value="0">Disponível</option>
						<option value="1">Lotado</option>
						<option value="2">Com defeito</option>
						<option value="3">Em manutenção</option>
					</select>
				</div>
			</div>
			<input type="submit" name="submit" value="Filtrar" class="btn btn-primary">
		</form><br>

		<!-- Formulario de EMPRÉSTIMO -->
		<form id="formulario_escondido" method="post" action="lotarEquipamento.php">
			<fieldset id="field">
				<legend>Emprestar Equipamento</legend>
				<input type="hidden" name="lista" value="" id="lotados">

				<div class="form-group">
					<label>Designação do empréstimo:</label>
					<br>
					<div class="radios">
						<div class="radio">
							<label for="destinoInterior">Interior</label>
							<input onfocus="exibirUnidade('i')" type="radio" name="destino" value="interior" id="destinoInterior">
						</div>

						<div class="radio">
							<label for="destinoCapital">Capital</label>
							<input onfocus="exibirUnidade('c')" type="radio" name="destino" value="capital" id="destinoCapital">
						</div>
					</div>
				</div>
				<div id="groupEmprestimo" class="form-group">
					<label>Tipo de transação:</label>
					<div class="radios2">
						<div class="radio">
							<label for="tipoDefinitivo">Definitivo</label>
							<input type="radio" name="tipoEmprestimo" value="definitivo" id="tipoDefinitivo">
						</div>

						<div class="radio">
							<label for="tipoEmprestado">Empréstimo</label>
							<input checked type="radio" name="tipoEmprestimo" value="emprestimo" id="tipoEmprestado">
						</div>
					</div>
				</div>

				<div class="form-group">
					<div>
						<input type="checkbox" id="prazoDevolucao" onclick="exibePrazo(true)">
						<label for="prazoDevolucao">Prazo de devolução</label>
					</div>
					<div id="contPrazo" class="contPutPrazo">
						<input id="putPrazo" class="form-control" type="date" name="prazo">
					</div>
				</div>

				<div class="form-row">
					<div class="form-group col-md-6">
						<input type="text" onblur="setMaiusculo(this)" name="responsavel" placeholder="Responsável" class="form-control" required>
					</div>

					<div class="form-group col-md-6">
						<input type="text" name="dpto" placeholder="Departamento" id="putDpto" required class="form-control">

						<input type="text" id="putUnidade" name="unidade" placeholder="Unidade" class="form-control">
					</div>
				</div>

				<div class="form-group">
					<textarea class="form-control" name="descricao" rows="3" placeholder="Descrição a respeito do empréstimo de equipamentos"></textarea>
				</div>

				<div class="form-group">
					<div id="lista" class="form-control"></div>
				</div>

				<input type="submit" name="sub_form" value="Enviar" class="btn btn-primary">
			</fieldset>
		</form><br>
		<!-- Fim do formulário de cadastro //Cley -->

		<!-- Obter o total de equipamentos -->
		<?php
		$query = "SELECT COUNT(*) as qtdd FROM equipamento WHERE status!=4";
		$result = mysqli_query($conn,$query);
		$qtdd = mysqli_fetch_object($result)->qtdd;
		?>
		<div id="quantitativo">
			<?php echo $limite." de ".$qtdd; ?>
		</div>

		<!-- ******* TABELA DE LISTAGEM DE EQUIPAMENTO ******* -->
		<div id="tabelinha" class="table">
			<div class="linha-cabecalho">
				<div class="coluna">Número de Série</div>
				<div class="coluna">Equipamento</div>
				<div class="coluna">Marca</div>
				<div class="coluna">Modelo</div>
				<div class="coluna centrar">Status</div>
				<div class="coluna centrar" style="width:70px">Alocar</div>
				<div class="coluna centrar <?php echo $tipo_user; ?>" style="width:70px">Editar</div>
				<div class="coluna centrar <?php echo $tipo_user; ?>" style="width:70px">Excluir</div>
				<div class="coluna centrar <?php echo $tipo_user; ?>" style="width:70px">Histórico</div>
			</div>
			<?php
			$query = "SELECT * FROM equipamento WHERE status!=4 ORDER BY tipo";
			if(isset($_POST['submit']))
			{
				$query = "SELECT * FROM equipamento WHERE status!=4";
				if($_POST['tipo']!="")
					$query .= " and tipo='".$_POST['tipo']."'";
				if($_POST['status']!="")
					$query .= " and status=".$_POST['status'];
				$query .= " ORDER BY tipo";
			}
			$result = mysqli_query($conn,$query);
			$i=0;
			$pg = 1;
			$pganterior = 0;
			$cor = 0;
			while ($fetch = mysqli_fetch_object($result))
			{
				$status = "";
				$s = $fetch->status;
				switch ($s)
				{
					case 0:
					$status = "Disponível";
					break;

					case 1:
					$status = "Alocado";
					break;
					
					case 2:
					$status = "Defeituoso";
					break;

					case 3:
					$status = "Em manutenção";
					break;

					case 4:
					$status = "Cedido ao interior";
					break;

					default:
						# code...
					break;
				}

				if($i%2==0)
					$cor = 1;
				else
					$cor = 0;
				if ($pganterior!=$pg)
				{
					echo "<div id='pg".$pg."' class='pagina'>";
					$pganterior = $pg;
				}
				?>

				<div class="linha cor<?php echo $cor; ?>">
					<div id="<?php echo $i; ?>" class="coluna link" onclick='abrefecha(0)'>
						<?php echo $fetch->num_serie; ?>
					</div>
					<div id="e<?php echo $i; ?>" class="coluna link">
						<?php echo $fetch->tipo; ?>
					</div>
					<div id="e<?php echo $i; ?>" class="coluna link">
						<?php echo $fetch->marca; ?>
					</div>
					<div id="e<?php echo $i; ?>" class="coluna link">
						<?php echo $fetch->modelo; ?>
					</div>
					<div id="stt<?php echo $i ?>" class="coluna">
						<?php echo $status; ?>
					</div>
					<div id="lotar<?php echo $i; ?>" class="coluna link" onclick="addList(<?php echo $i; ?>)" style="width:70px">
						<?php
						if ($s == 0)
						{
							?>
							<img src="imagens/icons/seta_que_vai.svg" class="icon">
							<?php
						}
						?>
					</div>
					<!--editar equipamento-->
					<div id="<?php echo $fetch->num_serie; ?>" class="coluna link editarM <?php echo $tipo_user; ?>" data-toggle="modal" data-target="#ExemploModalCentralizado" style="width:70px">
						<img src="imagens/icons/edit.svg" class="icon">
					</div>
					<!--excluir equipamento-->
					<div id="<?php echo $fetch->num_serie; ?>" class="coluna link excluirM <?php echo $tipo_user; ?>" data-toggle="modal" data-target="#modalexcluir" style="width:70px">
						<img src="imagens/icons/delete.svg" class="icon">
					</div>
					<!-- histórico do equipamento -->
					<div class="coluna link" style="width: 70px;">
						<a href="gerarHistorico.php?serie=<?php echo $fetch->num_serie; ?>">
							<img src="imagens/icons/archive.svg" class="icon">
						</a>
					</div>
				</div>

				<!-- Modal editar equipamento-->

				<div class="modal fade editarN" id="ExemploModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="TituloModalCentralizado">Editar</h5>
								<button type="button" onclick="removeMarca()" class="close" data-dismiss="modal" aria-label="Fechar">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<form name="editar" class="was-validated">
								<div class="modal-body">

									<div class="alert-warning esconder" role="alert">

									</div>
									<div class="form-row">

										<div class="form-group col-md-6">
											<label for="inputCity">Número de Patrimônio/Série</label>
											<input type="text" name="num_serie" class="form-control" id="campoSerie" required>
											<div class="invalid-feedback">
												Informe o Número de Patrimônio!
											</div>
										</div>

										<div class="form-group col-md-6">
											<label for="inputEstado">Tipo</label>
											<select id="inputEstado" name="tipo" class="form-control" required>
												<option value="">Equipamento</option>
												<option value="Mouse">Mouse</option>
												<option value="Monitor">Monitor</option>
												<option value="Teclado">Teclado</option>
												<option value="Gabinete">Gabinete</option>
												<option value="Notebook">Notebook</option>
												<option value="Injetor">Injetor</option>
												<option value="Impressora">Impressora</option>
												<option value="Print Server">Print Server</option>
												<option value="Projetor">Projetor</option>
												<option value="Webcam">Webcam</option>
												<option value="Telefone">Telefone</option>
												<option value="Mini HD">Mini HD</option>
												<option value="Minicomputador">Minicomputador</option>
												<option value="Bateria para Nobreak">Bateria para Nobreak</option>
											</select>
											<div class="invalid-feedback">
												selecione o Tipo do Equipamento!
											</div>
										</div>

									</div>

									<div class="form-row">
										<div class="form-group col-md-6">
											<label for="inputCity">Modelo</label>
											<input type="text" name="modelo" class="form-control" id="inputCity" placeholder="Modelo do Equipamento" required>
										</div>
										<div class="form-group col-md-6">
											<label for="inputEstado">Marca</label>
											<select id="selecao" name="marca" class="form-control" required>
												<option value="">Escolher...</option>
												<option value="Dell">Dell</option>
												<option value="HP">HP</option>
												<option value="AOC">AOC</option>
												<option value="AVAYA">AVAYA</option>
												<option value="Samsung">Samsung</option>
												<option value="Logitech">Logitech</option>
												<option value="Epson">Epson</option>
												<option value="Lenovo">Lenovo</option>
												<option value="Outro">Outro</option>
											</select>
											<div class="invalid-feedback">
												selecione a Marca do Equipamento!
											</div>
										</div>
									</div>

									<!-- Campo oculto de 'outra marca'-->

									<div class="form-group" id="oculto" style="display:none">
										<!-- Só pra deixar claro que esse style na div é 100% culpa do LEANDERSON //Cley -->
										<label for="exampleFormControlTextarea1">Outros</label>
										<input type="text" name="outraMarca" class="form-control" placeholder="Marca">
									</div>

									<!-- Fim do campo oculto -->

									<div class="form-group">
										<label>Status</label>
										<select name="status" class="form-control" required>
											<option value="">Escolher...</option>
											<option value="0">Disponivel</option>
											<option value="1" disabled>Alocado</option>
											<option value="2">Defeituoso</option>
											<option value="3">Em manutenção</option>
											<option value="4" disabled>Cedido ao interior</option>
										</select>
										<div class="invalid-feedback">
											selecione a um Status
										</div>
									</div>

									<div class="form-group">
										<label for="exampleFormControlTextarea1">Descrição</label>
										<textarea class="form-control" name="descricao" id="exampleFormControlTextarea1" rows="3" placeholder="Detalhes a respeito do equipamento"></textarea>
									</div>
									<input type="hidden" title="teste"  id="<?php echo $fetch->num_serie; ?>" />

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="removeMarca()">Fechar</button>
									<button type="submit" id="<?php echo $fetch->num_serie; ?>" data-dismiss="" class="btn btn-primary enveditar">Salvar mudanças</button>
								</div>
							</form>

						</div>
					</div>
				</div>

				<!--Inicio Modal excluir -->


				<div class="modal fade" tabindex="-1" role="dialog" id="modalexcluir" aria-labelledby="mySmallModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered modal-sm">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="TituloModalCentralizado">Excluir</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="alert alert-primary esconderex" role="alert" >
									Confirmar Exclusão?
								</div>
								
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-primary" value="1">Sim</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
								
							</div>

						</div>
					</div>
				</div><!--fim  Modal excluir -->


				<?php
				$i++;
				if($i%$limite==0)
				{
					echo "</div>";
					$pg++;
				}
			}
			?>
		</div>

		<div class="paginacao">
			<div onclick="back()" class="btn btn-primary">Anterior</div>
			<div class="botoes">
				<?php
				for ($i=1; $i <= $pganterior; $i++)
				{
					echo "<div onclick='paginacao(".$i.")' id='btn".$i."' class='btn btn-primary'>".$i."</div>";
				}
				?>
			</div>
			<div onclick="next()" class="btn btn-primary">Próximo</div>
		</div>

	</div><!--fim div do painel-->

</body>

<?php
if (isset($_GET['edit']))
{
	echo "<script async>alert('Informações do equipamento editadas!')</script>";
}
if (isset($_GET['excluido']))
{
	echo "<script>alert('Equipamento excluido!')</script>";
}

if(isset($_GET['protocolo']))
{
	echo "<script>alert('O número de protocolo é ".$_GET['protocolo'].". Anote-o!')</script>";
}
?>

<script>
	$(function(){
		$('select[name="marca"]').change(function () { 
			var valor = $(this).val();
			if (valor == "Outro"){
				$("#oculto").show(300);
			}else{
				$("#oculto").hide(300);
			}
		});
	});

	function removeMarca()
	{
		selecao = document.getElementById('selecao');
		marca = selecao.lastChild.innerText;
		if(marca != 'Outro')
			document.getElementById('selecao').removeChild(selecao.lastChild);
	}
</script>