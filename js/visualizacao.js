//variavel de redicionamento
var visualizar;

//pegando o resultado do ajax
var idOng = location.search.slice(1);

//Função para mandar um sinal a cada 15 segundo apenas uma única vez
visualizar = setTimeout(function () { 
    $.ajax({
        type: 'GET',
        url:'controller/registra_visualizacao.php',
        data: idOng
    });
}, 15000);

