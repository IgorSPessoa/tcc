/*  Método: --
    Parâmetros: [ -- ]
    Objetivo: Função para interação com a icon de upload. 
*/
function click_the_button(botao){
    botao.click();
}

//variavel para mostra a prévia da imagem quando for upada
var loadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('animalView');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};

