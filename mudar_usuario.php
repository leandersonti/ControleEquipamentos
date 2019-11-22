<?php require 'conn.php'; ?>
<?php
include_once('head.php');
include_once('topoLogo.php');
include_once('menu.php');
?>

<?php
$query = "SELECT COUNT(*) as total FROM usuario";
$result = mysqli_query($conn,$query);
$total = mysqli_fetch_object($result)->total;
?>

<body>
	<div style="width:80%; margin:100px auto" class="panel panel-defalt">

		<div id="quantitativo">
			<?php echo "Total de usuários: ".$total; ?>
		</div>
		<div class="tabelinha">
			<div class="linha-cabecalho">
				<div class="coluna">Nome</div>
				<div class="coluna">Título</div>
				<div class="coluna">Nível</div>
				<div class="coluna_icone centrar">Editar</div>
				<div class="coluna_icone centrar">Excluir</div>
			</div>

			<?php
			$query = "SELECT * FROM usuario ORDER BY nivel DESC";
			$result = mysqli_query($conn,$query);
			$i=0;
			$cor=0;
			while($fo = mysqli_fetch_object($result))
			{
				$nivel = "";
				switch ($fo->nivel)
				{
					case '1':
						$nivel = "Usuário";
						break;
					
					case '2':
						$nivel = "Administrador";
						break;

					default:
						# code...
						break;
				}

				if($cor==0)
					$cor = 1;
				else
					$cor = 0;
				?>

				<div class="linha topousu cor<?php echo $cor; ?>">
					<div class="coluna"><?php echo $fo->nome; ?></div>
					<div id="titulo<?php echo $i ?>" class="coluna"><?php echo $fo->titulo; ?></div>
					<div class="coluna"><?php echo $nivel; ?></div>
					<!--edição de usuarios-->
					<div id="<?php echo $fo->titulo; ?>" class="colun_icone link editarUsu" data-toggle="modal" data-target="#mudarusuario">
						<img src="imagens/icons/edit.svg" class="icon">
					</div>
					<!--exclusao de usuarios-->
					<div id="<?php echo $fo->titulo; ?>" class="coluna_icone link excluirUsu" data-toggle="modal" data-target="#modalexcluirUsuario">
						<img src="imagens/icons/delete.svg" class="icon">
					</div>
				</div>


					<!-- modal editar usuario--->
				<div class="modal fade" id="mudarusuario" tabindex="-1" role="dialog" aria-labelledby="mudarusuario" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="TituloModalCentralizado">Editar</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<form name="editusuario" method="post" class="was-validated">
								<div class="modal-body">
										<div class="alert-warning esconder" role="alert" >
										
										</div>

									<div class="form-row">
										<div class="form-group col-6">
											<label>Nome</label>
											<input type="text" name="nome" placeholder="Nome" class="form-control" required>
											<div class="invalid-feedback">
												Informe o Nome de Usuário!
											</div>
										</div>
										<div class="form-group col-6">
											<label>Título</label>
											<input type="text" name="titulo" placeholder="Titulo" class="form-control" onkeydown="fMasc(this,mNUM)" maxlength="14" required>
											<div class="invalid-feedback">
												Informe o Título do Usuário!
											</div>
										</div>
									</div>

									<div class="form-row">
										<div class="form-group col-6">
											<label>Senha</label>
											<input type="password" name="senha" placeholder="Senha" class="form-control">
										</div>
										<div class="form-group col-6">
											<label>Nível do Usuário</label>
											<select name="nivel" class="form-control" required>
												<option value="">Escolher...</option>
												<option value="1">Usuário</option>
												<option value="2">Administrador</option>
											</select>
											<div class="invalid-feedback">
												Selecione o Nível do Usuário!
											</div>
										</div>
									</div>

			
								
									<div class="modal-footer">
										<div class="form-row">
											<input type="submit" name="cad" value="Atualizar" class="btn btn-primary">
										</div>

									</div>

								</div>
							</form>
						
						</div>
					</div>
				</div><!--fim modal Editar-->


				<!--Inicio Modal excluir -->
					
						
				<div class="modal fade" tabindex="-1" role="dialog" id="modalexcluirUsuario" aria-labelledby="mySmallModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered modal-sm">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="TituloModalCentralizado">Excluir</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
							<div class="alert alert-primary esconderex" role="alert" >
							Confirmar Exclusão?
							</div>
								
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-primary" value="1">Sim</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
								
							</div>
						
						</div>
					</div>
				</div><!--fim  Modal excluir -->

				<?php

				$i++;
			}
			?>

		</div>
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

</html>