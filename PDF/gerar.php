<?php require '../conn.php'; ?>

<?php
$query = "SELECT *,COUNT(*) as total FROM equipamento GROUP BY tipo";
$result = mysqli_query($conn,$query);

if($_GET['tipo']==1)
	$tabela = "tabela_equipamento.php";
else
	$tabela = "tabela_emprestimo.php";

$pagina = "<!DOCTYPE html>
<html>
<head>
	<title>Relatório</title>
	<style>
		*{font-family: sans-serif;}
		table{width: 600px;margin: 0 auto;}
		table{border: 1px solid black;}
		td{padding: 5px;}

		.centro{text-align: center;}
		.row-cond{background-color: lightblue;}
		.row-eqp,.row-cond{font-size: 18px;text-align: center;}
		.row-eqp{background-color: skyblue;font-weight: bold;}
	</style>
</head>
<body>";

if($tabela=="tabela_equipamento.php")
{
	while($rs = mysqli_fetch_object($result))
	{
		// arquivo vergonha.php possui as consultas referente aos dados das tabelas
		include 'vergonha.php';

		include $tabela;
	}
}else{
	include 'vergonha.php';
	
	include $tabela;
}

$pagina .= "
	</body>
</html>";

use Dompdf\Dompdf;

require_once 'dompdf/autoload.inc.php';

//instanciando
$dompdf = new Dompdf();

//lendo o arquivo
$html = file_get_contents('teste.php');

//inserindo o html que queremos converter
$dompdf->load_html($pagina);

//definindo o papel e a orientação
$dompdf->setPaper('A4','portrait');

// Renderizando o HTML como PDF
$dompdf->render();

// Enviando o PDF para o browser
$dompdf->stream(
	"teste.pdf",
	array("Attachment" => false)
);

?>

<!-- <!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
		table{width: 400px;}
		table{border: 1px solid black;}
		td{text-align: center;padding: 5px;}

		.row-eqp{background-color: lightblue;}
		.row-cond{background-color: skyblue;}
	</style>
</head>
<body>
	<table cellpadding="0" cellspacing="0">
		<tr class='row-eqp'>
			<td colspan='3'>Equipamento</td>
			<td>Total: X</td>
		</tr>

		<tr class='row-cond'>
			<td colspan='2' style='border-right: 1px solid black'>Novo</td>
			<td colspan='2'>Doado</td>
		</tr>

		<tr>
			<td>Status</td>
			<td style='border-right: 1px solid black'>Quantidade: A</td>
			<td>Status</td>
			<td>Quantidade: B</td>
		</tr>

		<tr>
			<td>Status</td>
			<td style='border-right: 1px solid black'>Quantidade: C</td>
			<td>Status</td>
			<td>Quantidade: D</td>
		</tr>

		<tr>
			<td>Status</td>
			<td style='border-right: 1px solid black'>Quantidade: E</td>
			<td>Status</td>
			<td>Quantidade: F</td>
		</tr>

		<tr>
			<td>Status</td>
			<td style='border-right: 1px solid black'>Quantidade: G</td>
			<td>Status</td>
			<td>Quantidade: H</td>
		</tr>
	</table>
</body>
</html> -->