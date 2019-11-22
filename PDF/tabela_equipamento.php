<?php
$pagina .= "
<table cellpadding='0' cellspacing='0'>
	<tr class='row-eqp'>
		<td colspan='3'>".$rs->tipo."</td>
		<td>Total: ".$rs->total."</td>
	</tr>

	<tr class='row-cond' style='border-top: 1px solid black;'>
		<td colspan='2' style='border-right: 1px solid black'>Novos: ".$novos."</td>
		<td colspan='2'>Doados: ".$doados."</td>
	</tr>

	<tr>
		<td>Disponiveis</td>
		<td style='border-right: 1px solid black'>Quantidade: ".$disponiveis."</td>
		<td>Disponiveis</td>
		<td>Quantidade: ".$disponiveis_d."</td>
	</tr>

	<tr>
		<td>Alocados</td>
		<td style='border-right: 1px solid black'>Quantidade: ".$lotados."</td>
		<td>Alocados</td>
		<td>Quantidade: ".$lotados_d."</td>
	</tr>

	<tr>
		<td>Defeituosos</td>
		<td style='border-right: 1px solid black'>Quantidade: ".$defeito."</td>
		<td>Defeituosos</td>
		<td>Quantidade: ".$defeito_d."</td>
	</tr>

	<tr>
		<td>Em manutenção</td>
		<td style='border-right: 1px solid black'>Quantidade: ".$manu."</td>
		<td>Em manutenção</td>
		<td>Quantidade: ".$manu_d."</td>
	</tr>

	<tr>
		<td>Cedidos ao Interior</td>
		<td style='border-right: 1px solid black'>Quantidade: ".$perdido."</td>
		<td>Cedidos ao Interior</td>
		<td>Quantidade: ".$perdido_d."</td>
	</tr>
</table>
<br>";
?>