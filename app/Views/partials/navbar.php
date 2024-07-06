<!-- Sidebar -->
<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <img src="<?= base_url('assets/images/logo.svg') ?>" alt="Logo">
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Main Menu</li>
                <li class="sidebar-item">
                    <a href="<?= base_url('/home') ?>" class="sidebar-link">
                        <i data-feather="home" width="20"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="<?= base_url('/admin') ?>" class="sidebar-link">
                        <i data-feather="home" width="20"></i>
                        <span>Admin</span>
                    </a>
                    <a href="<?= base_url('/kurir') ?>" class="sidebar-link">
                        <i data-feather="home" width="20"></i>
                        <span>Kurir</span>
                    </a>
                    <a href="<?= base_url('/pengantaran') ?>" class="sidebar-link">
                        <i data-feather="home" width="20"></i>
                        <span>Pengantaran</span>
                    </a>
                    <a href="<?= base_url('/bukti') ?>" class="sidebar-link">
                        <i data-feather="home" width="20"></i>
                        <span>Bukti</span>
                    </a>
                </li>
                <!-- Menu items continue -->
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>