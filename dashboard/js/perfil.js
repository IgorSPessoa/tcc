//Função para interação com a icon de upload
function clickInput(id){
    document.getElementById(id).click();
}

//Função oferecida pelo VIACEP para uso externos
function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('address').value=("");
    document.getElementById('number').value=("");
    document.getElementById('district').value=("");
    document.getElementById('state').value=("");
}

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

//máscaras para os inputs cep e phone
$(document).ready( function() {
    $('#cep').mask("99999-999");
});

$(document).ready( function() {
    $('#phone').mask("(99) 99999-9999");
});

$(document).ready( function() {
    $('#whatsapp').mask("(99) 99999-9999");
});

//pegando a localização do ong e importando no mapa
const chave = "AIzaSyChFNJMuEdWzbDHzz1GskqtstVDLe9dcIo";
let url = `https://maps.googleapis.com/maps/api/geocode/json?address=${address}&key=${chave}`;

fetch(url)
.then(response => response.json())
.then( data => {
    let latLocation = data.results[0].geometry.location.lat;
    let lngLocation = data.results[0].geometry.location.lng;
    const LatLng = {lat: latLocation, lng: lngLocation};
    
    map = new google.maps.Map(document.getElementById('map'),{
        center: {lat: latLocation, lng: lngLocation},
        zoom: 18      
        });
    
        new google.maps.Marker({
        position: LatLng,
        map,
        title: "A ONG está aqui!",
    });
})
.catch(err => {
    CreateModal('Error', 'Houve algum problema em localizar o local desejado, tente novamente');
});
    