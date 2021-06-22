/*  Método: --
    Parâmetros: [ -- ]
    Objetivo: Função para interação com a icon de upload. 
*/
function clickInput(id){
    document.getElementById(id).click();
}

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
        return
    }
} //end if.
else {
    //cep sem valor, limpa formulário.
    limpa_formulário_cep();
}
};

//variavel para mostra a prévia da imagem quando for upada
var loadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('logo_upload');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };

/*  Método: --
    Parâmetros: [ -- ]
    Objetivo:  Mostrar os inputs abaixo com uma mascará do jquery. 
*/
$(document).ready( function() {
    $('#cep').mask("99999-999");
    $('#phone').mask("(99) 99999-9999");
    $('#whatsapp').mask("(99) 99999-9999");
});

//pegando a localização do ong e importando no mapa
const chave = "YOUR_APIKEY";
let url = `https://maps.googleapis.com/maps/api/geocode/json?address=${address}&key=${chave}`;

//verificando se a busca na API está voltando resultados 
fetch(url)
.then(response => response.json())//Colocando ela em um formato json
.then( data => {//pegando os valores retornados em 'data' 
    //colocando os valores em variaveis
    let latLocation = data.results[0].geometry.location.lat;
    let lngLocation = data.results[0].geometry.location.lng;
    const LatLng = {lat: latLocation, lng: lngLocation};
    
    //montando o mapa de acordo com as cordernadas
    map = new google.maps.Map(document.getElementById('map'),{
        center: {lat: latLocation, lng: lngLocation},
        zoom: 18      
        });
        
        //mmarcando o ponto encotrando nas cordenadas
        new google.maps.Marker({
        position: LatLng,
        map,
        title: "A ONG está aqui!",
    });
})
.catch(err => {//caso dê algum erro, irá criar um modal alertando
    CreateModal('Error', 'Houve algum problema em localizar o local desejado, tente novamente');
});
    