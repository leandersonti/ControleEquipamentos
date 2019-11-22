window.onload = paginacao(1);
function paginacao(pag)
{
	let limite = 5;
	let qtdd = document.getElementsByClassName('linha');
	let quant = document.getElementById('quantitativo');

	let totalzao = quant.innerText.split(" de ")[1];
	let altura;

	qtdd = qtdd.length-(limite*(pag-1));
	if(qtdd>limite)
	{
		altura = limite*35;
		quant.innerText = limite+" de "+totalzao;
	}
	else
	{
		altura = qtdd*35;
		quant.innerText = qtdd+" de "+totalzao;
	}

	var pgatual = document.getElementById('inputEscondido').value;
	document.getElementById('pg'+pgatual).style.height=0;

	document.getElementById('btn'+pgatual).className="btn btn-primary";
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
	total = parseInt(total);
	var proxima = pgatual+1;
	if(proxima<=total){
		console.log(total);
		paginacao(proxima);
	}
}