
<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="<?= base_url() ?>">
        <img class="navbar-brand-full" src="<?= base_url() ?>assets/logo.png" width="89" height="25" alt="Wedding Organizer Logo">
        <img class="navbar-brand-minimized" src="<?= base_url() ?>assets/img/brand/sygnet.svg" width="30" height="30" alt="Wedding Organizer Logo">
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item px-3">
            <a class="nav-link" href="<?= base_url() ?>Dashboard">Dashboard</a>
        </li>
        <li class="nav-item px-3">
            <a class="nav-link" href="<?= base_url() ?>User">Users</a>
        </li>
        <li class="nav-item px-3">
            <a class="nav-link" href="<?= base_url() ?>Settings">Settings</a>
        </li>
    </ul>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
<!--          <a class="nav-link" data-toggle="dropdown" href="<?= base_url() ?>" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="icon-bell"></i>
            <span class="badge badge-pill badge-danger"></span>
          </a>-->

            <!--          <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header text-center">
                          <strong>Notification</strong>
                        </div>
                        <a class="dropdown-item" href="<?= base_url() ?>">
                          <i class="fa fa-bell-o"></i> Updates
                          <span class="badge badge-info">42</span>
                        </a>
                        <a class="dropdown-item" href="<?= base_url() ?>">
                          <i class="fa fa-envelope-o"></i> Messages
                          <span class="badge badge-success">42</span>
                        </a>
                        <a class="dropdown-item" href="<?= base_url() ?>">
                          <i class="fa fa-tasks"></i> Tasks
                          <span class="badge badge-danger">42</span>
                        </a>
                        <a class="dropdown-item" href="<?= base_url() ?>">
                          <i class="fa fa-comments"></i> Comments
                          <span class="badge badge-warning">42</span>
                        </a>
                      </div>-->
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="<?= base_url() ?>" role="button" aria-haspopup="true" aria-expanded="false">
                <img class="img-avatar" src="<?= base_url() ?>assets/img/avatars/user.jpg" alt="admin@bootstrapmaster.com">
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header text-center">
                    <strong>Account</strong>
                </div>
                <a class="dropdown-item" href="<?= base_url() ?>User/Profil">
                    <i class="fa fa-user"></i> Profile</a>
                <a class="dropdown-item" href="<?= base_url() ?>Logout">
                    <i class="fa fa-lock"></i> Logout</a>
            </div>
        </li>
    </ul>
</header>
<div class="app-body">
    <div class="sidebar">
        <nav class="sidebar-nav">
            <ul class="nav">
                <li class="nav-title">Master</li>

                <?php
                $auth = $this->session->userdata('auth');
                $group = $auth['group'];
                if ($group== 1) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>Company">
                            <i class="nav-icon fa fa-bank"></i> Perusahaan</a>
                    </li>
                    <?php
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>Vendor">
                        <i class="nav-icon fa fa-tasks"></i> Vendor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>User">
                        <i class="nav-icon fa fa-users"></i> User</a>
                </li>
                <li class="nav-title">The Wedding</li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>Wedding">
                        <i class="nav-icon icon-user"></i> Data Wedding</a>
                </li>
            </ul>
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>