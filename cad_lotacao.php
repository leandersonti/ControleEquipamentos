<?php require 'conn.php'; ?>

<?php

if (isset($_POST['submit']))
{
	$sql = "SELECT * FROM equipamento WHERE num_serie=".$_POST['num_serie'];
	$consulta = mysqli_query($conn,$sql);
	$rs = mysqli_fetch_object($consulta);
	if($rs->status==0)
	{
		// INSERIR LOTAÇÃO DE UM EQUIPAMENTO NA TABELA 'e_lotado'
		$sql = "INSERT INTO e_lotado(protocolo,responsavel,dpto) VALUES (".$_POST['protocolo'].",'".$_POST['responsavel']."','".$_POST['dpto']."')";
		$consulta = mysqli_query($conn,$sql);
		if ($consulta)
		{
			// INSERIR CHAVES NA TABELA DE LIGAÇÃO
			$sql = "INSERT INTO ligacao (e_num_serie,prot_lotacao,data_lotacao,lot_status) VALUES (".$_POST['num_serie'].",".$_POST['protocolo'].",now(),0)";
			$consulta = mysqli_query($conn,$sql);
			
			// SETAR O STATUS DO EQUIPAMENTO EMPRESTADO PARA 1
			$sql = "UPDATE equipamento SET status=1 WHERE num_serie=".$_POST['num_serie'];
			$consulta = mysqli_query($conn,$sql);
			// if ($consulta) echo "Conseguiu";
		}
	}else{
		echo "Equipamento já está lotado";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Cadastrar lotação</title>
</head>
<body>

	<form method="post">
		<input type="text" name="protocolo" placeholder="Protocolo" required><br>
		<input type="text" name="dpto" placeholder="Departamento" required><br>
		<input type="text" name="responsavel" placeholder="Responsavel" required><br>
		
		<?php
		if (isset($_GET['serie']))
		{
		?>
		Número de serie: <br>
		<input type="text" name="num_serie" value="<?php echo $_GET['serie'] ?>" readonly='true'><br>
		<?php }else{ ?>
		Número de serie: <select name="num_serie">
			<?php

			$sql = "SELECT * FROM equipamento WHERE status=0";
			$consulta = mysqli_query($conn,$sql);
			while ($rs = mysqli_fetch_object($consulta))
			{
				echo "<option value=".$rs->num_serie.">".$rs->num_serie."</option>";
			}

			?>
		</select><br>
		<?php } ?>
		
		<input type="submit" name="submit" value="Enviar">
	</form>

</body>
</html>