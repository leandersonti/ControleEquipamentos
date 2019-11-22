<?php
require '../conn.php';
if($_POST['acao']=='loginUsuario')
{
	// sleep(1);
	$senha = sha1(md5($_POST['senha']));
	$dados = [$_POST['titulo'],$senha];
	$query = "SELECT COUNT(*) as qtdd FROM usuario WHERE titulo='".$dados[0]."' and senha = '".$dados[1]."'";
	$result = mysqli_query($conn,$query);
	if(mysqli_fetch_object($result)->qtdd==1)
	{
		echo $dados[0];
	}else{
		echo 2;
	}
}
?>