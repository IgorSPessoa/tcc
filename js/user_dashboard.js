function loadmap(address, idmap) {
    //pegando a localização do animal e importando no mapa
    $url = `https://maps.googleapis.com/maps/api/geocode/json?address=${address}&key=${chave}`;
    console.log($url)
    fetch($url)
        .then(response => response.json())
        .then(data => {
            let latLocation = data.results[0].geometry.location.lat;
            let lngLocation = data.results[0].geometry.location.lng;
            const LatLng = { lat: latLocation, lng: lngLocation };

            var map2 = document.getElementById('map' + idmap);
            //console.log(map2);
            map = new google.maps.Map(map2, {
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
            console.log("erro")
            //CreateModal('erro', 'Houve algum problema em localizar o local desejado, tente novamente');
        });
}

//Função para interação com a icon de upload
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