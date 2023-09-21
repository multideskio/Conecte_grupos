<?= $this->section('cssLink') ?>
<!--datatable css-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
<!--datatable responsive css-->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<?= $this->endSection() ?>



<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="listGroups" class="display table table-bordered dt-responsive table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Nome/Numero</th>
                        <th scope="col">Grupo</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Nome/Numero</th>
                        <th scope="col">Grupo</th>
                        <th scope="col">Status</th>
                    </tr>
                </tfoot>
            </table>
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
        var listGroups = $('#listGroups').DataTable({
            "ajax": `${baseUrl}api/v1/datatable/logs/<?= session('user')['company'] ?>`
        });

    })
</script>

<?= $this->endSection() ?>