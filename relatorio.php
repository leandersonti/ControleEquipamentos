<?php require 'conn.php'; 
include_once("head.php");
include_once('topoLogo.php');
include_once('menu.php');
?>

<body>
	<div style="width:50%; margin:100px auto" class="panel panel-defalt">
		<div class="flex">
			<div>
				<label>Gerar relatório de equipamentos</label> <br>
				<a href="PDF/gerar.php/?tipo=1" target="blank" class="btn btn-primary">Gerar</a>
			</div>

			<div>
				<label>Gerar relatório de emprestimos</label> <br>
				<a href="PDF/gerar.php/?tipo=2" target="blank" class="btn btn-primary">Gerar</a>
			</div>
		</div>
	</div>
</body>

<style type="text/css">
	.flex{display: flex;flex-direction: column;}
	.flex div{padding: 10px;}
</style>

</html>