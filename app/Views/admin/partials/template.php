<?= $this->include('admin/partials/main') ?>

<head>

    <?php echo view('admin/partials/title-meta', array('title' => $title)); ?>
    <?= $this->renderSection('cssLink') ?>

    <?= $this->include('admin/partials/head-css') ?>
    <?= $this->renderSection('css') ?>
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?= $this->include('admin/partials/menu') ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <?php echo view('admin/partials/page-title', array('pagetitle' => 'Dashboard', 'title' => $title)); ?>
                    <!-- <div class="text-center mb-2">
                        <a href="https://multidesk.io/" target="_blank">
                            <img src="https://cdn.multidesk.io/admin/MULTI-ATENDIMENTO.gif" class="img-fluid rounded" alt="" width="600px">
                        </a>
                    </div> -->
                    <?= $this->renderSection('content') ?>
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <?= $this->include('admin/partials/footer') ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
    <script>
        var baseUrl = "<?= site_url() ?>";
    </script>
    <?= $this->include('admin/partials/customizer') ?>
    <?= $this->include('admin/partials/vendor-scripts') ?>
    <?= $this->renderSection('js') ?>
    <!-- App js -->

    <script src="/assets/js/app.js"></script>

    <script>
        // Obtém a hora atual do usuário
        var horaAtual = new Date().getHours();

        // Define as mensagens de saudação
        var saudacao = '';
        if (horaAtual >= 5 && horaAtual < 12) {
            saudacao = 'Bom dia';
        } else if (horaAtual >= 12 && horaAtual < 18) {
            saudacao = 'Boa tarde';
        } else {
            saudacao = 'Boa noite';
        }

        // Exibe a saudação na página
        var saudacaoElement = document.getElementById('saudacao'); // Substitua 'saudacao' pelo ID do elemento onde você quer mostrar a saudação
        saudacaoElement.textContent = saudacao;
    </script>


    <?= $this->renderSection('javascript') ?>
</body>

</html>