<?= $this->extend('admin/partials/template') ?>
<?= $this->section('content') ?>
<div class="row mb-3 pb-1">
    <div class="col-12">
        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-16 mb-1"><span id="saudacao"></span>, <?= primaryName(session('user')['name']) ?>!</h4>
            </div>
        </div><!-- end card header -->
    </div>
    <!--end col-->
</div>
<!--end row-->
<?= $this->include('admin/campaigns/forms/create') ?>

<?= $this->endSection() ?>