/*  Método: nav()
    Parâmetros: [ -- ]
    Objetivo: Função para colocar a sideBar ou o icone de menu dependendo do tamanho da tela 
*/
function nav(){
    var sideBar = document.querySelector("sidebar");
    var menuIcon = document.querySelector(".menu-button");

    console.log(sideBar.style.display);
    if(sideBar.style.display == "none" || sideBar.style.display == ""){
        sideBar.style.display = "block";
        menuIcon.classList.add("activedMenu");
    }else{
        sideBar.style.display = "none";
        menuIcon.classList.remove("activedMenu");
    }
    
}

