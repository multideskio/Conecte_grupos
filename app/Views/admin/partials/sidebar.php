<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="/" class="logo logo-dark">
            <span class="logo-sm">
                <img src="/assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="/assets/images/logo-dark.png" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="/" class="logo logo-light">
            <span class="logo-sm">
                <img src="/assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="/assets/images/logo-light.png" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?= site_url('dashboard') ?>" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards"><?= lang('Menu.dashboard') ?></span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?= site_url('dashboard/campaigns') ?>" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-group-line"></i> <span ><?= lang('Menu.campaigns') ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?= site_url('dashboard/instances') ?>" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-smartphone-line"></i> <span ><?= lang('Menu.instances') ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?= site_url('dashboard/files') ?>" role="button" aria-expanded="false" aria-controls="sidebarApps">
                    <i class="ri-file-line"></i> <span ><?= lang('Menu.files') ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?= site_url('dashboard/tasks') ?>" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-task-line"></i> <span ><?= lang('Menu.tasks') ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?= site_url('dashboard/leads') ?>" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-space-ship-line"></i> <span ><?= lang('Menu.leads') ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?= site_url('dashboard/participants') ?>" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-space-ship-line"></i> <span ><?= lang('Menu.participants') ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?= site_url('dashboard/synchronize') ?>" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-restart-line"></i> <span ><?= lang('Menu.sicronization') ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?= site_url('dashboard/support') ?>" role="button" aria-expanded="false" aria-controls="sidebarApps">
                    <i class="ri-chat-3-line"></i><span ><?= lang('Menu.support') ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?= site_url('dashboard/help') ?>" role="button" aria-expanded="false" aria-controls="sidebarApps">
                    <i class="ri-questionnaire-line"></i> <span ><?= lang('Menu.help') ?></span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>