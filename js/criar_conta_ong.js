//Máscara do inputs cep e telefone
$(document).ready( function() {
    $('#phone').mask("(99) 99999-9999");
});
$(document).ready( function() {
    $('#ong_cep').mask("99999-999");
});

//Função oferecida pelo VIACEP para uso externos
function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('ong_address').value=("");
    document.getElementById('ong_number').value=("");
    document.getElementById('ong_district').value=("");
    document.getElementById('ong_state').value=("");
}

function meu_callback(conteudo) {
if (!("erro" in conteudo)) {
    //Atualiza os campos com os valores.
    document.getElementById('ong_address').value=(conteudo.logradouro);
    document.getElementById('ong_district').value=(conteudo.bairro);
    document.getElementById('ong_state').value=(conteudo.uf);
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
        document.getElementById('ong_address').value="...";
        document.getElementById('ong_district').value="...";
        document.getElementById('ong_state').value="...";

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

//mask telefone

$(document).ready( function() {
    $('#phone').mask("(99) 99999-9999");
});