<?php
require 'conn.php';
echo $_GET['titulo'];
session_start();

date_default_timezone_set('America/Manaus');

$sql = "SELECT * FROM usuario WHERE titulo='".$_GET['titulo']."'";
$consulta = mysqli_query($conn,$sql);
$_SESSION['titulo'] = $_GET['titulo'];
$_SESSION['momento_login'] = date('H:i:s');
$_SESSION['data'] = date("d/m/Y");
$_SESSION['nivel'] = mysqli_fetch_object($consulta)->nivel;
header('Location: lista_equipamento.php');
exit();
?>