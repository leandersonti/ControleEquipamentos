<?php require 'conn.php'; ?>
<?php
include_once('head.php');
include_once('topoLogo.php');
include_once('menu.php');
?>

<body>

	<div style="width:80%; margin:100px auto" class="panel panel-defalt">
		<!-- Mensagem de Erro ou Sucess-->
		<div class="alert-warning esconderUsu" role="alert" >
			
		</div><!--fim mensagem-->

		
		<form method="post" name="cadastrarUsuario">
			<div class="form-row">
				<div class="form-group col-6">
					<label>Nome</label>
					<input type="text" name="nome" placeholder="Nome" class="form-control trava">
					<div class="invalid-feedback">
						Informe o Nome do Usuário!
					</div>
				</div>
				<div class="form-group col-6">
					<label>Título</label>
					<input type="text" onkeydown="fMasc(this,mNUM)" name="titulo" placeholder="Título" maxlength="14" class="form-control trava">
					<div class="invalid-feedback">
						Informe o Título do Usuário!
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-6">
					<label>Senha</label>
					<div class="input-group">
						<input type="password" id="campSenha" name="senha" placeholder="Senha" class="form-control trava">
						
						<span id="cont-olho" class="input-group-addon">
							<btn id="bt-olho" onclick="exibeSenha('campSenha','bt-olho')" class="btn btn-secondary img-100">
							</btn>
						</span>
						<div class="invalid-feedback">
							Informe a Senha!
						</div>
					</div>
				</div>

				<div class="form-group col-6">
					<label>Confirmar Senha</label>
					<div class="input-group">
						<input type="password" id="campSenhaConfirm" name="senhaConfirm" placeholder="Confirmar Senha" class="form-control trava">
						<span id="cont-olho" class="input-group-addon">
							<btn id="bt-olho-confirm" onclick="exibeSenha('campSenhaConfirm','bt-olho-confirm')" class="btn btn-secondary img-100">
							</btn>
						</span>
						<div class="invalid-feedback">
							Confirme a Senha!
						</div>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-6">
					<label>Nível do Usuário</label>
					<select name="nivel" class="form-control trava">
						<option value="">Escolher...</option>
						<option value="1">Usuário</option>
						<option value="2">Administrador</option>
					</select>
					<div class="invalid-feedback">
						Selecione o Nível de Usuário!
					</div>
				</div>
			</div>

			<div class="form-row">
				<input type="submit" name="cad" value="Cadastrar" class="btn btn-primary">
			</div>
		</form>
	</div>
</body>

<script type="text/javascript">
	function exibeSenha(id,bt)
	{
		document.getElementById(id).type = 'text';
		document.getElementById(bt).style.backgroundImage = "url(imagens/icons/closed-eye.svg)";
		document.getElementById(bt).onclick = function()
		{
			escondeSenha(id,bt);
		}
	}
	function escondeSenha(id,bt)
	{
		document.getElementById(id).type = 'password';
		document.getElementById(bt).style.backgroundImage = "url(imagens/icons/view.svg)";
		document.getElementById(bt).onclick = function()
		{
			exibeSenha(id,bt);
		}
	}
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

</html>