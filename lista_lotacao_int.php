<?php require 'conn.php'; 
include_once("head.php");
include_once('topoLogo.php');
include_once('menu.php');
?>
<script async src="js/paginacao.js" type="text/javascript"></script>
<body>
	<div style="width:80%; margin:100px auto" class="panel panel-defalt">

		<!-- Formulario dos Filtros //Cley -->
		<form method="post">
			<div class="form-group col-md-6" style="margin-left:-15px">
				Filtrar por:
			</div>
			
			<div class="form-row">
				<div class="form-group col-md-3">
					<select name="equipamento" class="form-control">
						<option value="">Equipamento</option>
						<?php
						$query = "SELECT * FROM ligacao_interior,equipamento,e_lotado_interior WHERE i_num_serie=num_serie and prot_lotacao=protocolo and lot_status=0 GROUP BY tipo";
						$result = mysqli_query($conn,$query);
						while ($rs = mysqli_fetch_object($result))
						{
							echo "<option value='".$rs->tipo."'>".$rs->tipo."</option>";
						}
						?>
					</select>
				</div>

				<div class="form-group col-md-3">
					<select name="responsavel" class="form-control">
						<option value="">Responsável</option>
						<?php
						$query = "SELECT * FROM ligacao_interior,equipamento,e_lotado_interior WHERE i_num_serie=num_serie and prot_lotacao=protocolo and lot_status=0 GROUP BY responsavel";
						$result = mysqli_query($conn,$query);
						while ($rs = mysqli_fetch_object($result))
						{
							echo "<option value='".$rs->responsavel."'>".$rs->responsavel."</option>";
						}
						?>
					</select>
				</div>

				<div class="form-group col-md-3">
					<select name="dpto" class="form-control">
						<option value="">Unidade</option>
						<?php
						$query = "SELECT * FROM ligacao_interior,equipamento,e_lotado_interior WHERE i_num_serie=num_serie and prot_lotacao=protocolo and lot_status=0 GROUP BY unidade";
						$result = mysqli_query($conn,$query);
						while ($rs = mysqli_fetch_object($result))
						{
							echo "<option value='".$rs->unidade."'>".$rs->unidade."</option>";
						}
						?>
					</select>
				</div>

				<div class="form-group col-md-3">
					<input type="submit" name="filtro" value="Filtrar" class="btn btn-primary">
				</div>
			</div>
			<!--fim div form-row-->
		</form>
		<!-- Fim do formulário dos filtros //Cley -->
		<br>
		<?php
		$query = "SELECT COUNT(*) as qtdd FROM equipamento,e_lotado_interior,ligacao_interior WHERE num_serie=i_num_serie and protocolo=prot_lotacao and lot_status=0";
		$result = mysqli_query($conn,$query);
		$totalzao = mysqli_fetch_object($result)->qtdd;
		?>

		<div id="quantitativo">
			10	de <?php echo $totalzao; ?>
		</div>

		<?php include_once('tab_lotacao_interior.php') ?>

	</div>
</body>

</html>

<!-- Bloco de codigo para alertar quanto à devolução //Cley -->
<?php
if(isset($_GET['ok']))
{
	echo "<script>alert('Equipamento devolvido com sucesso!!!')</script>";
}
?>