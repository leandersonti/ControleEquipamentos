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

// Define status do equipamento
$status = $_GET['status'];
$status_original = $status;
if($status == 4) $status = 1;

// Caso o usuário cancele o cadastro
if (isset($_POST['cancelar']))
{
	header("Location: cad_equipamento.php");
}
// Script de inserção no banco
if(isset($_POST['cad']))
{
	$q = $_GET['qtdd'];

	if ($q<10) $qtdd = $q;
	else $qtdd = '0'.$q;

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

			$query = "INSERT INTO equipamento(num_serie,tipo,descricao,marca,modelo,status,condicao_entrada) VALUES ('".$_POST['serie'.$j]."','".$_GET['tipo']."','".$_GET['descricao']."','".$marca."','".$_GET['modelo']."',".$status.",".$_GET['condicao_entrada'].")";
			$result = mysqli_query($conn,$query);
			if(!$result)
				$flag=false;
		}
	}

	$dpto = $_GET['local_equipamento'];
	$responsavel = $_GET['responsavel'];
	if ($status_original==1 && $flag)
	{
		do
		{
			$num_protocolo = date("y")."".$qtdd;
			$num_protocolo .= rand(0,9);
			$num_protocolo .= rand(0,9);
			$num_protocolo .= rand(0,9);
			$num_protocolo .= rand(0,9);
			$num_protocolo .= rand(0,9);

			$protocolo = intval($num_protocolo);
			$query = "SELECT protocolo FROM e_lotado WHERE protocolo=".$protocolo;
			$rs = mysqli_query($conn,$query);
		}while (mysqli_fetch_object($rs));

		for ($k=0;$k<$q;$k++){
			$query = "INSERT INTO e_lotado(protocolo,dpto,responsavel) VALUES(".$protocolo.",'".$dpto."','".$responsavel."')";
			$insert = mysqli_query($conn,$query);
			if (!$insert) echo 2;

			$query = "INSERT INTO ligacao(e_num_serie,prot_lotacao,lot_status,data_lotacao) VALUES('".$_POST['serie'.$k]."',".$protocolo.",0,now())";
			$insert = mysqli_query($conn,$query);
			if (!$insert) echo 2;
		}

	}else if($status_original==4 && $flag){
		do
		{
			$num_protocolo = date("y")."".$qtdd;
			$num_protocolo .= rand(0,9);
			$num_protocolo .= rand(0,9);
			$num_protocolo .= rand(0,9);
			$num_protocolo .= rand(0,9);
			$num_protocolo .= rand(0,9);

			$protocolo = intval($num_protocolo);
			$query = "SELECT protocolo FROM e_lotado_interior WHERE protocolo=".$protocolo;
			$rs = mysqli_query($conn,$query);
		}while (mysqli_fetch_object($rs));

		for ($k=0;$k<$q;$k++){
			$query = "INSERT INTO e_lotado_interior(protocolo,unidade,responsavel) VALUES(".$protocolo.",'".$dpto."','".$responsavel."')";
			$insert = mysqli_query($conn,$query);
			if (!$insert) echo 2;

			$query = "INSERT INTO ligacao_interior(i_num_serie,prot_lotacao,lot_status,data_lotacao) VALUES('".$_POST['serie'.$k]."',".$protocolo.",0,now())";
			$insert = mysqli_query($conn,$query);
			if (!$insert) echo 2;
		}

	}

	if($flag)
	{
		header("Location: lista_equipamento.php");
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