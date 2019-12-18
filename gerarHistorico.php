<?php
require_once 'conn.php';
$serie = $_GET['serie'];
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>

	<link rel="stylesheet" type="text/css" href="css/relatorioEquipamento.css">
	<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>
<body>

	<?php
	$sql = "SELECT * FROM equipamento WHERE num_serie='$serie'";
	$tipo = mysqli_fetch_object(mysqli_query($conn,$sql))->tipo;
	$status = mysqli_fetch_object(mysqli_query($conn,$sql))->status;
	?>
	<div class="relatorio">
		<div class="linha info">
			<?php
			echo "<p><b>N° série: </b>".$serie."</p>";
			echo "<p><b>Tipo: </b>".$tipo."</p>";
			echo "<p><b>Status atual: </b>".conveteStatus($status)."</p>";
			?>
		</div>

		<div class="linha details cabecalho">
			<p>Departamento</p>
			<p>Responsável</p>
			<p>Locação</p>
			<p>Devolução</p>
			<p>Locador</p>
			<p>Receptor</p>
		</div>

		<?php
		$query = "SELECT * FROM ligacao,e_lotado WHERE e_num_serie='".$serie."' and protocolo=prot_lotacao";
		$result = mysqli_query($conn,$query);

		$i=0;
		while ($fetch = mysqli_fetch_object($result))
		{
			if($i==1)
			{
				$cor = "linha1";
				$i=0;
			}else{
				$cor = "";
				$i=1;
			}

			$sql = "SELECT nome FROM usuario WHERE titulo='$fetch->titulo_locador'";
			$locador = mysqli_fetch_object(mysqli_query($conn,$sql))->nome;

			$receptor = "A definir";
			if($fetch->titulo_receptor)
			{
				$sql = "SELECT nome FROM usuario WHERE titulo='$fetch->titulo_receptor'";
				$receptor = mysqli_fetch_object(mysqli_query($conn,$sql))->nome;
			}

			$dt_dev = "A devolver";
			if($fetch->data_devolucao) $dt_dev = dtPortugues($fetch->data_devolucao);
			?>
			<div class="linha details <?php echo $cor ?>">
				<?php
				echo "<p>$fetch->dpto</p>";
				echo "<p>$fetch->responsavel</p>";
				echo "<p>".dtPortugues($fetch->data_lotacao)."</p>";
				echo "<p>".$dt_dev."</p>";
				echo "<p>$locador</p>";
				echo "<p>$receptor</p>";
				?>
			</div>
			<?php 
		}


		$query = "SELECT * FROM ligacao_interior,e_lotado_interior WHERE i_num_serie='".$serie."' and protocolo=prot_lotacao";
		$result = mysqli_query($conn,$query);
		
		$i=0;
		while ($fetch = mysqli_fetch_object($result))
		{
			if($i==1)
			{
				$cor = "linha1";
				$i=0;
			}else{
				$cor = "";
				$i=1;
			}

			$sql = "SELECT nome FROM usuario WHERE titulo='$fetch->titulo_locador'";
			$locador = mysqli_fetch_object(mysqli_query($conn,$sql))->nome;

			$receptor = "A definir";
			if($fetch->titulo_receptor)
			{
				$sql = "SELECT nome FROM usuario WHERE titulo='$fetch->titulo_receptor'";
				$receptor = mysqli_fetch_object(mysqli_query($conn,$sql))->nome;
			}

			$dt_dev = "A devolver";
			if($fetch->data_devolucao) $dt_dev = dtPortugues($fetch->data_devolucao);
			?>
			<div class="linha details <?php echo $cor ?>">
				<?php
				echo "<p>$fetch->unidade</p>";
				echo "<p>$fetch->responsavel</p>";
				echo "<p>".dtPortugues($fetch->data_lotacao)."</p>";
				echo "<p>".$dt_dev."</p>";
				echo "<p>$locador</p>";
				echo "<p>$receptor</p>";
				?>
			</div>
			<?php 
		}
		?>
	</div>

	<a href="lista_equipamento.php#tabelinha" class="btn btn-voltar">
		<div class="cont-img-btn">
			<img src="imagens/icons/back-arrow.svg" class="img-100">
		</div>
		<span>Voltar</span>
	</a>

	<a href="PDF/historico.php?serie=<?php echo $serie; ?>" target="_blank" class="export">
		<img src="imagens/icons/pdf.svg" class="img-100 img-export">
		<span>Exportar PDF</span>
	</a>
</body>
</html>

<?php
function conveteStatus($status)
{
	$s = '';
	switch ($status)
	{
		case 0:
		$s = "Disponivel";
		break;

		case 1:
		$s = "Alocado";
		break;
		
		case 2:
		$s = "Defeituoso";
		break;

		case 3:
		$s = "Em manutenção";
		break;

		case 4:
		$s = "Cedido ao interior";
		break;

		default:
			# code...
		break;
	}
	return $s;
}

function dtPortugues($dt)
{
	$data = new DateTime($dt);
	return $data->format('d/m/Y');
}
?>