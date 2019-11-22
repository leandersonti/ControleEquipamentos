<?php require 'conn.php'; 
include_once("head.php");
include_once('topoLogo.php');
include_once('menu.php');
?>


<body>

	<div style="width:50%; margin:100px auto" class="panel panel-defalt">
    <fieldset>
      <form name="cadastrar" method="post">

        <div class="form-group">
          <label for="inputCity">Deseja adicionar mais de um equipamento com as mesmas especificações?</label>
          <br>
          <label for="yes">Sim</label> <input type="radio" name="pergunta" id="yes" onclick="exibirCampo(0)">
          <label for="no">Não</label> <input type="radio" selected="selected" name="pergunta" id="no" onclick="exibirCampo(1)">
        </div>   

        <div class="alert-warning esconderCad" role="alert" >
								
			  </div>   

        <div class="form-group oculto" id="campoQtdd">
          <label for="inputCity">Quantidade de Equipamentos Iguais</label>
          <input type="number" value="1" id="inputQtdd" name="qtdd" min="1" class="form-control" id="inputCity" placeholder="XXX.XXX">
        </div>

        <div class="form-row">

          <div class="form-group col-md-6">
            <label for="inputCity">Número de Patrimônio/Série</label>
            <input type="text" name="num_serie" class="form-control trava" id="campoSerie" placeholder="XXX.XXX">
              <div class="invalid-feedback">
                Informe o Número de Série ou Patrimônio!
              </div>
          </div>
          <div class="form-group col-md-6">
            <label for="inputEstado">Equipamento</label>
            <select id="inputEstado" name="tipo" class="form-control trava">
              <option value="">Escolher...</option>
              <option value="Mouse">Mouse</option>
              <option value="Teclado">Teclado</option>
              <option value="Monitor">Monitor</option>
              <option value="Gabinete">Gabinete</option>
              <option value="Notebook">Notebook</option>
              <option value="Injetor">Injetor</option>
              <option value="Impressora">Impressora</option>
              <option value="Print Server">Print Server</option>
              <option value="Projetor">Projetor</option>
              <option value="Webcam">Webcam</option>
              <option value="Telefone">Telefone</option>
              <option value="Mini HD">Mini HD</option>
              <option value="Minicomputador">Minicomputador</option>
              <option value="Bateria para Nobreak">Bateria para Nobreak</option>
            </select>
              <div class="invalid-feedback">
              Selecione o Tipo de Equipamento!
              </div>
          </div>

        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="inputCity">Modelo</label>
            <input type="text" name="modelo" class="form-control trava" id="inputCity" placeholder="Modelo do Equipamento">
              <div class="invalid-feedback">
                Informe o Modelo do Equipamento!
              </div>
          </div>
          <div class="form-group col-md-6">
            <label for="inputEstado">Marca</label>
            <select id="selecao" name="marca" class="form-control trava" onchange="revelarOutros()">
              <option selected value="">Escolher...</option>
              <option value="Dell">Dell</option>
              <option value="HP">HP</option>
              <option value="AOC">AOC</option>
              <option value="AVAYA">AVAYA</option>
              <option value="Samsung">Samsung</option>
              <option value="Logitech">Logitech</option>
              <option value="Epson">Epson</option>
              <option value="Lenovo">Lenovo</option>
              <option value="Outro">Outro</option>
            </select>
              <div class="invalid-feedback">
                Selecione a Marca do Equipamento!
              </div>
          </div>

          <!-- trabalhar a parte oculta-->
        </div>
        <div class="form-group" id="oculto" style="display:none">
          <label for="exampleFormControlTextarea1">Outros</label>
          <input type="text" name="outraMarca"  class="form-control trava1" placeholder="Marca">
          <div class="invalid-feedback">
                Informe a Marca do Equipamento!
          </div>
        </div>

        <div class="form-group">
          <label>Condição do Equipamento</label>
          <select name="condicao_entrada" class="form-control trava">
            <option value="">Escolher...</option>
            <option value="0">Novo</option>
            <option value="1">Doação</option>
          </select>
          <div class="invalid-feedback">
            selecione a Condição do Equipamento!
          </div>
        </div>

        <div class="form-group">
          <label for="exampleFormControlTextarea1">Descrição</label>
          <textarea class="form-control" name="descricao" id="exampleFormControlTextarea1" rows="3" placeholder="Detalhes a respeito do equipamento"></textarea>
        </div>

        <button type="submit" id="submit" class="btn btn-primary">Cadastrar</button>
      </form>
    </div>
  </fieldset>
</body>

<script type="text/javascript">
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

  /*function revelarOutros(){
    var x = document.getElementById("selecao").value;
    if (x == "Outro"){
      document.getElementById("oculto").removeAttribute("hidden");
    }else{
      document.getElementById("oculto").setAttribute("hidden","hidden");
    }
  }*/

  $(function(){
    $('select[name="marca"]').change(function () { 
      var valor = $(this).val();
      if (valor == "Outro"){
        //$("#oculto").delay(3000);
        $(".trava1").attr("REQUIRED","REQUIRED");
        $("#oculto").show(300);
      }else{
        $(".trava1").removeAttr("REQUIRED","REQUIRED");
        $("#oculto").hide(300);
      }
    });
  });

</script>

</html>