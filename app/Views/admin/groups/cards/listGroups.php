<?= $this->section('cssLink') ?>
<!--datatable css-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
<!--datatable responsive css-->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<?= $this->endSection() ?>

<div class="row mb-3 pb-1">
    <div class="col-12">
        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-16 mb-1"><span id="saudacao"></span>, <?= primaryName(session('user')['name']) ?>!</h4>
                <p class="text-muted mb-0">Lista de todos os grupos para relacionar ás suas campanhas.</p>
            </div>
            <div class="mt-3 mt-lg-0">
                <!--end col-->
                <div class="col-auto">
                    <button type="button" class="btn btn-soft-success" id="updateTables"><i class="ri-restart-line align-middle me-1"></i> Atualizar tabela</button>
                </div>
                <!--end col-->
            </div>
        </div><!-- end card header -->
    </div>
    <!--end col-->
</div>
<!--end row-->



<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0 flex-grow-1">
                    Lista de grupos
                </h4>
                <span class="text-info">Você ainda pode cancelar um agendamento</span>
            </div>
            <div class="card-body">
                <table id="listGroups" class="display table table-bordered dt-responsive table-striped" style="width:100%">
                    <thead>
                        <th>id</th>
                        <th>Info</th>
                        <th>Criado em</th>
                        <th>Campanhas</th>
                        <th class="text-end">
                            <button class="btn btn-sm btn-primary">
                                <i class="ri-download-line"></i>
                            </button>
                        </th>
                    </thead>
                    <tfoot>
                        <th>id</th>
                        <th>Info</th>
                        <th>Criado em</th>
                        <th>Campanhas</th>
                        <th></th>
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
        var listGroups = $('#listGroups').DataTable({
            "ajax": `${baseUrl}api/v1/datatable/data/<?= session('user')['company'] ?>`
        });

    })
</script>

<?= $this->endSection() ?>