<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0 flex-grow-1">
                    Lista de participantes
                </h4>
            </div>
            <div class="card-body">
                <table id="listParticipants" class="display table table-bordered dt-responsive table-striped" style="width:100%">
                    <thead>
                        <th>id</th>
                        <th>Grupo</th>
                        <th>Telefone</th>
                    </thead>
                    <tfoot>
                        <th>id</th>
                        <th>Grupo</th>
                        <th>Telefone</th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>


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
        var listParticipants = $('#listParticipants').DataTable({
            "ajax": `${baseUrl}api/v1/datatable/particpants/<?= session('user')['company'] ?>`,
            "buttons": [
                'copy', 'csv', 'excel', 'print', 'pdf'
        ]
        });

    })
</script>

<?= $this->endSection() ?>