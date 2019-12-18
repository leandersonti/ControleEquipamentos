<?php
// pegamos o tempo atual em que estamos:
date_default_timezone_set('America/Manaus');
$agora = date('H:i:s');
$dt_atual = date("d/m/Y");

// converter a hora atual e a hora de login em inteiros
$segundos = intval(str_replace(":", "", $agora));
$log = intval(str_replace(":", "", $_SESSION['momento_login']));

// subtraimos o tempo em que o usuário entrou pela ultima vez, do tempo atual "a diferença é em segundos"
$tempo = $segundos-$log;

//definimos os segundos que o usuário deverá ficar logado sem atividade
define('TEMPO_LOGADO',5000);

if($tempo > TEMPO_LOGADO || $_SESSION['data']<$dt_atual) {
	header("Location: logout.php?tempo=1");
} else {
	$_SESSION['momento_login'] = $agora;
}
?>