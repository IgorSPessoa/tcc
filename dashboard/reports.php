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
        <h2>Reports</h2>
        <p>Verifique reports de animais em situação de risco aqui</p>
        <table class="table table-striped" id="reports_table">
            <thead>
                <tr>
                    <th scope="col">Autor</th>
                    <th scope="col">Endereço</th>
                    <th scope="col">Situação</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>


                <?php 
                    include "../connect.php";

                    $dados = $mysql->query("SELECT id, author_name, localization_lastview, animal_situation FROM animal_report;"); 

                    while($linha = mysqli_fetch_array($dados)){
                        echo "<tr>
                                <td>$linha[1]</td>
                                <td>$linha[2]</td>
                                <td>$linha[3]</td>
                                <td>
                                    <button type='button' class='btn btn-primary' onclick='window.location=\"report_view.php?id=$linha[0]\";'>Visualizar</button>
                                </td>
                            </tr>";
                    }

                ?>
            </tbody>
        </table>
    </main>
</body>
</html>