<?php
require 'conn.php'; 
include_once("head.php");
include_once('topoLogo.php');
include_once('menu.php');
?>

<?php
function getCabecalho($values)
{
	$ret = "";
	$index = explode(", ", $values);
	$tam = count($index);
	// echo "$tam <br>";
	// echo "$values <br>";
	for($i=0;$i<$tam;$i++)
	{
		$case = str_replace(" ", "", $index[$i]);

		switch ($case)
		{
			case 'tipo':
				if($ret=="") $ret .= "Equipamento";
				else $ret .= ";Equipamento";
			break;
			
			case 'status':
				if($ret=="") $ret .= "Status";
				else $ret .= ";Status";
			break;

			case 'condicao_entrada':
				if($ret=="") $ret .= "Condição de Adesão";
				else $ret .= ";Condição de Adesão";
			break;

			default:
				# code...
				break;
		}
	}
	return $ret;
}
?>

<?php
$grupo = "";
$filtragem = "";
$tab = "";
if (isset($_POST['submit']))
{
	if($_POST['selet']=="equipamento")
	{

		$i=0;
		if(isset($_POST['checkTipo']))
		{
			if($i==0) $grupo .= " tipo";
			else $grupo .= ", tipo";
			$i++;
		}
		if(isset($_POST['checkStatus']))
		{
			if($i==0) $grupo .= " status";
			else $grupo .= ", status";
			$i++;
		}
		if(isset($_POST['checkCondicao']))
		{
			if($i==0) $grupo .= " condicao_entrada";
			else $grupo .= ", condicao_entrada";
			$i++;
		}

	}else{
		$i=0;
		$pre = " and";
		$filtro = "";

		if($_POST['tipoFiltro']!="")
		{
			$filtro .= " tipo='".$_POST['tipoFiltro']."'";
			$i++;
		}
		if($_POST['responsavel']!="")
		{
			if($i>0) $filtro .= " and responsavel='".$_POST['responsavel']."'";
			else $filtro .= " responsavel='".$_POST['responsavel']."'";
			$i++;
		}
		if($_POST['lot_status']!="")
		{
			if($i>0) $filtro .= " and lot_status=".$_POST['lot_status'];
			else $filtro .= " lot_status=".$_POST['lot_status'];
			$i++;
		}
		if($_POST['dt_inicio']!="" && $_POST['dt_fim']!="")
		{
			echo $_POST['dt_fim']." ".$_POST['dt_inicio']."<br>";
			$dt = explode("/", $_POST['dt_inicio']);
			$dt_inicio = $dt[2]."-".$dt[1]."-".$dt[0];

			$dt = explode("/", $_POST['dt_fim']);
			$dt_fim = $dt[2]."-".$dt[1]."-".$dt[0];

			if($i>0) $filtro .= " and data_lotacao BETWEEN '".$dt_inicio."' and '".$dt_fim."'";
			else $filtro .= " data_lotacao BETWEEN '".$dt_inicio."' and '".$dt_fim."'";
			$i++;
		}
		if($i>0) $filtragem = $pre.$filtro;
	}

	if($_POST['selet']=="lotacao")
	{
		if($_POST['destino_emprestimo']=="Interior")
			$tab = "equipamento, ligacao_interior, e_lotado_interior WHERE num_serie=i_num_serie and protocolo=prot_lotacao";
		else
			$tab = "equipamento, ligacao, e_lotado WHERE num_serie=e_num_serie and protocolo=prot_lotacao";
	}
	else{
		$tab = $_POST['selet'];
	}

	// echo $grupo;
}
?>

<body>
	<div style="width:80%; margin:100px auto" class="panel panel-defalt">
		<form method="post">
			<div class="form-group">
				<label>Selecionar:</label>
				<br>
				<label for="seletEquipamento">Equipamento</label>
				<input id="seletEquipamento" type="radio" name="selet" value="equipamento" onclick="mudaForm(0)" checked>

				<label for="seletEmprestimo">Emprestimo</label>
				<input id="seletEmprestimo" type="radio" name="selet" value="lotacao" onclick="mudaForm(1)">
			</div>

			<label>Contar por:</label>
			<div class="form-grid">
				<div class="form-group">
					<input id="check1" type="checkbox" name="checkTipo" value="tipo" checked onclick="forca()">
					<label for="check1">Equipamento</label>
					<br>
					<input id="check2" type="checkbox" name="checkStatus" value="status" checked>
					<label for="check2">Status</label>
					<br>
					<input id="check3" type="checkbox" name="checkCondicao" value="condicao_entrada" checked>
					<label for="check3">Condição de Adesão</label>
				</div>
			</div>
			<div class="form-grid">
				<label>Filtrar por:</label>
				<br>
				<div class="form-group col-md-12 teamEmprestimo">
					<label class='labelzinha'>Equipamento</label>
					<br>
					<select id="tipo" class="form-control" name="tipoFiltro">
						<option value="">Escolher...</option>
						<!-- <option value="all">Tudo</option> -->
						<?php
						$sql = "SELECT tipo FROM equipamento GROUP BY tipo";
						$consulta = mysqli_query($conn,$sql);
						while ($rs = mysqli_fetch_object($consulta))
						{
							?>
							<option value="<?php echo $rs->tipo; ?>">
								<?php echo $rs->tipo; ?>
							</option>
							<?php
						}
						?>
					</select>
				</div>

				<div class="form-group col-md-12 teamEmprestimo">
					<label class='labelzinha'>Responsável</label>
					<br>
					<select name="responsavel" class="form-control">
						<option value="">Escolher...</option>
						<?php
						$sql = "SELECT * FROM e_lotado GROUP BY responsavel";
						$consulta = mysqli_query($conn,$sql);
						while ($rs = mysqli_fetch_object($consulta))
						{
							?>
							<option value="<?php echo $rs->responsavel; ?>"><?php echo $rs->responsavel; ?></option>
							<?php
						}

						$sql = "SELECT * FROM e_lotado_interior GROUP BY responsavel";
						$consulta = mysqli_query($conn,$sql);
						while ($rs = mysqli_fetch_object($consulta))
						{
							?>
							<option value="<?php echo $rs->responsavel; ?>"><?php echo $rs->responsavel; ?></option>
							<?php
						}
						?>
					</select>
				</div>

				<div class="form-group col-md-12 teamEmprestimo">
					<label class='labelzinha'>Situação do Emprestimo</label>
					<br>
					<select name="lot_status" class="form-control">
						<option value="">Escolher...</option>
						<option value="0">Ativo</option>
						<option value="1">Devolvido</option>
					</select>
				</div>

				<div class="form-group col-md-12 teamEmprestimo">
					<label class='labelzinha'>Local do Empréstimo</label>
					<br>
					<select name="destino_emprestimo" class="form-control">
						<option value="">Escolher..</option>
						<option value="Capital">Capital</option>
						<option value="Interior">Interior</option>
					</select>
				</div>

				<div class="form-group col-md-12 teamEmprestimo">
					<label class='labelzinha'>Período</label>
					<br>
					<input type="text" name="dt_inicio" onkeydown="fMasc(this,mDATE)" maxlength="10" class="form-control" placeholder="Data Inicial dd/mm/aaaa">
				</div>

				<div class="form-group col-md-12 teamEmprestimo">
					<input id="dt_fim" type="text" name="dt_fim" onkeydown="fMasc(this,mDATE)" maxlength="10" class="form-control" placeholder="Data Final dd/mm/aaaa">
				</div>

			</div>
			<input type="submit" name="submit" class="btn btn-primary">
		</form>

		<?php
		if(isset($_POST['submit']))
		{
			$itens_cabecalho = explode(";",getCabecalho($grupo));
			$itens = $itens_cabecalho;
			$tam = count($itens);

			if($_POST['selet']=="equipamento")
				$query = "SELECT ".$grupo.", COUNT(*) as qtdd FROM ".$tab." GROUP BY".$grupo;
			else
				$query = "SELECT *,COUNT(*) as qtdd FROM ".$tab.$filtragem;
			$result = mysqli_query($conn,$query);
			while ($rs = mysqli_fetch_array($result))
			{
				?>
				<div class="caixaInfo">
					<div class="cabecaInfo">
						<label class="tituloInfo"><?php echo $rs[0]; ?></label>
						<label class="qtddInfo"><?php echo $rs[1]; ?></label>
					</div>
				</div>
				<?php
			}
		}
		?>

		<!-- <div id="tabelinha">
			<div class="linha-cabecalho">
				<?php
				if(isset($_POST['submit']))
			{
				$itens_cabecalho = explode(";",getCabecalho($grupo));

				for($i=0;$i<count($itens_cabecalho);$i++)
				{
					?>
					<div class="coluna">
						<?php echo $itens_cabecalho[$i]; ?>
					</div>
					<?php
				}
				?>
				<div class="coluna">Quantidade</div>
			</div>

			<?php
			
				$itens = $itens_cabecalho;
				$tam = count($itens);
				if($_POST['selet']=="equipamento")
					$query = "SELECT ".$grupo.", COUNT(*) as qtdd FROM ".$tab." GROUP BY".$grupo;
				else
					$query = "SELECT *,COUNT(*) as qtdd FROM ".$tab.$filtragem;
				$result = mysqli_query($conn,$query);
				while ($rs = mysqli_fetch_array($result))
				{

					?>
					<div class="linha">
						<?php 
						for($i=0;$i<=$tam;$i++)
						{
							$dado = $rs[$i];
							// Verifica o status do equipamento
							if($i!=$tam && $itens[$i]=="Status")
							{
								$s = $dado;
								switch ($s)
								{
									case 0:
									$dado = "Disponivel";
									break;

									case 1:
									$dado = "Alocado";
									break;

									case 2:
									$dado = "Com defeito";
									break;

									case 3:
									$dado = "Em manutenção";
									break;

									case 4:
									$dado = "Cedido ao interior";
									break;

									default:
									break;
								}
							}

							// Verifica a condição de adesão do equipamento
							if($i!=$tam && $itens[$i]=="Condição de Adesão")
							{
								$s = $dado;
								switch ($s)
								{
									case 0:
									$dado = "Novo";
									break;

									case 1:
									$dado = "Doado";
									break;

									default:
									break;
								}
							}
							?>


							<div class="coluna">
								<?php echo $dado." "; ?>
							</div>


							<?php
						}
						?>
					</div>
					<?php
				}
			}
			?>
		</div> -->
	</div>

	<script type="text/javascript">
		function forca()
		{
			document.getElementById('check1').checked="true";
		}
		function mudaForm(i)
		{
			if(i==0)
			{
				var eq = document.getElementsByClassName('teamEmprestimo');
				for(cont=0;cont<eq.length;cont++)
				{
					eq[cont].style.webkitAnimationName = "desaparece";
					eq[cont].style.webkitAnimationDuration = "3s";
					eq[cont].style.display = "none";
				}

				eq = document.getElementsByClassName('teamEquipamento');
				for(cont=0;cont<eq.length;cont++)
				{
					eq[cont].style.display = "block";
					eq[cont].style.opacity = "0";
					eq[cont].style.webkitAnimationName = "aparece";
					eq[cont].style.webkitAnimationDuration = "3s";
					eq[cont].style.opacity = "1";
				}
			}else{
				var eq = document.getElementsByClassName('teamEquipamento');
				for(cont=0;cont<eq.length;cont++)
				{
					eq[cont].style.opacity = "1";
					eq[cont].style.webkitAnimationName = "desaparece";
					eq[cont].style.webkitAnimationDuration = "3s";
					eq[cont].style.opacity = "0"
				}

				eq = document.getElementsByClassName('teamEmprestimo');
				for(cont=0;cont<eq.length;cont++)
				{
					eq[cont].style.display = "block";
					eq[cont].style.opacity = "0";
					eq[cont].style.webkitAnimationName = "aparece";
					eq[cont].style.webkitAnimationDuration = "3s";
					eq[cont].style.opacity = "1";
				}

				eq = document.getElementsByClassName('teamEquipamento');
				for(cont=0;cont<eq.length;cont++)
					eq[cont].style.display = "none";
			}
		}
	</script>

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
		function mDATE(date)
		{
			date=date.replace(/\D/g,"");
			date=date.replace(/(\d{2})(\d)/,"$1/$2");
			date=date.replace(/(\d{2})(\d)/,"$1/$2");
			return date;
		}
	</script>

</body>