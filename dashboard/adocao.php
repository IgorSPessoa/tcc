<?php 
session_start();

if(!isset($_SESSION['id']) || $_SESSION['acc_type'] != "ong"){
    header("Location: ../login.php?msg=need_login");
    die("Login needed!");
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Panel</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/reports.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
</head>
<body>
    <?php include "include/sidenav.php"; ?>
    <main>
        <div class="container_title">
            <div>
                <h2>Animal para adoção</h2>
                <p>Verifique seus animais públicos para adoção aqui</p>    
            </div>
            <div> 
                <button type="button" class="btn btn-success" onclick="window.location='adoacao_add.php';">Adicionar novo</button>
            </div>        
        </div>

        <table class="table table-striped" id="reports_table">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Stats</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>


                <?php 
                    include "../connect.php";

                    $ong_id = $_SESSION['id'];
                    $dados = $mysql->query("select id, name, description FROM animal_adoption where ong_id = $ong_id;"); 

                    while($linha = mysqli_fetch_array($dados)){
                        echo "<tr>
                                <td>$linha[1]</td>
                                <td>$linha[2]</td>
                                <td>Aguardando adoção</td>
                                <td>
                                    <button type='button' class='btn btn-primary' onclick='window.location=\"adocao_view.php?id=$linha[0]\";'>Editar</button>
                                </td>
                            </tr>";
                    }

                ?>
            </tbody>
        </table>
    </main>
</body>
</html>