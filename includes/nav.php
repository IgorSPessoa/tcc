<nav class="navbar navbar-expand-lg navbar-dark " style="background-color: #191970;">

    <a class="navbar-brand" href="./index.php">
        <img src="./imgs/CF_1.png" alt="Logo" height="40px">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Início</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ongs.php">ONGs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adocao.php">Adoção</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="reportar.php">Reporta</a>
            </li>
            <li class="nav-item">
                <?php
                // Verifica se está logado
                if(isset($_SESSION['email']) == true){
                    //Logou, então continua com as validações
                    if (isset($_SESSION['acc_type'])) {
                        $name = $_SESSION['name'];
                        $name = explode(" ", $name);
                        $name = $name[0];
                        // Verifica o tipo de conta
                        if ($_SESSION['acc_type'] == "user") {
                            echo "<a class='nav-link'  href='user_dashboard.php'>Conectado ($name)</a>";
                        } else {
                            echo "<a class='nav-link'  href='dashboard/index.php'>Conectado ($name)</a>";
                        }
                    }
                }else{//Não logou então volta para a página inicial
                    if(session_status() !== PHP_SESSION_ACTIVE){
                        session_start();
                    }
                    session_unset();
                    session_destroy();
                    echo "<a class='nav-link' href='login.php'>Conectar-se</a>";
                }
                ?>
            </li>
        </ul>
    </div>
</nav>
