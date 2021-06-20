/*  Método: --
    Parâmetros: [ -- ]
    Objetivo:  Mostrar os inputs abaixo com uma mascará do jquery. 
*/
$(document).ready( function() {
    $('#cep').mask("99999-999");
    $('#phone').mask("(99) 99999-9999");
});

/*  Método: loadmap()
    Parâmetros: [ address, idmap ]
    Objetivo: Pegando a localização do animal e importando no mapa. 
*/
function loadmap(address, idmap) {
    //pegando a localização do animal e importando no mapa
    $url = `https://maps.googleapis.com/maps/api/geocode/json?address=${address}&key=${chave}`;
    console.log($url)
    fetch($url)
        .then(response => response.json())
        .then(data => { //Caso dê certo, cairá aqui
            //colocando os resultados em variaveis
            let latLocation = data.results[0].geometry.location.lat;
            let lngLocation = data.results[0].geometry.location.lng;
            const LatLng = { lat: latLocation, lng: lngLocation };

            //pegando o id do maps desejado
            var map2 = document.getElementById('map' + idmap);

            //console.log(map2); <- debug
            
            //criando o mapa
            map = new google.maps.Map(map2, {
                center: { lat: latLocation, lng: lngLocation },
                zoom: 18
            });
            
            //colocando uma marcação
            new google.maps.Marker({
                position: LatLng,
                map,
                title: "O animal está aqui!",
            });
        })
        .catch(err => {//caso dê erro, cairá aqui
            console.log("erro")
            //CreateModal('erro', 'Houve algum problema em localizar o local desejado, tente novamente');
        });
}

/*  Método: click_the_button()
    Parâmetros: [ botao ]
    Objetivo:  Função para interação com a icon de upload 
*/
function click_the_button(botao){
    botao.click();
}

//variavel para mostra a prévia da imagem quando for upada
var loadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('userView');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};

/*  Método: limpa_formulário_cep()
    Parâmetros: [ -- ]
    Objetivo:  função para limpar os resultados caso existam. 
*/
function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('cep').value=("");

}

/*  Método: meu_callback()
    Parâmetros: [ conteudo ]
    Objetivo: Colocar os dados nos inputs desejados. 
*/
function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('cep').value=(conteudo.cep);

        if(conteudo.cep == ""){
            CreateModal('Error', 'Não foi possível preencher os dados pedidos, tente novamente com outro endereço!');
            limpa_formulário_cep();
        }
    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep();
        alert("CEP não encontrado.");
        //CreateModal('Error', 'CEP não encontrado.');
    }
    }

/*  Método: pesquisacep()
    Parâmetros: [ valor ]
    Objetivo: Pegando o CEP desejado e verificando na api se existe resultados. 
*/
function pesquisacep(valor) {

//Nova variável "cep" somente com dígitos.
var cep = valor.replace(/\D/g, '');

//Verifica se campo cep possui valor informado.
if (cep != "") {

    //Expressão regular para validar o CEP.
    var validacep = /^[0-9]{8}$/;

    //Valida o formato do CEP.
    if(validacep.test(cep)) {

        //Cria um elemento javascript.
        var script = document.createElement('script');

        //Sincroniza com o callback.
        script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

        //Insere script no documento e carrega o conteúdo.
        document.body.appendChild(script);

    } //end if.
    else {
        //cep é inválido.
        alert("Formato de CEP inválido.");
        //CreateModal('Error', 'Formato de CEP inválido.');
    }
} //end if.
else {
    //cep sem valor, limpa formulário.
    limpa_formulário_cep();
}
};
