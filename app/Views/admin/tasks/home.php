<?= $this->extend('admin/partials/template') ?>

<?= $this->section('content') ?>
<div class="row mb-3 pb-1">
    <div class="col-12">
        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-16 mb-1"><span id="saudacao"></span>, <?= primaryName(session('user')['name']) ?>!</h4>
                <p class="text-muted mb-0">Aqui você verifica as mensagens que foram enviadas e as que estão agendadas.</p>
            </div>
            <div class="mt-3 mt-lg-0">
                <!--end col-->
                <div class="col-auto">
                    <button type="button" class="btn btn-soft-success" id="updateTables"><i class="ri-restart-line align-middle me-1"></i> Atualizar tabelas</button>
                </div>
                <!--end col-->
            </div>
        </div><!-- end card header -->
    </div>
    <!--end col-->
</div>
<!--end row-->

<?= $this->include('admin/tasks/cards/agends') ?>

<?= $this->endSection() ?>