<?php require 'conn.php'; 
include_once("head.php");
include_once('topoLogo.php');
include_once('menu.php');
?>

<body>
	<div style="width:50%; margin:100px auto" class="panel panel-defalt">
		<div class="relatorios">
			<label>Gerar relatório de equipamentos</label>
			<div class="equipamentos">
				<div>
					<a href="PDF/gerar.php/?tipo=1" target="blank" class="btn btn-primary">Modelo 1</a>
				</div>

				<div>
					<a href="PDF/relatorioSeau.php" target="blank" class="btn btn-primary">Modelo 2</a>
				</div>
			</div>

			<label>Gerar relatório de emprestimos</label>
			<div>
				<a href="PDF/gerar.php/?tipo=2" target="blank" class="btn btn-primary">Gerar</a>
			</div>
		</div>
	</div>
</body>

<style type="text/css">
	.relatorios{display: flex;flex-direction: column;}
	.equipamentos{display: flex;width: 210px;justify-content: space-between;}
</style>

</html>