//máscaras para os inputs cep e phone
$(document).ready( function() {
    $('#cep').mask("99999-999");
});

$(document).ready( function() {
    $('#phone').mask("(99) 99999-9999");
});

//Função oferecida pelo VIACEP para uso externos
function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('cep').value=("");

}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('cep').value=(conteudo.cep);

        if(conteudo.cep == ""){
            CreateModal('Error', 'Não foi possível preencher os dados pedidos, tente novamente com outro endereço!');
            limpa_formulário_cep();
        }
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

        //Cria um elemento javascript.
        var script = document.createElement('script');

        //Sincroniza com o callback.
        script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

        //Insere script no documento e carrega o conteúdo.
        document.body.appendChild(script);

    } //end if.
    else {
        //cep é inválido.
        CreateModal('Error', 'Formato de CEP inválido.');
    }
} //end if.
else {
    //cep sem valor, limpa formulário.
    limpa_formulário_cep();
}
};