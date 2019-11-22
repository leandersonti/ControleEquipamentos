<?php
$pagina .= "
<table cellpadding='0' cellspacing='0'>
	<tr class='row-eqp'>
		<td>Capital</td>
		<td>Total: ".$todos_emp."</td>
	</tr>";
$query = "SELECT dpto,COUNT(*) AS quantidade FROM equipamento, ligacao, e_lotado WHERE  num_serie=e_num_serie and protocolo=prot_lotacao and lot_status=0 GROUP BY dpto";
$result = mysqli_query($conn,$query);
while ($rs = mysqli_fetch_object($result))
{
$pagina .="
	<tr class='centro'>
		<td>".$rs->dpto."</td>
		<td>Emprestimos: ".$rs->quantidade."</td>
	</tr>";
}
$pagina .= "
</table>
<br>";

$pagina .= "
<table cellpadding='0' cellspacing='0'>
	<tr class='row-eqp'>
		<td>Interior</td>
		<td>Total: ".$todos_emp_i."</td>
	</tr>";
$query = "SELECT unidade,COUNT(*) AS quantidade FROM equipamento, ligacao_interior, e_lotado_interior WHERE  num_serie=i_num_serie and protocolo=prot_lotacao and lot_status=0 GROUP BY unidade;";
$result = mysqli_query($conn,$query);
while ($rs = mysqli_fetch_object($result))
{
$pagina .="
	<tr class='centro'>
		<td>".$rs->unidade."</td>
		<td>Emprestimos: ".$rs->quantidade."</td>
	</tr>";
}
$pagina .= "
</table>
";

?>