<!-- Sidebar -->
<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <img src="<?= base_url('assets/sicepat_putih.svg') ?>" alt="Logo">
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Main Menu</li>
                <li class="sidebar-item">
                    <a href="<?= base_url('/home') ?>" class="sidebar-link">
                        <i data-feather="home" width="20"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?= base_url('/admin') ?>" class="sidebar-link">
                        <i data-feather="user" width="20"></i>
                        <span>Admin</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?= base_url('/kurir') ?>" class="sidebar-link">
                        <i data-feather="truck" width="20"></i>
                        <span>Kurir</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?= base_url('/pengantaran') ?>" class="sidebar-link">
                        <i data-feather="package" width="20"></i>
                        <span>Pengantaran</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?= base_url('/bukti') ?>" class="sidebar-link">
                        <i data-feather="file-text" width="20"></i>
                        <span>Bukti</span>
                    </a>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>

<!-- JavaScript -->
<script src="<?= base_url('assets/js/feather-icons/feather.min.js') ?>"></script>
<script>
    feather.replace()
</script>
