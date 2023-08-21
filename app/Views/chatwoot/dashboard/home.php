<?= $this->include('chatwoot/partials/main') ?>

<head>

    <?php echo view('chatwoot/partials/title-meta', array('title' => 'Starter')); ?>

    <?= $this->include('chatwoot/partials/head-css') ?>

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?= $this->include('chatwoot/partials/menu') ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <?php echo view('chatwoot/partials/page-title', array('pagetitle' => 'Pages', 'title' => 'Dashboard')); ?>

                    <div class="col-12">
                        <div class="alert alert-warning">
                            As informações são armazenadas em um banco de dados para gerar estatisticas e melhorar perfomance do sistema.
                        </div>
                    </div>
                    <?php echo view('chatwoot/dashboard/cards/statistics', array()) ?>
                    <?php echo view('chatwoot/dashboard/cards/instances', array()) ?>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?= $this->include('chatwoot/campaigns/modals/new') ?>

            <?= $this->include('chatwoot/partials/footer') ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <?= $this->include('chatwoot/partials/customizer') ?>

    <?= $this->include('chatwoot/partials/vendor-scripts') ?>

    <!-- App js -->
    <script src="/assets/js/app.js"></script>
</body>

</html>