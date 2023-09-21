<?= $this->extend('admin/partials/template') ?>

<?= $this->section('content') ?>

<div class="row mb-3 pb-1">
    <div class="col-12">
        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-16 mb-1"><span id="saudacao"></span>, <?= primaryName(session('user')['name']) ?>!</h4>
            </div>
            <div class="mt-3 mt-lg-0">
                <!--end col-->
                <div class="col-auto">
                    <a href="<?= site_url('dashboard/campaigns/create') ?>" type="button" class="btn btn-info" id="syncButton">
                        <i class="ri-restart-line align-middle me-1"></i> Nova campanha
                    </a>
                </div>
                <!--end col-->
            </div>
        </div><!-- end card header -->
    </div>
    <!--end col-->
</div>
<!--end row-->

<?= $this->include('admin/campaigns/cards/campanhas') ?>
<?= $this->include('admin/campaigns/modals/newCampaigns') ?>

<?= $this->endSection() ?>