<?php

if (isset($_GET['tempo']))
{
	echo "<script>alert('Tempo de inatividade excedido. Realize login novamente!')</script>";
}

session_start();
unset($_SESSION);
session_destroy();
header('Location: index.php');
exit();

?>