//Função para interação com a icon de upload
function clickInput(id) {
    document.getElementById(id).click();
}

//variavel para mostra a prévia da imagem quando for upada
var loadFile = function (event) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById('logo_upload');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};

//pegando a localização do animal e importando no mapa
const chave = "YOUR_APIKEY";
let url = `https://maps.googleapis.com/maps/api/geocode/json?address=${address}&key=${chave}`;

//verificando se a busca na API está voltando resultados 
fetch(url)
    .then(response => response.json())//Colocando ela em um formato json
    .then(data => {//pegando os valores retornados em 'data' 
        //colocando os valores em variaveis
        let latLocation = data.results[0].geometry.location.lat;
        let lngLocation = data.results[0].geometry.location.lng;
        const LatLng = { lat: latLocation, lng: lngLocation };

        //montando o mapa de acordo com as cordernadas
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: latLocation, lng: lngLocation },
            zoom: 18
        });

        //mmarcando o ponto encotrando nas cordenadas
        new google.maps.Marker({
            position: LatLng,
            map,
            title: "O animal está aqui!",
        });
    })
    .catch(err => {//caso dê algum erro, irá criar um modal alertando
        CreateModal('Error', 'Houve algum problema em localizar o local desejado, tente novamente');
    });

/*  Método: --
    Parâmetros: [ -- ]
    Objetivo: Verificando se o resultado for igual a 'rescued' a frase estará disponível. 
*/
$('#reason').change(function() {
    var valor = ($(this).val());
    if (valor == 'rescued') {
        document.getElementById("mensagem").style.display = "block";
        $("#animal_upload").prop('required', true);
    } else {
        document.getElementById("mensagem").style.display = "none";
        $("#animal_upload").prop('required', false);
    }
});