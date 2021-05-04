<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Logout</title>
    </head>
    <boby>
<?php
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}
unset($_SESSION['email']);
unset($_SESSION['acc_type']);
session_destroy();
?>
    <script> window.location = ' ../index.php';</script>
    </body>
</html>