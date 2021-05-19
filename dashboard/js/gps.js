function getLocation() { //Função chamada pelo botão no reportar.php
    if('geolocation' in navigator){//Saber se o navegador é compátivel com o geolocation
            navigator.geolocation.getCurrentPosition(function(position) {
                var latitude   = position.coords.latitude; //pegando a latitude atual do dispositivo
                var longitude  = position.coords.longitude;//pegando a longitude atual do dispositivo

                const Lat = latitude;
                const Lng = longitude;
                const chave = "AIzaSyChFNJMuEdWzbDHzz1GskqtstVDLe9dcIo"; //chave da API 

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
                    // console.log(urlViacep);

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
                    .catch(err => console.warn("Error VIACEP: " + err.message));
                        
                })
                .catch(err => console.warn("Error API geocoding: " + err.message));
        });
        } else {//Se o dispositivo não tiver suporte cairá no alert
            alert('Sem suporte para este navegador!');
        }
    }
    