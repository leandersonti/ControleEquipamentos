<?php

session_start();

$usuario = $_POST["usuario"];
$senha = $_POST["senha"];

if (isset($_POST['enviar'])){

$home = header("location: ../relatorio.php");

if ($usuario == "019768782283" && $senha == "fuila123456"){
	
	$_SESSION['usuario'] = "Eric Sales";
	$_SESSION['login'] = $usuario;
	$_SESSION['senha'] = $senha;
	$_SESSION["tempo"] = time()+3600;
    $home;
}elseif($usuario == "036153922232" && $senha == "mhos2301998"){
	
	$_SESSION['usuario'] = "Marcelo Henrique";
	$_SESSION['login'] = $usuario;
	$_SESSION['senha'] = $senha;
	$_SESSION["tempo"] = time()+3600;
	$home;

}elseif($usuario == "012181462232" && $senha == "glc2301842"){
	
	$_SESSION['usuario'] = "Gracilene Lima Cavalcante";
	$_SESSION['login'] = $usuario;
	$_SESSION['senha'] = $senha;
	$_SESSION["tempo"] = time()+3600;
	$home;

}elseif($usuario == "adm" && $senha == "123"){

	$_SESSION['usuario'] = "Leanderson Silva";
	$_SESSION['login'] = $usuario;
	$_SESSION['senha'] = $senha;
	$_SESSION["tempo"] = time()+3600;
	$home;;

}elseif($usuario == "016373312267" && $senha == "csfy2301848"){

	$_SESSION['usuario'] = "Celso Satoshi";
	$_SESSION['login'] = $usuario;
	$_SESSION['senha'] = $senha;
	$_SESSION["tempo"] = time()+3600;
	$home;;

}elseif($usuario == "018701372208" && $senha == "etnm2301985"){

	$_SESSION['usuario'] = "Eucicleia";
	$_SESSION['login'] = $usuario;
	$_SESSION['senha'] = $senha;
	$_SESSION["tempo"] = time()+3600;
	$home;;

}elseif($usuario == "039336502267" && $senha == "rica2267"){

	$_SESSION['usuario'] = "Ricardo Mendonça";
	$_SESSION['login'] = $usuario;
	$_SESSION['senha'] = $senha;
	$_SESSION["tempo"] = time()+3600;
	$home;;

}elseif($usuario == "010595792216" && $senha == "jbm2301821"){

	$_SESSION['usuario'] = "Desconhecido";
	$_SESSION['login'] = $usuario;
	$_SESSION['senha'] = $senha;
	$_SESSION["tempo"] = time()+3600;
	$home;;

}elseif($usuario == "011032862232" && $senha == "12345678"){

	$_SESSION['usuario'] = "Ricardo";
	$_SESSION['login'] = $usuario;
	$_SESSION['senha'] = $senha;
	$_SESSION["tempo"] = time()+3600;
	$home;

}else{
	$_SESSION["erro"] = "Usuário ou senha inválidos";
    header("location: ../index.php");
}

}else{
	header("location: ../index.php");
}

?>