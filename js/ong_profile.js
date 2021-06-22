/*  Método: --
    Parâmetros: [ address, chave ]
    Objetivo:  pegando a localização do ong e importando no mapa. 
*/

const chave = "YOUR_APIKEY"; //Chave da API do google maps
let url = `https://maps.googleapis.com/maps/api/geocode/json?address=${address}&key=${chave}`;
fetch(url)
.then(response => response.json())
.then( data => {//caso o resultado não dê erro, cairá aqui
    //guardandos os dados desejados em variaveis
    let latLocation = data.results[0].geometry.location.lat;
    let lngLocation = data.results[0].geometry.location.lng;
    const LatLng = {lat: latLocation, lng: lngLocation};
    
    //criando um mapa com os dados oferecidos
    map = new google.maps.Map(document.getElementById('map'),{
        center: {lat: latLocation, lng: lngLocation},
        zoom: 18      
        });
        
        //colocando um marcador no local desejado
        new google.maps.Marker({
        position: LatLng,
        map,
        title: "A ONG está aqui!",
    });
})
.catch(err => {//caso dê erro, criará um modal para o usuário
    CreateModal('Error', 'Houve algum problema em localizar o local desejado, tente novamente');
});

       
  