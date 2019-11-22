<?php require 'conn.php'; ?>

<?php
if (isset($_POST['submit']))
{
	$serie = $_GET['serie'];
	$status = $_POST['status'];
	$desc = $_POST['descricao'];
	$sql = "UPDATE equipamento SET status=$status, descricao='$desc' WHERE num_serie=$serie";
	echo $sql;
	mysqli_query($conn,$sql);
	header('Location: lista_equipamento.php?edit=1');
}
?>

<?php
function Status($id_status)
{
	$status = "";
	switch ($id_status)
	{
		case 0:
			$status = "Disponivel";	
		break;

		case 2:
			$status = "Com defeito";	
		break;

		case 3:
			$status = "Em manutenção";	
		break;
		
		default:
			# code...
			break;
	}
	return $status;
}

if (isset($_GET['serie']))
{
	$sql = "SELECT * FROM equipamento WHERE num_serie=".$_GET['serie'];
	$result = mysqli_query($conn,$sql);
	$fetch = mysqli_fetch_object($result);
	$s = $fetch->status;
	$status = Status($s);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Editar Equipamento</title>
</head>
<body>

<form method="post">
	<input type="text" name="num_serie" value="<?php echo $fetch->num_serie ?>" readonly='true'><br>
	<input type="text" name="tipo" value="<?php echo $fetch->tipo ?>" readonly='true'><br>
	<?php if ($fetch->status!=1){ ?>
	<select name="status">
		<option value="<?php echo $fetch->status; ?>"> <?php echo $status; ?> </option>
		<?php
		if ($s==0)
		{
			echo "<option value='2'>".Status(2)."</option>";
			echo "<option value='3'>".Status(3)."</option>";
		}else if($s==2){
			echo "<option value='0'>".Status(0)."</option>";
			echo "<option value='3'>".Status(3)."</option>";
		}else{
			echo "<option value='0'>".Status(0)."</option>";
			echo "<option value='2'>".Status(2)."</option>";
		}
		?>
	</select>
	<?php }else{ ?>
		<input type="text" name="desabilitado" value="O equipamento deve ser devolvido primeiro" disabled>
	<?php } ?>
	<br>
	<textarea name="descricao"><?php echo $fetch->descricao; ?></textarea><br>

	<?php if ($fetch->status!=1){ ?>
	<input type="submit" name="submit" value="Atualizar">
	<?php } ?>
</form>

</body>
</html>