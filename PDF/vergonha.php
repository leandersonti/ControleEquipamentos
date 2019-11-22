<?php
// Este arquivo contem a minha vergonha.
// As consultas feitas nos relatórios exigiam um detalhamento atômico da consulta então não havia como criar uma consulta que gerasse um laço de repetição, AS CONSULTAS DEVEM SER FEITAS POR CADA TIPO DE EQUIPAMENTO.

// CONSULTAS PARA EQUIPAMENTOS

if($tabela=="tabela_equipamento.php")
{
	// Contagem de equipamentos por condição de entrada
	$sql = "SELECT COUNT(*) AS total FROM equipamento WHERE tipo='".$rs->tipo."' and condicao_entrada=0";
	$consulta = mysqli_query($conn,$sql);
	$novos = mysqli_fetch_object($consulta)->total;

	$sql = "SELECT COUNT(*) AS total FROM equipamento WHERE tipo='".$rs->tipo."' and condicao_entrada=1";
	$consulta = mysqli_query($conn,$sql);
	$doados = mysqli_fetch_object($consulta)->total;


	// contagem dos equipamentos NOVOS por status
	$sql = "SELECT COUNT(*) AS total FROM equipamento WHERE tipo='".$rs->tipo."' and condicao_entrada=0 and status=0";
	$consulta = mysqli_query($conn,$sql);
	$disponiveis = mysqli_fetch_object($consulta)->total;

	$sql = "SELECT COUNT(*) AS total FROM equipamento WHERE tipo='".$rs->tipo."' and condicao_entrada=0 and status=1";
	$consulta = mysqli_query($conn,$sql);
	$lotados = mysqli_fetch_object($consulta)->total;

	$sql = "SELECT COUNT(*) AS total FROM equipamento WHERE tipo='".$rs->tipo."' and condicao_entrada=0 and status=2";
	$consulta = mysqli_query($conn,$sql);
	$defeito = mysqli_fetch_object($consulta)->total;

	$sql = "SELECT COUNT(*) AS total FROM equipamento WHERE tipo='".$rs->tipo."' and condicao_entrada=0 and status=3";
	$consulta = mysqli_query($conn,$sql);
	$manu = mysqli_fetch_object($consulta)->total;

	$sql = "SELECT COUNT(*) AS total FROM equipamento WHERE tipo='".$rs->tipo."' and condicao_entrada=0 and status=4";
	$consulta = mysqli_query($conn,$sql);
	$perdido = mysqli_fetch_object($consulta)->total;


	// contagem dos equipamentos DOADOS por status
	$sql = "SELECT COUNT(*) AS total FROM equipamento WHERE tipo='".$rs->tipo."' and condicao_entrada=1 and status=0";
	$consulta = mysqli_query($conn,$sql);
	$disponiveis_d = mysqli_fetch_object($consulta)->total;

	$sql = "SELECT COUNT(*) AS total FROM equipamento WHERE tipo='".$rs->tipo."' and condicao_entrada=1 and status=1";
	$consulta = mysqli_query($conn,$sql);
	$lotados_d = mysqli_fetch_object($consulta)->total;

	$sql = "SELECT COUNT(*) AS total FROM equipamento WHERE tipo='".$rs->tipo."' and condicao_entrada=1 and status=2";
	$consulta = mysqli_query($conn,$sql);
	$defeito_d = mysqli_fetch_object($consulta)->total;

	$sql = "SELECT COUNT(*) AS total FROM equipamento WHERE tipo='".$rs->tipo."' and condicao_entrada=1 and status=3";
	$consulta = mysqli_query($conn,$sql);
	$manu_d = mysqli_fetch_object($consulta)->total;

	$sql = "SELECT COUNT(*) AS total FROM equipamento WHERE tipo='".$rs->tipo."' and condicao_entrada=1 and status=4";
	$consulta = mysqli_query($conn,$sql);
	$perdido_d = mysqli_fetch_object($consulta)->total;
}

// CONSULTAS PARA EMPRESTIMOS
if ($tabela=="tabela_emprestimo.php")
{
	$query = "SELECT COUNT(*) as total FROM equipamento,ligacao,e_lotado WHERE num_serie=e_num_serie and protocolo=prot_lotacao and lot_status=0";
	$r = mysqli_query($conn,$query);
	$todos_emp = mysqli_fetch_object($r)->total;

	$query = "SELECT COUNT(*) as total FROM equipamento,ligacao_interior, e_lotado_interior WHERE num_serie=i_num_serie and protocolo=prot_lotacao and lot_status=0";
	$r = mysqli_query($conn,$query);
	$todos_emp_i = mysqli_fetch_object($r)->total;
}