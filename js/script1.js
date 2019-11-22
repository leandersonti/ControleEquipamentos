$(function(){

    var formModal = $('form[name="editar"]');
    var action = 'scripts/crud.php';
    var idSerieGlobal;
    
    //consultar
    $('.linha').on('click','.editarM',function(){
        var id = $(this).attr('id');
        idSerieGlobal = id;
        var consulta = "&acao=consulta&idedit="+id;

        
        

        $.ajax({
            type: "POST",
            url: action,
            data: consulta,
            dataType: "json",
            error: function (retorno){
                alert(retorno);
            },
            success: function (retorno) {
                $.each(retorno, function (key, value) { 
                    formModal.find("input[name='"+key+"']").val(value);
                    formModal.find("textarea[name='"+key+"']").val(value);
                    formModal.find("select[name='"+key+"']").val(value);
                });
               
            }
        });
    });

    /*formModal.one({
    focusin: function(){
        var idserie = $("input[name='num_serie']").val();
            /*formModal.submit(function(){
                var dados = "acao=editar&idserie="+idserie+"&"+$(this).serialize();
                alert(dados);
                $.ajax({
                    type: "POST",
                    url: action,
                    data: dados,
                    error: function (erro){
                        alert(erro);
                    },
                    success: function(resposta){
                        alert(resposta);
                        //$('.editarN .modal-content').fadeOut("slow");
                       // $('editarN').attr("class","close");
                    }
                });
                return false;
            });
    }        

    });*/

     //editar
     formModal.submit(function(){
        var dados = "acao=editar&idserie="+idSerieGlobal+"&"+$(this).serialize();


       $.ajax({
            type: "POST",
            url: action,
            data: dados,
            beforeSend: function(){
                $('.esconder').addClass('alert');
                $('.esconder').empty().html('<img src="imagens/load.gif" width="20"> Atualizando...');
            },
            error: function (erro){
                alert(erro);
            },
            success: function(resposta){
               $('.esconder').removeClass('alert-warning').addClass('alert-success');
               $('.esconder').empty().html('Atualizado com Sucesso');
               window.setTimeout(function(){location.reload()},500);
            }
           });
          return false;
     });


     //excluir
    $('.linha').one('click','.excluirM',function(){
        var id = $(this).attr('id');
        $('button[value="1"').click(function(){
            var excluir = "&acao=deletar&idexcluir="+id;
            $.ajax({
                type: "POST",
                url: action,
                data: excluir,
                beforeSend: function(){
                    $('.esconderex').removeClass('alert-primary');
                    $('.esconderex').addClass('alert-warning');
                    $('.esconderex').empty().html('<img src="imagens/load.gif" width="20"> Excluindo...');
                },
                error: function (erro){
                    alert(erro);
                },
                success: function(resposta){
                    $('.esconderex').removeClass('alert-warning').addClass('alert-success');
                    $('.esconderex').empty().html('Excluido com Sucesso');
                    //$('.esconder').delay(2000);
                    //location.reload();
                   window.setTimeout(function(){location.reload()},500);
                }
                
            });
            return false;
        });
   
    }); 
 
});