<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>   
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
                <p><?php echo $bodyModas;?></p>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Função que chama o modal e define os parametros 
    function CreateModal(title, text){
        $('#modalHeader').html(title);
        $('#modalBody').html(text);
        $('#mainID').modal();
    }
</script>
<?php
    if(!empty($_GET['mensagem'])){
        $result = $_GET['mensagem'];

        $tipo =  $_GET['type'];
        if($result == 'successCreate'){
            echo "<script>CreateModal('Atualização', 'Conta criada com sucesso, o tipo de usuário é: $tipo');</script>";
        }
    }
?>





