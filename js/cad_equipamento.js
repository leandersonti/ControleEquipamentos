function exibirLocacao()
{
  const change = document.getElementById('selectStatus');
  if (change.value == 1 || change.value == 4)
  {
    document.getElementById('dados-locacao').style.height = "86px";
  }else{
    document.getElementById('dados-locacao').style.height = "0";
  }
}

function exibirCampo(op)
{
  if (op==0)
  {
    document.getElementById('campoQtdd').style.height="69.65px";
    document.getElementById('campoSerie').setAttribute("readonly","true");
    document.getElementById('inputQtdd').value = "2";
    document.getElementById('submit').innerText="Próximo";
  }
  else
  {
    document.getElementById('campoSerie').removeAttribute("readonly");
    document.getElementById('campoQtdd').style.height="0";
    document.getElementById('inputQtdd').value = "1";
    document.getElementById('submit').innerText="Cadastrar";
  }
}

$(function(){
  $('select[name="marca"]').change(function () { 
    var valor = $(this).val();
    if (valor == "Outro"){
      $(".trava1").attr("REQUIRED","REQUIRED");
      $("#oculto").show(300);
    }else{
      $(".trava1").removeAttr("REQUIRED","REQUIRED");
      $("#oculto").hide(300);
    }
  });
});


$(function(){
  $('select[name="tipo"]').change(function () { 
    var valor = $(this).val();
    if (valor == "Outro"){
      $(".trava2").attr("REQUIRED","REQUIRED");
      $("#tipoOculto").show(300);
    }else{
      $(".trava2").removeAttr("REQUIRED","REQUIRED");
      $("#tipoOculto").hide(300);
    }
  });
});