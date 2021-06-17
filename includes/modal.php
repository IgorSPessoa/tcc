<!-- Corpo do modal -->
<div class="modal" id="modalID" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-start" id="modalHeader">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="modalBody">
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Função que chama o modal e define os parametros 
    function CreateModal(title, text){
        $('#modalHeader').html(title);
        $('#modalBody').html(text);
        $('#modalID').modal();
    }
</script>

<?php
    if(!empty($_COOKIE['msg'])){//verficando se a variavel está vazia
        //pegando a mensagem via Cookie
        $result = $_COOKIE['msg'];

        //SUCESS
        if($result == 'sucess_create'){
            echo "<script>CreateModal('<i class=\"pt-1 pr-1 fas fa-check-circle\"></i> Sucesso', 'Conta criada com êxito!');</script>";

        } elseif($result == "sucess_adoption"){
            echo "<script>CreateModal('<i class=\"pt-1 pr-1 fas fa-check-circle\"></i> Sucesso', 'Adoção criada com êxito!');</script>";

        } elseif($result == "sucess_perfil"){
            echo "<script>CreateModal('<i class=\"pt-1 pr-1 fas fa-check-circle\"></i> Atualização', 'Perfil alterado com sucesso!');</script>";

        } elseif($result == "sucess_login"){
            $name = $_COOKIE['nome'];
            $nameAlterado = str_replace("'", "", $name);
            echo "<script>CreateModal('<i class=\"pt-1 pr-1 fas fa-check-circle\"></i> Logado com sucesso', 'Bem vindo(a), $nameAlterado!');</script>";

        } elseif($result == "sucess_report"){
            echo "<script>CreateModal('<i class=\"pt-1 pr-1 fas fa-check-circle\"></i> Sucesso', 'Report feito com êxito!');</script>";

        } elseif($result == "sucess_acceptedReport"){
            $nameOng = $_COOKIE['name'];
            echo "<script>CreateModal('<i class=\"pt-1 pr-1 fas fa-check-circle\"></i> Sucesso', 'Report vinculado a ONG " . $nameOng ." com êxito!');</script>";

        } elseif($result == "sucess_unlinkReport"){
            $nameOng = $_COOKIE['name'];
            echo "<script>CreateModal('<i class=\"pt-1 pr-1 fas fa-check-circle\"></i> Sucesso', 'Report desvinculado a ONG " . $nameOng ." com êxito!');</script>";

        } elseif($result == "sucess_updateAdoption"){
            echo "<script>CreateModal('<i class=\"pt-1 pr-1 fas fa-check-circle\"></i> Atualização', 'A Adoção foi alterada com êxito!');</script>";

        } elseif($result == "sucess_updateReport"){
            echo "<script>CreateModal('<i class=\"pt-1 pr-1 fas fa-check-circle\"></i> Atualização', 'O report foi atualizado com êxito!');</script>";
            
        //INVALID
        } elseif($result == "invalid_login"){
            echo "<script>CreateModal('<i class=\"pt-1 pr-1 fas fa-exclamation-triangle\"></i> Aviso', 'A conta não foi achada, tente novamente!');</script>";

        } elseif($result == "invalid_login_pwd"){
            echo "<script>CreateModal('<i class=\"pt-1 pr-1 fas fa-exclamation-triangle\"></i> Aviso', 'A senha está incorreta, tente novamente!');</script>";

        } elseif($result == "invalid_create_pwd"){
            echo "<script>CreateModal('<i class=\"pt-1 pr-1 fas fa-exclamation-triangle\"></i> Aviso', 'As senhas não coincidem, tente novamente!');</script>";

        } elseif($result == "invalid_email"){
            echo "<script>CreateModal('<i class=\"pt-1 pr-1 fas fa-exclamation-triangle\"></i> Aviso', 'O email colocado já está em uso, tente novamente!');</script>";
        } elseif($result == "invalid_size_animal"){
            $animalSize = $_COOKIE['size'];
            echo "<script>CreateModal('<i class=\"pt-1 pr-1 fas fa-exclamation-triangle\"></i> Aviso', 'Foto muito grande, o tamanho máximo da foto é 10MB. Tamanho da foto do animal: " . $animalSize . "Kb');</script>";

        } elseif($result == "invalid_size_location"){
            $locationSize = $_COOKIE['size'];
            echo "<script>CreateModal('<i class=\"pt-1 pr-1 fas fa-exclamation-triangle\"></i> Aviso', 'Foto muito grande, o tamanho máximo da foto é 10MB. Tamanho da foto do local: " . $locationSize . "Kb');</script>";
        
        } elseif($result == "invalid_size_logo"){
            $logoSize = $_COOKIE['size'];
            echo "<script>CreateModal('<i class=\"pt-1 pr-1 fas fa-exclamation-triangle\"></i> Aviso', 'Logo muito grande, o tamanho máximo da logo é 10MB. Tamanho da foto do logo: " . $logoSize . "Kb');</script>";
        } elseif($result == "invalid_size_user"){
            $fotoSize = $_COOKIE['size'];
            echo "<script>CreateModal('<i class=\"pt-1 pr-1 fas fa-exclamation-triangle\"></i> Aviso', 'Foto muito grande, o tamanho máximo da Foto é 10MB. Tamanho da foto do logo: " . $fotoSize . "Kb');</script>";

        } elseif($result == "invalid_field"){
            echo "<script>CreateModal('<i class=\" pt-1 pr-1 fas fa-times\"></i> <i class=\"pt-1 pr-1 fas fa-exclamation-triangle\"></i> Aviso', 'Algum campo não está preenchido, tente novamente!');</script>";
             
        //ERROR
        } elseif($result == "error_report"){
            echo "<script>CreateModal('<i class=\" pt-1 pr-1 fas fa-times\"></i> Erro', 'Algo deu errado ao criar o report, tente novamente!');</script>";

        } elseif($result == "errorLoginReport"){
            echo "<script>CreateModal('<i class=\" pt-1 pr-1 fas fa-times\"></i> Erro - Sem Login', 'Se o usúario não estiver logado, o reporte não estará disponível');</script>";

        } elseif($result == "error_create"){
            echo "<script>CreateModal('<i class=\" pt-1 pr-1 fas fa-times\"></i> Erro', 'Algo deu errado ao criar a conta, tente novamente!');</script>";

        } elseif($result == "error_perfil"){
            echo "<script>CreateModal('<i class=\" pt-1 pr-1 fas fa-times\"></i> Erro ', 'Algo deu errado ao alterar o perfil, tente novamente!');</script>";

        } elseif($result == "error_acceptedReport"){
            echo "<script>CreateModal('<i class=\" pt-1 pr-1 fas fa-times\"></i> Erro ', 'Algo deu errado ao vincular com o reporte, tente novamente!');</script>";

        } elseif($result == "error_unlinkReport"){
            echo "<script>CreateModal('<i class=\" pt-1 pr-1 fas fa-times\"></i> Erro ', 'Algo deu errado ao desvincular o reporte, tente novamente!');</script>";

        } elseif($result == "error_updateAdoption"){
            echo "<script>CreateModal('<i class=\" pt-1 pr-1 fas fa-times\"></i> Erro ', 'Algo deu errado ao alterar a adoção, tente novamente!');</script>";
            
        } elseif($result == "error_updateReport"){
            echo "<script>CreateModal('<i class=\" pt-1 pr-1 fas fa-times\"></i> Erro ', 'Algo deu errado ao alterar o report, tente novamente!');</script>";

        } elseif($result == "error_information"){
            echo "<script>CreateModal(' <i class=\" pt-1 pr-1 fas fa-times\"></i> Erro', 'Nenhuma informação encontrada para a requisição, tente novamente!');</script>"; 

        }
    }
?>

