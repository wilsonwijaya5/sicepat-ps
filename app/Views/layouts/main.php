<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sicepat Admin Dashboard</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.svg') ?>" type="image/x-icon">
</head>
<body>
    <div id="app">
         <!-- Navbar -->
         <?= $this->include('partials/navbar') ?>
        <!-- Main Content -->
        <div id="main">
            <nav class="navbar navbar-header navbar-expand navbar-light">
                <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
                <!-- Navbar content -->
            </nav>

            <div class="main-content container-fluid">
                <?= $this->renderSection('content') ?>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-left">
                        <p>2024 &copy; Sicepat Payung Sekaki</p>
                    </div>
                   
                </div>
            </footer>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="<?= base_url('assets/js/feather-icons/feather.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
    <script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>
</html>
