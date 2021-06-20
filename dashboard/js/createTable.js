//variaveis
var tableAll = "";
var tableYour = "";
var EditInNewWindow = Boolean(Number(localStorage.getItem('EditWindow')));
var TableStateDb = Boolean(Number(localStorage.getItem('TableStateDb')));

/*  Método: ShowLoader()
    Parâmetros: [ id, active ]
    Objetivo: Carregamento do spinner na página. 
*/
function ShowLoader(id, active){
    if(active){
      $('#'+id).show();
     }else{
    $('#'+id).hide();
     }
}

/*  Método: GetData()
    Parâmetros: [ type ]
    Objetivo: Pegando os dados da tabela 1 no banco de dados via ajax. 
*/
function GetData(type){
    //ativar spinner
    ShowLoader("loadingYour",true);
    $.ajax({
        type: "GET",
        url: "./controller/pegar_reports.php",
        data: {"report": type, "id": id},
        success: function(data){ //Se der sucesso
          //redireciona para outra função
          BuildTableScd(data);
        },
        error: function (xhr, thrownError){ //se der erro
            if(xhr.status != 200){
                alert('ERR: Ajax returning a stats ' + xhr.status);
                console.warn("[AJAX] Stats: " + xhr.status + " // ERR: " + thrownError);
            }
      }
    });
}

/*  Método: GetDataSnd()
    Parâmetros: [ type ]
    Objetivo: Pegando os dados da tabela 2 no banco de dados via ajax. 
*/
function GetDataSnd(type){
    //ativar spinner
    ShowLoader("loadingAll",true);
    $.ajax({
        type: "GET",
        url: "./controller/pegar_reports.php",
        data: {"report": type, "id": id},
        success: function(data){ //se der sucesso
          //redireciona para outra função
          BuildTable(data);
        },
        error: function (xhr, thrownError){ //se der erro
            if(xhr.status != 200){
                alert('ERR: Ajax returning a stats ' + xhr.status);
                console.warn("[AJAX] Stats: " + xhr.status + " // ERR: " + thrownError);
            }
      }
    });

}

/*  Método: BuildTable()
    Parâmetros: [ data ]
    Objetivo: Função que cria a primeira tabela na página, tendo ou não os dados recebidos. 
*/
function BuildTable(data){
    //criando a estrutura da tabela via DataTable
    tableYour = $('#YourReports').DataTable( {
        data: data, //passando os dados
        stateSave: TableStateDb,
        "order": [[ 4, "asc" ]],
        columns: [ //passando as colunas da tabela
            {title: "ID"},
            {title: "Animal"},
            {title: "Descrição"},
            {title: "Localização"},
            {title: "Distância"}, 
            {title: "Ação"}
        ], 
        "columnDefs": [ //botão para conseguir visualizar o report melhor
            {
                "targets": -1,
                "data": null,
                "defaultContent": "<button type='button' class='btn btn-dark'>Visualizar</button>"
            },{ //Escondendo o id (desnecessário)
                "targets": [ 0 ],
                "visible": false
            }
        ]
    });

    /*  Método: --
        Parâmetros: [ -- ]
        Objetivo: A função que chama a outra página ao clicar no botão. 
    */
    $('#YourReports').on( 'click', 'button', function () {
        var data = tableYour.row( $(this).parents('tr') ).data();
        window.location.href = "visualizaReport.php?id=" + data[0];
    });
    //desativar spinner
    ShowLoader("loadingYour",false);
}

/*  Método: BuildTableScd()
    Parâmetros: [ data ]
    Objetivo: Função que cria a segunda tabela na página, tendo ou não os dados recebidos. 
*/
function BuildTableScd(data){
    //criando a estrutura da tabela via DataTable
    tableAll = $('#AllReports').DataTable( {
        data: data, //passando os dados
        stateSave: TableStateDb,
        "order": [[ 4, "asc" ]], //ordenar a coluna pela menor distância
        columns: [ //passando as colunas da tabela
            {title: "ID"},
            {title: "Animal"},
            {title: "Descrição"},
            {title: "Localização"},
            {title: "Distância"},
            {title: "Ação"}
        ], 
        "columnDefs": [ //botão para conseguir visualizar o report melhor           
            {
                "targets": -1,
                "data": null,
                "defaultContent": "<button type='button' class='btn btn-dark'>Visualizar</button>"
            }, { //Escondendo o id (desnecessário)
                "targets": [ 0 ],
                "visible": false
            }
        ]   
    });
    
    /*  Método: --
        Parâmetros: [ -- ]
        Objetivo: A função que chama a outra página ao clicar no botão. 
    */
    $('#AllReports').on( 'click', 'button', function () {
        var data = tableAll.row( $(this).parents('tr') ).data();
         window.location.href = "visualizaReport.php?id=" + data[0];
    });

    //desativar spinner
    ShowLoader("loadingAll",false);
}

//pegando o id da ong
var cookie = document.cookie; //recebendo o cookie inteiro
var justId = cookie.replace("PHPSESSID=al42guijcksmahbc8qmc28j10t", ""); //tirando caracteres desnecessarios
var getNumber = justId.replace("id=", "");//tirando caracteres desnecessarios
var id = getNumber.replace(";", "");//tirando caracteres desnecessarios
id = id.trim(); //tirando espaçamento desnecessario
//debug -> console.log(id);

//enviados os dados pré-determinados
GetData("all");
GetDataSnd("Your");