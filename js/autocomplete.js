$(function(){
    $.get('txts/dptos.txt', function (conteudoDoArquivo)
    {
        var linhas = conteudoDoArquivo.split('\n');

        $("#putDpto").autocomplete({
            source:linhas
        });

        // $("#putUnidade").autocomplete({
        //     source:linhas
        // });
    });
});

$(function(){
    $.get('txts/zonas.txt', function (conteudoDoArquivo)
    {
        var linhas = conteudoDoArquivo.split('\n');

        // $("#putDpto").autocomplete({
        //     source:linhas
        // });

        $("#putUnidade").autocomplete({
            source:linhas
        });
    });
});
