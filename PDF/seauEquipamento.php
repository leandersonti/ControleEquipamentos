<?php

$sql = "SELECT *,COUNT(*) as total FROM equipamento GROUP BY tipo";
$consulta = mysqli_query($conn,$sql);

while ($rs = mysqli_fetch_object($consulta))
{

	$pagina .= "
	<table cellpadding='0' cellspacing='0' style='margin-top: 10px;'>
		<tr class='row-eqp'>
			<td colspan='3'>".$rs->tipo."</td>
			<td>Total: ".$rs->total."</td>
		</tr>";

	$query = "SELECT *,COUNT(*) FROM equipamento WHERE tipo='$rs->tipo' GROUP BY marca,modelo";
	$result = mysqli_query($conn,$query);
	$pagina .= $query;

	while($fetch = mysqli_fetch_object($result))
	{
		for ($j=0; $j < 2; $j++)
		{ 
			$query = "SELECT COUNT(*) as s FROM equipamento WHERE condicao_entrada=$j and marca='$fetch->marca' and modelo='$fetch->modelo'";
			$busca = mysqli_query($conn,$query);
			$f = mysqli_fetch_object($busca);
			$condicao[$j] = $f->s;
		}

		for ($j=0; $j < 6; $j++)
		{ 
			$query = "SELECT COUNT(*) as s FROM equipamento WHERE status=$j and marca='$fetch->marca' and modelo='$fetch->modelo'";
			$busca = mysqli_query($conn,$query);
			$f = mysqli_fetch_object($busca);
			$status[$j] = $f->s;
		}

		$pagina .= "

		<tr class='row-marc'>
			<td colspan='4'>".$fetch->marca." - ".$fetch->modelo."</td>
		</tr>
		<tr>
			<td colspan='2'>Disponiveis: </td>
			<td colspan='2' class='colqtdd'>Quantidade: ".$status[0]."</td>
		</tr>
		<tr>
			<td colspan='2'>Alocados: </td>
			<td colspan='2' class='colqtdd'>Quantidade: ".$status[1]."</td>
		</tr>
		<tr>
			<td colspan='2'>Defeituosos: </td>
			<td colspan='2' class='colqtdd'>Quantidade: ".$status[2]."</td>
		</tr>
		<tr>
			<td colspan='2'>Em manutenção: </td>
			<td colspan='2' class='colqtdd'>Quantidade: ".$status[3]."</td>
		</tr>
		<tr>
			<td colspan='2'>Cedidos ao interior: </td>
			<td colspan='2' class='colqtdd'>Quantidade: ".$status[4]."</td>
		</tr>
		<tr>
			<td colspan='2'>Desfeitos: </td>
			<td colspan='2' class='colqtdd'>Quantidade: ".$status[5]."</td>
		</tr>
		<tr>
			<td colspan='2'>Novos: </td>
			<td colspan='2' class='colqtdd'>Quantidade: ".$condicao[0]."</td>
		</tr>
		<tr>
			<td colspan='2'>Doados: </td>
			<td colspan='2' class='colqtdd'>Quantidade: ".$condicao[1]."</td>
		</tr>";
	}
	$pagina .= "
	</table>";
}
?>