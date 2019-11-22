<?php require 'conn.php'; 
include_once("head.php");
include_once('topoLogo.php');
include_once('menu.php');
?>

<?php
// script para definir a marca do equipamento
$marca = "";
if($_GET['marca'] == "Outro")
{
	$marca = $_GET['outraMarca'];
}else{
	$marca = $_GET['marca'];
}

// Caso o usuário cancele o cadastro
if (isset($_POST['cancelar']))
{
	header("Location: cad_equipamento.php");
}
// Script de inserção no banco
if(isset($_POST['cad']))
{
	
	$q = $_GET['qtdd'];
	$i=0;
	$flag = true;

	while ($i<$q && $flag)
	{
		$query = "SELECT * FROM equipamento WHERE num_serie='".$_POST['serie'.$i]."'";
		$result = mysqli_query($conn,$query);
		if(mysqli_fetch_object($result))
		{
			echo "<script>alert('O Número de Série".$_POST['serie'.$i]." já existe')</script>";
			$flag = false;
		}
		$i++;
	}
	if($flag)
	{	

		for ($j=0; $j < $q; $j++)
		{

			$query = "INSERT INTO equipamento(num_serie,tipo,descricao,marca,modelo,status,condicao_entrada) VALUES ('".$_POST['serie'.$j]."','".$_GET['tipo']."','".$_GET['descricao']."','".$marca."','".$_GET['modelo']."',0,".$_GET['condicao_entrada'].")";
			$result = mysqli_query($conn,$query);
			if(!$result)
				$flag=false;
		}
		if($flag)
		{
			header("Location: lista_equipamento.php");
		}
	}
}
?>


<body>
	<div style="width:50%; margin:100px auto" class="panel panel-defalt">
		<form method="post">
			<div class="alert alert-primary" role="alert">
				<?php echo "Tipo de Equipamento: ".$_GET['tipo'].", Marca: '".$marca."', Modelo: ".$_GET['modelo']; ?>
			</div>

			<?php
			for ($i=0; $i < $_GET['qtdd']; $i++)
			{
				echo "<input name='serie$i' class='form-control' type='text' placeholder='Número de série do ".($i+1)."° equipamento'> <br>";
			}
			?>
			<div class="form-row">
				<div class="form-group col-md-2">
					<input type="submit" name="cad" value="Cadastrar" class="form-control btn btn-primary"> 
				</div>
				<div class="form-group col-md-2">
					<input type="submit" name="cancelar" value="Cancelar" class="form-control btn btn-danger"> 
				</div>
			</div>
		</form>
	</div>

</body>
</html>