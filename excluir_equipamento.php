<?php

session_start();
if(!isset($_SESSION['titulo']))
{
	header("Location: index.php");
	exit();
}

require 'conn.php';

$serie = $_GET['serie'];
// echo $serie."<br>";
$sql = "DELETE FROM equipamento WHERE num_serie=".$serie;
// echo $sql."<br>";
mysqli_query($conn,$sql);
header("Location: lista_equipamento.php?excluido=1");
?>