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