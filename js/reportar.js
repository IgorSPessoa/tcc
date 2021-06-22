/*  Método: click_the_button()
    Parâmetros: [ botao ]
    Objetivo:  Função para interação com a icon de upload 
*/
function click_the_button(botao){
    botao.click();
}

//variaveis para colocar a imagem como preview na página 
var loadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('animalView');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};

var loadFilesnd = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('addressPreview');
        output.src = reader.result;
        };
    reader.readAsDataURL(event.target.files[0]);
};

/*  Método: --
    Parâmetros: [ -- ]
    Objetivo:  Mostrar o input abaixo com uma mascará do jquery. 
*/
$(document).ready( function() {
    $('#cep').mask("99999-999");
});

/*  Método: limpa_formulário_cep()
    Parâmetros: [ -- ]
    Objetivo:  função para limpar os resultados caso existam. 
*/
function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('address').value=("");
    document.getElementById('number').value=("");
    document.getElementById('district').value=("");
    document.getElementById('state').value=("");
}

/*  Método: meu_callback()
    Parâmetros: [ conteudo ]
    Objetivo: Colocar os dados nos inputs desejados. 
*/
function meu_callback(conteudo) {
if (!("erro" in conteudo)) {
    //Atualiza os campos com os valores.
    document.getElementById('address').value=(conteudo.logradouro);
    document.getElementById('district').value=(conteudo.bairro);
    document.getElementById('state').value=(conteudo.uf);
} //end if.
else {
    //CEP não Encontrado.
    limpa_formulário_cep();
    CreateModal('Error', 'CEP não encontrado.');
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

        //Preenche os campos com "..." enquanto consulta webservice.
        document.getElementById('address').value="...";
        document.getElementById('district').value="...";
        document.getElementById('state').value="...";

        //Cria um elemento javascript.
        var script = document.createElement('script');

        //Sincroniza com o callback.
        script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

        //Insere script no documento e carrega o conteúdo.
        document.body.appendChild(script);

    } //end if.
    else {
        //cep é inválido.
        limpa_formulário_cep();
        CreateModal('Error', 'Formato de CEP inválido.');
    }
} //end if.
else {
    //cep sem valor, limpa formulário.
    limpa_formulário_cep();
}
};

/*  Método: getLocation()
    Parâmetros: [ -- ]
    Objetivo: Atráves das cordenadas do computador, o sistema faz uma pesquisa no geocode no google maps e depois na api do VIACEP para pegar todos os resultados desejados. 
*/
function getLocation() { //Função chamada pelo botão no reportar.php
    if('geolocation' in navigator){//Saber se o navegador é compátivel com o geolocation
            navigator.geolocation.getCurrentPosition(function(position) {
                var latitude   = position.coords.latitude; //pegando a latitude atual do dispositivo
                var longitude  = position.coords.longitude;//pegando a longitude atual do dispositivo

                const Lat = latitude;
                const Lng = longitude;
                const chave = "YOUR_APIKEY"; //chave da API 

                let urlsnd = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${Lat},${Lng}&key=${chave}`;

                fetch(urlsnd)//procurando pela url no browser
                .then(response => response.json())
                .then( data => { //Se houver dados irá vir para o .then

                    //colocando as variaveis que irão para api do viacep em constantes
                    let address = data.results[1].address_components[1].long_name; 
                    const state = data.results[1].address_components[3].short_name;
                    const uf = data.results[1].address_components[4].short_name; 
                    
                    //Url para fazer a pesquisa do endereço no VIACEP
                    let urlViacep = "https://viacep.com.br/ws/" + uf + "/" + state + "/" + address + "/json/";
                   
                    //console.log(urlViacep); <- debug

                    fetch(urlViacep)//procurando pela url no browser
                    .then(response => response.json())
                    .then ( data => {//Se houver dados irá vir para o .then

                        //Colotando os dados encontrados em variaveis
                        const cep = data[0].cep;
                        const endereco = data[0].logradouro;
                        const bairro = data[0].bairro;
                        const estado = data[0].uf;

                        //colocando os inputs dentro de variaveis pelo id
                        const cepGps = document.getElementById("cep")
                        const address = document.getElementById("address");
                        const district = document.getElementById("district");
                        const state = document.getElementById("state");

                        //impremindo os dados no inputs
                        cepGps.value = cep;
                        address.value = endereco;
                        district.value = bairro;
                        state.value = estado;
                        
                    })
                    .catch(err => {//Caso dê erro na API do VIACEP, cairá aqui
                        CreateModal('Error', 'Não foi possivel pegar os dados desejados!');
                        return;
                    });   
                })
                .catch(err => {//Caso dê erro na API do Geocoding do Google Maps, cairá aqui
                    CreateModal('Error', 'Não foi possivel pegar os dados desejados!');
                    return;
                });
        });
        } else {//Se o dispositivo não tiver suporte cairá no modal
            CreateModal('Error', 'Sem suporte para este navegador!');
        }
    }

/*  Método: --
    Parâmetros: [ -- ]
    Objetivo: Sistema de autocomplete para o modal. 
*/
const input = document.getElementById("modalAddress");        
const options = {
 componentRestrictions: { country: "br" },
 fields: ["address_components", "geometry", "icon", "name"],
 strictBounds: false,
 };
 
 /*  Método: --
    Parâmetros: [ -- ]
    Objetivo: criando uma variaveis para receber os dados da pesquisa. 
*/
 const autocomplete = new google.maps.places.Autocomplete(input, options);

/*  Método: --
    Parâmetros: [ -- ]
    Objetivo: Não deixar que o usúario mande os dados pela tecla enter, pois isso acarreta em um erro indesejável . 
*/
 $("form").keypress(function(e) {
    //Enter key
    if (e.which == 13) {
        return false;
    }
});

/*  Método: --
    Parâmetros: [ -- ]
    Objetivo: Pegando os dados da API VIACEP e preenchendo nos seus inputs. 
*/
$(document).ready( function (){
    $('#valueAddress').click( function (){
        //pegando o address que o usuario colocou
        var address = document.getElementById("modalAddress").value;

        //separados os dados 
        var newAddress = address.split("-");
        var separarBairro =  newAddress[1].split(",");
        var separarUf = newAddress[2].split(",");

        var address = newAddress[0].trim();;
        var district = separarBairro[0].trim();
        var state = separarBairro[1].trim();
        var uf = separarUf[0].trim();

        //Url para fazer a pesquisa do endereço no VIACEP
        let urlViacep = "https://viacep.com.br/ws/" + uf + "/" + state + "/" + address + "/json/";

        fetch(urlViacep)//procurando pela url no browser
        .then(response => response.json())
        .then ( data => {//Se houver dados irá vir para o .then

            //Coletando os dados encontrados em variaveis
            const cep = data[0].cep;
            const endereco = data[0].logradouro;
            const bairro = data[0].bairro;
            const estado = data[0].uf;

            //colocando os inputs dentro de variaveis pelo id
            const cepGps = document.getElementById("cep")
            const address = document.getElementById("address");
            const district = document.getElementById("district");
            const state = document.getElementById("state");
            
            //verificando se os inputs não está vazio
            if(endereco == "" || bairro == "" || estado == ""){
                CreateModal('Error', 'Não foi possível preencher os dados pedidos, tente novamente com outro endereço!');
                return;
            }
            //imprimindo os dados no inputs
            cepGps.value = cep;
            address.value = endereco;
            district.value = bairro;
            state.value = estado;
        })
        .catch(err => {//Se não achar o cep, cairá no modal
            CreateModal('Error', 'Não foi possivel pegar os dados desejados!');
        });

    });
});

