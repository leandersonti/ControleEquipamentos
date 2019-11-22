$(function(){

    //Variáves Globais
    var formModal = $('form[name="editar"]');
    var formModalEdit = $('form[name="editusuario"]');
    var action = 'scripts/crud.php';
    var idSerieGlobal;
    var idUsuGlobal;
    var marcas = ['Dell','HP','AOC','AVAYA','Samsung','Logitech','Epson','Lenovo'];

//------------------ CRUD BANCO -----------------//
     //Validações
     //cadastro Equipamento
     $('form[name="cadastrar"]').submit(function(){
        $('.trava').attr("REQUIRED","REQUIRED");
        $(this).addClass("was-validated");
        var nome = $('input[name="num_serie"]').val();
        var tipo = $('select[name="tipo"]').val();
        var marca = $('select[name="marca"]').val();
        var modelo = $('input[name="modelo"]').val();
        var outraMarca = $('input[name="outraMarca"]').val();
        var condicao = $('select[name="condicao_entrada"]').val();
        var qtd = $('input[name="qtdd"]').val();
        var cadastro = "&acao=cadastrar&"+$(this).serialize();

        if (qtd > 1){
        
            if(tipo !="" && marca !="" && modelo !=""  && condicao !=""){
                var cadastro = "&acao=cadastrar&"+$(this).serialize();
                    
                window.location.href = "cad_eq_multiplo.php?"+cadastro;
                }
                //verificar a questao da validade da outramarca

        }else if(nome != "" && tipo !="" && marca !="" && modelo !="" && condicao !=""){
            var cadastro = "&acao=cadastrar&"+$(this).serialize();
                
            $.ajax({
                type: "POST",
                url: action,
                data: cadastro,
                beforeSend: function(){
                    $('.esconderCad').addClass('alert');
                    $('.esconderCad').empty().html('<img src="imagens/load.gif" width="20"> Cadastrando...');
                },
                error: function (erro){
                    alert(erro);
                },
                success: function(msg){
                   if(msg == 1){
                        $('.esconderCad').removeClass('alert-warning').addClass('alert-success');
                        $('.esconderCad').empty().html('Cadastrado com Sucesso');
                        window.setTimeout(function(){location.href = "cad_equipamento.php"},500);     
                    }else{
                        $('.esconderCad').removeClass('alert-warning').addClass('alert-danger');
                        $('.esconderCad').empty().html('Falha ao Cadastrar');
                        window.setTimeout(function(){location.reload()},500);
                    }
                }
               });
            }
              return false;
         });


         //cadastro Usuario
         $('form[name="cadastrarUsuario"]').submit(function(){
           
            $('.trava').attr("REQUIRED","REQUIRED");
            $(this).addClass("was-validated");
            var nome = $('input[name="nome"]').val();
            var titulo = $('input[name="titulo"]').val();
            var senha = $('input[name="senha"]').val();
            var ConfirmSenha = $('input[name="senhaConfirm"]').val();
            var cadastroUsu = "&acao=cadastrarUsuario&"+$(this).serialize();
            
            if(nome != "" && titulo !="" && senha !="" && ConfirmSenha !=""){
                if(titulo.length!=14){
                    $('.esconderUsu').removeClass('alert-warning').addClass('alert alert-danger');
                    $('.esconderUsu').empty().html('O titulo informado não esta no formato padrão de 12 números');
                }else if(senha==ConfirmSenha){
                    // var cadastro = "&acao=cadastrar&"+$(this).serialize();
                    
                    $.ajax({
                        type: "POST",
                        url: action,
                        data: cadastroUsu,
                        beforeSend: function(){
                            $('.esconderUsu').addClass('alert');
                            $('.esconderUsu').empty().html('<img src="imagens/load.gif" width="20"> Cadastrando...');
                        },
                        error: function (erro){
                            alert(erro);
                        },
                        success: function(msg){
                            if(msg == 1){
                                $('.esconderUsu').removeClass('alert-warning').addClass('alert-success');
                                $('.esconderUsu').empty().html('Cadastrado com Sucesso');
                                window.setTimeout(function(){location.href = "mudar_usuario.php"},500);     
                            }else if(msg==2){
                                $('.esconderUsu').removeClass('alert-warning').addClass('alert-danger');
                                $('.esconderUsu').empty().html('Falha ao Cadastrar');
                                window.setTimeout(function(){location.reload()},500);
                            }else if(msg==3){
                                // $('.esconderUsu').removeClass('alert-warning').addClass('alert-danger');
                                // $('.esconderUsu').empty().html('O titulo informado não esta no padrão');
                            }
                        }
                    });
                }else{
                    $('.esconderUsu').addClass('alert alert-danger');
                    $('.esconderUsu').empty().html('As senhas devem ser iguais!');
                }
            }else{

                $('.esconderUsu').addClass('alert alert-danger');
                    $('.esconderUsu').empty().html('Preencha todos os campos!');
            }

                 return false; 
             });

    
    
    //consultar equipamento
    $('.linha').on('click','.editarM',function(){
        var id = $(this).attr('id');
        idSerieGlobal = id;
        $("#oculto").css("display","none");
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
                    console.log(key+" "+value);
                    formModal.find("input[name='"+key+"']").val(value);
                    formModal.find("textarea[name='"+key+"']").val(value);
                    formModal.find("select[name='"+key+"']").val(value);
                    formModal.find("select[name='"+key+"']").val(value);
                   // var marca = $('input[name="marca"]').val();
                /*if ($("select[name='marca']").val() ==""){                   
                    $("select[name='marca']").append("<option>"+marca+"</option>")
                    formModal.find("select[name='marca']").val(marca);
                  }*/
                    
                    
                });
                
                let flag = true;
                for(let i=0;i<marcas.length;i++)
                {
                    if(marcas[i] == retorno['marca'])
                        flag = false;
                }
                
                if(flag){
                    formModal.find("select[name='marca']").append("<option>"+retorno['marca']+"</option>");
                    formModal.find("select[name='marca']").val(retorno['marca']);
                }

            }
        });
    });

    //consultar Usuario
    $('.topousu').on('click','.editarUsu',function(){
        var id = $(this).attr('id');
        idUsuGlobal = id;
        var consulta = "&acao=consultaUsuario&ideditUsu="+id;
        
        

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
                    if (key != "senha"){
                    formModalEdit.find("input[name='"+key+"']").val(value);

                    formModalEdit.find("select[name='"+key+"']").val(value);
                    }

                });
                
                

            }
        });
    });


     //editar Equipamento
       formModal.submit(function(){
        var nome = $('input[name="num_serie"]').val();
        var tipo = $('select[name="tipo"]').val();
        var marca = $('select[name="marca"]').val();
        var modelo = $('input[name="modelo"]').val();
        var teste = $(this).serialize();
        // alert(teste);
        

        if(nome != ""){
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
               if(resposta == 1){
                    $('.esconder').removeClass('alert-warning').addClass('alert-success');
                    $('.esconder').empty().html('Atualizado com Sucesso');
                    window.setTimeout(function(){location.reload()},500);
                }else if(resposta == 2){
                    $('.esconder').removeClass('alert-warning').addClass('alert-danger');
                    $('.esconder').empty().html('Falha ao Atualizar');
                    window.setTimeout(function(){location.reload()},500);
                }else{
                    $('.esconder').removeClass('alert-warning').addClass('alert-danger');
                    $('.esconder').empty().html('Devolva o equipamento na aba "Empréstimos"');
                    window.setTimeout(function(){location.reload()},1700);
                }
            }
           });
        }else{
          alert("nao ta indo");
        }
          return false;
     });//fim edição equipamento

     //editar usuario

     formModalEdit.submit(function(){
        var nome = $('input[name="nome"]').val();
        var id = $(this).attr('id');

        if(nome != ""){
            var dadosUsu = "acao=editarUsuario&IdEditUsuario="+idUsuGlobal+"&"+$(this).serialize();
                
           $.ajax({
                type: "POST",
                url: action,
                data: dadosUsu,
                beforeSend: function(){
                    $('.esconder').addClass('alert');
                    $('.esconder').empty().html('<img src="imagens/load.gif" width="20"> Atualizando...');
                },
                error: function (erro){
                    alert(erro);
                },
                success: function(resposta){
                   if(resposta == 1){
                        $('.esconder').removeClass('alert-warning').addClass('alert-success');
                        $('.esconder').empty().html('Atualizado com Sucesso');
                        window.setTimeout(function(){location.reload()},500);
                    }else{
                        $('.esconder').removeClass('alert-warning').addClass('alert-danger');
                        $('.esconder').empty().html('Falha ao Atualizar');
                        window.setTimeout(function(){location.reload()},500);
                    }
                }
               });
            }else{
              alert("nao ta indo");
            }

        return false;
     });


     //excluir equipamento
    $('.linha').one('click','.excluirM',function(){
        var id = $(this).attr('id');
        $('button[value="1"]').click(function(){
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
                    if(resposta == 1){
                        $('.esconderex').removeClass('alert-warning').addClass('alert-success');
                        $('.esconderex').empty().html('Excluido com Sucesso');
                        //$('.esconder').delay(2000);
                        //location.reload();
                        window.setTimeout(function(){location.reload()},500);
                    }else{
                        $('.esconderex').removeClass('alert-warning').addClass('alert-danger');
                        $('.esconderex').empty().html('Falha ao Excluir ');
                        window.setTimeout(function(){location.reload()},500);
                    }
                }
                
            });
            return false;
        });
   
    }); 

    //excluir usuario

    $('.topousu').one('click','.excluirUsu',function(){
        var id = $(this).attr('id');
        $('button[value="1"]').click(function(){
            var excluir = "&acao=deletarUsuario&idexcluir="+id;
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
                    if(resposta == 1){
                        $('.esconderex').removeClass('alert-warning').addClass('alert-success');
                        $('.esconderex').empty().html('Excluido com Sucesso');
                        //$('.esconder').delay(2000);
                        //location.reload();
                        window.setTimeout(function(){location.reload()},500);
                    }else{
                        $('.esconderex').removeClass('alert-warning').addClass('alert-danger');
                        $('.esconderex').empty().html('Falha ao Excluir ');
                        window.setTimeout(function(){location.reload()},500);
                    }
                }
                
            });
            return false;
        });
   
    }); 
 //fim excluir usuario

 
});