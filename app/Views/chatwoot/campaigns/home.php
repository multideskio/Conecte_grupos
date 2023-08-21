<?= $this->include('chatwoot/partials/main') ?>

<head>

    <?php echo view('chatwoot/partials/title-meta', array('title' => 'Campanhas')); ?>

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
                    <?php echo view('chatwoot/partials/page-title', array('pagetitle' => 'Pages', 'title' => 'Campanhas')); ?>
                    <?php echo view('chatwoot/campaigns/lists/cards') ?>
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?= $this->include('chatwoot/partials/footer') ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <?= $this->include('chatwoot/partials/customizer') ?>

    <?= $this->include('chatwoot/partials/vendor-scripts') ?>


    <script src="https://malsup.github.io/jquery.form.js"></script>

    <script>
        $(document).ready(function() {
            $("#sendGroups").ajaxForm({
                beforeSend: function() {
                    $(".status").html('<div class="spinner-grow text-warning" role="status"><span class="sr-only">Loading...</span></div><br></bt><b>Enviando mensage...</b>').removeClass('alert-success').addClass('alert-warning').show();
                },
                success: function() {
                    $(".status").text("Mensagem enviada!").removeClass('alert-warning').addClass('alert-success')
                },
            })
        })
    </script>


    <!-- App js -->
    <script src="/assets/js/app.js"></script>
</body>

</html>