<?php
require '../conn.php';
$pagina = "<!DOCTYPE html>
<html>
<head>
	<title>Histórico de Equipamento</title>
	<style>
		*{font-family: sans-serif;}
		table{width: 600px;margin: 0 auto;}
		table{border: 1px solid black;}
		td{padding: 5px;}

		.centro{text-align: center;}
		.colqtdd{text-align: center;}
		.row-marc{background-color: lightgrey;}
		.row-eqp,.row-marc{font-size: 18px;text-align: center;}
		.row-eqp{background-color: skyblue;font-weight: bold;}
	</style>
</head>
<body>";

include 'seauEquipamento.php';

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
	"relatorioSeau.pdf",
	array("Attachment" => false)
);
?>