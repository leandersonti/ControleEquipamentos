function exibePrazo(flag)
{
	if (flag) document.getElementById('contPrazo').style.height = "38px";
	else document.getElementById('contPrazo').style.height = "0";
	document.getElementById('prazoDevolucao').onclick = function()
	{
		exibePrazo(!flag);
	};
}

function setMaiusculo(input)
{
	input.value = input.value.toUpperCase();
}

function edit(id)
{
	serie = document.getElementById(id).innerText;
	window.location.href = "editar_equipamento.php?serie="+serie;	
}

function excluir(id)
{
	serie = document.getElementById(id).innerText;
	window.location.href = "excluir_equipamento.php?serie="+serie;
}

function exibirUnidade(d)
{
	if (d=='i')
	{
		document.getElementById('groupEmprestimo').style.height = "63.5px";
		document.getElementById('groupEmprestimo').style.marginBottom = "1rem";

		document.getElementById('putDpto').value="";
		document.getElementById('putDpto').style.display="none";
		document.getElementById('putUnidade').style.display='block';
		document.getElementById('putDpto').removeAttribute("required");
		document.getElementById('putUnidade').setAttribute("required","true");
	}
	if (d=='c')
	{
		document.getElementById('groupEmprestimo').style.height = "0";
		document.getElementById('groupEmprestimo').style.marginBottom = "0";

		document.getElementById('putUnidade').value="";
		document.getElementById('putDpto').style.display='block';
		document.getElementById('putUnidade').style.display="none";
		document.getElementById('putUnidade').removeAttribute("required");
		document.getElementById('putDpto').setAttribute("required","true");
	}
}

function addList(id) 
{
	let numero = document.getElementsByClassName('item').length;

	if(numero==0) document.getElementById('formulario_escondido').style.height = "max-content";
	document.getElementById('formulario_escondido').style.display = "block"
	document.getElementById('stt'+id).style.fontWeight = "bold";
	document.getElementById('stt'+id).style.color = "gold";

	document.getElementById('lotar'+id).innerText = "";

	var div = document.getElementById("lista");

	var item = document.createElement('div');
	var bt_remove = document.createElement('div');
	var lotados = document.getElementById('lotados');
	var num_serie = document.getElementById(id).innerText;
	var equipamento = document.getElementById('e'+id).innerText;
	var divSerie = document.createElement('div');
	var divEquip = document.createElement('div');

	divSerie.innerText = num_serie;
	divEquip.innerText = equipamento;

	div.appendChild(item).className="item";
	div.lastChild.appendChild(divSerie).className="divSerie";
	div.lastChild.appendChild(divEquip).className="divEquip";
	div.lastChild.appendChild(bt_remove).className="bt_remove";
	document.getElementById('lotados').value += num_serie+";";

	var div_item = document.getElementById('lista').lastChild;
	div_item.setAttribute("id","item"+id);
	bt_remove.onclick = function ()
	{
		remove(id);
	};
	colorir();
}

function remove(id)
{
	document.getElementById('stt'+id).style.fontWeight = "normal";
	document.getElementById('stt'+id).style.color = "#000";

	var img = document.createElement('img');
	var div_remove = document.getElementById('item'+id);
	var teste_serie = div_remove.innerText.split("\n");
	if (div_remove.parentNode)
	{
		div_remove.parentNode.removeChild(div_remove);
	}
	var series = lotados.value.split(";");
	lotados.value = "";
	for(j=0;j<series.length-1;j++)
	{
		if(series[j]!=teste_serie[0])
			lotados.value += series[j]+";";
	}
	div = document.getElementById('lotar'+id);
	div.appendChild(img).className="icon";
	img.setAttribute("src","imagens/icons/seta_que_vai.svg");

	colorir();
	
	if(document.getElementsByClassName('item').length==0)
		document.getElementById('formulario_escondido').style.display="none";
}

function colorir()
{
	let itens = document.getElementsByClassName('item');
	for (var i = 0; i < itens.length; i++)
	{
		if(i%2==0)
			itens[i].style.backgroundColor="#F0F8FF";
		else
			itens[i].style.backgroundColor="#FFFFFF";
	}
}

window.onload = paginacao(1);
function paginacao(pag)
{
	let qtdd = document.getElementsByClassName('linha');
	let quantitativo = document.getElementById('quantitativo');
	let totalzao = quantitativo.innerText.split(" de ")[1];

	let limite = 10;
	let altura;
	qtdd = qtdd.length-(limite*(pag-1));
	if(qtdd>limite){
		altura = limite*35;
		quantitativo.innerText = limite+' de '+totalzao;
	}
	else{
		altura = qtdd*35
		quantitativo.innerText = qtdd+' de '+totalzao;
	}
	var pgatual = document.getElementById('inputEscondido').value;
	document.getElementById('pg'+pgatual).style.height=0;


	document.getElementById('btn'+document.getElementById('inputEscondido').value).className="btn btn-primary";
	document.getElementById('btn'+pag).className="btn btn-primary pgAtual";

	document.getElementById('pg'+pag).style.height = altura+"px";
	document.getElementById('inputEscondido').value = pag;
}

function back()
{
	var pgatual = document.getElementById('inputEscondido').value;
	pgatual = parseInt(pgatual);
	var anterior = pgatual-1;
	if(pgatual>1)
		paginacao(anterior);
}

function next()
{
	var pgatual = document.getElementById('inputEscondido').value;
	var total = document.getElementById('totalPaginas').value;
	pgatual = parseInt(pgatual);
	console.log(pgatual);
	var proxima = pgatual+1;
	if(pgatual<total)
		paginacao(proxima);
}