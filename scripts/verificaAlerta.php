<?php
function verificaAlerta()
{
	require 'conn.php';
	$dt_atual = date("Y-m-d");
	$query = "SELECT * FROM ligacao WHERE lot_status=0 and prazo";
	$result = mysqli_query($conn,$query);
	while($fetch = mysqli_fetch_object($result))
	{
		$dt = explode("-", $dt_atual);
		$dia = intval($dt[2]);
		$mes = intval($dt[1]);

		$dt_venc = explode("-", $fetch->prazo);
		$dia_venc = intval($dt_venc[2]);
		$mes_venc = intval($dt_venc[1]);

		if($mes==$mes_venc)
		{
			$falta = $dia_venc - $dia;
			if ($falta <= 7)
			{
				return true;
			}
		}
	}

	$query = "SELECT * FROM ligacao_interior WHERE lot_status=0 and prazo";
	$result = mysqli_query($conn,$query);
	while($fetch = mysqli_fetch_object($result))
	{
		$dt = explode("-", $dt_atual);
		$dia = intval($dt[2]);
		$mes = intval($dt[1]);

		$dt_venc = explode("-", $fetch->prazo);
		$dia_venc = intval($dt_venc[2]);
		$mes_venc = intval($dt_venc[1]);

		if($mes==$mes_venc)
		{
			$falta = $dia_venc - $dia;
			if ($falta <= 7)
			{
				return true;
			}
		}
	}
	return false;
}
?>