<?= $this->include('chatwoot/partials/main') ?>

<head>

    <?php echo view('chatwoot/partials/title-meta', array('title' => 'Starter')); ?>

    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

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

                    <?php echo view('chatwoot/partials/page-title', array('pagetitle' => 'Pages', 'title' => 'Teste')); ?>


                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0 flex-grow-1">Deals Status</h4>
                                </div><!-- end card header -->
                                <div class="card-body">
                                    <div class="table-card">
                                        <table id="scroll-home-vertical" class="table table-bordered dt-responsive nowrap align-middle mdl-data-table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="width: 10px;">
                                                        <div class="form-check">
                                                            <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                                        </div>
                                                    </th>
                                                    <th>Nome do grupo</th>
                                                    <th>Criado em</th>
                                                    <th>Admin</th>
                                                    <th>Participantes</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($grupos as $grupo) : ?>
                                                    <tr>
                                                        <td scope="col" style="width: 10px;">
                                                            <div class="form-check">
                                                                <input class="form-check-input fs-15" name="grupo[]" type="checkbox" id="checkAll" value="<?= $grupo['id'] ?>">
                                                            </div>
                                                        </td>
                                                        <td><b><?= $grupo['subject'] ?> <br><?= $grupo['id'] ?></b></td>
                                                        <td><?= date('d/m/Y H:i:s', $grupo['creation']) ?></td>
                                                        <td><?= (isset($grupo['owner'])) ? $grupo['owner'] : '' ?></td>
                                                        <td><span class="badge badge-soft-success p-2"><?= count($grupo['participants']) ?></span></td>
                                                        <td>
                                                            <div class="text-nowrap"></div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody><!-- end tbody -->
                                        </table><!-- end table -->
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                            ENVIAR MENSAGEM
                                        </button>
                                    </div><!-- end table responsive -->
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div>

                    </div>


                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->



            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <?= form_open('api/v1/groups/send', ['id' => 'sendGroups']) ?>
                        <div class="modal-body">
                            <div class="status alert alert-warning" style="display: none;">

                            </div>
                            <textarea class="form-control" name="destino" id="valoresSelecionados" cols="30" rows="2" readonly></textarea>
                            <div class="mt-3">
                                <label for="message">Sua mensagem</label>
                                <textarea name="message" id="message" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                            <div class="mt-3">
                                <label for="mentions">Mencionar</label>
                                <div class="form-check form-switch form-switch-lg" dir="ltr">
                                    <input type="checkbox" class="form-check-input" id="mentions" name="mentions" checked="" value="1">
                                    <label class="form-check-label" for="mentions">Mencionar</label>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <?= $this->include('chatwoot/partials/footer') ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <?= $this->include('chatwoot/partials/customizer') ?>

    <?= $this->include('chatwoot/partials/vendor-scripts') ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="/assets/js/pages/datatables.init.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let table = new DataTable('#scroll-home-vertical', {
                "scrollY": "300px",
                "scrollCollapse": true,
                "paging": false
            });

        });


        $(document).ready(function() {
            $(document).ready(function() {
                // Quando houver mudança em qualquer checkbox
                $("input[name='grupo[]']").on("change", function() {
                    // Capturar os valores selecionados dos checkboxes
                    var valoresSelecionados = $("input[name='grupo[]']:checked")
                        .map(function() {
                            return this.value;
                        })
                        .get()
                        .join(", "); // Unir os valores com vírgula e espaço

                    // Atualizar o campo de texto com os valores selecionados
                    $("#valoresSelecionados").val(valoresSelecionados);
                });
            });
        });
    </script>

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