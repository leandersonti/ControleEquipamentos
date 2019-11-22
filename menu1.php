<?php

session_start();
if(!isset($_SESSION['titulo']))
{
	header("Location: index.php");
	exit();
}

?>

<div>

	<nav class="nav">
		<ul>

			<li><a href="cad_equipamento.php">Cadastrar</a>
			</li>	
			<li><a href="lista_equipamento.php">Equipamentos</a>
			</li>
			<li class="drop3"><a href="#">Empréstimos</a>
				<ul class="dropdown3">
					<li><a href="lista_lotacao_cap.php">Capital</a></li>
					<li><a href="lista_lotacao_int.php">Interior</a></li>
				</ul>
			</li>
			<li><a href="relatorio.php">Relatório</a></li>
		</ul>
		<div class="bt-logoff" onclick="logout()">
			<img src="imagens/icons/bt-logoff.svg" class="img-100">
		</div>
	</nav>

	<script>
		$(".drop1")
		.mouseover(function() {
			$(".dropdown1").show(100);
		});
		$(".drop1")
		.mouseleave(function() {
			$(".dropdown1").hide(100);     
		});
		$(".drop2")
		.mouseover(function() {
			$(".dropdown2").show(100);
		});
		$(".drop2")
		.mouseleave(function() {
			$(".dropdown2").hide(100);     
		});
		$(".drop3")
		.mouseover(function() {
			$(".dropdown3").show(100);
		});
		$(".drop3")
		.mouseleave(function() {
			$(".dropdown3").hide(100);     
		});

		function logout()
		{
			window.location.href = "logout.php";
		}
	</script>

</div>
