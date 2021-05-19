<!-- Corpo do modal

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
                <button type="button" class="btn btn-primary" data-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div> -->

 <!-- Modal -->
 <div class="modal fade" id="modalLogin" role="dialog">
    <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Sem Login</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <p>Se o usúario não estiver logado, o reporte não estará disponável</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Okay</button>
        </div>
    </div>
    
    </div>
</div>

<!-- Modal -->
<!-- <div class="modal fade" id="modalRua" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Endereço</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <form onsubmit = "return false">
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Nome da rua onde o animal está</label>
                    <input type="text" class="form-control" id="modalAddress" name="modalAddress" value="">
                </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" required>Fechar</button>
                <button type="button" class="btn btn-primary"  data-dismiss="modal" id="valueAddress" required>Enviar</button>
            </div>
        </div>
    </div>
</div> -->

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






