$("form").keypress(function(e) {
    //Enter key
    if (e.which == 13) {
        return false;
    }
});

$(document).ready( function (){
    $('#valueAddress').click( function (){
        var address = document.getElementById("modalAddress").value;

        var newAddress = address.split("-");
        var separarBairro =  newAddress[1].split(",");
        var separarUf = newAddress[2].split(",");

        var address = newAddress[0].trim();;
        var district = separarBairro[0].trim();
        var state = separarBairro[1].trim();
        var uf = separarUf[0].trim();

        //Url para fazer a pesquisa do endereço no VIACEP
        let urlViacep = "https://viacep.com.br/ws/" + uf + "/" + state + "/" + address + "/json/";
        console.log(urlViacep);

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

    });
});

