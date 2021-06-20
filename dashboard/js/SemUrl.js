//Usado para limpar parametros da url evitando que sejam repetidas notificações no sistema do modal.php
var SemURL = window.location.href;
SemURL = SemURL.replace(window.location.search, "");

window.history.replaceState({}, document.title, SemURL);