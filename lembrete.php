<?php
require_once 'conn.php';
include_once('head.php');
include_once('topoLogo.php');
include_once('menu.php');

$dt_atual = date("Y-m-d");
?>
<link rel="stylesheet" type="text/css" href="css/lembretes.css">
<body>
	<div class="container">
		<div class="capital">

			<h3 class="titulo">Empréstimos da Capital</h3>
			
			<?php
			$query = "SELECT * FROM e_lotado,ligacao WHERE prot_lotacao=protocolo and lot_status=0 and prazo ORDER BY prazo";
			$result = mysqli_query($conn,$query);
			while($fetch = mysqli_fetch_object($result))
			{
				$dt = explode("-", $dt_atual);
				$dia = intval($dt[2]);
				$mes = intval($dt[1]);

				$dt_venc = explode("-", $fetch->prazo);
				$dia_venc = intval($dt_venc[2]);
				$mes_venc = intval($dt_venc[1]);


				$dpto = $fetch->dpto;
				$protocolo = $fetch->protocolo;
				$responsavel = $fetch->responsavel;

				if($mes==$mes_venc)
				{
					$falta = $dia_venc - $dia;
					if ($falta == 0)
					{
						$mensagem = "O empréstimo de protocolo $protocolo feito para $responsavel no departamento $dpto expira hoje e os equipamentos do empréstimo devem ser devolvidos";
						$cor = "laranja";
					}
					else if($falta == 1)
					{
						$mensagem = "O empréstimo de protocolo $protocolo feito para $responsavel no departamento $dpto expira em 1 dia e os equipamentos do empréstimo devem ser devolvidos";
						$cor = "verde";
					}
					else if($falta < 0)
					{
						$mensagem = "O empréstimo de protocolo $protocolo feito para $responsavel no departamento $dpto expirou a ".($falta * -1)." dias. Lembre o responsável do setor para devolvê-los";
						$cor = "vermelho";

						if($falta == -1) $mensagem = "O empréstimo de protocolo $protocolo feito para $responsavel no departamento $dpto expirou a ".($falta * -1)." dia. Lembre o responsável do setor para devolvê-los";
					}
					else if ($falta <= 7)
					{
						$mensagem = "O empréstimo de protocolo $protocolo feito para $responsavel no departamento $dpto expira em $falta dias e os equipamentos do empréstimo devem ser devolvidos";
						$cor = "verde";
					}

				}
				?>

				<div class="mensagem <?php echo $cor ?>">
					<span><?php echo $mensagem; ?></span>
				</div>

				<?php
			}
			?>
		</div>

		<div class="interior">
			
			<h3 class="titulo">Empréstimos do Interior</h3>
			
			<?php
			$query = "SELECT * FROM e_lotado_interior,ligacao_interior WHERE prot_lotacao=protocolo and lot_status=0 and prazo ORDER BY prazo";
			$result = mysqli_query($conn,$query);
			while($fetch = mysqli_fetch_object($result))
			{
				$dt = explode("-", $dt_atual);
				$dia = intval($dt[2]);
				$mes = intval($dt[1]);

				$dt_venc = explode("-", $fetch->prazo);
				$dia_venc = intval($dt_venc[2]);
				$mes_venc = intval($dt_venc[1]);


				$unidade = $fetch->unidade;
				$protocolo = $fetch->protocolo;
				$responsavel = $fetch->responsavel;

				if($mes==$mes_venc)
				{
					$falta = $dia_venc - $dia;
					if ($falta == 0)
					{
						$mensagem = "O empréstimo de protocolo $protocolo feito para $responsavel no departamento $unidade expira hoje e os equipamentos do empréstimo devem ser devolvidos";
						$cor = "laranja";
					}
					else if($falta == 1)
					{
						$mensagem = "O empréstimo de protocolo $protocolo feito para $responsavel no departamento $unidade expira em 1 dia e os equipamentos do empréstimo devem ser devolvidos";
						$cor = "verde";
					}
					else if($falta < 0)
					{
						$mensagem = "O empréstimo de protocolo $protocolo feito para $responsavel no departamento $unidade expirou a ".($falta * -1)." dias. Lembre o responsável do setor para devolvê-los";
						$cor = "vermelho";

						if($falta == -1) $mensagem = "O empréstimo de protocolo $protocolo feito para $responsavel no departamento $unidade expirou a ".($falta * -1)." dia. Lembre o responsável do setor para devolvê-los";
					}
					else if ($falta <= 7)
					{
						$mensagem = "O empréstimo de protocolo $protocolo feito para $responsavel no departamento $unidade expira em $falta dias e os equipamentos do empréstimo devem ser devolvidos";
						$cor = "verde";
					}

				}
				?>

				<div class="mensagem <?php echo $cor ?>">
					<span><?php echo $mensagem; ?></span>
				</div>

				<?php
			}
			?>
		</div>
	</div>
</body>

</html>