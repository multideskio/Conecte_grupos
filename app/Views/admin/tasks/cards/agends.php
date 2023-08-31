<?= $this->section('cssLink') ?>
<!--datatable css-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
<!--datatable responsive css-->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<?= $this->endSection() ?>


<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0 flex-grow-1">
                    Envios pendentes
                </h4>
                <span class="text-info">Você ainda pode cancelar um agendamento</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="enviar" class="display table table-bordered dt-responsive table-striped" style="width:100%">
                        <thead>
                            <th>id</th>
                            <th>Assunto</th>
                            <th>Instância</th>
                            <th>data</th>
                            <th></th>
                        </thead>
                        <tfoot>
                            <th>id</th>
                            <th>Assunto</th>
                            <th>Instância</th>
                            <th>data</th>
                            <th></th>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0 flex-grow-1">
                    Mensagens enviadas
                </h4>
                <span class="text-danger">O sistema armazena até 6 meses ou 50 mil mensagens.</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="enviados" class="display table table-bordered dt-responsive table-striped" style="width:100%">
                        <thead>
                            <th>id</th>
                            <th>Assunto</th>
                            <th>Instância</th>
                            <th>data</th>
                            <th></th>
                        </thead>
                        <tfoot>
                            <th>id</th>
                            <th>Assunto</th>
                            <th>Instância</th>
                            <th>data</th>
                            <th></th>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('admin/tasks/modals/viewMessage') ?>
<?= $this->include('admin/tasks/modals/deleteMessage') ?>

<?= $this->section('js') ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>



<script>
    $(document).ready(function() {
        // Referência para as tabelas
        var enviarTable = $('#enviar').DataTable({
            "ajax": `${baseUrl}api/v1/messages/data/<?= session('user')['company'] ?>/0`
        });

        var enviadosTable = $('#enviados').DataTable({
            "ajax": `${baseUrl}api/v1/messages/data/<?= session('user')['company'] ?>/1`
        });


        // Função para recarregar os dados das tabelas
        function reloadTables() {
            enviarTable.ajax.reload();
            enviadosTable.ajax.reload();
            $('#updateTables').prop('disabled', false); // Abilita o botão

        }

        // Recarregar tabelas a cada 5 minutos
        setInterval(function() {
            reloadTables();
        }, 5 * 60 * 1000); // 5 minutos em milissegundos

        // Recarregar tabelas quando o botão de atualização for clicado
        $('#updateTables').on('click', function() {
            console.log('clique');
            $('#updateTables').prop('disabled', true); // Desabilita o botão
            reloadTables();
        });

        //
        $(document).on('click', '.listFunctions', function() {
            var messageid = $(this).data('messageview');
            if (messageid) {
                messageView(messageid)
            }
            //var messageEdit = $(this).data('messageEdit');
            var messageDel = $(this).data('messagedel');

            if (messageDel) {
                deleteMessage(messageDel)
            }

            //console.log(messageid);
            //console.log(messageEdit);
            //console.log(messageEdit);
        })



    });


    function messageView(id) {
        $.getJSON(`${baseUrl}api/v1/messages/${id}`,
            function(data, textStatus, jqXHR) {
                $("#messageTitleView").text(data.name)
                $("#messageMessageView").text(data.message)
                $("#messageArchiveView").text(data.archive)
                $("#messageDestineView").text(data.senders)
                $("#messageDateView").text(data.created_at)
                $("#messageDateSendView").text(data.start)
                $("#modalViewMessage").modal('show');
                console.log(data.id)
            }
        );
    }

    function deleteMessage() {
        $("#modalDeleteMessage").modal("show");
    }
</script>

<?= $this->endSection() ?>