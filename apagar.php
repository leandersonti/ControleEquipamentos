<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="css/apagar.css" type="text/css" rel="stylesheet" />
<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet" />
<script src="js/jquery.min.js"></script>
<script src="js/scriptMenu.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</head>
<body>
<h1>Rozwijane Menu</h1>

<nav class="nav">
	<ul>
		<li><a href="#">Start</a>
    <li><a href="#">O nas</a>
		<li class="drop"><a href="#">Oferta</a>
			<ul class="dropdown">
				<li><a href="#">Oferta 01</a></li>
				<li><a href="#">Oferta 02</a></li>
				<li><a href="#">Oferta 03</a></li>
			</ul>
		</li>
		<li><a href="#">Aktualności</a>
		<li><a href="#">Kontakt</a>
	</ul>
</nav>
<script>
$(".drop")
  .mouseover(function() {
  $(".dropdown").show(300);
});
$(".drop")
  .mouseleave(function() {
  $(".dropdown").hide(300);     
});
</script>

</body>
</html>