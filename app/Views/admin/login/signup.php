<?= $this->include('admin/partials/main') ?>

<head>
    <?php echo view('admin/partials/title-meta', array('title' => 'Criar conta!')); ?>
    <?= $this->include('admin/partials/head-css') ?>
</head>

<body>
    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>
            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>
        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="/" class="d-inline-block auth-logo">
                                    <img src="/assets/images/logo-light.png" alt="" height="20">
                                </a>
                            </div>
                            <p class="mt-3 fs-15 fw-medium"><?= lang('General.textLogin.description') ?></p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary"><?= lang('General.newAccount.0') ?></h5>
                                    <p class="text-muted"><?= lang('General.newAccount.1') ?></p>
                                </div>
                                <div class="p-2 mt-4">
                                    <?= form_open('', 'class="needs-validation" novalidate action="/"') ?>
                                    
                                    <div class="mb-3">
                                        <label for="useremail" class="form-label"><?= lang('General.inputsLogin.username') ?> <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="username" id="useremail" placeholder="<?= lang('General.inputsLogin.username') ?>" required>
                                        <div class="invalid-feedback">
                                            <?= lang('General.newAccount.errors.0') ?>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="password-input"><?= lang('General.inputsLogin.password') ?></label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input type="password" class="form-control pe-5 password-input" onpaste="return false" placeholder="<?= lang('General.inputsLogin.password') ?>" id="password-input" aria-describedby="passwordInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required name="password">
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            <div class="invalid-feedback">
                                                <?= lang('General.newAccount.errors.1') ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <p class="mb-0 fs-12 text-muted fst-italic"><?= lang('General.newAccount.terms.0') ?> <a href="#" class="text-primary text-decoration-underline fst-normal fw-medium"><?= lang('General.newAccount.terms.1') ?></a></p>
                                    </div>

                                    <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                        <h5 class="fs-13"><?= lang('General.newAccount.errors.2') ?></h5>
                                        <p id="pass-length" class="invalid fs-12 mb-2"><?= lang('General.newAccount.errors.3') ?></p>
                                        <p id="pass-lower" class="invalid fs-12 mb-2"><?= lang('General.newAccount.errors.4') ?></p>
                                        <p id="pass-upper" class="invalid fs-12 mb-2"><?= lang('General.newAccount.errors.5') ?></p>
                                        <p id="pass-number" class="invalid fs-12 mb-0"><?= lang('General.newAccount.errors.6') ?></p>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-secondary w-100" type="submit"><?= lang('General.newAccount.btn') ?></button>
                                    </div>

                                    </form>

                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0"><?= lang('General.newAccount.2') ?> <a href="<?= site_url('login') ?>" class="fw-semibold text-primary text-decoration-underline"> <?= lang('General.newAccount.3') ?> </a> </p>
                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> <?= lang('General.footer.0') ?><i class="mdi mdi-heart text-danger"></i> <?= lang('General.footer.1') ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <?= $this->include('admin/partials/vendor-scripts') ?>

    <!-- particles js -->
    <script src="/assets/libs/particles.js/particles.js"></script>
    <!-- particles app js -->
    <script src="/assets/js/pages/particles.app.js"></script>
    <!-- validation init -->
    <script src="/assets/js/pages/form-validation.init.js"></script>
    <!-- password create init -->
    <script src="/assets/js/pages/passowrd-create.init.js"></script>
</body>

</html>