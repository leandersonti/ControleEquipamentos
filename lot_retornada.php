<?php require 'conn.php'; ?>

<?php

function data($date)
{
	return date("d/m/Y", strtotime($date));
}

?>

<?php 
require 'conn.php'; 
include_once('head.php');
include_once('topoLogo.php');
include_once('menu.php');
?>
<script async src="scripts/lista_equipamento.js" type="text/javascript"></script>
<body>

	<!-- Inputs do tipo hidden para controlar a paginação feita no JavaScript -->
	<input type="hidden" id="inputEscondido" value="1">
	<?php
	$sql = "SELECT COUNT(*) AS qtdd FROM equipamento";
	if(isset($_POST['submit']))
	{
		$sql = "SELECT COUNT(*) AS qtdd FROM equipamento WHERE status!=4";
		if($_POST['tipo']!="")
			$sql .= " and tipo='".$_POST['tipo']."'";
		if($_POST['status']!="")
			$sql .= " and status=".$_POST['status'];
	}
	$consulta = mysqli_query($conn,$sql);
	$rs = mysqli_fetch_object($consulta);
	$maximo = ceil($rs->qtdd/10);
	?>
	<input type="hidden" id="fecharPagina" value="0">
	<input type="hidden" id="totalPaginas" value="<?php echo $maximo ?>">

	<div style="width:80%; margin:100px auto" class="panel panel-defalt">

		<div id="tabelinha" class="table">
			<div class="linha-cabecalho">
				<div class="coluna">Protocolo</div>
				<div class="coluna">Número de Série</div>
				<div class="coluna">Equipamento</div>
				<div class="coluna centrar">Responsavel</div>
				<div class="coluna centrar">Departamento</div>
				<div class="coluna centrar">Emprestimo</div>
				<div class="coluna centrar">Devolução</div>
			</div>
			<?php
			$query = "SELECT * FROM equipamento,ligacao,e_lotado WHERE num_serie=e_num_serie and protocolo=prot_lotacao and lot_status=1";
			$result = mysqli_query($conn,$query);

			$sql = "SELECT * FROM equipamento, ligacao_interior, e_lotado_interior WHERE num_serie=i_num_serie and protocolo=prot_lotacao and lot_status=1";

			$consulta = mysqli_query($conn,$sql);

			$i=0;
			$pg = 1;
			$pganterior = 0;
			$cor = 0;
			while ( ($fetch = mysqli_fetch_object($result)) || ($rs = mysqli_fetch_object($consulta)) )
			{
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

				<?php
				if(isset($fetch->dpto))
				{
					?>
					<div class="linha cor<?php echo $cor; ?>">
						<div class="coluna link" onclick='abrefecha(0)'>
							<?php echo $fetch->protocolo; ?>
						</div>
						<div class="coluna link">
							<?php echo $fetch->num_serie; ?>
						</div>
						<div class="coluna">
							<?php echo $fetch->tipo; ?>
						</div>
						<div class="coluna link">
							<?php echo $fetch->responsavel; ?>
						</div>
						<div class="coluna link">
							<?php echo $fetch->dpto; ?>
						</div>
						<div class="coluna link">
							<?php echo data($fetch->data_lotacao); ?>
						</div>
						<div class="coluna link">
							<?php echo data($fetch->data_devolucao); ?>
						</div>
					</div>
				<?php }
				if(isset($rs->unidade))
				{
					?>
					<div class="linha cor<?php echo $cor; ?>">
						<div class="coluna link">
							<?php echo $rs->protocolo; ?>
						</div>
						<div class="coluna link">
							<?php echo $rs->num_serie; ?>
						</div>
						<div class="coluna">
							<?php echo $rs->tipo; ?>
						</div>
						<div class="coluna link">
							<?php echo $rs->responsavel; ?>
						</div>
						<div class="coluna link">
							<?php echo $rs->unidade; ?>
						</div>
						<div class="coluna link">
							<?php echo data($rs->data_lotacao); ?>
						</div>
						<div class="coluna link">
							<?php echo data($rs->data_devolucao); ?>
						</div>
					</div>
					<?php
				}
				?>
				<?php
				$i++;
				if($i%10==0)
				{
					echo "</div>";
					$pg++;
				}
			}
			?>
		</div>

		<div class="paginacao">
			<div onclick="back()" class="btn btn-primary">Back</div>
			<div class="botoes">
				<?php
				for ($i=1; $i <= $pganterior; $i++)
				{
					echo "<div onclick='paginacao(".$i.")' id='btn".$i."' class='btn btn-primary'>".$i."</div>";
				}
				?>
			</div>
			<div onclick="next()" class="btn btn-primary">Next</div>
		</div>

	</div><!--fim div do painel-->

	<!-- Aqui a light box pra exibir dados do equipamento -->
	<div id="box">
		<div id="box-menor">
			<button onclick="abrefecha(1)" class="bt-fechar">
				<img class="img-100" src="imagens/icons/cancel.svg">
			</button>
		</div>
	</div>

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
?>