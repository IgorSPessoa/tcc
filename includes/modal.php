<!-- Corpo do modal -->
<div class="modal" id="modalID" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" id="modalHeader">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="modalBody">
                <p>Text Here</p>
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
            echo "<script>CreateModal('Atualização', 'Conta criada com sucesso!');</script>";

        } elseif($result == "sucess_adoption"){
            echo "<script>CreateModal('Atualização', 'Adoção criada com sucesso!');</script>";

        } elseif($result == "sucess_perfil"){
            echo "<script>CreateModal('Atualização', 'Perfil alterado com sucesso!');</script>";

        } elseif($result == "sucess_login"){
            $name = $_COOKIE['nome'];
            echo "<script>CreateModal('Logado com sucesso', 'Bem vindo(a), $name!');</script>";

        } elseif($result == "sucess_report"){
            echo "<script>CreateModal('Atualização', 'Report feito com sucesso!');</script>";

        } elseif($result == "sucess_acceptedReport"){
            $nameOng = $_COOKIE['name'];
            echo "<script>CreateModal('Atualização', 'Report vinculado a ONG " . $nameOng ." com sucesso!');</script>";

        } elseif($result == "sucess_unlinkReport"){
            $nameOng = $_COOKIE['name'];
            echo "<script>CreateModal('Atualização', 'Report desvinculado a ONG " . $nameOng ." com sucesso!');</script>";

        } elseif($result == "sucess_updateAdoption"){
            echo "<script>CreateModal('Atualização', 'Adoção alterada com sucesso!');</script>";
        } elseif($result == "sucess_updateReport"){
            echo "<script>CreateModal('Atualização', 'Report alterada com sucesso!');</script>";
        //INVALID
        } elseif($result == "invalid_login"){
            echo "<script>CreateModal('Aviso', 'A conta não foi achada, tente novamente!');</script>";

        } elseif($result == "invalid_login_pwd"){
            echo "<script>CreateModal('Aviso', 'A senha está incorreta, tente novamente!');</script>";

        } elseif($result == "invalid_create_pwd"){
            echo "<script>CreateModal('Aviso', 'As senhas não coincidem, tente novamente!');</script>";

        } elseif($result == "invalid_email"){
            echo "<script>CreateModal('Aviso', 'O email colocado já está em uso, tente novamente!');</script>";
        } elseif($result == "invalid_size_animal"){
            $animalSize = $_COOKIE['size'];
            echo "<script>CreateModal('Aviso', 'Foto muito grande, o tamanho máximo da foto é 10MB. Tamanho da foto do animal: " . $animalSize . "Kb');</script>";

        } elseif($result == "invalid_size_location"){
            $locationSize = $_COOKIE['size'];
            echo "<script>CreateModal('Aviso', 'Foto muito grande, o tamanho máximo da foto é 10MB. Tamanho da foto do local: " . $locationSize . "Kb');</script>";
        
        } elseif($result == "invalid_size_logo"){
            $logoSize = $_COOKIE['size'];
            echo "<script>CreateModal('Aviso', 'Logo muito grande, o tamanho máximo da logo é 10MB. Tamanho da foto do logo: " . $logoSize . "Kb');</script>";

        } elseif($result == "invalid_field"){
            echo "<script>CreateModal('Aviso', 'Algum campo não está preenchido, tente novamente!');</script>";   
        //ERROR
        } elseif($result == "error_report"){
            echo "<script>CreateModal('Erro', 'Algo deu errado ao criar o report, tente novamente!');</script>";

        } elseif($result == "errorLoginReport"){
            echo "<script>CreateModal('Erro - Sem Login', 'Se o usúario não estiver logado, o reporte não estará disponível');</script>";

        } elseif($result == "error_create"){
            echo "<script>CreateModal('Erro', 'Algo deu errado ao criar a conta, tente novamente!');</script>";

        } elseif($result == "error_perfil"){
            echo "<script>CreateModal('Erro ', 'Algo deu errado ao alterar o perfil, tente novamente!');</script>";

        } elseif($result == "error_acceptedReport"){
            echo "<script>CreateModal('Erro ', 'Algo deu errado ao vincular com o reporte, tente novamente!');</script>";

        } elseif($result == "error_unlinkReport"){
            echo "<script>CreateModal('Erro ', 'Algo deu errado ao desvincular o reporte, tente novamente!');</script>";

        } elseif($result == "error_updateAdoption"){
            echo "<script>CreateModal('Erro ', 'Algo deu errado ao alterar a adoção, tente novamente!');</script>";
        } elseif($result == "error_updateReport"){
            echo "<script>CreateModal('Erro ', 'Algo deu errado ao alterar o report, tente novamente!');</script>";
        }
    }
?>

