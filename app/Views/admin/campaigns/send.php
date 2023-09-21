<?= $this->extend('admin/partials/template') ?>



<?= $this->section('content') ?>
<div class="row mb-3 pb-1">
    <div class="col-12">
        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-16 mb-1"><span id="saudacao"></span>, <?= primaryName(session('user')['name']) ?>!</h4>
                <p class="text-muted mb-0">Aqui você envia mensagens sem agendamento.</p>
            </div>
            <div class="mt-3 mt-lg-0">
                <!--end col -->
                <div class="col-auto">
                    <button data-instance="<?= $rowInstance['name'] ?>" type="button" class="btn btn-soft-success sincronizaGrupos" id="syncButton">
                        <i class="ri-restart-line align-middle me-1"></i> Sincronizar grupos
                    </button>
                </div>
                <!--end col-->
            </div>
        </div><!-- end card header -->
    </div>
    <!--end col-->
</div>
<!--end row-->

<div class="row mb-1 pb-1">
    <div class="col-12">
        <!-- Primary Alert -->
        <div class="alert alert-danger alert-dismissible bg-danger text-white alert-label-icon fade show" role="alert">
            <i class="ri-user-smile-line label-icon"></i><strong>Atenção</strong> - Para facilitar, os grupos que você não tem permissão para enviar mensagens, não serão listados.
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>

<?= $this->include('admin/campaigns/cards/send') ?>


<?= $this->endSection() ?>