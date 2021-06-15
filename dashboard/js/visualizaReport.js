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
const chave = "AIzaSyChFNJMuEdWzbDHzz1GskqtstVDLe9dcIo";
let url = `https://maps.googleapis.com/maps/api/geocode/json?address=${address}&key=${chave}`;

fetch(url)
    .then(response => response.json())
    .then(data => {
        let latLocation = data.results[0].geometry.location.lat;
        let lngLocation = data.results[0].geometry.location.lng;
        const LatLng = { lat: latLocation, lng: lngLocation };

        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: latLocation, lng: lngLocation },
            zoom: 18
        });

        new google.maps.Marker({
            position: LatLng,
            map,
            title: "O animal está aqui!",
        });
    })
    .catch(err => {
        CreateModal('Error', 'Houve algum problema em localizar o local desejado, tente novamente');
    });
