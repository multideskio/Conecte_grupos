<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="/" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="/assets/images/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="/assets/images/logo-dark.png" alt="" height="17">
                        </span>
                    </a>

                    <a href="/" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="/assets/images/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="/assets/images/logo-light.png" alt="" height="17">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>

            <div class="d-flex align-items-center">

                <div class="dropdown ms-1 topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img id="header-lang-img" src="/assets/images/flags/<?php if(session('lang') == 'en'){ echo 'us' ; }else{ echo 'br' ;} ?>.svg" alt="Header Language" height="20" class="rounded">
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <a href="<?= site_url('lang/pt-BR') ?>" class="dropdown-item notify-item language py-2" title="<?= lang('Dashboard.idioma.ptbr') ?>">
                            <img src="/assets/images/flags/br.svg" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle"><?= lang('Dashboard.idioma.ptbr') ?></span>
                        </a>

                        <!-- item-->
                        <a href="<?= site_url('lang/en') ?>" class="dropdown-item notify-item language py-2" title="<?= lang('Dashboard.idioma.en') ?>">
                            <img src="/assets/images/flags/us.svg" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle"><?= lang('Dashboard.idioma.en') ?></span>
                        </a>
                    </div>
                </div>
                
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="<?php if(session('user')['image']){ echo session('user')['image'] ; }else{ $nomeUser = session('user')['name']; echo 'https://placehold.co/60x60/000000/FFF?text='.$nomeUser[0] ;} ?>" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?= session('user')['name'] ?></span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text"><?= character_limiter(session('user')['email'], 5); ?></span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header"><?= lang('Dashboard.menuUser.welcome') ?> <?= primaryName(session('user')['name']) ?>!</h6>
                        <a class="dropdown-item" href="<?= site_url('dashboard/profile') ?>">
                            <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle"><?= lang('Dashboard.menuUser.profile') ?></span>
                        </a>
                        
                        <a class="dropdown-item" href="<?= site_url('dashboard/tasks') ?>">
                            <i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> 
                            <span class="align-middle"><?= lang('Dashboard.menuUser.tasks') ?></span>
                        </a>
                        <a class="dropdown-item" href="<?= site_url('dashboard/help') ?>">
                            <i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> 
                            <span class="align-middle"><?= lang('Dashboard.menuUser.help') ?></span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= site_url('dashboard/plan') ?>">
                            <i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> 
                            <span class="align-middle"><?= lang('Dashboard.menuUser.maturity.0').' '.counted(session('user')['daysRemaining'], lang('Dashboard.menuUser.maturity.2')) ?></span>
                        </a>
                        <a class="dropdown-item" href="<?= site_url('dashboard/config') ?>">
                            <span class="badge bg-soft-success text-success mt-1 float-end">New</span>
                            <i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> 
                            <span class="align-middle"><?= lang('Dashboard.menuUser.settings') ?></span>
                        </a>
                        <a class="dropdown-item" href="<?= site_url('disconnected') ?>">
                            <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> 
                            <span class="align-middle" data-key="t-logout"><?= lang('Dashboard.menuUser.logout') ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- removeNotificationModal -->
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->