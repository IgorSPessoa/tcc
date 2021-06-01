var visualizar;
var idOng = location.search.slice(1);

visualizar = setTimeout(function () { 
    $.ajax({
        type: 'GET',
        url:'controller/registra_visualizacao.php',
        data: idOng
    });
}, 15000);

