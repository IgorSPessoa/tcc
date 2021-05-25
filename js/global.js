// Usado para limpar parametros da url evitando que sejam repetidas notificações no sistema do modal.php
var url = window.location.href;
url = url.replace(window.location.search, "");

window.history.replaceState({}, document.title, url);