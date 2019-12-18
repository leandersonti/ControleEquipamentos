<?php
require '../conn.php';

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

$pagina = "<!DOCTYPE html>
<html>
<head>
	<title>Histórico de Equipamento</title>
	<style>
		*{font-family: sans-serif;}
		
		.relatorio{
			width: 95%;
			margin: 30px auto;
			border-radius: 10px;
		}

		.cabeca{
			font-weight: 600;
			background: #E6E6FA;
		}

		.linha1{
			background: #F0F8FF;
		}

		.tableRelat{
			border: 1px solid rgba(0,0,0,.7);
		}

		table{
			width: 100%;
			margin-bottom: 40px;
		}

		td{
			text-align:center;
			height: 50px;
		}
	</style>
</head>
<body>";

$serie = $_GET['serie'];
$sql = "SELECT * FROM equipamento WHERE num_serie='$serie'";
$tipo = mysqli_fetch_object(mysqli_query($conn,$sql))->tipo;
$status = mysqli_fetch_object(mysqli_query($conn,$sql))->status;


$pagina .= "
<div class='relatorio'>
<table>
	<tr>
		<td><b>N° série: </b>$serie</td>
		<td><b>Tipo: </b>$tipo</td>
		<td><b>Status atual: </b>".conveteStatus($status)."</td>
	</tr>
</table>

<table cellspacing=0 class='tableRelat'>
	<tr class='cabeca'>
		<td>Departamento</td>
		<td>Responsável</td>
		<td>Locação</td>
		<td>Devolução</td>
		<td>Locador</td>
		<td>Receptor</td>
	</tr>";

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

		$pagina .= "
		<tr class='$cor'>
			
			<td>$fetch->dpto</td>
			<td>$fetch->responsavel</td>
			<td>".dtPortugues($fetch->data_lotacao)."</td>
			<td>$dt_dev</td>
			<td>$locador</td>
			<td>$receptor</td>

		</tr>";
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

		$pagina .= "
		<tr class='$cor'>
			
			<td>$fetch->unidade</td>
			<td>$fetch->responsavel</td>
			<td>".dtPortugues($fetch->data_lotacao)."</td>
			<td>$dt_dev</td>
			<td>$locador</td>
			<td>$receptor</td>

		</tr>";
	}
$pagina .= "
</table>
</div>
";

$pagina .= "
</body>
</html>";

use Dompdf\Dompdf;

require_once 'dompdf/autoload.inc.php';

//instanciando
$dompdf = new Dompdf();

//lendo o arquivo
$html = file_get_contents('historicoPDF.php');

//inserindo o html que queremos converter
$dompdf->load_html($pagina);

//definindo o papel e a orientação
$dompdf->setPaper('A4','portrait');

// Renderizando o HTML como PDF
$dompdf->render();

// Enviando o PDF para o browser
$dompdf->stream(
	"historico.pdf",
	array("Attachment" => false)
);
?>