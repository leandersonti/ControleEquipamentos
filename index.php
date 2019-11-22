<?php 
require 'conn.php'; 
include_once('head.php');
include_once('topoLogo.php');
// include_once('menu.php');
session_start();

?>

<script type="text/javascript" src="js/scriptLogin.js" async></script>
<body id="body">

<h1>TESTANDO NOVA LINHA POR OUTRA CONTA USANDO GIT</H1>
	<div style="width:max-content; padding:40px;margin:100px auto" class="panel panel-defalt">
		<form method="post" name="loginUsuario">
			<label class="title">
				<img src="imagens/Tre.png" id="brasao">
				Área restrita
			</label>
			<div class="esconderUsu"></div>
			<div class="form-group form-row">
				<input type="text" name="titulo" class="form-control" placeholder="Título de Eleitor" onkeydown="fMasc(this,mNUM)" minlength="14" maxlength="14" required>
			</div>
			<div class="form-group form-row">
				<input type="password" name="senha" class="form-control" placeholder="Senha" required>
			</div>
			<div class="form-row">
				<input type="submit" name="login" value="Login" class="btn btn-primary form-control">
			</div>
		</form>
	</div>
</body>

<script type="text/javascript"> 
	function fMasc(objeto,mascara)
	{
		obj=objeto;
		masc=mascara;
		setTimeout("fMascEx()",1);
	}
	function fMascEx()
	{
		obj.value=masc(obj.value);
	}
	function mNUM(num)
	{
		num=num.replace(/\D/g,"");
		num=num.replace(/(\d{4})(\d)/,"$1 $2");
		num=num.replace(/(\d{4})(\d)/,"$1 $2");
		// num=num.replace(/(\d{4})(\d)/,"$1 $2");
		return num;
	}
</script>

</body>
</html>
