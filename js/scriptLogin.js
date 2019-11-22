$('form[name="loginUsuario"]').submit(function(){

    // $('.trava').attr("REQUIRED","REQUIRED");
    // $(this).addClass("was-validated");
    
    var titulo = $('input[name="titulo"]').val();
    var senha = $('input[name="senha"]').val();
    var cadastroUsu = "&acao=loginUsuario&"+$(this).serialize();
    var action = 'scripts/login.php';

    $.ajax({
        type: "POST",
        url: action,
        data: cadastroUsu,
        beforeSend: function(){
            $('.esconderUsu').addClass('alert');
            $('.esconderUsu').removeClass('alert-danger').addClass('alert-warning');
            $('.esconderUsu').empty().html('<img src="imagens/load.gif" width="20"> Verificando...');
        },
        error: function (erro){
            alert(erro);
        },
        success: function(msg){
            if(msg==2){
                $('.esconderUsu').removeClass('alert-warning').addClass('alert-danger');
                $('.esconderUsu').empty().html('Título e Senha não coincidem ');
            }else{
                window.setTimeout(function(){location.href = "logar.php?titulo="+msg},100);
            }
        }
    });

    return false; 
});