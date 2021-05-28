<?php 
//Iniciando sessão
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}
if(isset($_SESSION['email']) == true){
    //Logou, então continua com as validações

}else{//Não logou então volta para a página inicial
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }
    session_unset();
    session_destroy();
    require_once("logout.php");
}

//Concetando com o servidor mysql
include '../../connect.php';

//Declarando os nomes das variáveis pegas no NovaAdocao
$data = "$_POST[date_aceite]";
$proposito = "$_POST[reason]";
$comentarios = "$_POST[comments]";
$id = "$_GET[id]";

//Se houver um novo avatar enviado, delete o antigo e atualize um novo
if($_FILES['arquivo']['name'] != ""){
    //pegando a extensão da imagem
    $separa = explode(".", $_FILES['arquivo']['name']);
    $separa = array_reverse($separa);
    $tipoimg = $separa[0];
    $ext = strtolower("." . $tipoimg);
    
    // Definindo o limite do tamanho do arquivo
    $limite = 10240000; 
    
    //Definindo o tamanho em uma variavel
    $tamanhoImg = $_FILES['arquivo']['size']; 
    
    if($tamanhoImg <= $limite){
        //Verificando se algum campo está vazio
        if($proposito == "" || $comentarios == ""){//Se estiver ele retorna um aviso
            header('Location: ../visualizaReport.php?id=' . $id . '&msg=invalid_field');
        } else { //Se não, continua a operaçãp
                //pegando o nome da imgagem no Banco de dados
            $img = $mysql->prepare("SELECT report_img FROM animal_report WHERE id = $id");
            $img->execute();

            //verificando se existe uma imagem no bd
            if($linha = $img->fetch(PDO::FETCH_ASSOC)){
                $name = $linha['report_img']; //Se existir vai entrar na variavel $name
            }
            if($name != 'preview.jpg'){
                if(file_exists("../../imgsUpdate/$name")) { //verificando se ela existe no diretorio
                    unlink("../../imgsUpdate/$name"); //Tirando a imgagem do diretorio
                } 
            }
            
            //diretorio
            $uploaddir = "../../imgsUpdate/";

            //definindo onovo nome da imagem como tempo e nome da ong    
            $nameImg = time() . $id . md5($data) . $ext;

            move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploaddir . $nameImg);

            $sql = "UPDATE animal_report SET report_situation = ?, report_comments = ?, report_img = ? WHERE id = ?";
            $stmt = $mysql->prepare($sql);

            $stmt->execute([$proposito, $comentarios, $nameImg, $id]);
            
            if($stmt){
                header('Location: ../visualizaReport.php?id=' . $id . '&msg=sucess_updateReport');
            }else{
                header('Location: ../visualizaReport.php?id=' . $id . '&msg=error_updateReport');
            }
        }
    } else {
        header('Location: ../visualizaReport.php?id=' . $id . '&msg=invalid_size_animal&size=' . $tamanhoImg . '');
    }  
} elseif($_FILES['arquivo']['error'] == '4'){
    //Verificando se algum campo está vazio
    if($proposito == "" || $comentarios == ""){//Se estiver ele retorna um aviso
        echo "<script language='javascript' type='text/javascript'>alert('Algum campo está vazio, tente novamente!'); ;</script>";
     } else {//Se não, continua a operação
        $sql = "UPDATE animal_report SET report_situation = ?, report_comments = ? WHERE id = ?";
        $stmt = $mysql->prepare($sql);

        $stmt->execute([$proposito, $comentarios, $id]);
        
        if($stmt){
            header('Location: ../visualizaReport.php?id=' . $id . '&msg=sucess_updateReport');
        }else{
            header('Location: ../visualizaReport.php?id=' . $id . '&msg=error_updateReport');
        }
     }
}


?>
