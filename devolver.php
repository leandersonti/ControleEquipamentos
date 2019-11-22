<?php
require 'conn.php';

session_start();
if(!isset($_SESSION['titulo']))
{
	header("Location: index.php");
	exit();
}

$serie = $_GET['serie'];
$protocolo = $_GET['prot'];
$local = $_GET['local'];

// echo "$serie - $protocolo";

if($local=='capital')
{
	$sql = "UPDATE ligacao SET data_devolucao=now(), lot_status=1 WHERE prot_lotacao=".$protocolo." and e_num_serie=".$serie;
	mysqli_query($conn,$sql);
	header("Location: lista_lotacao_cap.php?ok=1");
}else{
	$sql = "UPDATE ligacao_interior SET data_devolucao=now(), lot_status=1 WHERE prot_lotacao=".$protocolo." and i_num_serie=".$serie;
	mysqli_query($conn,$sql);
	header("Location: lista_lotacao_int.php?ok=1");
}

$sql = "UPDATE equipamento SET status=0 WHERE num_serie=".$serie;
mysqli_query($conn,$sql);

?>