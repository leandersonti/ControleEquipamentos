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
            <select id="selecao" name="marca" class="form-control trava">
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

        <div class="form-group" id="oculto">
          <label>Outros</label>
          <input type="text" name="outraMarca" class="form-control trava1" placeholder="Marca">
          <div class="invalid-feedback">
                Informe a Marca do Equipamento!
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
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

          <div class="form-group col-md-6">
            <label>Status do Equipamento</label>
            <select id="selectStatus" name="status" class="form-control" onchange="exibirLocacao()">
              <option value="0" selected>Disponivel</option>
              <option value="1">Alocado</option>
              <option value="4">Alocado no interior</option>
              <option value="2">Defeituoso</option>
              <option value="3">Em manutenção</option>
            </select>
            <div class="invalid-feedback">
              selecione o Status do equipamento!
            </div>
          </div>
        </div>

        <div id="dados-locacao" class="form-row">
          <div class="form-group col-md-6">
            <label>Locação</label>
            <input type="text" name="local_equipamento" class="form-control" placeholder="Setor/Unidade">
            <div class="invalid-feedback">
              indique a locação do equipamento
            </div>
          </div>

          <div class="form-group col-md-6">
            <label>Responsável</label>
            <input type="text" name="responsavel" class="form-control" placeholder="Responsável">
            <div class="invalid-feedback">
              indique a locação do equipamento
            </div>
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

<script type="text/javascript" src="./js/cad_equipamento.js"></script>

</html>