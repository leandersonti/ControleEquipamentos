<?php require 'conn.php'; ?>

<?php

$limite = 5; #!!!!ATENÇÃO!!! esta variável controla a quantidade limite que aparecerá em cada página

function data($date)
{
	return date("d/m/Y", strtotime($date));
}

?>

<!-- Inputs do tipo hidden para controlar a paginação feita no JavaScript -->
<?php
$sql = "SELECT COUNT(*) AS qtdd FROM equipamento, e_lotado_interior, ligacao_interior WHERE num_serie=i_num_serie and prot_lotacao=protocolo and lot_status=0";

$consulta = mysqli_query($conn,$sql);
$rs = mysqli_fetch_object($consulta);
$maximo = ceil($rs->qtdd/$limite);
?>
<input type="hidden" id="fecharPagina" value="0">
<input type="hidden" id="inputEscondido" value="1">
<input type="hidden" id="totalPaginas" value="<?php echo $maximo ?>">

<div id="tabelinha" class="table">
	<div class="linha-cabecalho">
		<div class="coluna centrar">Protocolo</div>
		<div class="coluna">Número de Série</div>
		<div class="coluna">Equipamento</div>
		<div class="coluna centrar">Unidade</div>
		<div class="coluna centrar">Responsável</div>
		<div class="coluna centrar">Data de lotação</div>
		<div class="coluna_icone centrar">Devolver</div>
	</div>
	<?php
	$query = "";
	// echo "interior";
	if (isset($_POST['filtro']))
	{
		$query = "SELECT * FROM ligacao_interior, e_lotado_interior, equipamento WHERE i_num_serie=num_serie and prot_lotacao=protocolo and lot_status=0";
		if($_POST['equipamento']!="")
		{
			$query .= " and tipo = '".$_POST['equipamento']."'";
		}
		if ($_POST['responsavel']!="")
		{
			$query .= " and responsavel = '".$_POST['responsavel']."'";
		}
		if ($_POST['dpto']!="")
		{
			$query .= " and unidade='".$_POST['dpto']."'";
		}
		if ($_POST['dpto']=="" && $_POST['responsavel']=="" && $_POST['equipamento']=="")
		{
			$query = "SELECT * FROM ligacao_interior, e_lotado_interior, equipamento  WHERE num_serie = i_num_serie and prot_lotacao = protocolo and lot_status=0";
		}
		$query .=  " ORDER BY data_lotacao";
	}else{
		$query = "SELECT * FROM ligacao_interior, e_lotado_interior, equipamento WHERE num_serie = i_num_serie and prot_lotacao = protocolo and lot_status=0 ORDER BY data_lotacao";
	}
	// echo $query;
	$result = mysqli_query($conn,$query);
	$i=0; # Esse controlador gera ids na tabela para capturar o número de protocolo e número de série via JS //Cley
	$pg = 1;
	$pganterior = 0;
	while ($fo = mysqli_fetch_object($result))
	{
		if($i%2==0)
			$cor = 1;
		else
			$cor = 0;
		if ($pganterior!=$pg)
		{
			echo "<div id='pg".$pg."' class='pagina'>";
			$pganterior = $pg;
		}
		?>
		
		<div class="linha cor<?php echo $cor; ?>">
			<div id="<?php echo $i; ?>" class="coluna">
				<?php echo $fo->prot_lotacao; ?>
			</div>
			<div id="s<?php echo $i ?>" class="coluna">
				<?php echo $fo->i_num_serie; ?>
			</div>
			<div class="coluna">
				<?php echo $fo->tipo; ?>
			</div>
			<div class="coluna">
				<?php echo $fo->unidade; ?>
			</div>
			<div class="coluna">
				<?php echo $fo->responsavel; ?>
			</div>
			<div class="coluna">
				<?php echo data($fo->data_lotacao); ?>
			</div>
			<div class="coluna_icone link" onclick="devolver('<?php echo $i; ?>')">
				<img src='imagens/icons/seta_que_vem.svg' class='icon'>
			</div>
		</div>
		<?php
		$i++;
		if($i%$limite==0)
		{
			echo "</div>";
			$pg++;
		}
	}
	?>
</div>

<div class="paginacao">
	<div onclick="back()" class="btn btn-primary">Anterior</div>
	<div class="botoes">
		<?php
		for ($i=1; $i <= $pganterior; $i++)
		{
			echo "<div onclick='paginacao(".$i.")' id='btn".$i."' class='btn btn-primary'>".$i."</div>";
		}
		?>
	</div>
	<div onclick="next()" class="btn btn-primary">Próximo</div>
</div>



<script async type="text/javascript">
	function devolver(id,local)
	{
		let prot = document.getElementById(id).innerText;
		let serie = document.getElementById('s'+id).innerText;
		window.location.href = "devolver.php?prot="+prot+"&serie="+serie+"&local=interior";

		// console.log('protocolo: '+prot+" serie: "+serie);
	}
</script>